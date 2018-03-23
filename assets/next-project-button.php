<?php 
        
$connected = p2p_type( 'projects_to_projects' )->set_direction( 'to' )->get_connected( $post->ID );


print_r($connected);

$number = 0;

foreach ($connected as $conn) {

    if($number > 0){
    	break;
    }

    $next_project = $conn;

    $number ++;
}

print_r($conn);

wp_reset_postdata();

?>

<div class="wrapper next-project-button">Related project: <a href=""><?php echo $next_project['title']; ?></a></div>