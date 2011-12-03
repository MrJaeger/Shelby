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
		<script type="text/javascript" language="javascript" src="assets/js/jquery.js"></script>
		<script type="text/javascript" src="assets/js/shelby-player.js"></script>
		<script type="text/javascript">
				var ids = new Array();
				var i = 0;
				var count = 0;
				<?php foreach($broadcasts as $broadcast): ?>
				<?php if($broadcast->video_provider_name=="youtube"): ?>
				var id = "<?php echo $broadcast->video_id_at_provider; ?>";
				if(id!="" && i<100) {
					$.getScript("http://gdata.youtube.com/feeds/api/videos/"+encodeURIComponent(id)+"?v=2&alt=json-in-script&callback=youtubeFeedCallback");
					i++;
					console.log("I: "+i);
				}
				function youtubeFeedCallback(data) {
					console.log(count);
					ids.push(data);
					count++;
					if(count==100) {
						buildVids();
					}
				}
				<?php endif; ?>
				<?php endforeach; ?>
				function buildVids() {
						console.log("ONCE, ONLY ONCE");
				}
				$(function () {
					var options = {
					  container:'player-div',
					  sidebar:false
					};
					var myStateChangeFunc = function(data, player){      
					  if (data.state.playerLoaded){

					  }
					  if (data.state.buffering){

					  }
					  if (data.state.playing){

					  }
					  if (data.state.videoEnded){

					  }
					  if (data.state.muted){

					  }
					  if (data.state.currentTime){

					  }
					};
					var player = new ShelbyPlayer(options, myStateChangeFunc);
					var channel = "<?php echo $channels[0]->_id; ?>";
					var broadcast = "<?php echo $broadcasts[0]->_id; ?>";
					player.playBroadcast(channel, broadcast);
				});
		</script>
	</head>
	<body>
		<header id="header">
			<h1>Shelby+</h1>
			<a id="logout" href="./logout.php">Log Out</a>
		</header>
		<div id="player-div">
		</div>
	</body>
</html>