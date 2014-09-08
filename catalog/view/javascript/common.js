$(document).ready(function() {
	/* Search */
	$('.button-search').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var search = $('input[name=\'search\']').attr('value');
		
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		
		location = url;
	});
	
	$('#header input[name=\'search\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('input[name=\'search\']').attr('value');
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	/* Ajax Cart */
	$('#cart > .heading a').live('click', function() {
		$('#cart').addClass('active');
		
		$('#cart').load('index.php?route=module/cart #cart > *');
		
		$('#cart').live('mouseleave', function() {
			$(this).removeClass('active');
		});
	});
	
	/* Mega Menu */
/*	$('#menu ul > li > a + div').each(function(index, element) {
		// IE6 & IE7 Fixes
		if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
			var category = $(element).find('a');
			var columns = $(element).find('ul').length;
			
			$(element).css('width', (columns * 143) + 'px');
			$(element).find('ul').css('float', 'left');
		}		
		
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();
		
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
		
		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});*/

	// IE6 & IE7 Fixes
/*	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			$('#column-right + #content').css('margin-right', '195px');
		
			$('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if ($.browser.version <= 7) {
			$('#menu > ul > li').bind('mouseover', function() {
				$(this).addClass('active');
			});
				
			$('#menu > ul > li').bind('mouseout', function() {
				$(this).removeClass('active');
			});	
		}
	}*/
	
	$('.success img, .warning img, .attention img, .information img').live('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});


    $(".right-column article#article, section.category-content,#content.article .article-info,.product-info").mCustomScrollbar({
        theme:"dark-3",
        mouseWheel:{
            enable: true,
            preventDefault: true,
            normalizeDelta: true,
            deltaFactor: 200

        },
        autoDraggerLength:false

        // scrollbarPosition:"outside"
    });
    $('.product-list').mCustomScrollbar({
        theme:"dark-3",
        mouseWheel:{
            enable: true,
            preventDefault: true,
            normalizeDelta: true,
            deltaFactor: 200

        },
        autoDraggerLength:false,

        scrollbarPosition:"outside"
    });


    // Animate top-banners
    /*    $('.top-banners .banner').hover(function(){
     $(this).find('.l-box').prepend('<div class="overlay"/>');
     $('.overlay')
     .css({
     height:'100%',
     backgroundColor:'#000'
     }).stop(false,true).animate({
     opacity:0.5
     })
     },function(){});*/


});


/////////////////////////////////Magic Line /////////////////////////////

window.onload = function(){
    var $el, leftPos, newWidth, $magicLine;
    $mainNav = $("nav#menu > ul");



    $mainNav.append("<li id='magic-line'></li>"); //Now You See Me
    $magicLine = $("#magic-line");

    if($mainNav.find('li.active').length){
        $magicLine
            .width($('nav li.level-1.active').width())
            .css("left", $("li.active ").position().left)
            .data("origLeft", $magicLine.position().left)
            .data("origWidth", $magicLine.width());
    } else{
        $magicLine
            .data("origWidth",0)
            .css('padding','0');
    }


    $('nav li.level-1 ,.v-sep').hover(function() {
        $el = $(this);
        leftPos = $el.position().left;
        newWidth = $el.width();
        $magicLine.stop().animate({
            left: leftPos,
            width: newWidth
        });
        if($mainNav.find('li.active').length == 0 ){
            $magicLine
                .css('padding','0 1%');
        }
    }, function() {
        $magicLine.stop().animate({
            left: $magicLine.data("origLeft"),
            width: $magicLine.data("origWidth")
        });
            if($mainNav.find('li.active').length == 0 ){
            $magicLine
                .css('padding','0');
            }

    });


    function adapt_img(){
        var center = $('.center');
        var marg_centr = center.outerHeight(true)-center.height();

        var search_height = $('#container').height()-($('header').outerHeight(true)+$('footer').outerHeight(true));
        var height_center = search_height-($('.top-banners').height()+marg_centr);

        var css = "#content { height:" + Math.round(search_height) +"px; }" +
                "#banner4 {height:"+Math.round(height_center)+"px}" +
                "#banner5 {height:"+Math.round(height_center-10)/2+"px}"+
                "#banner6 {height:"+Math.round(height_center-10)/2+"px}",
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

        style.type = 'text/css';
        if (style.styleSheet){
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);

        $('.center .banner img').imageScale({
            scale: 'best-fill',
            callback: Animate_central_banners()
        });

        /*        $('.product-page .image img').imageScale({
         scale:'best-fill'
         });*/


    }

    adapt_img();

    $(window).resize(function(){
        adapt_img();
    });

    function Animate_central_banners() {
        $('#banner4 img,#banner5 img,#banner6 img').hover(function () {
                var el = $(this);
                var el_dom = el[0];
                el.stop(false, true);
                if ($.data(el_dom, 'width') !== el.width() && $.data(el_dom, 'height') !== el.height()) {
                    var width = el.width();
                    var height = el.height();
                    $.data(el_dom, "width", width);
                    $.data(el_dom, "height", height);
                }


                el.animate({
                    width: "+=10",
                    height: "+=10"
                }, 500);
                el.closest('.l-box').stop(false, true).animate({
                    'padding-top': 0,
                    'padding-bottom': 0,
                    'padding-right': 0,
                    'padding-left': 0
                }, 500)
            },
            function () {
                var el = $(this);
                var el_dom = el[0];
                var orig_width = $.data(el_dom, "width");
                var orig_height = $.data(el_dom, "height");
                el.stop(false, true).animate({
                    width: orig_width + 'px',
                    height: orig_height + 'px'
                }, 500);
                el.closest('.l-box').stop(false, true).animate({
                    padding: 5
                }, 500)
            });
    }

};


function getURLVar(key) {
	var value = [];
	
	var query = String(document.location).split('?');
	
	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
} 

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                var cart = $('#cart .cart');
                var imgtodrag = $('.product.'+product_id).find("img").eq(0);
                if (imgtodrag) {
                    var imgclone = imgtodrag.clone()
                        .offset({
                            top: imgtodrag.offset().top,
                            left: imgtodrag.offset().left
                        })
                        .css({
                            'opacity': '0.5',
                            'position': 'absolute',
                            'height': '150px',
                            'width': '150px',
                            'z-index': '100'
                        })
                        .appendTo($('body'))
                        .animate({
                            'top': cart.offset().top + 10,
                            'left': cart.offset().left - 20,
                            'width': 75,
                            'height': 75
                        }, 1000, 'easeInOutExpo');

                    setTimeout(function () {
                        cart.effect("bounce", {
                            times: 2
                        }, 200);
                    }, 1500);

                    imgclone.animate({
                        'width': 0,
                        'height': 0
                    }, function () {
                        $(this).detach()
                    });
                }


				
				$('.success').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}
function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#wishlist-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
}

function addToCompare(product_id) { 
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#compare-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}


function simplecheckout_login() {
    jQuery.ajax({
        url: 'index.php?route=checkout/simplecheckout_customer/login',
        data: jQuery('#simplecheckout_login input'),
        type: 'POST',
        dataType: 'text',
        success: function (data) {
            jQuery('#simplecheckout_login').replaceWith(data);
        }
    });
}

