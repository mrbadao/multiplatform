var $ = jQuery;
// Topmenu <ul> replace to <select>
function responsive(mainNavigation) {
    "use strict";
	var $ = jQuery;
	var screenRes = $('.body_wrap').width();
	
	if ($('.topmenu select').length == 0) {			  
		/* Replace unordered list with a "select" element to be populated with options, and create a variable to select our new empty option menu */
		$('.topmenu').append('<select class="select_styled" id="topm-select" style="display:none;"></select>');
		var selectMenu = $('#topm-select');

		/* Navigate our nav clone for information needed to populate options */
		$(mainNavigation).children('ul').children('li').each(function () {

			/* Get top-level link and text */
			var href = $(this).children('a').attr('href');
			var text = $(this).children('a').text();

			/* Append this option to our "select" */
			if ($(this).is(".current-menu-item") && href != '#') {
				$(selectMenu).append('<option value="' + href + '" selected>' + text + '</option>');
			} else if (href == '#') {
				$(selectMenu).append('<option value="' + href + '" disabled="disabled">' + text + '</option>');
			} else {
				$(selectMenu).append('<option value="' + href + '">' + text + '</option>');
			}

			/* Check for "children" and navigate for more options if they exist */
			if ($(this).children('ul').length > 0) {
				$(this).children('ul').children('li').not(".mega-nav-widget").each(function () {

					/* Get child-level link and text */
					var href2 = $(this).children('a').attr('href');
					var text2 = $(this).children('a').text();

					/* Append this option to our "select" */
					if ($(this).is(".current-menu-item") && href2 != '#') {
						$(selectMenu).append('<option value="'+href2+'" selected> - '+text2+'</option>');
					} else if (href2 == '#') {
						$(selectMenu).append('<option value="'+href2+'" disabled="disabled"> - '+text2+'</option>');
					} else {
						$(selectMenu).append('<option value="'+href2+'"> - '+text2+'</option>');
					}

					/* Check for "children" and navigate for more options if they exist */
					if ($(this).children('ul').length > 0) {
						$(this).children('ul').children('li').each(function () {

							/* Get child-level link and text */
							var href3 = $(this).children('a').attr('href');
							var text3 = $(this).children('a').text();

							/* Append this option to our "select" */
							if ($(this).is(".current-menu-item")) {
								$(selectMenu).append('<option value="' + href3 + '" class="select-current" selected> -- ' + text3 + '</option>');
							} else {
								$(selectMenu).append('<option value="' + href3 + '"> -- ' + text3 + '</option>');
							}

						});
					}
				});
			}
		});
	}
	if(screenRes >= 750){
        $('.topmenu select:first').hide();
        $('.topmenu ul:first').show();      
    }else{
        $('.topmenu ul:first').hide();
        $('.topmenu select:first').show();             
    }

	/* When our select menu is changed, change the window location to match the value of the selected option. */
	$(selectMenu).change(function () {
		location = this.options[this.selectedIndex].value;
	});

    // mega dropdown menu
    $('.dropdown .mega-nav > ul.submenu-1').each(function(){
        var liItems = $(this);
        var Sum = 0;
        var liHeight = 0;
        if (liItems.children('li').length > 1){
            $(this).children('li').each(function(i, e){
                Sum += $(e).outerWidth(true);
            });
            $(this).width(Sum);
            liHeight = $(this).innerHeight();
            $(this).children('li').css({"height":liHeight});
        }
        var posLeft = 0;
        var halfSum = Sum/2;
        var screenRes = $(window).width();

        var margLeft = $(this).parent().offset().left;
        liItems.css({"width": screenRes, "left": -margLeft});
        var arrowPos = margLeft + $(this).parent().width() / 2 - 6;
        liItems.find(".dropdown_arrow").css('left',arrowPos);

    });
}

