<?php 
/**
 * Template Name: Homepage
 *
 */

get_header(); ?>
<div id="contenuti">
	<div class="wrapper">
		<div class="wp_content">
        <?php
            $args = array(
                'post_type'  => 'project',
                'posts_per_page' => '-1',
            );

            $query = new WP_Query($args);

            if ( $query->have_posts() ) :
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post();

                    $meta = get_post_meta( $post->ID );

                    the_title();

                 //   echo $meta['webkolm_project_year'];

                  //  echo $meta['webkolm_prizes'];

                    print_r($meta['webkolm_designer']);



                    the_content();

                endwhile;
            endif;
        ?>
        <?php twentythirteen_paging_nav();?>
        </div>
	</div>
</div>
<?php get_footer(); ?>
