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











/*******    CUSTOM POST TYPES      ********/

function wk_create_post_type() {
  register_post_type('project',
    array(
      'labels' => array(
        'name' => __( 'Projects', "webkolm" ),
        'singular_name' => __( 'Project', "webkolm" )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array( 'title', 'editor', 'thumbnail'),
    )
  );

  register_post_type( 'client',
    array(
      'labels' => array(
        'name' => 'Clients',
        'singular_name' => 'client'
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'thumbnail')
    )
  );
}

add_action( 'init', 'wk_create_post_type' );

/*******    CUSTOM FIELDS       ********/



/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'webkolm_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'webkolm_post_meta_boxes_setup' );



// Create one or more meta boxes to be displayed on the post editor screen.
function webkolm_add_post_meta_boxes() {

  add_meta_box(
    'webkolm_project_year',      // Unique ID
    esc_html__( 'Year', 'webkolm' ),    // Title
    'webkolm_project_year_meta_box',   // Callback function
    'project',         // Admin page (or post type)
    'side',         // Context
    'default'      // Priority
  );

  add_meta_box(
    'webkolm_designer',      // Unique ID
    esc_html__( 'Designed by', 'webkolm' ),    // Title
    'webkolm_designer_meta_box',   // Callback function
    'project',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );

  add_meta_box(
    'webkolm_prizes',      // Unique ID
    esc_html__( 'Prizes', 'webkolm' ),    // Title
    'webkolm_prizes_meta_box',   // Callback function
    'project',       // Admin page (or post type)
    'normal',         // Context
    'default'         // Priority
  );

  add_meta_box(
    'webkolm_gallery',      // Unique ID
    esc_html__( 'Gallery', 'webkolm' ),    // Title
    'webkolm_gallery_meta_box',   // Callback function
    'project',       // Admin page (or post type)
    'normal',         // Context
    'default'         // Priority
  );

  add_meta_box(
    'webkolm_client_link',      // Unique ID
    esc_html__( 'Link', 'webkolm' ),    // Title
    'webkolm_client_link_meta_box',   // Callback function
    'client',       // Admin page (or post type)
    'normal',         // Context
    'default'         // Priority
  );

  add_meta_box(
    'webkolm_checkboxes',      // Unique ID
    esc_html__( 'Post settings', 'webkolm' ),    // Title
    'webkolm_checkboxes_box',   // Callback function
    'project',       // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );

  add_meta_box(
    'webkolm_featured_img',      // Unique ID
    esc_html__( 'Secondary Feautured Image', 'webkolm' ),    // Title
    'webkolm_featured_img_box',   // Callback function
    'project',       // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );

}


// ***************  Custom fields Projects *****************

// Display the post meta box.
function webkolm_project_year_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'webkolm_project_year_nonce' ); ?>

  <p>
    <label for="webkolm_project_year"><?php _e( "Year", 'webkolm' ); ?></label>
    <br />
    <input type="text" name="webkolm_project_year" id="webkolm_project_year" value="<?php echo esc_attr( get_post_meta( $object->ID, 'webkolm_project_year', true ) ); ?>" size="30" />
  </p>
<?php }


// Display the post meta box.
function webkolm_designer_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'webkolm_designer_nonce' ); ?>

  <p>
    <label for="webkolm_designer"><?php _e( "Name of designer", 'webkolm' ); ?></label>
    <br />
    <input class="widefat" type="text" name="webkolm_designer" id="webkolm_designer" value="<?php echo esc_attr( get_post_meta( $object->ID, 'webkolm_designer', true ) ); ?>" />
  </p>
<?php }


// Display the post meta box.
function webkolm_gallery_meta_box( $object, $box ) { 

    wp_nonce_field( basename( __FILE__ ), 'webkolm_gallery_nonce' ); ?>

    <?php $content = get_post_meta($object->ID, 'webkolm_gallery_test', true); 
            $editor_id = "webkolm_gallery_id";
    ?>

  <p>
    <?php wp_editor( $content, $editor_id); ?>


  </p>
<?php }

// Display the post meta box.
function webkolm_prizes_meta_box( $object, $box ) { 

    wp_nonce_field( basename( __FILE__ ), 'webkolm_prizes_nonce' ); ?>

    <?php $content = get_post_meta($object->ID, 'webkolm_prizes_test', true); 
            $editor_id = "webkolm_prizes_id";
    ?>

  <p>
    <?php wp_editor( $content, $editor_id); ?>


  </p>
<?php }



