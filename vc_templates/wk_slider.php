<?php


add_action( 'vc_before_init', 'wk_slider_build' );
function wk_slider_build() {

    vc_map( array(
        "name" => __( "Webkolm Image Slider", "webkolm" ),
        "base" => "webkolm_slider",
        "icon" => get_template_directory_uri() . "/img/VC/w.png",
        "description" => __("Create an image slider with text", 'webkolm'),
        "class" => "wk-slider",
        "category" => 'Webkolm Add-on',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __( "Stile transizione", "webkolm" ),
                "param_name" => "wk_slider_transition",
                "value" => array( "fade", "slide" ),
                "description" => __( "Choose the ptype of the trasition", "webkolm" )
            ),
            array(
                'type' => 'textfield',
                'value' => '',
                'heading' => __( "Transition speed in ms", "webkolm" ),
                'param_name' => 'wk_slider_speed',
            ),
            //PARAMS GROUP
            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'slides',
                // Note params is mapped inside param-group:
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => __( "Title", "webkolm" ),
                        'param_name' => 'wk_slide_title',
                    ),
                    array(
                        "type" => "attach_image",
                        "holder" => "img",
                        "class" => "",
                        "heading" => __( "Select image", "webkolm" ),
                        "param_name" => "wk_slide_image",
                        "value" => "",
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'value' => '',
                        'heading' => __( "Image caption", "webkolm" ),
                        'param_name' => 'wk_slide_image_caption',
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __( "Select text alignment", "webkolm" ),
                        "param_name" => "wk_slide_text_position",
                        "value" => array( "top-left", "top-center", "top-right", "center-left", "center-center", "center-right", "bottom-left", "bottom-center", "bottom-right" ),
                        "description" => __( "Choose the alignment of the text", "webkolm" )
                    ),
                    array(
                        "type" => "colorpicker",
                        "heading" => __( "Select text color", "webkolm" ),
                        "param_name" => "wk_slide_text_color",
                        "value" => "#fff",
                        "description" => __( "Color for text, defualt is white", "webkolm" )
                    ),
                )
            )
        )
    ) );
}


global $javascript_append;

add_shortcode( 'webkolm_slider', 'wk_slider_func' );
function wk_slider_func( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'wk_slider_transition' => 'fade',
        'wk_slider_speed' => '4000',
    ), $atts ) );
    $slides= vc_param_group_parse_atts( $atts['slides'] );
    
    // VELOCITA
    $velocita_slider=$wk_slider_speed;

    // TIPOLOGIA DI TRANSIZIONE
    $transizione_slider=$wk_slider_transition;

    // RANDOM ID SLIDER
    $id_slider=rand(0,99999);


    // CREO SLIDER FLEXSLIDER
    $output.='<div id="slider-wk-'.$id_slider.'" class="wk-slider '.$slider_class.'" ><ul class="slides">';
     
    $numslide=0;
    // CICLO LE SLIDES
    foreach( $slides as $slide ){
        $images_small = wp_get_attachment_image_src($slide['wk_slide_image'], 'medium')[0];
        $images_big = wp_get_attachment_image_src($slide['wk_slide_image'], 'large')[0];
        $images = wp_get_attachment_image_src($slide['wk_slide_image'], 'full')[0];

        // CHECK CAPTION
        $caption="";
        if($slide['wk_slide_image_caption']!=""){
            $caption='<div class="caption"><span>'.$slide['wk_slide_image_caption'].'</span></div>';
            $class_gradient = " gradient ";

        }

        // CHECK SLIDE TITLE
        $slide_title = "";
        if($slide['wk_slide_title'] != ""){
            $slide_title = 
                '<div class="testo_slide '.$slide['wk_slide_text_position'].' nomobile">
                    <h1 class="slide-title" style="color:'.$slide['wk_slide_text_color'].'">'. $slide['wk_slide_title'] .'</h1>
                </div>';

            $slide_title_mobile = 
                '<div class="testo_slide onlymobile">
                    <h1 class="slide-title">'. $slide['wk_slide_title'] .'</h1>
                </div>';
        }

        $output.='
            
            <li class="slide-'.$id_slider.'-'.$numslide.'">
                <style>
                  .slideimg-'.$id_slider.'-'.$numslide.' { background-image:url('.$images_small.');}
                  @media (min-width: 768px) {  .slideimg-'.$id_slider.'-'.$numslide.' { background-image:url('.$images_big.'); } }
                  @media (min-width: 1800px) {  .slideimg-'.$id_slider.'-'.$numslide.' { background-image:url('.$images.'); } }
                </style>
                <div class="slideimg-'.$id_slider.'-'.$numslide.' slideimg ' . $class_gradient . ' no-mobile">
                    '.$slide_title.'
                    '.$caption.'
                </div>
                '. $slide_title_mobile .'
            </li>';

        $numslide++;
    }

    // CHIUDO SLIDER
    $output .='</ul></div>';
    



    // JS SLIDER INIZIALIZZAZIONE
    global $javascript_append;
    $javascript_append.='
        <script>
            $("#slider-wk-'.$id_slider.'").flexslider({
                animation: "'.$transizione_slider.'",
                animationLoop: true,
                slideshowSpeed : "'.$velocita_slider.'",
                 pauseOnHover: true,
                multipleKeyboard: true,
                keyboard: true,
                controlNav: true,
              
            });
        </script>';


    return $output;
}


?>