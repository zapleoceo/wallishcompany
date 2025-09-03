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

function getUrlAction(action) {
    var url = String(document.location).split('/');

    return (url.indexOf(action) !== -1);
}

function updatePageBackets() {
    $('.card__bucket').removeClass('active');
    $('.card__bucket.card__bucket__no_icon').text($('.card__bucket').attr('title'));

    $('.cart-product-id').each(function () {
        var product_id = $(this).attr('data-product-id');
        $('.card__like[data-pid=' + product_id + ']').closest('.card').find('.card__bucket').addClass('active');
        $('.card__like[data-pid=' + product_id + ']').closest('.card').find('.card__bucket').text($('.card__bucket').data('textInBacket'));
    });
}

function updateProductBucket() {
    var bucket = $('.product-info .product-controls .product-controls__bucket');
    var product_page_bucket_id = bucket.attr('data-product-id');
    bucket.removeClass('active');
    bucket.find('.text').text(bucket.attr('title'));

    $('.cart-product-id').each(function () {
        var product_id = $(this).attr('data-product-id');
        if (product_page_bucket_id === product_id) {
            bucket.addClass('active');
            bucket.find('.text').text(bucket.data('textInBacket'));
        }
    });
}

function cancelOrder() {
    var content = $('#formCart .c-info__content');
    var rezult = $('#formCart .c-info__rezult');
    if (!content.length) return;

    rezult.on('click', '.cancel-order', function () {
        content.children().each(function (i, el) {
            cart.remove(el.dataset.productid);
            location.reload();
        });
    });
}

function addWishlistCart(selector) {
    $.ajax({
        url: $(selector).attr('href') + '&not_redirect=1',
        type: 'get',
        dataType: 'json',
        success: function (data) {
            $('div.card .card__like.active').removeClass('active');

            $.ajax({
                url: 'index.php?route=common/wishlist/info',
                type: 'post',
                dataType: 'json',
                success: function (json) {
                    var html = $(json.html).html();
                    $('.wishlist-set').html(html);
                }
            });

            $.ajax({
                url: 'index.php?route=common/cart/info',
                type: 'post',
                dataType: 'json',
                success: function (json) {
                    if ('total' in json) {
                        $('.top-nav__money a').html(json['total'][1]);
                        $('.top-nav__money').attr('aria-show', json['total'][0]);
                    }

                    var html = $(json.html).html();

                    $('.fullcart-set').html(html);

                    productQuantity();

                },
                error: function (e) {
                    location.reload();
                }
            });
        },
        error: function (e) {
            location.reload();
        }
    });
}

function isWishlistEmpty() {
    var otherStr = $('#formWishlist .c-info__content').children().length === 0;
    var accountStr = $('section.pa-wish .card').length === 0;
    console.log(otherStr, accountStr);
    return !(otherStr ^ accountStr);
}

function fillWishListIcon() {
    $('#dropdownWishList').attr('data-empty', isWishlistEmpty());
}

