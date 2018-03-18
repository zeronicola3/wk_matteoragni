<?php 
/**
 * Template Name: Homepage
 *
 */

get_header(); ?>
<div id="contenuti">

		<div class="wp_content">
            <div class="project-cover-gallery project-cover-gallery-<?php echo $elem_number; ?>">
                <ul class="slides">
                <?php
                    $args = array(
                        'post_type'  => 'project',
                        'posts_per_page' => -1,
                        'meta_key'     => 'webkolm_homepage_post_box',
                        'meta_value'   => 'yes',
                        'meta_compare' => 'LIKE',
                    );

                    $query = new WP_Query($args);
                    $numslide=1;
                    $elem_number = rand(10,9999);

                    if ( $query->have_posts() ) :
                        // Start the Loop.
                        while ( $query->have_posts() ) : $query->the_post();

                            $item_id = get_the_ID();

                            $url_small = wp_get_attachment_image_src( $item_id, 'medium' );
                            $url_big = wp_get_attachment_image_src( $item_id, 'large' );
                            //  image field TRUE = cover; FALSE = contain
                            $is_contain = (bool) get_post_meta( $item_id, 'image-bg-size', true );
                              
                            ?>
                            <li class="project_slide-<?= $numslide; ?> slideimg">
                                <style>
                                    .project-cover-gallery-<?php echo $elem_number; ?> .project_slide-<?= $numslide; ?> { 
                                        background-image:url('<?php echo $url_small['0'] ?>');
                                    }

                                    @media (min-width: 768px) {  
                                        .project-cover-gallery-<?php echo $elem_number; ?> .project_slide-<?= $numslide; ?> { 
                                            background-image:url('<?php echo $url_big['0'] ?>');
                                            background-size: <?php if($is_contain){ echo 'contain'; }else{ echo 'cover'; }?> ;
                                        }
                                    }

                                </style>
                            </li>
                            
                <?php $numslide++;
                   
                endwhile;
            endif;
        ?>
        </div>
</div>
<?php get_footer(); ?>
