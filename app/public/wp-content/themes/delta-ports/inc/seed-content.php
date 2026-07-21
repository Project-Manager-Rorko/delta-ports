<?php
/**
 * Seeds Gutenberg pages/posts/menus on theme activation.
 * Content is stored in post_content as blocks — fully editable in Block Editor.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once DELTA_PORTS_DIR . '/inc/content-blocks.php';

/**
 * Run seed when theme is switched on.
 */
function delta_ports_on_theme_switch() {
	delta_ports_seed_all( false );
}
add_action( 'after_switch_theme', 'delta_ports_on_theme_switch' );

/**
 * Admin tool: Tools → Delta Ports Seed.
 */
function delta_ports_seed_admin_menu() {
	add_management_page(
		'Delta Ports Seed',
		'Delta Ports Seed',
		'manage_options',
		'delta-ports-seed',
		'delta_ports_seed_admin_page'
	);
}
add_action( 'admin_menu', 'delta_ports_seed_admin_menu' );

/**
 * Admin page UI.
 */
function delta_ports_seed_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$done = false;
	if ( isset( $_POST['delta_ports_seed_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['delta_ports_seed_nonce'] ) ), 'delta_ports_seed' ) ) {
		$force = ! empty( $_POST['force'] );
		delta_ports_seed_all( $force );
		$done = true;
	}
	echo '<div class="wrap"><h1>Delta Ports Content Seed</h1>';
	if ( $done ) {
		echo '<div class="notice notice-success"><p>Seed completed. Pages are editable in the Block Editor.</p></div>';
	}
	echo '<p>Creates/updates all marketing pages as <strong>Gutenberg block content</strong> (not PHP templates).</p>';
	echo '<form method="post">';
	wp_nonce_field( 'delta_ports_seed', 'delta_ports_seed_nonce' );
	echo '<p><label><input type="checkbox" name="force" value="1" /> Force overwrite existing page content</label></p>';
	echo '<p><button type="submit" class="button button-primary">Run Seed</button></p>';
	echo '</form></div>';
}

/**
 * Upsert a page by slug with block content.
 *
 * @param string $slug Slug.
 * @param string $title Title.
 * @param string $content Block markup.
 * @param bool   $force Overwrite content.
 * @return int Page ID.
 */
function delta_ports_upsert_page( $slug, $title, $content, $force = false ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		$update = array(
			'ID'         => $existing->ID,
			'post_title' => $title,
			'post_status'=> 'publish',
			'post_name'  => $slug,
		);
		if ( $force || '' === trim( $existing->post_content ) ) {
			$update['post_content'] = $content;
		}
		wp_update_post( $update );
		return (int) $existing->ID;
	}
	return (int) wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
		)
	);
}

/**
 * Upsert a post by slug.
 *
 * @param string $slug Slug.
 * @param string $title Title.
 * @param string $content Content.
 * @param bool   $force Force.
 * @return int
 */
function delta_ports_upsert_post( $slug, $title, $content, $force = false ) {
	$posts = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => 'post',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $posts ) {
		$id = (int) $posts[0];
		$update = array(
			'ID'         => $id,
			'post_title' => $title,
			'post_status'=> 'publish',
		);
		if ( $force || '' === trim( get_post_field( 'post_content', $id ) ) ) {
			$update['post_content'] = $content;
		}
		wp_update_post( $update );
		return $id;
	}
	return (int) wp_insert_post(
		array(
			'post_type'    => 'post',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
		)
	);
}

/**
 * Apply Yoast meta if plugin active.
 *
 * @param int    $post_id Post ID.
 * @param string $seo_title Title.
 * @param string $seo_desc Description.
 */
function delta_ports_set_yoast_meta( $post_id, $seo_title, $seo_desc ) {
	if ( $seo_title ) {
		update_post_meta( $post_id, '_yoast_wpseo_title', $seo_title );
	}
	if ( $seo_desc ) {
		update_post_meta( $post_id, '_yoast_wpseo_metadesc', $seo_desc );
	}
}

/**
 * Sideload a theme image into the Media Library and set as featured image.
 *
 * @param int    $post_id Post ID.
 * @param string $filename Filename under assets/images.
 * @return int Attachment ID or 0.
 */
