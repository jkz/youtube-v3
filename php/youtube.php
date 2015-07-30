var itvghana = '<table><tbody><tr><iframe width="640" height="390" src="http://cdn.livestream.com/embed/itvghana?layout=4&color=0x000000&amp;height=540&amp;width=100%&amp;autoplay=true" style="border:0;outline:0" frameborder="0" scrolling="no"></iframe></tr></tbody></table>';
var gtvghana = '<table><tbody><tr><iframe src="http://new.livestream.com/accounts/3700223/events/2055798/player?width=640&height=360&autoPlay=true&mute=false" width="98%" height="850" frameborder="0" scrolling="no"> </iframe></tr></tbody></table>';

  
var currentLiveVideo;
var normalplayer = false;
var currentid = 0;
var size = 1;
  

  window.addEventListener('message', function(event) {

    // IMPORTANT: Check the origin of the data!
    if (~event.origin.indexOf('https://www.youtube.com')) {
        // The data has been sent from your site

        // The data sent with postMessage is stored in event.data
        console.log(event.data);
    } else {
        // The data hasn't been sent from your site!
        // Be careful! Do not use it.
        return;
    }
});



      	  // Define some variables used to remember state.
var playlistId, nextPageToken, prevPageToken;

// After the API loads, call a function to get the uploads playlist ID.
function handleAPILoaded() {
  requestUserUploadsPlaylistId();
  $('#search-button').attr('disabled', false);
}

// Call the Data API to retrieve the playlist ID that uniquely identifies the
// list of videos uploaded to the currently authenticated user's channel.
function requestUserUploadsPlaylistId() {
  // See https://developers.google.com/youtube/v3/docs/channels/list
  var request = gapi.client.youtube.channels.list({
    mine: true,
    part: 'contentDetails'
  });
  request.execute(function(response) {
    playlistId = response.result.items[0].contentDetails.relatedPlaylists.uploads;
    requestVideoPlaylist(playlistId);
  });
}

// Retrieve the list of videos in the specified playlist.
function requestVideoPlaylist(playlistId, pageToken) {
  $('#video-container').html('');
  var requestOptions = {
    playlistId: playlistId,
    part: 'snippet',
    maxResults: 10
  };
  if (pageToken) {
    requestOptions.pageToken = pageToken;
  }
  var request = gapi.client.youtube.playlistItems.list(requestOptions);
  request.execute(function(response) {
    // Only show pagination buttons if there is a pagination token for the
    // next or previous page of results.
    nextPageToken = response.result.nextPageToken;
    var nextVis = nextPageToken ? 'visible' : 'hidden';
    $('#next-button').css('visibility', nextVis);
    prevPageToken = response.result.prevPageToken
    var prevVis = prevPageToken ? 'visible' : 'hidden';
    $('#prev-button').css('visibility', prevVis);

    var playlistItems = response.result.items;
    if (playlistItems) {
      $.each(playlistItems, function(index, item) {
       displayResult(item.snippet);
	   

		//createDisplayThumbnail(item.snippet);
      });
    } else {
      $('#video-container').html('Sorry you have no uploaded videos');
    }
  });
}

// Create a listing for a video.
function displayResult(videoSnippet) {
  var title = videoSnippet.title;
  videoId = videoSnippet.resourceId.videoId;
                     vidThumburl =  videoSnippet.thumbnails.default.url;
                     vidThumbimg = '<li><p><img id="thumb" src="'+vidThumburl+'" alt="No Image Available." style="width:204px;height:128px"></img></p></li>';
                    $('#video-container').append(vidThumbimg);
                 }


// Retrieve the next page of videos in the playlist.
function nextPage() {
  requestVideoPlaylist(playlistId, nextPageToken);
}

// Retrieve the previous page of videos in the playlist.
function previousPage() {
  requestVideoPlaylist(playlistId, prevPageToken);
}






// 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var container = 'player';
var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player(container, {
          height: '390',
          width: '640',
          videoId: 'M7lc1UVf-VE',
            events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      
      
      
      
      function stopVideo() {
        player.stopVideo();
      }

          var firsttime = true;
          var setter;    // Sets if youtube or livestream to be played
      function playVideo(id){
	if(document.title)
	//document.title = title;
	if(setter =='off'){
              setYoutubePlayer();
              setter ='on' ;
              vid = id;
               } else{
               player.loadVideoById(id, 1, 'large');
               player.playVideo();
               vid = id;
              }

    }


  function loadNewVideo(id) {
	if (normalplayer) {
		currentid = id;
		normalplayer.loadVideoById(id);
		normalplayer.loadVideoById(id);


	}
}


var livestream;
  livestream = function(stream){
      currentLiveVideo = stream;  // Sets the current playing live stream
      vid = currentid;
     player.stopVideo();
     var frm_element = document.getElementById(container);
        var vis = frm_element.style;
        vis.display = 'none';
        setter ='off';
       //string_allDone : "LIVE TV",
       document.getElementById('videoPlayer').innerHTML = stream;
   }




  function setYoutubePlayer(){
      var frm_element = document.getElementById(container);
       var vis = frm_element.style;
       if (vis.display=='' || vis.display=='none')
      {
           vis.display = 'block';
           document.getElementById('videoPlayer').innerHTML = "";


      }

   }

