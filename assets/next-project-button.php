<?php 
        
$data = parse_json_file(); 

$next_project = get_next_project($data, $meta['webkolm_project_year']['0'], $post->post_name);

wp_reset_postdata();

?>

<div class="wrapper next-project-button">Related project: <a href=""><?php echo $next_project['title']; ?></a></div>