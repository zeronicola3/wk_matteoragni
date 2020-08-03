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

      <div class="mobile_archive">
        <h5 class="wk-list-title">CLIENTS:</h5>
        <select class="wk-select-clienti">
            <?php 
            
            $args = array(
                'post_type'  => 'client',
                'posts_per_page' => -1,
                'ignore_custom_sort' => true,
                'orderby' => 'post_title',
                'order' => 'ASC',
            );

            $query = new WP_Query($args);

            if ( $query->have_posts() ) {
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post(); ?>
                    
                    <option value="<?php the_permalink(); ?>"><?php the_title(); ?></option>

                <?php endwhile;
            } ?>

            <?php wp_reset_postdata(); ?>
            
        </select>

        <h5 class="wk-list-title">TYPOLOGY:</h5>
        <select class="wk-select-tipologia">
            <?php 
            $terms = get_terms( array(
                'taxonomy' => 'project_type',
            ) );

            foreach ($terms as $term) { ?>
                <option value="<?php echo get_term_link( $term ); ?>"><?php echo $term->name; ?></option>
            <?php } ?>
        </select>

        <h5 class="wk-list-title">YEAR:</h5>
        <select class="wk-select-anno">
            <?php
            $projects_per_year = parse_json_file();

            foreach ($projects_per_year as $year => $projects) { ?>
                <option value="<?php echo get_home_url(); ?>/year/?project_by_year=<?php echo $year; ?>"><?php echo $year; ?></option>
            <?php } ?>
        </select>
      </div>
    </div>
</nav>