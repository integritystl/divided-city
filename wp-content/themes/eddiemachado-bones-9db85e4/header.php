<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/library/images/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon-16x16.png">
		<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/library/images/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

		<div id="fixed-layout">

			<header id="fixed-layout-header-area">
                <div id="hamburger"><img src="<?php echo get_template_directory_uri(); ?>/library/images/hamburger.gif" alt="Menu"></div>
                <a id="logo" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/library/images/logo-horizontal.gif" alt="The Divided City"></a>
                <div id="tagline"><span><?php bloginfo('description'); ?></span></div>
            </header>

            <div id="flyout-menu">
                <div class="close-button"><img src="<?php echo get_template_directory_uri(); ?>/library/images/close.png"></div>
                <div class="scrollable">
                    <?php wp_nav_menu(array(
					         'container' => 'div',                           // remove nav container
					         'container_class' => 'page-menu cf',            // class of container (should you choose to use it)
					         'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
					         'menu_class' => '',               // adding custom nav class
					         'theme_location' => 'main-nav',                 // where it's located in the theme
					         'before' => '',                                 // before the menu
    			               'after' => '',                                  // after the menu
    			               'link_before' => '',                            // before each link
    			               'link_after' => '',                             // after each link
    			               'depth' => 0,                                   // limit the depth of the nav
					         'fallback_cb' => ''                             // fallback function (if there is one)
					)); ?>
                    <div class="dialogue-menu">
                        <li>Dialogues:</li>
                        <?php wp_nav_menu(array(
                             'container' => false,                           // remove nav container
                             'container_class' => '',            // class of container (should you choose to use it)
                             'menu' => __( 'Dialogues', 'bonestheme' ),  // nav name
                             'menu_class' => '',               // adding custom nav class
                             'theme_location' => 'dialogues-nav',                 // where it's located in the theme
                             'before' => '',                                 // before the menu
                               'after' => '',                                  // after the menu
                               'link_before' => '',                            // before each link
                               'link_after' => '',                             // after each link
                               'depth' => 0,                                   // limit the depth of the nav
                             'fallback_cb' => ''                             // fallback function (if there is one)
                    )); ?>
                    </div>
                    <div class="logo"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/library/images/logo.png"></a></div>
                </div><!-- /.scrollable -->
            </div>

