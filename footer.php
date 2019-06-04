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
            <button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form"><svg class="icon icon--cross"><use xlink:href="#icon-cross"></use></svg></button>
           <form role="search" method="get" class="search__form" action="<?php echo home_url( '/' ); ?>" >
                <input class="search__input" name="s" type="search" placeholder="<?php _e('search', 'paolac');?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                <input type="hidden" name="post_type" value="product" />
                <span class="search__info"><?php _e('Hit enter to search or ESC to close', 'paolac');?></span>
            </form>
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