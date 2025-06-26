jQuery(function ($) {
	// Get the current domain
    var currentDomain = window.location.hostname;
  

    // Function to process links
    function processLinks() {
    $('a').each(function () {
        var $link = $(this);
        var linkHref = $link.attr('href');
        var attr = $link.attr('target');

        if (linkHref) {
            if (isValidUrl(linkHref)) {
                var isExternalLink = isExternal(linkHref, currentDomain);
                var isFile = getFileType(linkHref);

                if (isExternalLink || isFile) {
                    $link.attr('target', '_blank');

                    if (!$link.attr('aria-label')) {
                        var linkText = $link.text().trim();
                        var ariaLabel = linkText + ' (opens in a new window)';
                        $link.attr('aria-label', ariaLabel);
                    }

                    // Only add icon if it's not already there
                    if ($link.find('img.external-icon').length === 0) {
						if ($link.hasClass('arrow-link') || $link.find('img').length > 0) {
            				return; // Skip this link
        				}
                        $link.append(
                            ' <img src="/wp-content/uploads/2025/04/arrow-up-right-from-square-solid.svg" alt="" class="external-icon">'
                        );
                    }
                }
            }
        }
    });
}

    // Initial processing of links
    processLinks();

    // Function to check if a string is a valid URL
    function isValidUrl(url) {
        try {
            // Check if the URL is valid by using window.location.origin to handle relative URLs
            new URL(url, window.location.origin);
            return true;
        } catch (error) {
         
            return false;
        }
    }

    // Function to check if a link is external
    function isExternal(link, currentDomain) {
        try {
            // Use window.location.origin as the base URL for relative links
            var linkDomain = new URL(link, window.location.origin).hostname;
            return linkDomain !== currentDomain;
        } catch (error) {
            
            return false;
        }
    }

    // Function to get the file type from a URL
    function getFileType(url) {
        var pathname = new URL(url, window.location.origin).pathname;
        var fileExtension = pathname.split('.').pop().toLowerCase().split('?')[0]; // Remove query params
        var fileTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar', 'txt'];
        return fileTypes.includes(fileExtension) ? fileExtension : null;
    }

    // Create a MutationObserver to watch for DOM changes
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && (mutation.addedNodes.length > 0 || mutation.removedNodes.length > 0)) {
                // Re-process links whenever nodes are added or removed
                processLinks();
            }
        });
    });

    // Start observing the document body for changes
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
	
	$('.search-button.desktops').click(function() {
        var searchBox = $('.site-search.pre-header.desktops');
        var isVisible = searchBox.hasClass('d-flex');

        // Toggle visibility of the search box
        searchBox.toggleClass('d-flex');
        
        // Update the aria-expanded attribute
        $(this).attr('aria-expanded', !isVisible);
		// Update the aria-label based on the visibility
        if (isVisible) {
            $(this).attr('aria-label', 'Open site search');
        } else {
            $(this).attr('aria-label', 'Close site search');
        }
    });
	
	$('.search-button.mobiles').click(function() {
        var searchBox = $('.site-search.pre-header.mobiles');
        var isVisible = searchBox.hasClass('d-flex');

        // Toggle visibility of the search box
        searchBox.toggleClass('d-flex');
        
        // Update the aria-expanded attribute
        $(this).attr('aria-expanded', !isVisible);
		// Update the aria-label based on the visibility
        if (isVisible) {
            $(this).attr('aria-label', 'Open site search');
        } else {
            $(this).attr('aria-label', 'Close site search');
        }
    });
});