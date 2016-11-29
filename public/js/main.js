// Declare all functions here
function login_page()
{
	jQuery('body').removeClass();
	jQuery('body').addClass('login');
	//Get template from server
	jQuery.get("http://localhost/tinderbox/public/templates/login_signup_template.html").done(function(response) {

		var content = jQuery(jQuery.parseHTML(response));

		//Compile main template
		var login_template = Handlebars.compile(content.filter('#login_template').html());

		// set html content
		jQuery('body').html(login_template);
	});
}

function signup_page()
{
	jQuery('body').removeClass();
	jQuery('body').addClass('signup');
	//Get template from server
	jQuery.get("http://localhost/tinderbox/public/templates/login_signup_template.html").done(function(response) {

		var content = jQuery(jQuery.parseHTML(response));

		//Compile main template
		var signup_template = Handlebars.compile(content.filter('#signup_template').html());

		// set html content
		jQuery('body').html(signup_template);
	});
}

function schedule_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return;
	}

	var endpoint = 'schedule';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: 'http://localhost/tinderbox/app/' + endpoint,
		contentType: 'application/json',
		type: 'GET',
		beforeSend: function(ajax)
		{
			ajax.setRequestHeader(
				'Authorization', login
			);
		},
		success: function(data, status, response)
		{
			// Get template from server
			jQuery.get("http://localhost/tinderbox/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile templates
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var schedule_template = Handlebars.compile(content.filter('#schedule_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
				}
				jQuery('body').removeClass();
				jQuery('body').addClass('site schedule');
				jQuery('main').html(schedule_template(data));
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return;
			}
		}
	});
}

function announcements_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return;
	}

	var endpoint = 'announcements';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: 'http://localhost/tinderbox/app/' + endpoint,
		contentType: 'application/json',
		type: 'GET',
		beforeSend: function(ajax)
		{
			ajax.setRequestHeader(
				'Authorization', login
			);
		},
		success: function(data, status, response)
		{
			// Get template from server
			jQuery.get("http://localhost/tinderbox/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile main template
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var announcements_template = Handlebars.compile(content.filter('#announcements_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
					jQuery('body').addClass('site');
				}
				jQuery('main').html(announcements_template(data));
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return;
			}
		}
	});
}

function locations_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return;
	}

	var endpoint = 'locations';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: 'http://localhost/tinderbox/app/' + endpoint,
		contentType: 'application/json',
		type: 'GET',
		beforeSend: function(ajax)
		{
			ajax.setRequestHeader(
				'Authorization', login
			);
		},
		success: function(data, status, response)
		{
			// Get template from server
			jQuery.get("http://localhost/tinderbox/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile main template
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var announcements_template = Handlebars.compile(content.filter('#locations_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
					jQuery('body').addClass('site');
				}
				jQuery('main').html(locations_template(data));
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return;
			}
		}
	});
}

function info_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return;
	}

	var endpoint = 'info';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: 'http://localhost/tinderbox/app/' + endpoint,
		contentType: 'application/json',
		type: 'GET',
		beforeSend: function(ajax)
		{
			ajax.setRequestHeader(
				'Authorization', login
			);
		},
		success: function(data, status, response)
		{
			// Get template from server
			jQuery.get("http://localhost/tinderbox/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile main template
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var announcements_template = Handlebars.compile(content.filter('#info_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
					jQuery('body').addClass('site');
				}
				jQuery('main').html(info_template(data));
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return;
			}
		}
	});
}

function log_out()
{
	localStorage.removeItem('login');
	login_page();
}

// declare all function BEFORE this point!!!!
// run on document start
if (localStorage.getItem('login') === null) // if local storage login not set
{
	login_page();
}
else
{
	schedule_page();
}

// some handlebars helpers
Handlebars.registerHelper('get_time', function(timestamp) { // returns time like this -> 7.15
	var date = new Date(timestamp);
	return ((date.getHours()<10?'0':'') + date.getHours()) + '.' + ((date.getMinutes()<10?'0':'') + date.getMinutes());
});

Handlebars.registerHelper('get_day', function(timestamp) { // returns tommorow or date
	var date = timestamp.split(' ');
	date = new Date(date[0]);
	var today = new Date();
	if(date.getFullYear() == today.getFullYear() && date.getMonth() == today.getMonth())
	{
		if(date.getDate() == (today.getDate()))
		{
			return 'Today';
		}
		else if(date.getDate() == (today.getDate() + 1))
		{
			return 'Tomorrow';
		}
		else if(date.getDate() == (today.getDate() + 2))
		{
			return 'Day After Tomorrow';
		}
	}
	else
	{
		var result = (date.toString()).split(' ');
		return result[0] + ' ' + result[1] + ' ' + result[2];
	}
});

// event listeners
jQuery('body').on('submit', '#login_form', function(event)
{
	event.preventDefault();
	if(jQuery('#email').val() === '' || jQuery('#password').val() === '')
	{
		// msg user -> email and password required
		return;
	}
	else
	{
		var email = jQuery('#email').val();
		var password = jQuery('#password').val();
		localStorage.setItem('login', ('Basic ' + btoa(email + ':' + password) + '=='));

		schedule_page();
	}

});

jQuery('body').on('click', '.announcements', function(event){
	event.preventDefault();
	announcements_page();
});
