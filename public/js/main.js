jQuery(function()
{
	// Declare all function here
	function login_page()
	{
		// set html content
		var content = '<form method="post" id="login_form">' +
				'<div><label>Email</label><input id="email" type="text" name="email"></div>' +
				'<div><label>Password</label><input id="password" type="password" name="password"></div>' +
				'<input type="submit"></form>';

		jQuery('body').html(content);
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
				var schedule = '';
				for(var i in data)
				{
					schedule += '<p>' + data[i].start + '</p></br>' +
						'<p>' + data[i].end + '</p></br>' +
						'<p>' + data[i].task + '</p></br>' +
						'<p>' + data[i].team + '</p></br>' +
						'<p>' + data[i].location + '</p></br>';
				}
				jQuery('body').html(schedule);
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
});