function delta_ports_set_post_featured_from_theme( $post_id, $filename ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 || '' === $filename ) {
		return 0;
	}

	// Keep existing featured image if already set.
	if ( has_post_thumbnail( $post_id ) ) {
		return (int) get_post_thumbnail_id( $post_id );
	}

	$path = trailingslashit( DELTA_PORTS_DIR ) . 'assets/images/' . ltrim( $filename, '/\\' );
	if ( ! file_exists( $path ) ) {
		return 0;
	}

	// Reuse attachment if we already imported this file.
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'post_status'    => 'inherit',
			'meta_key'       => '_delta_ports_theme_image',
			'meta_value'     => $filename,
			'fields'         => 'ids',
		)
	);
	if ( $existing ) {
		set_post_thumbnail( $post_id, (int) $existing[0] );
		return (int) $existing[0];
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_bits( basename( $path ), null, file_get_contents( $path ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$filetype   = wp_check_filetype( $upload['file'], null );
	$attachment = array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	$attach_id  = wp_insert_attachment( $attachment, $upload['file'], $post_id );
	if ( is_wp_error( $attach_id ) || ! $attach_id ) {
		return 0;
	}

	$meta = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
	wp_update_attachment_metadata( $attach_id, $meta );
	update_post_meta( $attach_id, '_delta_ports_theme_image', $filename );
	set_post_thumbnail( $post_id, $attach_id );

	return (int) $attach_id;
}

/**
 * Create / return Contact Form 7 talent form ID.
 *
 * @return int
 */
/**
 * Find a CF7 form by exact title.
 *
 * @param string $title Form title.
 * @return int
 */
function delta_ports_find_cf7_by_title( $title ) {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return 0;
	}
	$all = get_posts(
		array(
			'post_type'      => 'wpcf7_contact_form',
			'posts_per_page' => 50,
			'post_status'    => 'publish',
		)
	);
	foreach ( $all as $form_post ) {
		if ( $title === $form_post->post_title ) {
			return (int) $form_post->ID;
		}
	}
	return 0;
}

/**
 * Create/find business enquiry form (mail1 + mail2).
 *
 * @param bool $force_update Force rewrite.
 * @return int
 */
function delta_ports_get_or_create_contact_form( $force_update = true ) {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return 0;
	}

	$props = function_exists( 'delta_ports_business_form_properties' )
		? delta_ports_business_form_properties()
		: array();

	$found = delta_ports_find_cf7_by_title( 'Business Enquiry' );
	if ( ! $found ) {
		$legacy = delta_ports_find_cf7_by_title( 'Contact form 1' );
		if ( $legacy ) {
			$found = $legacy;
		}
	}

	if ( $found ) {
		$cf7 = wpcf7_contact_form( $found );
		if ( $cf7 && $force_update && $props ) {
			if ( 'Business Enquiry' !== $cf7->title() ) {
				$cf7->set_title( 'Business Enquiry' );
			}
			$cf7->set_properties( $props );
			$cf7->save();
		}
		return (int) $cf7->id();
	}

	$form = WPCF7_ContactForm::get_template(
		array(
			'title' => 'Business Enquiry',
		)
	);
	if ( $props ) {
		$form->set_properties( $props );
	}
	return (int) $form->save();
}

/**
 * Talent Network CF7 form properties (layout matches live contact design).
 *
 * @return array
 */
function delta_ports_talent_form_properties() {
	$site_mail = 'info@deltaports.com';
	$form_html = trim(
		'
<div class="dp-cf7-grid">
  <div class="dp-cf7-field">
    <label>Full Name
      [text* full-name autocomplete:name]
    </label>
  </div>
  <div class="dp-cf7-field">
    <label>Email Address
      [email* email autocomplete:email]
    </label>
  </div>
  <div class="dp-cf7-field">
    <label>Mobile Number
      [tel* mobile autocomplete:tel]
    </label>
  </div>
  <div class="dp-cf7-field">
    <label>Business Vertical
      [text business-vertical]
    </label>
  </div>
  <div class="dp-cf7-field">
    <label>Years of Experience
      [text experience]
    </label>
  </div>
  <div class="dp-cf7-field dp-cf7-field--file">
    <label>Upload Resume
      [file resume limit:5mb filetypes:pdf|doc|docx]
    </label>
  </div>
</div>
<div class="dp-cf7-actions">
  [submit "Submit Application"]
</div>
'
	);

	return array(
		'form'  => $form_html,
		// Mail (1): notification to Delta Ports.
		'mail'  => array(
			'subject'            => 'Talent Network application from [full-name]',
			'sender'             => 'Delta Ports <wordpress@' . ( wp_parse_url( home_url(), PHP_URL_HOST ) ?: 'delta-ports.local' ) . '>',
			'body'               => "New Talent Network application\n\nName: [full-name]\nEmail: [email]\nMobile: [mobile]\nBusiness Vertical: [business-vertical]\nYears of Experience: [experience]\n\n--\nSent from the Delta Ports contact page.",
			'recipient'          => $site_mail,
			'additional_headers' => "Reply-To: [email]\nCc: " . get_option( 'admin_email' ),
			'attachments'        => '[resume]',
			'use_html'           => 0,
			'exclude_blank'      => 0,
		),
		// Mail (2): auto-reply to applicant.
		'mail_2' => array(
			'active'             => true,
			'subject'            => 'We received your application — Delta Ports',
			'sender'             => 'Delta Ports <' . $site_mail . '>',
			'body'               => "Hello [full-name],\n\nThank you for applying to the Delta Ports Talent Network. We have received your details and will review your application.\n\nIf your profile matches our current or upcoming opportunities, our team will get in touch.\n\nRegards,\nDelta Ports Talent Team\n" . $site_mail,
			'recipient'          => '[email]',
			'additional_headers' => 'Reply-To: ' . $site_mail,
			'attachments'        => '',
			'use_html'           => 0,
			'exclude_blank'      => 0,
		),
	);
}

