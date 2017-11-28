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
                    $big_img = wp_get_attachment_image_src(  get_post_thumbnail_id($post->ID), 'large' );
                    $mobile_img = wp_get_attachment_image_src(  get_post_thumbnail_id($post->ID), 'medium' );

                    $elem_number = rand(10,9999);

                    ?>

                    <div class="project-cover project-cover-<?php echo $elem_number; ?>">
                        <img src="<?php echo $big_img['0'] ?>" srcset="<?php echo $mobile_img['0'] ?> 768w, <?php echo $big_img['0'] ?> 1500w">
                    </div>



                    <div class="project-container">
                        <div class="project-col project-header">
                            <h4 class="project-title"><?php the_title(); ?></h4>
                            <span class="project-designer"><?php echo $meta['webkolm_designer']['0']; ?><br></span>
                            <span class="project-year"><?php echo $meta['webkolm_project_year']['0']; ?></span>
                        </div>

                        <div class="project-col project-prizes">
                            <?php echo $meta['webkolm_prizes']['0']; ?>
                        </div>

                        <div class="project-col project-content">
                            <?php the_content(); ?>
                        </div>

                        <div class="project-col project-content-eng">
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
