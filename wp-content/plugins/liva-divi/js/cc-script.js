(function($, window, document) {
    "use strict";

	var CC;

	CC = window.CC || {};

	CC.ClickShowMore = function() {
		$('.travel_style.tab_header').find('.show_more > a').on('click', function (el) {
			el.preventDefault();

			var $this 	= $(this),
				$todo	= $this.siblings('.cc-list-travel-style');

			if ($todo.hasClass('open')) {
				$todo.removeClass('open');
			} else {
				$todo.addClass('open');
			}
		})
	};

	$(document).ready(function() {
		CC.ClickShowMore();
	});

})(jQuery, window, document);


