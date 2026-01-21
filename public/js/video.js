// Load & insert into DOM Youtube iframe_api
var tag = document.createElement("script");

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName("script")[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

/* Create Player */
var player;
var timer,
    timeSpent = [];

$("#mediaCorner").on("click", ".videoLoader", function () {
    // Create new instance of player
    player = new YT.Player("videoModalContainer", { 
        videoId: this.id,
        host: "https://www.youtube.com",
        width: "560",
        height: "315",
        playerVars: {
            rel: 0,
            autoplay: 1,
            controls: 0,
            autohide: 1,
        },
        events: {
            onReady: OpenModal,
        },
    });

    // Show Modal
    function OpenModal() {
        $("#manufacture-video").show();
        player.playVideo();
    }
    return false;
}); // /each video

// Add a Lisener to Modal CLose Button
$("#manufacture-video").on("click", "#videoClose", function () {
    $("#manufacture-video").hide();
    player.destroy();
});


$("#how-to-clew").on("click", ".videoLoader", function () {
    var videoSrc = $(this).data("video-src");
    $("#localVideo source").attr("src", videoSrc);
    $("#localVideo")[0].load();
    $("#how-to-clew-video").show();
    return false;
});

// Close modal and stop video
$("#how-to-clew-video").on("click", "#videoClose", function () {
    var video = $("#localVideo")[0];
    video.pause();
    video.currentTime = 0;
    $("#how-to-clew-video").hide();
});
