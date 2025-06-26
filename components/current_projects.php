<?php
$title_light_projects = get_sub_field('title_light_projects');
$title_bold_projects = get_sub_field('title_bold_projects');
$tech_justice_title_1 = get_sub_field('tech_justice_title_1');
$tech_justice_title_2 = get_sub_field('tech_justice_title_2');
$tech_justice_description = get_sub_field('tech_justice_description'); 
$tech_justice_image = get_sub_field('tech_justice_image');
?>
<div class="current-projects inner-projects" id="current-projects">
<div class="full-container">
  <div class="custom-container">

    <div class="tech-container">
      <div class="text-col">
        <h3 class="pink-shapes">
			<?php echo $tech_justice_title_1;?>
        </h3>
        <div class="desc">
          <?php echo $tech_justice_description; ?>
        </div>

        <?php if (have_rows('button_tech')) : ?>
          <?php while (have_rows('button_tech')) : the_row(); ?>
            <?php
            $button_text = get_sub_field('button_text');
            $button_link = get_sub_field('button_link');
            if (!empty($button_link) && !empty($button_text)) :
            ?>
              <a href="<?php echo $button_link; ?>" class="custom-button black"><?php echo $button_text; ?></a>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>

      <div class="img-col position-relative">
      

        <?php if ($tech_justice_image && isset($tech_justice_image['sizes']['large'])) : ?>
          <img class="img-tech" src="<?php echo $tech_justice_image['sizes']['large']; ?>" alt="<?php echo $tech_justice_image['alt']; ?>" />

        <?php endif; ?>
      </div>
    </div>
  </div>
<div class="custom-shape-divider-bottom-tech">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
    </svg>
</div>
</div>


<div class="full-container">
  <div class="custom-container">
    <?php
    if (have_rows('funders_forum')) {
      while (have_rows('funders_forum')) {
        the_row();
        $title = get_sub_field('title');
        $text = get_sub_field('text');
        if (!empty($title) && !empty($text)) {
          ?>
          <div class="col-c-1">
              <div>
            <h3><?php echo $title; ?></h3>
            <hr>
            
            <div class="text-c">
              <?php echo $text; ?>
            </div>
            </div>
            <div class="buttons">
              <?php
              if (have_rows('button_forum')) {
                while (have_rows('button_forum')) {
                  the_row();
                  $button_text = get_sub_field('button_text');
                  $button_link = get_sub_field('button_link');
                  if (!empty($button_link) && !empty($button_text)) {
                    ?>
                    <a href="<?php echo $button_link; ?>" class="custom-button black"><?php echo $button_text; ?></a>
                    <?php
                  }
                }
              }
              ?>
              <?php
 
 if (have_rows('button_event')) {
                while (have_rows('button_event')) {
                  the_row();
                  $button_text = get_sub_field('button_text');
                  $button_link = get_sub_field('button_link');
                  if (!empty($button_link) && !empty($button_text)) {
                    ?>
                    <a href="<?php echo $button_link; ?>" class="custom-button d-purple"><?php echo $button_text; ?></a>
                    <?php
                  }
                }
              }
              ?>
            </div>
          </div>
          <?php
        }
      }
    }
    ?>
<?php
    if (have_rows('find_funder')) {
      while (have_rows('find_funder')) {
        the_row();
        $title = get_sub_field('title');
        $text = get_sub_field('text');
        if (!empty($title) && !empty($text)) {
          ?>
          <div class="col-c-1">
              <div>
            <h3><?php echo $title; ?></h3>
            <hr>
            <div class="text-c">
              <?php echo $text; ?>
            </div>
            </div>
            <div class="buttons">
              <?php
              if (have_rows('button_forum')) {
                while (have_rows('button_forum')) {
                  the_row();
                  $button_text = get_sub_field('button_text');
                  $button_link = get_sub_field('button_link');
                  if (!empty($button_link) && !empty($button_text)) {
                    ?>
                    <a href="<?php echo $button_link; ?>" class="custom-button black"><?php echo $button_text; ?></a>
                    <?php
                  }
                }
              }
              ?>
              <?php
      
              ?>
            </div>
          </div>
          <?php
        }
      }
    }
?>
  </div>
</div>
</div>