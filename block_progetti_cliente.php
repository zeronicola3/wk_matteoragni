<?php

$connected = $connected = p2p_type( 'projects_to_client' )->get_connected( get_the_ID() );
//print_r($connected);
?>
<!--div class="grid">
    <div class="grid-sizer"></div-->

    <?php
    $store_post = $post;
    while ( $connected->have_posts() ) : $connected->the_post(); 
        //print_r($conn);

        $image_id = get_post_meta(get_the_ID(), 'webkolm_featured_img_input', true);

        if($image_id != ""){

            $url_small = wp_get_attachment_image_src( $image_id, 'medium' );
            $url_big = wp_get_attachment_image_src( $image_id, 'large' );

            // FILTRO LINK A PROGETTI SECONDARI
            $secondary_project = get_post_meta(get_the_ID(), 'webkolm_post_secondario', false)[0];
            if($secondary_project == "yes") {
                $project_link = '';
            } else {
                $project_link = 'href="' . get_the_permalink(). '"';
            }


          /*  if($conn->post_title != get_the_title())
                $titolo = $conn->post_title;
            else
                $client_name = ""; */
            ?>
            <div class="grid-item">
                <a <?php echo $project_link; ?> class="tile-content lazy module" style="background-image: url('<?php echo $url_small[0]; ?>');">
                    <span class="tile-title nomobile" style="color:<?php echo $cursor_color; ?>;"><?php the_title(); ?></span>
                </a>
                <span class="tile-title onlymobile module" style="display:block; margin-top:5px; font-size: 14px;"><?php the_title(); ?></span>
            </div>
            <?php
        }
    endwhile; 
    $post = $store_post;
    ?>