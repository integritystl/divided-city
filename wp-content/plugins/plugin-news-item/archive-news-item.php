<?php get_header(); ?>
<?php

  // WP_Query arguments
  // Sort by the date of publication meta value as a numerical value
  $args = array(
  	'post_type'              => array( 'news-item' ),
  	'post_status'            => array( 'publish' ),
    'meta_key' => 'date',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    // Do not page results, that is, show all query results no matter how many.
    'nopaging' => true,
  );

  // The Query
  $news_item_query = new WP_Query( $args );

?>
<div id="fixed-layout-content-area">
  <div class="scrollable">
    <div class="news-archive">
      <h1>NEWS</h1>
      <?php if ( $news_item_query->have_posts() ) : ?>
        <?php while ( $news_item_query->have_posts() ) : ?>
          <?php $news_item_query->the_post(); ?>
          <?php
            // Get data for each news item
            $link = htmlentities( get_field('link') );
            $description = get_field('description');
            $date_field = get_field('date');
            $date = DateTime::createFromFormat('Ymd', $date_field);
            $formatted_date = $date->format('F j, Y');
            $featured_image_id = get_post_thumbnail_id();
            $featured_image_alt = get_post_meta( $featured_image_id, '_wp_attachment_image_alt', true );
            $image_src_array_medium = wp_get_attachment_image_src($featured_image_id, 'medium');
            $image_src_array_medium_large = wp_get_attachment_image_src($featured_image_id, 'medium_large');
          ?>

          <article class="news-archive__news-item">
            <div class="news-archive__title-and-date">
              <h2 class="news-archive__title"><a class="news-archive__link" href="<?php echo $link; ?>"><?php htmlentities( the_title() ); ?></a></h2>
              <p class="news-archive__date"><?= $formatted_date ?></p>
            </div>
            <picture class="news-archive__picture">
              <source media="(min-width: 600px)" srcset="<?php echo $image_src_array_medium_large[0]; ?>">
              <img src="<?php echo $image_src_array_medium[0]; ?>" alt="<?php echo $featured_image_alt; ?>" class="news-archive__image">
            </picture>
            <p class="news-archive__description"><?= $description ?></p>
          </article>

        <?php endwhile; ?>
      <?php else : ?>
        <h1>There are currently no news items to display!</h1>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>
