/* JQuery for smooth page jumps. */
(function() {
	$('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html, body').animate({
					scrollTop: target.offset().top
				}, 1000);
				return false;
			}
		}
	});
})();


// If javascript gets the results of a media query...
if (matchMedia) {
	// Check if the media query matches the expression.
	var mqLaptop = window.matchMedia("(min-width: 993px)");
	// Add an event listener which fires when a change is detected.
	mqLaptop.addListener(setLaptopLayout);
	// Execute the widtChange function.
	setLaptopLayout(mqLaptop);
}


/* This function sets the "natural classes" for screen widths exceeding 992px or fires a new media query listener when the screen is 992px or smaller. */
function setLaptopLayout(mqLaptop) {
	if (mqLaptop.matches) { // Screen is 993px or larger.
		var organiserRow = document.getElementById('organiserRow');
		organiserRow.className = "row";
	} else {  // Screen is smaller than 993px.
		var organiserRow = document.getElementById('organiserRow');
		organiserRow.className = "organiserRow";
	}
}


// This function plays or pauses videos when you click on them.
function playVideo(video) {
	if (video.paused) {
		video.play();
	} else {
		video.pause();
	}
}