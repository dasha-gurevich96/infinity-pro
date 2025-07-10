jQuery(document).ready(function($) {
    const mediaQuery = window.matchMedia("(max-width: 990px)"); // example: tablets and up

    $(window).on('scroll resize', function() {
        let scrollTop = $(this).scrollTop();

        if (mediaQuery.matches) {
            // Applies only if screen width >= 768px
            if (scrollTop > 150) {
                $('.logo-btn-container').addClass('top');
            } else {
                $('.logo-btn-container').removeClass('top');
            }

            if (scrollTop > 160) {
                $('.logo-btn-container').addClass('fixed');
            } else {
                $('.logo-btn-container').removeClass('fixed');
            }
        } else {
        
             if (scrollTop > 150) {
                $('.logo-btn-container').addClass('top');
            } else {
                $('.logo-btn-container').removeClass('top');
            }

            if (scrollTop > 260) {
                $('.logo-btn-container').addClass('fixed');
            } else {
                $('.logo-btn-container').removeClass('fixed');
            }
        }
    });
});
