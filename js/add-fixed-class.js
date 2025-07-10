jQuery(function ($) {
    console.log('fixed');
    const $logo = $('.logo-btn-container');

    $(window).on('scroll resize', toggleClasses);   // run on scroll and when window resizes
    toggleClasses();                                // run once on load

    function toggleClasses () {
        const scrollTop   = $(this).scrollTop();         // current scroll offset
        const winHeight   = $(this).height();            // viewport height
        const logoTop     = $logo.offset().top;          // element’s distance from doc top
        const logoHeight  = $logo.outerHeight();
        const logoBottom  = logoTop + logoHeight;

        /* ---------------------------------------------------------
           1.  Is *any* part of the element outside the viewport?
               (above top edge OR below bottom edge) → add `.top`
         --------------------------------------------------------- */
        const outOfView = logoBottom < scrollTop || logoTop > scrollTop + winHeight;
        $logo.toggleClass('top', outOfView);

        /* ---------------------------------------------------------
           2.  Has the page itself been scrolled > 150 px?
               If so → pin it with `.fixed` (and remove `.top`),
               else → remove `.fixed`
         --------------------------------------------------------- */
        if (scrollTop > 150) {
            $logo.addClass('fixed');
        } else {
            $logo.removeClass('fixed top');
        }
    }
});

