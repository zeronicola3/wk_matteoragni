<?php 
        
$connected = p2p_type( 'projects_to_projects' )->set_direction( 'to' )->get_connected( $post->ID );


print_r($connected);

/*foreach ($connected as $conn) {
    $client_id = $conn->ID;
    $client_name = $conn->post_title;
    $client_link = $conn->webkolm_client_link;
}*/

$next_project = get_next_project($data, $meta['webkolm_project_year']['0'], $post->post_name);

wp_reset_postdata();

?>

<div class="wrapper next-project-button">Related project: <a href=""><?php echo $next_project['title']; ?></a></div>