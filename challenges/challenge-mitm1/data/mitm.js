$(function() {
	// The form starts disabled.
	$('#request_data').attr('disabled', true);

	// A click on the smartphone simulates the launch of the application
	// and thus, the request from the application is loaded.
	$('#clickable_layer_smartphone').click(function() {
		$.get('app.php', function(data) {
			loadRequestFromSmartphone(data);
		});
	});

	// Sends the XML data to the server when the button is clicked.
	// Disables the button and empties the form.
	$('#send_to_server').click(function() {
		$('#request_data').attr('disabled', true);
		xmlData = $('#request_data').val();
		$('#request_data').val('');
		sendToServer(xmlData);
	});

	// Sends the XML data to the smartphone when the button is clicked.
	// Disables the button and empties the form.
	$('#send_to_smartphone').click(function() {
		$('#request_data').attr('disabled', true);
		xmlData = $('#request_data').val();
		$('#request_data').val('');
		sendToSmartphone(xmlData);
	});
});

/**
 * Sends some XML data to the PHP script sumilating the application's server.
 * Triggers some JavaScript animations.
 */
function sendToServer(xmlData) {
	$('#send_to_server').addClass('disabled');
	$('#server img.loading').show();
	window.setTimeout(function() {
		$.ajax({
			type: "POST",
			url: 'server.php',
			data: xmlData,
		}).done(function(data) {
			loadResponseFromServer(data);
		}).always(function() {
			$('#server img.loading').hide();
		});
	}, 1500);
}

/**
 * Sends some XML data to the PHP script sumilating the application.
 * Triggers some JavaScript animations.
 */
function sendToSmartphone(xmlData) {
	$('#send_to_smartphone').addClass('disabled');
	$('#smartphone img.loading').show();
	window.setTimeout(function() {
		$.ajax({
			type: "POST",
			url: 'app.php',
			data: xmlData,
		}).done(function(response) {
			if(response != 'Application opened!') {
				accessDenied();
			}
			window.setTimeout(function() {
				document.location.reload();
			}, 500);
		}).always(function() {
			$('#smartphone img.loading').hide();
		});
	}, 1500);
}

/**
 * Loads the XML data of a request from the smartphone in the form.
 */
function loadRequestFromSmartphone(data) {
	$('#request_data').attr('disabled', false);
	$('#send_to_server').removeClass('disabled');
	$('#request_data').val(data);
}

/**
 * Loads the XML data of the response from the server in the form.
 */
function loadResponseFromServer(data) {
	$('#request_data').attr('disabled', false);
	$('#send_to_smartphone').removeClass('disabled');
	$('#request_data').val(data);
}

/**
 * Triggers some JavaScript animations corresponding to an access denied on the application.
 */
function accessDenied() {
	$('#access_denied').show();
	$('#smartphone').effect('shake');
	window.setTimeout(function() {
		$('#access_denied').hide();
	}, 500);
}