<?php 
        
$connected = p2p_type( 'projects_to_projects' )->set_direction( 'to' )->get_connected( $post->ID );


print_r($connected);

$number = 0;

foreach ($connected as $conn) {

    /*if($number > 0){
    	break;
    }
*/
    print_r($conn);

    $next_project = $conn;

    $number ++;
}

//print_r($conn);

echo $conn->ID;

wp_reset_postdata();

?>

<div class="wrapper next-project-button">Related project: <a href=""><?php echo $next_project['title']; ?></a></div>