jQuery(document).ready(function ($) {

  /*Home page slider*/
 

let sliderDiscover = $('.two-slide-cards');

let initSlick = function() {
  sliderDiscover.slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 2,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 890,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
    
      ]
  });
}

initSlick();
$(window).on('resize', initSlick);

//Home slider for why important 
let mobileSlider = $('.slider-mobile');

function initMobileSlick() {
  if ($(window).width() < 1000) {
    if (!mobileSlider.hasClass('slick-initialized')) {
      mobileSlider.slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 700,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            }
          }
        ]
      });
    }
  } else {
    if (mobileSlider.hasClass('slick-initialized')) {
      mobileSlider.slick('unslick');
    }
  }
}
initMobileSlick();

// Re-check on resize
$(window).on('resize', initMobileSlick);

	
//Working Groups - who we are 

let sliderG = $('.working-group-cards');

let initSlickW = function() {
  sliderG.slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 2,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 890,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
    
      ]
  });
}

initSlickW();
$(window).on('resize', initSlickW);
	
	
	
})

