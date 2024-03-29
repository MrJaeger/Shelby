var player;
var channel;
var search = new Array();
var videos = new Array();
var ids = new Array();
var playids = new Array();
var imgs = new Array();
var count = 0;
for(var i = 0; i<(json.length/2); i++) {
	var id = json[i].video_id_at_provider;
	if(id!="") {
		videos.push(id);
		$.getScript("http://gdata.youtube.com/feeds/api/videos/"+encodeURIComponent(id)+"?v=2&alt=json-in-script&callback=youtubeFeedCallback");
		imgs[id] = json[i].video_thumbnail_url;
		playids[id] = json[i]._id;
	}
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
function buildVids() {
		var categories = new Array();
		var flag = 1;
		for(var j = 0; j<count; j++) {
			addToSearch(j);
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
			$("#"+cat).append("<img src='"+imgs[videos[n]]+"' class='cat_img' value='"+n+"'/>");
		}
		$(".cat_img").click( 
			function() {
				window.scrollTo(0,0);
				player.playBroadcast(channel, playids[videos[$(this).attr("value")]]);			
			}
		);
		$(".cat_img").hover(
			function() {
				var val = $(this).attr("value");
				var pos = $(this).position();
				var html = "<h3>"+json[val].video_title+"</h3>";
				html += "<span>Posted By:  <b>"+json[val].video_originator_user_nickname+"</b> </span><img src='"+json[val].video_originator_user_image+"'/>";
				$('#popup').html(html);
				var height = $('#popup').height();
				var width = $(this).width();
				$('#popup').css({"width": "250px", "top": (pos.top-height-20)+"px", "left": (pos.left+(width/2))+"px"}).show();
			}, function () {
				$('#popup').hide();
			}
		)
}
function addToSearch(spot) {
	for(var i = 2; i<ids[videos[spot]].entry.category.length; i++) {
		var term = ids[videos[spot]].entry.category[i].term;
		var check = search[term];
		if(check==undefined) {
			search[term] = new Array();
		}
			search[term][search[term].length] = videos[spot];
			console.log(search[term]);
	}
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
	var broadcast = json[0]._id;
	player.playBroadcast(channel, broadcast);
});