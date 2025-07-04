jQuery(function($) {
  console.log('button loaded');

  // Function to handle button click
  function handleButtonClick(button) {
    button.on('click', function() {
      var card = $('.bio-card');
      console.log("Button clicked");
      var buttonId = $(this).attr('id');
      var contentId = $(this).attr('aria-controls');
      var expanded = $(this).attr('aria-expanded') === 'true' || false;
      
      $(this).attr('aria-expanded', !expanded);
      var newExpanded = !expanded;
      $('#' + contentId).attr('aria-hidden', expanded);
      $('#' + contentId).slideToggle();
      $('#' + contentId).removeClass('d-none');
      $('#' + contentId).attr('tabindex', -1).focus();
      
      if (newExpanded) {
        $(this).find('span.text').text('Read less');
        card.addClass('full');
      } else {
        $(this).find('span.text').text('Read more');
        card.removeClass('full');
        $('#' + contentId).blur();
      }
    });
  }

  // Initial setup for already existing buttons
  $('button[id^="toggleButton"]').each(function() {
    handleButtonClick($(this));
  });

  // MutationObserver to watch for dynamically added buttons
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      $(mutation.addedNodes).each(function() {
        if ($(this).is('button[id^="toggleButton"]')) {
          handleButtonClick($(this));
        } else {
          // Check descendants in case the button is nested
          $(this).find('button[id^="toggleButton"]').each(function() {
            handleButtonClick($(this));
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
});