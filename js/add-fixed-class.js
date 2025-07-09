jQuery(document).ready(function($) {
    $(window).scroll(function() {
        let scrollTop = $(this).scrollTop();

        if (scrollTop > 450 ) {
            $('.logo-btn-container').addClass('fixed');
        } else {
            $('.logo-btn-container').removeClass('fixed');
        }
		
    });
});
