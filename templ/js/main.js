function lg(code) {
    if (typeof js_translation[code] != undefined)
        return js_translation[code];

    return code;
}

function SlidersInit() {
    $('#slideshow_top').owlCarousel({
        items: 1,
        autoPlay: 3000,
        nav: false,
        dots: false,
        singleItem: true,
        navigation: false,
        navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
        pagination: false,
        responsiveClass: true,
        responsive: {
            0: {
                mouseDrag: false,
                touchDrag: true
            },
            1200: {
                mouseDrag: true,
                touchDrag: false
            }
        }
    });

    $('#slideshow_newsroom').owlCarousel({
        autoPlay: 3000,
        loop: true,
        center: true,
        items: 3,
        margin: 20,
        nav: true,
        dots: true,
        navText: ['<img class="owl-nav__icon" src="/templ/img/icons/arrow-small.svg" />',
            '<img class="owl-nav__icon" src="/templ/img/icons/arrow-small.svg" />'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false,
                mouseDrag: false,
                touchDrag: true
            },
            640: {
                items: 2,
                center: false,
                nav: false,
                dots: true,
                mouseDrag: false,
                touchDrag: true
            },
            960: {
                items: 3,
                nav: false,
                dots: true,
                mouseDrag: false,
                touchDrag: true
            },
            1200: {
                items: 3,
                nav: true,
                mouseDrag: true,
                touchDrag: false
            }
        }
        /*onInitialized : function () {
            $('#slideshow_newsroom').find('.owl-nav').removeClass('disabled');
            $('#slideshow_newsroom').find('.owl-dots').removeClass('disabled');
        }*/
    });


    $('#slideshow_newsroom').on('initialize.owl.carousel', function () {
        // alert('ok');
    });
}


function update_quanity_top(inp = false) {

    if (inp !== false) {
        var key = inp.attr('data-key');
        var quantity = inp.val();

        cart.update(key, quantity);

        return true;
    }

    var $inputs = $('#formCartTop').find('.quantity__text input');

    $inputs.each(function () {
        var key = $(this).attr('data-key');
        var quantity = $(this).val();
        //cart.update(key, quantity);
        setTimeout(cart.update, 150, key, quantity);
    });
}


function initAddCart() {
    $('.card').on('click', '.card__btn', function (e) {
        e.preventDefault();

        var $count = $(this).closest('.card').find('.card__counter input');
        var quanity = Number($count.val());

        if ($(this).hasClass('plus')) {
            quanity = quanity + 1;
        }

        if ($(this).hasClass('minus')) {
            quanity = quanity - 1;
        }

        if (quanity < Number($count.parent().data('min'))) {
            quanity = $count.parent().data('min');
        }

        $count.val(quanity);
    });

    $('.card').on('click', '.card__bucket', function (e) {
        e.preventDefault();
        // Логируем добавление в корзину
        var product_id = $(this).data('productId');
        var $count = $(this).closest('.card').find('.card__counter input');
        var quanity = Number($count.val());
        console.log('CART_ADD_ITEM:', {product_id: product_id, quantity: quanity});
        cart.add(product_id, quanity);
    });


    $('div.fullcart-set').on('click', '.quantity button', function (e) {

        var $count = $(e.target).closest('.quantity').find('input');
        var quanity = Number($count.val());

        if ($(e.target).hasClass('quantity__minus')) {
            quanity = quanity - 1;
            $count.val(quanity);
        }

        if ($(e.target).hasClass('quantity__plus')) {
            quanity = quanity + 1;
            $count.val(quanity);
        }

        if (quanity < Number($count.data('min'))) {
            quanity = $count.data('min');
            $count.val(quanity);
        }

        update_quanity_top($count);
    });

    $('div.fullcart-set').on('change', '.quantity input', function (e) {
        update_quanity_top($(e.target));
    });
};

