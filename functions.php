<?php


	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'menuwide'   => __( 'Menu principale', 'wk_menuwide' ),
		'menumobile' => __( 'Mobile Menu', 'wk_menumobile' ),
	) );

/* featured image */
add_theme_support( 'post-thumbnails' );


add_filter('show_admin_bar', '__return_false');


/* DATI DELL'IMMAGINE PASSANDO l'ID */

function wp_get_attachment( $attachment_id ) {

    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}



//CUSTOM LANGUAGE SWITCHER



function custom_language_selector(){
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if(!empty($languages)){
            foreach($languages as $l){
                if(!$l['active'])
                    {
                        echo '<a class="selettore_lingua nomobile" href="'.$l['url'].'" >';
                        echo $l['language_code'];
                        echo '</a>';
                    }
            }
        }
    }
    

function custom_language_selector_mobile(){
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if(!empty($languages)){
            echo '<ul id="lingue_mobile" class="onlymobile" style="margin-top:0 !important;">';
            foreach($languages as $l){
                echo '<li class="nochild">';
                if(!$l['active'])
                    {
                        echo '<a href="'.$l['url'].'">';
                        echo $l['native_name'];
                        echo '</a>';
                    }
                
                echo '</li>';
            }
            echo '</ul>';
        }
    }


/* GESTIONE SVG */

function svg_mime_types( $mimes ) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;}
add_filter( 'upload_mimes', 'svg_mime_types' );


function requireToVar($file){
    ob_start();
    include(ABSPATH . $file);
    return ob_get_clean();

}

function svg_line($url) {
     if ( strpos( $url[1], '.svg' ) !== false ) {
         $url = str_replace( site_url(), '', $url[1]);
         $test=requireToVar($url);
     }
     else {
        $test='<img src="'.$url[1].'">';
     }
     return $test;

}

add_filter('the_content', 'svg_inliner');
function svg_inliner($content) {

       global $post;
       
       $pattern ='#<img.+?src="([^"]*)".*?/?>#i';
       $content = preg_replace_callback($pattern, "svg_line", $content);
       
       return $content;
       
}



/**
 * Extends WP_Query with a posts_join filter allowing you to query by taxonomy instead of tax_query using terms
 * Usage: <code> $query = new Query_By_Taxonomy( array( 'posts_per_page' => $foo, 'orderby' => $bar ) ); </code>
 *
 * @class Query_By_Taxonomy
 */
class Query_By_Taxonomy extends WP_Query {

    var $posts_by_taxonomy;
    var $taxonomy;

    function __construct( $args = array() ) {
        add_filter( 'posts_join', array( $this, 'posts_join' ), 10, 2 );
        $this->posts_by_taxonomy = true;
        $this->taxonomy = $args['taxonomy'];

        unset( $args['taxonomy'] );

        parent::query($args);
    }

    function posts_join( $join, $query ) {
        if ( isset( $query->posts_by_taxonomy ) && false !== $query->posts_by_taxonomy ) {
            global $wpdb;
            $join .= $wpdb->prepare(
                 "INNER JOIN {$wpdb->term_relationships} ON {$wpdb->term_relationships}.object_id={$wpdb->posts}.ID
                  INNER JOIN {$wpdb->term_taxonomy} ON {$wpdb->term_taxonomy}.term_taxonomy_id={$wpdb->term_relationships}.term_taxonomy_id
                  AND {$wpdb->term_taxonomy}.taxonomy=%s",
                $this->taxonomy );
        }
        return $join;
    }
}




/* GESTIONE GALLERY CUSTOM */
    

add_shortcode('gallery', 'my_gallery_shortcode');    

function my_gallery_shortcode($attr) {
    $post = get_post();

    static $instance = 0;
    $instance++;
    $random_number=rand(0,100000);

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) )
        $itemtag = 'dl';
    if ( ! isset( $valid_tags[ $captiontag ] ) )
        $captiontag = 'dd';
    if ( ! isset( $valid_tags[ $icontag ] ) )
        $icontag = 'dt';

    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';
        if ( apply_filters( 'use_default_gallery_style', true ) )
            $gallery_style = "";
        $size_class = sanitize_html_class( $size );
        
        $gallery_div = "<div id=\"links\" class=\"galleria\">";
        
        $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
        
    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
        $immagine=wp_get_attachment_image_src( $id, 'large' );
        $immagine_small=wp_get_attachment_image_src( $id, 'medium' );
        $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
        $image_title = $attachment->post_title;
        $caption = $attachment->post_excerpt;
        $description = $image->post_content;
        if($descriptio!="")
        {
            $caption="<span class=\"didascalia\">".$caption."</span>";
        }else { $caption=""; }  
        $output .= "\n\t<a href=\"".$immagine[0]."\" data-gallery=\"#".$random_number."\" title=\"".$caption."\" style=\"background-image: url('".$immagine_small[0]."');\">".$caption."</a>";
    }

    $output .= "
            </div><div id=\"blueimp-gallery\" class=\"blueimp-gallery blueimp-gallery-controls\">
                        <div class=\"slides\"></div>
                        <h3 class=\"title\"></h3>
                        <a class=\"prev\">‹</a>
                        <a class=\"next\">›</a>
                        <a class=\"close\">×</a>
                        <a class=\"play-pause\"></a>
                        <ol class=\"indicator\"></ol>
                    </div>";

    return $output;
}
/* FINE GESTIONE GALLERY CUSTOM */



/* Nascondi aggiornamenti per gli utenti Non-Admin */
if ( !current_user_can( 'edit_users' ) ) {
    add_filter('pre_site_transient_update_core', create_function('$a', "return null;")); // rimuove notifiche sugli aggiornamenti del core di WordPress
    add_filter('pre_site_transient_update_plugins', create_function( '$a', "return null;")); // rimuove notifiche sugli aggiornamenti dei plugins
}



// PAGINAZIONE

function wpa85791_category_posts_per_page( $query ) {
    if ( $query->is_category() && $query->is_main_query() )
        $query->set( 'posts_per_page', 10 );
}
add_action( 'pre_get_posts', 'wpa85791_category_posts_per_page' );


function twentythirteen_paging_nav() {
    global $wp_query;

    // Don't print empty markup if there's only one page.
    if ( $wp_query->max_num_pages < 2 )
        return;
    ?>
    <nav class="woocommerce-pagination"><?php
    $big = 999999999; // need an unlikely integer
    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '/page/%#%',
        'prev_text' => '«',
        'next_text' => '»',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'type' => 'list'
    ) );
    
?></nav>
    <?php
}


include('optimize.php');

?>