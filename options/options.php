<?php

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
	register_setting( 're_options', 're_opt', 'theme_options_validate' );
	register_setting( 're_gettext_options', 're_opt_gettext' );
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

$fileList = array();

function globThis($path){
	global $fileList;

	$files = glob($path.'/*');
	foreach($files as $file){

		if(is_dir($file)){
			if( strpos($file,'bower_components') !== false or 
				strpos($file,'.sass-cache') !== false or 
				strpos($file,'.git') !== false or
				strpos($file,'cache') !== false or
				strpos($file,'functions') !== false ) continue;
			globThis($file);
		}else{
			if( strpos($file,'meta_') !== false or strpos($file,'_meta') !== false or strpos($file,'options.php') !== false ) continue;
			$fileList[] = $file;
		}
	      
	}
}
/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options, $fileList;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;




	function trimRest($rest){
		//$rest = explode("' )", $rest);
    	//$rest = explode("')", $rest[0]);
    	//$rest = explode('")', $rest[0]);
    	$rest = str_replace("_e( '","",$rest);
    	$rest = str_replace("_e('","",$rest);
    	$rest = str_replace('_e("',"",$rest);
    	$rest = str_replace('_e( "',"",$rest);
    	$rest = str_replace('__( "',"",$rest);
    	$rest = str_replace('__("',"",$rest);
    	$rest = str_replace("__( '", "",$rest);
    	$rest = str_replace("__('", "",$rest);
    	$rest = str_replace("')","",$rest);
    	$rest = str_replace("' )","",$rest);
    	$rest = str_replace("')","",$rest);
    	$rest = str_replace('" )',"",$rest);
    	$rest = str_replace('")',"",$rest);
    	$rest = str_replace("', '", "','",$rest);
    	$rest = str_replace('", "', "','",$rest);
    	$rest = str_replace('","', "','",$rest);
    	$rest = explode("','", $rest);
    	//$rest = explode('","', $rest);
    	return $rest;
	}
	

	function trimRest2($rest){
		//print_r($rest . '<br>');
    	$rest = str_replace("_e('","",$rest);
    	$rest = str_replace("_e( '","",$rest);
    	$rest = str_replace("__('","",$rest);
    	$rest = str_replace("__( '","",$rest);
    	$rest = str_replace("')","",$rest);
    	$rest = str_replace("' )","",$rest);
    	$rest = str_replace("', '","','",$rest);
    	$rest = explode("','", $rest);
    	return $rest;
	}

	function in_array_r($needle, $haystack, $strict = false) {
	    foreach ($haystack as $item) {
	        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
	            return true;
	        }
	    }

	    return false;
	}

	//update_option( 're_opt_gettext', '' );

	if(isset($_POST['gettext']) and $_POST['gettext'] == 'update'){
		$path    = TEMPLATEPATH;

		globThis($path);
		$fileList = array_unique($fileList);

		$gettext = array();
		$processed = array();

		foreach ($fileList as $key => $filepath) {
			if(in_array($filepath, $processed)) continue;
			$processed[] = $filepath;

			$filesource = file_get_contents($filepath);
			preg_match_all( "/((?:__|_e)\((?:.*?)\))/", $filesource, $out);

			//print_r($out);
        	foreach($out as $key => $val){
            	if(!empty($val)){		
        			foreach( $val as $key => $v ){
						$rest = trimRest($v);

						//print_r($rest);

        				if(strpos($rest[0], 'outerHTML') !== false or
            				strpos($rest[0], 'esc_html') !== false or
            				strpos($rest[0], 'get_option') !== false or
            				strpos($rest[0], 'WC()') !== false) continue;

                    	$key = $rest[1];
                    	if(empty($key)) $key = 'Mamma';
                		if(!in_array_r($rest[0], $gettext) )  {
                			$gettext[$key][] = htmlspecialchars($rest[0]);
                		}
        			}
            	}
            }
		}


		$gettext_opt = get_option( 're_opt_gettext' );
		//$gettext_opt
		if($gettext_opt != $gettext) {
			update_option( 're_opt_gettext', $gettext );
		}
	}

	//update_option( 're_opt_gettext', '' );
	$gettext_opt = get_option( 're_opt_gettext' );

	//print_r( $gettext_opt );

	?>

	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'pptheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'pptheme' ); ?></strong></p></div>
		<?php endif; ?>


		<?php if ( isset($_POST['gettext']) ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Theme texts grabbed', 'pptheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="">
			<input type="hidden" name="gettext" value="update">

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Grab/Update theme texts', 'pptheme' ); ?>" />
			</p>
		</form>

		<form method="post" action="options.php">
			<?php settings_fields( 're_options' ); ?>
			<?php $options = get_option( 're_opt' ); ?>
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'pptheme' ); ?>" />
			</p>

			<div class="tabs">
				<div class="tab-menu">
					<ul><?php 
							if( function_exists('qtrans_getSortedLanguages')){
								$langarr = qtrans_getSortedLanguages();	
							}else{
								$langarr = array('ru');
							}
							$i = 1;
							foreach($langarr as $lang){
								echo '<li><a href="#tab'. $i . '">' . $lang . '</a></li>';
								$i++;
							}
						?></ul><div class="clear"></div>
				</div><!-- .tab-menu (end) -->
				<div class="tab-wrapper"><?php 
					$i = 1;
					foreach($langarr as $lang){ 
						echo '<div class="tab" id="tab' . $i . '" style="display: block;"> ';
							?>




<h2>Content</h2>

	<div class="row clearfix">
		<label>Все новости</label>
		<?php
			$option_name = 'newspage' . '_'; 
			$value = esc_attr( $options[ $option_name . $lang ] );
			if(empty($value)) $value = ''; // default
		?>
		<select name="re_opt[<?php echo $option_name . $lang ?>]"> 
			<option value=""><?php echo esc_attr( __( '-- Select page --' ) ); ?></option> 
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

	<div class="row clearfix">
		<label>Все клиенты</label>
		<?php
			$option_name = 'clientspage' . '_'; 
			$value = esc_attr( $options[ $option_name . $lang ] );
			if(empty($value)) $value = ''; // default
		?>
		<select name="re_opt[<?php echo $option_name . $lang ?>]"> 
			<option value=""><?php echo esc_attr( __( '-- Select page --' ) ); ?></option> 
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



	<div class="row clearfix">
		<label>Имейл для заявок</label>
		<?php
			$option_name = 'email' . '_'; 
			$value = $options[ $option_name . $lang ];
			if(empty($value)) $value = ''; // default
		?>
		<input id="re_opt[<?php echo $option_name . $lang ?>]" name="re_opt[<?php echo $option_name . $lang ?>]" value="<?php echo esc_attr($value); ?>" class="regular-text" type="text"  />	
	</div>



<h2>footer</h2>


	<div class="row clearfix">
		<label></label>
		<?php
			$option_name = 'footer' . '_'; 
			$value = $options[ $option_name . $lang ];
			if(empty($value)) $value = ''; // default
		?>
		<?php wp_editor( $value, $option_name . $lang , $settings = array('teeny' => false, 'textarea_name' => 're_opt[' .  $option_name . $lang  . ']') ); ?>							
	</div>



<h1>&nbsp;</h1>
<h1>Theme texts</h1>


<?php 
	foreach( $gettext_opt as $key => $txt){

		echo  '<div class="toggle">';
	    	echo  '<a href="#" class="trigger">'.$key.'</a>';
		   
			echo  '<div class="box">';
		//echo '<h2>'.$key.'</h2>';

		foreach( $txt as $key => $val){
				echo '<div class="row clearfix">';
				echo '<label>'.$val.'</label>';
				$option_name = sanitize_title($val) . '_'; 
				$value = esc_attr( $options[ $option_name . $lang ] );

				//print_r($value);
				if(empty($value)) $value = $val; // default
	?>
					<input id="re_opt[<?php echo $option_name . $lang ?>]" name="re_opt[<?php echo $option_name . $lang ?>]" value="<?php echo $value; ?>" class="regular-text" type="text"  />
	<?php
				echo '</div>';

		}
			echo '<input type="submit" class="button-primary" value="'. __( 'Save Options', 'pptheme' ).'" />';
		    echo  '</div>';
	    echo '</div>';
		
	}
?>

							
						<?php echo '</div>';
						$i++;
					}
					?></div><!-- .tab-wrapper (end) -->
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