function initSelect(selector, form) {
    var allowCloseMenu = true;

    $(selector).each(function () {
        var $this = $(this), numberOfOptions = $(this).children('option').length;
        var $options = [].slice.call($(this).children('option'));
        var index = this.selectedIndex;


        $this.addClass('select-hidden');

        var $select = $this.next('div.selected')[0];

        var $selectedText = $select.children.item(0);
        var $selectedList = $select.children.item(1);
        $($selectedText).text($options[$this[0].selectedIndex].innerText);

        for (var i = 0; i < numberOfOptions; i++) {
            //if(index !== i) {
            $('<li />', {
                text: $options[i].innerText,
                rel: $options[i].value
            }).appendTo($selectedList);
            //}
            if (index === i) {
                $($selectedList).find('li').last().hide();
            }
        }

        $($select).click(function (e) {
            e.stopPropagation();
            $($select).toggleClass('active');
            $('.selected').not($select).removeClass('active');
        });

        $($selectedList).each(function (i, e) {
            $(e).click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (e.target.hasAttribute('rel')) {
                    $selectedText.innerText = e.target.innerText;
                    var optionIndex = $($selectedList.children).index(e.target);

                    /*$($options[optionIndex]).attr('selected','selected').change();

                    $($options).not($options[optionIndex]).each( function(i, el) {
                        $(el).removeAttr('selected');
                    });*/

                    $($options).removeAttr('selected');

                    $($options[optionIndex]).attr('selected', 'selected').change();

                    $('.selected').removeClass('active');
                }
            });
        });

        $(document).click(function (e) {
            //e.stopPropagation();
            $('.selected').removeClass('active');
        });

    });
    if (window.innerWidth < 768) {
        allowCloseMenu = false;
    }
    $(window).on('resize', function () {
        if (this.innerWidth < 768) {
            allowCloseMenu = false;
        } else {
            allowCloseMenu = true;
        }
    });
    $('div.selected').on('mouseover', function () {
        $('div.top-nav__main-icon').find('.show').removeClass('show');
        console.log(allowCloseMenu);
        if (allowCloseMenu) {
            $('.drop-menu__core')[0].checked = false;
        }
    });
    $('div.selected').on('mouseleave', function () {
        $('header.header div.header__nav-wrapper').addClass('back');
        $('header.header div.header__nav-wrapper').removeClass('blocked');
    });
};

function blockHeaderByMenu() {
    $('div.drop-menu').on('click', function (e) {
        e.stopPropagation();
        var checked = $('.drop-menu__core')[0].checked;
        var $header = $('header.header div.header__nav-wrapper');
        console.log(checked);
        if (!checked) {
            $header.removeClass('blocked');
            $header.addClass('back');
        } else {
            $header.addClass('blocked');
        }
    });
}

function closeMenu() {
    $(document).click(function (e) {
        var target = $('.drop-menu')[0];
        var ckecked = $('.drop-menu__core')[0].checked;
        if (ckecked && e.target.closest('.drop-menu') !== target) {
            $('.drop-menu__core')[0].checked = !ckecked;
            $('header.header div.header__nav-wrapper').removeClass('blocked');
        }
    });
}

$('body').on('change', '#languageTopSelect,#currencyTopSelect,#languageDrop,#currencyDrop', function () {
    $(this).closest('form').submit();
});

function productQuantity() {
    var productQuantity = $('div.bucket-empty__detail').find('.c-info__product').length;
    if (productQuantity == 0) {
        productQuantity = $('section.cart-page').find('.c-info__product').length;
    }

    //console.log(productQuantity);

    const $cartIcon = $('button.bucket-empty__icon-holder');
    $cartIcon.attr('data-quantity', productQuantity);

    var is = $('div.bucket-empty__detail .c-info__btn').attr('aria-disabled');
    if (typeof is == 'undefined') {
        is = $('.c-info__footer .btn.btn--submit').attr('aria-disabled');
    }

    if (typeof is == 'undefined') {
        $cartIcon.attr('aria-more1k', false);
        $('.top-nav__money').attr('aria-more1k', false);

        return;
    }

    if (is === 'true') {
        $cartIcon.attr('aria-more1k', false);
        $('.top-nav__money').attr('aria-more1k', false);
    } else {
        $cartIcon.attr('aria-more1k', true);
        $('.top-nav__money').attr('aria-more1k', true);
    }
}

