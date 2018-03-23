<?php get_header(); ?>

<?php 
        $post = get_queried_object(); ?>
	<div id="contenuti" class="current-project" data-id="<?php echo $post->ID; ?>">
		
    <?php
        include get_template_directory() . '/assets/single-project-content.php'; 

        include get_template_directory() . '/assets/next-project-button.php'; 
    ?>

	</div>

    <?php include get_template_directory() . '/assets/next-project-block.php'; ?>

<?php get_footer(); ?>
