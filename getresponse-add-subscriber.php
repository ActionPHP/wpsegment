<?php

	$api_key = get_option('tmt_getresponse_api_key');
	require_once 'ap/jsonRPCClient.php';

			$api_url = 'http://api2.getresponse.com';
			# initialize JSON-RPC client
			$client = new jsonRPCClient($api_url);
				
			$result = NULL;
			
			# get CAMPAIGN_ID of 'sample_marketing' campaign
			try {
			    $result = $client->get_campaigns(
        $api_key,
        array (
            # find by name literally
            'name' => array ( 'EQUALS' => $the_list )
        )
    );
			}
			catch (Exception $e) {
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
	
	$params = array (
				'campaign'  => $CAMPAIGN_ID,
				'email'     => $email,
				'cycle_day' => '0',
				'customs' => array(
					array(
						'name'       => 'added_by',
						'content'    => 'ST'
					)
				)
			);
	
	if(!empty($name)) {$params['name'] = $name ;}
	# add contact to 'sample_marketing' campaign
	try {
		$result = $client->add_contact(
			$api_key,
			$params
			
			);
	}
	catch (Exception $e) {
		# check for communication and response errors
		# implement handling if needed
		
	}

	# uncomment this line to preview data structure
	# print_r($result);
	
	//print("Contact added\n");
$d = get_defined_vars();
		update_option('aaa111', $d);
?>

?>