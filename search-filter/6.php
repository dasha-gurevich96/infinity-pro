<?php
/* Team members*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $query ) ) {
	return;
}

	if ($query->have_posts()) {
		$count = 0;
?>
	<!-- Keep the `.search-filter-query-posts` class to support the load more button -->
	<div class="search-filter-query-posts members-cards">
		<?php while($query->have_posts()) {
			$query->the_post();
			$image = get_field('image');
			$job_role = get_field('job_role');
			$bio = get_field('text_above_read_more');
			$get_touch = get_field('get_in_touch');
			$linkedIn_img = '';
			$linked_url = '';
		$bio_above_read_more = get_field('bio_above_read_more');
		
		$count++;
			if(have_rows('social_media')) {
				while(have_rows('social_media')) {
					the_row();
					$media = get_sub_field('select_social');
					$link = get_sub_field('link');
					if(!empty($media) && !empty($link)) {
						$src= '';
						if($media ==='Youtube') {
							$src="/wp-content/uploads/2025/03/Youtube_icon_grey-e1742386530501.png";
						} elseif($media ==='Medium') {
							$src="/wp-content/uploads/2025/03/medium_icon_grey-e1742386489104.png";
						} elseif($media ==='LinkedIn') {
							$src="/wp-content/uploads/2025/03/linked-in-icon_grey-e1742386512950.png";
							$linkedIn_img = $src;
							$linked_url = $link;
						} 
				?>
				<?php
					}
				}
				?>
			
				<?php
			}
			/*if(have_rows('social_media')) {
				?><div class="social-media d-flex">
				<?php while(have_rows('social_media_buttons','options')) {
					the_row();
					$media = get_sub_field('media');
					$link = get_sub_field('link');
					if(!empty($media) && !empty($link)) {
						$src= '';
						if($media ==='Youtube') {
							$src="/wp-content/uploads/2025/03/Youtube_icon_grey-e1742386530501.png";
						} elseif($media ==='Instagram') {
							$src="/wp-content/uploads/2025/03/linked-in-icon_grey-e1742386512950.png";
						} elseif($media ==='Medium') {
							$src="/wp-content/uploads/2025/03/medium_icon_grey-e1742386489104.png";
						}
				?><a class="social-icon move-up" href="<?php echo $link;?>" aria-label="<?php echo $media;?> profile - opens in a new window"><img src="<?php echo $src;?>" alt="" /></a>
				<?php
					}
				}
				?>
				</div>
				<?php
			}*/
			if(!empty($bio) && !empty($job_role) && !empty($bio_above_read_more )) {
				
				?><div class="team-card">
						<div class="img-photo-col position-relative">
							<?php if(!empty($image)) {
								?>
							<img class="frame frame-top position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_top-corner.png"/>
								 <img class="frame frame-bottom position-absolute" src="/wp-content/uploads/2025/04/Photo-overlay_bottom-corner.png"/>
							<img class="photo" src="<?php echo $image['url'];?>" alt="<?php echo $image['alt'];?>"/><?php
							} else {
						?>
							
							<img class="photo" src="/wp-content/uploads/2024/09/Staff-photo-no-image.jpg" alt=""/><?php
				}
							?>
						</div>
						<div class="about-team">
							<div class="title-job">
								<div class="title-social">
									<h3>
										<?php the_title();?>
									</h3>
									<?php if(!empty($linked_url)) {
									?> <a class="social-icon move-up" href="<?php echo $linked_url;?>" aria-label="LinkedIn profile of <?php the_title();?> - opens in a new window"><img src="<?php echo $linkedIn_img;?>" alt="" /></a>
									<?php
									}
								?>
								</div>
								
								<p>
									<?php echo $job_role;?>
								</p>
							</div>
							<div class="bio-contact">
										<?php 
												$bio_to_show = $bio_above_read_more;
												
										
										?>
										<div class="bio">
											<div class="bio-short">
												<?php echo $bio_to_show;?>
												
											</div>
											<div id="bio-content<?php echo $count;?>" class="bio-full" style="display: none;">
												
												<?php echo $bio; ?>
													<div class="get-in">
														<div class="get-text">
															<?php echo $get_touch;?>
														</div>
														<?php if(have_rows('social_media')) {
											
															?><div class="social-media d-flex">
															<?php while(have_rows('social_media')) {
																the_row();
																
																$media_1 = get_sub_field('select_social');
																$link_1 = get_sub_field('link');
																if(!empty($media_1) && !empty($link_1)) {
																
																	$src= '';
																	if($media_1 ==='Youtube') {
																		$src="/wp-content/uploads/2025/03/Youtube_icon_grey-e1742386530501.png";
																	} elseif($media_1 ==='Medium') {
																		$src="/wp-content/uploads/2025/03/medium_icon_grey-e1742386489104.png";
																	} elseif($media_1 ==='LinkedIn') {
																		$src="/wp-content/uploads/2025/03/linked-in-icon_grey-e1742386512950.png";
																		$linked_url = $link;
																	} 
															?><a class="social-icon move-up" href="<?php echo $link_1;?>" aria-label="<?php echo $media_1;?> profile of <?php the_title();?> - opens in a new window"><img src="<?php echo $src;?>" alt="" /></a>
															<?php
																}
															}
															?>
															</div>
															<?php
														}
										?>
													</div>
											</div>
											<div class="read-more">
												<button id="toggleButton<?php echo $count;?>" class="button bio-button" aria-expanded="false" aria-controls="bio-content<?php echo $count;?>">
													<span class="text">Read more</span><span> about <?php the_title();?></span>
													<img class="arrow" src="/wp-content/uploads/2025/04/Team-pages-pink-arrow.svg" alt="" />
												</button>
											</div>
										</div>
			
							</div>
							
						</div>
					<div>
						
					</div>
		
				</div>
			<?php
			}
		
		}
	?>
	</div>
	<?php
		wp_reset_postdata();
		} else {
		?><p>
		No results found
		</p>
	<?php
	}