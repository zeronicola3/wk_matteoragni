<!DOCTYPE html>

<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> >
<!--<![endif]-->

<head>

  <!-- META -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-touch-fullscreen" content="YES">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes ">

  <!-- FONT LIB -->
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400" rel="stylesheet">

  <!-- JQUERY -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!-- FAVICON -->
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo bloginfo( 'stylesheet_directory' ); ?>/img/favicon.ico">


  <title><?php wp_title(''); ?></title>


  <!-- STYLE ABOVE THE FOLD -->
  <style><?php include 'css/atf.css'; ?></style>


  <?php

    global $woocommerce;
    global $javascript_append;

    wp_head();

  ?>

</head>

<body class="<?php if(is_front_page()){ echo 'home';} ?>">

	prova 1 2 3 4
  <header>
    <div class="wrap">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="titolo_sito">
            <?php get_template_part('img/logo.svg'); ?>
      </a>

      <!-- MENU MOBILE -->
      <?php include("block_menumobile.php"); ?>

      <!-- MENU WIDE -->
      <?php include("block_menuwide.php"); ?>

    </div>
  </header>
