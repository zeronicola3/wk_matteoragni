<?php
$post_id = get_the_ID();

// FILTRO IMMAGINE DI GRIGLIA
$image_id = get_post_meta($post_id, 'webkolm_featured_img_input', true);
if($image_id != ""){
    $url_small = wp_get_attachment_image_src( $image_id, 'medium' );
    $url_big = wp_get_attachment_image_src( $image_id, 'large' );

    // FILTRO LINK A PROGETTI SECONDARI
    $secondary_project = get_post_meta($post_id, 'webkolm_post_secondario', false)[0];
    if($secondary_project == "yes") {
        $project_link = '';
    } else {
        $project_link = 'href="' . get_the_permalink(). '"';
    }
    
    // CLIENTE CORRELATO AL PROGETTO
    $connected = p2p_type( 'projects_to_client' )->set_direction( 'to' )->get_connected( $post_id );

    foreach ($connected as $conn) {

        if(!empty($conn->post_title)){
            $client_name = "<br/><span class='tile-client'>" . $conn->post_title . "</span>";
        }
        /*
        if($conn->post_title != get_the_title())
            $client_name = "<br/><span class='tile-client'>" . $conn->post_title . "</span>";
        else
            $client_name = "";
        */
    }
    
    ?>

    <div class="grid-item">
        <a <?php echo $project_link; ?> class="tile-content lazy module" style="background-image: url('<?php echo $url_small[0]; ?>');">
            <span class="tile-title nomobile" ><?php the_title(); ?><?php echo $client_name; ?></span>
        </a>
        <span class="tile-title onlymobile module" style="display:block; margin-top:5px; font-size: 14px;"><?php the_title(); ?><?php echo $client_name; ?></span>
    </div>

<?php
}
?>