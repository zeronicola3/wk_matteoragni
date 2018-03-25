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

		$('.timeline-title-box').on('click', function(){
			
			$(".timeline-item.active").removeClass('active');

			var slug = $(this).attr('data-title');

			$(".timeline-item." + slug).addClass('active');
		});

	} else {

		var lastScrollTop = 0;
		var screenheight = $(window).height();
	//	var item_right = $(document).outerWidth() - ($('.timeline-item').offset().left + $('.timeline-item').outerWidth());
		
		
/*
		$(window).scroll(function(e){	
			var st = window.pageYOffset || document.documentElement.scrollTop;

			var container_top = $(".timeline-block").offset().top;
			var container_bottom = container_top + $(".timeline-block").outerHeight();

			var abs_top = item_top - container_top;
			var sb = st + screenheight;

			var item_top = $('.timeline-item').offset().top;
			//var curBottom = curTop + $(element).height();
		    var screenTop = document.documentElement.scrollTop;
		    

			if (st > lastScrollTop ){

				var item_bottom = item_top + $('.timeline-item').outerHeight();

				if(item_bottom >= container_bottom) {
					$('.timeline-item').removeClass('fixed').css({bottom: "0px", top: "unset", right: "0px" });
				} else if((st >= item_top - 200) && (sb <= container_bottom)){
					$('.timeline-item').addClass('fixed').css({top: "200px", right: + item_right + "px", bottom: "unset" });
				}

			} else {

				if(st < container_top - 200) {
					$('.timeline-item').removeClass('fixed').css({top: "0px", right: "0px", bottom: "unset" });
				} else if((st <= item_top - 200)){
					$('.timeline-item').addClass('fixed').css({top: "200px", right: + item_right + "px", bottom: "unset"  });
				}
			}

			


			if(isOnScreen(".timeline-block")) {
				if(item_top <= (scroll_top + 200)) {

					$('.timeline-item').addClass('fixed').css({ top: "200px", right:  "px" });
				}
				
			} else {

				if($('.timeline-item').hasClass('fixed')){
					

					$('.timeline-item').removeClass('fixed').css({ top: (abs_top + "px") });

				} 
			}

			lastScrollTop = st;
		}).scroll();


*/
		

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

			
/*
			var lasttop = $(lastItem + ' a .timeline-item-title').offset();
			if(lasttop.top == screenCenter){
				var item = $(lastItem + ' .timeline-item-title').parent('a.timeline-title-box').attr('data-title');
				$('.timeline-item.active').removeClass('active');
				$('.timeline-item.' + item).addClass('active'); 
			} */

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
		    animationSpeed: 100,
		    slideshowSpeed : "2500",
		    pauseOnHover: true,
		    multipleKeyboard: true,
		    keyboard: true,
		    controlNav: false, 

		});
	}

		/* SLIDER SITO */

	if($(".project-gallery").length > 0){
		$('.project-gallery').flexslider({
		    animation: "fade",
		    animationLoop: true,
		    slideshow: true,
		    animationSpeed: 100,
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



	$(document).on('click','.next-project-button a', function(event){
		event.preventDefault();

		//.attr('id', 'contenuti').removeClass('next-project').addClass('current-project');
		//$('#contenuti').animate({ opacity: '0' }).slideToggle();

		$('#contenuti').animate({ opacity: '0' }).slideToggle();
		
		var timeout = setTimeout(function(){
			$('.next-project').addClass('active', change_project());
		}, 700);

	});

	function change_project(){
		var project_id = $('.next-project').attr('data-id');

		$('#contenuti').detach();
			
		$('.next-project').removeClass('next-project').removeClass('active').addClass('current-project').attr('id', 'contenuti');
		$(".current-project .project-gallery").flexslider('play', load_next_project(project_id));

	}


    // FUNZIONE PER LANCIO DELLA RICERCA DINAMICA
	function load_next_project(project_id) {
        // RICHIESTA AJAX PER SEARCH
	    $.ajax({
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
			    }
		    }
	    });
    }
	

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



