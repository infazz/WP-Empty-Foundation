<?php
global $lang;

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

add_action('admin_enqueue_scripts', 'my_admin_scripts');

function my_admin_scripts() {
    //if (isset($_GET['page']) && $_GET['page'] == 'theme_options') {
        wp_enqueue_media();
    //}
}

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	global $lang;
	register_setting( 're_options', 're_opt_'.$lang );
	register_setting( 're_gettext_options', 're_opt_gettext' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'mktheme' ), __( 'Theme Options', 'mktheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $lang;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>

	<div class="wrap">
		<?php echo "<h2>" . get_current_theme() . __( ' Theme Options', 'pptheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'pptheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 're_options' ); ?>
			<?php $options = get_option( 're_opt_'.$lang ); ?>

			<div class="tabs">
				<div class="tab-wrapper">

					<div class="box">
						<h3>Input</h3>

							<div class="row clearfix">
								<label>Input label</label>
								<?php
									$option_name = 'someinput'; 
									$value = esc_attr( $options[ $option_name ] );
									if(empty($value)) $value = ''; // default
								?>
								<input id="re_opt_<?php echo $lang ?>[<?php echo $option_name ?>]" name="re_opt_<?php echo $lang ?>[<?php echo $option_name ?>]" value="<?php echo $value; ?>" class="regular-text" type="text"  />	
							</div>	


						<h3>Pages</h3>

							<div class="row clearfix">
								<label>"Some" page</label>
								<?php
									$option_name = 'somepage'; 
									$value = esc_attr( $options[ $option_name ] );
									if(empty($value)) $value = ''; // default
								?>
								<select name="re_opt_<?php echo $lang ?>[<?php echo $option_name ?>]"> 
									<option value="">
								   	<?php echo esc_attr( __( 'Select page' ) ); ?></option> 
									<?php 
										
										 $pages = get_pages(); 
										 foreach ( $pages as $page ) {
											$sel = '';
											if($value == $page->ID)  $sel = 'selected';
											   $option = '<option value="' . $page->ID . '" '. $sel .'>';
											   $option .= $page->post_title;
											   $option .= '</option>';
											   echo $option;
										 }
										
									?>
								</select>
							</div>	

		
					</div>
				</div><!-- .tab-wrapper (end) -->
			</div>	

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'pptheme' ); ?>" />
			</p>


		</form>
		
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