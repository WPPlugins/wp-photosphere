<?php
/*
Plugin Name: WP-Photosphere
Plugin URI: http://www.blogtogo.de/wp-photosphere-photosphere-aufnahmen-in-wordpress-einbinden/
Description: Bindet via Shortcode eine Photosphere-Aufnahme in Artkeln und Seiten ein.
Author: Marcel Schmilgeit
Version: 1.0.1
Author URI: http://www.blogtogo.de
*/

error_reporting(0);
load_plugin_textdomain('wp-photosphere', false, dirname(plugin_basename( __FILE__ )) . '/');

define("WPPHOTOSPHERE_PLUGIN_NAME", 'WP-Photosphere'); 
define("WPPHOTOSPHERE_PLUGIN_VERSION", '1.0.1');
define("WPPHOTOSPHERE_BASE_DIR", basename(dirname(dirname(__FILE__))));	
include_once("wp-photosphere-admin.php");	


function wpPhotosphere_add_button($buttons) {
	array_push($buttons, "separator", "wpPhotosphere_Button");
	return $buttons;
}


function wpPhotosphere_register($plugin_array) {
	$plugin_array["wpPhotosphere"] = plugins_url('btn.js', __FILE__);
	return $plugin_array;
}


function wpPhotosphere_shortcode($atts, $content = null) {
	$options = get_option('wpPhotosphere');

	$autorotate = false;
	$add = '';
	
	if(is_array($atts)) {
		foreach($atts as $value) { if($value == 'autorotate') $autorotate = true; }
	}
	if(!$autorotate) $autorotate = $options['wpPhotosphere_autorotate'];
	if($autorotate) $add .= ' autorotate="1"';
	
	extract(shortcode_atts(array(
		'height' => $options['wpPhotosphere_height'], 
		'width' => $options['wpPhotosphere_width']
	), $atts));

	if($content != '') $add .= ' imageurl="'.$content.'"';
	return '<p><g:panoembed fullsize="4096,2048" croppedsize="4096,1380" offset="0,480" displaysize="'.$width.','.$height.'" '.$add.'/></p>';
}


function wpPhotosphere_deactivate() {
	delete_option('wpPhotosphere');
}


add_shortcode('photosphere', 'wpPhotosphere_shortcode');

wp_enqueue_script('photospherescript', 'https://apis.google.com/js/plusone.js');

add_action('admin_menu', 'wpPhotosphere_create_menu');
add_action('admin_init', 'wpPhotosphere_adminInit');
 
add_filter('mce_external_plugins', "wpPhotosphere_register");
add_filter('mce_buttons', 'wpPhotosphere_add_button', 0);

register_deactivation_hook(__FILE__, 'wpPhotosphere_deactivate');

?>