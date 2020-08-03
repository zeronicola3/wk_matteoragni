<?php 
/**
 * Template Name: Year
 *
 */

get_header(); ?>
<div id="contenuti">
    <div class="wrapper solo-padding">
        <h3 class="titoletto-home">Risulati per: <?php echo $_GET['project_by_year']; ?></h3>
    </div>
    <div class="grid">
        <div class="grid-sizer"></div>
        <?php 

            if(isset($_GET['project_by_year'])){
                $args = array(
                    'post_type'  => 'project',
                    'posts_per_page' => -1,
                    'ignore_custom_sort' => true,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key'     => 'webkolm_project_year',
                            'value'   => $_GET['project_by_year'],
                            'compare' => 'LIKE',
                        ),
                    ),
                );

                //print_r(get_projects_by_year($_GET['project_by_year']));

            } else {
                $args = array(
                    'post_type'  => 'project',
                    'posts_per_page' => -1,
                    'ignore_custom_sort' => true,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                );
            }

            $query = new WP_Query($args);

            if ( $query->have_posts() ) {

                $numslide=1;
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post(); 

                    include 'block_grid-item_progetto.php'; 
                    
                endwhile;
            }
        ?>

        </div>
    </div>
</div>
<?php get_footer(); ?>

