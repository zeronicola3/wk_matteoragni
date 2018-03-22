<?php get_header(); ?>
	<div id="contenuti" class="current-project">
		<?php 
        $post = get_queried_object();

        include get_template_directory() . '/assets/single-project-content.php'; 

        include get_template_directory() . '/assets/next-project-button.php'; ?>

	</div>

    <?php include get_template_directory() . '/assets/next-project-block.php'; ?>

<?php get_footer(); ?>
