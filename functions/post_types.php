<?php
	//change the menu items label
	function change_post_menu_label() {
		global $menu;
		global $submenu;
		$menu[5][0] = 'Tooted';
		$submenu['edit.php'][5][0] = 'Tooted';
		$submenu['edit.php'][10][0] = 'Lisa toote';
		echo '';
	}
	
	function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Tooted';
        $labels->singular_name = 'Tooted';
        $labels->add_new = 'Lisa toode';
        $labels->add_new_item = 'Lisa toode';
        $labels->edit_item = 'Uuenda toode';
        $labels->new_item = 'toode';
        $labels->view_item = 'Vaata toode';
        $labels->search_items = 'Otsi';
        $labels->not_found = 'Ei teitud';
        $labels->not_found_in_trash = 'Ei teitud';
    }
    add_action( 'init', 'change_post_object_label' );
    add_action( 'admin_menu', 'change_post_menu_label' );



	function my_post_type_requests() {
		$labels = array(
			'name'               => 'Taotlused',
			'singular_name'      => 'Taotlused',
			'add_new'            => 'Lisa taotlus',
			'add_new_item'       => 'Lisa',
			'new_item'           => 'Uus',
			'edit_item'          => 'Uuenda',
			'view_item'          => 'Vaata',
			'all_items'          => 'Kõik taotlused',
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

	function my_post_type_slider() {
		register_post_type( 'slider',
		array( 
		'label' => __('Slaidid'), 
		'singular_label' => 'Slaidid',
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
			'editor',
			'thumbnail')
			) 
		);
		//register_taxonomy('posttype_category', 'portfolio', array('hierarchical' => true, 'label' => 'Posttype Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	add_action('init', 'my_post_type_slider');


	function my_post_type_clients() {
		register_post_type( 'clients',
		array( 
		'label' => __('Kliendid'), 
		'singular_label' => 'Kliendid',
		'_builtin' => false,
		'exclude_from_search' => false, // Exclude from Search Results
		'capability_type' => 'page',
		'public' => true, 
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'rewrite' => array(
		'slug' => 'clients',
		'with_front' => FALSE,
		),
		'query_var' => "clients", // This goes to the WP_Query schema
		//'menu_icon' => get_template_directory_uri() . '/images/slides.png',
		'supports' => array(
			'title',
			'editor',
			'thumbnail')
			) 
		);
		//register_taxonomy('posttype_category', 'portfolio', array('hierarchical' => true, 'label' => 'Posttype Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	add_action('init', 'my_post_type_clients');

?>
