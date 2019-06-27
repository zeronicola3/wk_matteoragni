<?php
$image_id = get_post_meta(get_the_ID(), 'webkolm_featured_img_input', true);

if($image_id != ""){
    $url_small = wp_get_attachment_image_src( $image_id, 'medium' );
    $url_big = wp_get_attachment_image_src( $image_id, 'large' );

    // SE immagine scura, allora frecce bianche
    $is_dark_image = get_post_meta(get_the_ID(), 'webkolm_dark_image', true);
    $cursor_color = ' ';
    if($is_dark_image) {
        $cursor_color = ' white-text ';
    }
    
    $double_class = '';

    $connected = p2p_type( 'projects_to_client' )->set_direction( 'to' )->get_connected( get_the_ID() );

    foreach ($connected as $conn) {
        if($conn->post_title != get_the_title())
            $client_name = "<br/><span class='tile-client'>" . $conn->post_title . "</span>";
        else
            $client_name = "";
    }
    
    ?>

    <div class="grid-item lazy module <?php echo $double_class; ?>">
        <a href="<?php echo get_the_permalink(); ?>" class="tile-content" style="background-image: url('<?php echo $url_small[0]; ?>');">
            <span class="tile-title <?php echo $cursor_color; ?>" ><?php the_title(); ?><?php echo $client_name; ?></span>
        </a>
    </div>

<?php
}
?>