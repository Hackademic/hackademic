$(function() {
	$('[placeholder]').bind('propertychange', function() {
		var input = $(this);
		if(input.val()!=input.attr('placeholder')) {
			input.removeClass('placeholder');
			input.css('color', 'black');
		}
	}).focus(function() {
		var input = $(this);
		if(input.val()==input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
			input.css('color', 'black');
		}
	}).blur(function() {
		var input = $(this);
		if(input.val()=='' || input.val()==input.attr('placeholder')) {
			if(input.attr('type')=='password') {
				input.addClass('password_hide');
				// Creates new text field for password placeholder:
				var input_show = $('<input type="text" class="password_show"/>');
				input_show.val(input.attr('placeholder'));
				input_show.css('color', 'grey');
				input_show.insertBefore(input);
				input_show.focus(function() {
					$(this).next().removeClass('password_hide').show().focus();
					$(this).remove();
				}).bind('propertychange', function() {
					$(this).next().removeClass('password_hide').show().focus();
					$(this).remove();
				});
				input.hide();
			} else {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
				input.css('color', 'grey');
			}
		}
	}).blur();
	
	$('[placeholder]').parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if(input.val() == input.attr('placeholder')) {
				input.val('');
			}
		})
	});
	
	$('#file').change(function() {
	   $('#file-bootstrap').val($(this).val().replace('C:\\fakepath\\', ''));
	});
});