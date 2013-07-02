<?php

	include_once('ap/aweber_api/aweber_api.php');
	include_once('ap/jsonRPCClient.php');

?>
<?php

	
	
	 if(isset($_POST["tmt_icontact_integration_complete"])){
 	$autoresponder = 'icontact';
 	$icontact_username = trim(stripslashes($_POST["tmt-icontact-username"]));
 	$icontact_password = trim(stripslashes($_POST["tmt-icontact-password"]));
 	
 	if(empty($icontact_username)){
 		
 		$errors['empty_icontact_username'] = 'iContact username cannot be empty.';
 		 		
 	}
 	
 	
 	if(empty($icontact_password)){
 		
 		 		$errors['empty_icontact_password'] = 'iContact password cannot be empty.';

 		
 	}
 	
 	if(empty($errors)){
 		
 		update_option('tmt_icontact_username', $icontact_username);
 		update_option('tmt_icontact_password', $icontact_password);
 		
	 	update_option('tmt_autoresponder', 'icontact' );

 		$changes_saved = true;
 		
 	}
 	
 }
 
 	if(isset($_POST['tmt_get_response_added'])){
 	$autoresponder = 'getresponse';
		$api_key = trim($_POST['tmt_getresponse_api_key']);
		if(!empty($api_key)){
			
			$api_url = 'http://api2.getresponse.com';
			$client = new jsonRPCClient( $api_url );;
			
			try {
			    $result = $client->ping(
			        $api_key
			    );
			}
			catch (Exception $e) {
			    # check for communication and response errors
			    # implement handling if needed	
				$errors['tmt_not_connected_to_getresponse_api'] = 'Please try a different key: not connected to GetResponse';	

			   // die($e->getMessage());
			}
			
			if( $result['ping'] == 'pong') {
			update_option('tmt_getresponse_api_key', $api_key);
				
			update_option('tmt_autoresponder', 'getresponse' );
			
		$changes_saved = true;
		
			} else {
			
				$errors['tmt_invalid_getresponse_api_key'] = 'Invalid GetResponse API Key';	
				
			}
		}
	 }
	 
	 
	if(isset ( $_POST['__aweber_added'])) {
	 include_once('ap/aweber_api/aweber_api.php');
 	$autoresponder = 'aweber';

	$aweber_auth = $_POST['__aweber_auth'];
	 
	try{	
	 $auth = AWeberAPI::getDataFromAweberID($aweber_auth);
	
	 
		$consumerKey = $auth[0];
		$consumerSecret = $auth[1];
		$accessKey = $auth[2];
		$accessSecret = $auth[3];
		
		
		if(!empty($auth)){
		update_option('tmt_aweber_consumerKey', $consumerKey);
		update_option('tmt_aweber_consumerSecret', $consumerSecret);
		update_option('tmt_aweber_accessKey', $accessKey);
		update_option('tmt_aweber_accessSecret', $accessSecret);
		
		update_option('tmt_autoresponder', 'aweber' );
		
		$changes_saved = true;
		} else {
			
			$errors['tmt-invalid-aweber-auth-code'] = 'Invalid Aweber auth code';	
			
		}
		
		
		
	} catch(AWeberAPIException $exc) {
print "<h3>AWeberAPIException:</h3>";
print " <li> Type: $exc->type              <br>";
print " <li> Msg : $exc->message           <br>";
print " <li> Docs: $exc->documentation_url <br>";
print "<hr>";
}

	}
$autoresponder = $tmt_autoresponder = get_option('tmt_autoresponder');

if(empty( $autoresponder ) ) {
	
	$autoresponder = 'aweber';
	
}

?><pre><?php  //print_r( get_defined_vars() ); ?></pre>

<?php

	 tmt_branding();

?>	
		<style>

	label {
		
		display: block;
		margin: 20px;
		
	}
	
	#tmt-saved {
		
		position: absolute;
		top: 25%;
		left: 33%;
		width: 300px;
		padding: 15px;
		margin: 0 auto;
		border: 1px #090 solid;
		background-color: #E1EAE6;
		color: #090;
		
		height: 30px;
		font-size: 24px;
		text-align: center;
		z-index: 9999;	
	}

</style>
    <label>
       <strong> Please choose your autoresponder: </strong>
        <select name="tmt-autoresponder" onchange=";chooseAutoresponder(this.value);" >
            <option value="aweber" <?php selected($autoresponder, 'aweber'); ?>>Aweber</option>
            <option value="getresponse"  <?php selected($autoresponder, 'getresponse'); ?> >GetResponse</option>
            <option value="icontact"  <?php selected($autoresponder, 'icontact'); ?> >iContact</option>
        </select>
        
    </label>
    
    <?php
//print_r($autoresponder);
	if($changes_saved){

?>
    <div id="tmt-saved" >
    Saved!
    </div>
<script>

function savedIndicator(){
					
				jQuery('#tmt-saved').fadeIn(100);
				jQuery('#tmt-small-saved-indicator').fadeIn(100);
				jQuery('#tmt-saved').fadeOut(3000);
				jQuery('#tmt-small-saved-indicator').fadeOut(3000);
			
		}
	
	savedIndicator();

</script>
<?php } ?>


<div id="aweber-i"  class="auto-choice" >
<?php
	include('aweber-settings.php');
	
?>

</div>

<div id="getresponse-i" class="auto-choice" >
<?php

	include('getresponse-settings.php');
		
?>
</div>

<div id="icontact-i" class="auto-choice"  >
<?php

	include('icontact-connect.php');
	/*switch($autoresponder){
		
		case 'aweber':
		
			
		
		break;
		
		case 'getresponse';
		
			
		
		break;
		
		case 'icontact';
		
		
		
		break;
		
		case 'constant-contact':
		
		
		break;	
		
	}*/
	
?>
</div>
<script>

function savedIndicator(){
					
				jQuery('#tmt-saved').fadeIn(100);
				jQuery('#tmt-small-saved-indicator').fadeIn(100);
				jQuery('#tmt-saved').fadeOut(3000);
				jQuery('#tmt-small-saved-indicator').fadeOut(3000);
			
		}
	
	function chooseAutoresponder(the_choice){
		
		jQuery('.auto-choice').hide();
		
		jQuery('#'+the_choice+'-i').show();
		
		
		
	}

</script>
<script>
		var the_choice 	= '<?php echo $autoresponder; ?>';
		chooseAutoresponder(the_choice);
	
</script>