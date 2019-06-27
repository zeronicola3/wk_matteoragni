<?php 

/* PULSANTE VK */

add_action( 'vc_before_init', 'wk_button_build' );
function wk_button_build() {
    vc_map( array(
        "name" => __( "Button", "webkolm-dev" ),
        "base" => "wk_button",
        "icon" => get_template_directory_uri() . "/img/VC/w.png",
        "description" => __("Insert button", 'webkolm-dev'),
        "class" => "wk_button",
        "category" => 'Webkolm Add-on',
        "params" => array(
            array(
                'type' => 'textfield',
                'heading' => "Text",
                'param_name' => 'wk_text',
                'value' => "",
                'description' => __( "Button text", "webkolm-dev" )
            ),
            array(
                'type' => 'textfield',
                'heading' => "Link",
                'param_name' => 'wk_link',
                'value' => "",
                'description' => __( "Button link", "webkolm-dev" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Select alignment", "webkolm-dev" ),
                "param_name" => "wk_alignment",
                "value" => array( "left", "center", "right" ),
                "description" => __( "Choose the alignment of the buttons (default left)", "webkolm-dev" )
            ),
            array(
                "type" => "checkbox",
                "heading" => __( "Open in new tab", "webkolm-dev" ),
                "param_name" => "wk_new_tab",
                "value" => "",
            ),
        )
    ) );
}



add_shortcode( 'wk_button', 'wk_button_func' );
function wk_button_func( $atts ) {
    extract( shortcode_atts( array(
        'wk_text' => '',
        'wk_link' => '#',
        'wk_alignment' => '',
        'wk_new_tab' => '',

    ), $atts ) );

    // RANDOM ID SLIDER
    $id_button=rand(0,99999);

    $attr = "";
    if($wk_new_tab != ''){
        $attr = ' target="_blank" ';
    }

    $output .= '
    <div class="wrap_pulsante wk_align_'.$wk_alignment.'">
        <a href="'.$wk_link.'" class="'. $class .' wk-pulsante wk-pulsante-' . $id_button . '" '. $attr .'>'.$wk_text.'</a>
    </div>';

    return $output;
        
}

?>