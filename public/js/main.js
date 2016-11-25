jQuery(function login(){
	jQuery.ajax({
		url: 'http://localhost/g8',
		contentType: 'application/json',
		type: 'GET',
		success: function(data, status, response)
		{
			console.log(status);
			
		}
	});
});