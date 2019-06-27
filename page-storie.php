<?php 
/**
 * Template Name: Stories
 *
 */
get_header(); ?>
<div id="contenuti" class="wk-stories">
    
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
                //$url_big = wp_get_attachment_image_src( $image_id, 'large' )[0]; 

                $id_rand = rand(0,99999999);

                // anno
                $year = get_post_meta(get_the_ID(), 'webkolm_project_year', true); ?>

                <div class="wkrow wk-single-story wk-story-<?php echo $id_rand; ?>" data-id="<?php echo $id_rand; ?>">
                    <div class="wkcol-4 wk-client-cover">
                        <div class="wk-client-img">
                            <style>
                                .wk-story-<?php echo $id_rand; ?> .wk-client-img {
                                    background-image: url('<?php echo $url_small; ?>');
                                }
                            </style>
                        </div>
                    </div>
                    <div class="wkcol-8">
                        <h3 class="wk-client-title"><?php the_title(); ?></h3>
                        <span class="wk-client-year"><?php echo $year; ?></span>
                        <div class="wk-client-content">
                            <div class="wk-content-ita">
                                <?php the_content(); ?>
                                <a class="wk-pulsante">Scopri di più</a>
                            </div>
                            <div class="wk-content-eng">
                                <?php echo apply_filters('the_content', get_post_meta(get_the_ID(), 'webkolm_client_eng_test', true)); ?>
                                <a class="wk-pulsante">Discover more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wk-stories-grid" id="<?php echo $id_rand; ?>">
                    <div class="grid-sizer"></div>
                    <?php include 'block_progetti_cliente.php'; ?>
                </div>
                <?php

                $numslide++;
            endwhile;
        }

    ?>
</div>
<?php get_footer(); ?>
