/* DIMENSIONI SCHERMO */
	 
	var $width = $(window).width();
	var $height = $(window).height();
	var $docheight = document.documentElement.scrollHeight;
	var $scrollspace = $docheight-$height;

function is_touch_device() {
 return (('ontouchstart' in window)
      || (navigator.maxTouchPoints > 0)
      || (navigator.msMaxTouchPoints > 0));
 //navigator.msMaxTouchPoints for microsoft IE backwards compatibility
}
	  
$(document).ready(function() {

	 $('.lazy').Lazy();
    	
	// OTTIMIZZAZIONE PER RETINA */
	
	if (window.devicePixelRatio == 2) {

          var images = $("img.hires");

          // loop through the images and make them hi-res
          for(var i = 0; i < images.length; i++) {

            // create new image name
            var imageType = images[i].src.substr(-4);
            var imageName = images[i].src.substr(0, images[i].src.length - 4);
            imageName += "@x2" + imageType;


            //rename image
            images[i].src = imageName;
          }
     }
	 
	
	if(!is_touch_device()){
		
		$(".touch").addClass("notouch");
		$("body").addClass("notouch");
		
	}
	
	if($width<768) {
		
		/* PER SMARTPHONE */
		
		/* TASTO PER APERTURA MENU */
		$("a.mobile-menu").on('click', function (){
		  $('body').toggleClass('nav-open');
		  $("body").toggleClass("bloccoscroll");
	      $("html").toggleClass("bloccoscroll");
		});
		
		$("nav.onlymobile .menu").on('click', 'li a', function(){
			var $this=$(this);
			if($this.hasClass("attivo"))
			{
				$this.toggleClass("attivo");
				$this.next('ul.sub-menu').slideToggle();
			}
			else{
				$this.next('ul.sub-menu').slideToggle();
				$this.toggleClass("attivo");	
			}
			
			if($(this).siblings("ul.sub-menu").size()!=0){
			  	return false;
			}
		});
		
		$("nav.onlymobile .menu li.current-menu-ancestor > a").addClass("attivo");

		var lastScrollTop = 0;
		var header=$("header");

		// element should be replaced with the actual target element on which you have applied scroll, use window in case of no target element.
		window.addEventListener("scroll", function(){	 // or window.addEventListener("scroll"....
			var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"

			if(st > 70){
				if (st > lastScrollTop ){
				console.log('down');

				// downscroll code
				if(!header.hasClass("disattivo")){
					header.addClass("disattivo");
				}
			} else {
				// upscroll code
				console.log('up');
				if(header.hasClass("disattivo")){
					header.removeClass("disattivo");
				}
			}

			} else {
				if(header.hasClass("disattivo")){
					header.removeClass("disattivo");
				}
			}
			lastScrollTop = st;

		},false);

		$('.timeline-year-box h4').on('click', function(){
			$(this).parent().toggleClass('active');
		});

		$('.timeline-title-box').on('click', function(e){

			e.preventDefault();
			var slug = $(this).attr('data-title');

			if(!$(".timeline-item." + slug).hasClass('active')){
				$(".timeline-item.active").removeClass('active');
				$(".timeline-item." + slug).addClass('active');
			} else {
				$(".timeline-item.active").removeClass('active');
			}
			
		});

	} else {

		var lastScrollTop = 0;
		var screenheight = $(window).height();
		

		$(window).scroll(function(){

			var st = window.pageYOffset || document.documentElement.scrollTop;
			var screenCenter = st + ((screenheight*2)/3);
			var lastItem = $(".timeline-year-box.active").last();
			var nextItem = $(lastItem).next();
			var curTop = $(nextItem).offset();

			if(curTop != undefined){
				if(curTop.top <= screenCenter){
					$(nextItem).addClass('active');
				}
			}

		});
/*
		$('.timeline-year-box.active').(function(){
			$(this).parent().addClass('active');
		});
*/
		$('.timeline-item-title').hover(function(){
			var item = $(this).parent('a.timeline-title-box').attr('data-title');
			$('.timeline-item.active').removeClass('active');

			$('.timeline-item.' + item).addClass('active'); 

			//$('.timeline-item.active').css("top", -($('.timeline-item.active').offset().top * 13.5 - 40));
		});

/*
		$(".timeline-block").css("overflow", "hidden").wrapInner("<div id='mover' />");
		var $el, 
			speed = 20,    
		    items = $('.timeline-title-box');
		    				
		items.each(function(i) {
			$(this).attr("data-pos", i);
		}).hover(function() {
			$el = $(this);		
			$("#mover").css("top", -($el.data("pos") * speed - 40));			
		});

*/





	}

	/* SLIDER SITO */

	if($(".project-cover-gallery").length > 0){
		$('.project-cover-gallery').flexslider({
		    animation: "fade",
		    animationLoop: true,
		    slideshow: true,
		    animationSpeed: 250,
		    start: function(){
		    	var cursor_color = $('.flex-active-slide').attr('data-cursor');
		    	$('.project-cover-gallery').attr('data-cursor', cursor_color);
		    },
		    after: function(){
		    	var cursor_color = $('.flex-active-slide').attr('data-cursor');
		    	$('.project-cover-gallery').attr('data-cursor', cursor_color);
		    },
		    slideshowSpeed : "2500",
		    pauseOnHover: true,
		    multipleKeyboard: true,
		    keyboard: true,
		    controlNav: true, 

		});
	}

		/* SLIDER SITO */

	if($(".project-gallery").length > 0){
		$('.project-gallery').flexslider({
		    animation: "fade",
		    animationLoop: true,
		    slideshow: false,
		    animationSpeed: 250,
		    slideshowSpeed : "2500",
		    pauseOnHover: true,
		    multipleKeyboard: true,
		    keyboard: true,
		    controlNav: false, 

		});
	}


	if($(".next-project .project-gallery").length > 0){
		$(".next-project .project-gallery").flexslider('stop');
	}


	$('#contenuti').waypoint(function(direction) {
		$("header").toggleClass('active', direction === 'down');
	}, {
	    offset: '-1' // 
	});






	function isOnScreen(element){
	    var curPos = $(element).offset();
	    var curTop = curPos.top;
	    var curBottom = curTop + $(element).height();
	    var screenTop = document.documentElement.scrollTop;
	    var screenheight = $(window).height();
	    var screenBottom = screenTop + screenheight;

	   // console.log(curTop + " " + curBottom + " " + screenBottom);
	    
	    if((screenBottom > curTop) && (screenBottom < curBottom)){
	    	return true;
	    } else if( (screenTop < curBottom) && (screenTop > curTop) ) {
	    	return true;
	    }
	    return false;
	}


	// NEXT PROJECT --- NEXT PROJECT --- NEXT PROJECT --- NEXT PROJECT --- NEXT PROJECT --- NEXT PROJECT --- //

	// NEXT PROJECT --- NEXT PROJECT --- NEXT PROJECT --- NEXT PROJECT --- NEXT PROJECT --- NEXT PROJECT --- //

	$(document).on('click','.next-project-button a, .next-project', function(event){
		event.preventDefault();

		//.attr('id', 'contenuti').removeClass('next-project').addClass('current-project');
		//$('#contenuti').animate({ opacity: '0' }).slideToggle();


		$('#contenuti').animate(
			{ opacity: '0' },
			{complete: function(){
				$('.next-project').removeClass('limiti-altezza');
				$('html,body').animate({scrollTop: $(this).offset().top-90});
				$('#contenuti').stop().slideToggle(function(){
					$('.next-project').addClass('active', change_project());
				});
		    }}
		);
	});

	function change_project(){
		var project_id = $('.next-project').attr('data-id');
		var pageurl = $('.next-project').attr('data-link');

		$('#contenuti').detach();
		$('.next-project').removeClass('next-project').addClass('current-project').attr('id', 'contenuti');
		$(".current-project .project-gallery").flexslider('play', load_next_project(project_id, pageurl));

	}


    // FUNZIONE PER LANCIO DELLA RICERCA DINAMICA
	function load_next_project(project_id, pageurl) {
        // RICHIESTA AJAX PER SEARCH
	    var request = $.ajax({
		    type: 'post',
		    url: ajaxurl, 
		    data: {
			    action: 'webkolm_ajax_next_project',
			    next_project: project_id
		    },
		    success: function( result ) {
			    // SE LA RICERCA NON VA A BUON FINE
			    if( result === 'error' ) {
				   
			    
			    // SE LA RICERCA VA A BUON FINE
			    } else {			    	
			    	$('#contenuti').after(result);
			    	//to change the browser URL to the given link location
			    	if(pageurl!=window.location){
			    		window.history.pushState({path:pageurl},'',pageurl);
			    	}

			    	$('.next-project').fadeIn();

			    	/* SLIDER SITO */
			    }
		    }
	    });

	    request.done(function() { 
	    	if($(".project-gallery").length > 0){
	    		$('.project-gallery').flexslider({
	    		    animation: "fade",
	    		    animationLoop: true,
	    		    slideshow: false,
	    		    animationSpeed: 100,
	    		    slideshowSpeed : "2500",
	    		    pauseOnHover: true,
	    		    multipleKeyboard: true,
	    		    keyboard: true,
	    		    controlNav: false, 

	    		});
	    	}
	    });
    }


    $(document).on('click', ".current-project .project-gallery .slides li", function() {
    	$('.current-project .project-gallery').flexslider('next');
    } );



    $('.projects-all').on('click', function(event){
    	event.preventDefault();	
    	var current_link = $(this).children('a').attr('href');
    	if($(".timeline-block")[0]){
    		if($('.timeline-title-box.disattivato')[0]) {
    			$('.disattivato').removeClass('disattivato');
    		}
    		$(this).siblings('.current-menu-item').removeClass('current-menu-item');
    		$(this).addClass('current-menu-item');
    		window.history.pushState("Projects", "projects - Matteo Ragni", current_link);
    	} else {
    		window.location.href = current_link;
    	}
    });


     $('.projects-objects').on('click', function(event){
    	event.preventDefault();	
    	var current_link = $(this).children('a').attr('href');
    	if($(".timeline-block")[0]){
			$('.objects.disattivato').removeClass('disattivato');
			$('.spaces').addClass('disattivato');
			$(this).siblings('.current-menu-item').removeClass('current-menu-item');
    		$(this).addClass('current-menu-item');
    		window.history.pushState("Objects", "objects - Matteo Ragni", current_link);
    	} else {
    		window.location.href = current_link;
    	}
    });


    $('.projects-spaces').on('click', function(event){
    	event.preventDefault();	
    	var current_link = $(this).children('a').attr('href');
    	if($(".timeline-block")[0]){
			$('.spaces.disattivato').removeClass('disattivato');
			$('.objects').addClass('disattivato');
			$(this).siblings('.current-menu-item').removeClass('current-menu-item');
    		$(this).addClass('current-menu-item');
    		window.history.pushState("Spaces", "spaces - Matteo Ragni", current_link);
    	} else {
    		window.location.href = current_link;
    	}
    });


    $('.grid').isotope({
	  itemSelector: '.grid-item',
	  percentPosition: true,
	  masonry: {
		  columnWidth: 50,
		  gutter: 5
		}
	});
		

	/* CAROUSEL POST

	$('.owl-carousel').owlCarousel({
	   loop:true,
	       margin:30,
	       responsiveClass:true,
	       autoplay:true,
	       dots:false,
	       nav:true,
	       navText:['&#60;','&#62;'],
	       responsive:{
	           0:{
	               items:1
	           },
	           600:{
	               items:2
	           },
	           1000:{
	               items:3
	           }
	           1280:{
	               items:4
	           }
	       }
	}); */
	

});	/* FINE DOCUMENT READY */



