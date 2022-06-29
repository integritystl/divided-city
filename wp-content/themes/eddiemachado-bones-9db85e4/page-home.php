<?php
/*
 Template Name: Home Page
*/
?>

<?php get_header(); ?>

			<div id="fixed-layout-content-area">

            <article>

                <video autoplay loop poster="<?php echo get_template_directory_uri(); ?>/library/images/splash.gif">
                    <source src="<?php echo get_template_directory_uri(); ?>/library/images/splash.webm" type="video/webm">
                    <source src="<?php echo get_template_directory_uri(); ?>/library/images/splash.mp4" type="video/mp4">
                    <source src="<?php echo get_template_directory_uri(); ?>/library/images/splash.ogv" type="video/ogg">
                </video>

            </article>

            </div> <!-- /.content-area -->

        </div> <!-- /#fixed-layout -->


<?php get_footer(); ?>
