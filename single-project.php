<?php get_header(); ?>

<?php 
        $post = get_queried_object(); ?>
	<div id="contenuti" class="current-project" data-id="<?php echo $post->ID; ?>">
		
    <?php
        get_template_part('assets/single-project-content'); 
    ?>

	</div>

    <?php  get_template_part('assets/next-project-block'); ?>

<?php get_footer(); ?>
