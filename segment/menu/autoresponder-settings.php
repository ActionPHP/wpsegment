<?php
	
	if(isset($_POST['submit-autoresponder-service'])){

		$autoresponder_service = trim(stripslashes($_POST['autoresponder-service']));

		switch ($autoresponder_service){

			case "aweber":

				$aweber = new WPSegmentAweber;
				$aweber->saveWPSettings();

				update_option('wp_segment_autoresponder_service', $autoresponder_service);

			break;

			case "getresponse":

				$getresponse = new WPSegmentGetResponse;
				$getresponse->saveWPSettings();

				update_option('wp_segment_autoresponder_service', $autoresponder_service);

			break;

			case "infusionsoft":

				$infusionsoft = new WPSegmentInfusionsoft;
				$infusionsoft->saveWPSettings();
				
				update_option('wp_segment_autoresponder_service', $autoresponder_service);

			break;

			case "icontact":

				$icontact = new WPSegmentIContact;
				$icontact->saveWPSettings();

				update_option('wp_segment_autoresponder_service', $autoresponder_service);

			break;

		}



	}
		

?>
<?php

	$autoresponder = trim(stripslashes(get_option('wp_segment_autoresponder_service')));

	#Credentials
	$infusionsoft_app_name = get_option('wp_segment_infusionsoft_app_name');
	$infusionsoft_username = get_option('wp_segment_infusionsoft_username');
	$infusionsoft_password = get_option('wp_segment_infusionsoft_password');


	$icontact_username = get_option('wp_segment_icontact_username');
	$icontact_password = get_option('wp_segment_icontact_password');

	$getresponse_api_key = get_option('wp_segment_getresponse_api_key');



?>


<div id="wp-segment-autoresponder-settings" >

<h2>Your autoresponder settings</h2>

<label>
	<select id="wp-segment-autoresponder">
		<option value="aweber" <?php selected('aweber', $autoresponder); ?> >Aweber</option>
		<option value="getresponse" <?php selected('getresponse', $autoresponder); ?>>GetResponse</option>
		<option value="infusionsoft" <?php selected('infusionsoft', $autoresponder); ?>>Infusionsoft</option>
		<option value="icontact" <?php selected('icontact', $autoresponder); ?>>iContact</option>
	</select>

</label>
	<div id="view-port" >




	</div>
</div>

<script type="text/template" id="aweber-form">
<h3>Aweber Settings</h3>
	<p>
		<strong>Get your autorization code: </strong> <a href="https://auth.aweber.com/1.0/oauth/authorize_app/561be1c8" target="_blank" >click here</a>
	</p>
	<p>
		<strong>Please paste your authorization code below: </strong>
	</p>
	<form action="" id="aweber-settings-form" method="post">
		<label>
			<textarea id="aweber-authorization-code" name="aweber-authorization-code" style="width: 300px; height: 150px;" ><?php echo $aweber_authorization_code; ?></textarea>
		</label>
		<label>
			<input type="hidden" id="autoresponder-service" name="autoresponder-service" value="aweber" />
			<input type="hidden" id="submit-autoresponder-service" name="submit-autoresponder-service" value="true" />
			<input type="submit" value="Save settings" class="button-primary" />
		</label>

	</form>
</script>


<script type="text/template" id="getresponse-form">
<h3>GetResponse Settings</h3>
	
	<form action="" id="getresponse-settings-form" method="post">
		<label>
			<a href="http://www.getresponse.com/my_api_key.html" target="_blank" >Get your API key</a>
			<p>
				<strong>Please paste your API key below:</strong>
			</p>
		</label>
		<label>
			<input type="text" id="getresponse-api-key" name="getresponse-api-key" class="regular-text" value="<?php echo $getresponse_api_key; ?>"/>
		</label>
		<label>
			<input type="hidden" id="autoresponder-service" name="autoresponder-service" value="getresponse" />
			<input type="hidden" id="submit-autoresponder-service" name="submit-autoresponder-service" value="true" />
			<input type="submit" value="Save settings" class="button-primary" />
		</label>

	</form>
</script>


<script type="text/template" id="infusionsoft-form">
<h3>Infusionsoft Settings</h3>

<form id='infusionsoft-settings-form' method="post" >
	
	<label>
		<strong>App name: </strong> <input type="text" name="infusionsoft-app-name" id="infusionsoft-app-name" class="regular-text" value="<?php echo $infusionsoft_app_name; ?>"/>
	</label>

	<label>
		<strong>Username: </strong> <input type="text" name="infusionsoft-username" id="infusionsoft-username" class="regular-text" value="<?php echo $infusionsoft_username; ?>"/>
	</label>

	<label>
		<strong>Password: </strong> <input type="password" name="infusionsoft-password" id="infusionsoft-password" class="regular-text" value="<?php echo $infusionsoft_password; ?>"/>
	</label>

	<label>
		<input type="hidden" id="autoresponder-service" name="autoresponder-service" value="infusionsoft" />
		<input type="hidden" id="submit-autoresponder-service" name="submit-autoresponder-service" value="true" />
		<input type="submit" value="Save settings" class="button-primary" />
	</label>
</form>

</script>

<script type="text/template" id="icontact-form">
<h3>iContact Settings</h3>
<ol>
	<li><a href="https://app.icontact.com/icp/core/externallogin" target="_blank" >Click here</a> to go to the integration page on your account.</li>
	<li>Paste this as the Application ID: <input type="text" class="regular-text" value="hzyJomZIb4vPyQR4Mp5bzze3MZ4nUfaa" readonly="readonly" />
	<li>Create a password for your integration then then type it in below. Please click "Save settings" when you are finished.</li>
<ol>
	<form id="icontact-settings-form" method="post" action="" >


		<label>
			<strong>iContact username: </strong><input type="text" class="regular-text" value="<?php echo $icontact_username; ?>" id="icontact-username" name="icontact-username" />
		</label>

		<label>

			<strong>Application password: </strong><input type="password" class="regular-text" value="<?php echo $icontact_password; ?>" id="icontact-password" name="icontact-password" />

		</label>

		<label>
			<input type="hidden" id="autoresponder-service" name="autoresponder-service" value="icontact" />
			<input type="hidden" id="submit-autoresponder-service" name="submit-autoresponder-service" value="true" />
			<input type="submit" value="Save settings" class="button-primary" />
		</label>

	</form>

</script>

<script type="text/javascript">
	function showSettings(service){

		var content = jQuery('#' + service + '-form').html();
		jQuery('#view-port').html(content);

	}

	jQuery('#wp-segment-autoresponder').change(function(e){

			var service = jQuery(e.currentTarget).val();
			showSettings(service);

	})
	

	showSettings('<?php echo $autoresponder; ?>');


</script>