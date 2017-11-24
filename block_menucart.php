<nav class="onlymobile nav-left">
  <a href="#" class="mobile-menu-right text-menu-icon" data-action="toggleMenuCart">BAG()</a>
  <div class="nav_wrapper">
    <?php 
    /*  MENU MOBILE  */
    wp_nav_menu( array(
        'theme_location'  =>'menumobile' ,
        'container'       => '',
        'container_class' => false,
      )
    );
      ?>
    </div>
    <a href="#" class="close-mobile-menu" data-action="toggleMenuCart"><?php include("img/svg/close.svg.php"); ?></a>
</nav>