function fixedHeader() {

    var scroll;
    var $nav = $('header.header').find('div.header__nav-wrapper');
    var delta = 0;

    function helper(currentDelta) {
        if (currentDelta > 0) {
            $nav.removeClass('back');
        } else {
            $nav.addClass('back');
            $nav.addClass('logo');
        }
    }

    if ($(window).scrollTop() !== 0) {
        $nav.addClass('prepined');
        setTimeout(function () {
            $nav.addClass('pined');
        }, 300);
    }

    $(window).scroll(function () {
        scroll = $(window).scrollTop();
        var currentDelta = scroll - delta;
        delta = scroll;
        if (scroll > 0) {
            $nav.addClass('prepined');
            setTimeout(function () {
                $nav.addClass('pined');
                helper(currentDelta);
            }, 300);
        } else if (scroll === 0) {
            setTimeout(function () {
                $nav.removeClass('back');
                $nav.removeClass('pined');
                $nav.removeClass('logo');
            }, 1000);
        }
    });
}

function inputPhoneValidate(selector) {
    var $obj = $(selector);
    $obj.each(function (i, el) {
        $(el).on('keypress input', function (event) {
            if (event.type === 'keypress') {
                var code = (event.which) ? event.which : event.keyCode;
                if (code > 31 && (code < 48 || code > 57) && code !== 43) return false;
                return true;
            }
        });
    });
}

$('div.fullcart-set').on('click', function (e) {
    if (e.target.classList.contains('remove')) {
        $(e.target.closest('tr')).remove();
    }
});

function ckeckInputValue() {
    $('div.contacts__input-holder').find('input.contacts__input').each(function (i, el) {
        if (el.value !== '') {
            $(el).addClass('valid');
        } else {
            $(el).removeClass('valid');
        }
    });
    $('div.contacts__input-holder').find('input.contacts__input').on('keyup', function () {
        //console.log(this.value !== '');
        if (this.value !== '') {
            $(this).addClass('valid');
            $(this).removeClass('empty');
        } else {
            $(this).removeClass('valid');
            $(this).addClass('empty');
            $(this).removeClass('error');
            $(this).closest('.intl-tel-input').removeClass('error');
            $($(this).attr('data-error')).html('');
        }
    });
}

function initRadioButtons() {
    $('div.c-info').on('click', 'div.holiday-radio', function (e) {
        e.preventDefault();
        var parent = this.parentNode;
        var $checked = $(parent).find('input[checked]');
        var $labelActive = $(parent).find('label.holiday-radio__label.active');

        var $radio = $(this).find('input[type=radio]');
        var $label = $(this).find('label.holiday-radio__label');

        $checked.removeAttr('checked');
        $labelActive.removeClass('active');

        $radio.attr('checked', 'checked');
        $label.addClass('active');
    });
}

function footerSubscribe() {
    $('.footer__thanks-for-subscribe').hide();

    $('.footer__thanks-for-subscribe').on('click', ' .close', function () {
        $('.footer__thanks-for-subscribe').fadeOut(1000, function () {
            $('.footer__thanks-for-subscribe').hide();
        });
    });

    $('#footerSubscribe').on('change', '.footer__input', function () {
        $('.footer__input').css('border', '1px solid #f2f2f2');
    });

    $('#footerSubscribe').on('submit', function (e) {
        e.preventDefault();

        var $form = $(this);

        $('.footer__thanks-for-subscribe').hide();
        $form.find('.footer__input').css('border', '1px solid #f2f2f2');

        var value = $form.find('.footer__input').val();
        if (!value) {
            $form.find('.footer__input').addClass('errorbak');
            return false;
        }

        $.ajax({
            url: $form.attr('action'),
            data: {'email': value},
            method: 'POST',

            complete: function (resp) {

                $('.footer__thanks-for-subscribe').show();
                $('.footer__input').val('');
            }
        });

        return false;
    });
}

function initGetUpButton() {
    var $getUpBtn = $('body').find('button.btn.btn--up');
    $getUpBtn.on('click', function () {
        $('html').animate({scrollTop: 0}, 1000);
    });

    var position;
    $(window).scroll(function () {
        position = $(window).scrollTop();

        if (position > 500) {
            $getUpBtn.css('display', 'flex');
            //$getUpBtn.addClass('fadeIn');
        } else {
            //$getUpBtn.removeClass('fadeIn');
            $getUpBtn.fadeOut(function () {
                $getUpBtn.css('display', 'none');
            });
        }
    });
}

