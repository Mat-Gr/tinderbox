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





$('.post').click(function(e){

	e.preventDefault();

    var $this = $(this);
    
	$this.addClass('post--animatable');

	if($this.hasClass('post--visible')){

		$this.removeClass('post--visible');

	}else{
		
		$this.addClass('post--visible');

	}
    

    $this.bind( 'transitionend', function() {

		$this.removeClass('post--animatable');

    });

		



});