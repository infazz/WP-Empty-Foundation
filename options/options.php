<?php
global $lang;

add_action( 'admin_menu', 'theme_options_add_page' );
add_action( 'admin_init', 'theme_options_init' );

add_action('admin_enqueue_scripts', 'my_admin_scripts');

function my_admin_scripts() {
    wp_enqueue_media();
}

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){

	if (function_exists('icl_get_languages')) {
        //get list of used languages from WPML
        $langs = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
        //Set current language for language based variables in theme.

        if( !empty($langs) ){
			$langarr = $langs;
        }else{
        	$default_lang = explode('-', get_bloginfo( 'language' ));
			$dlang = $default_lang[0];
        	$langarr = array();	
        	$langarr[$dlang] = $dlang;
        }
    }

    foreach($langarr as $lang => $lng){
    	register_setting( 're_options_'.$lang , 're_opt_'.$lang );
    }
}


/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'blueglass' ), __( 'Theme Options', 'blueglass' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
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
		<?php echo "<h2>" . get_current_theme() . __( ' Theme Options', 'blueglass' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'blueglass' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 're_options_'.$lang ); ?>
			<?php $options = get_option( 're_opt_'.$lang ); 
			//print_r($options);
			?>

			<div class="tabs">
				<div class="tab-wrapper">

					<div class="box">
						<h3>Footer</h3>

							<div class="row clearfix">
								<label>Phone number</label>
								<?php
									$option_name = 'phonenumber'; 
									$value = esc_attr( $options[ $option_name ] );
									if(empty($value)) $value = ''; // default
								?>
								<input id="re_opt_<?php echo $lang ?>[<?php echo $option_name ?>]" name="re_opt_<?php echo $lang ?>[<?php echo $option_name ?>]" value="<?php echo $value; ?>" class="regular-text" type="text"  />	
							</div>	

							<div class="row clearfix">
								<label>Email</label>
								<?php
									$option_name = 'email'; 
									$value = esc_attr( $options[ $option_name ] );
									if(empty($value)) $value = ''; // default
								?>
								<input id="re_opt_<?php echo $lang ?>[<?php echo $option_name ?>]" name="re_opt_<?php echo $lang ?>[<?php echo $option_name ?>]" value="<?php echo $value; ?>" class="regular-text" type="text"  />	
							</div>	


						<h3>Pages</h3>

							<div class="row clearfix">
								<label>"Contact" page</label>
								<?php
									$option_name = 'contactpage'; 
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
