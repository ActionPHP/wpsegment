<?php

	class WPSegmentActivation
	{

		public function activate()
		{
			$this->questions_table();
			$this->answers_table();
			$this->response_table();
			$this->user_table();
			$this->results_table();
		}

		public function questions_table()
		{
			global $wpdb;

			$table_name = $wpdb->prefix . "pp_actionphp_questions";

			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (

			id mediumint(9) NOT NULL AUTO_INCREMENT,

			content text NOT NULL,
			      
			position int(9) NOT NULL,

			Status varchar(10) NOT NULL DEFAULT 'fresh',

			UNIQUE KEY id (id)

			);";
      
	      	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    		dbDelta($sql);
    		

		}

		public function answers_table()
		{
			global $wpdb;

			$table_name = $wpdb->prefix . "pp_actionphp_answers";

			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (

			id mediumint(9) NOT NULL AUTO_INCREMENT,

			question_id mediumint(9) NOT NULL,

			content text NOT NULL,

			points mediumint(9) NOT NULL DEFAULT 0,
			      
			position int(9) NOT NULL,

			custom_text text NOT NULL,

			Status varchar(10) NOT NULL DEFAULT 'fresh',

			UNIQUE KEY id (id)

			);";
      
	      	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    		dbDelta($sql);


		}

		public function response_table()
		{
			# code...
		}

		public function user_table()
		{
			# code...
		}

		public function results_table()
		{
			# code...
		}

	}

	$activation = new WPSegmentActivation;

?>