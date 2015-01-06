<?php
/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 're_custom_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 're_custom_post_meta_boxes_setup' );

/* Save post meta on the 'save_post' hook. */
add_action( 'save_post', 're_save_post_class_meta', 10, 2 );

/* Meta box setup function. */
function re_post_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 're_add_post_meta_boxes' );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function re_add_post_meta_boxes() {

  add_meta_box(
    'smashing-post-class',      // Unique ID
    esc_html__( 'Заявки' ),    // Title
    're_post_class_meta_box',   // Callback function
    'requests',         // Admin page (or post type)
    'normal',         // side, normal, advanced
    'default'         // Priority
  );
}


/* Display the post meta box. */
function re_post_class_meta_box( $object, $box ) { 

  	wp_nonce_field( basename( __FILE__ ), 're_post_class_nonce' );

  	$postArray = array(  'uniq_user', 'product', 'size', 'quantity', 'size', 'info' );

  	$meta = get_post_meta($object->ID, 're_request_meta', true); 

  	print_r($meta);
  

  
	$message .= 	'<h3>Заявка</h3>';
	$message .= 	'<table style="width: 100%; text-align: left; padding: 5px 7px;" cellspacing="0" cellpadding="5" border="0" class="">';
	$message .= 	'<tbody>';
	$message .= 	'<tr>
						<th width="55%">Товар</th>
						<th width="15%">Колличество</th>
						<th width="15%">Цена</th>
					</tr>';
	$total = 0;
	foreach($meta as $key => $product){
		if($key == '' or $key == 'promo') continue;
		// 'uniq_user', 'product', 'size', 'quantity', 'size', 'info'
		$post_id = $product['id'];

		$price = get_post_meta($key, 're_price', true);
		$weight = get_post_meta($key, 're_weight', true);
		$byweight = get_post_meta($key, 're_byweight', true);
		$instock = get_post_meta($key, 're_quantity', true);

		$quantity = $product['quantity'];

		if($byweight) { 
			$by = ' гр.';
			$instockTotal = round_down( $instock / $weight, 0 );
			$instock = round_down( $instockTotal * $weight, 0 );
			$n = $quantity / $weight;
    		$productTotal = number_format($price * $n, 2, '.', '');
    	}else{
    		$productTotal = number_format($price * $quantity, 2, '.', '');
    		$by = ' шт.';
    	}

		$total = $total + $productTotal;
		
		$message .= 	'<tr>
							<td>'.get_the_title($post_id).'</td>
							<td>'.$product['quantity'].' '.$by.'</td>
							<td>'.$productTotal.' руб.</td>
						</tr>';
	}


	

	$message .= 	'</tbody>';
	$message .= 	'</table>';
	$message .= 	'<br/>';


	if(!empty($meta)){		
		$message .= 	'<h3>Покупатель</h3>';
		$message .= 	'<table cellspacing="0" cellpadding="5" border="0" style="width: 100%; text-align: left; padding: 5px 7px;">';
		$message .= 	'<tbody>';
	
		$message .= 	'<tr><td width="25%"><strong>Имя:</strong></td><td>'. $metaContact['name'] .'</td></tr>';
		$message .= 	'<tr><td><strong>E-mail:</strong></td><td>'. $metaContact['email'] .'</td></tr>';
		$message .= 	'<tr><td><strong>Телефон:</strong></td><td>'. $metaContact['phone'] .'</td></tr>';
		$message .= 	'<tr><td><strong></strong></td><td></td></tr>';
		$message .= 	'<tr><td><strong></strong></td><td></td></tr>';
		$message .= 	'</tbody>';
		$message .= 	'</table>';
	}
	$message .= 	'<br/><br/>';

	echo $message;
}


/* Meta box setup function. */
function re_custom_post_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 're_add_post_meta_boxes' );
  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 're_save_post_class_meta', 10, 2 );
}




/* Save the meta box's post metadata. */
function re_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['re_post_class_nonce'] ) || !wp_verify_nonce( $_POST['re_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['smashing-post-class'] ) ? sanitize_html_class( $_POST['smashing-post-class'] ) : '' );

  /* Get the meta key. */
  $meta_key = 're_post_class';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}
?>