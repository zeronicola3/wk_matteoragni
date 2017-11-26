<?php


add_action( 'vc_before_init', 'wk_post_cover_build' );
function wk_post_cover_build() {

    vc_map( array(
        "name" => __( "Webkolm Post Cover", "webkolm" ),
        "base" => "webkolm_post_cover",
        "icon" => get_template_directory_uri() . "/img/VC/w.png",
        "description" => __("Create a cover for single post", 'webkolm'),
        "class" => "wk-post-cover",
        "category" => 'Webkolm Add-on',
        "params" => array(
            array(
                'type' => 'textarea',
                'value' => '',
                'heading' => __( "Image caption", "webkolm" ),
                'param_name' => 'wk_image_caption',
            ),
            array(
                "type" => "colorpicker",
                "heading" => __( "Select text color", "webkolm" ),
                "param_name" => "wk_text_color",
                "value" => "#fff",
                "description" => __( "Color for text, defualt is white", "webkolm" )
            ),
             array(
                "type" => "attach_image",
                "holder" => "img",
                "class" => "",
                "heading" => __( "Select image", "webkolm" ),
                "param_name" => "wk_background_image",
                "value" => "",
            ),
            )   
        )
    );
}


add_shortcode( 'webkolm_post_cover', 'wk_post_cover_func' );
function wk_post_cover_func( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'wk_text_color' => '#fff',
        'wk_background_image' => '',
        'wk_image_caption' => '',
    ), $atts ) );

    $elem_number = rand(10,9999); 

    $big_img = wp_get_attachment_image_src($wk_background_image, "full");
    $mobile_img = wp_get_attachment_image_src($wk_background_image, 'medium');

    
    $output .= '<style>
                    .wk-cover-container.wk-cover-' . $elem_number . ' { 
                        background-image:url("' . $mobile_img['0'] . '");
                    }

                    .wk-cover-container .wk-cover-text .wk-cover-title.wk-cover-' . $elem_number . ' {
                        color: ' . $wk_text_color . ';
                    }

                    .wk-cover-container .wk-cover-caption.wk-cover-' . $elem_number . ' {
                        color: ' . $wk_text_color . ';
                    }

                    @media (min-width: 768px) {  
                        .wk-cover-container.wk-cover-' . $elem_number . ' { background-image:url("' . $big_img['0'] . '"); 
                        }
                    }
                </style>';


    $output .=   '<div class="wk-cover-container wk-cover-' . $elem_number . ' gradient ">
                    <div class="wk-cover-text">
                        <div class="wk-cover-title wk-cover-' . $elem_number . '">' . get_the_title() . '</div><br/>
                        <div class="wk-cover-author wk-cover-' . $elem_number . '">' . get_the_author() . '</div>
                    </div>

                    <div class="wk-cover-caption wk-cover-' . $elem_number . '">' . $wk_image_caption . '</div>
                </div>

                <div class="wk-cover-meta">
                    <div class="wk-cover-date">' . get_the_date("d/m/A") . '</div>';


    if ( get_post_meta( get_the_ID(), 'webkolm_reading_time', true ) ) {

        $output .=  '<div class="wk-cover-clock">
                        <svg id="clock" x="0px" y="0px"
                             viewBox="0.9 0.9 30.2 30.2" enable-background="new 0.9 0.9 30.2 30.2" xml:space="preserve">
                        <g id="icomoon-ignore">
                            <line fill="none" stroke="#449FDB" x1="0" y1="0" x2="0" y2="0"/>
                        </g>
                        <path d="M16,1.3C7.9,1.3,1.3,7.9,1.3,16c0,8.1,6.6,14.7,14.7,14.7c8.1,0,14.7-6.6,14.7-14.7C30.7,7.9,24.1,1.3,16,1.3z M16,27.5
                            C9.6,27.5,4.5,22.4,4.5,16C4.5,9.6,9.6,4.5,16,4.5c6.4,0,11.5,5.2,11.5,11.5C27.5,22.4,22.4,27.5,16,27.5z M17.1,7.7h-2.2v8.8
                            l5.4,5.4l1.6-1.6l-4.8-4.8V7.7z"/>
                        </svg>
                    </div>
                    <div class="wk-cover-reading-time">' . get_post_meta( get_the_ID(), 'webkolm_reading_time', true ) . ' min</div>
                </div>';
    } else {
        $output .= '</div>';
    }

    return $output;
}

?>