<?php
	//
	// BlueGlass Interactive
	//
	

	$functions_path 	= TEMPLATEPATH . '/functions/';	
	$template_url 		= get_bloginfo('template_url');

	// Get language code from WPML if one of plugin is enabled
	if( function_exists('icl_get_languages')){
		$lang = ICL_LANGUAGE_CODE;
	}else{
		$default_lang = explode('-', get_bloginfo( 'language' ));
		$lang = $default_lang[0];
	}

	
	// Setups
	add_action( 'after_setup_theme', 're_setup_template' );
	function re_setup_template(){
		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'post-formats', array('aside', 'gallery', 'image', 'quote', 'video')); 
		
		//add_image_size( 'tiny', 78, 81, true );

		register_nav_menus( array( 'top-menu' => __( 'Top menu', 'blueglass')  ) );
	}



	// Add RSS links to <head> section
	add_theme_support( 'automatic-feed-links' );


	// Theme ajax functions
	include_once($functions_path . '/ajax.php');
	
	// Theme sidebars
	include_once($functions_path . '/sidebars.php');

	//Post types
	//include_once($functions_path . 'post_types.php');


	//Category meta
	//include_once($functions_path . 'category_meta.php');

	
	//Shortcodes
	require_once $functions_path . 'theme_shortcodes/shortcodes.php';
	//include_once($functions_path . 'theme_shortcodes/alert.php');
	include_once($functions_path . 'theme_shortcodes/tabs.php');
	include_once($functions_path . 'theme_shortcodes/toggle.php');
	//include_once($functions_path . 'theme_shortcodes/html.php');

	if( is_admin() ){
		// Taxonomy custom fields
		//include_once($functions_path . 'category-meta.php');

		//tinyMCE includes
		include_once($functions_path . 'theme_shortcodes/tinymce_shortcodes.php');
		include_once($functions_path . '/add_thumbs_to_admin.php');
	}



 

    add_action('admin_init', 'blueglass_admin_JS_init_method');
	function blueglass_admin_JS_init_method() {
		global $template_url;

		wp_enqueue_script('adminjs', $template_url . '/functions/admin_js.js', 'jquery', false);
		wp_enqueue_style('adminjs', $template_url . '/functions/admin_css.css', 'jquery', false);		
	}



	//add_action( 'get_header', 'mighty_enqueue_head_scripts' );
	if ( !function_exists( 'mighty_enqueue_head_scripts' ) ) {
		function mighty_enqueue_head_scripts() {
			global $template_url;

			//wp_enqueue_style( 'fancybox', $template_url ."/css/jquery.fancybox.css", FALSE, '1.0' ); 
			//wp_enqueue_style( 'slick', $template_url ."/css/idangerous.swiper.css", FALSE, '1.0' ); 
		}
	}
	
	
	add_action('get_footer', 'blueglass_JS_init_method');
	function blueglass_JS_init_method() {
		global $template_url;

		// Load jQuery
		if ( !is_admin() ) {

			$localized_scripts = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
			//$localized_scripts['custom'] = 'variable';

			wp_enqueue_script('jquery');
	
			wp_enqueue_script('theme-foundation', $template_url.'/bower_components/foundation/js/foundation.min.js', 'jquery');
			//wp_enqueue_script('theme-mousewheel', $template_url.'/js/jquery.mousewheel-3.0.6.pack.js', 'jquery');
			//wp_enqueue_script('theme-fancybox', $template_url.'/js/jquery.fancybox.js', 'jquery');
			//wp_enqueue_script('theme-fancybox-media', $template_url.'/js/jquery.fancybox-media.js', 'jquery');

			wp_enqueue_script('theme-javascript', $template_url.'/js/app.js', 'theme-foundation');
			//wp_enqueue_script('theme-javascript-additional', $template_url.'/js/functions.js', 'theme-javascript');

			wp_localize_script('theme-javascript', 'scripts_localized', $localized_scripts );

			//wp_enqueue_script('easing', $template_url . '/js/easing.js', 'jquery', false);
			//wp_enqueue_script('theme-slides', $template_url .'/js/idangerous.swiper.js', 'jquery');
			//if( current_user_can('manage_options') ) wp_enqueue_script('theme-slides', $template_url .'/js/admin_func.js', 'slides');
		}
	}

    

	

?>