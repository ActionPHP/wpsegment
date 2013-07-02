<?php
require_once (AP_PATH . 'vendor/getresponse/jsonRPCClient.php');
class WPSegmentGetResponse
{
	private $api_key;
	
	public function addContact($first_name, $last_name, $email, $list="")
	{
		$api = $this->getAPI();
		$api_key = $this->getAPIKey();

		//$CAMPAIGN_ID = $this->getCampaignID($list);
		$CAMPAIGN_ID = $list;
		$name = $first_name . ' ' .$last_name;

		$params = array (
				'campaign'  => $CAMPAIGN_ID,
				'email'     => $email,
				'name'		=> $name,
				'cycle_day' => '0',
				);

		try{

			$result = $api->add_contact(

					$api_key,
					$params

				);

		}

		catch (Exception $e) {
		# check for communication and response errors
		# implement handling if needed
		
		}

	}

	public function saveWPSettings()
	{
			$api_key = trim(stripslashes($_POST['getresponse-api-key']));

			if($api_key){

				update_option('wp_segment_getresponse_api_key', $api_key);
			}
	}	

	public function getAPI($first_name, $last_name, $email)
	{
		$api_url = 'http://api2.getresponse.com';
		# initialize JSON-RPC client
		$api = new jsonRPCClient2($api_url);

		$api_key = $this->getAPIKey();

		return $api;		

	}

	public function getAPIKey(){

		if(!$this->api_key){

			$this->api_key = get_option('wp_segment_getresponse_api_key');
		}

		return $this->api_key;
	}

	public function getCampaignID($list=''){

		$api = $this->getAPI();
		$api_key = $this->getAPIKey();

		try {

			$result = $api->get_campaigns(

					$api_key,
					array(

							# find by name literally
            				'name' => array ( 'EQUALS' => $list )

						)
				);
		} catch (Exception $e) {
			    # check for communication and response errors
			    # implement handling if needed	

			    //die($e->getMessage());
			}

		# uncomment this line to preview data structure
		# print_r($result);
		
		# since there can be only one campaign of this name
		# first key is the CAMPAIGN_ID you need
		$campaigns = array_keys($result);
		$CAMPAIGN_ID = array_pop($campaigns);
		
		return $CAMPAIGN_ID;

	}

	public function getCampaigns(){

		$api = $this->getAPI();
		$api_key = $this->getAPIKey();

		$campaigns = $api->get_campaigns( $api_key );

		return $campaigns;

	}


}

?>