add_action('save_post', 'wysiwyg_save_meta');
function wysiwyg_save_meta(){

        // GALLERY
        $editor_id = 'webkolm_gallery_id';
        $meta_key = 'webkolm_gallery_test';

        if(isset($_REQUEST[$editor_id]))
                update_post_meta($_REQUEST['post_ID'], $meta_key, $_REQUEST[$editor_id]);

        // PRIZES
        $editor_id = 'webkolm_prizes_id';
        $meta_key = 'webkolm_prizes_test';

        if(isset($_REQUEST[$editor_id]))
                update_post_meta($_REQUEST['post_ID'], $meta_key, $_REQUEST[$editor_id]);


}




// ***************  Custom fields Clients *****************

// Display the post meta box.
function webkolm_client_link_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'webkolm_client_link_nonce' ); ?>

  <p>
    <label for="webkolm_client_link"><?php _e( "Link al sito dello sponsor. (es. 'https://www.google.it')", 'webkolm' ); ?></label>
    <br />
    <input class="widefat" placeholder="https://" type="url" name="webkolm_client_link" id="webkolm_client_link" value="<?php echo esc_attr( get_post_meta( $object->ID, 'webkolm_client_link', true ) ); ?>" /> 
  </p>
<?php }


// Display the post meta box.
function webkolm_checkboxes_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'webkolm_homepage_post_box_nonce' ); ?>
  <?php wp_nonce_field( basename( __FILE__ ), 'webkolm_post_secondario_nonce' ); ?>
  <?php $meta = get_post_meta( $object->ID ) ;

  //$bg_color = ( isset( $meta['webkolm_background_color'][0] ) ) ? $meta['webkolm_background_color'][0] : ''; ?>

  <p>
    
    <input class="widefat" type="checkbox" name="webkolm_homepage_post_box" id="webkolm_homepage_post_box" value="yes" <?php if ( isset ( $meta['webkolm_homepage_post_box'] ) ) checked( $meta['webkolm_homepage_post_box'][0], 'yes' ); ?> />
    <?php _e( "Evidenza in homepage", 'webkolm' ); ?>
    <br/><br/>
    <input class="widefat" type="checkbox" name="webkolm_post_secondario" id="webkolm_post_secondario" value="yes" <?php if ( isset ( $meta['webkolm_post_secondario'] ) ) checked( $meta['webkolm_post_sfigato'][0], 'yes' ); ?> />
    <?php _e( "Post secondario", 'webkolm' ); ?><br/>
  </p>
<?php }


// Display the post meta box.
function webkolm_featured_img_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'webkolm_feature_img_box_nonce' ); 
  
  global $post;

  // Get WordPress' media upload URL
  $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

  // See if there's a media id already saved as post meta
  $your_img_id = get_post_meta( $post->ID, 'webkolm_featured_img', true );

  echo "test";

  // Get the image src
  $your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );

  // For convenience, see if the array is valid
  $you_have_img = is_array( $your_img_src );
  ?>

  <!-- Your image container, which can be manipulated with js -->
  <div class="custom-img-container">
      <?php if ( $you_have_img ) : ?>
          <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:100%;" />
      <?php endif; ?>
  </div>

  <!-- Your add & remove image links -->
  <p class="hide-if-no-js">
      <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
         href="<?php echo $upload_link ?>">
          <?php _e('Set secondary image') ?>
      </a>
      <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
        href="#">
          <?php _e('Remove this image') ?>
      </a>
  </p>

  <!-- A hidden input to set and post the chosen image id -->
  <input class="webkolm_featured_img" id="webkolm_featured_img" name="webkolm_featured_img" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>" />

  <script>
        jQuery(function($){

          // Set all variables to be used in scope
          var frame,
              metaBox = $('#webkolm_featured_img.postbox'), // Your meta box id here
              addImgLink = metaBox.find('.upload-custom-img'),
              delImgLink = metaBox.find( '.delete-custom-img'),
              imgContainer = metaBox.find( '.custom-img-container'),
              imgIdInput = metaBox.find( '.webkolm_featured_img' );
          
          // ADD IMAGE LINK
          addImgLink.on( 'click', function( event ){
            
            event.preventDefault();
            
            // If the media frame already exists, reopen it.
            if ( frame ) {
              frame.open();
              return;
            }
            
            // Create a new media frame
            frame = wp.media({
              title: 'Secondary featured image',
              button: {
                text: 'Use this media'
              },
              multiple: false  // Set to true to allow multiple files to be selected
            });

            
            // When an image is selected in the media frame...
            frame.on( 'select', function() {
              
              // Get media attachment details from the frame state
              var attachment = frame.state().get('selection').first().toJSON();

              // Send the attachment URL to our custom image input field.
              imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );

              // Send the attachment id to our hidden input
              imgIdInput.val( attachment.id );

              // Hide the add image link
              addImgLink.addClass( 'hidden' );

              // Unhide the remove image link
              delImgLink.removeClass( 'hidden' );
            });

            // Finally, open the modal on click
            frame.open();
          });
          
          
          // DELETE IMAGE LINK
          delImgLink.on( 'click', function( event ){

            event.preventDefault();

            // Clear out the preview image
            imgContainer.html( '' );

            // Un-hide the add image link
            addImgLink.removeClass( 'hidden' );

            // Hide the delete image link
            delImgLink.addClass( 'hidden' );

            // Delete the image id from the hidden input
            imgIdInput.val( '' );

          });

        });
  </script>

