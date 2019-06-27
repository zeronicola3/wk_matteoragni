<?php 

get_header(); ?>
<div id="contenuti">
    <div class="wp_content">
        <?php the_content(); ?>
    </div>

    <div class="wrapper solo-padding">
        <h3 class="wk-client-title">all projects for <?php echo the_title();?></h3>
    </div>
    <div class="grid">
        <div class="grid-sizer"></div>
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); 

            include 'block_grid-item_progetto.php';
            $numslide++;
            
            endwhile;
        endif;
    ?>
    </div>
</div>
<?php get_footer(); ?>
