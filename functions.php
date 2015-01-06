<?php

	$functions_path = TEMPLATEPATH . '/functions/';	
	require_once ( TEMPLATEPATH . '/options/options.php' );

	if(function_exists('qtrans_getSortedLanguages')){
		$lang_arr = qtrans_getSortedLanguages();	
	}else{
		$lang_arr = array('ru');	
	}

	
	//Category meta
	//include_once($functions_path . 'category_meta.php');

	function clearPost($POST){
		foreach($POST as $key => $value){
		   $_POST[$key] = strip_tags($value);
		  }
	}
	

	add_action( 'after_setup_theme', 're_setup_template' );
	function re_setup_template(){
		add_theme_support( 'post-thumbnails' );
		
		add_image_size( 'tiny', 78, 81, true );
		add_image_size( 'thumb', 456, 424, true );

		add_image_size( 'client', 415, 130, true );
		add_image_size( 'client_square', 415, 415, true );

		add_image_size( 'slider', 542, 542, true );

		register_nav_menus( array( 'footer-menu' => __( 'Нижнее меню', 'rebrand')  ) );
		register_nav_menus( array( 'top-menu' => __( 'Верхнее меню', 'rebrand')  ) );
	}


	// Ajax cart update
	add_action('wp_ajax_re_update_guru', 're_update_guru');
	add_action('wp_ajax_nopriv_re_update_guru', 're_update_guru' );
	function re_update_guru() {
		unset( $_POST['action'] );

		if( isset($_POST['step-1']) and isset($_POST['step-6']) ){

			$post_title = 'временная заявка - ' . current_time('d.m.Y H:i:s');
			$postarray = array(
			  'post_content'   => '',
			  'post_name'      => sanitize_title($post_title),
			  'post_title'     => $post_title,
			  'post_status'    => 'draft',
			  'post_type'      => 'requests',
			  'ping_status'    => 'closed',
			  'comment_status' => 'closed'
			);

			$post_id = wp_insert_post( $postarray );
			
			$meta = array();
			
			foreach ($_POST as $key => $value) {
				$vopros = '';
				if( $key == 'step-1') $vopros = 'Сфера бизнеса';
				if( $key == 'step-2') $vopros = 'Заказ';
				if( $key == 'step-3') $vopros = 'Юридическая помощь';
				if( $key == 'step-4') $vopros = 'Фон для';
				if( $key == 'step-5') $vopros = 'Установка оборудования';
				if( $key == 'step-6') $vopros = 'Пользовались раньше';
				if( $key == 'step-7') $vopros = 'Пожелания';

				$strip_value = array();
				foreach($value as $keys => $val){
				   $strip_value[$keys] = strip_tags( strval($val) );
				}

				$meta[ $key ] = array(
					'vopros' => $vopros,
					'otvet' => $strip_value
				);

				//print_r( $strip_value );
			}

			update_post_meta($post_id, 're_request_meta', $meta);

			//print_r( $strip_value );
			echo $post_id;
		}else{
			echo 'not ok';
		}
		die();
	}


	//re_save_guru
	add_action('wp_ajax_re_save_guru', 're_save_guru');
	add_action('wp_ajax_nopriv_re_save_guru', 're_save_guru' );
	function re_save_guru() {

		if( isset($_POST['id']) and $_POST['id'] != '' and isset($_POST['any']) and $_POST['any'] != '' ){
			$id = strip_tags( make_safe($_POST['id']) );
			$any = strip_tags( make_safe($_POST['any']) );
			$name = strip_tags( make_safe($_POST['name']) );

			$meta = get_post_meta($id, 're_request_meta', true);

			$meta['client'] = array(
									'name' => $name,
									'contact' => $any
								);

			update_post_meta($id, 're_request_meta', $meta);

			$post_title = $name . ' - заявка '.$id.' - ' . current_time('d.m.Y H:i:s');
			wp_update_post(
			        array (
			          'ID'          => $id, 
			          'post_title'  => $post_title,
			          'post_name'	=> sanitize_title($post_title),
			          'post_status' => 'pending'
			));

			//print_r( $meta );
			$noreply = 'noreply@' . $_SERVER['SERVER_NAME'];

			$headers = "From: ".$noreply."\r\n";
			$headers .= "Reply-To: ".$noreply."\r\n";
			$headers .= "Return-Path: ".$noreply."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			if( wp_mail(__t('email'), 'Новая заявка!', newOrderMessage($id, $meta, true), $headers, '-f ' . $noreply ) ){
				echo 'ok';
			}else{
				echo 'problem';
			}

		}else{
			echo 'not ok';
		}
		die();
	}



	function newOrderMessage($order_id, $meta, $toadmin = true){

		$client = $meta['client'];
		unset($meta['client']);

		
		$message = "<html><body>";
		
		$message .= '<table style="width: 600px; text-align: left; padding: 5px 7px; margin: 0 auto;" cellspacing="0" cellpadding="5" border="0" class="">';
		$message .= '<tbody>';
		
		$message .= '<tr>
						<th style="background-color: #ffffff; text-align: left;"><img style="margin: 10px;" src="http://project.rebrand.ee/muzcafe/wp-content/themes/muzcafe/i/logo.png" alt="МузКафе" width="180" /></th>
					</tr>';
				
		if( $toadmin ){		
			/*
			$message .= '<tr>';
				$message .= '<td>';	
					$message .= 	'<a href="http://bigmeat.ru/wp-admin/post.php?post='.$order_id.'&action=edit">Открыть заказ на сайте.</a>';
			
				$message .= '</td>';	
			$message .= '</tr>';
			*/
		}else{
			$message .= '<tr>';
				$message .= '<td>';	
				$message .= '<br/>';	
				$message .= 	apply_filters('the_content', __t('order_thanks'));
				
				$message .= '</td>';	
			$message .= '</tr>';
		}
		
		$message .= 	'</tbody>';
		$message .= 	'</table>';
			
			$message .= 	'<table style="width: 600px; margin: 0 auto; text-align: left; padding: 5px 7px;" cellspacing="0" cellpadding="5" border="0" class="">';
			$message .= 	'<tbody>';
			$message .= 	'<tr><th>';
				$message .= 	'<h3 style="color: #c81e46;">'. __('Заявка:', 'Cart') .' '.$order_id.'</h3>';
			$message .= 	'</th></tr>';
			$message .= 	'</tbody>';
			$message .= 	'</table>';
			
			
			$message .= 	'<table style="width: 600px; margin: 0 auto; text-align: left; padding: 5px 7px;" cellspacing="0" cellpadding="5" border="0" class="">';
			$message .= 	'<tbody>';
			$message .= 	'<tr>
								<th width="35%">Вопрос</th>
								<th width="65%">Ответ</th>
							</tr>';
			$c = 0;
			foreach($meta as $key => $met){
				$message .= '<tr>';
					$message .= '<td style="border-bottom: 1px dashed #ddd;">'.$met['vopros'].'</td>';
					$message .= '<td style="border-bottom: 1px dashed #ddd;">';
					foreach ($met['otvet'] as $key => $value) {
						$message .= $value . '<br>';
					}
					$message .= '</td>';
				$message .= '</tr>';
			}
		
			$message .= 	'<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>';
			
			$message .= 	'</tbody>';
			$message .= 	'</table>';
			$message .= 	'<br/>';
		
		
			if(!empty($client)){
				
				$message .= 	'<table style="width: 600px; margin: 0 auto; text-align: left; padding: 5px 7px;" cellspacing="0" cellpadding="5" border="0" class="">';
				$message .= 	'<tbody>';
				$message .= 	'<tr><th>';
					if( $toadmin ){
						$message .= 	'<h3 style="color: #c81e46;">Клиент</h3>';
					}else{
						$message .= 	'<h3 style="color: #c81e46;">Ваши контактные данные</h3>';
					}
				$message .= 	'</th></tr>';
				$message .= 	'</tbody>';
				$message .= 	'</table>';
				
				
				$message .= 	'<table cellspacing="0" cellpadding="5" border="0" style="width: 600px; margin: 0 auto; text-align: left; padding: 5px 7px;">';
				$message .= 	'<tbody>';
			
				$message .= 	'<tr><td width="25%"><strong>Имя:</strong></td><td>'. $client['name'] .'</td></tr>';
				$message .= 	'<tr><td><strong>Контакт:</strong></td><td>'. $client['contact'] .'</td></tr>';
				$message .= 	'<tr><td><strong></strong></td><td></td></tr>';
				$message .= 	'<tr><td><strong></strong></td><td></td></tr>';
				$message .= 	'</tbody>';
				$message .= 	'</table>';
			}
		
		$message .= "</body></html>";
		
		return $message;
	}




    if (function_exists('register_sidebar')) {
		
		foreach($lang_arr as $lang){
			register_sidebar(array(
	    		'name' => __('('.$lang.') Homepage Widgets','html5reset' ),
	    		'id'   => 'sidebar-widgets-'.$lang,
	    		'description'   => __( 'These are widgets for the homepage.','html5reset' ),
	    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    		'after_widget'  => '</div>',
	    		'before_title'  => '<h2>',
	    		'after_title'   => '</h2>'
	    	));
		}

    }

    add_action('admin_init', 'rebrand_admin_JS_init_method');
	function rebrand_admin_JS_init_method() {

		wp_enqueue_script('adminjs', get_template_directory_uri() . '/functions/admin_js.js', 'jquery', false);
		wp_enqueue_style('adminjs', get_template_directory_uri() . '/functions/admin_css.css', 'jquery', false);
		
	}

	function cc_mime_types($mimes) {
	  $mimes['svg'] = 'image/svg+xml';
	  return $mimes;
	}
	add_filter('upload_mimes', 'cc_mime_types');

	function fix_svg_thumb_display() {
	  echo '
	    td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { 
	      width: 100% !important; 
	      height: auto !important; 
	    }
	  ';
	}
	//add_action('admin_head', 'fix_svg_thumb_display');

	
	// Add RSS links to <head> section
	automatic_feed_links();

	//Posttypes
	include_once($functions_path . 'post_types.php');

	//Meta boxes
	include_once($functions_path . 'meta_box.php');
	include_once($functions_path . 'meta_box_better.php');
	include_once($functions_path . 'order_meta.php');


	//Meta boxes
	include_once($functions_path . 'menu_classes.php');
	
	
	//Shortcodes
	require_once $functions_path . 'theme_shortcodes/shortcodes.php';
	//include_once($functions_path . 'theme_shortcodes/alert.php');
	include_once($functions_path . 'theme_shortcodes/tabs.php');
	include_once($functions_path . 'theme_shortcodes/toggle.php');
	//include_once($functions_path . 'theme_shortcodes/html.php');

	//tinyMCE includes
	include_once($functions_path . 'theme_shortcodes/tinymce_shortcodes.php');
	
	
	function make_blog_name_from_name($name = '') {
		return get_bloginfo('name');
	}
	function make_blog_email_from_host( $email_address = null ){
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
			wp_enqueue_style( 'fancybox', get_bloginfo('template_url')."/css/jquery.fancybox.css", FALSE, '1.0' ); 
			wp_enqueue_style( 'slick', get_bloginfo('template_url')."/css/idangerous.swiper.css", FALSE, '1.0' ); 
		}
	}
	
	
	add_action('get_footer', 'rebrand_JS_init_method');
	function rebrand_JS_init_method() {
		// Load jQuery
		if ( !is_admin() ) {
			wp_enqueue_script('jquery');
			
				
			wp_enqueue_script('easing', get_template_directory_uri() . '/js/easing.js', 'jquery', false);
			wp_enqueue_script('theme-slides', get_bloginfo('template_url').'/js/idangerous.swiper.js', 'jquery');
			
			
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

    
    //add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video')); // Add 3.1 post format theme support.


	
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
	//add_filter('get_pagenum_link', 'qtranslate_next_previous_fix');

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

	function _t($val){
		$txt = get_option( 're_opt' ); 
		if( function_exists('qtrans_getLanguage')){
			$lang = qtrans_getLanguage();
		}else{
			$lang = 'ru';
		}
		//use  
		echo $txt[$val.'_'.$lang];
	}

	function __t($val){
		$txt = get_option( 're_opt' ); 
		if( function_exists('qtrans_getLanguage')){
			$lang = qtrans_getLanguage();
		}else{
			$lang = 'ru';
		}
		//use  
		return $txt[$val.'_'.$lang];
	}



	add_filter( 'gettext', 'theme_gettext_fields', 20, 3 );
	function theme_gettext_fields( $translated_text, $text, $domain ) {
		//if(is_admin()) return $translated_text;

		$newtext = __t( sanitize_title($text) );
		if( !empty($newtext) and $newtext != $text ) $translated_text = $newtext;

   	 	return $translated_text;
	}

	if (function_exists('qtrans_getLanguage')) {
		add_action( 'admin_init', 'fix_nav_menu' );
		function fix_nav_menu() {
			global $pagenow;
			
			if( $pagenow != 'nav-menus.php' ) return;
			wp_enqueue_script( 'nav-menu-query',  get_template_directory_uri() . '/functions/qts_nav_fix.js' , 'nav-menu', '1.0' );
			add_meta_box( 'qt-languages', __('Languages'), 'nav_menu_meta_box', 'nav-menus', 'side', 'default' );
		}
		/**
		 * draws meta box for select language
		 * 
		 * @since 1.0
		 */
		function nav_menu_meta_box() {
			global $q_config;
			echo '<p>';
			foreach($q_config['enabled_languages'] as $id => $language) {
				$checked = ($language == $q_config['language']) ? ' checked="checked"' : '';
				echo '<p style="margin:0 0 5px 0"><input type="radio" style="margin-right:5px" name="wa_qt_lang" value="' . $language . '" id="wa_gt_lang_' . $id . '" ' . $checked . '/>';
				echo '<label for="wa_gt_lang_' . $id . '">';
				echo '<img src="' . trailingslashit(WP_CONTENT_URL).$q_config['flag_location'].$q_config['flag'][$language] . '"/>&nbsp;';
				echo __($q_config['language_name'][$language], 'qtranslate');
				echo '</label></p>';
			}
			echo '</p>';
		}
	}



	// Ajax search posts
	add_action('wp_ajax_searh_get_posts', 'searh_get_posts');
	function searh_get_posts() {
		if ( !empty($_POST['value']) ) {

			$value = strip_tags($_POST['value']);

			add_filter( 'posts_search', 'ni_search_by_title_only', 500, 2 );
			$query = new WP_Query( 's='.$value );
			remove_filter( 'posts_search', 'ni_search_by_title_only');

			if ( $query->have_posts() ) {
				//echo '<ul>';
				while ( $query->have_posts() ) {
					$query->the_post();
					echo '<li><a href="'.get_permalink($query->post->ID).'">' . get_the_title($query->post->ID) . '</a></li>';
				}
				//echo '</ul>';
			} else {
				echo 'noposts';
			}
			wp_reset_postdata();
			
			die();
		} else {
			die();
		}
	}

	function ni_search_by_title_only( $search, &$wp_query ){
	    global $wpdb;
	    if ( empty( $search ) )
	        return $search; // skip processing - no search term in query
	    $q = $wp_query->query_vars;
	    $n = ! empty( $q['exact'] ) ? '' : '%';
	    $search =
	    $searchand = '';
	    foreach ( (array) $q['search_terms'] as $term ) {
	        $term = esc_sql( like_escape( $term ) );
	        $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
	        $searchand = ' AND ';
	    }
	    if ( ! empty( $search ) ) {
	        $search = " AND ({$search}) ";
	        if ( ! is_user_logged_in() )
	            $search .= " AND ($wpdb->posts.post_password = '') ";
	    }
	    return $search;
	}
	
?>