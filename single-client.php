<?php 

get_header(); ?>
<div id="contenuti">
    
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <div class="wrapper solo-padding">
                <h3 class="titoletto-home">all projects for <?php echo the_title();?></h3>
            </div>
            <div class="grid">
                <div class="grid-sizer"></div>
                <?php include 'block_progetti_cliente.php'; ?>
            </div>
                <?php

                $numslide++;
            endwhile;
        endif;

    ?>
</div>
<?php get_footer(); ?>
