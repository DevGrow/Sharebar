<?php
/*
Plugin Name: Sharebar
Plugin URI: http://devgrow.com/sharebar-wordpress-plugin/
Description: Adds a dynamic bar with sharing icons (Facebook, Twitter, etc.) that changes based on browser size and page location.
Version: 1.4.1
Author: Monji Dolon
Author URI: http://mdolon.com/
License: GPL2
*/
/*  Copyright 2010  Monjurul Dolon  (email : md@devgrow.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
$sharebar_options = array("auto_posts","auto_pages","horizontal","width","position","credit","leftoffset","rightoffset","swidth","twitter_username","sbg","sborder");

function sharebar_install(){
    global $wpdb;
    $table = $wpdb->prefix."sharebar";
    if($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
        $structure = "CREATE TABLE $table (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			position mediumint(9) NOT NULL,
			enabled int(1) NOT NULL,
			name VARCHAR(80) NOT NULL,
			big text NOT NULL,
			small text NULL,
			UNIQUE KEY id (id)
		);";

        $wpdb->query($structure);

        $facebook = "<div id=\"fb-root\"></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3\"; fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'));</script><div class=\"fb-like\" data-width=\"60\" data-layout=\"box_count\" data-action=\"like\" data-show-faces=\"false\" data-share=\"false\"></div>";
        $facebook_small = "<div id=\"fb-root\"></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3\"; fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'));</script><div class=\"fb-like\" data-width=\"80\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"false\" data-share=\"false\"></div>";
        $twitter = "<a class=\"twitter-share-button\" href=\"https://twitter.com/share\" data-count=\"vertical\">Tweet</a><script>window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,\"script\",\"twitter-wjs\"));</script>";
        $twitter_small = "<a class=\"twitter-share-button\" href=\"https://twitter.com/share\">Tweet</a><script>window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,\"script\",\"twitter-wjs\"));</script>";
        $reddit = "<script type=\"text/javascript\" src=\"http://reddit.com/static/button/button2.js\"></script>";
        $reddit_small = "<script type=\"text/javascript\" src=\"http://reddit.com/static/button/button1.js\"></script>";
        $stumbleupon = "<script src=\"http://www.stumbleupon.com/hostedbadge.php?s=5\"></script>";
        $stumbleupon_small = "<script src=\"http://www.stumbleupon.com/hostedbadge.php?s=2\"></script>";
        $pinterest = "<a href=\"//www.pinterest.com/pin/create/button/\" data-pin-do=\"buttonBookmark\"  data-pin-color=\"red\" data-pin-height=\"28\"><img src=\"//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_28.png\" /></a>
		<!-- Please call pinit.js only once per page -->
		<script type=\"text/javascript\" async defer src=\"//assets.pinterest.com/js/pinit.js\"></script>";
        $pinterest_small = "<a href=\"//www.pinterest.com/pin/create/button/\" data-pin-do=\"buttonBookmark\"  data-pin-color=\"red\"><img src=\"//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png\" /></a>
		<!-- Please call pinit.js only once per page -->
		<script type=\"text/javascript\" async defer src=\"//assets.pinterest.com/js/pinit.js\"></script>";
        $email = "<a href=\"mailto:?subject=[url]\" class=\"sharebar-button email\">Email</a>";
        $email_small = "<a href=\"mailto:?subject=[url]\" class=\"sharebar-button email\">Email</a>";

        $wpdb->query("INSERT INTO $table(enabled, position, name, big, small) VALUES ('1','1','facebook', '$facebook', '$facebook_small')");
        $wpdb->query("INSERT INTO $table(enabled, position, name, big, small) VALUES ('1','2','twitter', '$twitter', '$twitter_small')");
        $wpdb->query("INSERT INTO $table(enabled, position, name, big, small) VALUES ('0','3','pinterest', '$pinterest', '$pinterest_small')");

        $wpdb->query("INSERT INTO $table(enabled, position, name, big, small) VALUES ('0','4','reddit', '$reddit', '$reddit_small')");
        $wpdb->query("INSERT INTO $table(enabled, position, name, big, small) VALUES ('0','5','stumbleupon', '$stumbleupon', '$stumbleupon_small')");
        $wpdb->query("INSERT INTO $table(enabled, position, name, big, small) VALUES ('1','6','email', '$email', '$email_small')");

        add_option('sharebar_auto_posts', 1);
        add_option('sharebar_auto_pages', 1);
        add_option('sharebar_horizontal', 1);
        add_option('sharebar_credit', 0);
        add_option('sharebar_minwidth','1000');
        add_option('sharebar_position','left');
        add_option('sharebar_leftoffset','20');
        add_option('sharebar_rightoffset','10');
        add_option('sharebar_swidth','65');
        add_option('sharebar_twitter_username','ThinkDevGrow');
        add_option('sharebar_bg','#ffffff');
        add_option('sharebar_border','#cccccc');
    }
}

function sharebar_reset(){
    global $wpdb;
    $table = $wpdb->prefix."sharebar";
    $wpdb->query("DROP TABLE IF EXISTS $table");
    sharebar_install();
}

function sharebar_menu(){
    global $wpdb, $sharebar_options;
    foreach($sharebar_options as $option) $$option = get_option('sharebar_'.$option);
    include 'sharebar-admin.php';
}

function sharebar_settings($settings){
    global $sharebar_options;
    foreach($sharebar_options as $option) update_option('sharebar_'.$option,$settings[$option]);
}


function sharebar_auto($content){
    if((get_option('sharebar_auto_posts') && is_single()) || (get_option('sharebar_auto_pages') && is_page())){ $str = sharebar(false); $str .= sharebar_horizontal(false); }
    $newcontent = $str.$content;
    return $newcontent;
}

function sharebar($print = true){
    global $wpdb, $post;
    $sharebar_hide = get_post_meta($post->ID, 'sharebar_hide', true);
    $sbg = get_option('sharebar_sbg');
    $sborder = get_option('sharebar_sborder');
    if(empty($sharebar_hide)) {
        $credit = get_option('sharebar_credit');
        $str = '<ul id="sharebar" style="background:#'.$sbg.';border-color:#'.$sborder.';">';
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."sharebar WHERE enabled=1 ORDER BY position, id ASC", null)); $str .= "\n";
        foreach($results as $result){ $str .= '<li>'.sharebar_filter($result->big).'</li>'; }
        if($credit) $str .= '<li class="credit"><a rel="nofollow" href="http://sumo.com/" target="_blank">Sumo</a></li>';
        $str .= '</ul>';
        if($print) echo $str; else return $str;
    }
}

function sharebar_horizontal($print = true){
    if(get_option('sharebar_horizontal')){
        global $wpdb;
        $str = '<ul id="sharebarx">';
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."sharebar WHERE enabled=1 ORDER BY position, id ASC", null)); $str .= "\n";
        foreach($results as $result) { $str .= '<li>'.sharebar_filter($result->small).'</li>'; }
        $str .= '</ul>';
        if($print) echo $str; else return $str;
    }
}

function sharebar_button($name, $size = 'big'){
    global $wpdb;
    $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."sharebar WHERE name='$name'"));
    if($size == 'big') echo stripslashes($item->big); else echo stripslashes($item->small);
}

function sharebar_update_button($id, $uptask){
    global $wpdb;
    if($uptask == 'enable')
        $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."sharebar SET enabled='1' WHERE id='%d'", $id));
    elseif($uptask == 'disable')
        $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."sharebar SET enabled='0' WHERE id='%d'", $id));
    elseif($uptask == 'delete')
        $wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."sharebar WHERE id=%d LIMIT 1", $id));
}

function sharebar_scripts() {
    wp_enqueue_script('sharebar', plugins_url('js/sharebar.js', __FILE__ ), array('jquery'));
    wp_enqueue_style('sharebar', plugins_url('css/sharebar.css', __FILE__ ));
}

function sharebar_header(){
    global $sharebar_options;
    foreach($sharebar_options as $option) $$option = get_option('sharebar_'.$option);
    if (is_single() || is_page()) {
        if($horizontal)	$hori = 'true'; else $hori = 'false';
        if(!$width) $width = 1000;
        echo "\n"; ?><script type="text/javascript">jQuery(document).ready(function($) { $('.sharebar').sharebar({horizontal:'<?php echo $hori; ?>',swidth:'<?php echo $swidth; ?>',minwidth:<?php echo $width; ?>,position:'<?php echo $position; ?>',leftOffset:<?php echo $leftoffset; ?>,rightOffset:<?php echo $rightoffset; ?>}); });</script><?php echo "\n"; ?><!-- Sharebar Plugin by Monjurul Dolon (http://mdolon.com/) - more info at: http://devgrow.com/sharebar-wordpress-plugin --><?php echo "\n"; ?><?php
    }
}

function sharebar_filter($input){
    global $post;
    $code = array('[title]','[url]','[author]','[twitter]');
    $values = array($post->post_title,get_permalink(),get_the_author(),get_option('sharebar_twitter_username'));
    return str_replace($code,$values,$input);
}

function sharebar_admin_actions(){
    if(current_user_can('manage_options')) add_options_page("Sharebar", "Sharebar", 1, "Sharebar", "sharebar_menu");
}

function sharebar_custom_boxes() {
    add_meta_box( 'Sharebar', 'Sharebar Settings', 'sharebar_post_options', 'post', 'side', 'low');
    add_meta_box( 'Sharebar', 'Sharebar Settings', 'sharebar_post_options', 'page', 'side', 'low');
}

function sharebar_post_options(){
    global $post;
    $sharebar_hide = get_post_meta($post->ID, 'sharebar_hide', true); ?>
    <p>
        <input name="sharebar_hide" id="sharebar_hide" type="checkbox" <?php checked(true, $sharebar_hide, true) ?> />
        <label for="sharebar_hide">Disable Sharebar on this post?</label>
    </p>
    <?php
}

function sharebar_save_post_options($post_id) {
    if (!isset($_POST['sharebar_hide']) || empty($_POST['sharebar_hide'])) {
        delete_post_meta($post_id, 'sharebar_hide');
        return;
    }
    $post = get_post($post_id);
    if (!$post || $post->post_type == 'revision') return;
    update_post_meta($post_id, 'sharebar_hide', true);
}

function sharebar_admin_head(){
    echo '
	<link rel="stylesheet" media="screen" type="text/css" href="'.plugins_url('css/colorpicker.css', __FILE__).'" />
	<script type="text/javascript" src="'.plugins_url('js/colorpicker.js', __FILE__).'"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var ids = ["sbg","sborder"];
			$.each(ids, function() {
				var id = this;
				$("#"+this).ColorPicker({
					onSubmit: function(hsb, hex, rgb, el) {
						$(el).val(hex);
						$(el).ColorPickerHide();
					},
					onBeforeShow: function () {
						$(this).ColorPickerSetColor(this.value);
					},
					onChange: function(hsb, hex, rgb, el) {
						$("#"+id).val(hex);
					}
				});
			});
		});
	</script>';
}

function cleanInput($input) {

    $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    );

    $output = preg_replace($search, '', $input);
    return $output;
}

function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = esc_sql($input);
    }
    return $output;
}


add_filter('the_content', 'sharebar_auto');
add_action('wp_enqueue_scripts', 'sharebar_scripts');
add_action('wp_head', 'sharebar_header');
add_action('admin_head', 'sharebar_admin_head');
add_action('activate_sharebar/sharebar.php', 'sharebar_install');
add_action('admin_menu', 'sharebar_admin_actions');
add_action('add_meta_boxes', 'sharebar_custom_boxes');
add_action('draft_post', 'sharebar_save_post_options');
add_action('publish_post', 'sharebar_save_post_options');
add_action('save_post', 'sharebar_save_post_options');

?>
