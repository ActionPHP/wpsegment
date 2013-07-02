<?php
require_once(AP_PATH. 'vendor/icontact/iContactApi.php');

class WPSegmentIContact
{

	public function addContact($first_name, $last_name, $email)
	{
		$api = $this->getAPI();
		$api->addContact($email, 'normal', null, $first_name, $last_name);

	}

	public function getAPI()
	{
		if(!$this->api){

			$icontact_username = get_option('wp_segment_icontact_username');
			$icontact_password = get_option('wp_segment_icontact_password');


			iContactApi::getInstance()->setConfig(array(
				'appId'       => 'hzyJomZIb4vPyQR4Mp5bzze3MZ4nUfaa', 
				'apiPassword' => $icontact_password,
				'apiUsername' => $icontact_username
			));

			$this->api = iContactApi::getInstance();

			
		}

		return $this->api;

	}

	public function saveWPSettings()
	{
		$icontact_username = $_POST['icontact-username'];
		$icontact_password = $_POST['icontact-password'];

		if($icontact_username){

			update_option('wp_segment_icontact_username', $icontact_username);

		}

		if($icontact_password){

			update_option('wp_segment_icontact_password', $icontact_password)	;

		}
	}

}
?>