<?php 
// ID PAGINA DELLA POLICY
$permalink = "";
//$permalink=get_permalink( icl_object_id(54, 'page', false) );
?>

 <!-- Templates -->
    <script id="ce-banner-html" type="text/plain">
      <p class="cookie-text"><?php _e('MatteoRagni.com utilizza cookies tecnici per rendere il sito più sicuro e usabile. Leggi tutti i dettagli ','webkolm'); ?>
      <a href="<?= $permalink ?>" class="ce-law"><?php _e('qui','cookie-law'); ?></a></p>
      <p class="cookie-botton">
         <a href="#" class="ce-accept"><?php _e('ACCETTO','cookie-law');?></a>
      </p>
    </script>

    <script id="ce-iframePlaceholder-html" type="text/plain">
      <p><?php _e('Questo contenuto non è disponibile se non si accettano i cookies.','cookie-law');?>
          <a href="#" class="ce-accept"><?php _e('Abilita i cookies','cookie-law');?></a>
          <a href="<?= $permalink ?>" class="ce-law"><?php _e('Leggi la Policy','cookie-law'); ?></a>
      </p>
</script>

<script>
    window.COOKIES_ENABLER=window.COOKIES_ENABLER||function(){"use strict";function e(){var e,n;for(e=1;e<arguments.length;e++)for(n in arguments[e])arguments[e].hasOwnProperty(n)&&(arguments[0][n]=arguments[e][n]);return arguments[0]}function n(e,n,t){var s;return function(){var a=this,i=arguments,o=function(){s=null,t||e.apply(a,i)},r=t&&!s;clearTimeout(s),s=setTimeout(o,n),r&&e.apply(a,i)}}function t(e,n){do if(s(e,n))return e;while(e=e.parentNode);return null}function s(e,n){return(" "+e.className+" ").indexOf(" "+n+" ")>-1}var a,i,o,r={scriptClass:"ce-script",iframeClass:"ce-iframe",acceptClass:"ce-accept",disableClass:"ce-disable",dismissClass:"ce-dismiss",bannerClass:"ce-banner",bannerHTML:null!==document.getElementById("ce-banner-html")?document.getElementById("ce-banner-html").innerHTML:'<p>This website uses cookies. <a href="#" class="ce-accept">Enable Cookies</a></p>',eventScroll:!1,scrollOffset:200,clickOutside:!1,cookieName:"ce-cookie",cookieDuration:"365",iframesPlaceholder:!0,iframesPlaceholderHTML:null!==document.getElementById("ce-iframePlaceholder-html")?document.getElementById("ce-iframePlaceholder-html").innerHTML:'<p>To view this content you need to<a href="#" class="ce-accept">Enable Cookies</a></p>',iframesPlaceholderClass:"ce-iframe-placeholder",onEnable:"",onDismiss:"",onDisable:""},l=function(){Math.abs(window.pageYOffset-o)>a.scrollOffset&&u()},c=function(){i={accept:document.getElementsByClassName(a.acceptClass),disable:document.getElementsByClassName(a.disableClass),banner:document.getElementsByClassName(a.bannerClass),dismiss:document.getElementsByClassName(a.dismissClass)};var e,n=i.accept,s=n.length,r=i.disable,c=r.length,d=i.dismiss,p=d.length;for(a.eventScroll&&window.addEventListener("load",function(){o=window.pageYOffset,window.addEventListener("scroll",l)}),a.clickOutside&&document.addEventListener("click",function(e){var n=e.target;return t(n,a.iframesPlaceholderClass)||t(n,a.disableClass)||t(n,a.bannerClass)||t(n,a.dismissClass)||t(n,a.disableClass)?!1:void u()}),e=0;s>e;e++)n[e].addEventListener("click",function(e){e.preventDefault(),u(e)});for(e=0;c>e;e++)r[e].addEventListener("click",function(e){e.preventDefault(),m(e)});for(e=0;p>e;e++)d[e].addEventListener("click",function(e){e.preventDefault(),f.dismiss()})},d=function(n){a=e({},r,n),"Y"==p.get()?("function"==typeof a.onEnable&&a.onEnable(),b.get(),g.get()):"N"==p.get()?("function"==typeof a.onDisable&&a.onDisable(),g.hide(),c()):(f.create(),g.hide(),c())},u=n(function(e){"undefined"!=typeof e&&"click"===e.type&&e.preventDefault(),"Y"!=p.get()&&(p.set(),b.get(),g.get(),g.removePlaceholders(),f.dismiss(),window.removeEventListener("scroll",l),"function"==typeof a.onEnable&&a.onEnable())},250,!1),m=function(e){"undefined"!=typeof e&&"click"===e.type&&e.preventDefault(),"N"!=p.get()&&(p.set("N"),f.dismiss(),window.removeEventListener("scroll",l),"function"==typeof a.onDisable&&a.onDisable())},f=function(){function e(){var e='<div class="'+a.bannerClass+'">'+a.bannerHTML+"</div>";document.body.insertAdjacentHTML("beforeend",e)}function n(){i.banner[0].style.display="none","function"==typeof a.onDismiss&&a.onDismiss()}return{create:e,dismiss:n}}(),p=function(){function e(e){var n,t,s="undefined"!=typeof e?e:"Y";a.cookieDuration?(n=new Date,n.setTime(n.getTime()+24*a.cookieDuration*60*60*1e3),t="; expires="+n.toGMTString()):t="",document.cookie=a.cookieName+"="+s+t+"; path=/"}function n(){var e,n,t,s=document.cookie.split(";"),i=s.length;for(e=0;i>e;e++)if(n=s[e].substr(0,s[e].indexOf("=")),t=s[e].substr(s[e].indexOf("=")+1),n=n.replace(/^\s+|\s+$/g,""),n==a.cookieName)return unescape(t)}return{set:e,get:n}}(),g=function(){function e(e){var n=document.createElement("div");n.classList.add(a.iframesPlaceholderClass),n.innerHTML=a.iframesPlaceholderHTML,e.parentNode.insertBefore(n,e)}function n(){var e,n=document.getElementsByClassName(a.iframesPlaceholderClass),t=n.length;for(e=t-1;e>=0;e--)n[e].remove()}function t(){var n,t,s=document.getElementsByClassName(a.iframeClass),i=s.length;for(t=0;i>t;t++)n=s[t],n.style.display="none",a.iframesPlaceholder&&e(n)}function s(){var e,n,t,s=document.getElementsByClassName(a.iframeClass),i=s.length;for(t=0;i>t;t++)n=s[t],e=n.attributes["data-ce-src"].value,n.src=e,n.style.display="block"}return{hide:t,get:s,removePlaceholders:n}}(),b=function(){function e(){var e,n,t,s,i=document.getElementsByClassName(a.scriptClass),o=i.length,r=document.createDocumentFragment();for(e=0;o>e;e++){for(t=document.createElement("script"),t.type="text/javascript",n=0;n<i[e].attributes.length;n++)s=i[e].attributes[n],s.specified&&"type"!=s.name&&"class"!=s.name&&t.setAttribute(s.name,s.value);t.innerHTML=i[e].innerHTML,r.appendChild(t)}document.body.appendChild(r)}return{get:e}}();return{init:d,enableCookies:u,dismissBanner:f.dismiss}}();
</script>

<script>
        COOKIES_ENABLER.init({
            scriptClass: 'ce-script',
            iframeClass: 'ce-iframe',
            acceptClass: 'ce-accept',
            dismissClass: 'ce-dismiss',
            bannerClass: 'ce-banner nascondibile',
            eventScroll: false,
            scrollOffset: 0,
            clickOutside: false,
            cookieName: 'ce-cookie',
            cookieDuration: '365',
            iframesPlaceholder: true,
            iframesPlaceholderClass: 'ce-iframe-placeholder',
            onEnable: function(){
                console.log('enable callback');
                $('.ce-banner.nascondibile').removeClass('nascondibile');
            },
            onDismiss: function(){
                console.log('dismiss callback');
            }
        });


       $(window).scroll(function() {

    if ($(this).scrollTop()>0)
     {
        $('.ce-banner.nascondibile').fadeOut();
     }
      else 
     {
        $('.ce-banner.nascondibile').fadeIn();
     }
     });



    </script>


