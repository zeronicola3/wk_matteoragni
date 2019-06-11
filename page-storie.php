<?php 
/**
 * Template Name: Stories
 *
 */
get_header(); ?>
<div id="contenuti">
    <div class="wp_content">
    <?php the_content(); ?>

    </div>
    
    <?php 

        $args = array(
            'post_type'  => 'client',
            'posts_per_page' => -1,
            'ignore_custom_sort' => true,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key'     => 'webkolm_cliente_in_stories',
                    'value'   => 'yes',
                    'compare' => 'LIKE',
                ),
            ),
        );

        $query = new WP_Query($args);

        if ( $query->have_posts() ) {

            $numslide=1;
            // Start the Loop.
            while ( $query->have_posts() ) : $query->the_post(); 

                $image_id = get_post_thumbnail_id(get_the_ID());
                $url_small = wp_get_attachment_image_src( $image_id, 'medium' )[0];
                $url_big = wp_get_attachment_image_src( $image_id, 'large' )[0]; ?>

                <div class="wkrow">
                    <div class="wkcol-4">
                        <img src="<?php echo $url_big;?>"/>
                    </div>
                    <div class="wkcol-4">
                        <?php the_content(); ?>
                    </div>
                    <div class="wkcol-4">
                        <?php print_r(get_post_meta(get_the_ID(), 'webkolm_client_eng_test', true)); ?>
                    </div>
                </div>
                <?php

                $numslide++;
            endwhile;
        }

    ?>
</div>
<?php get_footer(); ?>
