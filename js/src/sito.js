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
		window.addEventListener("scroll", function(){ // or window.addEventListener("scroll"....
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

		}, false);



		$('.timeline-title-box').on('click', function(){
			
			$(".timeline-item.active").removeClass('active');

			var slug = $(this).attr('data-title');

			$(".timeline-item." + slug).addClass('active');
		});

	} else {

		window.addEventListener("scroll", function(){
			var item_top = $('.timeline-item').offset().top;
			var container_top = $(".timeline-block").offset().top;
			var abs_top = item_top - container_top;
			var scroll_top = document.documentElement.scrollTop;


			if(isOnScreen(".timeline-block")) {
				if(item_top <= (scroll_top + 200)) {
					console.log((scroll_top - container_top + 200) + "px");
					$('.timeline-item').css({ top: ((scroll_top - container_top + 200) + "px") });
				}
				
			} else {

				if($('.timeline-item').hasClass('fixed')){
					

					$('.timeline-item').removeClass('fixed').css({ top: (abs_top + "px") });

				} 
			}

		});

	}

	/* SLIDER SITO */

	if($(".project-cover-gallery").length > 0){
		$('.project-cover-gallery').flexslider({
		    animation: "fade",
		    animationLoop: true,
		    slideshow: true,
		    slideshowSpeed : "4000",
		     pauseOnHover: true,
		    multipleKeyboard: true,
		    keyboard: true,
		    controlNav: true, 

		});
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
	    	return true
	    }
	    return false;
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



