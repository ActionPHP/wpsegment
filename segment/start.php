<?php


class WPSegment
{
	
	public function run(){

		define('AP_PATH', plugin_dir_path(__FILE__));
		require_once('scripts.php');
		
		//register_activation_hook( __FILE__, array($this, 'activate') ); //Not working for some reason.
		$this->activate();
		$this->wp_actions();

	}

	public function activate(){
		//die('activating');

		require_once('lib/class-activation.php');
		$activation->activate();

	}

	public function wp_actions()
	{
		$router = new WPSegmentRouter;

		add_action('admin_menu', array($this, 'create_menus'));
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts') );
		add_action( 'wp_ajax_actionphp_save_question', array($router, 'save_question'));
		add_action( 'wp_ajax_actionphp_save_answer', array($router, 'save_answer'));
		add_action( 'wp_ajax_actionphp_get_question', array($router, 'get_question'));
		add_action( 'wp_ajax_actionphp_get_answers', array($router, 'get_answers')); //We're getting all the answers by question id
		add_action( 'wp_ajax_actionphp_delete_question', array($router, 'delete_question'));
		add_action( 'wp_ajax_actionphp_delete_answer', array($router, 'delete_answer'));
		add_action( 'wp_ajax_actionphp_process_quiz', array($router, 'process_quiz'));
		add_action( 'wp_ajax_actionphp_store_contact', array($router, 'store_contact'));


		add_action( 'template_redirect', array($router, 'show_quiz' ));
	}

	public function create_menus(){

		$SegmentMenu = new SegmentMenu;
		$SegmentMenu->menu();

	}

	public function scripts($hook)
	{
		if($hook == 'segmenting_page_actionphp-segment-create-quiz'){

			wp_enqueue_script( 'actionphp_segment_app', plugins_url('js/segment-app.js', __FILE__), array('backbone', 'jquery-ui-sortable') );
			wp_enqueue_script( 'actionphp_bootstrap_js', "//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js", array( 'jquery') );
			
			wp_register_style( 'actionphp_bootstrap_css', "//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" );
        	wp_enqueue_style( 'actionphp_bootstrap_css' );
			
			wp_register_style( 'actionphp_segment_style', plugins_url('css/style.css', __FILE__) );
        	wp_enqueue_style( 'actionphp_segment_style' );
		}
	}

	
}

$segment = new WPSegment;

?>