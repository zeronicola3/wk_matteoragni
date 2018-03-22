<?php get_header(); ?>
	<div id="contenuti" class="current-project">
		<?php include get_template_directory() . '/assets/single-project-content.php'; ?>
	</div>

    <div class="next-project">
        <?php $post = get_post($next_project->ID); ?>
    </div>


<?php get_footer(); ?>
