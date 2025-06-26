jQuery(function($) {
	$('.menu-item-has-children > a').attr('aria-expanded', 'false');
	$('.menu-item-has-children > a').click(function(e) {
	//$('.menu-item-has-children > a').attr('aria-expanded', 'true');
        e.preventDefault(); // Prevents clicking the parent item
		 $('.sub-menu').not($(this).siblings('.sub-menu')).slideUp();
        $(this).siblings('.sub-menu').slideToggle(); // Toggles submenu visibility
    });
// Close submenu when focus leaves it
$('.menu-item-has-children').on('focusout', function(e) {
    const $this = $(this);

    // Small delay to let focus settle
    setTimeout(function() {
        // Check if focus is still inside this menu item
        if (!$this.find(':focus').length) {
            $this.find('.sub-menu').slideUp();
			$this.children('a').attr('aria-expanded', 'false');
        }
    }, 10);
});
	
   if ($(window).width() > 1100) {
        // Add mouseenter event listener to show submenu on hover
        var timer;
        $('ul.genesis-nav-menu > li.menu-item-has-children').each(function() {
            var topLevelSubMenu = $(this).find('> .sub-menu');
			var subSub = $(this).find('> .sub-menu .sub-menu');

            // Handle hover on top-level submenu items
            $(this).on('mouseenter', function() {
                clearTimeout(timer);
                // Close other open submenus
                $('.sub-menu.open').not(topLevelSubMenu).removeClass('open').hide();
				$('.sub-menu .sub-menu').not(subSub).removeClass('open2').hide();
			
                topLevelSubMenu.addClass('open').show();
				
            });

            // Handle hover on sub-submenu
            $(this).find('.sub-menu .menu-item-has-children').on('mouseenter', function() {
                var subSubMenu = $(this).find('.sub-menu');
				$('.sub-menu .menu-item-has-children .sub-menu.open2').not(subSubMenu).removeClass('open2').hide();
                subSubMenu.addClass('open2').show();
            });
			$(this).find('.sub-menu .menu-item-has-children').on('mouseleave', function() {
                var subSubMenu2 = $(this).find('.sub-menu');
				$('.sub-menu .menu-item-has-children .sub-menu').hide();
				/*
				timer2 = setTimeout(function() {
                	$('.sub-menu .menu-item-has-children .sub-menu').hide();
            	}, 600);*/
				
                
            });
        });

        // Add mouseleave event listener to hide submenu when mouse leaves
        $('ul.genesis-nav-menu > li.menu-item-has-children').on('mouseleave', function() {
            timer = setTimeout(function() {
                $('.sub-menu.open').removeClass('open').hide();
               
            }, 600);
        });
	
	   
    }
 /*function updateAriaExpanded() {
			$('ul.genesis-nav-menu > .menu-item-has-children').each(function () {
				const $menuItem = $(this);
				const $submenu = $menuItem.children('.sub-menu');
				const $link = $menuItem.children('a');

				// Check if the submenu is visible based on inline style
				const display = $submenu[0].style.display; // Access the inline style
				const isVisible = (display !== 'none' && display !== '');

				// Update aria-expanded based on visibility
				if (isVisible) {
					$link.attr('aria-expanded', 'true');
				} else {
					$link.attr('aria-expanded', 'false');
				}
			});
		}*/
	
function updateAriaExpanded() {
  $('ul.genesis-nav-menu > .menu-item-has-children').each(function () {
    const $menuItem = $(this);
    const $submenu = $menuItem.children('.sub-menu');
    const $link = $menuItem.children('a');

    // Use jQuery's visibility check
    const isVisible = $submenu.is(':visible');

    // Update aria-expanded accordingly
    $link.attr('aria-expanded', isVisible ? 'true' : 'false');
  });
}


	const config = { attributes: true, attributeFilter: ['style'] }; // Optimize to only watch style changes

	document.querySelectorAll('.sub-menu').forEach((targetNode) => {
	  const observer = new MutationObserver(function(mutationsList) {
		for (let mutation of mutationsList) {
		  if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
			updateAriaExpanded();
		  }
		}
	  });

	  observer.observe(targetNode, config);
	});

	
});