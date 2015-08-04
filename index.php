<?php get_header(); ?>

<div id="slides">
	<?php 
		$args = array(
				'post_type' => 'slider',
				'posts_per_page' => -1
					  );
		$slides = new WP_Query($args);
		
		if ($slides->have_posts()) : while ($slides->have_posts()) : $slides->the_post();
			$linkID = get_post_meta($slides->post->ID, 're_post', true);
			$linkURL = get_post_meta($slides->post->ID, 're_link', true);

			$thumb_id = get_post_thumbnail_id( $slides->post->ID );
			
			$src1 = wp_get_attachment_image_src( $thumb_id, 'slider' );
			$src2 = wp_get_attachment_image_src( $thumb_id, 'slider_cropped' );
			
			echo '<div class="slide">';
				echo '<div class="wrap">';
					echo '<div class="row">';
						echo '<div class="column medium-7">';
							echo get_the_content( $slides->post->ID );
						echo '</div>';
					echo '</div>';
				echo '</div>';
				
				if(!empty($linkURL)) echo '<a href="'.get_permalink($linkURL).'">';
					echo '<img data-interchange="['.$src2[0].', (default)], ['.$src1[0].', (large)]">';
				if(!empty($linkURL)) echo '</a>';
			echo '</div>';
			
		endwhile; endif;
	?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
