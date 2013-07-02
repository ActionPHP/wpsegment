<?php

	$aweber = new WPSegmentAweber;
	
?>
<pre>
<?php


	$account_id = $aweber->getLists();

	foreach ($account_id as $key => $value) {
		# code...
		print_r($value);
	}
	
?>
</pre>