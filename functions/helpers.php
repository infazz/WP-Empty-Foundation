<?php 
	/*
	Theme Helper functions
	*/


	// Removes from admin bar
	function mytheme_admin_bar_render() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
	}
	//add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

	

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');



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
	
	

	function make_blog_name_from_name($name = '') {
		return get_bloginfo('name');
	}
	function make_blog_email_from_host( $email_address = null ){
		return 'noreply@' . $_SERVER['SERVER_NAME'];
	}
	add_filter('wp_mail_from_name', 'make_blog_name_from_name');
	//add_filter( 'wp_mail_from', 'make_blog_email_from_host' );
	
	

	// helps clearing get/post values
	function make_safe($variable) {
	    $variable = strip_tags(trim($variable));
	    return $variable;
	}


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
	//
	
	
		
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


	function wp_corenavi() {
	  	global $wp_query;
	  	$pages = '';
	  	$max = $wp_query->max_num_pages;
	  	if (!$current = get_query_var('paged')) $current = 1;
	  	$a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
	  	$a['total'] = $max;
	  	$a['current'] = $current;

	  	$total = 1; 
	  	$a['mid_size'] = 3; 
	  	$a['end_size'] = 1;
	  	$a['prev_text'] = '&laquo;'; 
	  	$a['next_text'] = '&raquo;'; 

	  	if ($max > 1) echo '<div class="navigation column medium-12">';
	  	if ($total == 1 && $max > 1) $pages = '<span class="pages">' . __('Page', 'blueglass') . $current . ' ' . __('of', 'blueglass') . ' ' . $max . '</span>'."\r\n";
	  	echo $pages . paginate_links($a);
	 	if ($max > 1) echo '</div>';
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