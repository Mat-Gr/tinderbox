// menu
function toggleClassMenu() {
	myMenu.classList.add("menu--animatable");
	if(!myMenu.classList.contains("menu--visible")) {
		myMenu.classList.add("menu--visible");
	} else {
		myMenu.classList.remove('menu--visible');
	}
}

function OnTransitionEnd() {
	myMenu.classList.remove("menu--animatable");
}

var myMenu = document.querySelector(".menu");
var oppMenu = document.querySelector(".menu-icon");
myMenu.addEventListener("transitionend", OnTransitionEnd, false);
oppMenu.addEventListener("click", toggleClassMenu, false);



/*

$('.post').click(function(e){

	e.preventDefault();


    var $this = $(this).find('.post-content');

    if($this.hasClass('.contact-active')){
		
		$this.removeClass('.contact-active');
		$this.slideToggle( "fast", function() {

			
			
		  });


    } else {

		    //$(".contact-active").toggle();
		    $this.slideToggle( "fast", function() {
		    	$this.addClass('.contact-active');
		    	//$this.toggleClass('contact-active', $(this).is(':visible'));
		  });
    }
  




 



});*/