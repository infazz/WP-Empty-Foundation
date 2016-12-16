<?php  
	/*
	Theme Ajax functions
	*/


	// Ajax example

	add_action('wp_ajax_re_update_guru', 're_update_guru');
	add_action('wp_ajax_nopriv_re_update_guru', 're_update_guru' );
	
	function re_update_guru() {
		unset( $_POST['action'] );

		if( isset($_POST['step-1']) and isset($_POST['step-6']) ){

			
			echo 'ok';
		}else{
			echo 'not ok';
		}
		die();
	}

?>