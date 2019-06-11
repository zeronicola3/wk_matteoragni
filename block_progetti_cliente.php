<?php

$connected = $connected = p2p_type( 'projects_to_client' )->get_connected( get_the_ID() );
//print_r($connected);
?>
<!--div class="grid">
    <div class="grid-sizer"></div-->
    <?php
    while ( $connected->have_posts() ) : $connected->the_post(); 
        //print_r($conn);

        the_title();

        $image_id = get_post_meta($conn->ID, 'webkolm_featured_img_input', true);
        $url_small = wp_get_attachment_image_src( $image_id, 'medium' );
        $url_big = wp_get_attachment_image_src( $image_id, 'large' );

        if($conn->post_title != get_the_title())
            $conn->post_title;
        else
            $client_name = "";
        ?>
        <div class="grid-item">
            <a href="<?php echo get_the_permalink($conn->ID); ?>" class="tile-content" style="background-image: url('<?php echo $url_small[0]; ?>');">
                <span class="tile-title" style="color:<?php echo $cursor_color; ?>;"><?php echo $conn->post_title; ?></span>
            </a>
        </div>
        <?php
    endwhile; ?>