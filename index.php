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

                    $meta = get_post_meta( $post->ID ); ?>


                    <div class="project-container">
                        <div class="project-col project-header">
                            <h4 class="project-title"><?php the_title(); ?></h4>
                            <?php
                                echo $meta['webkolm_designer']['0'];
                                echo $meta['webkolm_project_year']['0'];
                            ?>
                        </div>

                        <div class="project-col">
                            <div class="project-prizes">
                                <?php echo $meta['webkolm_prizes']['0']; ?>
                            </div>
                        </div>

                        <div class="project-col">
                            <?php the_content(); ?>
                        </div>

                        <div class="project-col">
                            <?php the_content(); ?>
                        </div>
                        
                    </div>

        <?php   endwhile;
            endif;
        ?>
        <?php twentythirteen_paging_nav();?>
        </div>
	</div>
</div>
<?php get_footer(); ?>
