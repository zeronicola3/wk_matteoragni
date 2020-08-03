<?php 

get_header(); ?>
<div id="contenuti">
    <div class="wrapper">
        <h2>Risulati per: <?php echo $_GET['s']; ?></h2>
    </div>
    <div class="grid">
        <div class="grid-sizer"></div>
        <?php 

            global $query_string;

            wp_parse_str( $query_string, $search_query );
            $query = new WP_Query( $search_query );

            if ( $query->have_posts() ) {

                $numslide=1;
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post(); 

                    include 'block_grid-item_progetto.php'; 
                    
                endwhile;
            }

        ?>

        </div>
    </div>
</div>
<?php get_footer(); ?>

