/*
Author       : Theme_ocean.
Template Name: Accede - Consultancy HTML5 Template
Version      : 1.0
*/

(function ($) {
	'use strict';

	jQuery(document).on('ready', function () {

		/*PRELOADER JS*/
		$(window).on('load', function () {
			$('.status').fadeOut();
			$('.preloader').delay(350).fadeOut('slow');
		});
		/*END PRELOADER JS*/


		/*START MENU JS*/
		$('a.page-scroll').on('click', function (e) {
			var anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $(anchor.attr('href')).offset().top - 50
			}, 1500);
			e.preventDefault();
		});

		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('.menu-top').addClass('menu-shrink');
			} else {
				$('.menu-top').removeClass('menu-shrink');
			}
		});

		$(document).on('click', '.navbar-collapse.in', function (e) {
			if ($(e.target).is('a') && $(e.target).attr('class') != 'dropdown-toggle') {
				$(this).collapse('hide');
			}
		});
		/*END MENU JS*/

		/*START PROGRESS-BAR JS*/
		$('.progress-bar > span').each(function () {
			var $this = $(this);
			var width = $(this).data('percent');
			$this.css({
				'transition': 'width 2s'
			});

			setTimeout(function () {
				$this.appear(function () {
					$this.css('width', width + '%');
				});
			}, 500);
		});
		/*END PROGRESS-BAR JS*/


		/*START MIXITUP JS*/
		$('#portfolio .row').mixitup({
			targetSelector: '.portfolio-item',
		});

		$("a[class^='prettyPhoto']").prettyPhoto();
		/*END MIXITUP JS*/

		/*START TESTIMONIAL JS*/
		$(window).load(function () {
			$('.testi-slider').flexslider({
				animation: 'slide',
				prevText: "<i class='fa fa-long-arrow-left'></i>",
				nextText: "<i class='fa fa-long-arrow-right'></i>"
			});
		});
		$(window).load(function () {
			$('.testi-slider-blog').flexslider({
				animation: 'slide',
				prevText: "<i class='fa fa-long-arrow-left'></i>",
				nextText: "<i class='fa fa-long-arrow-right'></i>",
				itemWidth: 210,
				minItems: 1,
				maxItems: 3
			});
		});
		/*END TESTIMONIAL JS*/

		/*START COUNDOWN JS*/
		$('.counter_feature').on('inview', function (event, visible, visiblePartX, visiblePartY) {
			if (visible) {
				$(this).find('.timer').each(function () {
					var $this = $(this);
					$({ Counter: 0 }).animate({ Counter: $this.text() }, {
						duration: 2000,
						easing: 'swing',
						step: function () {
							$this.text(Math.ceil(this.Counter));
						}
					});
				});
				$(this).unbind('inview');
			}
		});
		/*END COUNDOWN JS */

		/*START PARTNER LOGO*/
		$('.partner').owlCarousel({
			autoPlay: 3000, //Set AutoPlay to 3 seconds
			items: 4,
			itemsDesktop: [1199, 3],
			itemsDesktopSmall: [979, 3]
		});
		/*END PARTNER LOGO*/

		/*START CONTACT MAP JS*/
		function initialize() {
			var mapOptions = {
				zoom: 18,
				scrollwheel: false,
				center: new google.maps.LatLng(39.480542, -0.389263)
			};
			var contentPoint = '<div id="content">' +
				'<div id="siteNotice">' +
				'</div>' +
				'<img src="http://localhost/avanza-backend/web/assets/img/logoInfoMap.png"></img>' +
				// '<h1 id="firstHeading" class="firstHeading">AVANZA</h1>' +
				// '<h2 id="firstHeading" class="firstHeading">Consultoría Informática</h2>' +
				'<div id="bodyContent">' +
				'<p>Calle Profesor Beltrán Báguena 5</br>' +
				'Piso 4º 46015 Valencia</p>' +
				'</div>' +
				'</div>';

			var infowindow = new google.maps.InfoWindow({
				content: contentPoint
			});

			var map = new google.maps.Map(document.getElementById('map'),
				mapOptions);

			var marker = new google.maps.Marker({
				position: map.getCenter(),
				icon: "http://localhost/avanza-backend/web/assets/img/punterolargo.png",
				map: map
			});

			marker.addListener('click', function () {
				infowindow.open(map, marker);
			});

		}
		google.maps.event.addDomListener(window, 'load', initialize);
		/*END CONTACT MAP JS*/

	});


})(jQuery);




