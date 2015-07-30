
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
	  	  
      function onYouTubeIframeAPIReady() {
	  function playVideo(divId, vidId) {
       player = new YT.Player(divId,  {
          height: '390',
          width: '640',
          videoId: vidId,
		playerVars: {
        autoplay: 1,
        controls: 2,
        modestbranding: 1,
        rel: 0,
        showInfo: 0
      },
		    events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }
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
  
  
   
  function playVideo(divId, videoId) {
    var width = divId.offsetWidth;
    var height = divId.offsetHeight;
    new YT.Player(divId, {
      videoId: videoId,
      width: width,
      height: height,
      playerVars: {
        autoplay: 1,
        controls: 2,
        modestbranding: 1,
        rel: 0,
        showInfo: 0
      }
    });
  }
  
  
  
  
  
  
  
	  
	  // Define some variables used to remember state.
var playlistId, nextPageToken, prevPageToken;

// After the API loads, call a function to get the uploads playlist ID.
function handleAPILoaded() {
  requestUserUploadsPlaylistId();
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
  var videoId = videoSnippet.resourceId.videoId;
                    vidThumburl =  videoSnippet.thumbnails.default.url;                 
                    vidThumbimg = '<li><img id="thumb" src="'+vidThumburl+'" alt="No Image Available." style="width:204px;height:128px"></img></li>';                   
                   $('#video-container').append(vidThumbimg); 
			  		$('li').click(function(){
					playVideo('vplayer', videoId);
						
					})
     }

	 
	 

	 
	 
// Retrieve the next page of videos in the playlist.
function nextPage() {
  requestVideoPlaylist(playlistId, nextPageToken);
}

// Retrieve the previous page of videos in the playlist.
function previousPage() {
  requestVideoPlaylist(playlistId, prevPageToken);
} 