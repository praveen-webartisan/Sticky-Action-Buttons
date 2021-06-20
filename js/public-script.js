(function ($) {

	$(document).ready(function () {
		// Remove Buttons having Invalid JS functions as Action
		$('.sabs-container > .sab[onclick]:not([onclick="javascript:void(0);"])').each(function () {
			var method = $(this).attr('onclick');

			if(typeof(window[method]) == 'function') {
				$(this).click(function (e) {
					window[method]();
				});
			} else {
				$(this).remove();
			}
		});

		// Show/Hide Buttons container (Collapsible Mode)
		function toggleSabsContainer(sabsContainer, action = 'show')
		{
			if(action == 'show') {
				sabsContainer.addClass('sabs-collapsible-expanded');

				setTimeout(function () {
					sabsContainer.children('.sab:not(.sab-toggle-collapsible)').addClass('sab-collapsible-visible');
				}, 100);
			} else {
				sabsContainer.children('.sab:not(.sab-toggle-collapsible)').removeClass('sab-collapsible-visible');

				setTimeout(function () {
					sabsContainer.removeClass('sabs-collapsible-expanded');
				}, 100);
			}
		}

		if($('.sabs-container > .sab').length == 0) {
			// Hide container if there's no Buttons found
			$('.sabs-container').addClass('sabs-hide-container');
		} else {
			$('.sabs-container').removeClass('sabs-hide-container');

			if($('.sabs-container').hasClass('sabs-view-mode-collapsible')) {
				if($('.sabs-container.sabs-view-mode-collapsible').hasClass('sabs-collapsible-mode-click')) {
					// Collapsible Mode - Click
					$('.sabs-container.sabs-view-mode-collapsible.sabs-collapsible-mode-click > .sab.sab-toggle-collapsible').click(function () {
						var sabsContainer = $(this).closest('.sabs-container');

						if(sabsContainer.hasClass('sabs-collapsible-expanded')) {
							toggleSabsContainer(sabsContainer, 'hide');
						} else {
							toggleSabsContainer(sabsContainer, 'show');
						}
					});
				} else {
					// Collapsible Mode - Mouse Hover
					$('.sabs-container.sabs-view-mode-collapsible > .sab.sab-toggle-collapsible').mouseenter(function () {
						toggleSabsContainer($(this).closest('.sabs-container'), 'show');
					});

					$('.sabs-container.sabs-view-mode-collapsible').mouseleave(function () {
						toggleSabsContainer($(this).closest('.sabs-container'), 'hide');
					});
				}


				// Hide on pressing [Esc]
				$(document).on('keyup', function (e) {
					if($('.sabs-container.sabs-view-mode-collapsible.sabs-collapsible-expanded').length > 0) {
						if((e.which || e.keyCode) == 27) {
							$('.sabs-container.sabs-view-mode-collapsible.sabs-collapsible-expanded > .sab-toggle-collapsible').trigger('click');

							if(document.activeElement != document) {
								document.activeElement.blur();
							}
						}
					}
				});
			}
		}
	});

}) (jQuery);