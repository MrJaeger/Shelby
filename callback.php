<?php
require_once('Oauth/shelbyoauth/shelbyoauth.php');
require_once('Oauth/config.php');

session_start();

 $connection = new ShelbyOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

 $user = $connection->getResource('users');
 $channels = $connection->getResource('channels');
 $broadcasts = $connection->getResource('channels/'.$channels[0]->_id.'/broadcasts');
?>
<html>
	<head>
		<title>Shelby+</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" href="assets/css/style.css"/>
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="assets/js/shelby-player.js"></script>
		<script type="text/javascript">
			var json = <?php echo json_encode($broadcasts); ?>;
			var channel = "<?php echo $channels[0]->_id; ?>";
		</script>
		<script type="text/javascript" src="assets/js/shelbyplus.js"></script>
	</head>
	<body>
		<header id="header">
			<h1>Shelby+</h1>
			<a id="logout" href="./logout.php">Log Out</a>
		</header>
		<div id="player-div">
		</div>
		<div id="cats">
		</div>
	</body>
</html>