function toggleAccount() {
    var $container = $('ul.sidebar-nav.account__sidebar-nav');
    var $hidden = $container.find('li.sidebar-nav__item.hidden');
    var $active = $container.find('li.sidebar-nav__item.active');
    var activeText = $active.text();
    $hidden.text(activeText);
    //console.log(activeText);
    $container.on('click', function (e) {
        e.stopPropagation();
        var $this = $(e.target);
        var $label = $(e.target.closest('.sidebar-nav__control'));
        if ($this.hasClass('account__sidebar-nav') || $label) {
            $(this).toggleClass('open');
        }
    });
    $('body').on('click', function () {
        $container.removeClass('open');
    });
}

function addBr(selector) {
    if (window.innerWidth < 1920) {
        var $target = $('body').find(selector).eq(0);
        var text = $target.text();
        var newText = text.replace('.', '.<br>');
        $target.html(newText);
    }
    if (window.innerWidth < 1200) {
        var $target = $('body').find(selector).eq(1);
        var text = $target.text();
        var newText = text.replace(' ', '<br>');
        $target.html(newText);
    }
}

function closeAlert() {
    $('body').on('click', function () {
        $(this).find('div.alert').fadeOut(1000);
    });
}

function initPopupSelect(selector) {
    $(selector).hide();
    $(selector).parent().find('label.control').hide();
    $(selector).select2();
    $(selector).on('select2:open', function (e) {
        $('.select2-container').find('input.select2-search__field').focus();
        $('.select2-container').find('input.select2-search__field').attr('placeholder', 'Введите название');
        $('.select2-results__options').attr('data-simplebar', 'data-simplebar');
    });
    $('body').on('keyup', 'input.select2-search__field', function () {
        new SimpleBar($('.select2-results__options')[0]);
    });
}

function initActiveTopMenu() {
    var path = location.href.replace(location.origin, '');

    $('.topmenu-block a').each(function () {
        var curpath = $(this).attr('href');
        curpath = curpath.replace(location.origin, '');
        if (curpath == path) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });
    var $icon = $('nav.top-nav.row').find('div.user.user-icon');
    var $link = $icon.closest('a');
    var icon_curpath = $link.attr('href');
    icon_curpath = icon_curpath.replace(location.origin, '');

    if (icon_curpath == path) {
        $link.addClass('active');
    } else {
        $link.removeClass('active');
    }
}

