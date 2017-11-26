<?php


add_action( 'vc_before_init', 'wk_quote_build' );
function wk_quote_build() {

    vc_map( array(
        "name" => __( "Webkolm Citazione", "webkolm" ),
        "base" => "webkolm_quote",
        "icon" => get_template_directory_uri() . "/img/VC/w.png",
        "description" => __("Create a quote area", 'webkolm'),
        "class" => "wk-quote",
        "category" => 'Webkolm Add-on',
        "params" => array(
            array(
                'type' => 'textarea',
                'value' => '',
                'heading' => __( "Text for quote", "webkolm" ),
                'param_name' => 'wk_quote_textarea',
                'admin_label' => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Select quote style", "webkolm" ),
                "param_name" => "wk_quote_style",
                "value" => array( "virgolette-grandi", "evidenziato-grande", "testo-fino" ),
                "description" => __( "Choose quote style", "webkolm" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Select text alignment", "webkolm" ),
                "param_name" => "wk_quote_align",
                "value" => array("left", "center", "right"),
                "description" => __( "Choose the text alignment in quote", "webkolm" )
            ),
            )   
        )
    );
}


add_shortcode( 'webkolm_quote', 'wk_quote_func' );
function wk_quote_func( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'wk_quote_style' => 'virgolette-grandi',
        'wk_quote_textarea' => '',
        'wk_quote_align' => 'left',
    ), $atts ) );



   $output = '<div class="wk-quote ' . $wk_quote_style . ' wk-align-' . $wk_quote_align . '"><span class="highlight">
                    ' . $wk_quote_textarea . '
                <span></div>';

    return $output;
}

?>