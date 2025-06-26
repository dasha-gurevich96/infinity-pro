jQuery(function ($) {
	$('.search').click(function() {
        var searchBox = $('.site-search.pre-header');
        var isHidden = searchBox.hasClass('d-none');

        // Toggle visibility of the search box
        searchBox.toggleClass('d-none');
        
        // Update the aria-expanded attribute
        $(this).attr('aria-expanded', isHidden);
		// Update the aria-label based on the visibility
        if (isHidden) {
            $(this).attr('aria-label', 'Open site search');
        } else {
            $(this).attr('aria-label', 'Close site search');
        }
    });
})

