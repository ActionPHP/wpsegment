<?php 
			include_once('ap/aweber_api/aweber_api.php');
			$tmt_autoresponder = get_option('tmt_autoresponder');
			
			
			$email = trim(stripslashes($_POST['st_email']));
			$name =  trim(stripslashes($_POST['st_name']));
			$tmt_the_list = trim(stripslashes($_POST['the_list']));
			
			$new_subscriber = array(
				
					'email' => $email,
					'name' => $name
					
				);
				
				$tmt_autoresponder = get_option('tmt_autoresponder');
				
				if($tmt_autoresponder == 'aweber'){
				
					require_once('ap/aweber_api/aweber_api.php');
					
					
					$consumerKey = get_option('tmt_aweber_consumerKey');
					$consumerSecret = get_option('tmt_aweber_consumerSecret');
					$accessKey = get_option('tmt_aweber_accessKey');
					$accessSecret = get_option('tmt_aweber_accessSecret');
					
					
					$aweber = new AWeberAPI($consumerKey, $consumerSecret);
					$account = $aweber->getAccount($accessKey, $accessSecret);
					$account_id = $account->id;
					$list_url = 'https://api.aweber.com/1.0/accounts/'.$account_id.'/lists/'.$tmt_the_list;
					$lists = $account->loadFromUrl($list_url);

					  $subscribers = $lists->subscribers;
				        try {
							    $new_subscriber = $subscribers->create($new_subscriber);
							    print_r($new_subscriber); die();
							} catch(AWeberAPIException $exc) {
							    print "<h3>AWeberAPIException:</h3>";
							    print " <li> Type: $exc->type              <br>";
							    print " <li> Msg : $exc->message           <br>";
							    print " <li> Docs: $exc->documentation_url <br>";
							    print "<hr>";
							    exit(1);
							}
								
								
				}
								
					
				if($tmt_autoresponder == 'getresponse'){
					
					$api_key = get_option('tmt_getresponse_api_key');
					$the_list = $tmt_the_list;
					
					include('getresponse-add-subscriber.php');
					
					
				}
				
				if($tmt_autoresponder == 'icontact'){
					
					include('icontact-add-subscriber.php');
				
				}