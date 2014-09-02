<?php

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

	

?>
