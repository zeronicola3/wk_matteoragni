<?php


add_action( 'vc_before_init', 'wk_text_build' );
function wk_text_build() {

    vc_map( array(
        "name" => __( "Webkolm Blocco Testo", "webkolm" ),
        "base" => "webkolm_text",
        "icon" => get_template_directory_uri() . "/img/VC/w.png",
        "description" => __("Crea un blocco testo", 'webkolm'),
        "class" => "wk-text",
        "category" => 'Webkolm Add-on',
        "params" => array(
            array(
                "type" => "checkbox",
                "heading" => __( "Capitalizza prima lettera", "webkolm" ),
                "param_name" => "wk_capitalize",
                "value" => "",
            ),
            array(
                'type' => 'textarea',
                'value' => '',
                'heading' => __( "Starter text", "webkolm" ),
                'param_name' => 'wk_starter_text',
                "description" => __( "Testo iniziale in corsivo (facoltativo)", "webkolm" )
            ),
            
            array(
                "type" => "dropdown",
                "heading" => __( "Layout del testo", "webkolm" ),
                "param_name" => "wk_text_layout",
                "value" => array("nessuna colonna","colonna centrata", "colonne multiple"),
                "description" => __( "Layout delle colonne del testo (default: 'nessuna colonna')", "webkolm" )
            ),
            array(
                "type" => "textarea_html",
                "heading" => __( "Testo principale", "webkolm" ),
                "param_name" => "content",
                "value" => "",
                'admin_label' => true,
            ),


            ), 
        )
    );
}


add_shortcode( 'webkolm_text', 'wk_text_func' );
function wk_text_func( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'wk_enable_starter' => '',
        'wk_capitalize' => '',
        'wk_starter_text' => '',
        'wk_text_layout' => 'nessuna colonna',
    ), $atts ) );

    $content = wpb_js_remove_wpautop($content, true);

    $output = '';


    if ($wk_starter_text != "") {

        $starter_classes = 'wk-starter-text ';

        if (!empty($atts['wk_capitalize'])) {
            $starter_classes .= ' wk-capitalize ';
        } 
        if ($wk_text_layout == 'colonna centrata') {
            $starter_classes .= ' wk-centred ';
        } 

        $output .= '<div class="' . $starter_classes . '">' . $wk_starter_text . '</div>';
    } else {
        if (!empty($atts['wk_capitalize'])) {
            $main_classes .= ' wk-capitalize ';
        } 
    }


    if ($wk_text_layout == 'colonna centrata') {
        $main_classes .= ' wk-centred ';
    } elseif($wk_text_layout == 'colonne multiple') {
        $main_classes .= ' colonne-multiple ';   
    }

    $output .= '<div class="wk-main-text ' . $main_classes . '" >' . $content . '</div>';

    return $output;
}

?>