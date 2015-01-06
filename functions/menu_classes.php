<?php 


	add_action('wp_nav_menu_item_custom_fields', 'avia_menu_button_type', 10, 4);
	function avia_menu_button_type($output, $item, $depth, $args){
	        $item_id = $item->ID;
	        $key = "btn-type";
			$name  = "menu-item-".$key; //name prefix must be the same for all items
			$value = get_post_meta( $item->ID, '_'.$name, true);
	        ?>
	
	        <!-- *************** start conditional logic input fields *************** -->
	        <p class="field-avia-link-style description description-wide avia_mega_menu avia_mega_menu_d0">
				<label for="<?php echo $key; ?>">
					Тип кнопки<br />
					<select id="<?php echo $name . "-". $item_id;?>" class="widefat edit-menu-item-target" name="<?php echo $name . "[". $item_id ."]";?>">
						<option value="default-link" <?php selected( $value,  'default-link'); ?>	>Стандартная</option>
						<option value="big-and-icon" 	<?php selected( $value,  'big-and-icon'); ?>>Большая, с иконкой</option>
					</select>
				</label>
			</p>
	        
	        <?php    
	}

	add_action('wp_nav_menu_item_custom_fields', 'avia_menu_button_style', 10, 4);
	function avia_menu_button_style($output, $item, $depth, $args){
	        $item_id = $item->ID;
	        $key = "btn-icon";
			$name  = "menu-item-".$key; //name prefix must be the same for all items
			$value = get_post_meta( $item->ID, '_'.$name, true);
	        ?>
	
	        <!-- *************** start conditional logic input fields *************** -->
	        <p class="field-avia-link-style description description-wide avia_mega_menu avia_mega_menu_d0">
				<label for="<?php echo $key; ?>">
					Иконка большой кнопки<br />
					<select id="<?php echo $name . "-". $item_id;?>" class="widefat edit-menu-item-target" name="<?php echo $name . "[". $item_id ."]";?>">
						<option value="icon-phone" <?php selected( $value,  'default-submenu'); ?>	>Телефон</option>
						<option value="icon-mouse" 	<?php selected( $value,  'wide-submenu'); ?>>Курсор</option>
						<option value="icon-melody" 	<?php selected( $value,  'wide-submenu'); ?>>Мелодия</option>
					</select>
				</label>
			</p>
	        
	        <?php    
	}



	function add_classes_wpse_130358($classes, $item) {
		$style = get_post_meta($item->ID, '_menu-item-btn-icon', true);
		$type = get_post_meta($item->ID, '_menu-item-btn-type', true);
		if( $style != ''){
		  	$classes[] = $style;
		}
		if( $type != ''){
		  	$classes[] = $type;
		}
	  	return $classes;
	}
	add_filter('nav_menu_css_class','add_classes_wpse_130358',1,3);



	if ( !class_exists('JMO_Custom_Nav')) {
		class JMO_Custom_Nav {
			public function add_nav_menu_meta_boxes() {
				add_meta_box(
					'wl_login_nav_link',
					'Группа',
					array( $this, 'nav_menu_link'),
					'nav-menus',
					'side',
					'low'
				);
			}
			public function nav_menu_link() {?>
				<div id="posttype-wl-login" class="posttypediv">
					<div id="tabs-panel-wishlist-login" class="tabs-panel tabs-panel-active">
						<ul id ="wishlist-login-checklist" class="categorychecklist form-no-clear">					
							<li>
								<?php 
									$post_id = -1;
									$i = 1;
								?>
								<label class="menu-item-title2">
									<input type="checkbox" checked value="<?php echo $post_id; ?>" name="menu-item[-<?php echo $i; ?>][menu-item-object-id]" class="menu-item-checkbox"> Группа
								</label>

								<input type="hidden" value="custom" name="menu-item[-<?php echo $i; ?>][menu-item-type]" class="menu-item-type">
								<input type="hidden" value="Группа" name="menu-item[-<?php echo $i; ?>][menu-item-title]" class="menu-item-title">
								<input type="hidden" value="#" name="menu-item[-<?php echo $i; ?>][menu-item-url]" class="menu-item-url">

								<input type="hidden" value="group" name="menu-item[-<?php echo $i; ?>][menu-item-attr_title]" class="menu-item-attr_title">
								<input type="hidden" value="group" name="menu-item[-<?php echo $i; ?>][menu-item-classes]" class="menu-item-classes">
							</li>		
						</ul>
					</div>
				<p class="button-controls">
					<span class="add-to-menu">
						<input type="submit" class="button-secondary submit-add-to-menu right" value="Добавить" name="add-post-type-menu-item" id="submit-posttype-wl-login">
						<span class="spinner"></span>
					</span>
				</p>
				</div>
				<?php
			}
		}
		$custom_nav = new JMO_Custom_Nav;
		add_action('admin_init', array($custom_nav, 'add_nav_menu_meta_boxes')); 
	}
?>