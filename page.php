<?php get_header(); ?>
<div id="contenuti">
	<div class="wrapper">
		<div class="wp_content">

        <?php
            if ( have_posts() ) :
                // Start the Loop.
                while ( have_posts() ) : the_post();

                    the_content();

                endwhile;
            endif;
        ?>
        </div>
	</div>
</div>
<?php get_footer(); ?>
