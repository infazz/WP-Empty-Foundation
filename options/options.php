<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

add_action('admin_enqueue_scripts', 'my_admin_scripts');
 
function my_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'theme_options') {
        wp_enqueue_media();
    }
}

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'ef_options', 'ef_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'mktheme' ), __( 'Theme Options', 'mktheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}
/**
 * Create arrays for our select and radio options
 */
$select_options = array(
	'0' => array(
		'value' =>	'0',
		'label' => __( 'Да', 'pptheme' )
	),
	'1' => array(
		'value' =>	'1',
		'label' => __( 'Нет', 'pptheme' )
	)
);

$radio_options = array(
	'yes' => array(
		'value' => 'yes',
		'label' => __( 'Yes', 'pptheme' )
	),
	'no' => array(
		'value' => 'no',
		'label' => __( 'No', 'pptheme' )
	)
);

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'pptheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'pptheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'ef_options' ); ?>
			<?php $options = get_option( 'ef_theme_options' ); ?>
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'pptheme' ); ?>" />
			</p>
			
			<table class="form-table">
			
				

				<!--
				<tr valign="top">
					<th scope="row"><strong>Homapage</strong></th>
				</tr>
			
				<tr valign="top">
					<th scope="row"><strong>Request box</strong></th>
				</tr>
				
				<tr valign="top"><th scope="row">Request box content</th>
					<td>
						<?php //wp_editor( $options['request'], 'ef_theme_options[request]', $settings = array() ); ?>
					</td>
				</tr>
				-->
				<tr valign="top">
					<th scope="row"><strong>Header</strong></th>
				</tr>
				<tr valign="top"><th scope="row">"Search for" text</th>
					<td>
						<input id="ef_theme_options[search]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[search]" value="<?php esc_attr_e( $options['search'] ); ?>" />
					</td>
				</tr>
				
				
			
				<tr valign="top">
					<th scope="row"><strong>Footer</strong></th>
				</tr>
				
				<tr valign="top"><th scope="row">Row 1</th>
					<td>
						<textarea id="ef_theme_options[row1]" style="width: 500px; height: 100px;" class="regular-text" type="text" name="ef_theme_options[row1]" ><?php echo $options['row1']; ?></textarea>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row">Row 2</th>
					<td>
						<textarea id="ef_theme_options[row2]" style="width: 500px; height: 100px;" class="regular-text" type="text" name="ef_theme_options[row2]" ><?php echo $options['row2']; ?></textarea>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row">Row 3</th>
					<td>
						<textarea id="ef_theme_options[row3]" style="width: 500px; height: 100px;" class="regular-text" type="text" name="ef_theme_options[row3]" ><?php echo $options['row3']; ?></textarea>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row">Row 4</th>
					<td>
						<textarea id="ef_theme_options[row4]" style="width: 500px; height: 100px;" class="regular-text" type="text" name="ef_theme_options[row4]" ><?php echo $options['row4']; ?></textarea>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong></strong></th>
				</tr>
				<tr valign="top"><th scope="row">HINNAPÄRING shortcode</th>
					<td>
						<input id="ef_theme_options[hinnaparing]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[hinnaparing]" value="<?php esc_attr_e( $options['hinnaparing'] ); ?>" />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong></strong></th>
				</tr>
				<tr valign="top"><th scope="row">Email Subscription shortcode</th>
					<td>
						<input id="ef_theme_options[mails]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[mails]" value="<?php esc_attr_e( $options['mails'] ); ?>" />
					</td>
				</tr>
				
				
				
				<tr valign="top">
					<th scope="row"><strong></strong></th>
				</tr>
				<tr valign="top">
					<th scope="row"><strong></strong></th>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Localization</strong></th>
				</tr>
		
				
				
				<tr valign="top"><th scope="row">EST url</th>
					<td>
						<input id="ef_theme_options[est]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[est]" value="<?php esc_attr_e( $options['est'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">if EST is current check this</th>
					<td>
						<input id="ef_theme_options[estc]" type="radio" name="ef_theme_options[currlang]" value="estc" <?php if($options['currlang'] == 'estc') echo 'checked="checked"'; ?>/>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row">RU url</th>
					<td>
						<input id="ef_theme_options[ru]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[ru]" value="<?php esc_attr_e( $options['ru'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">if RU is current check this</th>
					<td>
						<input id="ef_theme_options[ruc]" type="radio" name="ef_theme_options[currlang]" value="ruc" <?php if($options['currlang'] == 'ruc') echo 'checked="checked"'; ?>/>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row">FI url</th>
					<td>
						<input id="ef_theme_options[fi]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[fi]" value="<?php esc_attr_e( $options['fi'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">if FI is current check this</th>
					<td>
						<input id="ef_theme_options[fic]" type="radio" name="ef_theme_options[currlang]" value="fic" <?php if($options['currlang'] == 'fic') echo 'checked="checked"'; ?>/>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row">ENG url</th>
					<td>
						<input id="ef_theme_options[eng]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[eng]" value="<?php esc_attr_e( $options['eng'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">if ENG is current check this</th>
					<td>
						<input id="ef_theme_options[engc]" type="radio" name="ef_theme_options[currlang]" value="engc" <?php if($options['currlang'] == 'engc') echo 'checked="checked"'; ?>/>
					</td>
				</tr>
				
				
				<tr valign="top">
					<th scope="row"><strong></strong></th>
				</tr>
				<tr valign="top">
					<th scope="row"><strong></strong></th>
				</tr>
				<tr valign="top">
					<th scope="row"><strong>Translations</strong></th>
				</tr>
		
				
				
				<tr valign="top"><th scope="row">Tellimuskeskus URL</th>
					<td>
						<input id="ef_theme_options[tellimusurl]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[tellimusurl]" value="<?php esc_attr_e( $options['tellimusurl'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">Kasutajanimi</th>
					<td>
						<input id="ef_theme_options[kasutajanimi]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[kasutajanimi]" value="<?php esc_attr_e( $options['kasutajanimi'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">Parool</th>
					<td>
						<input id="ef_theme_options[parool]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[parool]" value="<?php esc_attr_e( $options['parool'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row"> Unustasid salasõna? </th>
					<td>
						<input id="ef_theme_options[unustasid]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[unustasid]" value="<?php esc_attr_e( $options['unustasid'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row"> Unustasid salasõna? URL</th>
					<td>
						<input id="ef_theme_options[unustasidURL]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[unustasidURL]" value="<?php esc_attr_e( $options['unustasidURL'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">Registreeru kasutajaks</th>
					<td>
						<input id="ef_theme_options[registreeru]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[registreeru]" value="<?php esc_attr_e( $options['registreeru'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">Registreeru kasutajaks URL</th>
					<td>
						<input id="ef_theme_options[registreeruURL]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[registreeruURL]" value="<?php esc_attr_e( $options['registreeruURL'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">Logi sisse</th>
					<td>
						<input id="ef_theme_options[login]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[login]" value="<?php esc_attr_e( $options['login'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">Esita tellimus registreerimata</th>
					<td>
						<input id="ef_theme_options[esita]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[esita]" value="<?php esc_attr_e( $options['esita'] ); ?>" />
					</td>
				</tr>
				<tr valign="top"><th scope="row">Esita tellimus registreerimata URL</th>
					<td>
						<input id="ef_theme_options[esitaURL]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[esitaURL]" value="<?php esc_attr_e( $options['esitaURL'] ); ?>" />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong></strong></th>
				</tr>
				<tr valign="top">
					<th scope="row">Hinnakiri pilt</th>
					<td><label for="upload_image">
					<input id="upload_image" style="width: 500px;" type="text" size="36" name="ef_theme_options[hinnakiri]" value="<?php esc_attr_e( $options['hinnakiri'] ); ?>" />
					<input id="upload_image_button" type="button" value="Upload Image" />
					<br />Enter an URL or upload an image.
					</label></td>
				</tr>
				<tr valign="top"><th scope="row">Hinnakiri url</th>
					<td>
						<input id="ef_theme_options[hinnakiriurl]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[hinnakiriurl]" value="<?php esc_attr_e( $options['hinnakiriurl'] ); ?>" />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong></strong></th>
				</tr>
		
				
				
				<tr valign="top"><th scope="row">Otsingu tulemused</th>
					<td>
						<input id="ef_theme_options[tulemused]" style="width: 500px;" class="regular-text" type="text" name="ef_theme_options[tulemused]" value="<?php esc_attr_e( $options['tulemused'] ); ?>" />
					</td>
				</tr>
				
				
			
				<tr valign="top">
					<th scope="row"><strong>SEO</strong></th>
				</tr>
				<tr valign="top">
					<th scope="row">Keywords:</th>
					<td>
						<textarea id="ef_theme_options[keywords]" class="regular-text" style="width: 500px; height: 50px;" name="ef_theme_options[keywords]"><?php echo $options['keywords']; ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Description:</th>
					<td>
						<textarea id="ef_theme_options[description]" class="regular-text" style="width: 500px; height: 50px;" name="ef_theme_options[description]"><?php echo $options['description']; ?></textarea>
					</td>
				</tr>
				
				
			</table>
			

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'pptheme' ); ?>" />
			</p>
		</form>
		
		<script type="text/javascript">
		jQuery(document).ready(function(){			
			jQuery("#postselect").change(function(){
				jQuery(".op_about").val(jQuery(this).val());
			});
			
			var custom_uploader;
 
			 
				jQuery('#upload_image_button').click(function(e) {
			 
					e.preventDefault();
			 
					//If the uploader object has already been created, reopen the dialog
					if (custom_uploader) {
						custom_uploader.open();
						return;
					}
			 
					//Extend the wp.media object
					custom_uploader = wp.media.frames.file_frame = wp.media({
						title: 'Choose Image',
						button: {
							text: 'Choose Image'
						},
						multiple: false
					});
			 
					//When a file is selected, grab the URL and set it as the text field's value
					custom_uploader.on('select', function() {
						attachment = custom_uploader.state().get('selection').first().toJSON();
						jQuery('#upload_image').val(attachment.url);
					});
			 
					//Open the uploader dialog
					custom_uploader.open();
			 
				});
		});

		</script>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['selectinput'], $select_options ) )
		$input['selectinput'] = null;

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['radioinput'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
		$input['radioinput'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/