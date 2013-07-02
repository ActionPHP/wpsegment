<?php
require_once( AP_PATH . 'vendor/aweber_api/aweber_api.php');
class WPSegmentAweber
{

	public function addContact($first_name, $last_name, $email, $list_id="")
	{

		$account = $this->getAccount();

		$account_id = $account->id;
		$url = "/accounts/$account_id/lists/$list_id";

		$list = $account->loadFromUrl($url);

		$name = $first_name . ' ' . $last_name;

		$params = array(

				'email' => $email,
				'name'  => $name,
				'ad_tracking' => 'wpsegment'
			);

		$subscribers = $list->subscribers;

		try {

				$new_subscriber = $subscribers->create($params);

			} catch(AWeberAPIException $exc) {
							    print "<h3>AWeberAPIException:</h3>";
							    print " <li> Type: $exc->type              <br>";
							    print " <li> Msg : $exc->message           <br>";
							    print " <li> Docs: $exc->documentation_url <br>";
							    print "<hr>";
							    exit(1);
							}
	}

	public function saveWPSettings()
	{
			$auth_code = trim(stripslashes($_POST['aweber-authorization-code']));

			$auth = AWeberAPI::getDataFromAweberID($auth_code);
	
			$consumerKey = $auth[0];
			$consumerSecret = $auth[1];
			$accessKey = $auth[2];
			$accessSecret = $auth[3];

			update_option('wp_segment_aweber_consumerKey', $consumerKey);
			update_option('wp_segment_aweber_consumerSecret', $consumerSecret);
			update_option('wp_segment_aweber_accessKey', $accessKey);
			update_option('wp_segment_aweber_accessSecret', $accessSecret);

	}	

	public function getAPI()
	{
		if(!$this->api){

			$consumerKey = get_option('wp_segment_aweber_consumerKey');
			$consumerSecret = get_option('wp_segment_aweber_consumerSecret');
			
			
			$this->api = new AWeberAPI($consumerKey, $consumerSecret);
		
			
		}
			return $this->api;	
	}

	public function getAccount(){

		$api = $this->getAPI();

		$accessKey = get_option('wp_segment_aweber_accessKey');
		$accessSecret = get_option('wp_segment_aweber_accessSecret');
		
		$account = $api->getAccount($accessKey, $accessSecret);
		return $account;
	}

	public function getAccountID()
	{
		$account = $this->getAccount();

		$account_id = $account->id;

		return $account;

	}

	public function getLists()
	{
		$account = $this->getAccount();

		return $account->lists;
	}
}

?>