<?php

class novafwLikes {

    function __construct() {	
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        add_action('publish_post', array(&$this, 'setup_likes'));
        add_action('wp_ajax_novafw-likes', array(&$this, 'ajax_callback'));
		add_action('wp_ajax_nopriv_novafw-likes', array(&$this, 'ajax_callback'));
        add_shortcode('novafw_likes', array(&$this, 'shortcode'));
	}
	
	function enqueue_scripts(){
	    $options = get_option( 'novafw_likes_settings' );
		if( !isset($options['disable_css']) ) $options['disable_css'] = '0';
		
		if(!$options['disable_css']) wp_enqueue_style( 'novafw-likes', plugins_url( '/styles/novafw-likes.css', __FILE__ ) );
		
		wp_enqueue_script( 'novafw-likes', plugins_url( '/scripts/novafw-likes.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'jquery' );
		
		wp_localize_script('novafw-likes', 'novafw', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
        
		wp_localize_script( 'novafw-likes', 'novafw_likes', array('ajaxurl' => admin_url('admin-ajax.php')) );
	}
	
	function setup_likes( $post_id ) {
		if(!is_numeric($post_id)) return;
	
		add_post_meta($post_id, '_novafw_likes', '0', true);
	}
	
	function ajax_callback($post_id){

		$options = get_option( 'novafw_likes_settings' );
		if( !isset($options['add_to_posts']) ) $options['add_to_posts'] = '0';
		if( !isset($options['add_to_pages']) ) $options['add_to_pages'] = '0';
		if( !isset($options['add_to_other']) ) $options['add_to_other'] = '0';
		if( !isset($options['zero_postfix']) ) $options['zero_postfix'] = '';
		if( !isset($options['one_postfix']) ) $options['one_postfix'] = '';
		if( !isset($options['more_postfix']) ) $options['more_postfix'] = '';

		if( isset($_POST['likes_id']) ) {
		    // Click event. Get and Update Count
			$post_id = str_replace('novafw-likes-', '', $_POST['likes_id']);
			echo $this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'update');
		} else {
		    // AJAXing data in. Get Count
			$post_id = str_replace('novafw-likes-', '', $_POST['post_id']);
			echo $this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'get');
		}
		
		exit;
	}
	
	function like_this($post_id, $zero_postfix = false, $one_postfix = false, $more_postfix = false, $action = 'get'){
		if(!is_numeric($post_id)) return;
		$zero_postfix = strip_tags($zero_postfix);
		$one_postfix = strip_tags($one_postfix);
		$more_postfix = strip_tags($more_postfix);		
		
		switch($action) {
		
			case 'get':
				$likes = get_post_meta($post_id, '_novafw_likes', true);
				if( !$likes ){
					$likes = 0;
					add_post_meta($post_id, '_novafw_likes', $likes, true);
				}
				
				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }
				
				return '<span class="novafw-likes-count">'. $likes .'</span> <span class="novafw-likes-postfix">'. $postfix .'</span>';
				break;
				
			case 'update':
				$likes = get_post_meta($post_id, '_novafw_likes', true);
				if( isset($_COOKIE['novafw_likes_'. $post_id]) ) return $likes;
				
				$likes++;
				update_post_meta($post_id, '_novafw_likes', $likes);
				setcookie('novafw_likes_'. $post_id, $post_id, time()*20, '/');
				
				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }
				
				return '<span class="novafw-likes-count">'. $likes .'</span> <span class="novafw-likes-postfix">'. $postfix .'</span>';
				break;
		
		}
	}
	
	function shortcode( $atts ){
		extract( shortcode_atts( array(
		), $atts ) );
		
		return $this->do_likes();
	}
	
	function do_likes(){
		global $post;

        $options = get_option( 'novafw_likes_settings' );
		if( !isset($options['zero_postfix']) ) $options['zero_postfix'] = '';
		if( !isset($options['one_postfix']) ) $options['one_postfix'] = '';
		if( !isset($options['more_postfix']) ) $options['more_postfix'] = '';
		
		$output = $this->like_this($post->ID, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix']);
  
  		$class = 'novafw-likes';
  		$title = __('Like this', 'novafw');
		if( isset($_COOKIE['novafw_likes_'. $post->ID]) ){
			$class = 'novafw-likes active';
			$title = __('You already like this', 'novafw');
		}
		
		return '<a href="#" class="'. $class .'" id="novafw-likes-'. $post->ID .'" title="'. $title .'">'. $output .'</a>';
	}
	
}
global $novafw_likes;
$novafw_likes = new novafwLikes();

/**
 * Template Tag
 */
function novafw_likes(){
	global $novafw_likes;
    echo $novafw_likes->do_likes(); 
}