/**
 * Create/find talent network form and keep mail1/mail2 synced.
 *
 * @param bool $force_update Force rewrite form fields + mail.
 * @return int
 */
function delta_ports_get_or_create_talent_form( $force_update = true ) {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return 0;
	}

	$props = delta_ports_talent_form_properties();
	$found = delta_ports_find_cf7_by_title( 'Talent Network' );

	if ( $found ) {
		if ( $force_update ) {
			$cf7 = wpcf7_contact_form( $found );
			if ( $cf7 ) {
				$cf7->set_properties( $props );
				$cf7->save();
			}
		}
		return (int) $found;
	}

	$form = WPCF7_ContactForm::get_template(
		array(
			'title' => 'Talent Network',
		)
	);
	$form->set_properties( $props );
	return (int) $form->save();
}

/**
 * Business enquiry form props + mail1 / mail2.
 *
 * @return array
 */
function delta_ports_business_form_properties() {
	$site_mail = 'info@deltaports.com';
	return array(
		'form'   => trim(
			'
<label> Full Name
    [text* your-name] </label>

<label> Email Address
    [email* your-email] </label>

<label> Phone
    [tel your-phone] </label>

<label> Company
    [text your-company] </label>

<label> Subject
    [text* your-subject] </label>

<label> Message
    [textarea* your-message] </label>

[submit "Send Enquiry"]
'
		),
		'mail'   => array(
			'subject'            => 'Business enquiry: [your-subject]',
			'sender'             => 'Delta Ports <wordpress@' . ( wp_parse_url( home_url(), PHP_URL_HOST ) ?: 'delta-ports.local' ) . '>',
			'body'               => "From: [your-name] <[your-email]>\nPhone: [your-phone]\nCompany: [your-company]\nSubject: [your-subject]\n\n[your-message]\n\n--\nDelta Ports contact form.",
			'recipient'          => $site_mail,
			'additional_headers' => "Reply-To: [your-email]\nCc: " . get_option( 'admin_email' ),
			'attachments'        => '',
			'use_html'           => 0,
			'exclude_blank'      => 0,
		),
		'mail_2' => array(
			'active'             => true,
			'subject'            => 'We received your enquiry — Delta Ports',
			'sender'             => 'Delta Ports <' . $site_mail . '>',
			'body'               => "Hello [your-name],\n\nThank you for contacting Delta Ports. We have received your message and will respond shortly.\n\nRegards,\nDelta Ports\n" . $site_mail,
			'recipient'          => '[your-email]',
			'additional_headers' => 'Reply-To: ' . $site_mail,
			'attachments'        => '',
			'use_html'           => 0,
			'exclude_blank'      => 0,
		),
	);
}

/**
 * Seed everything.
 *
 * @param bool $force Overwrite content.
 */
