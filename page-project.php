<?php 
/**
 * Template Name: Template timeline
 *
 */

get_header(); ?>
<div id="contenuti">
    <div class="grid">
        <div class="grid-sizer"></div>
        <?php 

            $args = array(
                'post_type'  => 'project',
                'posts_per_page' => -1,
                'ignore_custom_sort' => true,
                'orderby' => 'menu_order',
                'order' => 'ASC',
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

                    /* SE immagine scura, allora frecce bianche
                    $is_double = get_post_meta(get_the_ID(), 'webkolm_double_box_home', true);
                    $double_class = '';
                    if($is_double) {
                        $double_class = ' grid-item--width2 ';
                    } */
                    $double_class = '';

                    $connected = p2p_type( 'projects_to_client' )->set_direction( 'to' )->get_connected( get_the_ID() );

                    foreach ($connected as $conn) {
                        if(($conn->post_title != get_the_title()) && ($conn->post_title!=""))
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
</div>
<?php get_footer(); ?>

