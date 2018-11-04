jQuery(document).ready(function($){
	"use strict";

	// cache container
	var $filterContainer = $('#gridblock-container,#gridblock-container-blog');
	var AjaxPortfolio;
	var portfolio_height;
	var portfolio_width;
	var half_width;
	var image_height;
	var slideshow_active;
	var AutoStart;
	var ajax_image_height;
	var ajax_window_height;
	var $data;
	var heart;
	var post_id;
	var parentPortfolio_id;

	var deviceAgent = navigator.userAgent.toLowerCase();
	var isIOS = deviceAgent.match(/(iphone|ipod|ipad)/);
	var ua = navigator.userAgent.toLowerCase();
	var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
	var curr_menu_item;
	var percent;

	function mobilecheck() {
		var check = false;
		(function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	}

	if ( isIOS || isAndroid ) {
		// Mobile specifics
	} else {
		$.fn.centerDiv = function (options) {
		    var centerthis = this;

	        $(centerthis).each(function(){
	            $(this).css({
	                position:'absolute',
	                left: ($(window).width() - $(this).outerWidth())/2,
	                top: ($(window).height() - $(this).outerHeight())/2
	            });
	 
	        });

		    $(window).bind('load resize',function(){
		        $(centerthis).each(function(){
		            $(this).css({
		                position:'absolute',
		                left: ($(window).width() - $(this).outerWidth())/2,
		                top: ($(window).height() - $(this).outerHeight())/2
		            });
		        });
		    });
		}
		$('.mtheme-vh-center,.fullscreen-protected #password-protected').centerDiv();
	}

	//Detect Orientaiton change
	window.onload = orientationchange;
	window.onorientationchange = orientationchange;
	jQuery(window).bind("resize", orientationchange);
	function orientationchange() {
		if ( isIOS || isAndroid ) {
		} else {
			$('.mtheme-vh-center,.fullscreen-protected #password-protected').centerDiv();
		}
	}

	$('#gridblock-filters a').first().addClass('is-active');

	function AjaxProofing() {

		var proofing_count_total = $(".proofing-item-wrap > .mtheme-proofing-item").length;
		var proofing_count_selected = $(".proofing-item-wrap > .proofing-item-selected").length;
		console.log(proofing_count_total,proofing_count_selected);

		$( ".proofing-count-total" ).html( proofing_count_total );
		$( ".proofing-count-selected" ).html( proofing_count_selected );

		jQuery(".mtheme-proofing-choice.mtheme-proofing-active").click(function(){

			var proofing_item = jQuery(this);
			var image_id = proofing_item.data("image_id");
			var proofing_status = $('#mtheme-proofing-item-'+image_id+'').data('proofing_status');

			jQuery.ajax({
				type: "post",
				url: ajax_var.url,
				data: "action=mtheme_proofing_checker&nonce="+ajax_var.nonce+"&mtheme_proofing_status="+proofing_status+"&image_id="+image_id,
	            beforeSend : function(){
	            	console.log(ajax_var.url,ajax_var.nonce,image_id);
					$('#mtheme-proofing-item-'+image_id+'').addClass("proofing-item-inprogress");
	            },
				success: function(data){

					// Split and Get the values in data varaible that has been given as COUNT:POSTID
					console.log(data);
					var substr = data.split(':');
					var checked = substr[0];
					var image_id = substr[1];

					if(checked == "checked") {
						$('#mtheme-proofing-item-'+image_id+'').removeClass("proofing-item-inprogress").removeClass("proofing-item-unchecked").addClass("proofing-item-selected");
						$('#mtheme-proofing-item-'+image_id+'').find('.proofing-icon-status').removeClass("feather-icon-check").addClass("feather-icon-cross");
						$('#mtheme-proofing-item-'+image_id+'').data('proofing_status','selected');	
						$('#mtheme-proofing-item-' + image_id + '').removeClass("filter-unchecked").addClass('filter-selected');
					} else {
						$('#mtheme-proofing-item-'+image_id+'').removeClass("proofing-item-inprogress").addClass("proofing-item-unchecked").removeClass("proofing-item-selected");
						$('#mtheme-proofing-item-'+image_id+'').find('.proofing-icon-status').addClass("feather-icon-check").removeClass("feather-icon-cross");
						$('#mtheme-proofing-item-'+image_id+'').data('proofing_status','unchecked');
						$('#mtheme-proofing-item-' + image_id + '').removeClass("filter-selected").addClass('filter-unchecked');						
					}
					var proofing_count_total = $(".proofing-item-wrap > .mtheme-proofing-item").length;
					var proofing_count_selected = $(".proofing-item-wrap > .proofing-item-selected").length;
					console.log(proofing_count_total,proofing_count_selected);
					$( ".proofing-count-total" ).html( proofing_count_total );
					$( ".proofing-count-selected" ).html( proofing_count_selected );
				},
	            error     : function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	            }
			});

			return false;
		});
		
	}

	function AjaxLike() {

		jQuery(".mtheme-post-like a.vote-ready").click(function(){

			heart = jQuery(this);

			post_id = heart.data("post_id");
			var parentPortfolio_id = jQuery(this).closest("li").data("id");

			jQuery.ajax({
				type: "post",
				url: ajax_var.url,
				data: "action=mtheme-post-like&nonce="+ajax_var.nonce+"&mtheme_post_like=&post_id="+post_id,
	            beforeSend : function(){
					if( !heart.hasClass('voted')) {
						heart.children("span.mtheme-like").addClass("voteprogress");
					}
	            },
				success: function(data){

					// Split and Get the values in data varaible that has been given as COUNT:POSTID

					var substr = data.split(':');
					var count = substr[0];
					var post_id = substr[1];

					if(count != "already")
					{
						
						jQuery('.mtheme-post-like a[data-post_id="'+post_id+'"]').removeClass("vote-ready").addClass("vote-disabled");
						jQuery('.mtheme-post-like a[data-post_id="'+post_id+'"]').find(".mtheme-like").removeClass("like-notvoted").addClass("like-alreadyvoted");
						jQuery('.post-link-count-wrap[data-count_id="'+post_id+'"]').find("span.post-like-count").text(count);
						jQuery('.mtheme-post-like a[data-post_id="'+post_id+'"] span.mtheme-like').removeClass("voteprogress");
						
					}
				},
	            error     : function(jqXHR, textStatus, errorThrown) {
	                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	            }
			});

			return false;
		});
		
	}

	function Magnific_Lightbox() {

			$(".mtheme-block-em_works_carousel a[data-lightbox^='magnific-image'],a[data-lightbox^='magnific-image']:visible,a[data-lightbox^='magnific-image-gallery'],span[data-lightbox^='magnific-carousel-gallery'],img[data-lightbox^='magnific-carousel-gallery']").magnificPopup({
			type: 'image',
 	        tLoading: '',
	        closeBtnInside: false,
	        fixedContentPos:true,
	        mainClass: 'mfp-zoom-in',
	        removalDelay: 300,
	        image: {
	            verticalFit: true,
	            titleSrc: function(item) {

	                        var caption = item.el.attr('title');
	                        var image_link = item.el.attr('href');
	                        if ( typeof image_link === 'undefined' ) {
	                        	image_link = item.el.attr('src');
	                        }
	                        var pinItURL = "http://pinterest.com/pin/create/bookmarklet/";
	                        pinItURL += '?url=' + window.location.href;
	                        pinItURL += '&media=' + image_link;
	                        pinItURL += '&description=' + caption;
	                        var pinshare = '<a class="lightbox-share" href="'+pinItURL+'" target="_blank"><i class="fa fa-pinterest"></i></a>';

	                        var facebookURL = "http://www.facebook.com/sharer.php";
	                        facebookURL += '?u=' + image_link;
	                        facebookURL += '&t=' + caption;
	                        var facebookshare = '<a class="lightbox-share" href="'+facebookURL+'" target="_blank"><i class="fa fa-facebook"></i></a>';

	                        var twitterURL = "http://twitter.com/intent/tweet?text=";
	                        twitterURL += caption;
	                        twitterURL += '+' + image_link;
	                        var twittershare = '<a class="lightbox-share" href="'+twitterURL+'" target="_blank"><i class="fa fa-twitter"></i></a>';


	                        return caption + '<div class="maginific-lightbox-sharing">'+facebookshare+pinshare+twittershare+'</div>';
	            }
	        },

		    gallery: {
		      enabled: true,
		      preloader: true,
		      preload:	[1,1],
		      arrowMarkup: '<span title="%title%" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir% mfp-prevent-close"></i></span>',
		      tCounter: '<span class="mfp-counter-inner">%curr% / %total%</span>'
		    },

		    callbacks: {
				open: function() {
					this.wrap.on('click.pinhandler', '.lightbox-share', function(e) {

					  window.open(e.currentTarget.href, "intent", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 50) + ",top=" + 100);

					  return false;
					});

					if ($.fn.swipe) {
						$(".mfp-wrap").swipe({
						    swipeLeft: function() {
						    	$(".mfp-arrow-left").magnificPopup("next");
						    },
						    swipeRight: function() {
						    	$(".mfp-arrow-right").magnificPopup("prev");
						    }
						});
					}

					//overwrite default prev + next function. Add timeout for css3 crossfade animation
					$.magnificPopup.instance.next = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
					}
					$.magnificPopup.instance.prev = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
					}
				},
				beforeClose: function() {
					this.wrap.off('click.pinhandler');
				},
				imageLoadComplete: function() 
				{	
					var self = this;
					setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
				}
		    }

		});

		$(".portfolio-end-block a[data-lightbox^='magnific-image']").magnificPopup({
			type: 'image',
 	        tLoading: '',
	        closeBtnInside: false,
	        fixedContentPos:true,
	        mainClass: 'mfp-zoom-in',
	        removalDelay: 300,
	        image: {
	            verticalFit: true,
	            titleSrc: function(item) {

	                        var caption = item.el.attr('title');

	                        var pinItURL = "http://pinterest.com/pin/create/bookmarklet/";
	                        pinItURL += '?url=' + window.location.href;
	                        pinItURL += '&media=' + item.el.attr('href');
	                        pinItURL += '&description=' + caption;
	                        var pinshare = '<a class="lightbox-share" href="'+pinItURL+'" target="_blank"><i class="fa fa-pinterest"></i></a>';

	                        var facebookURL = "http://www.facebook.com/sharer.php";
	                        facebookURL += '?u=' + item.el.attr('href');
	                        facebookURL += '&t=' + caption;
	                        var facebookshare = '<a class="lightbox-share" href="'+facebookURL+'" target="_blank"><i class="fa fa-facebook"></i></a>';

	                        var twitterURL = "http://twitter.com/intent/tweet?text=";
	                        twitterURL += caption;
	                        twitterURL += '+' + item.el.attr('href');
	                        var twittershare = '<a class="lightbox-share" href="'+twitterURL+'" target="_blank"><i class="fa fa-twitter"></i></a>';


	                        return caption + '<div class="maginific-lightbox-sharing">'+facebookshare+pinshare+twittershare+'</div>';
	            }
	        },

		    gallery: {
		      enabled: true,
		      preloader: true,
		      preload:	[1,1],
		      arrowMarkup: '<span title="%title%" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir% mfp-prevent-close"></i></span>',
		      tCounter: '<span class="mfp-counter-inner">%curr% / %total%</span>'
		    },

		    callbacks: {
				open: function() {
					this.wrap.on('click.pinhandler', '.lightbox-share', function(e) {

					  window.open(e.currentTarget.href, "intent", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 50) + ",top=" + 100);

					  return false;
					});

					if ($.fn.swipe) {
						$(".mfp-wrap").swipe({
						    swipeLeft: function() {
						    	$(".mfp-arrow-left").magnificPopup("next");
						    },
						    swipeRight: function() {
						    	$(".mfp-arrow-right").magnificPopup("prev");
						    }
						});
					}

					//overwrite default prev + next function. Add timeout for css3 crossfade animation
					$.magnificPopup.instance.next = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
					}
					$.magnificPopup.instance.prev = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
					}
				},
				beforeClose: function() {
					this.wrap.off('click.pinhandler');
				},
				imageLoadComplete: function() 
				{	
					var self = this;
					setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
				}
		    }

		});


		$('.proofing-item-wrap').each(function() {
			$(this).find(".column-gridblock-lightbox").magnificPopup({
	        type: 'image',
	        closeBtnInside: false,
	        fixedContentPos:true,
	        mainClass: 'mfp-zoom-in',
	        removalDelay: 300,
	        image: {
	            verticalFit: true,
	        },

		    gallery: {
		      enabled: true,
		      preload:	[1,1],
		      arrowMarkup: '<span title="%title%" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir% mfp-prevent-close"></i></span>',
		      tCounter: '<span class="mfp-counter-inner">%curr% / %total%</span>'
		    },

		    callbacks: {
				open: function() {

					if ($.fn.swipe) {
						$(".mfp-wrap").swipe({
						    swipeLeft: function() {
						    	$(".mfp-arrow-left").magnificPopup("next");
						    },
						    swipeRight: function() {
						    	$(".mfp-arrow-right").magnificPopup("prev");
						    }
						});
					}
					//overwrite default prev + next function. Add timeout for css3 crossfade animation
					$.magnificPopup.instance.next = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
					}
					$.magnificPopup.instance.prev = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
					}
				},
				imageLoadComplete: function() 
				{	
					var self = this;
					setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
				}
		    }
			});
		});
		$('.mtheme-block-em_lightboxcarousel,.gridblock-metro,.vertical_images').each(function() {
			$(this).find(".column-gridblock-icon,.vertical-images-link").magnificPopup({
	        type: 'image',
	        closeBtnInside: false,
	        fixedContentPos:true,
	        mainClass: 'mfp-zoom-in',
	        removalDelay: 300,
	        image: {
	            verticalFit: true,
	            titleSrc: function(item) {

	                        var caption = item.el.attr('title');

	                        var pinItURL = "http://pinterest.com/pin/create/bookmarklet/";
	                        pinItURL += '?url=' + window.location.href;
	                        pinItURL += '&media=' + item.el.attr('href');
	                        pinItURL += '&description=' + caption;
	                        var pinshare = '<a class="lightbox-share" href="'+pinItURL+'" target="_blank"><i class="fa fa-pinterest"></i></a>';

	                        var facebookURL = "http://www.facebook.com/sharer.php";
	                        facebookURL += '?u=' + item.el.attr('href');
	                        facebookURL += '&t=' + caption;
	                        var facebookshare = '<a class="lightbox-share" href="'+facebookURL+'" target="_blank"><i class="fa fa-facebook"></i></a>';

	                        var twitterURL = "http://twitter.com/intent/tweet?text=";
	                        twitterURL += caption;
	                        twitterURL += '+' + item.el.attr('href');
	                        var twittershare = '<a class="lightbox-share" href="'+twitterURL+'" target="_blank"><i class="fa fa-twitter"></i></a>';


	                        return caption + '<div class="maginific-lightbox-sharing">'+facebookshare+pinshare+twittershare+'</div>';
	            }
	        },

		    gallery: {
		      enabled: true,
		      preload:	[1,1],
		      arrowMarkup: '<span title="%title%" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir% mfp-prevent-close"></i></span>',
		      tCounter: '<span class="mfp-counter-inner">%curr% / %total%</span>'
		    },

		    callbacks: {
				open: function() {
					this.wrap.on('click.pinhandler', '.lightbox-share', function(e) {

					  window.open(e.currentTarget.href, "intent", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 50) + ",top=" + 100);

					  return false;
					});

					if ($.fn.swipe) {
						$(".mfp-wrap").swipe({
						    swipeLeft: function() {
						    	$(".mfp-arrow-left").magnificPopup("next");
						    },
						    swipeRight: function() {
						    	$(".mfp-arrow-right").magnificPopup("prev");
						    }
						});
					}

					//overwrite default prev + next function. Add timeout for css3 crossfade animation
					$.magnificPopup.instance.next = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
					}
					$.magnificPopup.instance.prev = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
					}
				},
				beforeClose: function() {
				this.wrap.off('click.pinhandler');
				},
				imageLoadComplete: function() 
				{	
					var self = this;
					setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
				}
		    }

			});
		});
		$("a[data-lightbox^='magnific-video']").magnificPopup({ 
		    type: 'iframe',
	        closeBtnInside: false,
	        fixedContentPos:true,
	        mainClass: 'mfp-zoom-in mfp-iframe-on',
	        removalDelay: 300,
	        image: {
	            verticalFit: true,
	        },

		    gallery: {
		      enabled: true,
		      preload:	[1,1],
		      arrowMarkup: '<span title="%title%" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir% mfp-prevent-close"></i></span>',
		      tCounter: '<span class="mfp-counter-inner">%curr% / %total%</span>'
		    },

		    callbacks: {
				open: function() {
					//overwrite default prev + next function. Add timeout for css3 crossfade animation
					$.magnificPopup.instance.next = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
					}
					$.magnificPopup.instance.prev = function() {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
					}
				},
				imageLoadComplete: function() 
				{	
					var self = this;
					setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
				}
		    }
		});
	}
	
	function HoverEffect() {
		//Ajax Hover
		jQuery("div.gridblock-element").hover(
		function () {
			var GotImage = $(this).find(".preload-image");
			if (GotImage.is(':visible')) {
				portfolio_height=jQuery(this).height()-10;
				portfolio_width=jQuery(this).width();

				jQuery(this).find("span.ajax-image-hover")
				.css({ "display":"block", "left":"0", "height": ""+portfolio_height+"px", "width": ""+portfolio_width+"px"})
				.stop().animate({"top": "0","opacity" : "1"}, "normal");
			}
		},
		function () {
			jQuery(this).find("span.ajax-image-hover").stop().animate({"top": "10px","opacity" : "0"}, "fast");
		});

		//Thumbnails shortcode hover
		jQuery("div.thumbnails-shortcode ul li").hover(
		function () {

			var GotImage = $(this).find(".displayed-image");
			if (GotImage.is(':visible')) {
				portfolio_height=$(this).find("img.displayed-image").height();
				portfolio_width=$(this).find("img.displayed-image").width();

				jQuery(this).find(".gridblock-image-icon")
				.css({"display":"block", "top": "0", "left":"0" , "height" : portfolio_height + "px"})
				.stop().animate({"opacity" : "1"}, "normal");
			}
		},
		function () {
			jQuery(this).find(".gridblock-image-icon").stop().animate({"opacity" : "0"}, "fast");
		});

	}

	HoverEffect();
	Magnific_Lightbox();
	//AjaxLike();
	AjaxProofing();
	
});

