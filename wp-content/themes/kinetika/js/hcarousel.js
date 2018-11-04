jQuery(document).ready(function($){
    $('.circular-preloader').remove();
});

(function($) {
$(window).load(function() {
    "use strict";

    var last_slide = $('.horizontal-carousel').find('li').size();
    //console.log(last_slide);
    var container = '.horizontal-carousel';
    var slide_class_prefix = '.slide-';
    var caption_class_prefix = '.caption-';
    var image_sep_value = 20;
    var margin_size = 40;

    function hcarousel_build() {
        var w_height = $(window).height() - 160;
        var w_width = $(window).width();

        // Reset current slide
        $('.current').removeClass('current');

        $(slide_class_prefix + '1').addClass('current');
        $(caption_class_prefix + '1').addClass('current');

        var adjust_height = w_height - 150;

        // adjust wrapper to height and width of window
        $('.horizontal-carousel-outer').height(w_height).width(w_width);
        $('.horizontal-carousel-inner,.horizontal-carousel .hc-image-wrap,.horizontal-carousel').height(adjust_height);
        $('.horizontal-carousel').css('left', 0); // reset to first

        $(container).find('li.hc-slides').each(function() {
            $(this).data('position',$(this).offset().left);
            $('.horizontal-carousel').width( $('.horizontal-carousel').width() + $(this).width() );
            
            var image_width = $(this).find('img').width();
            var cell_size = image_width + margin_size;
            //console.log(cell_size);
            $(this).width( cell_size );
        });

        var delay = -1;
        clearTimeout(delay);
        delay = setTimeout(center_slide, 300);
    }

    function center_slide(current_slide) {
        if (current_slide==undefined) {
            current_slide = 1;
        }
        var w_width = $(window).width();
        var offset_end = ($(container).width() - w_width) * -1;
        var image_width = $(container + ' ' + slide_class_prefix + current_slide).width();
        var offset_value = $(container + ' ' + slide_class_prefix + current_slide).data('position') * -1;
        
        var center_space  = ( w_width/2 - image_width/2 ) + image_sep_value - margin_size;
        fade_caption(current_slide);
        $(container).stop().animate({"left": offset_value + center_space }, 600, "easeInOutCubic", function() {
           set_caption(current_slide); 
        });
    }

    function set_slide(current_slide) {
        $(container + ' .current').removeClass('current');
        $(container + ' ' + slide_class_prefix + current_slide).addClass('current');
        center_slide(current_slide);
    }

    function set_caption(current_slide) {
        $('.carousel-captions' + ' .current').removeClass('current');
        
            $('.carousel-captions' + ' ' + caption_class_prefix + current_slide).fadeIn('fast').addClass('current');          
    }
    function fade_caption(current_slide) {
        $('.carousel-captions' + ' .current').fadeOut('fast');        
    }

    function next_slide() {

        var current_slide = $(container + ' li.current').data('id');
        
        //console.log(current_slide);
        if (current_slide == last_slide) {
            current_slide = 1
        } else {
            current_slide++;
        }
        //console.log(current_slide);
        set_slide(current_slide);
    }

    function prev_slide() {

        var current_slide = $(container + ' li.current').data('id');

        if (current_slide == 1) {
            current_slide = last_slide;
        } else {
            current_slide--;
        }

        set_slide(current_slide);
    }

    hcarousel_build();

    if ($.fn.swipe) {
        jQuery(".fullscreen-horizontal-carousel").swipe({
          excludedElements: "button, input, select, textarea, .noSwipe",
          swipeLeft: function() {
            jQuery(".next-hcarousel").trigger("click");
          },
          swipeRight: function() {
            jQuery(".prev-hcarousel").trigger("click");
          }
        });
    }

    $('.prev-hcarousel').click(function() {
        prev_slide();
    });
    $('.next-hcarousel').click(function() {
        next_slide();
    });

    $(document).keydown(function(e){
        switch((e.keyCode ? e.keyCode : e.which)){
            //case 13: // Enter
            //case 27: // Esc
            //case 32: // Space
            case 37:   // Left Arrow
                prev_slide();
            break;
            //case 38: // Up Arrow
            case 39:   // Right Arrow
                next_slide();
            break;
            //case 40: // Down Arrow
        }
    });

    
    $(window).resize(function() {
        var w_width = $(window).width();
        $('.carousel-captions ul li').removeClass('current');
        $('.carousel-captions ul li').hide();
        hcarousel_build();

        var delay = -1;
        clearTimeout(delay);
        delay = setTimeout(hcarousel_build, 100);

    });

})
})(jQuery);