function delta_ports_seed_all( $force = false ) {
	$map = array(
		array(
			'slug'    => 'home-upgrade',
			'title'   => 'Home',
			'content' => delta_ports_content_home(),
			'seo_t'   => 'Delta Ports | Terminal Operations & Port Logistics',
			'seo_d'   => 'Delta Ports provides deep-water terminal infrastructure and port logistics powering India’s maritime trade.',
			'front'   => true,
		),
		array(
			'slug'    => 'about-us',
			'title'   => 'About Us',
			'content' => delta_ports_content_about(),
			'seo_t'   => 'About Delta Ports | Port Terminal Operations India',
			'seo_d'   => 'Learn about Delta Ports — port-led infrastructure and terminal operations across India.',
		),
		array(
			'slug'    => 'leadership',
			'title'   => 'Leadership',
			'content' => delta_ports_content_leadership(),
			'seo_t'   => 'Delta Ports Leadership | Vision & Management Team',
			'seo_d'   => 'Meet the Delta Ports leadership team driving terminal excellence and governance.',
		),
		array(
			'slug'    => 'led-operation-new',
			'title'   => 'Port-Led Operation',
			'content' => delta_ports_content_port_led(),
			'seo_t'   => 'Port-Led Operations | Delta Ports Terminal Services',
			'seo_d'   => 'Integrated terminal operations across India’s strategic maritime gateways.',
		),
		array(
			'slug'    => 'led-operations',
			'title'   => 'Port-Led Operations',
			'content' => delta_ports_content_port_led(),
			'seo_t'   => 'Port-Led Operations | Delta Ports Terminal Services',
			'seo_d'   => 'Terminal network, cargo capabilities, and multimodal port operations.',
		),
		array(
			'slug'    => 'cargo-handling-capabilities',
			'title'   => 'Cargo Handling Capabilities',
			'content' => delta_ports_content_cargo(),
			'seo_t'   => 'Cargo Handling Services | Delta Ports Infrastructure',
			'seo_d'   => 'Cargo handling, yard facilities, equipment, storage, and safety infrastructure.',
		),
		array(
			'slug'    => 'integrated-port-logistics',
			'title'   => 'Integrated Port Logistics',
			'content' => delta_ports_content_logistics(),
			'seo_t'   => 'Integrated Port Logistics | Rail & Road Connectivity',
			'seo_d'   => 'Road and rail connectivity for seamless cargo movement from Delta Ports terminals.',
		),
		array(
			'slug'    => 'sustainability',
			'title'   => 'Sustainability',
			'content' => delta_ports_content_sustainability(),
			'seo_t'   => 'Delta Ports Sustainability | Safe & Responsible Operations',
			'seo_d'   => 'Lower-carbon terminal operations, safety, and environmental compliance at Delta Ports.',
		),
		array(
			'slug'    => 'contact-us',
			'title'   => 'Contact Us',
			'content' => delta_ports_content_contact(),
			'seo_t'   => 'Contact Delta Ports | Mangalore, Bangalore & Dammam',
			'seo_d'   => 'Contact Delta Ports offices or join our talent network.',
		),
		array(
			'slug'    => 'privacy-policy',
			'title'   => 'Privacy Policy',
			'content' => delta_ports_content_privacy(),
			'seo_t'   => 'Privacy Policy - Delta Ports',
			'seo_d'   => 'Privacy policy for the Delta Ports website.',
		),
		array(
			'slug'    => 'terms-conditions',
			'title'   => 'Terms & Conditions',
			'content' => delta_ports_content_terms(),
			'seo_t'   => 'Terms & Conditions - Delta Ports',
			'seo_d'   => 'Terms and conditions for using the Delta Ports website.',
		),
	);

	$front_id = 0;
	foreach ( $map as $page ) {
		$id = delta_ports_upsert_page( $page['slug'], $page['title'], $page['content'], $force );
		delta_ports_set_yoast_meta( $id, $page['seo_t'], $page['seo_d'] );
		if ( ! empty( $page['front'] ) ) {
			$front_id = $id;
		}
	}

	if ( $front_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_id );
	}

	// Media & Updates (posts index) at /media-updates/.
	// Migrate legacy /blog/ slug if present.
	$legacy_blog = get_page_by_path( 'blog' );
	if ( $legacy_blog ) {
		wp_update_post(
			array(
				'ID'         => $legacy_blog->ID,
				'post_name'  => 'media-updates',
				'post_title' => 'Media & Updates',
			)
		);
	}
	$blog_id = delta_ports_upsert_page(
		'media-updates',
		'Media & Updates',
		'<!-- wp:paragraph --><p>Media &amp; updates from Delta Ports and the Group.</p><!-- /wp:paragraph -->',
		$force
	);
	update_option( 'page_for_posts', $blog_id );
	update_option( 'permalink_structure', '/media-updates/%postname%/' );
	delta_ports_set_yoast_meta( $blog_id, 'Media & Updates | Delta Ports', 'Media updates and news from Delta Ports and Group Delta.' );

	// Ensure CF7 forms exist.
	delta_ports_get_or_create_contact_form();
	delta_ports_get_or_create_talent_form();

	// Blog posts (with related images on top via featured image).
	$posts = array(
		array(
			'slug'  => 'acquisition-of-noatum-propels-ad-ports-group',
			'title' => 'Acquisition of Noatum Propels AD Ports Group',
			'body'  => '<!-- wp:paragraph --><p>Industry update on strategic acquisitions shaping global ports and logistics networks.</p><!-- /wp:paragraph -->',
			'seo_t' => 'Acquisition of Noatum Propels AD Ports Group - Delta Ports',
			'seo_d' => 'Media update: Acquisition of Noatum and its impact on global port logistics.',
			'image' => 'media-update1.webp',
		),
		array(
			'slug'  => 'indias-logistics-sector-big-opportunity-for-investors',
			'title' => "India's logistics sector big opportunity for investors",
			'body'  => '<!-- wp:paragraph --><p>India’s logistics sector continues to present significant opportunity for infrastructure and supply-chain investors.</p><!-- /wp:paragraph -->',
			'seo_t' => "India's logistics sector big opportunity for investors - Delta Ports",
			'seo_d' => 'Media update on India’s logistics growth and investment opportunity.',
			'image' => 'media-update2.webp',
		),
		array(
			'slug'  => 'hello-world',
			'title' => 'Home-grown Stevedoring Giant bags big',
			'body'  => '<!-- wp:paragraph --><p>Coverage of home-grown stevedoring leadership and operational scale in Indian ports.</p><!-- /wp:paragraph -->',
			'seo_t' => 'Home-grown Stevedoring Giant bags big - Delta Ports',
			'seo_d' => 'Media update on stevedoring and terminal operations excellence.',
			'image' => 'media-update3.webp',
		),
	);
	foreach ( $posts as $p ) {
		$id = delta_ports_upsert_post( $p['slug'], $p['title'], $p['body'], $force );
		delta_ports_set_yoast_meta( $id, $p['seo_t'], $p['seo_d'] );
		if ( ! empty( $p['image'] ) ) {
			delta_ports_set_post_featured_from_theme( $id, $p['image'] );
		}
	}

	delta_ports_seed_menus();
	update_option( 'blogname', 'Delta Ports' );
	update_option( 'blogdescription', 'Terminal Operations & Port Logistics' );
	flush_rewrite_rules();
	update_option( 'delta_ports_seeded', DELTA_PORTS_VERSION );
}