jQuery(window).bind("load", function(e) {
	var AutoStart=false;
	var SlideStarted=false;
	jQuery('.ajax-next').addClass('ajax-nav-disabled').css('cursor','default');
	jQuery('.ajax-prev').addClass('ajax-nav-disabled').css('cursor','default');

});

jQuery(document).ready(function($) {

	// cache container
	var $filterContainer = $('#gridblock-container,#gridblock-container-blog,.thumbnails-grid-container');
	var AjaxPortfolio;
	var portfolio_height;
	var portfolio_width;
	var half_width;
	var image_height;
	var slideshow_active;
	var AutoStart;
	var ajax_image_height;
	var ajax_window_height;
	var $data;
		
	var ajaxLoading=0;
	var SlideStarted=false;

    //variables to confirm window height and width
    var lastWindowHeight = $(window).height();
    var lastWindowWidth = $(window).width();

	//Detect Orientaiton change
	window.onload = orientationchange;
	window.onorientationchange = orientationchange;
	jQuery(window).bind("resize", orientationchange);
	function orientationchange() {
		isotopeInit();
	}

    $(window).resize(function() {

		$('.thumbnails-grid-container').each(function() {
			$(this).find('.gridblock-element').removeClass('animation-action animated flipInX');
		});

        //confirm window was actually resized
        if($(window).height()!=lastWindowHeight || $(window).width()!=lastWindowWidth){

            //set this windows size
            lastWindowHeight = $(window).height();
            lastWindowWidth = $(window).width();

            //call my function
            if ($.fn.isotope) {
            	$filterContainer.isotope( 'layout' );
        	}

           	ajax_image_height=jQuery('.displayed-image').height();
			$('.ajax-image-selector').css({"height" : ajax_image_height + "px"});

        }
    });

	// Toggle - Show and Hide displayed portfolio showcase item
	jQuery("a.ajax-hide").click(
		function () {
			if ( jQuery(".ajax-gridblock-window").is(':animated') || jQuery(".ajax-gridblock-image-wrap").is(':animated') ) return;
			if (SlideStarted==false) {
				jQuery('.gridblock-ajax').eq(0).trigger('click');
			}
			$('.ajax-gridblock-block-wrap').toggleClass('ajax-collapsed');
			jQuery('.ajax-gridblock-window').slideToggle();
			return false;
		}
	);
	
	AjaxPortfolio = function(e) {
		// Initialize
	    var page = 1;
	    var loading = true;
		var loaded = false;
	    var $window = jQuery(window);
	    var $content = jQuery("body #ajax-gridblock-wrap");
	    var $contentData = jQuery("body #ajax-gridblock-content");
		var total = jQuery('#gridblock-container .gridblock-ajax').length;
		var index;
		var nextStatus=true;
		var prevStatus=true;
		
		var isiPhone = navigator.userAgent.toLowerCase().indexOf("iphone");
		var isiPad = navigator.userAgent.toLowerCase().indexOf("ipad");
		var isiPod = navigator.userAgent.toLowerCase().indexOf("ipod");

		var deviceAgent = navigator.userAgent.toLowerCase();
		var isIOS = deviceAgent.match(/(iphone|ipod|ipad)/);
		var ua = navigator.userAgent.toLowerCase();
		var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");

		var altTotal=total-1;


	jQuery(".gridblock-ajax").click(function(){

		//Get postID from rel attribute of link
		var postID = jQuery(this).attr("data-portfolioid");
		if(typeof postID === 'undefined') return;
	
		AutoStart=false;
		SlideStarted=true;

		if ( $(this).parent().hasClass('gridblock-displayed') ) {
			return false;
		}

		ajax_image_height=jQuery('.displayed-image').height();
		$('.ajax-image-selector').css({"height" : ajax_image_height + "px"});

		$('.ajax-gallery-navigation').fadeIn();
		$('span.ajax-loading').show();
		//Get this index
		index=jQuery(".gridblock-ajax").index(this);
		//Store the navigation ID as the current element
		jQuery('.ajax-gallery-navigation').attr('id', index);

		//Grab the current displayed ID
		var DisplayedID = jQuery('.ajax-gallery-navigation').attr("data-portfolioid");
		
		// Compare clicked and Displayed ID. Acts as Gatekeeper


		if (postID!=DisplayedID) {

			$('.ajax-gridblock-block-wrap').addClass('ajax-active');
			// Remove previous displayed set class
			jQuery('div').removeClass("gridblock-displayed");
		
			//Add portfolio post ID to attribute
			jQuery('.ajax-gallery-navigation').attr('data-portfolioid', postID);
		
			//Add the class to currently viewing
			jQuery( '[data-portfolio=portfolio-'+postID+']').addClass('gridblock-displayed');


			var filtered_total = $('#gridblock-container div:visible').length;
			var $got_current = $filterContainer.find(".gridblock-displayed");
			var $next_portfolio = $got_current.nextAll("div:visible").first();
			var $prev_portfolio = $got_current.prevAll("div:visible").first();

			if ($next_portfolio.length) {
				$('.ajax-next').removeClass('ajax-nav-disabled').css('cursor','pointer');
			} else {
				$('.ajax-next').addClass('ajax-nav-disabled').css('cursor','default');
			}
			if ($prev_portfolio.length) {
				$('.ajax-prev').removeClass('ajax-nav-disabled').css('cursor','pointer');
			} else {
				$('.ajax-prev').addClass('ajax-nav-disabled').css('cursor','default');
			}

			var sitewide = $('.top-menu-wrap').width();
			// If iphone then scroll to Ajax nav bar - otherwise top of page
			if(sitewide==470 || sitewide==758) {
				jQuery('html, body').stop().animate({
				    scrollTop: jQuery(".ajax-gridblock-block-wrap").offset().top - 20
				}, 1000);
			} else {
				jQuery('html, body').stop().animate({
				    scrollTop: jQuery(".container").offset().top - 70
				}, 1000);
			}

			 function syncPosition(el) {
			     var current = this.currentItem;
			     $("#owl-ajax-2")
			         .find(".owl-item")
			         .removeClass("synced")
			         .eq(current)
			         .addClass("synced")
			     if ($("#owl-ajax-2").data("owlCarousel") !== undefined) {
			         center(current)
			     }
			 }

			 function center(number) {
			     var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
			     var num = number;
			     var found = false;
			     for (var i in sync2visible) {
			         if (num === sync2visible[i]) {
			             var found = true;
			         }
			     }

			     if (found === false) {
			         if (num > sync2visible[sync2visible.length - 1]) {
			             sync2.trigger("owl.goTo", num - sync2visible.length + 2)
			         } else {
			             if (num - 1 === -1) {
			                 num = 0;
			             }
			             sync2.trigger("owl.goTo", num);
			         }
			     } else if (num === sync2visible[sync2visible.length - 1]) {
			         sync2.trigger("owl.goTo", sync2visible[1])
			     } else if (num === sync2visible[0]) {
			         sync2.trigger("owl.goTo", num - 1)
			     }
			 }
			

				jQuery('#ajax-gridblock-loading').show();

				jQuery.ajax({
	                type: "post",
	                url: ajax_var.url,
	                data: "action=ajaxportfolio&post_id="+postID,
	                beforeSend : function(){
						ajax_window_height = $('#ajax-gridblock-content').height();
						$('.ajax-gridblock-window').css({'height': ajax_window_height + 'px'});

	                    jQuery("#ajax-gridblock-content").fadeOut('slow');
	                },
	                success    : function(data){
						loaded = true;
						jQuery('#ajax-gridblock-loading').hide();
						jQuery("#ajax-gridblock-content").remove();
						$('span.ajax-loading').hide();
	                    $data = $(data);

	                    if($data.length){

	                        $content.append($data);
							$('.ajax-gridblock-window').css({'height': 'auto'});

	                        jQuery('.ajax-gridblock-window').slideDown(500, function(){
								jQuery(".ajax-gridblock-image-wrap").fadeTo(100, 1);
								jQuery(".ajax-gridblock-data, .ajax-gridblock-contents-wrap").fadeIn();
								jQuery("#ajax-gridblock-content").fadeIn('slow');
	                            loading = false;
	                        });
							jQuery('.ajax-gridblock-image-wrap img').bind('load', function() {
								jQuery('.ajax-gridblock-image-wrap img').fadeTo(100, 1);
								//$('.ajax-portfolio-image-wrap').css({'background': 'none'});
							});
								$("a[data-lightbox^='magnific-image-gallery']").magnificPopup({
							        type: 'image',
							        closeBtnInside: false,
							        fixedContentPos:true,
							        mainClass: 'mfp-zoom-in',
							        removalDelay: 300,
							        image: {
							            verticalFit: true,
							            titleSrc: function(item) {

							                        var caption = item.el.attr('title');

							                        var pinItURL = "http://pinterest.com/pin/create/bookmarklet/";
							                        pinItURL += '?url=' + window.location.href;
							                        pinItURL += '&media=' + item.el.attr('href');
							                        pinItURL += '&description=' + caption;
							                        var pinshare = '<a class="lightbox-share" href="'+pinItURL+'" target="_blank"><i class="fa fa-pinterest"></i></a>';

							                        var facebookURL = "http://www.facebook.com/sharer.php";
							                        facebookURL += '?u=' + item.el.attr('href');
							                        facebookURL += '&t=' + caption;
							                        var facebookshare = '<a class="lightbox-share" href="'+facebookURL+'" target="_blank"><i class="fa fa-facebook"></i></a>';

							                        var twitterURL = "http://twitter.com/intent/tweet?text=";
							                        twitterURL += caption;
							                        twitterURL += '+' + item.el.attr('href');
							                        var twittershare = '<a class="lightbox-share" href="'+twitterURL+'" target="_blank"><i class="fa fa-twitter"></i></a>';


							                        return caption + '<div class="maginific-lightbox-sharing">'+facebookshare+pinshare+twittershare+'</div>';
							            }
							        },

								    gallery: {
								      enabled: true,
								      preload:	[1,1],
								      arrowMarkup: '<span title="%title%" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir% mfp-prevent-close"></i></span>',
								      tCounter: '<span class="mfp-counter-inner">%curr% / %total%</span>'
								    },

								    callbacks: {
										open: function() {
											this.wrap.on('click.pinhandler', '.lightbox-share', function(e) {

											  window.open(e.currentTarget.href, "intent", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 50) + ",top=" + 100);

											  return false;
											});

											if ($.fn.swipe) {
												$(".mfp-wrap").swipe({
												    swipeLeft: function() {
												    	$(".mfp-arrow-left").magnificPopup("next");
												    },
												    swipeRight: function() {
												    	$(".mfp-arrow-right").magnificPopup("prev");
												    }
												});
											}

											//overwrite default prev + next function. Add timeout for css3 crossfade animation
											$.magnificPopup.instance.next = function() {
												var self = this;
												self.wrap.removeClass('mfp-image-loaded');
												setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
											}
											$.magnificPopup.instance.prev = function() {
												var self = this;
												self.wrap.removeClass('mfp-image-loaded');
												setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
											}
										},
										beforeClose: function() {
										this.wrap.off('click.pinhandler');
										},
										imageLoadComplete: function() 
										{	
											var self = this;
											setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
										}
								    }
									});

									if ($.fn.waypoint) {

										//Skill Bar
										$('.skillbar').waypoint(function() {
											$('.skillbar').each(function(){
												percent = $(this).attr('data-percent');
												$(this).find('.skillbar-bar').animate({ 'width' : percent + '%' }, 3000, 'easeInOutExpo').addClass('progressed');
											});
										}, { offset: '90%' });

										$('.animation-standby').waypoint(function() {
											$(this).removeClass('animation-standby').addClass('animation-action');
										}, { offset: '90%' });

										$('.is-animated').waypoint(function() {
											$(this).removeClass('is-animated').addClass('element-animate');
										}, { offset: '90%' });
									}

									 var sync1 = $("#owl-ajax");
									 var sync2 = $("#owl-ajax-2");

									 sync1.owlCarousel({
									     singleItem: true,
									     slideSpeed: 500,
									     navigation: true,
									     autoHeight: true,
									     pagination: false,
									     afterAction: syncPosition,
									     navigationText : ["",""],
									     responsiveRefreshRate: 200,
									 });

									 sync2.owlCarousel({
									     items: 15,
									     itemsDesktop: [1199, 10],
									     itemsDesktopSmall: [979, 10],
									     itemsTablet: [768, 8],
									     itemsMobile: [479, 4],
									     pagination: false,
									     responsiveRefreshRate: 100,
									     afterInit: function(el) {
									         el.find(".owl-item").eq(0).addClass("synced");
									     }
									 });

									 $("#owl-ajax-2").on("click", ".owl-item", function(e) {
									     e.preventDefault();
									     var number = $(this).data("owlItem");
									     sync1.trigger("owl.goTo", number);
									 });
								
							
	                    } else {
	                        jQuery('#ajax-gridblock-loading').hide();
	                    }
	                },
	                error     : function(jqXHR, textStatus, errorThrown) {
	                    jQuery('#ajax-gridblock-loading').hide();
	                    alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	                }
	        	});

			return false;
			}
		});
	
	}
	
	function AjaxNavigation() {

		// Next Clicked
		$('.ajax-next').click(function(){
			
			if ( $(".ajax-gridblock-window").is(':animated') || $(".ajax-gridblock-image-wrap").is(':animated') ) return;

			var $got_current = $filterContainer.find(".gridblock-displayed");
			var $next_portfolio = $got_current.nextAll("div:visible").first();
			
			if ($next_portfolio.length) {
				$next_portfolio.find(".gridblock-ajax").trigger('click');
			}

			$('.ajax-gridblock-block-wrap').removeClass('ajax-collapsed');
			
			return false;

		});

		// Clicked Prev	

		$('.ajax-prev').click(function(){
			
			if ( $(".ajax-gridblock-window").is(':animated') || $(".ajax-gridblock-image-wrap").is(':animated') ) return;

			var $got_current = $filterContainer.find(".gridblock-displayed");
			var $prev_portfolio = $got_current.prevAll("div:visible").first();

			$prev_portfolio.find(".gridblock-ajax").trigger('click');

			$('.ajax-gridblock-block-wrap').removeClass('ajax-collapsed');
			
			return false;
		});	
	}
	
	
	function isotopeInit() {
		// initialize isotope
		if ($.fn.isotope) {

			$filterContainer.imagesLoaded( function() {

			var itemReveal = Isotope.Item.prototype.reveal;
			Isotope.Item.prototype.reveal = function() {
			  itemReveal.apply( this, arguments );
			  $( this.element ).removeClass('isotope-hidden');
			};

			var itemHide = Isotope.Item.prototype.hide;
			Isotope.Item.prototype.hide = function() {
			  itemHide.apply( this, arguments );
			  $( this.element ).addClass('isotope-hidden');
			};
			
			if ( $($filterContainer).hasClass('gridblock-masonary') ) {

				var photow_window_width = $('.container').width();
				if ( photow_window_width === null ) {
					photow_window_width = $('.container-edge-to-edge').width();
				}
				var wallContainer_w = $($filterContainer).width()-0.5;

				number_of_columns = $($filterContainer).attr('data-columns');

				var fourcolumn = '23%',
				threecolumn = '31%',
				twocolumn = '48%',
				onecolumn = '99%';

				if ( $($filterContainer).hasClass('thumnails-gutter-active') ) {
					fourcolumn = '25%';
					threecolumn = '33.3333%';
					twocolumn = '50%';
					onecolumn = '100%';
					wallContainer_w = $($filterContainer).width()-0.5;
				}

				if (number_of_columns==4) {
					$($filterContainer).find('.gridblock-element').css('width',fourcolumn);
				}
				if (number_of_columns==3) {
					$($filterContainer).find('.gridblock-element').css('width',threecolumn);
				}
				if (number_of_columns==2) {
					$($filterContainer).find('.gridblock-element').css('width',twocolumn);
				}
				if (number_of_columns==1) {
					$($filterContainer).find('.gridblock-element').css('width',onecolumn);
				}

				if (photow_window_width < 1035 ) {
					number_of_columns = 3;
					$($filterContainer).find('.gridblock-element').css('width',threecolumn);
				}
				if (photow_window_width < 800 ) {
					number_of_columns = 2;
					$($filterContainer).find('.gridblock-element').css('width',twocolumn);
				}			
				if (photow_window_width < 500 ) {
					number_of_columns = 2;
					$($filterContainer).find('.gridblock-element').css('width',onecolumn);
				}

				//console.log(wallContainer_w , wallContainer_w / number_of_columns , number_of_columns );
				console.log( number_of_columns , photow_window_width , wallContainer_w );

				if ( $('body.rtl').length == 1 ) {
					$filterContainer.isotope({
						isOriginLeft: false,
						resizable: false, // disable normal resizing
					  	masonry: {
					    	gutterWidth: 0,
					    	columnWidth: wallContainer_w / number_of_columns
					  }
					});
				} else {
					$filterContainer.isotope({
						resizable: false, // disable normal resizing
					  	masonry: {
					    	gutterWidth: 0,
					    	columnWidth: wallContainer_w / number_of_columns
					  }
					});					
				}

			} else {
				if ( $('body.rtl').length == 1 ) {
					$filterContainer.isotope({
						isOriginLeft: false,
						animationEngine : 'best-available',
						layoutMode : 'fitRows',
						  masonry: {
						    gutterWidth: 0
						  }
					});
				} else {
					$filterContainer.isotope({
						animationEngine : 'best-available',
						layoutMode : 'fitRows',
						  masonry: {
						    gutterWidth: 0
						  }
					});
				}
			}
		});
		}
	}
	function isotopeClicks() {
		// filter items when filter link is clicked
		$('#gridblock-filters a').click(function(){
		  var selector = $(this).attr('data-filter');
		  var filter_title = $(this).attr('data-title');
		  $filterContainer.isotope({ filter: selector });

		  $('#gridblock-filters a').removeClass('is-active');
		  $(this).addClass('is-active');

			$('.gridblock-filter-wrap h2').text(filter_title);
			// Set index to zero and disable prev
			$('.ajax-gallery-navigation').attr('id', '-1');
			$('.ajax-prev').css('cursor','default');

		  return false;
		});
	}


	AjaxPortfolio();
	AjaxNavigation();
	isotopeInit();
	isotopeClicks();
	if ($.fn.isotope) {
		$filterContainer.imagesLoaded( function() {
	    $filterContainer.isotope( 'on', 'layoutComplete', function (isoInstance, laidOutItems) {
			$(".gridblock-element:not(.isotope-hidden) .column-gridblock-lightbox").magnificPopup({
	 	        type: 'image',
	 	        tLoading: '',
		        closeBtnInside: false,
		        fixedContentPos:true,
		        mainClass: 'mfp-zoom-in',
		        removalDelay: 300,
		        image: {
		            verticalFit: true,
		            titleSrc: function(item) {

		                        var caption = item.el.attr('title');

		                        var pinItURL = "http://pinterest.com/pin/create/bookmarklet/";
		                        pinItURL += '?url=' + window.location.href;
		                        pinItURL += '&media=' + item.el.attr('href');
		                        pinItURL += '&description=' + caption;
		                        var pinshare = '<a class="lightbox-share" href="'+pinItURL+'" target="_blank"><i class="fa fa-pinterest"></i></a>';

		                        var facebookURL = "http://www.facebook.com/sharer.php";
		                        facebookURL += '?u=' + item.el.attr('href');
		                        facebookURL += '&t=' + caption;
		                        var facebookshare = '<a class="lightbox-share" href="'+facebookURL+'" target="_blank"><i class="fa fa-facebook"></i></a>';

		                        var twitterURL = "http://twitter.com/intent/tweet?text=";
		                        twitterURL += caption;
		                        twitterURL += '+' + item.el.attr('href');
		                        var twittershare = '<a class="lightbox-share" href="'+twitterURL+'" target="_blank"><i class="fa fa-twitter"></i></a>';


		                        return caption + '<div class="maginific-lightbox-sharing">'+facebookshare+pinshare+twittershare+'</div>';
		            }
		        },

			    gallery: {
			      enabled: true,
			      preloader: true,
			      preload:	[1,1],
			      arrowMarkup: '<span title="%title%" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir% mfp-prevent-close"></i></span>',
			      tCounter: '<span class="mfp-counter-inner">%curr% / %total%</span>'
			    },

			    callbacks: {
					open: function() {
						this.wrap.on('click.pinhandler', '.lightbox-share', function(e) {

						  window.open(e.currentTarget.href, "intent", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 50) + ",top=" + 100);

						  return false;
						});

						if ($.fn.swipe) {
							$(".mfp-wrap").swipe({
							    swipeLeft: function() {
							    	$(".mfp-arrow-left").magnificPopup("next");
							    },
							    swipeRight: function() {
							    	$(".mfp-arrow-right").magnificPopup("prev");
							    }
							});
						}

						//overwrite default prev + next function. Add timeout for css3 crossfade animation
						$.magnificPopup.instance.next = function() {
							var self = this;
							self.wrap.removeClass('mfp-image-loaded');
							setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
						}
						$.magnificPopup.instance.prev = function() {
							var self = this;
							self.wrap.removeClass('mfp-image-loaded');
							setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
						}
					},
					beforeClose: function() {
						this.wrap.off('click.pinhandler');
					},
					imageLoadComplete: function() 
					{	
						var self = this;
						setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
					}
			    }

			});

			$(".gridblock-element:not(.isotope-hidden) a[data-lightbox^='magnific-image']").magnificPopup({
	 	        type: 'image',
	 	        tLoading: '',
		        closeBtnInside: false,
		        fixedContentPos:true,
		        mainClass: 'mfp-zoom-in',
		        removalDelay: 300,
		        image: {
		            verticalFit: true,
		            titleSrc: function(item) {

		                        var caption = item.el.attr('title');

		                        var pinItURL = "http://pinterest.com/pin/create/bookmarklet/";
		                        pinItURL += '?url=' + window.location.href;
		                        pinItURL += '&media=' + item.el.attr('href');
		                        pinItURL += '&description=' + caption;
		                        var pinshare = '<a class="lightbox-share" href="'+pinItURL+'" target="_blank"><i class="fa fa-pinterest"></i></a>';

		                        var facebookURL = "http://www.facebook.com/sharer.php";
		                        facebookURL += '?u=' + item.el.attr('href');
		                        facebookURL += '&t=' + caption;
		                        var facebookshare = '<a class="lightbox-share" href="'+facebookURL+'" target="_blank"><i class="fa fa-facebook"></i></a>';

		                        var twitterURL = "http://twitter.com/intent/tweet?text=";
		                        twitterURL += caption;
		                        twitterURL += '+' + item.el.attr('href');
		                        var twittershare = '<a class="lightbox-share" href="'+twitterURL+'" target="_blank"><i class="fa fa-twitter"></i></a>';


		                        return caption + '<div class="maginific-lightbox-sharing">'+facebookshare+pinshare+twittershare+'</div>';
		            }
		        },

			    gallery: {
			      enabled: true,
			      preloader: true,
			      preload:	[1,1],
			      arrowMarkup: '<span title="%title%" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir% mfp-prevent-close"></i></span>',
			      tCounter: '<span class="mfp-counter-inner">%curr% / %total%</span>'
			    },

			    callbacks: {
					open: function() {
						this.wrap.on('click.pinhandler', '.lightbox-share', function(e) {

						  window.open(e.currentTarget.href, "intent", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 50) + ",top=" + 100);

						  return false;
						});

						if ($.fn.swipe) {
							$(".mfp-wrap").swipe({
							    swipeLeft: function() {
							    	$(".mfp-arrow-left").magnificPopup("next");
							    },
							    swipeRight: function() {
							    	$(".mfp-arrow-right").magnificPopup("prev");
							    }
							});
						}

						//overwrite default prev + next function. Add timeout for css3 crossfade animation
						$.magnificPopup.instance.next = function() {
							var self = this;
							self.wrap.removeClass('mfp-image-loaded');
							setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
						}
						$.magnificPopup.instance.prev = function() {
							var self = this;
							self.wrap.removeClass('mfp-image-loaded');
							setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
						}
					},
					beforeClose: function() {
						this.wrap.off('click.pinhandler');
					},
					imageLoadComplete: function() 
					{	
						var self = this;
						setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
					}
			    }

			});
	    });
	    });
	}
});