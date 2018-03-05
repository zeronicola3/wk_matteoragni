<?php 


/**
 *	
 *
 **/
function get_array_sorted_by_years(){
	global $post;

	$args = [
	    'post_type'      => 'project',
	    'posts_per_page' => -1,
	];

	$projects = get_posts( $args );
	$json_array = array();
	foreach ($projects as $project) {
		$year = get_post_meta($project->ID, 'webkolm_project_year', true);
		if($year != "") {
			if(!in_array($year, $json_array)){
				$json_array[$year] = get_projects_by_year($year);
			}
		}
	}

	krsort($json_array);

	return $json_array;
}



function get_projects_by_year($year){

	global $post;

	$meta_query_args = array(
		'post_type' => 'project',
		'meta_query' => array(   
			array(
				'key'     => 'webkolm_project_year',
				'value'   => $year,
				'compare' => '='
			)
		)
	);
	$meta_query = new WP_Query( $meta_query_args );

	$project_array = array();

	if ( $meta_query->have_posts() ) :
	    // Start the Loop.
	    while ( $meta_query->have_posts() ) : $meta_query->the_post();

	    	$is_secondary = 0;
	    	$secondary_project = get_post_meta($post->ID, 'webkolm_post_secondario', false)[0];
	    	if($secondary_project == "yes") {
	    		$is_secondary = 1;
	    	}

	    	$project[$post->post_name] = array(
	    		'ID' => $post->ID,
	    		'slug' => $post->post_name,
	    		'title' => $post->post_title,
	    		'description' => $post->post_excerpt,
	    		'url' => get_the_permalink($post->ID),
	    		'is_secondary' => $is_secondary,
	    		'year' => $year,
	    		//'clienti' => get_clients($post->ID),
	    		'img_urls' => get_images($post->ID)
	    	);

	    endwhile;
	endif;

	return $project;
}



function get_clients($post_id){

	$connected = p2p_type( 'projects_to_client' )->set_direction( 'to' )->get_connected( $post_id );
	$clients = array();

    foreach ($connected as $conn) {
    	array_push($clients, array(
    		'ID' => $conn->ID,
    		'title' => $conn->post_title,
    		'url' => $conn->webkolm_client_link
    	));
    }

    return $clients;
}


function get_images($post_id) {

	$img_id = get_post_meta($post_id, 'webkolm_featured_img_input', true);

	if($img_id != "") {
		return array(
			'medium' => wp_get_attachment_image_src( $img_id, 'medium' )[0],
			'large' => wp_get_attachment_image_src( $img_id, 'large' )[0],
			'full' => wp_get_attachment_image_src( $img_id, 'full' )[0],
		);
	} 
	
	return null;
}


/**
 *  Creates json formatted output with all root folders in cloudinary, width relatives subdirs, covers and images in subdirs.
 *  @return json string
 **/
function generate_projects_json() {

    return json_encode(get_array_sorted_by_years());
}

/**
 *  Updates cloudinary content cache JSON file in current theme directory
 *  @return file ./results.json 
 **/
function update_projects_json(){

    $fp = fopen(__DIR__ . '/timeline.json', 'w');
    $data = generate_projects_json();
    fwrite($fp, $data);
    fclose($fp);
}

/**
 *  Gets array
 *  @return file ./results.json 
 **/
function parse_json_file(){
    // Read JSON file
    $json = file_get_contents(__DIR__ . '/timeline.json');
    //Decode JSON
    $json_data = json_decode($json,true);

    return $json_data;
}








?>