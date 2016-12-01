var base_url = 'http://localhost/tinderbox';

// Declare all functions here
function login_page()
{
	//Get template from server
	jQuery.get(base_url + "/public/templates/login_signup_template.html").done(function(response) {

		var content = jQuery(jQuery.parseHTML(response));

		//Compile main template
		var login_template = Handlebars.compile(content.filter('#login_template').html());

		// set html content
		jQuery('body').removeClass();
		jQuery('body').addClass('login');
		jQuery('body').html(login_template);
		window.scrollTo(0, 0);
		jQuery('body').hide().fadeIn();
	});
}

function signup_page()
{
	//Get template from server
	jQuery.get(base_url + "/public/templates/login_signup_template.html").done(function(response) {

		var content = jQuery(jQuery.parseHTML(response));

		//Compile main template
		var signup_template = Handlebars.compile(content.filter('#signup_template').html());

		// set html content
		jQuery('body').removeClass();
		jQuery('body').addClass('site signup');
		jQuery('body').html(signup_template);
		window.scrollTo(0, 0);
		jQuery('body').hide().fadeIn();
	});
}

function signup(userinfo)
{
	var endpoint = 'signup';

	var input_date = userinfo.birthdate;
	var output_date = input_date.split('/');
	userinfo.birthdate = output_date[2] + '-' + output_date[1] + '-' + output_date[0];

	jQuery.ajax(
	{
		url: base_url + '/app/' + endpoint,
		contentType: 'application/json',
		type: 'POST',
		data: JSON.stringify(userinfo),
		success: function(date, status, response)
		{
			alert('Signup successfull');
			login_page();
		},
		error: function(request, status, error)
		{
			signup_page();
			return false;
		}
	});
}

function schedule_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return false;
	}

	var endpoint = 'schedule';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: base_url + '/app/' + endpoint,
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
			jQuery.get(base_url + "/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile templates
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var schedule_template = Handlebars.compile(content.filter('#schedule_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
				}
				nav('schedule');
				jQuery('body').removeClass();
				jQuery('body').addClass('site schedule');
				jQuery('header h1').html('schedule');
				jQuery('main').html(schedule_template(data));
				window.scrollTo(0, 0);
				jQuery('main').hide().fadeIn();
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return false;
			}
		}
	});
}

function announcements_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return false;
	}

	var endpoint = 'announcements';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: base_url + '/app/' + endpoint,
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
			jQuery.get(base_url + "/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile main template
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var announcements_template = Handlebars.compile(content.filter('#announcements_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
				}
				nav('announcements');
				jQuery('body').removeClass();
				jQuery('body').addClass('site announcements');
				jQuery('header h1').html('announcements');
				jQuery('main').html(announcements_template(data));
				window.scrollTo(0, 0);
				jQuery('main').hide().fadeIn();
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return false;
			}
		}
	});
}

function locations_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return false;
	}

	var endpoint = 'userinfo';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: base_url + '/app/' + endpoint,
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
			jQuery.get(base_url + "/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile main template
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var locations_template = Handlebars.compile(content.filter('#locations_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
				}
				nav('locations');
				jQuery('body').removeClass();
				jQuery('body').addClass('site locations');
				jQuery('header h1').html('locations');
				jQuery('main').html(locations_template());
				window.scrollTo(0, 0);
				jQuery('main').hide().fadeIn();
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return false;
			}
		}
	});
}

function info_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return false;
	}

	var endpoint = 'userinfo';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: base_url + '/app/' + endpoint,
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
			jQuery.get(base_url + "/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile main template
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var info_template = Handlebars.compile(content.filter('#info_template').html());

				var page = {
					contact: {
						link : "#contacts",
						letter: "C",
						tittle: "contact",
						text: "Get in touch with the management"
					},
					general: {
						link : "",
						letter: "G",
						tittle: "general info",
						text: "Basic information about the festival"
					},
					team: {
						link : "",
						letter: "Y",
						tittle: "your team",
						text: "See who your teammates are"
					},
					rules: {
						link : "",
						letter: "R",
						tittle: "rules",
						text: "Important rules you should keep in mind"
					}
				};
				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
				}
				nav('information');
				jQuery('body').removeClass();
				jQuery('body').addClass('site information');
				jQuery('header h1').html('info');
				jQuery('main').html(info_template(page));
				window.scrollTo(0, 0);
				jQuery('main').hide().fadeIn();
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return false;
			}
		}
	});
}

