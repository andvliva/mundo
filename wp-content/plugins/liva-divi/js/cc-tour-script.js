(function($, window, document) {
    "use strict";

	var CC;

	CC = window.CC || {};

	CC.CreateLoading = function() {
		$('<div/>', {
			id: 'cc-loading'
		}).appendTo('body');

		$('#cc-loading').append('<span></span>');
	};

	CC.TourFilterToogle = function() {
		if (('.cc-filter-all').length) {
			var $ccfilterall = $('.cc-filter-all');

			$ccfilterall.find('.cc-filters > h3').on('click', function () {
				var $this = $(this),
					$filter = $this.parent('.cc-filters');

				if ($filter.hasClass('active')) {
					$filter.removeClass('active');
				} else {
					$filter.addClass('active');
				}
			});

			$('.parent-destination').each(function () {
				var $this = $(this);

				$this.find('.open').on('click', function () {
					$this.addClass('open');
				});

				$this.find('.close').on('click', function () {
					$this.removeClass('open');
				});
			});
		}
	};

	CC.TourCreateFilter = function($name, $checked, $val, $s) {
		$name = $name.replace("[]", "");

		if ($checked === 1) {
			$('.r-f_' + $name).append("<div class=\"r-c\" id='cc-" + $val + "'>" + $s + "<span>x</span></div>");

			if ($('.r-f_' + $name).hasClass('no-content')) {
				$('.r-f_' + $name).removeClass('no-content');
				$('.r-f_' + $name).addClass('has-content');
			}

			CC.TourClickCloseFilter();
		} else if ($checked === 0) {
			$('#cc-' + $val).remove();

			if ($('.r-f_' + $name).find('.r-c').length) {

			} else {
				$('.r-f_' + $name).removeClass('has-content');
				$('.r-f_' + $name).addClass('no-content');
			}
		}
	};

	CC.TourClickCloseFilter = function() {
		var $loading 	= $('#cc-loading'),
			$page		= $('.cc-tour-page'),
			$content	= $page.find('.cc-tour-content'),
			$filter_all	= $page.find('.cc-clear-all'),
			$c_url		= $page.find('.current_url'),
			$total		= $page.find('.cc-result-found .total_posts'),
			$rf_content	= $page.find('.cc-result-filter .result-filter-content');

		$('.r-c').find('span').on('click', function() {
			var $this 	= $(this),
				$rc		= $this.parents('.r-c'),
				$id		= $rc.attr('id'),
				$val	= $id.replace("cc-", ""),
				$rf		= $this.parents('.r-f'),
				$rid	= $rf.attr('id'),
				$name	= $rid.replace("cc-", ""),
				$c_url_val	= $c_url.val();

			var data = {
				'action' : 'cc_tour_page_ajax_filter',
				'checked': 0,
				'c_url'	: $c_url_val
			};

			data[$name] = $val;

			$.ajax({
				method: 'POST',
				url: cc_script.ajax_url,
				data: data,
				dataType: 'json',
				beforeSend: function() {
					$loading.addClass('open');
				},
				success: function(response) {
					$loading.removeClass('open');

					$content.empty();
					$content.html(response.text).hide().fadeIn(2000);

					if (cc_script.filter_url === 'off') {
						window.history.replaceState({}, '', response.new_url);
					}

					$c_url.val(response.new_url);

					$total.empty();
					$total.html(response.count);

					if( $('#tours_travel_style').length && $( window ).width()>=500 ) {
						setTimeout(function() {
							$('#tours_travel_style .post_content').height('auto').vjustify();
							$('#tours_travel_style .post-thumbnail a').height('auto').vjustify();
							$('#tours_travel_style .item').height('auto').vjustify();
						}, 1e3);
					}

					if (response.has_filter === 'cc') {
						$filter_all.addClass('has-checked');
					} else {
						$filter_all.removeClass('has-checked');
					}

					$rc.remove();

					if ($rf.find('.r-c').length === 0) {
						$rf.removeClass('has-content');
						$rf.addClass('no-content');
					}

					$('.cc-filter-all').find('.cc-filters input').each(function () {
						if ($(this).attr('value') === $val) {
							$(this).removeAttr('checked');
						}
					})
				},
				error: function (response) {
					console.log(response);
				}
			});
		});
	};

	CC.TourFiterAjax = function() {
		var $loading 	= $('#cc-loading'),
			$page		= $('.cc-tour-page'),
			$content	= $page.find('.cc-tour-content'),
			$filter_all	= $page.find('.cc-filter-all'),
			$c_url		= $page.find('.current_url'),
			$total		= $page.find('.cc-result-found .total_posts'),
			$rf_content	= $page.find('.cc-result-filter .result-filter-content');

		$('.cc-single-filter input[type="checkbox"]').change(function() {
			var $this = $(this),
				$name		= $this.attr('name'),
				$val		= $this.val(),
				$c_url_val	= $c_url.val(),
				$checked;

			if ($this[0].checked) {
				$checked = 1;
			} else {
				$checked = 0;
			}

			CC.TourCreateFilter($name, $checked, $val, $this.attr('data-s'));

			var data = {
				'action' : 'cc_tour_page_ajax_filter',
				'checked': $checked,
				'c_url'	: $c_url_val
			};

			data[$name] = $val;

			CC.TourPageAjax(data, '', $(this));
		});

		$('.cc-per-page select').change(function () {
			var $this 	= $(this),
				$c_url_val	= $c_url.val(),
				$val	= $this.val();

			var data = {
				'action' : 'cc_tour_page_ajax_filter',
				'post_per_page': $val,
				'c_url'	: $c_url_val
			};

			CC.TourPageAjax(data, '', $(this));

		});

		$('.cc-sort-by select').change(function () {
			var $this 	= $(this),
				$c_url_val	= $c_url.val(),
				$val	= $this.val();

			var data = {
				'action' : 'cc_tour_page_ajax_filter',
				'sort_by': $val,
				'c_url'	: $c_url_val
			};

			CC.TourPageAjax(data, '', $(this));
		});

		$('.cc-search input').keyup(function(e){
			if(e.keyCode == 13) {
				$(this).trigger("enterKey");
			}
		});

		$('.cc-search input').bind('enterKey', function () {
			var $this 		= $(this),
				$c_url_val	= $c_url.val(),
				$val		= $this.val();

			var data = {
				'action' 	: 'cc_tour_page_ajax_filter',
				's_tour'	: $val,
				'c_url'		: $c_url_val
			};

			CC.TourPageAjax(data, '', $(this));
		});

		$('.cc-clear-all').on('click', function() {
			var $this 		= $(this),
				$c_url_val	= $c_url.val();

			var data = {
				'action' : 'cc_tour_page_ajax_filter',
				'c_url'	: $c_url_val,
				'clear_all': 'cc'
			};

			CC.TourPageAjax(data, '', $(this));
		});
	};

	CC.RangerSlider = function() {
		$('.cc-duration').jRange({
			from: 1,
			to: 32,
			step: 1,
			format: '%s ' + cc_script.duration_label,
			showScale: false,
			showLabels: true,
			isRange : true,
			ondragend: function () {
				var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

				var data = {
					'action' 		: 'cc_tour_page_ajax_filter',
					'duration_tour'	: $('.cc-duration').val(),
					'c_url'			: $c_url_val
				};

				var t = $('.cc-duration').val().split(','),
					z = t[0] + cc_script.duration_label + ' - ' + t[1] + cc_script.duration_label;

				$('.r-f_duration_tour').find('.r-c').remove();
				$('.r-f_duration_tour').append("<div class=\"r-c\" id='cc-duration_tour'>" + z + "<span>x</span></div>");
				$('.r-f_duration_tour').removeClass('no-content');
				$('.r-f_duration_tour').addClass('has-content');

				$('.r-f_duration_tour span').on('click', function () {
					var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

					var data = {
						'action' 		: 'cc_tour_page_ajax_filter',
						'remove_action'	: 'duration',
						'c_url'			: $c_url_val
					};

					CC.TourPageAjax(data, 'remove_duration_filter', $(this));
				});

				CC.TourPageAjax(data, '', $(this));

			}
		});

		$('.r-f_duration_tour span').on('click', function () {
			var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

			var data = {
				'action' 		: 'cc_tour_page_ajax_filter',
				'remove_action'	: 'duration',
				'c_url'			: $c_url_val
			};

			CC.TourPageAjax(data, 'remove_duration_filter', $(this));
		});

		$('.cc-price').jRange({
			from: 1,
			to: 2500,
			step: 100,
			scale: '',
			format: '%s ' + cc_script.price_val,
			showLabels: true,
			showScale: false,
			isRange : true,
			ondragend: function () {
				var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

				var data = {
					'action' 		: 'cc_tour_page_ajax_filter',
					'filter_price'	: $('.cc-price').val(),
					'c_url'			: $c_url_val
				};

				var t = $('.cc-price').val().split(','),
					z = '$' + t[0] + ' - ' + '$' + t[1];

				$('.r-f_price').find('.r-c').remove();
				$('.r-f_price').append("<div class=\"r-c\" id='cc-f_price'>" + z + "<span>x</span></div>");
				$('.r-f_price').removeClass('no-content');
				$('.r-f_price').addClass('has-content');

				$('.r-f_price span').on('click', function () {
					var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

					var data = {
						'action' 		: 'cc_tour_page_ajax_filter',
						'remove_action'	: 'price',
						'c_url'			: $c_url_val
					};

					CC.TourPageAjax(data, 'remove_price_filter', $(this));
				});

				CC.TourPageAjax(data, '', $(this));
			}
		});

		$('.r-f_price span').on('click', function () {
			var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

			var data = {
				'action' 		: 'cc_tour_page_ajax_filter',
				'remove_action'	: 'price',
				'c_url'			: $c_url_val
			};

			CC.TourPageAjax(data, 'remove_price_filter', $(this));
		});
	};

	CC.TourPageAjax = function(data, $func, $el) {
		var $loading 	= $('#cc-loading'),
			$page		= $('.cc-tour-page'),
			$content	= $page.find('.cc-tour-content'),
			$filter_all	= $page.find('.cc-clear-all'),
			$c_url		= $page.find('.current_url'),
			$total		= $page.find('.cc-result-found .total_posts');

		$.ajax({
			method: 'POST',
			url: cc_script.ajax_url,
			data: data,
			dataType: 'json',
			beforeSend: function() {
				$loading.addClass('open');
			},
			success: function(response) {
				$loading.removeClass('open');

				$content.empty();
				$content.html(response.text).hide().fadeIn(2000);

				if (cc_script.filter_url === 'off') {
					window.history.replaceState({}, '', response.new_url);
				}

				$c_url.val(response.new_url);

				$total.empty();
				$total.html(response.count);

				if( $('#tours_travel_style').length && $( window ).width()>=500 ) {
					setTimeout(function() {
						$('#tours_travel_style .post_content').height('auto').vjustify();
						$('#tours_travel_style .post-thumbnail a').height('auto').vjustify();
						$('#tours_travel_style .item').height('auto').vjustify();
					}, 1e3);
				}

				if (response.has_filter === 'cc') {
					$filter_all.addClass('has-checked');
				} else {
					$filter_all.removeClass('has-checked');

					$('.result-filter-content').find('.r-f').removeClass('has-content');
					$('.result-filter-content').find('.r-f').addClass('no-content');
				}

				//Custom action by function
				if ($func === 'remove_price_filter') {
					$('.r-f_price').removeClass('has-content');
					$('.r-f_price').addClass('no-content');
					$('.r-f_price').find('.r-c').remove();
				}

				if ($func === 'remove_duration_filter') {
					$('.r-f_duration_tour').removeClass('has-content');
					$('.r-f_duration_tour').addClass('no-content');
					$('.r-f_duration_tour').find('.r-c').remove();
				}

				if ($func == 'depaturemonth') {
					$el.parents('.cc-departure-month').find('li').removeClass('active');
					$el.addClass('active');
				}

				if ($func == 'remove_departure_filter') {
					$('.r-f_departure').removeClass('has-content');
					$('.r-f_departure').addClass('no-content');
					$('.r-f_departure').find('.r-c').remove();
				}
			},
			error: function (response) {
				console.log(response);
			}
		});
	};

	CC.DatePicker = function() {
		$.datepicker.formatDate( "yy-mm-dd", new Date( 2007, 1 - 1, 26 ) );

		$(".cc_date_picker").datepicker({
			dateFormat: "dd-mm-yy",
			changeMonth: true,
			changeYear: true,
			dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
		});
	};

	CC.TourPageDepatureMonth = function() {
		$('.cc-departure-month').find('li').on('click', function () {
			var $this = $(this),
				$parents 		= $(this).parents('.cc-departure-month'),
				$val 			= $this.attr('data-d'),
				$departure_date = $parents.siblings('.cc-departure-date'),
				$start_date		= $departure_date.find('.cc_start_date'),
				$end_date		= $departure_date.find('.cc_end_date');

			var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

			var data = {
				'action' 			: 'cc_tour_page_ajax_filter',
				'departure_month'	: $val,
				'c_url'				: $c_url_val
			};

			if ($start_date.val() !== '' && $end_date.val() !== '') {

			} else {
				$('.r-f_departure').find('.r-c').remove();
				$('.r-f_departure').append("<div class=\"r-c\" id='cc-f_departure'>" + $val + "<span>x</span></div>");
				$('.r-f_departure').removeClass('no-content');
				$('.r-f_departure').addClass('has-content');

				$('.r-f_departure span').on('click', function () {
					var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

					var data = {
						'action' 		: 'cc_tour_page_ajax_filter',
						'remove_action'	: 'departure',
						'c_url'			: $c_url_val
					};

					CC.TourPageAjax(data, 'remove_departure_filter', $(this));
				});

				CC.TourPageAjax(data, 'depaturemonth', $this);
			}
		})
	};

	CC.TourPageDepatureDate = function() {
		$('.cc_start_date').on('change', function () {
			var $this = $(this),
				$end_date = $this.siblings('.cc_end_date');

			if ($end_date.val() !== '') {
				var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

				var data = {
					'action' 				: 'cc_tour_page_ajax_filter',
					'departure_start_date'	: $this.val(),
					'departure_end_date'	: $end_date.val(),
					'c_url'					: $c_url_val
				};

				$('.r-f_departure').find('.r-c').remove();
				$('.r-f_departure').append("<div class=\"r-c\" id='cc-f_departure'>" + $this.val() + ' ' + $end_date.val() + "<span>x</span></div>");
				$('.r-f_departure').removeClass('no-content');
				$('.r-f_departure').addClass('has-content');

				$('.r-f_departure span').on('click', function () {
					var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

					var data = {
						'action' 		: 'cc_tour_page_ajax_filter',
						'remove_action'	: 'departure',
						'c_url'			: $c_url_val
					};

					CC.TourPageAjax(data, 'remove_departure_filter', $(this));
				});

				CC.TourPageAjax(data, 'depaturedate', $this);
			}
		}),

		$('.cc_end_date').on('change', function () {
			var $this = $(this),
				$start_date = $this.siblings('.cc_start_date');

			if ($start_date.val() !== '') {
				var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

				var data = {
					'action' 				: 'cc_tour_page_ajax_filter',
					'departure_start_date'	: $start_date.val(),
					'departure_end_date'	: $this.val(),
					'c_url'					: $c_url_val
				};

				$('.r-f_departure').find('.r-c').remove();
				$('.r-f_departure').append("<div class=\"r-c\" id='cc-f_departure'>" + $start_date.val() + $this.val() + "<span>x</span></div>");
				$('.r-f_departure').removeClass('no-content');
				$('.r-f_departure').addClass('has-content');

				$('.r-f_departure span').on('click', function () {
					var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

					var data = {
						'action' 		: 'cc_tour_page_ajax_filter',
						'remove_action'	: 'departure',
						'c_url'			: $c_url_val
					};

					CC.TourPageAjax(data, 'remove_departure_filter', $(this));
				});

				CC.TourPageAjax(data, 'depaturedate', $this);
			}
		})
	};

	CC.TourPageClearAll = function() {
		$('.cc-clear-all').on('click', function () {
			var $c_url_val	= $('.cc-tour-page').find('.current_url').val();

			var data = {
				'action' 	: 'cc_tour_page_ajax_filter',
				'clear_all'	: 'cc',
				'c_url'		: $c_url_val
			};

			CC.TourPageAjax(data, '', $(this));
		});
	};

	$(document).ready(function() {
		$('.cc-select').amyuiFancySelect();

		CC.CreateLoading();
		CC.TourFilterToogle();
		CC.TourFiterAjax();
		CC.RangerSlider();
		CC.DatePicker();
		CC.TourPageDepatureMonth();
		CC.TourPageDepatureDate();
		//CC.TourClickCloseFilter();
		CC.TourPageClearAll();
	});

})(jQuery, window, document);


