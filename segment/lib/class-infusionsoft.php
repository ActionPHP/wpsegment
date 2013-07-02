<?php 

require_once(AP_PATH.'vendor/infusionsoft/isdk.php');

class WPSegmentInfusionsoft
{

	protected $api_key;
	protected $api_url;
	protected $api;

	public function connect($value='')
	{	
		$api = $this->getAPI();

		$user_fields = array('Id', 'FirstName','LastName', 'Email');

		/*$addContact = $api->addCon(array(

				'FirstName' => 'Michael',
				'LastName' => 'Smith',
				'Email'		=> 'msmith@actionphp.com'

			));*/

		//print_r($addContact);
		$users = $api->dsQuery('Contact', 1000, 0, array('Email' => "%"), $user_fields);
		
		
		print_r($users);
		
	}

	public function addContact($first_name, $last_name, $email, $tag_id='')
	{	
		if(!$email) return; //We don't want to store contacts who don't have an email.
		
		$api = $this->getAPI();

		$contact = array (

				'FirstName' => $first_name,
				'LastName'  => $last_name,
				'Email'		=>$email
			);

		$contact_id = $api->addCon($contact);
		
		print_r($contact_id);

		if($tag_id){

			$this->tagContact($contact_id, $tag_id);

		}
	}

	public function request($request)
	{
			# code...
	}	

	private function getAPI($connectionName = 'ge144')
	{
		if(!$this->api){

		require_once(AP_PATH.'vendor/infusionsoft/isdk.php');
		$api = new iSDK;

		$app_name = get_option('wp_segment_infusionsoft_app_name');
		$username = get_option('wp_segment_infusionsoft_username');
		$password = get_option('wp_segment_infusionsoft_password');
		//$password = md5($password);
		$vendor_key = 'f8e03fb45075192d389977f641bbede7';

		$tempKey = $api->vendorCon($app_name, $username, $password, $vendor_key);
		//print_r($tempKey);
		//$api->cfgCon($connectionName);
		
		return $api;

		}
	}

	public function saveWPSettings()
	{
		
		$app_name = trim(stripslashes($_POST['infusionsoft-app-name']));
		$username = trim(stripslashes($_POST['infusionsoft-username']));
		$password = trim(stripslashes($_POST['infusionsoft-password']));


		

		if($username){

			update_option('wp_segment_infusionsoft_username', $username);

		}

		if($password){

			update_option('wp_segment_infusionsoft_password', $password);

		}

		if($app_name){


			update_option('wp_segment_infusionsoft_app_name', $app_name);

		}
	}
}

?>