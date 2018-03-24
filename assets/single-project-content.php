<div class="wp_content">
	<?php 

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



    <div class="project-container wrapper">
        <div class="project-col wkcol-5 project-header">
            <h4 class="project-title"><?php the_title(); ?></h4>
        <?php if($meta['webkolm_designer']['0'] != ""){ ?>
            <span class="project-designer"><?php echo $meta['webkolm_designer']['0']; ?><br></span>
        <?php } ?>
        <?php if($client_id != ""){ ?>
            <span class="project-client"><a href="<?php echo $client_link; ?>"><?php echo $client_name; ?></a><br></span>
        <?php } ?>
        <?php if($meta['webkolm_project_year']['0'] != ""){ ?>
            <span class="project-year"><?php echo $meta['webkolm_project_year']['0']; ?></span>
        <?php } ?>
        </div>
        <div class="wkcol-1"></div>
        <div class="project-col wkcol-5 project-prizes">
            <?php echo $meta['webkolm_prizes_test']['0']; ?>
        </div>
        <div class="wkcol-1"></div>
        <div class="project-col project-content wkcol-12">
            <?php echo the_content(); ?>
        </div>
        
    </div>

    

</div>

<?php 
   
    $connected1 = p2p_type( 'projects_to_projects')->set_direction( 'to' )->get_connected( get_the_ID() );

    wp_reset_postdata();

    foreach ($connected1 as $conn1) {
        //echo $conn1->ID;
        //echo $conn1->post_title;
    } 

    $post = get_post($conn1->ID);

    setup_postdata($post);

    ?>

    <div class="wrapper next-project-button">Related project: <a href=""><?php echo $post->post_title; ?></a></div>
