jQuery(function($) {
    console.log('loded');
	  // listen for clicks on the Manage–consent button
  $(document).on(
    'click',
    'button.cmplz-btn.cmplz-manage-consent.manage-consent-1.cmplz-show',
    function () {

      /*  Wait one tick so Complianz can finish replacing
          the compact banner with the preferences dialog.
          50 ms is usually enough; raise it if you use long
          CSS animations on the banner.                       */
      setTimeout(function () {

        // the newly‑inserted dialog element
        const $banner = $(
          'div#cmplz-header-1-optin'
        );

        if ($banner.length) {
          // make sure it’s focusable and move focus there
          $banner.prop('tabIndex', 0).focus();

          /*  Optional visual outline so you can see
              that focus really landed on the banner.
              Remove or replace with your own theme token.   */
          $banner.css('outline', '2px solid #005fcc');
        } else {
          console.warn('Complianz banner not in DOM yet.');
        }

      }, 50);          // ← adjust if needed
    }
  );

  // Counter approach to ensure unique IDs if needed:
  let ffErrorCounter = 0;

  // Helper: Given a jQuery-wrapped error <div>, assign an ID if missing,
  // and update the related input's aria-describedby.
  function processErrorDiv($errorDiv) {
    // 1. Assign an ID to the error div if missing
    let newId = $errorDiv.attr('id');
    if (!newId) {
      // Find the related input within the same container
      const $container = $errorDiv.closest('.ff-el-input--content');
      let baseId = null;
      if ($container.length) {
        const $input = $container.find('input.ff-el-form-control').first();
        if ($input.length && $input.attr('id')) {
          baseId = $input.attr('id');
        }
      }

      if (baseId) {
        newId = baseId + '_error';
        // Avoid collision
        if (document.getElementById(newId)) {
          ffErrorCounter++;
          newId = baseId + '_error_' + ffErrorCounter;
        }
      } else {
        ffErrorCounter++;
        newId = 'ff_error_' + ffErrorCounter;
      }
      $errorDiv.attr('id', newId);
    }
    // 2. Update the related input's aria-describedby
    // Find the related input again:
    const $container2 = $errorDiv.closest('.ff-el-input--content');
    if ($container2.length) {
      const $input2 = $container2.find('input.ff-el-form-control').first();
      if ($input2.length) {
        const existing = $input2.attr('aria-describedby');
        if (existing) {
          // Append only if not already present
          const tokens = existing.split(/\s+/);
          if (tokens.indexOf(newId) === -1) {
            $input2.attr('aria-describedby', existing + ' ' + newId);
          }
        } else {
          $input2.attr('aria-describedby', newId);
        }
      }
    }
   
  }

  // Set up a single MutationObserver to detect inserted error divs
  const errorObserver = new MutationObserver(function(mutationsList) {
    mutationsList.forEach(function(mutation) {
      if (mutation.type === 'childList' && mutation.addedNodes.length) {
        $(mutation.addedNodes).each(function() {
          const $node = $(this);
          // Case A: node itself is error div
          if ($node.is('div.error.text-danger')) {
            processErrorDiv($node);
          }
          // Case B: node contains descendant error divs
          const $innerErrors = $node.find('div.error.text-danger');
          if ($innerErrors.length) {
            $innerErrors.each(function() {
              processErrorDiv($(this));
            });
          }
        });
      }
    });
  });
let errors = [];
  // Start observing. You can narrow the root to a container of your form if known.
  // For example: const rootEl = document.querySelector('#your-form-container');
  // errorObserver.observe(rootEl || document.body, { childList: true, subtree: true });
  errorObserver.observe(document.body, { childList: true, subtree: true });

  // Form submit handler: focus first invalid field
  $(document).on('submit', '.fluentform', function(e) {
	 
	  
	  
    const $form = $(this);
	  
	   const $summary = $('.error-summary');
	const $ul = $summary.find('ul').empty();
	errors = [];
    // Find the first element with aria-invalid="true"
    const $firstInvalid = $form.find('[aria-invalid="true"]').first();

	  
	  $form.find('input.ff-el-form-control[aria-invalid="true"]').each(function() {
  const $input = $(this);
  const inputId = $input.attr('id') || null;
  // Locate the sibling error div
  const $container = $input.closest('.ff-el-input--content');
  const $errorDiv = $container.find('div.error.text-danger').first();
  if ($errorDiv.length) {
    const message = $errorDiv.text().trim();
    errors.push({
      inputId: inputId,
      message: message
    });
  } 
});
	  
	  errors.forEach(function(err) {
  const fieldId = err.inputId;
  const msg = err.message;

  // Only proceed if we have an inputId
  if (fieldId) {
    // Derive a user-friendly label or use the message directly.
    // Optionally, you can fetch the label text:
    let labelText = '';
    const $label = $form.find('label[for="' + fieldId + '"]');
    if ($label.length) {
      labelText = $label.text().trim();
    }
    if (!labelText) {
      // Fallback: use the ID or generic text
      labelText = fieldId;
    }

    // Build the link text, e.g. "First Name: The first name field is required"
    const linkText = msg;

    // Create <li> and <a>
    const $li = $('<li></li>');
    const $a = $('<a></a>')
      .attr('href', '#' + fieldId)
      .text(linkText)
    $li.append($a);
    $ul.append($li);
  }
});

// 3. Show and focus the summary so screen readers announce it
$summary.show();
// Ensure it has tabindex so it can be focused

  $summary.attr('tabindex', '-1');

$summary.focus();
	  
	  console.log(errors);


   
  });



});