$(document).ready(function () {
    fillWishListIcon();

    $('body').on('click', 'div.wish-cart__detail a.btn--wishlist', function (e) {
        e.preventDefault();

        addWishlistCart(this);
    });

    // Highlight any found errors
    $('.text-danger').each(function () {
        var element = $(this).parent().parent();

        if (element.hasClass('form-group')) {
            element.addClass('has-error');
        }
    });

    // Currency
    $('#currency .currency-select').on('click', function (e) {
        e.preventDefault();

        $('#currency input[name=\'code\']').attr('value', $(this).attr('name'));

        $('#currency').submit();
    });

    // Language
    $('#language a').on('click', function (e) {
        e.preventDefault();

        $('#language input[name=\'code\']').attr('value', $(this).attr('href'));

        $('#language').submit();
    });

    /* Search */
    $('#search input[name=\'search\']').parent().find('button').on('click', function () {
        url = $('base').attr('href') + 'index.php?route=product/search';

        var value = $('header input[name=\'search\']').val();

        if (value) {
            url += '&search=' + encodeURIComponent(value);
        }

        location.href = url;
    });

    $('#search input[name=\'search\']').on('keydown', function (e) {
        if (e.keyCode == 13) {
            $('header input[name=\'search\']').parent().find('button').trigger('click');
        }
    });

    // Menu
    $('#menu .dropdown-menu').each(function () {
        var menu = $('#menu').offset();
        var dropdown = $(this).parent().offset();

        var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

        if (i > 0) {
            $(this).css('margin-left', '-' + (i + 5) + 'px');
        }
    });

    // Product List
    $('#list-view').click(function () {
        $('#content .product-grid > .clearfix').remove();

        $('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');

        localStorage.setItem('display', 'list');
    });

    // Product Grid
    $('#grid-view').click(function () {
        // What a shame bootstrap does not take into account dynamically loaded columns
        cols = $('#column-right, #column-left').length;

        if (cols == 2) {
            $('#content .product-list').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
        } else if (cols == 1) {
            $('#content .product-list').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
        } else {
            $('#content .product-list').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
        }

        localStorage.setItem('display', 'grid');
    });

    if (localStorage.getItem('display') == 'list') {
        $('#list-view').trigger('click');
    } else {
        $('#grid-view').trigger('click');
    }

    // Checkout
    $(document).on('keydown', '#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']', function (e) {
        if (e.keyCode == 13) {
            $('#collapse-checkout-option #button-login').trigger('click');
        }
    });

    // tooltips on hover
    $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

    // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function () {
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
    });

    //Module-container layout fix
    cols = $('#column-right, #column-left').length;
    var productSet = $('#content .product-layout:not(.product-list,.product-grid)');
    if (cols == 2) {
        productSet.attr('class', 'product-layout col-lg-6 col-md-6 col-sm-12 col-xs-12');
    } else if (cols == 1) {
        productSet.attr('class', 'product-layout col-lg-4 col-md-4 col-sm-12 col-xs-12');
    } else {
        productSet.attr('class', 'product-layout col-lg-3 col-md-3 col-sm-12 col-xs-12');
    }

    updatePageBackets();

    updateProductBucket();

    cancelOrder();
});