(function ($) {
    "use strict";
    $.fn.tfGallery = function () {
        return $(this).each(function () {
            //var galleryID = $(this); // paste here a gallery ID
            //var galleryWrap = $(this).parents(".tf-gallery-wrap");
            var gallerySize = $(this).children(".gallery-images").children().size();

            $(this).children('.gallery-images').carouFredSel({
                prev : {
                    button: function() {
                        return $(this).parents(".tf-gallery-wrap").find(".prev");
                    }
                },
                next : {
                    button: function() {
                        return $(this).parents(".tf-gallery-wrap").find(".next");
                    }
                },
                circular: false,
                infinite: false,
                items: 1,
                auto: false,
                scroll: {
                    fx: "crossfade",
                    onBefore: function() {
                        var pos = $(this).triggerHandler('currentPosition');
                        $(this).closest(".tf-gallery-wrap").find(".image-count").html('Image '+(pos+1)+' of '+ gallerySize);
                        $(this).closest(".tf-gallery-wrap").find(".thumb-item").removeClass('selected');
                        $(this).closest(".tf-gallery-wrap").find('.gallery-thumbs div.itm'+pos).addClass('selected');
                        var currentText = $(this).children(".itm"+pos).children(".gallery-item-caption").html();
                        $(this).closest(".tf-gallery-wrap").find(".gallery-text").fadeOut(150, function() {
                            $(this).html(currentText);
                        }).fadeIn(150);
                        $(this).closest(".tf-gallery").find('.gallery-thumbs').trigger('slideTo', [pos, true]);
                    }
                },
                onCreate: function() {
                    $(this).children().each(function(i) {
                        $(this).addClass('itm'+i);
                    });
                    var currentText = $(this).find('.itm0 > .gallery-item-caption').html();
                    $(this).closest(".tf-gallery-wrap").find(".gallery-text").html(currentText);
                    $(this).closest(".tf-gallery-wrap").find(".midtab_right > .image-count").html('Image 1 of '+ gallerySize);
                }
            });

            $(this).children('.gallery-thumbs').carouFredSel({
                width: "100%",
                auto: false,
                infinite: false,
                circular: false,
                scroll: {
                    items : 1,
                    width: 128,
                    height: 83
                },
                onCreate: function() {
                    $(this).children().each(function(i) {
                        $(this).addClass( 'itm'+i );
                        $(this).click(function() {
                            $(this).closest(".tf-gallery").find('.gallery-images').trigger('slideTo', [i, true]);
                        });
                    });
                    $(this).children('.itm0').addClass('selected');
                }
            });
        });
    };
}(jQuery));

