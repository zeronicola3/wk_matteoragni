
        <!-- BLUEIMPGALLERY -->
        <div id="singolo-overlay">
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
        </div>

        <footer id="footer">
            <div class="wrapper">
                <!-- FOOTER CONTENT -->
            </div>
        </footer> 

        <!-- CSS -->
        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo bloginfo( 'stylesheet_directory' );?>/css/stile.css?v=3" />

        <!-- JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
        <!-- <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> -->
        <script type="text/javascript" src="<?php echo bloginfo( 'stylesheet_directory' );?>/js/theme.js"></script>

        <?php get_template_part( 'cookie' ); ?>

        <?php wp_footer();?> 

    </body>
</html>