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

        $image_id = get_post_thumbnail_id(get_the_ID());
        $url_small = wp_get_attachment_image_src( $image_id, 'medium' );
        $url_big = wp_get_attachment_image_src( $image_id, 'large' );


      /*  if($conn->post_title != get_the_title())
            $titolo = $conn->post_title;
        else
            $client_name = ""; */
        ?>
        <div class="grid-item lazy module">
            <a href="<?php echo get_the_permalink($conn->ID); ?>" class="tile-content" style="background-image: url('<?php echo $url_small[0]; ?>');">
                <span class="tile-title" style="color:<?php echo $cursor_color; ?>;"><?php the_title(); ?></span>
            </a>
        </div>
        <?php
    endwhile; 
    $post = $store_post;
    ?>