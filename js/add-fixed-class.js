jQuery(document).ready(function($) {
    console.log('fixed');
    $(window).scroll(function() {
        let scrollTop = $(this).scrollTop();

        if(scrollTop > 10) {
            $('.logo-btn-container').addClass('top');
        } else {
            $('.logo-btn-container').removeClass('top');
        }

        if (scrollTop > 150 ) {
             $('.logo-btn-container').removeClass('top');
            $('.logo-btn-container').addClass('fixed show');
        } else {
            $('.logo-btn-container').removeClass('fixed');
        }
		
    });
});
