<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $this->getTitle(); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../', __FILE__); ?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../', __FILE__); ?>/css/style.css">

		<script type="text/javascript" >

			var ajaxurl = '<?php echo admin_url(); ?>admin-ajax.php';

		</script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript" src="<?php echo plugins_url('../', __FILE__); ?>/js/script.js"></script>

	</head>	
	<body>

		<div class="container" id="main-view-port">

			<h1 class="text-info"><?php echo $this->getTitle(); ?></h1>


