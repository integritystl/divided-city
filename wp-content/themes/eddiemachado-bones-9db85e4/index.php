<?php get_header(); ?>

			<div id="fixed-layout-content-area">

                <div class="scrollable"></div> <!-- /.scrollable -->
            	<div id="scrollleft"></div>
				<div id="scrollright"></div>

                <!-- synopses handles horizontal scrolling for the article synopses -->
                <div class="synopses">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<div id="post-image-<?php the_ID(); ?>" class="post-image" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>);"></div>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" data-imageid="post-image-<?php the_ID(); ?>">

						<div class="inner">
							<!-- <h1 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1> -->

							<h1 class="h2 entry-title"><a data-href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

							<?php the_excerpt(); ?>

							<!-- <p><strong><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">read full article</a></strong></p> -->

							<?php echo get_post_meta( get_the_ID(), 'contributors', true ); ?>

						</div>

					</article>

					<?php endwhile; ?>

							<?php bones_page_navi(); ?>

					<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
								</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
								</section>
								<footer class="article-footer">
										<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
								</footer>
							</article>

					<?php endif; ?>

				</div> <!-- ./synopses -->

            </div> <!-- /.content-area -->

        </div> <!-- /#fixed-layout -->


<?php get_footer(); ?>