/**
 * Create primary navigation menu.
 */
function delta_ports_seed_menus() {
	$menu_name = 'Primary';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = (int) $menu->term_id;
		$items   = wp_get_nav_menu_items( $menu_id );
		if ( $items ) {
			foreach ( $items as $item ) {
				wp_delete_post( $item->ID, true );
			}
		}
	}

	$structure = array(
		array(
			'title' => 'Company',
			'url'   => '#',
			'children' => array(
				array( 'title' => 'Who we are', 'slug' => 'about-us' ),
				array( 'title' => 'Leadership team', 'slug' => 'leadership' ),
			),
		),
		array(
			'title' => 'Our Operations',
			'url'   => '#',
			'children' => array(
				array( 'title' => 'Port-led operations', 'slug' => 'led-operation-new' ),
				array( 'title' => 'Cargo Handling Capabilities', 'slug' => 'cargo-handling-capabilities' ),
				array( 'title' => 'Integrated Port Logistics', 'slug' => 'integrated-port-logistics' ),
			),
		),
		array( 'title' => 'Sustainability', 'slug' => 'sustainability' ),
		array( 'title' => 'Contact Us', 'slug' => 'contact-us' ),
	);

	foreach ( $structure as $item ) {
		$parent_id = 0;
		if ( ! empty( $item['slug'] ) ) {
			$page = get_page_by_path( $item['slug'] );
			if ( $page ) {
				$parent_id = wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => $item['title'],
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $page->ID,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}
		} else {
			$parent_id = wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'  => $item['title'],
					'menu-item-url'    => $item['url'],
					'menu-item-type'   => 'custom',
					'menu-item-status' => 'publish',
				)
			);
		}
		if ( ! empty( $item['children'] ) && $parent_id ) {
			foreach ( $item['children'] as $child ) {
				$page = get_page_by_path( $child['slug'] );
				if ( ! $page ) {
					continue;
				}
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => $child['title'],
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $page->ID,
						'menu-item-type'      => 'post_type',
						'menu-item-parent-id' => $parent_id,
						'menu-item-status'    => 'publish',
					)
				);
			}
		}
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