function initMainPopup() {
    var $wrapCart = $('header.header').find('div.cart-popup-wrapper');
    var $wrapWish = $('header.header').find('div.dropdown.wishlist');
    $headerWrapper = $('header.header').find('div.header__nav-wrapper');
    if (window.innerWidth < 1024) {
        $wrapCart.off('click');
        $wrapWish.off('click');
        smallDeviceToggle('div.cart-popup-wrapper');
        smallDeviceToggle('div.dropdown.wishlist');
    } else if (window.innerWidth >= 1024) {
        $wrapCart.off('click');
        $wrapWish.off('click');
        toggleCartPopup('div.cart-popup-wrapper');
        toggleWishPopup('div.dropdown.wishlist');
        toggleAccount();
    }
    $(window).on('resize', function (e) {
        e.stopPropagation();
        //console.log(window.innerWidth);
        if (window.innerWidth < 1024) {
            $wrapCart.off('click');
            $wrapWish.off('click');
            smallDeviceToggle('div.cart-popup-wrapper');
            smallDeviceToggle('div.dropdown.wishlist');
        } else {
            $wrapCart.off('click');
            $wrapWish.off('click');
            toggleCartPopup('div.cart-popup-wrapper');
            toggleWishPopup('div.dropdown.wishlist');
            toggleAccount();
        }
    });

    function blockHeader() {
        $headerWrapper.addClass('blocked');
    }

    function unBlockHeader() {
        $headerWrapper.addClass('back');
        $headerWrapper.removeClass('blocked');
    }

    function smallDeviceToggle(selector) {
        $(selector).on('click', function (e) {
            var target = e.target.closest('.main-icon__icon-holder');
            if (target.classList.contains('wishlist')) {
                location.href = '/index.php?route=account/wishlist';
            }
            if (target.classList.contains('bucket-empty')) {
                location.href = '/index.php?route=checkout/cart';
            }
        });
    }

    function toggleCartPopup(selector) {
        var $wrap = $('header.header').find(selector);
        $wrap.on('click, mouseover', function (e) {
            e.stopPropagation();
            $('.drop-menu__core')[0].checked = false;
            $('div.dropcontent.show').removeClass('show');
            $('header.header').find('.user__dropcontent.show').removeClass('show');
            $wrap.find('div.dropcontent').addClass('show');
            blockHeader();
        });
        $wrap.on('click', 'button.close', function (e) {
            e.stopPropagation();
            var $pop = $wrap.find('div.dropcontent');
            $pop.addClass('force-hide');
            // unBlockHeader();
            setTimeout(function () {
                $pop.removeClass('force-hide');
            }, 500);
        })
        $wrap.on('mouseleave', 'div.bucket-empty__detail', function () {
            $wrap.find('div.dropcontent').removeClass('show');
            // unBlockHeader();
        })
        $('body').on('click', function () {
            $wrap.find('div.dropcontent').removeClass('show');
            // unBlockHeader();
        });
    }

    function toggleWishPopup(selector) {
        var $wrap = $('header.header').find(selector);
        $wrap.on('click, mouseover', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $('.drop-menu__core')[0].checked = false;
            $('div.dropcontent.show').removeClass('show');
            $('header.header').find('.user__dropcontent.show').removeClass('show');
            $wrap.find('div.dropcontent').addClass('show');
            blockHeader();
        });
        $wrap.on('click', 'button.close', function (e) {
            e.stopPropagation();
            var $pop = $wrap.find('div.dropcontent');
            $pop.addClass('force-hide');
            // unBlockHeader();
            setTimeout(function () {
                $pop.removeClass('force-hide');
            }, 500);
        })
        $wrap.on('mouseleave', 'div.wish-cart__detail', function () {
            $wrap.find('div.dropcontent').removeClass('show');
            // unBlockHeader();
        })
        $('body').on('click', function () {
            $wrap.find('div.dropcontent').removeClass('show');
            // unBlockHeader();
        });
    }

    function toggleAccount() {
        var $user_content = $('header.header').find('.user__dropcontent');
        var $wrap = $user_content.closest('.main-icon__icon-holder');
        $wrap.on('mouseover', function () {
            $('.drop-menu__core')[0].checked = false;
            $('div.dropcontent.show').removeClass('show');
            $user_content.addClass('show');
        });
        $user_content.on('mouseleave', function () {
            $user_content.removeClass('show');
        });
        $('body').on('click', function () {
            $user_content.removeClass('show');
        });
    }
}

function toggleDiscont() {
    $('div.discont__dis-table-small.dis-table-small').on('click', 'div.toggle-category', function (e) {
        $('div.discont__dis-table-small.dis-table-small').find('div.toggle-category.show').not(this).removeClass('show');
        $(this).toggleClass('show');
    });
}

// var countf = 0;

function validate_check_phone($input, placehold) {
    var val = $input.val();

    if (!(/[1-9]{1}\d{1}[ ]\d{3}[ ]\d{4}/).test($input.val())) {
        $input.closest('.intl-tel-input').addClass('phone-error');
        return false;
    }

    placehold = placehold.replace(/\d/g, '9');
    val = val.replace(/\d/g, '9');

    if (val == placehold) {
        $input.closest('.intl-tel-input').removeClass('phone-error');
        return true;
    }

    $input.closest('.intl-tel-input').addClass('phone-error');

    return false;
}

function check_phone($form) {
    var $elem = $form.find('.phone_input_checked');

    if (!$elem.length)
        return true;

    if ($elem.val().length < 7)
        return false;

    if ($elem.closest('.intl-tel-input').hasClass('phone-error'))
        return false;

    var placehold = $elem.attr('placeholder');
    if (typeof placehold === 'undefined')
        return false;

    return validate_check_phone($elem, placehold);
}

