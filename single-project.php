<?php get_header(); ?>
	<div id="contenuti" class="current-project">
		<?php 
        $post = get_queried_object();

        include get_template_directory() . '/assets/single-project-content.php'; ?>
	</div>

    <?php 
    
    $data = parse_json_file(); 
    
    $next_project = get_next_project($data, $meta['webkolm_project_year']['0'], $post->post_name);

    wp_reset_postdata();

     ?>


    <div class="next-project">
        <?php 
        $post = get_post($next_project['ID']); 
        setup_postdata( $post ); 
        ?>
        <?php include get_template_directory() . '/assets/single-project-content.php'; ?>
    </div>


<?php get_footer(); ?>