function contacts_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return false;
	}

	var endpoint = 'userinfo';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: base_url + '/app/' + endpoint,
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
			jQuery.get(base_url + "/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile main template
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var contacts_template = Handlebars.compile(content.filter('#contacts_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
				}
				jQuery('body').removeClass();
				jQuery('body').addClass('site contacts');
				jQuery('header h1').html('contacts');
				jQuery('main').html(contacts_template());
				window.scrollTo(0, 0);
				jQuery('main').hide().fadeIn();
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return false;
			}
		}
	});
}

function settings_page()
{
	if (localStorage.getItem('login') === null)
	{
		login_page();
		return false;
	}

	var endpoint = 'userinfo';

	var login = localStorage.getItem('login');

	jQuery.ajax(
	{
		url: base_url + '/app/' + endpoint,
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
			jQuery.get(base_url + "/public/templates/app_pages_template.html").done(function(response) {

				var content = jQuery(jQuery.parseHTML(response));

				//Compile main template
				var page_template = Handlebars.compile(content.filter('#page_template').html());
				var settings_template = Handlebars.compile(content.filter('#settings_template').html());

				// check if the page template already exists
				if(!jQuery('body').hasClass('site'))
				{
					jQuery('body').html(page_template);
				}
				jQuery('body').removeClass();
				jQuery('body').addClass('site settings');
				jQuery('header h1').html('settings');
				jQuery('main').html(settings_template(data));
				window.scrollTo(0, 0);
				jQuery('main').hide().fadeIn();
			});
		},
		error: function(request, status, error)
		{
			if(error == 'Unauthorized')
			{
				// set error msg here
				login_page();
				return false;
			}
		}
	});
}

function log_out()
{
	localStorage.removeItem('login');
	document.location.hash = '#login';
}

// declare all function BEFORE this point!!!!
// run on document start
url_change();


