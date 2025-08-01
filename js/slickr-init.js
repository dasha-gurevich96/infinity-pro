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
          breakpoint: 990,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
         {
          breakpoint: 820,
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

let mobileSlider = $('.slider-mobile');

function initMobileSlick() {
  if ($(window).width() < 1000) {
    if (!mobileSlider.hasClass('slick-initialized')) {
      mobileSlider.slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 1, // Safe default
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 990, // screens < 990
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 700, // screens < 700
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
$(window).on('resize', initMobileSlick); // ← important: reinit on resize


	
//Working Groups - who we are 

let sliderG = $('.working-group-cards');

let initSlickW = function() {
  sliderG.slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 990,
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

let sliderWM = $('.working-group-cards-mobile');
let initSlickWM = function() {
  sliderWM.slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
  });
}

initSlickWM();
$(window).on('resize', initSlickWM);
//Logos - who we are 

let sliderL = $('.logos-cards');

let initSlickL = function() {
  sliderL.slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 890,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 390,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
    
      ]
  });
}

initSlickL();
$(window).on('resize', initSlickL);
	

//Funders - who we are 

let sliderF = $('.funders-cards');

let initSlickF = function() {
  sliderF.slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
  });
}

initSlickF();
$(window).on('resize', initSlickF);
	
	
	
})

