<?php
	

	function my_post_type_requests() {
		$labels = array(
			'name'               => 'Заявки',
			'singular_name'      => 'Заявки',
			'add_new'            => 'Новая',
			'add_new_item'       => 'Добавить',
			'new_item'           => 'Новая',
			'edit_item'          => 'Обновить',
			'view_item'          => 'Просмотреть',
			'all_items'          => 'Все заявки',
		);
		register_post_type( 'requests',
		array( 
			'labels' => $labels,
			'menu_position' => 2,
			'_builtin' => false,
			'exclude_from_search' => true, // Exclude from Search Results
			'capability_type' => 'page',
			'public' => true, 
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'rewrite' => array(
			'slug' => 'zakaz',
			'with_front' => FALSE,
			),
			'query_var' => "requests", // This goes to the WP_Query schema
			//'menu_icon' => get_template_directory_uri() . '/i/clipboard.png',
			'supports' => array(
				'title'
				)
			) 
		);
		//register_taxonomy('posttype_category', 'portfolio', array('hierarchical' => true, 'label' => 'Posttype Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	add_action('init', 'my_post_type_requests');





	function my_post_type_team() {
		register_post_type( 'team',
			array( 
			'label' => 'Команда', 
			'singular_label' => 'Команда',
			'_builtin' => false,
			'exclude_from_search' => true, // Exclude from Search Results
			'capability_type' => 'page',
			'public' => true, 
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'rewrite' => array(
			'slug' => 'team',
			'with_front' => FALSE,
			),
			'query_var' => "team", // This goes to the WP_Query schema
			//'menu_icon' => get_template_directory_uri() . '/images/slides.png',
			'supports' => array(
				'title',
				'thumbnail'
				)
			) 
		);
		//register_taxonomy('posttype_category', 'portfolio', array('hierarchical' => true, 'label' => 'Posttype Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	add_action('init', 'my_post_type_team');





	function my_post_type_slider() {
		register_post_type( 'slider',
		array( 
		'label' => 'Слайдер', 
		'singular_label' => 'Слайдер',
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
		'query_var' => "slider", // This goes to the WP_Query schema
		//'menu_icon' => get_template_directory_uri() . '/images/slides.png',
		'supports' => array(
			'title',
			'editor',
			)
			) 
		);
		//register_taxonomy('posttype_category', 'portfolio', array('hierarchical' => true, 'label' => 'Posttype Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	add_action('init', 'my_post_type_slider');


	function my_post_type_business() {
		register_post_type( 'business',
		array( 
		'label' => 'Индустрии', 
		'singular_label' => 'Индустрии',
		'_builtin' => false,
		'exclude_from_search' => false, // Exclude from Search Results
		'capability_type' => 'page',
		'public' => true, 
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'rewrite' => array(
		'slug' => 'business',
		'with_front' => FALSE,
		),
		'query_var' => "business", // This goes to the WP_Query schema
		//'menu_icon' => get_template_directory_uri() . '/images/slides.png',
		'supports' => array(
			'title',
			//'editor',
			'thumbnail')
			) 
		);
		//register_taxonomy('posttype_category', 'portfolio', array('hierarchical' => true, 'label' => 'Posttype Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	add_action('init', 'my_post_type_business');




	function my_post_type_client() {
		register_post_type( 'client',
		array( 
		'label' => 'Клиенты', 
		'singular_label' => 'Клиенты',
		'_builtin' => false,
		'exclude_from_search' => false, // Exclude from Search Results
		'capability_type' => 'page',
		'public' => true, 
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'rewrite' => array(
		'slug' => 'client',
		'with_front' => FALSE,
		),
		'query_var' => "client", // This goes to the WP_Query schema
		//'menu_icon' => get_template_directory_uri() . '/images/slides.png',
		'supports' => array(
			'title',
			'editor',
			'thumbnail')
			) 
		);
		//register_taxonomy('posttype_category', 'portfolio', array('hierarchical' => true, 'label' => 'Posttype Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	add_action('init', 'my_post_type_client');
?>
