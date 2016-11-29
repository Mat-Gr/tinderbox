// slide in menu
jQuery('body').on('click', '#menu-icon', function(e){
    var menu = jQuery('.menu');
	menu.addClass('menu--animatable');

	if(menu.hasClass('menu--visible')){
		menu.removeClass('menu--visible');
	}else{
		menu.addClass('menu--visible');
	}

	menu.on('transitionend webkitTransitionEnd oTransitionEnd', function(){
		menu.removeClass('menu--animatable');
	});
});

// drop down post
jQuery('body').on('click', '.post', function(e){

	e.preventDefault();

    var post = jQuery(this);
	post.addClass('post--animatable');

	if(post.hasClass('post--visible')){
		post.removeClass('post--visible');
	}else{
		post.addClass('post--visible');
	}

	post.on('transitionend webkitTransitionEnd oTransitionEnd', function(){
		post.removeClass('post--animatable');
	});
});
