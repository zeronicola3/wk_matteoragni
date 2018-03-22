<?php get_header(); ?>
	<div id="contenuti" class="current-project">
		<?php 
        $post = get_queried_object();

        include get_template_directory() . '/assets/single-project-content.php'; 

        include get_template_directory() . '/assets/next-project-button.php'; ?>

	</div>




    <div class="next-project">
        <?php 
        $post = get_post($next_project['ID']); 
        setup_postdata( $post ); 
        ?>
        <?php include get_template_directory() . '/assets/single-project-content.php'; ?>
    </div>


<?php get_footer(); ?>