// Cart add remove functions
var cart = {
    'add': function (product_id, quantity) {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                $('.alert, .text-danger').remove();

                if (json['redirect']) {
                    location.href = json['redirect'];
                }

                if (json['success']) {
                    $('body .main h1').after().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    // Need to set timeout otherwise it wont update the total
                    setTimeout(function () {
                        $('.top-nav__money a').html(json['total'][1]);
                        $('.top-nav__money').attr('aria-show', json['total'][0]);
                        var bool = json['total'][0] > 0 ? true : false;
                        $('div.dropdown.wishlist.main-icon__icon-holder').attr('data-hasmoney', bool);
                    }, 100);

                    //$('html, body').animate({ scrollTop: 0 }, 'slow');
                    setTimeout(function () {
                        $('div.alert.alert-success').fadeOut(1000);
                    }, 2000);
                    $.ajax({
                        url: 'index.php?route=common/cart/info',
                        type: 'post',
                        dataType: 'json',
                        success: function (json) {

                            if (typeof json.ok == 'undefined' || json.ok != true)
                                location.reload();

                            var html = $(json.html).html();

                            //console.log(json);
                            $('.fullcart-set').html(html);

                            productQuantity();

                            $('header.header').find('div.header__nav-wrapper').addClass('back');

                            updatePageBackets();

                            var bucket = $('.product-info .product-controls .product-controls__bucket');
                            bucket.addClass('active');
                            bucket.find('.text').text(bucket.data('textInBacket'));
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'updateBig': function (key, quantity) {
        $.ajax({
            url: 'index.php?route=checkout/cart/editCart',
            type: 'post',
            data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            beforeSend: function () {
                $('.overCart').fadeIn(200).css('display', 'flex');
            },
            complete: function () {
                // $('.overCart').fadeOut(200).css('display', 'none');
            },
            success: function (json) {
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('.top-nav__money a').html(json['total'][1]);
                    $('.top-nav__money').attr('aria-show', json['total'][0]);
                }, 100);

                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $.ajax({
                        url: 'index.php?route=checkout/cart/index',
                        type: 'post',
                        data: 'ajaxForm',
                        dataType: 'json',
                        error: function (json) {
                            // setTimeout(function () {
                                var html = $(json.responseText).html();
                                $('#cartContainer').html(html);
                            $('.overCart').fadeOut(200).css('display', 'none');
                            // }, 10);
                        }
                    });
                }
            }
        });
    },
    'update': function (key, quantity) {
        $.ajax({
            url: 'index.php?route=checkout/cart/edit',
            type: 'post',
            data: 'getjson=1&key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                if (document.getElementById('formCartTop')) {
                    sessionStorage.setItem('scrollTop-dropdown-cart', document.getElementById('formCartTop').scrollTop);
                }

                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('.top-nav__money a').html(json['total'][1]);
                    $('.top-nav__money').attr('aria-show', json['total'][0]);
                }, 100);

                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location.href = 'index.php?route=checkout/cart';
                } else {
                    $.ajax({
                        url: 'index.php?route=common/cart/info',
                        type: 'post',
                        dataType: 'json',
                        success: function (json) {
                            if (typeof json.ok == 'undefined' || json.ok != true)
                                location.reload();

                            var html = $(json.html).html();

                            $('.fullcart-set').html(html);

                            productQuantity();

                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function (key) {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                console.log(json);
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('.top-nav__money a').html(json['total'][1]);
                    $('.top-nav__money').attr('aria-show', json['total'][0]);
                    //$('#formCart .c-info__rezult tr:nth-of-type(1) .c-info__general-price').text(json['total'][1]);
                }, 100);

                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location.href = 'index.php?route=checkout/cart';
                } else {
                    $.ajax({
                        url: 'index.php?route=common/cart/info',
                        type: 'post',
                        dataType: 'json',
                        success: function (json) {

                            if (typeof json.ok == 'undefined' || json.ok != true)
                                location.reload();

                            var html = $(json.html).html();

                            $('.fullcart-set').html(html)
                            //console.log(this,html);
                            productQuantity();

                            updatePageBackets();

                            updateProductBucket();
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

var voucher = {
    'add': function () {

    },
    'remove': function (key) {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                }, 100);

                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location.href = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

var timeoutcard;
var wishlist_one_view = 0;
var wishlist = {
    'add': function (product_id) {

        $.ajax({
            url: 'index.php?route=account/wishlist/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function (json) {
                $('.alert').remove();

                if (json['redirect']) {
                    location.href = json['redirect'];
                }

                if (wishlist_one_view == 0) {
                    if (json['success']) {
                        //alert(json['success']);

                        $('body .main h1').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }

                    clearTimeout(timeoutcard);

                    timeoutcard = setTimeout(function () {
                        $('.alert').fadeOut(1000, function () {
                            $(this).remove();
                        });
                    }, 3000);

                    wishlist_one_view = 1;
                }


                /*if (typeof json['nologin'] != 'undefined') {
                    $('.card__like').removeClass('active');
                    return;
                }*/

                $.ajax({
                    url: 'index.php?route=common/wishlist/info',
                    type: 'post',
                    dataType: 'json',
                    success: function (json) {

                        if (typeof json.ok == 'undefined' || json.ok != true)
                            location.reload();

                        var html = $(json.html).html();
//console.log(json);
                        $('.wishlist-set').html(html);

                        fillWishListIcon();
                    }
                });


            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function (product_id) {

        $.ajax({
            url: 'index.php?route=account/wishlist/remove',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function (json) {
                $('.alert').remove();

                if (json['redirect']) {
                    location.href = json['redirect'];
                }

                if (wishlist_one_view == 0) {
                    if (json['success']) {
                        //alert(json['success']);

                        $('body .main h1').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    }

                    clearTimeout(timeoutcard);

                    timeoutcard = setTimeout(function () {
                        $('.alert').fadeOut(1000, function () {
                            $(this).remove();
                        });
                    }, 3000);

                    wishlist_one_view = 1;
                }

                $.ajax({
                    url: 'index.php?route=common/wishlist/info',
                    type: 'post',
                    dataType: 'json',
                    success: function (json) {

                        if (typeof json.ok == 'undefined' || json.ok != true)
                            location.reload();

                        var html = $(json.html).html();
//console.log(json);
                        $('.wishlist-set').html(html);

                        fillWishListIcon();
                    }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

var compare = {
    'add': function (product_id) {
        $.ajax({
            url: 'index.php?route=product/compare/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function (json) {
                $('.alert').remove();

                if (json['success']) {
                    $('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');


                    $('#compare-total').html(json['total']);

                    $('html, body').animate({scrollTop: 0}, 'slow');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function () {

    }
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function (e) {
    e.preventDefault();

    $('#modal-agree').remove();

    var element = this;

    $.ajax({
        url: $(element).attr('href'),
        type: 'get',
        dataType: 'html',
        success: function (data) {
            html = '<div id="modal-agree" class="modal">';
            html += '  <div class="modal-dialog">';
            html += '    <div class="modal-content">';
            html += '      <div class="modal-header">';
            html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
            html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
            html += '      </div>';
            html += '      <div class="modal-body">' + data + '</div>';
            html += '    </div';
            html += '  </div>';
            html += '</div>';

            $('body').append(html);

            $('#modal-agree').modal('show');
        }
    });
});

// Autocomplete */
/*
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);
*/
