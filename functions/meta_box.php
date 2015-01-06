<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */




add_filter( 'rwmb_meta_boxes', 'your_prefix_register_meta_boxes' );

function your_prefix_register_meta_boxes( $meta_boxes ){

	$prefix = 're_';

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id' => 'standard',
		'title' => __( 'Настроики', 'meta-box' ),
		'pages' => array( 'team' ),
		'context' => 'normal',
		'priority' => 'high',
		'autosave' => true,

		// List of meta fields
		'fields' => array(
			

			// TEXT
			array(
				'name'  => 'Пояснение',
				'id'    => "{$prefix}description",
				'desc'  => '',
				'type'  => 'text',
				'std'   => '',
				'clone' => false,
			),

			// TEXTAREA
			array(
				'name' => 'Описание',
				'desc' => '',
				'id' => "{$prefix}text",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
			),
			
		)	
	);



	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id' => 'standard',
		'title' => __( 'Настроики', 'meta-box' ),
		'pages' => array( 'business' ),
		'context' => 'normal',
		'priority' => 'high',
		'autosave' => true,

		// List of meta fields
		'fields' => array(
			

			// SELECT BOX
			array(
				'name'     => 'Стиль',
				'id'       => "{$prefix}class",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'blue_warm' => 'Синий (тёплый)',
					'blue_cold' => 'Синий (холодный)',
					'yellow_warm' => 'Жёлтый (тёплый)',
					'yellow_cold' => 'Жёлтый (холодный)',
					'violet' => 'Фиолетовый',
					'green_warm' => 'Зелёный (тёплый)',
					'green_cold' => 'Зелёный (холодный)',
					'red' => 'Красный',
					'gray' => 'Серый',
					'pink' => 'Розовый',
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'blue_warm',
				'placeholder' => 'Выберите цвет',
			),


			// TEXT
			array(
				'name'  => 'Пояснение',
				'id'    => "{$prefix}description",
				'desc'  => '',
				'type'  => 'text',
				'std'   => '',
				'clone' => false,
			),
			
		)	
	);


	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id' => 'box1',
		'title' => 'Контент',
		'pages' => array( 'business' ),
		'context' => 'normal',
		'priority' => 'high',
		'autosave' => true,

		// List of meta fields
		'fields' => array(

			// HEADING
			array(
				'type' => 'heading',
				'name' => 'Расшифровка видов бизнеса',
				'id'   => 'fake_id', // Not used but needed for plugin
			),
			// WYSIWYG/RICH TEXT EDITOR
			array(
				'name' => '',
				'id'   => "{$prefix}box_1",
				'type' => 'wysiwyg',
				// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
				'raw'  => false,
				'std'  => '',

				// Editor settings, see wp_editor() function: look4wp.com/wp_editor
				'options' => array(
					'textarea_rows' => 4,
					'teeny'         => false,
					'media_buttons' => true,
				),
			),
			// DIVIDER
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', // Not used, but needed
			),



			// HEADING
			array(
				'type' => 'heading',
				'name' => 'Преимущества аудиомаркетинга',
				'id'   => 'fake_id', // Not used but needed for plugin
			),
			// WYSIWYG/RICH TEXT EDITOR
			array(
				'name' => '',
				'id'   => "{$prefix}box_2",
				'type' => 'wysiwyg',
				// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
				'raw'  => false,
				'std'  => '',

				// Editor settings, see wp_editor() function: look4wp.com/wp_editor
				'options' => array(
					'textarea_rows' => 4,
					'teeny'         => false,
					'media_buttons' => true,
				),
			),
			// DIVIDER
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', // Not used, but needed
			),



			// HEADING
			array(
				'type' => 'heading',
				'name' => 'Услуги «МузКафе» по аудиомаркетингу',
				'id'   => 'fake_id', // Not used but needed for plugin
			),
			// WYSIWYG/RICH TEXT EDITOR
			array(
				'name' => '',
				'id'   => "{$prefix}box_3",
				'type' => 'wysiwyg',
				// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
				'raw'  => false,
				'std'  => '',

				// Editor settings, see wp_editor() function: look4wp.com/wp_editor
				'options' => array(
					'textarea_rows' => 4,
					'teeny'         => false,
					'media_buttons' => true,
				),
			),
			// DIVIDER
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', // Not used, but needed
			),



			// HEADING
			array(
				'type' => 'heading',
				'name' => 'ПРИМЕР АУДИО ОФОРМЛЕНИЯ',
				'id'   => 'fake_id', // Not used but needed for plugin
			),
			// FILE ADVANCED (WP 3.5+)
            array(
                'name' => 'MP3',
                'id' => "{$prefix}mp3",
                'type' => 'file_advanced',
                'max_file_uploads' => 10,
                'mime_type' => 'audio/mpeg', // Leave blank for all file types
            ),
			// DIVIDER
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', // Not used, but needed
			),



			// HEADING
			array(
				'type' => 'heading',
				'name' => 'ПРИБЛЕЗИТЕЛЬНАЯ СТОИМОСТЬ аудио оформления',
				'id'   => 'fake_id', // Not used but needed for plugin
			),

			// TEXT
			array(
				'name'  => 'От',
				'id'    => "{$prefix}price_from",
				'desc'  => '',
				'type'  => 'text',
				'std'   => '',
				'clone' => false,
			),

			// TEXT
			array(
				'name'  => 'До',
				'id'    => "{$prefix}price_till",
				'desc'  => '',
				'type'  => 'text',
				'std'   => '',
				'clone' => false,
			),


			// TEXT
			array(
				'name'  => 'Единица измерения',
				'id'    => "{$prefix}price",
				'desc'  => '',
				'type'  => 'text',
				'std'   => '',
				'clone' => false,
			),
			// WYSIWYG/RICH TEXT EDITOR
			array(
				'name' => '',
				'id'   => "{$prefix}box_4",
				'type' => 'wysiwyg',
				// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
				'raw'  => false,
				'std'  => '',

				// Editor settings, see wp_editor() function: look4wp.com/wp_editor
				'options' => array(
					'textarea_rows' => 4,
					'teeny'         => false,
					'media_buttons' => true,
				),
			),
			// DIVIDER
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', // Not used, but needed
			),
		)
	);




	// 2nd meta box
	$meta_boxes_[] = array(
		'title' => __( 'Advanced Fields', 'meta-box' ),

		'fields' => array(
			// HEADING
			array(
				'type' => 'heading',
				'name' => __( 'Heading', 'meta-box' ),
				'id'   => 'fake_id', // Not used but needed for plugin
			),
			// SLIDER
			array(
				'name' => __( 'Slider', 'meta-box' ),
				'id'   => "{$prefix}slider",
				'type' => 'slider',

				// Text labels displayed before and after value
				'prefix' => __( '$', 'meta-box' ),
				'suffix' => __( ' USD', 'meta-box' ),

				// jQuery UI slider options. See here http://api.jqueryui.com/slider/
				'js_options' => array(
					'min'   => 10,
					'max'   => 255,
					'step'  => 5,
				),
			),
			// NUMBER
			array(
				'name' => __( 'Number', 'meta-box' ),
				'id'   => "{$prefix}number",
				'type' => 'number',

				'min'  => 0,
				'step' => 5,
			),
			// DATE
			array(
				'name' => __( 'Date picker', 'meta-box' ),
				'id'   => "{$prefix}date",
				'type' => 'date',

				// jQuery date picker options. See here http://api.jqueryui.com/datepicker
				'js_options' => array(
					'appendText'      => __( '(yyyy-mm-dd)', 'meta-box' ),
					'dateFormat'      => __( 'yy-mm-dd', 'meta-box' ),
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => true,
				),
			),
			// DATETIME
			array(
				'name' => __( 'Datetime picker', 'meta-box' ),
				'id'   => $prefix . 'datetime',
				'type' => 'datetime',

				// jQuery datetime picker options.
				// For date options, see here http://api.jqueryui.com/datepicker
				// For time options, see here http://trentrichardson.com/examples/timepicker/
				'js_options' => array(
					'stepMinute'     => 15,
					'showTimepicker' => true,
				),
			),
			// TIME
			array(
				'name' => __( 'Time picker', 'meta-box' ),
				'id'   => $prefix . 'time',
				'type' => 'time',

				// jQuery datetime picker options.
				// For date options, see here http://api.jqueryui.com/datepicker
				// For time options, see here http://trentrichardson.com/examples/timepicker/
				'js_options' => array(
					'stepMinute' => 5,
					'showSecond' => true,
					'stepSecond' => 10,
				),
			),
			// COLOR
			array(
				'name' => __( 'Color picker', 'meta-box' ),
				'id'   => "{$prefix}color",
				'type' => 'color',
			),
			// CHECKBOX LIST
			array(
				'name' => __( 'Checkbox list', 'meta-box' ),
				'id'   => "{$prefix}checkbox_list",
				'type' => 'checkbox_list',
				// Options of checkboxes, in format 'value' => 'Label'
				'options' => array(
					'value1' => __( 'Label1', 'meta-box' ),
					'value2' => __( 'Label2', 'meta-box' ),
				),
			),
			// EMAIL
			array(
				'name'  => __( 'Email', 'meta-box' ),
				'id'    => "{$prefix}email",
				'desc'  => __( 'Email description', 'meta-box' ),
				'type'  => 'email',
				'std'   => 'name@email.com',
			),
			// RANGE
			array(
				'name'  => __( 'Range', 'meta-box' ),
				'id'    => "{$prefix}range",
				'desc'  => __( 'Range description', 'meta-box' ),
				'type'  => 'range',
				'min'   => 0,
				'max'   => 100,
				'step'  => 5,
				'std'   => 0,
			),
			// URL
			array(
				'name'  => __( 'URL', 'meta-box' ),
				'id'    => "{$prefix}url",
				'desc'  => __( 'URL description', 'meta-box' ),
				'type'  => 'url',
				'std'   => 'http://google.com',
			),
			// OEMBED
			array(
				'name'  => __( 'oEmbed', 'meta-box' ),
				'id'    => "{$prefix}oembed",
				'desc'  => __( 'oEmbed description', 'meta-box' ),
				'type'  => 'oembed',
			),
			// SELECT ADVANCED BOX
			array(
				'name'     => __( 'Select', 'meta-box' ),
				'id'       => "{$prefix}select_advanced",
				'type'     => 'select_advanced',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'value1' => __( 'Label1', 'meta-box' ),
					'value2' => __( 'Label2', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				// 'std'         => 'value2', // Default value, optional
				'placeholder' => __( 'Select an Item', 'meta-box' ),
			),
			// TAXONOMY
			array(
				'name'    => __( 'Taxonomy', 'meta-box' ),
				'id'      => "{$prefix}taxonomy",
				'type'    => 'taxonomy',
				'options' => array(
					// Taxonomy name
					'taxonomy' => 'category',
					// How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
					'type' => 'checkbox_list',
					// Additional arguments for get_terms() function. Optional
					'args' => array()
				),
			),
			// POST
			array(
				'name'    => __( 'Posts (Pages)', 'meta-box' ),
				'id'      => "{$prefix}pages",
				'type'    => 'post',

				// Post type
				'post_type' => 'page',
				// Field type, either 'select' or 'select_advanced' (default)
				'field_type' => 'select_advanced',
				// Query arguments (optional). No settings means get all published posts
				'query_args' => array(
					'post_status'    => 'publish',
					'posts_per_page' => - 1,
				)
			),
			// WYSIWYG/RICH TEXT EDITOR
			array(
				'name' => __( 'WYSIWYG / Rich Text Editor', 'meta-box' ),
				'id'   => "{$prefix}wysiwyg",
				'type' => 'wysiwyg',
				// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
				'raw'  => false,
				'std'  => __( 'WYSIWYG default value', 'meta-box' ),

				// Editor settings, see wp_editor() function: look4wp.com/wp_editor
				'options' => array(
					'textarea_rows' => 4,
					'teeny'         => true,
					'media_buttons' => false,
				),
			),
			// DIVIDER
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', // Not used, but needed
			),
			// FILE UPLOAD
			array(
				'name' => __( 'File Upload', 'meta-box' ),
				'id'   => "{$prefix}file",
				'type' => 'file',
			),
			// FILE ADVANCED (WP 3.5+)
			array(
				'name' => __( 'File Advanced Upload', 'meta-box' ),
				'id'   => "{$prefix}file_advanced",
				'type' => 'file_advanced',
				'max_file_uploads' => 4,
				'mime_type' => 'application,audio,video', // Leave blank for all file types
			),
			// IMAGE UPLOAD
			array(
				'name' => __( 'Image Upload', 'meta-box' ),
				'id'   => "{$prefix}image",
				'type' => 'image',
			),
			// THICKBOX IMAGE UPLOAD (WP 3.3+)
			array(
				'name' => __( 'Thickbox Image Upload', 'meta-box' ),
				'id'   => "{$prefix}thickbox",
				'type' => 'thickbox_image',
			),
			// PLUPLOAD IMAGE UPLOAD (WP 3.3+)
			array(
				'name'             => __( 'Plupload Image Upload', 'meta-box' ),
				'id'               => "{$prefix}plupload",
				'type'             => 'plupload_image',
				'max_file_uploads' => 4,
			),
			// IMAGE ADVANCED (WP 3.5+)
			array(
				'name'             => __( 'Image Advanced Upload', 'meta-box' ),
				'id'               => "{$prefix}imgadv",
				'type'             => 'image_advanced',
				'max_file_uploads' => 4,
			),
			// BUTTON
			array(
				'id'   => "{$prefix}button",
				'type' => 'button',
				'name' => ' ', // Empty name will "align" the button to all field inputs
			),

		)
	);

	return $meta_boxes;
}