function check_validate($form, first = false) {
    var ret = 0;

    $form.find('div.error').each(function () {
        if (typeof $(this).attr('style') == 'undefined')
            ret = 1;
    });

    if (ret)
        return false;

    return true;
}

function paintAfterActiveStager() {
    var $links = $('div.stagger.cart__stagger').find('a.stagger__link');
    $links.each(function (i, el) {
        var $this = $(el);
        if ($this.hasClass('active')) {
            return false;
        } else {
            $this.addClass('passed');
        }
    });
}

function initPhoneMask() {
    var $phone = $('main.main').find('input[type=tel]');
    var placehold;
    var intId;
    //console.log($phone);
    $phone.each(function (i, el) {
        // intId = setInterval(function(){
        //console.log(el);
        //   placehold = $(el).attr('placeholder');
        //   if(placehold) {
        //     console.log(placehold + ': ' + i);
        //     // placehold = placehold.replace(/\d/g, '9');
        //     // $(el).inputmask(placehold);
        //     clearInterval(intId);
        //   }
        // }, 50);
    });
}

function contactAddress() {
    var contact = $('section.contacts--contacts');
    if (!contact.length) return;
    var address = contact.find('.contacts__text a.address').text();
    var address = address.split(',');
    var part1 = address[0] + ', ' + address[1];
    var part2 = '';
    for (var i = 0; i < address.length - 1; i++) {
        if (i > 1) {
            part2 += address[i] + ', ';
        }
    }
    part2 += address[address.length - 1];
    contact.find('.contacts__text a.address').html('<div>' + part1 + '</div><div>' + part2 + '</div>');
}

$(document).ready(function () {
    paintAfterActiveStager();
    closeAlert();
    SlidersInit();
    ckeckInputValue();
    toggleDiscont();
    blockHeaderByMenu();
//'.dropdown.bucket-empty',
    initMainPopup();
    //initOpenCartByMoneyBlock();
    fixedHeader();
    initGetUpButton();

    initAddCart();
    // initPopupSelect('#languageDropSelect');
    // initPopupSelect('#currencyDropSelect');
    // initPopupSelect('#languageTopSelect');
    // initPopupSelect('#currencyTopSelect');
    initSelect('#languageDropSelect');
    initSelect('#currencyDropSelect');
    initSelect('#languageTopSelect');
    initSelect('#currencyTopSelect');

    closeMenu();
    productQuantity();

    footerSubscribe();

    addBr('p.banner__text');

    initActiveTopMenu();

    contactAddress();
    //$("#phone").inputmask('+99 (999) 999-99-99');
});

$('.wishlist-wrapper').on('click', '.c-info__like', function (e) {
    var $like = $(this);

    var product_id = $like.attr('data-pid');
    wishlist.remove(product_id);
    $like.removeClass('active');

    if ($('.card__like[data-pid="' + product_id + '"]').length) {
        $('.card__like[data-pid="' + product_id + '"]').removeClass('active');
    }
});

$('.card__like').on('click', function (e) {
    var $like = $(e.target.closest('.card__like'));
    var product_id = $like.attr('data-pid');

    if ($like.hasClass('active')) {
        wishlist.remove(product_id);
        $like.removeClass('active');
    } else {
        wishlist.add(product_id);
        $like.addClass('active');
    }
});

$('.seo_more_generator').on('click', function () {
    let textMore = $(this).data('textMore');
    let textHide = $(this).data('textHide');
    $(this).parent().find('#seo_text_generator').toggleClass('seo_show_generator');
    if ($(this).parent().find('#seo_text_generator').hasClass('seo_show_generator')) {
        $(this).html(textHide);
    } else {
        $(this).html(textMore);
    }
});

$('.seo_more_place').on('click', function () {
    let textMore = $(this).data('textMore');
    let textHide = $(this).data('textHide');
    $(this).parent().find('#seo_text_place').toggleClass('seo_show_place');
    if ($(this).parent().find('#seo_text_place').hasClass('seo_show_place')) {
        $(this).html(textHide);
    } else {
        $(this).html(textMore);
    }
});
if ($('#seo_text_place').is(':empty')) {
    $('.seo_more_place').hide();
}
