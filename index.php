<?php 
/**
 * Template Name: Homepage
 *
 */

get_header(); ?>
<div id="contenuti">
    <div class="wp_content">
    <?php the_content(); ?>
    <?php /* $elem_number = rand(10,9999); ?>
		<div class="wp_content">
            <div class="project-cover-gallery project-cover-gallery-<?php echo $elem_number; ?> homepage-gallery">
                <ul class="slides">
                <?php

                    $args = array(
                        'post_type'  => 'page',
                        'posts_per_page' => 1,
                        'meta_key'     => 'webkolm_page_in_homepage',
                        'meta_value'   => 'yes',
                        'meta_compare' => 'LIKE',
                    );

                    $query = new WP_Query($args);

                    $is_flagged_page = true;

                    if ( !$query->have_posts() ) {

                        $args = array(
                            'orderby' => 'rand',
                            'post_type'  => 'project',
                            'posts_per_page' => '5',
                            'ignore_custom_sort' => true,
                            'meta_query' => array(
                                array(
                                    'key'     => 'webkolm_homepage_post_box',
                                    'value'   => 'yes',
                                    'compare' => 'LIKE',
                                ),
                            ),
                        );

                        $query = new WP_Query($args);

                        $is_flagged_page = false;
                    }

                    if ( $query->have_posts() ) {

                        $numslide=1;
                        // Start the Loop.
                        while ( $query->have_posts() ) : $query->the_post();

                            $item_id = get_the_ID();

                            // SE sto visualizzando la pagine flaggata -> prendo l'immagine d'evidenza
                            if($is_flagged_page){
                                $image_id = get_post_thumbnail_id($item_id);
                            // ALTRIMENTI -> prendo le immagini d'evidenza secondarie
                            } else {
                                $image_id = get_post_meta($item_id, 'webkolm_featured_img_input', true);
                            }


                            // SE immagine scura, allora frecce bianche
                            $is_dark_image = get_post_meta($item_id, 'webkolm_dark_image', true);
                            $cursor_color = 'black';
                            if($is_dark_image) {
                                $cursor_color = 'white';
                            }
                            

                            $url_small = wp_get_attachment_image_src( $image_id, 'medium' );
                            $url_big = wp_get_attachment_image_src( $image_id, 'large' );
                            //  image field TRUE = cover; FALSE = contain
                            $is_contain = (bool) get_post_meta( $image_id, 'image-bg-size', true );

                            ?>
                            
                                <li class="project_slide-<?php echo $numslide; ?> slideimg" data-cursor="<?php echo $cursor_color; ?>">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                    </a>
                                    <style>
                                        .project-cover-gallery-<?php echo $elem_number; ?> .project_slide-<?php echo $numslide; ?> { 
                                            background-image:url('<?php echo $url_small['0'] ?>');
                                        }

                                        @media (min-width: 768px) {  
                                            .project-cover-gallery-<?php echo $elem_number; ?> .project_slide-<?php echo $numslide; ?> { 
                                                background-image:url('<?php echo $url_big['0'] ?>');
                                                background-size: <?php if($is_contain){ echo 'contain'; }else{ echo 'cover'; }?> ;
                                            }
                                        }

                                    </style>

                                </li>
                            </a>

                <?php $numslide++;
                   
                endwhile;
            }
        ?>
        </ul>
    </div>

    <?php 
    if($is_flagged_page){ ?>
    <div class="wrapper">
        <?php the_content(); ?>
    </div>
    <?php } */?>
    </div>

    
    <div class="grid">
        <h3>SELECTED PROJECTS</h3>
        <div class="grid-sizer"></div>
        <?php 

            $args = array(
                'post_type'  => 'project',
                'posts_per_page' => 3,
                'ignore_custom_sort' => true,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key'     => 'webkolm_homepage_post_box',
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

                    $image_id = get_post_meta(get_the_ID(), 'webkolm_featured_img_input', true);
                    $url_small = wp_get_attachment_image_src( $image_id, 'medium' );
                    $url_big = wp_get_attachment_image_src( $image_id, 'large' );

                    // SE immagine scura, allora frecce bianche
                    $is_dark_image = get_post_meta(get_the_ID(), 'webkolm_dark_image', true);
                    $cursor_color = 'black';
                    if($is_dark_image) {
                        $cursor_color = 'white';
                    }

                    // SE immagine scura, allora frecce bianche
                    $is_double = get_post_meta(get_the_ID(), 'webkolm_double_box_home', true);
                    $double_class = '';
                    if($is_double) {
                        $double_class = ' grid-item--width2 ';
                    }

                    $connected = p2p_type( 'projects_to_client' )->set_direction( 'to' )->get_connected( get_the_ID() );

                    foreach ($connected as $conn) {
                        if($conn->post_title != get_the_title())
                            $client_name = " - " . $conn->post_title;
                        else
                            $client_name = "";
                    }
                    

                    ?>

                    <div class="grid-item <?php echo $double_class; ?>">
                        <a href="<?php echo get_the_permalink(); ?>" class="tile-content" style="background-image: url('<?php echo $url_small[0]; ?>');">
                            <span class="tile-title" style="color:<?php echo $cursor_color; ?>;"><?php the_title(); ?><?php echo $client_name; ?></span>
                        </a>
                    </div>

                    <?php
                    $numslide++;
                endwhile;
            }

        ?>

    
        
        
        
    </div>
</div>
<?php get_footer(); ?>
