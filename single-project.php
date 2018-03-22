<?php get_header(); ?>
	<div id="contenuti" class="current-project">
		<?php include get_template_directory() . '/assets/single-project-content.php'; ?>
	</div>

     <?php 
     $data = parse_json_file(); 
    

     function get_next_project($data, $year, $project) {
        reset($data);

        //$next_year = current($data);
        $key_year = key($data);

        while($key_year != $year){

            $next_year = next($data);
            $key_year = key($data);
        }

        $data_year = current($data);
        
        reset($data_year);

        $key_project = key($data_year);

        while($project != $key_project){
            $next_project = next($data_year);
            $key_project = key($data_year);
        }


        if(next($data_year) == null){
            $next_year = next($data);
            $data_year = current($data);
            reset($data_year);
            return current($data_year);
        } else {
            return current($data_year);
        }
     }



    $next_project = get_next_project($data, $meta['webkolm_project_year']['0'], $post->post_name);

     ?>


    <div class="next-project">
        <?php $post = get_post($next_project->ID); 
            setup_postdata($next_project->ID);
        ?>
        <?php include get_template_directory() . '/assets/single-project-content.php'; ?>
    </div>


<?php get_footer(); ?>
