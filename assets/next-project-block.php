
    <?php 
    $post = get_post($next_project['ID']); 
    setup_postdata( $post ); 
    ?>
<div class="next-project" data-id="<?php echo $post->ID; ?>">
    <?php include get_template_directory() . '/assets/single-project-content.php'; 
    
    include get_template_directory() . '/assets/next-project-button.php'; ?>
</div>