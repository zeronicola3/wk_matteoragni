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
                'posts_per_page' => -1,
                'meta_key'     => 'webkolm_homepage_post_box',
                'meta_value'   => '1',
                'meta_compare' => '==',
            );

            $query = new WP_Query($args);

            if ( $query->have_posts() ) :
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post();

                    the_title();
                    /*
                    $client_name = $client_link = $client_id = $connected = "";
                    $meta = get_post_meta( $post->ID ); 
                    $elem_number = rand(10,9999);

                    $connected = p2p_type( 'projects_to_client' )->set_direction( 'to' )->get_connected( get_the_ID() );

                    foreach ($connected as $conn) {
                        $client_id = $conn->ID;
                        $client_name = $conn->post_title;
                        $client_link = $conn->webkolm_client_link;
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


        <?php   */
                endwhile;
            endif;
        ?>
        </div>
</div>
<?php get_footer(); ?>
