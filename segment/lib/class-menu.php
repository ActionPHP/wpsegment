<?php

class SegmentMenu
{
	public $parent_slug = 'actionphp-segment';
	public $capability = 'manage_options';

 	public function menu()
 	{
 		$this->main_menu();
 		$this->create_quiz_menu();
 		$this->autoresponder_menu();


 	}

 	public function main_menu()
 	{
 		$page_title = 'Segment This';
		$menu_title = 'Segmenting';
		$capability = $this->capability;
		$menu_slug = $this->parent_slug;
		$function = array($this, 'main_menu_view');

		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

 	}

 	public function main_menu_view()
 	{
 		$path = AP_PATH;
 		$path.= 'menu/main-page.php';

 		include($path);
 	}

 	public function create_quiz_menu()
 	{
 		$parent_slug = 'actionphp-segment';//$this->parent_slug;
 		$page_title = 'Create quiz';
 		$menu_title = 'Create your quiz';
 		$capability = $this->capability;
 		$menu_slug = 'actionphp-segment-create-quiz';
 		$function = array ($this, 'create_quiz_menu_view');

		add_submenu_page( 'actionphp-segment', $page_title, $menu_title, $capability, $menu_slug, $function );


 	}

 	public function create_quiz_menu_view()
 	{
 		$path = AP_PATH;
 		$path.= 'menu/create-quiz.php';
 		
 		include($path);

 	}

 	public function autoresponder_menu()
 	{
 		$parent_slug = 'actionphp-segment';//$this->parent_slug;
 		$page_title = 'Your autoresponder settings.';
 		$menu_title = 'Autoresponder';
 		$capability = $this->capability;
 		$menu_slug = 'actionphp-segment-autoresponder' ;
 		$function = array ($this, 'autoresponder_menu_view');

		add_submenu_page( 'actionphp-segment', $page_title, $menu_title, $capability, $menu_slug, $function );
 	}

 	public function autoresponder_menu_view()
 	{
 		$path = AP_PATH;
 		$path.= 'menu/autoresponder-settings.php';
 		
 		include($path);
 	}


}