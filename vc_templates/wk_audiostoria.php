<?php

function featured_posts($type) {
    $args = array(
        'post_type' => $type,
        'orderby' =>'title',
        'order' => 'desc',
     //   'suppress_filters' => 0,
        'posts_per_page' => -1,


      //  'tax_query' => array(
         //   array(
             //   'taxonomy' => 'azioni',
              //  'field'    => 'term_id',
               // 'terms'    => array(19),
           // )
        
    );

    $query = new WP_Query( $args );

    $list_ids= array();
    $list_ids[__('Choose an option or leave random','webkolm')]='0';

    if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post(); 
         // my loop code, which returns title, thumbnail, etc -- see image below

                $id_post=get_the_ID();

                $meta = get_post_meta($id_post, 'wp_custom_attachment', true); 

                if($meta != "") {
                    $nome_elenco=get_the_title().' - '.$id_post;
                    $list_ids[$nome_elenco]=$id_post;
                }

             endwhile;
         wp_reset_postdata();
         return $list_ids;
    endif;
}

add_action( 'vc_before_init', 'wk_audiostoria_altitudini_build' );

function wk_audiostoria_altitudini_build() {

    vc_map( array(
        "name" => __( "Webkolm Blocco audiostoria altitudini", "webkolm" ),
        "base" => "webkolm_audiostoria_altitudini",
        "icon" => get_template_directory_uri() . "/img/VC/w.png",
        "description" => __("Crea un blocco audiostoria", 'webkolm'),
        "class" => "wk-audiostoria-altitudini",
        "category" => 'Webkolm Add-on',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __( "Audiostoria correlata", "webkolm" ),
                "param_name" => "wk_audiostoria_correlata",
                "admin_label" => true,
                'value' => featured_posts('post'),
                "description" => __( "Scegli un audiostoria", "webkolm" ),
            ), 
            ), 
        )
    );
}


add_shortcode( 'webkolm_audiostoria_altitudini', 'wk_audiostoria_altitudini_func' );


function wk_audiostoria_altitudini_func( $atts) {

    global $post;

    extract( shortcode_atts( array(
        'wk_audiostoria_correlata' => '',
    ), $atts ) );


    if($wk_audiostoria_correlata != "") {
        $meta = get_post_meta($wk_audiostoria_correlata, 'wp_custom_attachment', true); 
    } else {
        $meta = get_post_meta($post->ID, 'wp_custom_attachment', true); 
    }

    $output = "<h4 class='titolo-audiostoria'>Ascolta l'audiostoria</h4>";

    $output .= '<audio controls class="player-audiostoria">
      <source src="' . $meta['url'] . '" type="audio/mpeg">
    Your browser does not support the audio element.
    </audio>';

    return $output;
}

?>