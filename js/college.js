
//Jquery Marquee Plugin Starter
$('.marquee').marquee({
	duration:5000, //4 seconds duration
	delayBeforeStart:0, //no delay
    pauseOnHover:true //Pause marquee on mouse hover
});

//Automatic Scroll to the page content on page load
if(document.getElementById('scroll-content')){
    $(document).ready(function () {
        // Handler for .ready() called.
        $('html, body').animate({
            scrollTop: $('#scroll-content').offset().top - 60
        }, 'slow');
    });
}