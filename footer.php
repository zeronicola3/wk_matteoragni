</div>  
        <!-- BLUEIMPGALLERY -->
        <!--div id="singolo-overlay">
            <div id="loader-singolo"></div>
        </div>

        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev"></a>
        	<a class="next"></a>
        	<a class="close">x</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div-->

        <footer id="footer" >
            <div class="wrapper no-limitated">
                <!-- FOOTER CONTENT -->
                <div class="footer-box">
                    
                    <span class="footer-p-iva">P.IVA 13476100154</span>
                    <span class="footer-credit"><a href="<?php echo get_the_permalink(2142); ?>">Credits</a> </span>
                    <span class="cookies"><a href="<?php echo get_the_permalink(2144); ?>">Privacy & Cookie Policy</a></span>
                    <span class="timeline"><a href="<?php echo get_the_permalink(2260); ?>">Timeline</a></span>
                    <span class="instagram"><a href="https://www.instagram.com/matteoragni_designstudio">instagram</a></span>
                    <span class="facebook"><a href="https://www.facebook.com/Matteo-Ragni-Design-Studio-188257474554200/">facebook</a></span>

                </div>
            </div>
        </footer> 

        <!-- CSS -->
        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo bloginfo( 'stylesheet_directory' );?>/css/stile.css?v=3" />

        <!-- JS -->
        <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script-->
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.6/jquery.lazy.min.js"></script>
        <!-- <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> -->
        <script type="text/javascript" src="<?php echo bloginfo( 'stylesheet_directory' );?>/js/theme.js?v=2"></script>



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
                        $projects_per_year = get_array_sorted_by_years();

                        foreach ($projects_per_year as $key => $projecs) { ?>
                            
                            <li class="wk-list-item"><a href="<?php echo get_home_url(); ?>/year/?project_by_year=<?php echo $key; ?>"><?php echo $key; ?></a></li>

                        <?php } ?>
                    </ul>
                </div>
                
            </div>



        </div><!-- /search -->

        <script type="text/javascript">
            /**
             * GESTIONE SEARCH
             */

            ;(function(window) {

                'use strict';

                var mainContainer = document.getElementById('contenuti'),
                    openCtrl = document.getElementById('btn-search'),
                    closeCtrl = document.getElementById('btn-search-close'),
                    searchContainer = document.querySelector('.search'),
                    inputSearch = searchContainer.querySelector('.search__input'),
                    bordoDx = document.getElementById('bordodx'),
                    bordoSx = document.getElementById('bordosx');

                function init() {
                    initEvents();   
                }

                function initEvents() {
                    openCtrl.addEventListener('click', openSearch);
                    closeCtrl.addEventListener('click', closeSearch);
                    document.addEventListener('keyup', function(ev) {
                        // escape key.
                        if( ev.keyCode == 27 ) {
                            closeSearch();
                        }
                    });
                }

                function openSearch() {
                    console.log('click');
                    mainContainer.classList.add('main-wrap--move');
                    searchContainer.classList.add('search--open');
                    setTimeout(function() {
                        inputSearch.focus();
                    }, 600);
                }

                function closeSearch() {
                    mainContainer.classList.remove('main-wrap--move');
                    searchContainer.classList.remove('search--open');
                    inputSearch.blur();
                    inputSearch.value = '';
                }

                init();

            })(window);
        </script>


        <?php get_template_part( 'cookie' ); ?>

        <?php wp_footer();?> 

        <?php 
            global $javascript_append;

            echo $javascript_append; ?>

    </body>
</html>