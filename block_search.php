<!--    SEARCH    -->
<div class="search">
    <button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form">
        <svg version="1.1" id="Capa_1" class="icon icon--cross" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="-119 242.9 357 357" enable-background="new -119 242.9 357 357" xml:space="preserve">
        <g>
            <g id="close">
                <polygon points="238,278.6 202.3,242.9 59.5,385.7 -83.3,242.9 -119,278.6 23.8,421.4 -119,564.2 -83.3,599.9 59.5,457.1 
                    202.3,599.9 238,564.2 95.2,421.4        "/>
            </g>
        </g>
        </svg>
    </button>
   <form role="search" method="get" class="search__form" action="<?php echo home_url( '/' ); ?>" >
        <input class="search__input" name="s" type="search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
        <div class="search__btn">
             <svg version="1.1" id="Livello_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 49.9 595.3 594.3" enable-background="new 0 49.9 595.3 594.3" xml:space="preserve">
            <path d="M591.3,580.1L405.1,393.9c24.2-36.1,37.2-78.5,37.2-122.8c0-59.1-23-114.6-64.8-156.4c-41.8-41.8-97.3-64.8-156.4-64.8
                s-114.6,23-156.4,64.8C23,156.5,0,212,0,271.1s23,114.6,64.8,156.4s97.3,64.8,156.4,64.8c44.9,0,87.7-13.3,124-38l186.1,186
                c6.3,6.3,17.8,4.9,25.8-3l31.3-31.3C596.3,598,597.6,586.4,591.3,580.1z M221.1,432.3c-88.9,0-161.2-72.3-161.2-161.2
                s72.3-161.2,161.2-161.2s161.2,72.3,161.2,161.2S310,432.3,221.1,432.3z"/>
            </svg>
            <input class="" type="submit" >
        </div>
        <input type="hidden" name="post_type" value="product" />
        <!--span class="search__info"><?php _e('Hit enter to search or ESC to close', 'paolac');?></span-->
    </form>
   

     <div class="wk-archive">
        <div class="wk-list-client">
            <h3 class="wk-list-title">CLIENTI</h3>
            <ul class="wk-list-container" id="archivio-clienti">
                <?php 
                
                $args = array(
                    'post_type'  => 'client',
                    'posts_per_page' => -1,
                    'ignore_custom_sort' => true,
                    'orderby' => 'post_title',
                    'order' => 'ASC',
                );

                $query = new WP_Query($args);

                if ( $query->have_posts() ) {
                    $current_letter = "";
                    // Start the Loop.
                    while ( $query->have_posts() ) : $query->the_post(); 

                        $item_title = get_the_title();
                        if($item_title[0] != $current_letter){
                            $current_letter = $item_title[0]; 
                            echo '<li class="wk-list-item letter-item">'. $current_letter .'</li>';
                        }
                        ?>
                        
                        <li class="wk-list-item"><a href="<?php the_permalink(); ?>"><?php echo $item_title; ?></a></li>

                    <?php endwhile;
                } ?>
                
            </ul>
        </div>


        <div class="wk-list-client">
            <h3 class="wk-list-title">TIPOLOGIA</h3>
            <ul class="wk-list-container" id="archivio-clienti">
                <?php 
                $terms = get_terms( array(
                    'taxonomy' => 'project_type',
                ) );

                foreach ($terms as $term) { ?>
                    <li class="wk-list-item">
                        <a href="<?php echo get_term_link( $term ); ?>"><?php echo $term->name; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>


        <div class="wk-list-client">
            <h3 class="wk-list-title">ANNO</h3>
            <ul class="wk-list-container" id="archivio-clienti">
            <?php
                $projects_per_year = parse_json_file();

                foreach ($projects_per_year as $year => $projects) { ?>
                    
                    <li class="wk-list-item"><a href="<?php echo get_home_url(); ?>/year/?project_by_year=<?php echo $year; ?>"><?php echo $year; ?></a></li>

                <?php } ?>
            </ul>
        </div>
        
    </div>



</div><!-- /search -->