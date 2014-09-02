<?php
	$functions_path = TEMPLATEPATH . '/functions/';	
	require_once ( TEMPLATEPATH . '/options/options.php' );
	

	add_action( 'after_setup_theme', 're_setup_template' );
	function re_setup_template(){
		add_theme_support( 'post-thumbnails' );
		
		add_image_size( 'tiny', 80, 50, $crop );
		add_image_size( 'thumb', 200, 200, $crop );
		add_image_size( 'preview', 765, 505, $crop );

		register_nav_menus( array( 'top-menu' => __( 'Top Menu', 'desadent' ) ) );
	}
	
	// Add RSS links to <head> section
	automatic_feed_links();
	
	//Shortcodes
	require_once $functions_path . 'theme_shortcodes/shortcodes.php';
	include_once($functions_path . 'theme_shortcodes/alert.php');
	include_once($functions_path . 'theme_shortcodes/tabs.php');
	include_once($functions_path . 'theme_shortcodes/toggle.php');
	include_once($functions_path . 'theme_shortcodes/html.php');

	//tinyMCE includes
	include_once($functions_path . 'theme_shortcodes/tinymce/tinymce_shortcodes.php');
	
	
	function make_blog_name_from_name($name = '') {
		return get_bloginfo('name');
	}
	function make_blog_email_from_host( $email_address ){
		return 'noreply@' . $_SERVER['SERVER_NAME'];
	}
	add_filter('wp_mail_from_name', 'make_blog_name_from_name');
	add_filter( 'wp_mail_from', 'make_blog_email_from_host' );
	
	
	function make_safe($variable) {
	    $variable = mysql_real_escape_string(trim($variable));
	    return $variable;
	}


	add_action( 'get_header', 'mighty_enqueue_head_scripts' );
	if ( !function_exists( 'mighty_enqueue_head_scripts' ) ) {
		function mighty_enqueue_head_scripts() {
			wp_enqueue_style( 'fancybox', get_bloginfo('template_url')."/stylesheets/jquery.fancybox.css", FALSE, '1.0' ); 
		
		}
	}
	
	
	add_action('get_footer', 'rebrand_JS_init_method');
	function rebrand_JS_init_method() {
		// Load jQuery
		if ( !is_admin() ) {
			wp_enqueue_script('jquery');
			
				
			wp_enqueue_script('easing', get_template_directory_uri() . '/js/easing.js', 'jquery', false);
			wp_enqueue_script('theme-slides', get_bloginfo('template_url').'/js/slides.js', 'slides');
			
			//if( current_user_can('manage_options') ) wp_enqueue_script('theme-slides', get_bloginfo('template_url').'/js/admin_func.js', 'slides');
		}
	}




	// Removes from admin bar
	function mytheme_admin_bar_render() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
	}
	//add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
	
	
	
	// Apply parent template to all subpages
	add_action('template_redirect','switch_page_template');
	function switch_page_template() {
		global $post;
		// Checks if current post type is a page, rather than a post
		if (is_page()){	
			$ancestors = $post->ancestors;

			if ($ancestors) {
				$current_page_template = get_post_meta($post->ID,'_wp_page_template',true);
				$parent_page_template = get_post_meta(end($ancestors),'_wp_page_template',true);
				$template = TEMPLATEPATH . "/{$parent_page_template}";
				
				//print_r($current_page_template);
				if (file_exists($template)) {
					if( $current_page_template == 'default' ){
						load_template($template);
						exit;
					} else {
						return true;
					}
				}
			} else {
				return true;
			}
		
		}
	}
	/////////////////
	
	add_filter('mce_css', 'tuts_mcekit_editor_style');  
	function tuts_mcekit_editor_style($url) {  
	  
		if ( !empty($url) )  
			$url .= ',';  
	  
		// Retrieves the plugin directory URL and adds editor stylesheet  
		// Change the path here if using different directories  
		$url .= get_template_directory_uri() . '/editor.css';  
	  
		return $url;  
	}  

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => __('Sidebar Widgets','html5reset' ),
    		'id'   => 'sidebar-widgets',
    		'description'   => __( 'These are widgets for the sidebar.','html5reset' ),
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }
    
    //add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video')); // Add 3.1 post format theme support.

	//require_once ($functions_path . 'customs.php');

	/* Slider */
	function my_post_type_slider() {
		register_post_type( 'slider',
		array( 
		'label' => __('Slides'), 
		'singular_label' => 'Slides',
		'_builtin' => false,
		'exclude_from_search' => true, // Exclude from Search Results
		'capability_type' => 'page',
		'public' => true, 
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'rewrite' => array(
		'slug' => 'slide-view',
		'with_front' => FALSE,
		),
		'query_var' => "slide", // This goes to the WP_Query schema
		//'menu_icon' => get_template_directory_uri() . '/images/slides.png',
		'supports' => array(
			'title',
			'custom-fields',
			'excerpt',
			'editor',
			'thumbnail')
			) 
		);
		//register_taxonomy('posttype_category', 'portfolio', array('hierarchical' => true, 'label' => 'Posttype Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	add_action('init', 'my_post_type_slider');
	
	
	// Show filter by categories for custom posts
	function my_restrict_manage_posts() {
		global $typenow;
		$args=array( 'public' => true, '_builtin' => false ); 
		$post_types = get_post_types($args);
		if ( in_array($typenow, $post_types) ) {
		$filters = get_object_taxonomies($typenow);
			foreach ($filters as $tax_slug) {
				$tax_obj = get_taxonomy($tax_slug);
				wp_dropdown_categories(array(
					'show_option_all' => __('Show All '.$tax_obj->label ),
					'taxonomy' => $tax_slug,
					'name' => $tax_obj->name,
					'orderby' => 'term_order',
					'selected' => $_GET[$tax_obj->query_var],
					'hierarchical' => $tax_obj->hierarchical,
					'show_count' => false,
					'hide_empty' => true
				));
			}
		}
	}
	function my_convert_restrict($query) {
		global $pagenow;
		global $typenow;
		if ($pagenow=='edit.php') {
			$filters = get_object_taxonomies($typenow);
			foreach ($filters as $tax_slug) {
				$var = &$query->query_vars[$tax_slug];
				if ( isset($var) ) {
					$term = get_term_by('id',$var,$tax_slug);
					$var = $term->slug;
				}
			}
		}
	}
	add_action('restrict_manage_posts', 'my_restrict_manage_posts' );
	add_filter('parse_query','my_convert_restrict');
	
	
	
	include_once($functions_path . '/add_thumbs_to_admin.php');
	
		
	// Fix for qTranslate plugin and "Home" menu link reverting back to default language

	if (function_exists('qtrans_convertURL')) {
		function qtrans_in_nav_el($output, $item, $depth, $args) {
			$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
			$attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
			$attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';

			// Integration with qTranslate Plugin
			$attributes .=!empty($item->url) ? ' href="' . esc_attr( qtrans_convertURL($item->url) ) . '"' : '';

			$output = $args->before;
			$output .= '<a' . $attributes . '>';
			$output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
			$output .= '</a>';
			$output .= $args->after;

			return $output;
		}

		add_filter('walker_nav_menu_start_el', 'qtrans_in_nav_el', 10, 4);
	}
	
	
		
	// text trimmer
	function wpwr_trimmer($mytitle, $length){	
		if ( mb_strlen($mytitle) >$length ){
			$mytitle = mb_substr( $mytitle,0,$length);
			return $mytitle . '...';
		}else{
			return $mytitle;
		}
	}
	
	function wpwr_extrimmer($mytitle, $length){	
		if ( mb_strlen($mytitle) >$length ){
			$mytitle = mb_substr( $mytitle,0,$length);
			return $mytitle . '... <img src="'. get_bloginfo('template_directory') .'/i/arrow2.png" alt=""/>';
		}else{
			return $mytitle;
		}
	} 
	
	
	#
	# Function to return post featured image or first image in post
	#
	function get_that_image_url( $postid, $imagesize = 'large'){
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), $imagesize, false, '' );
		if( $img[0] == '' ){
			$img = catch_that_image();
		}else{
			$img = $img[0];
		}
		return $img;
	}
	
	
	function catch_that_image() {
	  global $post, $posts;
	  $first_img = '';
	  ob_start();
	  ob_end_clean();
	  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	  $first_img = $matches [1] [0];

	  if(empty($first_img)){ //Defines a default image
		$first_img = get_bloginfo('tmplate_url') . "/i/default.jpg";
	  }
	  return $first_img;
	}
	
	
	function RE_pagination($pages = '', $range = 999)
	{ 
	
		global $paged; if(empty($paged)) $paged = 1;
		if($pages == ''){
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages){ $pages = 1; }
		}
		if(1 != $pages){
			echo "<div class='pagination'>";
				if($paged > 1 && $showitems < $pages) echo "<a  href='".get_pagenum_link($paged - 1)."' class='page-numbers'>&lsaquo;</a>";
				
				for ($i=1; $i <= $pages; $i++){
					
					if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
					echo ($paged == $i)? "<span class='page-numbers'><span class='current'>".$i."</span></span>":"<a  href='".get_pagenum_link($i)."' class='page-numbers'>".$i."</a>";
					}
				}
				if ($paged < $pages && $showitems < $pages) echo "<a  href='".get_pagenum_link($paged + 1)."' class='page-numbers'>&rsaquo;</a>";
		   
			echo "</div>";
		}
	 }
	add_filter('get_pagenum_link', 'qtranslate_next_previous_fix');

	function qtranslate_next_previous_fix($url) {
		$aUrl = explode("/".qtrans_getLanguage(),$url);
		if (isset($aUrl[1]))
			$url=qtrans_convertURL($aUrl[1]);
		return $url;
	}
	
	

	//add_filter( 'gettext', 'theme_change_fields', 20, 3 );
	function theme_change_fields( $translated_text, $text, $domain ) {
		$lang = qtrans_getLanguage();
		switch ( $translated_text ) {
	
			case 'Some text' :
	
				$translated_text = __( 'First Name ', 'theme_text_domain' ) . $lang;
				break;
	
			case 'Email' :
	
				$translated_text = __( 'Email Address', 'theme_text_domain' );
				break;
		}
	
	
		return $translated_text;
	}
?>