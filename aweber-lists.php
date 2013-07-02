<?php
include_once('ap/aweber_api/aweber_api.php');
$tmt_autoresponder = get_option('tmt_autoresponder');

if($tmt_autoresponder == 'aweber'){
	
		$aweber_connected = true; 
	
	
		$consumerKey = get_option('tmt_aweber_consumerKey');
		$consumerSecret = get_option('tmt_aweber_consumerSecret');
		$accessKey = get_option('tmt_aweber_accessKey');
		$accessSecret = get_option('tmt_aweber_accessSecret');
		
		$aweber = new AWeberAPI($consumerKey, $consumerSecret);
		$account = $aweber->getAccount($accessKey, $accessSecret);
		$account_id = $account->id;
		$list_url = 'https://api.aweber.com/1.0/accounts/'.$account_id.'/lists/';
		
		$aweber_chosen_list = get_option('tmt_aweber_chosen_list');
?>


<label>
<select  name="tmt-the-list" >
<?php
foreach($account->lists as $offset => $list) {
?>
<option value="<?php echo $list->id; ?>" <?php selected($tmt_the_list, $list->id); ?> ><?php echo $list->name; ?></option>
<?php } ?>
</select>
</label>

<?php } ?>