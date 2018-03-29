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

                </div>
            </div>
        </footer> 

        <!-- CSS -->
        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo bloginfo( 'stylesheet_directory' );?>/css/stile.css?v=3" />

        <!-- JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.6/jquery.lazy.min.js"></script>
        <!-- <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> -->
        <script type="text/javascript" src="<?php echo bloginfo( 'stylesheet_directory' );?>/js/theme.js"></script>



        <?php get_template_part( 'cookie' ); ?>

        <?php wp_footer();?> 

    </body>
</html>