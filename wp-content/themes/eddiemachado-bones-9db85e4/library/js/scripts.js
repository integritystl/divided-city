/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
function loadGravatars() {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
  jQuery('.comment img[data-gravatar]').each(function(){
    jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
  });
	}
} // end function


/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {

  /*
   * Let's fire off the gravatar function
   * You can remove this if you don't need it
  */
  loadGravatars();


}); /* end of as page load scripts */


jQuery(function($){

  function constrain(n,min,max) {
    if (n>max) return max;
    if (n<min) return min;
    return n;
  }

  function articleScrollListener(e){
    // calculate the normalized scroll percentage for the item being scrolled
    var normalizedTop = constrain( $(this).scrollTop() / ( $("body").height() - $(window).height() ), 0, 1);
    // apply the normalized percentage to all articles
    $("article").each(function(){
      $(this).scrollTop(( $(this).children(".inner").height() - $(this).height() ) * normalizedTop);
    });
  }

  function onResize(){
    //measure the tallest article, and set the body height to match, so scrolling amount stays reasonable
    var tallest = 0;
    $("article").each(function(){
      var h = $(this).children(".inner").height();
      if (h>tallest) tallest = h;
    });
    $("body").height(tallest);
  }

  if ($("body").hasClass("blog")) {
    $(window).on("resize", onResize);
    $(window).on("scroll", articleScrollListener);
    onResize();
  }

  var interactionEvent = Modernizr.touch ? "touchend" : "click" ;
  $("#hamburger").on(interactionEvent, function(e){
    $("#flyout-menu").addClass("open");
  });

  $("#flyout-menu .close-button").on(interactionEvent, function(e){
    $("#flyout-menu").removeClass("open");
  });



  // DIALOGUES


  var underlineCount = 0;

  function getTextNodesIn(el) {
      return $(el).find(":not(iframe)").addBack().contents().filter(function() {
          return this.nodeType == 3;
      });
  }

  // for each dialogue we find in the dialogues menu...
  $("ul#menu-dialogues li a").each(function(){

    var underlineClass = 'underline-' + (underlineCount + 1);
    underlineCount = (underlineCount+1)%18;
    var dialogue = this;
    var $dialogue = $(dialogue);

    $dialogue.addClass(underlineClass);
    // wrap it in a span and give it a class according to it's content
    var dialogueTitle = $dialogue.text();
    var dialogueLower = $dialogue.text().toLowerCase();
    var dialogueClassName = dialogueLower.replace(/\W+/g, "-");
    dialogue.selector = '.dialogue.' + dialogueClassName;

    $regexTitle = new RegExp(dialogueTitle,"g");
    $regexLower = new RegExp(dialogueLower,"g");

    $("h1, h2, h3, p").each(function(){
      // lower case
      var textNodes = getTextNodesIn(this);
      textNodes.each(function(){
        $(this).replaceWith(this.nodeValue.replace($regexLower,('<span class="dialogue ' + dialogueClassName + ' ' + underlineClass + '">' + dialogueLower + '</span>')));
      });
      // title case
      textNodes = getTextNodesIn(this);
      textNodes.each(function(){
        $(this).replaceWith(this.nodeValue.replace($regexTitle,('<span class="dialogue ' + dialogueClassName + ' ' + underlineClass + '">' + dialogueTitle + '</span>')));
      });
    });

    // wireup hover states
    $dialogue.hover(function(){
      $dialogue.addClass('hover');
      $(dialogue.selector).addClass('hover');
    },
    function(){
      $dialogue.removeClass('hover');
      $(dialogue.selector).removeClass('hover');
    });

    // wireup click states
    $dialogue.on(interactionEvent,function(e){
      e.preventDefault();
      if( !$dialogue.hasClass('active') ) {
        $dialogue.addClass('active');
        $(dialogue.selector).addClass('active');
      } else {
        $dialogue.removeClass('active');
        $(dialogue.selector).removeClass('active');
      }
    });
  });

  $("h1.h2 a, .hentry a, #menu-main-nav li a").each(function(){
    var underlineClass = 'underline-' + (underlineCount + 1);
    underlineCount = (underlineCount+1)%18;
    $(this).addClass(underlineClass);
  });

  $('#scrollright').click(function() {
    var scrollPos = parseInt($(".blog article").css("width")) + 30;
    $('.synopses').animate({
        scrollLeft: '+=' + scrollPos + 'px'
    }, 800);
  });

  $('#scrollleft').click(function() {
    var scrollPos = parseInt($(".blog article").css("width")) + 30;
    $('.synopses').animate({
        scrollLeft: '-=' + scrollPos + 'px'
    }, 800);
  });


  // BACKGROUND IMAGES

  function mouseOverArticle(e){
    var imageid = $(this).data('imageid');
    if (typeof imageid !="undefined") {
      $("#"+imageid).css({opacity:1});
    }
    $(this).find("h1.h2 a").addClass('active');
  }

  function mouseOutArticle(e) {
    var imageid = $(this).data('imageid');
    if (typeof imageid !="undefined") {
      $("#"+imageid).css({opacity:0});
    }
    $(this).find("h1.h2 a").removeClass('active');
  }

  var $postImages = $(".post-image");
  if ($postImages.length>0){
    $("#fixed-layout").prepend($postImages);
    $postImages.css({opacity:0, display:"block"});
    $("article").hover(mouseOverArticle, mouseOutArticle);
  }


});