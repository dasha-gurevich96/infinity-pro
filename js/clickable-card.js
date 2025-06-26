jQuery(function($){
	// Function to make elements clickable
  function makeClickable(element) {
    element.find("a").on("click", function(e) {
      e.stopPropagation();
    });

    element.on("click", function(event) {
      var noTextSelected = !window.getSelection().toString();

      if (noTextSelected) {
        $(this).find("a")[0].click();
      }
    });
  }

  // Initial setup for already existing .clickable-card elements
  $(".clickable-card").each(function() {
    makeClickable($(this));
  });

  // MutationObserver to watch for dynamically added .clickable-card elements
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      $(mutation.addedNodes).each(function() {
        if ($(this).hasClass("clickable-card")) {
          makeClickable($(this));
        } else {
          // Check descendants in case the card is nested
          $(this).find(".clickable-card").each(function() {
            makeClickable($(this));
          });
        }
      });
    });
  });

  // Observe the document body for added nodes
  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
	
	
	var clickableSlide = $(".clickable-slider .n2-ss-slide");
	console.log(clickableSlide);
    if(clickableSlide) {
       clickableSlide.find("a").on("click", function (e) {
        e.stopPropagation();
      });

      clickableSlide.on("click", function (event) {
        var noTextSelectedSlide = !window.getSelection().toString();

        if (noTextSelectedSlide) {
          $(this).find("a")[0].click();
        }
      }); 
    }


})