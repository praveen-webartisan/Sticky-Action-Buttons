(function ($) {

	var customSabSeq = 0;

	// Change Preview Button Size
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

	// Add New Custom Button
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

	// Change Preview Button Icon
	$(document).on('change blur input', '.sabsCustom-icon', function () {
		var icofontClass = $(this).val() ?? '';
		var tr = $(this).closest('tr');

		tr.find('.sab-custom-icon').attr('class', 'sab-custom-icon ' + icofontClass);
	});

	// Change Preview Button Color
	function onColorChanged(element)
	{
		var tr = element.closest('tr');

		tr.find('.sab').css({
			'background-color': tr.find('.sabsCustom-bgColor').val() ?? '',
			'color': tr.find('.sabsCustom-color').val() ?? '',
		});
	}

	$(document).on('change colorChange', '.sabsCustom-bgColor, .sabsCustom-color', function () {
		onColorChanged($(this));
	});

	// Show/Hide Preview Button Notification Icon
	$(document).on('tickChange change', '.sabsCustom-withNotificationIcon', function () {
		var icon = $(this).closest('.trCustomSab').find('.sab');

		if($(this).is(':checked')) {
			icon.addClass('sab-with-notification');
		} else {
			icon.removeClass('sab-with-notification');
		}
	});

	// Delete Custom Button
	$(document).on('click', '.btnDeleteCustomSab', function (e) {
		e.preventDefault();

		if(confirm('Are you sure you want to remove this Button?')) {
			$(this).closest('.trCustomSab').remove();
		}
	});

	// Show/Hide [Collapsible] mode child fields
	$(document).on('change viewModeChange', '#sabsViewMode', function () {
		var viewMode = $(this).val();

		if(viewMode == 'collapsible') {
			$('.showOnViewModeCollapsible').show();
		} else {
			$('.showOnViewModeCollapsible').hide();
		}
	});

	// Change [Toggle Collapsible Preview Button] Icon
	$(document).on('change blur input iconChange', '#sabsCollapseButtonIcon', function () {
		var icon = $(this).val() ?? '';

		$(this).closest('tr').find('.sab').children('i').attr('class', icon);
	});

	// Change [Toggle Collapsible Preview Button] Color
	$(document).on('change colorChange', '#sabsCollapseButtonBgColor, #sabsCollapseButtonIconColor', function () {
		var tr = $(this).closest('tr');

		tr.find('.sab').css({
			'background-color': tr.find('#sabsCollapseButtonBgColor').val() ?? '',
			'color': tr.find('#sabsCollapseButtonIconColor').val() ?? '',
		});
	});

	// Show Validation Error messages for Custom Buttons
	function sabs_renderCustomFieldValidationError(field, message)
	{
		field.addClass('invalid');

		field.closest('label').append('<span class="invalid"><i class="icofont-warning-alt"></i></span>');
		field.closest('label').after('<p class="description invalid-feedback">' + message + '</p>');
	}

	// Create Custom Buttons from [Array] of values
	function sabs_renderCustomButtons()
	{
		/**
		 * oldSabsCustom - previously submitted values
		 * currentCustomSabs - saved values
		 * */
		var customSabs = typeof(oldSabsCustom) != 'undefined' ? oldSabsCustom : (typeof(currentCustomSabs) != 'undefined' ? currentCustomSabs : []);

		if(Array.isArray(customSabs) && customSabs.length > 0) {
			// Attributes of Custom Buttons
			var fieldsName = [
				'bgColor', 'color', 'icon', 'action', 'withNotificationIcon',
			];

			// Check if there's any Validation Error with the previously submitted data
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

		// Trigger custom events to the Button styling elements
		if($('.sabsCustom-icon').length > 0) {
			$('.sabsCustom-icon').trigger('blur');
		}

		if($('.sabsCustom-color').length > 0) {
			$('.sabsCustom-color').trigger('colorChange');
		}

		if($('.sabsCustom-withNotificationIcon').length > 0) {
			$('.sabsCustom-withNotificationIcon').trigger('tickChange');
		}

		if($('#sabs-size').length > 0) {
			$('#sabs-size').trigger('sabsSizeChange');
		}

		if($('#sabsViewMode').length > 0) {
			$('#sabsViewMode').trigger('viewModeChange');
		}

		if($('#sabsCollapseButtonIcon').length > 0) {
			$('#sabsCollapseButtonIcon').trigger('iconChange');
		}

		if($('#sabsCollapseButtonBgColor').length > 0) {
			$('#sabsCollapseButtonBgColor').trigger('colorChange');
		}
	}

	$(document).ready(function () {
		sabs_renderCustomButtons();
	});

}) (jQuery);