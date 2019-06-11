<?php 
/**
 * Template Name: TEST 3
 *
 */

get_header(); ?>
<div id="contenuti">
    <div class="grid">
        <div class="grid-sizer"></div>
        <?php 
            /*
            $args = array(
                'post_type'  => 'client',
                'posts_per_page' => -1,
                'ignore_custom_sort' => true,
                'orderby' => 'menu_order',
                'order' => 'ASC',
              /*  'meta_query' => array(
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

                    $image_id = get_post_meta(get_the_ID(), 'webkolm_featured_img_input', true);

                    if($image_id != ""){
                        $url_small = wp_get_attachment_image_src( $image_id, 'medium' );
                        $url_big = wp_get_attachment_image_src( $image_id, 'large' );

                        $connected = p2p_type( 'projects_to_client' )->set_direction( 'from' )->get_connected( get_the_ID() );

                        foreach ($connected as $conn) {
                            if($conn->post_title != get_the_title())
                                $client_name = " - " . $conn->post_title;
                            else
                                $client_name = "";
                        }
                        
                        ?>

                        <div class="grid-item ">
                            <a href="<?php echo get_the_permalink(); ?>" class="tile-content" style="background-image: url('<?php echo $url_small[0]; ?>');">
                                <span class="tile-title" style="color:<?php echo $cursor_color; ?>;"><?php the_title(); ?></span>
                            </a>
                        </div>

                    <?php
                    }
                    $numslide++;
                endwhile;
            }
        */
        ?>

        </div>
    </div>
</div>
<?php get_footer(); ?>

