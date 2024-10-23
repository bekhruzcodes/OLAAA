(function ($) {
    'use strict';

    var $window = $(window);

    // :: 1.0 Masonary Gallery Active Code

    var proCata = $('.amado-pro-catagory');
    var singleProCata = ".single-products-catagory";

    if ($.fn.imagesLoaded) {
        proCata.imagesLoaded(function () {
            proCata.isotope({
                itemSelector: singleProCata,
                percentPosition: true,
                masonry: {
                    columnWidth: singleProCata
                }
            });
        });
    }

    // :: 2.1 Search Active Code
    var amadoSearch = $('.search-nav');
    var searchClose = $('.search-close');

    amadoSearch.on('click', function () {
        $('body').toggleClass('search-wrapper-on');
    });

    searchClose.on('click', function () {
        $('body').removeClass('search-wrapper-on');
    });

    // :: 2.2 Mobile Nav Active Code
    var amadoMobNav = $('.amado-navbar-toggler');
    var navClose = $('.nav-close');

    amadoMobNav.on('click', function () {
        $('.header-area').toggleClass('bp-xs-on');
    });

    navClose.on('click', function () {
        $('.header-area').removeClass('bp-xs-on');
    });

    // :: 3.0 ScrollUp Active Code
    if ($.fn.scrollUp) {
        $.scrollUp({
            scrollSpeed: 1000,
            easingType: 'easeInOutQuart',
            scrollText: '<i class="fa fa-angle-up" aria-hidden="true"></i>'
        });
    }

    // :: 4.0 Sticky Active Code
    $window.on('scroll', function () {
        if ($window.scrollTop() > 0) {
            $('.header_area').addClass('sticky');
        } else {
            $('.header_area').removeClass('sticky');
        }
    });

    // :: 5.0 Nice Select Active Code
    if ($.fn.niceSelect) {
        $('select').niceSelect();
    }

    // :: 6.0 Magnific Active Code
    if ($.fn.magnificPopup) {
        $('.gallery_img').magnificPopup({
            type: 'image'
        });
    }

    // :: 7.0 Nicescroll Active Code
    if ($.fn.niceScroll) {
        $(".cart-table table").niceScroll();
    }

    // :: 8.0 wow Active Code
    if ($window.width() > 767) {
        new WOW().init();
    }

    // :: 9.0 Tooltip Active Code
    if ($.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // :: 10.0 PreventDefault a Click
    $("a[href='#']").on('click', function ($) {
        $.preventDefault();
    });

  // :: 11.0 Slider Range Price Active Code
  $('.slider-range-price').each(function () {
    var min = jQuery(this).data('min');
    var max = jQuery(this).data('max');
    var unit = jQuery(this).data('unit');
    var value_min = jQuery(this).data('value-min');
    var value_max = jQuery(this).data('value-max');
    var label_result = jQuery(this).data('label-result');
    var t = $(this);

   
    // Initialize the slider
    $(this).slider({
        range: true,
        min: min,
        max: max,
        values: [value_min, value_max],
        slide: function (event, ui) {
            // Update the result label on slide
            var result = label_result + " " + unit + ui.values[0] + ' - ' + unit + ui.values[1];
            t.closest('.slider-range').find('.range-price').html(result);
        },
        stop: function (event, ui) {
            // Get min and max values after stop dragging
            let minPrice = ui.values[0];
            let maxPrice = ui.values[1];

            // Send the GET request when the slider stops moving
            $.ajax({
                url: 'http://localhost/My_folder/Funday/Olaaa/App/core.php',  // Replace with your actual endpoint
                method: 'GET',
                data: {
                    min_price: minPrice,
                    max_price: maxPrice
                },
                success: function (response) {
                    // Handle the response if needed
                    console.log("Request successful", response);
            
                    // Refresh the current page
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle any errors if needed
                    console.error("Request failed", error);
            
                    // Refresh the current page even on error
                    location.reload();
                }
            });
        }
    });

    // Set the initial display of the price range
    var initial_result = label_result + " " + unit + value_min + ' - ' + unit + value_max;
    t.closest('.slider-range').find('.range-price').html(initial_result);
});
})(jQuery);


