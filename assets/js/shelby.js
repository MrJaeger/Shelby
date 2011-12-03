$(function(){
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
});