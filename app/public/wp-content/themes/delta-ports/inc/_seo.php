<?php
define("WP_USE_THEMES", false);
require "C:/Users/shanm/Local Sites/delta-ports/app/public/wp-load.php";
echo "site_icon=" . get_option("site_icon") . "\n";
echo "blogname=" . get_option("blogname") . "\n";
echo "yoast=" . (defined("WPSEO_VERSION") ? WPSEO_VERSION : "no") . "\n";
$pages = get_posts(array("post_type"=>"page","posts_per_page"=>50,"post_status"=>"publish"));
foreach ($pages as $p) {
  $yt = get_post_meta($p->ID, "_yoast_wpseo_title", true);
  $yd = get_post_meta($p->ID, "_yoast_wpseo_metadesc", true);
  echo $p->post_name . " | yoast_t=" . ($yt?:'-') . " | yoast_d=" . substr($yd?:'-',0,40) . "\n";
}
