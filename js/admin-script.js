jQuery(document).ready(function ($) {

	var customSabSeq = 0;

	$(document).on('sabsSizeChange input change', '#sabs-size', function () {
		var sizeText = 'Default';
		$('.sab').removeClass('sabs-size-small sabs-size-large');

		if($(this).val() == 1) {
			$('.sab').addClass('sabs-size-small');
			sizeText = 'Small';
		} else if($(this).val() == 3) {
			$('.sab').addClass('sabs-size-large');
			sizeText = 'Large';
		}

		$('#strSabsSize').html(sizeText);
	});

	$(document).on('click', '#trAddCustomSab #btnAddCustomSab', function (e, focusOnTextBox = true) {
		e.preventDefault();

		var trAddCustomSab = $(this).closest('#trAddCustomSab');
		var tmplHTML = $('#tmplAddCustomSabRow').html();

		tmplHTML = tmplHTML.replace(/INDEX/g, customSabSeq);

		trAddCustomSab.before(tmplHTML);

		customSabSeq++;

		if(focusOnTextBox) {
			$('html, body').animate({
				'scrollTop': trAddCustomSab.offset().top,
			}, 0);

			trAddCustomSab.prev('tr').find('.sabsCustom-icon').focus();
		}
	});

	$(document).on('change blur input', '.sabsCustom-icon', function () {
		var icofontClass = $(this).val() ?? '';
		var tr = $(this).closest('tr');

		tr.find('.sab-custom-icon').attr('class', 'sab-custom-icon ' + icofontClass);
	});

	function onColorChanged(element)
	{
		var tr = element.closest('tr');

		tr.find('.sab').css({
			'background': tr.find('.sabsCustom-bgColor').val() ?? '',
			'color': tr.find('.sabsCustom-color').val() ?? '',
		});
	}

	$(document).on('change colorChange', '.sabsCustom-bgColor, .sabsCustom-color', function () {
		onColorChanged($(this));
	});

	$(document).on('tickChange change', '.sabsCustom-withNotificationIcon', function () {
		var icon = $(this).closest('.trCustomSab').find('.sab');

		if($(this).is(':checked')) {
			icon.addClass('sab-with-notification');
		} else {
			icon.removeClass('sab-with-notification');
		}
	});

	$(document).on('click', '.btnDeleteCustomSab', function (e) {
		e.preventDefault();

		if(confirm('Are you sure you want to remove this Button?')) {
			$(this).closest('.trCustomSab').remove();
		}
	});

	function sabs_renderCustomFieldValidationError(field, message)
	{
		field.addClass('invalid');

		field.closest('label').append('<span class="invalid"><i class="icofont-warning-alt"></i></span>');
		field.closest('label').after('<p class="description invalid-feedback">' + message + '</p>');
	}

	var customSabs = typeof(oldSabsCustom) != 'undefined' ? oldSabsCustom : (typeof(currentCustomSabs) != 'undefined' ? currentCustomSabs : []);

	if(Array.isArray(customSabs) && customSabs.length > 0) {
		var fieldsName = [
			'bgColor', 'color', 'icon', 'action', 'withNotificationIcon',
		];

		var errors = typeof(oldSabsCustomErrors) != 'undefined' && Array.isArray(oldSabsCustomErrors) ? oldSabsCustomErrors : [];

		$.each(customSabs, function (i, btn) {
			$('#trAddCustomSab #btnAddCustomSab').trigger('click', [false]);

			var newTr = $('.trCustomSab:last');

			$.each(fieldsName, function (fieldNameIndex, fieldName) {
				var fieldElement = newTr.find('.sabsCustom-' + fieldName);

				if(typeof(fieldElement) != 'undefined' && fieldElement.length > 0) {
					if(typeof(btn[fieldName]) != 'undefined') {
						if(fieldElement.is('input:checkbox') || fieldElement.is('input:radio')) {
							if(btn[fieldName] == 'yes') {
								fieldElement.prop('checked', true);
							}
						} else {
							fieldElement.val(btn[fieldName]);
						}
					}
				}

				if(typeof(errors[i]) != 'undefined') {
					if(typeof(errors[i][fieldName]) != 'undefined') {
						sabs_renderCustomFieldValidationError(fieldElement, errors[i][fieldName]);
					}
				}
			});
		});
	}

	$('.sabsCustom-icon').trigger('blur');
	$('.sabsCustom-color').trigger('colorChange');
	$('.sabsCustom-withNotificationIcon').trigger('tickChange');
	$('#sabs-size').trigger('sabsSizeChange');

});