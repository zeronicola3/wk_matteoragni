<?php 
/**
 * Template Name: Homepage
 *
 */

get_header(); ?>
<div id="contenuti">
    <div class="wp_content">
        <?php 

        //print_r($post);
        the_content(); ?>
    </div>

    <?php $selected_posts = array(); ?>

    <div class="wrapper solo-padding"><h3 class="titoletto-home">SELECTED PROJECTS</h3></div>
    <div class="grid">
        <div class="grid-sizer"></div>
        <?php 

            $args = array(
                'post_type'  => 'project',
                'posts_per_page' => -1,
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
                    $is_double = get_post_meta(get_the_ID(), 'webkolm_double_box_home', true);
                    $double_class = '';
                    if($is_double) {
                        $double_class = ' grid-item--width2 ';
                        $url_small[0] = $url_big[0];
                    }

                    // CLIENTE CORRELATO AL TROGETTO
                    $connected = p2p_type( 'projects_to_client' )->set_direction( 'to' )->get_connected( get_the_ID() );

                    foreach ($connected as $conn) {
                        //print_r($conn->post_title);
                        if($conn->post_title != ""){
                            $client_name = "<br/><span class='tile-client'>" . $conn->post_title . "</span>";
                        }
                        
                        /*f($conn->post_title != get_the_title()){
                            
                        } else {
                            $client_name = "";
                        }*/
                    }
                    

                    ?>

                    <div class="grid-item <?php echo $double_class; ?>">
                        <a href="<?php echo get_the_permalink(); ?>" class="tile-content lazy module" style="background-image: url('<?php echo $url_small[0]; ?>');">
                            <span class="tile-title nomobile "><?php the_title(); ?><?php echo $client_name; ?></span>
                        </a>
                        <span class="tile-title onlymobile module" style="display:block; margin-top:5px; font-size: 14px;"><?php the_title(); ?><?php echo $client_name; ?></span>
                    </div>

                    <?php
                    array_push($selected_posts,get_the_ID());

                    $numslide++;
                endwhile;
            }

        ?>

    
        
        
        
    </div>
</div>

<div class="wrapper solo-padding">
    <h3 class="titoletto-home"><a href="<?php echo get_the_permalink(12); ?>">VIEW ALL PROJECTS</a></h3>
</div>
    <div class="grid">
        <div class="grid-sizer"></div>
        <?php 

            $args = array(
                'post_type'  => 'project',
                'posts_per_page' => -1,
                'ignore_custom_sort' => true,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post__not_in' => $selected_posts
            );

            $query = new WP_Query($args);

            if ( $query->have_posts() ) {

                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post(); 

                    // FILTRO PROGETTO SOLO IN TIMELINE
                    $secondary_project = get_post_meta($post->ID, 'webkolm_post_secondario', false)[0];
                    if($secondary_project != "yes"){

                        include 'block_grid-item_progetto.php';

                    }
                endwhile;
            } ?>
    </div>
</div>
<?php get_footer(); ?>
