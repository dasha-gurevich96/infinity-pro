jQuery(function ($) {
    $('.play-btn').on('click', function () {
        console.log('clicked');
    const $container = $('#video-container');
    const videoId = $container.data('video');

    const iframe = `
      <iframe width="560" height="315"
        src="https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1"
        title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen></iframe>
    `;

    $('.placeholder-container').hide();

    $container.html(iframe).show();
  });
	
})