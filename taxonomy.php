<?php 

get_header(); 

$queried_object = get_queried_object();
$tax = get_category(get_queried_object());

?>
<div id="contenuti">
    <div class="wrapper solo-padding">
        <h3 class="wk-client-title">all projects for <?php echo $tax->name;?></h3>
    </div>
    <div class="grid">
        <div class="grid-sizer"></div>
        <?php 

        if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); 

            include 'block_grid-item_progetto.php';
            $numslide++;
            
            endwhile;
        endif;
    ?>
    </div>
</div>
<?php get_footer(); ?>