<?php }






// Meta box setup function.
function webkolm_post_meta_boxes_setup() {

  // Add meta boxes on the 'add_meta_boxes' hook.
  add_action( 'add_meta_boxes', 'webkolm_add_post_meta_boxes' );
  add_action( 'save_post', 'webkolm_save_metas', 10, 2 );
 }


function webkolm_save_metas($post_id, $post) {


    $metas = array('webkolm_project_year','webkolm_prizes', 'webkolm_designer', 'webkolm_client_link', 'webkolm_homepage_post_box', 'webkolm_post_secondario', 'webkolm_featured_img' );

    // Get the post type object. 
    $post_type = get_post_type_object( $post->post_type );

    // Check the current custom post type
   // if (( 'post' == $_POST['post_type'])){
        // Check if the current user has permission to edit the post. 
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;
   // } else {
  //      return $post_id;
   // }

    foreach($metas as $meta) {

        $meta_nonce = $meta . '_nonce';
    
        // Verify the nonce before proceeding.
        if ( !isset( $_POST[$meta_nonce] ) || !wp_verify_nonce( $_POST[$meta_nonce], basename( __FILE__ ) ) )
        continue;

        // Get the posted data and sanitize it for use as an HTML class.
        $new_meta_value = ( isset( $_POST[$meta] ) ? $_POST[$meta]  : '' );

        // Get the meta key. 
        $meta_key = $meta;

        // Get the meta value of the custom field key.
        $meta_value = get_post_meta( $post_id, $meta_key, true );

        // If a new meta value was added and there was no previous value, add it.
        if ( $new_meta_value && '' == $meta_value )
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );

        // If the new meta value does not match the old value, update it. 
        elseif ( $new_meta_value && $new_meta_value != $meta_value )
            update_post_meta( $post_id, $meta_key, $new_meta_value );

        // If there is no new meta value but an old value exists, delete it. 
        elseif ( '' == $new_meta_value && $meta_value )
            delete_post_meta( $post_id, $meta_key, $meta_value );
                    
    }
}






// ****************   CORRELAZIONI POSTS

function projects_to_projects() {
    p2p_register_connection_type( array(
        'name' => 'projects_to_projects',
        'from' => 'project',
        'to' => 'project',
        'reciprocal' => true,
    ) );
}
add_action( 'p2p_init', 'projects_to_projects' );

function projects_to_client() {
    p2p_register_connection_type( array(
        'name' => 'projects_to_client',
        'from' => 'client',
        'to' => 'project',
        'reciprocal' => true,
    ) );
}
add_action( 'p2p_init', 'projects_to_client' );

include('vc_addon.php');








//  *******************    CUSTOM FIELD BACKGROUND SIZE GALLERY

/**
 * Add background-size fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
 
function be_attachment_field_credit( $form_fields, $post ) {


    $ischeck = get_post_meta($post->ID, 'image-bg-size', true);
    if(($ischeck == 'off') || ($ischeck == '')) {
        $checked = '';
    } elseif($ischeck == 'on') {
        $checked = 'checked';
    }

    $form_fields['image-bg-size'] = array(
        'label' => 'Immagine non tagliata:',
        'input' => 'html',
        'html' => "<input type='checkbox' {$checked} name='attachments[{$post->ID}][image-bg-size]' id='attachments[{$post->ID}][image-bg-size]' />",
        'value' => get_post_meta( $post->ID, 'image-bg-size', true ),
        'helps' => 'Se selezionato, l`immagine verrà visualizzata per intero',
    );
    
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );

/**
 * Save values of Photographer Name and URL in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */
function be_attachment_field_credit_save( $post, $attachment ) {
    //if( isset( $attachment['image-bg-size'] ) )
        update_post_meta( $post['ID'], 'image-bg-size', $attachment['image-bg-size'] );
    
    return $post;
}
add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2);



?>