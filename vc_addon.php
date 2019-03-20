<?php

/* FUNZIONE PER RICAVARE ELENCHI DI CORRELATI */

function featured_posts($type) {
    $args = array(
        'post_type' => $type,
        'posts_per_page' => -1,
        'orderby' =>'title',
        'order' => 'desc',
        'suppress_filters' => 0,
    );
    $query = new WP_Query( $args );

    $list_ids= array();
    $list_ids[__('Choose an option or leave random','webkolm')]='0';

    if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post(); 
         // my loop code, which returns title, thumbnail, etc -- see image below
                $id_post=get_the_ID();
                $array_lingua=wpml_get_language_information($id_post);
                if($array_lingua['language_code']=="it"){
                    $nome_elenco=get_the_title().' - '.$id_post;
                    $list_ids[$nome_elenco]=$id_post;
                }

             endwhile;
         wp_reset_postdata();
         return $list_ids;
    endif;
}



/* PERMETTE DI NASCONDERE UNA COLONNA DA MOBILE */

$attributes = array(
    'type' => 'checkbox',
    'heading' => "<br/>Hide from mobile",
    'param_name' => 'wk_nomobile',
    'value' => "",
    'weight' =>4,
    'description' => __( "Select to hide this content from mobile version", "webkolm" )
);
vc_add_param( 'vc_row', $attributes ); 
vc_add_param( 'vc_column', $attributes ); 



/* FORZARE LARGHEZZA A 100% per LA SINGOLA IMMAGINE */

$attributes = array(
    'type' => 'checkbox',
    'heading' => "<br/>Full width image",
    'param_name' => 'wk_full_width',
    'value' => "",
    'weight' =>4,
    'description' => __( "Select to getting 100% width to the image", "webkolm" )
);
vc_add_param( 'vc_single_image', $attributes );


/* BLOCCA LA LARGHEZZA DELLA RIGA AL WRAPPER */

$attributes = array(
    "type" => "checkbox",
    'heading' => "<br/>Larghezza della riga fissa",
    'param_name' => 'wk_fixrow',
    'value' => "",
    'weight' =>2,
    'description' => __( "La riga si estenderà al massimo fino a 1160px e sarà centrata", "webkolm" )
);
vc_add_param( 'vc_row', $attributes ); 


/* BLOCCA L'ALTEZZA DELLA RIGA' */

$attributes = array(
    "type" => "checkbox",
    'heading' => "<br/>Altezza della riga fissa",
    'param_name' => 'wk_fix_height_row',
    'value' => "",
    'weight' =>2,
    'description' => __( "Fissa l'altezza della riga a 4:3", "webkolm" )
);
vc_add_param( 'vc_row', $attributes ); 


$attributes = array(
    "type" => "checkbox",
    'heading' => "<br/>Blocco scroll",
    'param_name' => 'wk_b-scroll_row',
    'value' => "",
    'weight' =>2,
    'description' => __( "Attiva lo scrolling per blocchi per il blocco corrente", "webkolm" )
);
vc_add_param( 'vc_row', $attributes ); 


$attributes = array(
    "type" => "checkbox",
    'heading' => "<br/>Larghezza della riga fissa",
    'param_name' => 'wk_fixrow',
    'value' => "",
    'weight' =>2,
    'description' => __( "La riga si estenderà al massimo fino a 1150px e sarà centrata", "webkolm" )
);
vc_add_param( 'vc_row_inner', $attributes ); 


/* FORZA IL TESTO IN BIANCO */

$attributes = array(
    "type" => "checkbox",
    'heading' => "<br/>Testo in bianco",
    'param_name' => 'wk_white_text',
    'value' => "",
    'weight' =>2,
    'description' => __( "Il testo contenuto verrà visualizzato di colore bianco", "webkolm" )
);
vc_add_param( 'vc_column_text', $attributes );



global $javascript_append;
//include("vc_templates/tiles.php");
include("vc_templates/wk_slider.php");
//include("vc_templates/social_share.php");
//include("vc_templates/instagram_feed.php");
//include("vc_templates/wk_videoframe.php");
//include("vc_templates/wk_pulsante.php");
//include("vc_templates/vc_fullwidth_text.php");
//include("vc_templates/vc_news.php");
//include("vc_templates/vc_slider_cta.php");
//include("vc_templates/vc_fullwidth_ti.php");
