$(function() {
	$('#request_data').attr('disabled', true);

	$('#clickable_layer_smartphone').click(function() {
		$('#smartphone img.loading').show();
		$.get('app.php', function(data) {
			$('#smartphone img.loading').hide();
			loadRequestFromSmartphone(data);
		});
	});

	$('#send_to_server').click(function() {
		$('#request_data').attr('disabled', true);
		xmlData = $('#request_data').val();
		$('#request_data').val('');
		sendToServer(xmlData);
	});

	$('#send_to_smartphone').click(function() {
		$('#request_data').attr('disabled', true);
		xmlData = $('#request_data').val();
		$('#request_data').val('');
		sendToSmartphone(xmlData);
	});
});

function sendToServer(xmlData) {
	$('#send_to_server').addClass('disabled');
	$('#server img.loading').show();
	$.ajax({
		type: "POST",
		url: 'server.php',
		data: xmlData,
	}).done(function(data) {
		loadResponseFromServer(data);
	}).always(function() {
		$('#server img.loading').hide();
	});
}

function sendToSmartphone(xmlData) {
	$('#send_to_smartphone').addClass('disabled');
	$('#smartphone img.loading').show();
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
}

function loadRequestFromSmartphone(data) {
	$('#request_data').attr('disabled', false);
	$('#send_to_server').removeClass('disabled');
	$('#request_data').val(data);
}

function loadResponseFromServer(data) {
	$('#request_data').attr('disabled', false);
	$('#send_to_smartphone').removeClass('disabled');
	$('#request_data').val(data);
}

function accessDenied() {
	$('#access_denied').show();
	$('#smartphone').effect('shake');
	window.setTimeout(function() {
		$('#access_denied').hide();
	}, 500);
}