<?php
/*
Plugin Name: Sharebar
Plugin URI: http://devgrow.com/sharebar-wordpress-plugin/
Description: Adds a dynamic bar with sharing icons (Facebook, Twitter, etc.) that changes based on browser size and page location.  More info and demo at: <a href="http://devgrow.com/sharebar-wordpress-plugin/">Sharebar Plugin Home</a>
Version: 1.0.1
Author: Monjurul Dolon
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

function sharebar_install(){
    global $wpdb;
    $table = $wpdb->prefix."sharebar";
	if($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
		$structure = "CREATE TABLE $table (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		position mediumint(9) NOT NULL,
		name VARCHAR(80) NOT NULL,
		big text NOT NULL,
		small text NULL,
		UNIQUE KEY id (id)
		);";
		$wpdb->query($structure);
		$wpdb->query("INSERT INTO $table(position,name, big, small)
			VALUES('1','tweetmeme', '<script type=\'text/javascript\' src=\'http://tweetmeme.com/i/scripts/button.js\'></script>', '<script type=\'text/javascript\'>tweetmeme_style = \'compact\';</script><script type=\'text/javascript\' src=\'http://tweetmeme.com/i/scripts/button.js\'></script>')");
		$wpdb->query("INSERT INTO $table(position,name, big, small)
			VALUES('2','facebook', '<a name=\'fb_share\' type=\'box_count\' href=\'http://www.facebook.com/sharer.php\'>Share</a><script src=\'http://static.ak.fbcdn.net/connect.php/js/FB.Share\' type=\'text/javascript\'></script>', '<a name=\'fb_share\' type=\'button_count\' href=\'http://www.facebook.com/sharer.php\'>Share</a><script src=\'http://static.ak.fbcdn.net/connect.php/js/FB.Share\' type=\'text/javascript\'></script>')");
		$wpdb->query("INSERT INTO $table(position,name, big, small)
			VALUES('3','buzz', '<a title=\'Post to Google Buzz\' class=\'google-buzz-button\' href=\'http://www.google.com/buzz/post\' data-button-style=\'normal-count\'></a><script type=\'text/javascript\' src=\'http://www.google.com/buzz/api/button.js\'></script>', '<a title=\'Post to Google Buzz\' class=\'google-buzz-button\' href=\'http://www.google.com/buzz/post\' data-button-style=\'small-count\'></a><script type=\'text/javascript\' src=\'http://www.google.com/buzz/api/button.js\'></script>')");
		$wpdb->query("INSERT INTO $table(position,name, big, small)
			VALUES('4','digg', '<script type=\'text/javascript\'>(function() { var s = document.createElement(\'SCRIPT\'), s1 = document.getElementsByTagName(\'SCRIPT\')[0]; s.type = \'text/javascript\'; s.async = true; s.src = \'http://widgets.digg.com/buttons.js\'; s1.parentNode.insertBefore(s, s1); })(); </script><a class=\'DiggThisButton DiggMedium\'></a>', '<script type=\'text/javascript\'>(function() { var s = document.createElement(\'SCRIPT\'), s1 = document.getElementsByTagName(\'SCRIPT\')[0]; s.type = \'text/javascript\'; s.async = true; s.src = \'http://widgets.digg.com/buttons.js\'; s1.parentNode.insertBefore(s, s1); })(); </script><a class=\'DiggThisButton DiggCompact\'></a>')");
		$wpdb->query("INSERT INTO $table(position,name, big, small)
			VALUES('5','email', '<a href=\'mailto:?subject=[url]\' class=\'sharebar-button email\'>Email</a>', '<a href=\'mailto:?subject=[url]\' class=\'sharebar-button email\'>Email</a>')");
		add_option('sharebar_auto', 1);
		add_option('sharebar_horizontal', 1);
		add_option('sharebar_minwidth','1000');
		add_option('sharebar_position','left');
		add_option('sharebar_leftoffset','20');
		add_option('sharebar_rightoffset','10');
	}
}

function sharebar_reset(){
	global $wpdb;
	$table = $wpdb->prefix."sharebar";
	$wpdb->query("DROP TABLE IF EXISTS $table");
	sharebar_install();
}

function sharebar_menu(){
    global $wpdb;

	$auto = get_option('sharebar_auto'); $horizontal = get_option('sharebar_horizontal');
	$width = get_option('sharebar_minwidth'); $position = get_option('sharebar_position');
	$leftoffset = get_option('sharebar_leftoffset'); $rightoffset = get_option('sharebar_rightoffset');

    include 'sharebar-admin.php';
}

function sharebar_settings($auto, $horizontal, $width, $position, $leftoffset, $rightoffset){
	update_option('sharebar_auto',$auto); update_option('sharebar_horizontal',$horizontal);
	update_option('sharebar_minwidth',$width); update_option('sharebar_position',$position);
	update_option('sharebar_leftoffset',$leftoffset); update_option('sharebar_rightoffset',$rightoffset);
}


function sharebar_auto($content){
	if(get_option('sharebar_auto') && (is_single() || is_page())){ $str = sharebar(false); $str .= sharebar_horizontal(false); }
	$newcontent = $str.$content;
	return $newcontent;
}

function sharebar($print = true){
	global $wpdb;
	$str = '<ul id="sharebar">';
	$results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."sharebar ORDER BY position, id ASC"); $str .= "\n";
	foreach($results as $result)
		$str .= '<li>'.sharebar_filter($result->big).'</li>';
	$str .= '</ul>';
	if($print) echo $str; else return $str;
}

function sharebar_horizontal($print = true){
	if(get_option('sharebar_horizontal')){
		global $wpdb;
		$str = '<ul id="sharebarx">';
		$results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."sharebar ORDER BY position, id ASC"); $str .= "\n";
		foreach($results as $result)
			$str .= '<li>'.sharebar_filter($result->small).'</li>';
		$str .= '</ul>';
		if($print) echo $str; else return $str;
	}
}

function sharebar_button($name, $size = 'big'){
	global $wpdb;
	$item = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."sharebar WHERE name='$name'");
	if($size == 'big') echo $item->big; else echo $item->small;
}

function sharebar_header(){

	if(function_exists('wp_enqueue_script') && (is_single() || is_page())) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('sharebar', plugins_url('js/sharebar.js', __FILE__), array('jquery'),false,true);
		wp_enqueue_style( 'sharebar_style', plugins_url('css/sharebar.css', __FILE__));
	}
}

function sharebar_footer(){
	$auto = get_option('sharebar_auto'); $horizontal = get_option('sharebar_horizontal');
	$width = get_option('sharebar_minwidth'); $position = get_option('sharebar_position');
	$leftoffset = get_option('sharebar_leftoffset'); $rightoffset = get_option('sharebar_rightoffset');
	if(function_exists('wp_enqueue_script') && (is_single() || is_page())) {
		if($horizontal)	$hori = 'true'; else $hori = 'false';
		?>
		<script type="text/javascript">jQuery(document).ready(function($) { $('.sharebar').sharebar({horizontal:'<?php echo $hori; ?>',minwidth:<?php echo $width; ?>,position:'<?php echo $position; ?>',leftOffset:<?php echo $leftoffset; ?>,rightOffset:<?php echo $rightoffset; ?>}); });</script>
		<!-- Sharebar Plugin by Monjurul Dolon (http://mdolon.com/) - more info at: http://devgrow.com/sharebar-wordpress-plugin -->
		<?
	}
}

function sharebar_filter($input){
	global $post;
	$code = array('[title]','[url]','[author]');
	$values = array($post->post_title,get_permalink(),get_the_author());
	return str_replace($code,$values,$input);
}
 
function sharebar_admin_actions(){
    add_options_page("Sharebar", "Sharebar", 1, "Sharebar", "sharebar_menu");
}


add_filter('the_content', 'sharebar_auto');
add_action('wp_head', sharebar_header, 1);
add_action('wp_footer', sharebar_footer, 1);
add_action('activate_sharebar/sharebar.php', 'sharebar_install');
add_action('admin_menu', 'sharebar_admin_actions');

?>