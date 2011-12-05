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
		<link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css"/>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript" src="assets/js/shelby-player.js"></script>
		<script type="text/javascript">
				var player;
				var channel;
				var videos = new Array();
				var ids = new Array();
				var playids = new Array();
				var imgs = new Array();
				var i = 0;
				var count = 0;
				<?php foreach($broadcasts as $broadcast): ?>
				<?php if($broadcast->video_provider_name=="youtube"): ?>
				var id = "<?php echo $broadcast->video_id_at_provider; ?>";
				if(id!="" && i<100) {
					videos.push(id);
					$.getScript("http://gdata.youtube.com/feeds/api/videos/"+encodeURIComponent(id)+"?v=2&alt=json-in-script&callback=youtubeFeedCallback");
					i++;
					imgs[id] = "<?php echo $broadcast->video_thumbnail_url; ?>";
					playids[id] = "<?php echo $broadcast->_id; ?>";
				}
				function youtubeFeedCallback(data) {
					var array = data.entry.id.$t.split(":");
					var video_id = array[array.length-1];
					ids[video_id] = data;
					count++;
					if(count==100) {
						buildVids();
					}
				}
				<?php endif; ?>
				<?php endforeach; ?>
				function buildVids() {
						var categories = new Array();
						var flag = 1;
						for(var j = 0; j<count; j++) {
							var category = ids[videos[j]].entry.category[1].term;
							for(var k = 0; k<categories.length; k++) {
								if(category==categories[k]) {
									flag = 0;
									break;
								}
							}
							if(flag==1) {
								categories.push(category);
							}
							flag = 1;
						}
						categories = categories.sort();
						for(var m=0; m<categories.length; m++) {
							$('#cats').append('<div id="'+categories[m]+'"></div>');
							$('#'+categories[m]).append('<h2>'+categories[m]+'</div>');
						}
						for(var n = 0; n<count; n++) {
							var cat = ids[videos[n]].entry.category[1].term;
							var string = new String(videos[n]);
							$("#"+cat).append("<img src='"+imgs[videos[n]]+"'onclick='work("+n+")'/>");
						}
				}
				function work(value) {
					window.scrollTo(0,0);
					console.log(value);
					player.playBroadcast(channel, playids[videos[value]]);
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
					  	  player.togglePlay();
					  }
					  if (data.state.muted){

					  }
					  if (data.state.currentTime){

					  }
					};
					player = new ShelbyPlayer(options, myStateChangeFunc);
					channel = "<?php echo $channels[0]->_id; ?>";
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
		<div id="cats">
		</div>
	</body>
</html>