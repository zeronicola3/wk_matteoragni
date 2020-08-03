<?php 
/**
 * Template Name: Template timeline
 *
 */
 

get_header(); ?>
<div id="contenuti">
    <div class="grid">
        <div class="grid-sizer">
            <div class="sizer-content"></div>
        </div>
        <?php 

            $args = array(
                'post_type'  => 'project',
                'posts_per_page' => -1,
                'ignore_custom_sort' => true,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'exclude' => '',
            );

            $query = new WP_Query($args);

            if ( $query->have_posts() ) {

                $numslide=1;
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post(); 

                    $secondary_project = get_post_meta($post->ID, 'webkolm_post_secondario', false)[0];

                    if($secondary_project != "yes"){
                        include 'block_grid-item_progetto.php';   
                    }
                endwhile;
            }

        ?>

        </div>
    </div>
</div>
<?php get_footer(); ?>

