<nav class="onlymobile">
  <a class="mobile-menu" data-action="toggleMenu"><span class="fa fa-bars" data-action="toggleMenu"></span></a>
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
</nav>