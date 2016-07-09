<?php
	

	function my_post_type_team() {
		$labels = array(
			'name'               => 'Team',
			'singular_name'      => 'Team Member',
			'add_new'            => 'Add Memeber',
			'add_new_item'       => 'Add New Memeber',
			'new_item'           => 'New',
			'edit_item'          => 'Update memeber',
			'view_item'          => 'View member',
			'all_items'          => 'All members',
		);
		register_post_type( 'team',
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
			'slug' => 'team',
			'with_front' => FALSE,
			),
			'query_var' => "team", // This goes to the WP_Query schema
			//'menu_icon' => get_template_directory_uri() . '/i/icon.png',
			'supports' => array(
				'title',
				'editor',
				'thumbnail'
				)
			) 
		);
		//register_taxonomy('team_category', 'team', array('hierarchical' => true, 'label' => 'Team Categories', 'singular_name' => 'Category', "rewrite" => true, "query_var" => true));
	}

	//add_action('init', 'my_post_type_team');



?>
