<?php 
/**
 * Template Name: Homepage
 *
 */

get_header(); ?>
<div id="contenuti">

		<div class="wp_content">
        <?php
            $args = array(
                'post_type'  => 'project',
                'posts_per_page' => '-1',
            );

            $query = new WP_Query($args);

            if ( $query->have_posts() ) :
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post();

                    $meta = get_post_meta( $post->ID ); 
                    $elem_number = rand(10,9999);

                    $connected = p2p_type( 'projects_to_client' )->set_direction( 'to' )->get_connected( $post->ID );

                    foreach ($connected as $conn) {
                        $client_id = $conn->ID;
                        $client_name = $client_id->post_title;
                    }

                    ?>

                    <div class="project-cover-gallery project-cover-gallery-<?php echo $elem_number; ?>">
                        <ul class="slides">
                        <?php
                            $numslide=1;
                            $post_content = get_post_meta($post->ID, 'webkolm_gallery_test', true);

                            if($post_content != "") {

                                preg_match('/\[gallery.*ids=.(.*).\]/', $post_content, $ids);
                                $array_id = explode(",", $ids[1]);

                                
                                foreach ($array_id as &$item) {
                                    $url_small = wp_get_attachment_image_src( $item, 'medium' );
                                    $url_big = wp_get_attachment_image_src( $item, 'large' );
                                    //  image field TRUE = cover; FALSE = contain
                                    $is_contain = (bool) get_post_meta( $item, 'image-bg-size', true );
                                      
                                    ?>
                                    <li class="project_slide-<?= $numslide; ?> slideimg">
                                        <style>
                                            .project-cover-gallery-<?php echo $elem_number; ?> .project_slide-<?= $numslide; ?> { 
                                                background-image:url('<?php echo $url_small['0'] ?>');
                                            }

                                            @media (min-width: 768px) {  
                                                .project-cover-gallery-<?php echo $elem_number; ?> .project_slide-<?= $numslide; ?> { 
                                                    background-image:url('<?php echo $url_big['0'] ?>');
                                                    background-size: <?php if($is_contain){ echo 'contain'; }else{ echo 'cover'; }?> ;
                                                }
                                            }

                                        </style>
                                    </li>
                                    <?php $numslide++;
                                }
                            }   ?>
                        </ul>
                    </div>



                    <div class="project-container wrapper">
                        <div class="project-col wkcol-5 project-header">
                            <h4 class="project-title"><?php the_title(); ?></h4>
                            <span class="project-designer"><?php echo $meta['webkolm_designer']['0']; ?><br></span>
                            <!--span class="project-client"><?php echo $client_name; ?><br></span-->
                            <span class="project-year"><?php echo $meta['webkolm_project_year']['0']; ?></span>
                        </div>
                        <div class="wkcol-1"></div>
                        <div class="project-col wkcol-5 project-prizes">
                            <?php echo $meta['webkolm_prizes_test']['0']; ?>
                        </div>
                        <div class="wkcol-1"></div>
                        <div class="project-col project-content wkcol-12">
                            <?php the_content(); ?>
                        </div>
                        
                    </div>

        <?php   endwhile;
            endif;
        ?>
        <?php twentythirteen_paging_nav();?>
        </div>
</div>
<?php get_footer(); ?>