jQuery(document).ready(function($) {
    "use strict";
	var screenRes = $(window).width();

    //search on hover
    $(".hover-search").hoverIntent(
        function() {
            $(this).children(".btn-search").fadeOut();
            $(this).children("form").fadeIn();
        }, function() {
            $(this).children("form").fadeOut();
            $(this).children(".btn-search").fadeIn();
        }
    );

    $('.hover').bind('touchstart touchend', function(e) {
        e.preventDefault();
        $(this).toggleClass('hover_effect');
    });

    $('.dropdown .mega-nav > ul.submenu-1').each(function(){
        $(this).wrapInner('<div class="mega-wrap clearfix"></div>');
        $(this).prepend('<span class="dropdown_arrow"></span>');
    });
	
// Remove links outline in IE 7
	$("a").attr("hideFocus", "true").css("outline", "none");

// style Select, Radio, Checkbox
	if ($("select").hasClass("select_styled")) {
		var deviceAgent = navigator.userAgent.toLowerCase();
		var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
		if (agentID) {
			cuSel({changedEl: ".select_styled", visRows: 8, scrollArrows: true});	 // Add arrows Up/Down for iPad/iPhone
		} else {
			cuSel({changedEl: ".select_styled", visRows: 8, scrollArrows: false});
		}		
	}
	if ($("div,p").hasClass("input_styled")) {
		$(".input_styled input").iCheck({
            labelHover: false,
            checkboxClass: 'icheckbox_minimal-green',
            radioClass: 'iradio_minimal-green'
        });
	}

// centering dropdown submenu (not mega-nav)
	$(".dropdown > li:not(.mega-nav)").hover(function(){
		var dropDown = $(this).children("ul");
		var dropDownLi = $(this).children().children("li").innerWidth();		
		var posLeft = ((dropDownLi - $(this).innerWidth())/2);
		dropDown.css("left",-posLeft);		
	});	
	
// reload topmenu on Resize
	var mainNavigation = $('.topmenu').clone();
	responsive(mainNavigation);
	
    $(window).resize(function() {		
        var screenRes = $('.body_wrap').width();
        responsive(mainNavigation);
    });	
	
// responsive megamenu

    if (screenRes < 750) {
        //$(".dropdown li.mega-nav").removeClass("mega-nav");
    }
    if (screenRes > 320) {
        mega_show();
    }

    function mega_show(){
		$('.dropdown li').hoverIntent({
			sensitivity: 5,
			interval: 30,
			over: subm_show, 
			timeout: 0,
			out: subm_hide
		});
	}
	function subm_show(){	
		if ($(this).hasClass("parent")) {
			$(this).addClass("parentHover");
		};		
		$(this).children("ul").fadeIn(200);
	}
	function subm_hide(){ 
		$(this).removeClass("parentHover");
		$(this).children("ul").fadeOut(20);
	}
		
	$(".dropdown ul").closest("li").addClass("parent");
	$(".dropdown li:first-child, .pricing_box li:first-child, .sidebar .widget-container:first-child, .f_col .widget-container:first-child, .lang-list li:first-child").addClass("first");
	$(".dropdown li:last-child, .pricing_box li:last-child, .widget_twitter .tweet_item:last-child, .sidebar .widget-container:last-child, .f_col .widget-container li:last-child, .lang-list li:last-child").addClass("last");
	$(".dropdown li:only-child").removeClass("last").addClass("only");	
	$(".sidebar .current-menu-item, .sidebar .current-menu-ancestor").prev().addClass("current-prev");				
	
// tabs		
	var $tabs_on_page = $('.tabs').length;
	var $bookmarks = 0;

	for(var i = 1; i <= $tabs_on_page; i++){
		$('.tabs').eq(i-1).addClass('tab_id'+i);
		$bookmarks = $('.tab_id'+i+' li').length;
		$('.tab_id'+i).addClass('bookmarks'+$bookmarks);
	};
	$('.tabs li').click(function() {
    setTimeout(function () {
        for(var i = 1; i <= $tabs_on_page; i++){
            $bookmarks = $('.tab_id'+i+' li').length;
            for(var j = 1; j <= $bookmarks; j++){
                $('.tab_id'+i).removeClass('active_bookmark'+j);

                if($('.tab_id'+i+' li').eq(j-1).hasClass('active')){
                    $('.tab_id'+i).addClass('active_bookmark'+j);
                }
            }
        }
    }, 0)
});
	
// odd/even
	$("ul.recent_posts > li:odd, ul.popular_posts > li:odd, .table-striped table>tbody>tr:odd, .boxed_list > .boxed_item:odd, .grid_layout .post-item:odd").addClass("odd");
	$(".widget_recent_comments ul > li:even, .widget_recent_entries li:even, .widget_twitter .tweet_item:even, .widget_archive ul > li:even, .widget_categories ul > li:even, .widget_nav_menu ul > li:even, .widget_links ul > li:even, .widget_meta ul > li:even, .widget_pages ul > li:even, .event_list .event_item:even").addClass("even");
	
// cols
	$(".row .col:first-child").addClass("alpha");
	$(".row .col:last-child").addClass("omega"); 	

// toggle content
	$(".toggle_content").hide(); 	
	$(".toggle").toggle(function(){
		$(this).addClass("active");
		}, function () {
		$(this).removeClass("active");
	});
	
	$(".toggle").click(function(){
		$(this).next(".toggle_content").slideToggle(300,'easeInQuad');
	});
	
	
	$(".opened").find(".panel-collapse").addClass("in");
	$(".panel-toggle").click (function() {
		$(this).closest(".toggleitem").toggleClass("opened");;
	});
	
	$("[data-toggle='tooltip']").tooltip();

// pricing
	if (screenRes > 750) {
		// style 2
		$(".pricing_box ul").each(function () {
			$(".pricing_box .price_col").css('width',$(".pricing_box ul").width() / $(".pricing_box .price_col").size() - 10);			
		});
		
		var table_maxHeight = -1;
		$('.price_item .price_col_body ul').each(function() {
			table_maxHeight = table_maxHeight > $(this).height() ? table_maxHeight : $(this).height();
		});
		$('.price_item .price_col_body ul').each(function() {
			$(this).height(table_maxHeight);
		});	
	} 

// grid list	
	if (screenRes > 600) {
		$(".gridlist .post-item:nth-child(3n), .block-list .block-item:nth-child(3n)").addClass("omega");
	}	
	
// buttons	
		$(".btn, .post-share a, .btn-submit").hover(function(){
			$(this).stop().animate({"opacity": 0.80});
		},function(){
			$(this).stop().animate({"opacity": 1});
		});
// SyntaxHighlighter
    if ($("pre").hasClass("brush: plain")) {
        SyntaxHighlighter.defaults['gutter'] = false;
        SyntaxHighlighter.defaults['toolbar'] = true;
        SyntaxHighlighter.all();
    }
// Smooth Scroling of ID anchors	
  function filterPath(string) {
  return string
    .replace(/^\//,'')
    .replace(/(index|default).[a-zA-Z]{3,4}$/,'')
    .replace(/\/$/,'');
  }
  var locationPath = filterPath(location.pathname);
  var scrollElem = scrollableElement('html', 'body');
 
  $('a[href*=#].anchor').each(function() {
    $(this).click(function(event) {
    var thisPath = filterPath(this.pathname) || locationPath;
    if (  locationPath == thisPath
    && (location.hostname == this.hostname || !this.hostname)
    && this.hash.replace(/#/,'') ) {
      var $target = $(this.hash), target = this.hash;
      if (target && $target.length != 0) {
        var targetOffset = $target.offset().top;
          event.preventDefault();
          $(scrollElem).animate({scrollTop: targetOffset}, 400, function() {
            location.hash = target;
          });
      }
    }
   });	
  });
 
  // use the first element that is "scrollable"
  function scrollableElement(els) {
    for (var i = 0, argLength = arguments.length; i <argLength; i++) {
      var el = arguments[i],
          $scrollElement = $(el);
      if ($scrollElement.scrollTop()> 0) {
        return el;
      } else {
        $scrollElement.scrollTop(1);
        var isScrollable = $scrollElement.scrollTop()> 0;
        $scrollElement.scrollTop(0);
        if (isScrollable) {
          return el;
        }
      }
    }
    return [];
  }
  
	// prettyPhoto lightbox, check if <a> has atrr data-rel and hide for Mobiles
	if($('a').is('[data-rel]') && screenRes > 481) {
        $('a[data-rel]').each(function() {
			$(this).attr('rel', $(this).data('rel'));
		});
        $("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
    }
    if($('a.popup').is('[data-rel]') && screenRes < 481) {
        $('a.popup[data-rel]').each(function() {
            $(this).attr('rel', $(this).data('rel'));
        });
        if (screenRes > 320) {
            $("a.popup[rel^='prettyPhoto']").prettyPhoto({
                social_tools:false,
                default_width: 400,
                default_height: 220,
            });
        } else {
            $("a.popup[rel^='prettyPhoto']").prettyPhoto({
                social_tools:false,
                default_width: 280,
                default_height: 220,
            });
        }
    }
	  
});

$(window).load(function() {
    var $=jQuery;

	// Rating Stars
	$(".rating span.star").hover(
		function() {
			$(".rating span.star").removeClass("on");
			$(this).prevAll().addClass("over");
		}
		, function() {
			$(this).removeClass("over");
		}
	);
	$(".rating span.star").click( function() {
		$(this).parent().children(".star").removeClass("voted");
		$(this).prevAll().addClass("voted");
		$(this).addClass("voted");
	});

    //Map on homepage

});