<?php

function wpPhotosphere_create_menu() {
	$settings_page = add_options_page(WPPHOTOSPHERE_PLUGIN_NAME, WPPHOTOSPHERE_PLUGIN_NAME, 'manage_options', 'wp-photosphere', 'wpPhotosphere_options_page');
	add_action( "load-{$settings_page}", 'wpPhotosphere_loadSettingsPage' );
}

function wpPhotosphere_adminInit() {
	$settings_photosphere = get_option("wpPhotosphere");
	if(empty($settings_photosphere)) {
	$settings_photosphere = array(
		'wpPhotosphere_autorotate' => false,
		'wpPhotosphere_width' => '600',
		'wpPhotosphere_height' => '400'
	);	
	add_option("wpPhotosphere", $settings_photosphere, '', 'yes');
	}	
}

function wpPhotosphere_loadSettingsPage() {
	if($_POST["wp-photosphere-settings-submit"] == 'Y') {
		check_admin_referer("wp-photosphere-setting-page");
		wpPhotosphere_saveSettings();
		$url_parameters = isset($_GET['tab'])?'updated=true&tab='.$_GET['tab']:'updated=true';
		wp_redirect(admin_url('options-general.php?page=wp-photosphere&'.$url_parameters));
		exit;
	}
}

function wpPhotosphere_saveSettings() {
	$settings = get_option("wpPhotosphere");
    $settings['wpPhotosphere_width'] = $_POST['wpPhotosphere_width'];
    $settings['wpPhotosphere_height'] = $_POST['wpPhotosphere_height'];
    $settings['wpPhotosphere_autorotate'] = $_POST['wpPhotosphere_autorotate'];
	$updated = update_option("wpPhotosphere", $settings);
}

function wpPhotosphere_options_page() {
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2><?php echo WPPHOTOSPHERE_PLUGIN_NAME; ?> (Version <?php echo WPPHOTOSPHERE_PLUGIN_VERSION; ?>)</h2>
	<div class="widget" style="margin:15px 0;"><p style="margin:10px;">
		<a href="http://www.blogtogo.de/wp-photosphere-photosphere-aufnahmen-in-wordpress-einbinden/" target="_blank"><?php _e('Besuch die Plugin-Seite'); ?></a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=698ZDAQJDFX22" target="_blank"><?php _e('Spenden via PayPal'); ?></a> | <a href="http://wordpress.org/extend/plugins/wp-appbox/" target="_blank"><?php _e('Plugin im WordPress Directory'); ?></a> | <a href="https://twitter.com/Marcelismus" target="_blank"><?php _e('Folge mir via Twitter'); ?></a>
	</p></div>
	<?php settings_fields('wpPhotosphere'); ?>
	<?php $options = get_option('wpPhotosphere'); ?>
	<form method="post" action="<?php admin_url('options-general.php?page=wp-photosphere'); ?>">
	<?php wp_nonce_field("wp-photosphere-setting-page"); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Breite der Box in Pixel'); ?>:</th>
				<td>
					<input type="number" pattern="[0-9]*" name="wpPhotosphere_width" value="<?php echo $options['wpPhotosphere_width']; ?>" />
					<span class="description"><?php _e('Kann über den Tag "width=600" manuell im Shortcode aktiviert werden'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Höhe der Box in Pixel'); ?>:</th>
				<td>
					<input type="number" pattern="[0-9]*" name="wpPhotosphere_height" value="<?php echo $options['wpPhotosphere_height']; ?>" />
					<span class="description"><?php _e('Kann über den Tag "height=600" manuell im Shortcode aktiviert werden'); ?></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Autorotation'); ?>:</th>
				<td>
					<input type="checkbox" name="wpPhotosphere_autorotate" value="1" <?php  if($options['wpPhotosphere_autorotate'] == true) echo 'checked="checked"'; ?> /> <?php _e('Standardmäßig aktivieren'); ?><br />
					<span class="description"><?php _e('Kann über den Tag "autorotate" manuell im Shortcode aktiviert werden'); ?></span>
				</td>
			</tr>
		</table>
		<p class="submit" style="clear: both;">
		      <input type="submit" name="Submit" class="button-primary" value="<?php _e('Änderungen speichern', 'wp-photosphere'); ?>" />
		      <input type="hidden" name="wp-photosphere-settings-submit" value="Y" />
		   </p>
	</form>
</div>
<?php } ?>