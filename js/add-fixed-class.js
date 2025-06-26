jQuery(document).ready(function($) {
    $(window).scroll(function() {
        let scrollTop = $(this).scrollTop();
        let lightLilacOffset = $('.full-container.related-slider').offset().top;

        if (scrollTop > 450 ) {
            $('.news-single .quick-links').addClass('fixed');
        } else {
            $('.news-single .quick-links').removeClass('fixed');
        }
		
		if (scrollTop + $(window).height() > lightLilacOffset) {
            $('.news-single .quick-links').removeClass('fixed');
        }
    });
});