// some handlebars helpers
Handlebars.registerHelper('get_time', function(timestamp) { // returns time like this -> 7.15
	var date = new Date(timestamp.replace(' ', 'T'));
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

Handlebars.registerHelper('time_since', function(datetime){
	var time = new Date(datetime.replace(' ', 'T'));

	var seconds = Math.floor((new Date() - time) / 1000);

	var interval = Math.floor(seconds / 31536000);
	if(interval > 1)
	{
		return interval + ' years';
	}

	interval = Math.floor(seconds / 2592000);
	if(interval > 1)
	{
		return interval + ' months';
	}

	interval = Math.floor(seconds / 86400);
	if(interval > 1)
	{
		return interval + ' days';
	}

	interval = Math.floor(seconds / 3600);
	if(interval > 1)
	{
		return interval + ' hours';
	}

	interval = Math.floor(seconds / 60);
	if(interval > 1)
	{
		return interval + ' minutes';
	}

	return Math.floor(seconds) + ' seconds';
});

Handlebars.registerHelper('times', function(n, block) {
    var accum = '';
    for(var i = 0; i < n; ++i)
        accum += block.fn(i);
    return accum;
});

// event listeners
jQuery('body').on('submit', '#login_form', function(event)
{
	event.preventDefault();
	if(jQuery('#email').val() === '' || jQuery('#password').val() === '')
	{
		alert('Email and Password required');
		return false;
	}
	else
	{
		var email = jQuery('#email').val();
		var password = jQuery('#password').val();
		localStorage.setItem('login', ('Basic ' + btoa(email + ':' + password) + '=='));

		document.location.hash = 'schedule';
		schedule_page();
	}
});

jQuery('body').on('submit', '#signup_form', function(event){
	event.preventDefault();
	if(
		jQuery('#fname').val() === '' ||
		jQuery('#lname').val() === '' ||
		jQuery('#email').val() === '' ||
		jQuery('#phone').val() === '' ||
		jQuery('#birthdate').val() === '' ||
		jQuery('#password').val() === '' ||
		jQuery('#shirt_size').val() === '' ||
		jQuery('#shoe_size').val() === '')
	{
		alert('All fields are required');
		return false;
	}
	else
	{
		var date_pattern = /^(0?[1-9]|[12][0-9]|3[01])([ \/])(0?[1-9]|1[012])\2([0-9][0-9][0-9][0-9])$/;
		if(date_pattern.test(jQuery('#birthdate').val()) === false)
		{
			alert('Please fill out birthdate in following format: dd/mm/yyyy');
			return false;
		}
	}
	var userinfo = {
		fname: jQuery('#fname').val(),
		lname: jQuery('#lname').val(),
		email: jQuery('#email').val(),
		phone: jQuery('#phone').val(),
		birthdate: jQuery('#birthdate').val(),
		password: jQuery('#password').val(),
		shirt_size: jQuery('#shirt_size').val(),
		shoe_size: jQuery('#shoe_size').val()
	};
	signup(userinfo);
});

jQuery('body').on('click', '#delete_user', function(event){
	event.preventDefault();
	if(confirm('Are you sure, you want to delete this account?'))
	{
		if (localStorage.getItem('login') === null)
		{
			login_page();
			return false;
		}

		var endpoint = 'delete_user';

		var login = localStorage.getItem('login');

		jQuery.ajax(
		{
			url: base_url + '/app/' + endpoint,
			contentType: 'application/json',
			type: 'DELETE',
			beforeSend: function(ajax)
			{
				ajax.setRequestHeader(
					'Authorization', login
				);
			},
			success: function(data, status, response)
			{
				//succesfully deleted
				window.location.hash = '#login';
				login_page();
			},
			error: function(request, status, error)
			{
				//something went wrong
			}
		});
	}
});

// bottom nav color manipulation
function nav(site)
{
	jQuery('nav ul li a').removeClass('active');
	jQuery('nav ul li a[href^="#' + site + '"]').addClass('active');

	// var icons = {
	// 	schedule: "fa-calendar",
	// 	announcements: "fa-comment",
	// 	locations: "fa-map",
	// 	information: "fa-info"
	// };
	//
	// jQuery('nav ul li a i').each(function(){
	// 	if((jQuery(this).attr('class')).indexOf(icons[site]) > -1)
	// 	{
	// 		var i_class = (jQuery(this).attr('class')).replace('-o ', ' ');
	// 		jQuery(this).removeClass();
	// 		jQuery(this).addClass(i_class);
	// 	}
	// 	else
	// 	{
	// 		// var o_class = jQuery(this).find('[class^="fa-"], :not([class$="x"])');
	// 		var o_class = jQuery(this).attr('class').split(' ');
	// 		console.log(o_class);
	// 		jQuery(this).removeClass(o_class);
	// 		jQuery(this).addClass(o_class + '-o ');
	// 	}
	// });
}

// url switch case
function url_change()
{
	var hash = window.location.hash;
	switch(hash) {
		case '#login':
			login_page();
			break;

		case '#signup':
			signup_page();
			break;

		case '#logout':
			log_out();
			break;

		case '#schedule':
			schedule_page();
			break;

		case '#announcements':
			announcements_page();
			break;

		case '#information':
			info_page();
			break;

		case '#locations':
			locations_page();
			break;

		case '#contacts':
			contacts_page();
			break;

		case '#settings':
			settings_page();
			break;

		default:
			schedule_page();
			break;
	}
}

// if page refreshed
if(window.performance)
{
	if(performance.navigation.type  == 1)
	{
		url_change();
	}
}

// if url changes
window.onhashchange = function(){
	url_change();
};
