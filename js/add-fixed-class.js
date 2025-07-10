jQuery(document).ready(function($) {
    let isFixed = false;

    $(window).scroll(function() {
        let scrollTop = $(this).scrollTop();

        if (scrollTop > 150 && !isFixed) {
            $('.logo-btn-container').addClass('fixed show');
            isFixed = true;
        } else if (scrollTop <= 150 && isFixed) {
            $('.logo-btn-container').removeClass('show').delay(300).queue(function(next){
                $(this).removeClass('fixed');
                next();
            });
            isFixed = false;
        }
    });
});
