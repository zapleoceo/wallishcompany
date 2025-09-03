
function initProductSlider() {

    var $prodPhoto = $('main.main').find('img.product__photo');
    var owl = $('.product-slider');
    var imgs = owl.find('img');
    var isLoop = true;
    var isNav = false;
    var scroll = 0;

    if(imgs.length >= 3) {
      isLoop = true;
      isNav = true;
      isCenter = true;
      showItems = 3;
    } else {
      isLoop = false;
      isNav = false;
      isCenter = false;
      showItems = 2;
      owl.addClass('not-full');
    }

    owl.on('initialized.owl.carousel', function() {
      owl.css('visibility', 'visible');
      owl.addClass('fadeIn');
    });

    owl.owlCarousel({
      loop: isLoop,
      center: isCenter,
      items: showItems,
      margin: 15,
      nav: isNav,
      dots: false,
      smartSpeed: 500,
      navText: ['<i class="owl-nav__icon"></i>',
          '<i class="owl-nav__icon"></i>'],
      responsiveClass:true,
    });
    owl.trigger('next.owl.carousel');
    owl.on('mousewheel', '.owl-stage', function (e) {
        if (e.originalEvent.deltaY > 0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
        e.preventDefault();
        e.stopPropagation();
    });
    owl.on('click', 'div.owl-item.active', function(e) {
        var startActive = $('div.slider-wrapper div.owl-item.active:first');
        var endActive = $('div.slider-wrapper div.owl-item.active:last');
        var start = $('div.slider-wrapper div.owl-item:first');
        var end = $('div.slider-wrapper div.owl-item:last');
        var items = $('div.slider-wrapper div.owl-item');
        var curent = $(this);
        
        if (curent.index() === startActive.index()) {
            owl.trigger('prev.owl');
            // swapPicture($prodPhoto, curent);
        }

        if (curent.index() === endActive.index()) {
            owl.trigger('next.owl');
            // swapPicture($prodPhoto, curent);
        }

        if (imgs.length < 3) {
          $('div.slider-wrapper div.owl-item .item').removeClass('current');
          curent.find('.item').addClass('current');
          
          swapPicture($prodPhoto, curent);
        }

        // if (curent.index() === start.index() && items.length <= 3) {
        //     swapPicture($prodPhoto, curent);
        // }
        //
        // if (curent.index() === end.index() && items.length <= 3) {
        //     swapPicture($prodPhoto, curent);
        // }

        // if (e.item.count === 1) {
        //
        //     swapPicture($prodPhoto, curent);
        // }

        // swapPicture($prodPhoto, curent);
        e.preventDefault();
        e.stopPropagation();
    });
    owl.on('click', '.owl-nav button', function(e){
        e.stopPropagation();
    });
    owl.on('changed.owl.carousel', function(event) {
        var index = event.item.index;
        //console.log(event.item);

        var $curent = $('.owl-item').eq(index);
        //console.log('changed ' + $curent.index(), $curent);

        var imgPath = $curent.find('.item').attr('data-origin');
        var originPath = $prodPhoto.attr('src');

        $prodPhoto.css('opacity', '0');
        // $curent.find('.item img').css('opacity', '0');

        var $item = $('.owl-item .item');
        var path;

        // $item.each(function(i, el){
        //     path = $(el).attr('data-origin');
        //     if(path === imgPath) {
        //         $(el).attr('data-origin', originPath);
        //         $(el).find('img').attr('src', originPath);
        //     }
        // });

        
        setTimeout(function(){
          $prodPhoto.attr('src', imgPath);
        }, 400);

        setTimeout(function(){
          $prodPhoto.css('opacity', '1');
          // $curent.find('.item img').css('opacity', '1');
        }, 500);
    });

    function swapPicture(prodPhoto, current) {
        var slideItemPath = current.find('.item').attr('data-origin');
        var prodPath = prodPhoto.attr('src');
        var $item = $('.owl-item .item');
        // var path;
        prodPhoto.css('opacity', '0');
        // current.find('img').css('opacity', '0');
        // $item.each(function(i, el){
        //     path = $(el).attr('data-origin');
        //     if(path === slideItemPath) {
        //         $(el).attr('data-origin', prodPath);
        //         $(el).find('img').attr('src', prodPath);
        //     }
        // });
        prodPhoto.attr('src', slideItemPath);

        setTimeout(function(){
            prodPhoto.css('opacity', '1');
            // current.find('img').css('opacity', '1');
        },500);
    }
};

function initProductAddCart() {
    $('.product-controls').on('click', '.product-controls__btn', function(e){
        e.preventDefault();

        var $count = $('.product-controls__counter input');
        //console.log($count);
        var quanity = Number($count.val());

        if ($(this).hasClass('plus')) {
            quanity = quanity + 1;
        }

        if ($(this).hasClass('minus')) {
            quanity = quanity -1;
        }

        if (quanity < $count.data('min')) {
            quanity = $count.data('min');
        }

        $count.val(quanity);
    });

    $('.product-controls').on('click', '.product-controls__bucket', function(e){

        e.preventDefault();

        var product_id = $('.product-controls__bucket').data('productId');
        var $count = $('.product-controls__counter input');
        var quanity = Number($count.val());

        cart.add(product_id, quanity);
    });
};
function openCategory(){
  var $container = $('div.holiday-sidebar');
  $container.on('click', 'label.sidebar__control, span.sidebar__link', function(e){

    var $this = $(this);
    var $content = $(this.closest('li.sidebar__item')).find('ul.sub-items');
    var length = $content[0].children.length;

    if($this.hasClass('sidebar__control')) {
      toggleOpenLabel();
    } else {
      toggleOpenContainer();
    }
    function toggleOpenContainer() {
      if($content.hasClass('open')) {
        $content.removeClass('open');
        $content.css('height', '0px');
        //$content.css('marginTop', '0');
        $this.closest('li.sidebar__item').find('label.sidebar__control').removeClass('sidebar__control--open');
      } else {
        closeAll();
        $content.addClass('open');
        $content.css('height', length * 45 + 'px');
        //$content.css('marginTop', '15px');
        $this.closest('li.sidebar__item').find('label.sidebar__control').addClass('sidebar__control--open');
      }
    }
    function toggleOpenLabel() {
      if($content.hasClass('open')) {
        $content.removeClass('open');
        $content.css('height', '0px');
       // $content.css('marginTop', '0');
        $this.removeClass('sidebar__control--open');
      } else {
        closeAll();
        $content.addClass('open');
        $content.css('height', length * 45 + 'px');
        //$content.css('marginTop', '15px');
        $this.addClass('sidebar__control--open');
      }
    }
    function closeAll() {
      var $openedContent = $container.find('ul.sub-items');
      var $control = $container.find('label.sidebar__control.sidebar__control--open');
      $openedContent.removeClass('open');
      $openedContent.css('height', '0px');
      //$openedContent.css('marginTop', '0');
      $control.removeClass('sidebar__control--open');
    }
  });
}
function openCategoryTop(){
  var $container = $('div.top-drop');
    $container.on('click', 'li.sidebar__item', function(e){
      e.stopPropagation();
      var $this = $(e.target);
      if($this.hasClass('sidebar__link') || $this.hasClass('sidebar__item') || $this.hasClass('sidebar__control')) {
        var $content = $(this).find('ul.sub-items');
        var $label = $(this).find('label.sidebar__control');
        var length = $content[0].children.length;
        if($content.hasClass('open')) {
          $content.removeClass('open');
          $content.css('height', '0px');
          $label.removeClass('sidebar__control--open');
        } else {
          closeAll();
          $content.addClass('open');
          $content.css('height', length * 30 + 'px');
          $label.addClass('sidebar__control--open');
        }
      }

    function closeAll() {
      var $openedContent = $container.find('ul.sub-items');
      var $control = $container.find('label.sidebar__control.sidebar__control--open');
      $openedContent.removeClass('open');
      $openedContent.css('height', '0px');
      $control.removeClass('sidebar__control--open');
    }
  });
  function toggleWrapper() {
    $('div.top-drop').on('click', function(e) {
      var $this = $(e.target);
      var $label = $(e.target.closest('.top-drop__control'));
      console.log($this, $label);
      if($this.hasClass('top-drop__title') || $this.hasClass('top-drop') || $label.hasClass('top-drop__control')) {
        $(this).find('.top-drop__control').toggleClass('top-drop__control--open');
        $(this).toggleClass('open');
        var $wrapper = $('div.top-drop').find('div.top-drop__wrapper');
        if($wrapper.hasClass('zoomIn')) {
          $wrapper.addClass('zoomOut');
          $wrapper.removeClass('zoomIn');
          setTimeout(function(){
            $('div.top-drop').find('div.top-drop__wrapper').toggle();
          },1000);
        } else {
          $wrapper.addClass('zoomIn');
          $wrapper.removeClass('zoomOut');
          $('div.top-drop').find('div.top-drop__wrapper').toggle();
        }
      }
    });
  }

  toggleWrapper();
}
function initWishlist(){
    $('.like-product').on('click', function(){
        var id = Number($(this).attr('data-pid'));

        if ($(this).hasClass('active')) {
            wishlist.remove(id);
            $(this).removeClass('active');
        } else {
            wishlist.add(id);
            $(this).addClass('active');
        }
    });
}

function sliderChanger() {
  /*var $prodPhoto = $('main.main').find('img.product__photo');
  $('div.slider-wrapper').on('click', 'div.owl-item', function(e){
    var imgPath = $(this).find('div.item[data-origin]').attr('data-origin');
    $prodPhoto.fadeOut(function(){
      $prodPhoto.attr('src', imgPath);
    });
    $prodPhoto.fadeIn();
  });*/
}

function setMargin() {
  var $photo = $('div.def-col').find('div.col-photo.left');
  var $info = $('div.product-info').find('div.product-info__main-holder');
  if($('div.product-info').find('div.product-info__old').hasClass('product-info__old')) {
    $photo.addClass('left--old-price');
    $info.addClass('old-price');
  }
}

function setNumberPagination() {
  var $dots = $('#similar-products').find('button.owl-dot');
  $dots.each(function(i, el) {
    if(i >= 9) {
      $(el).addClass('normal');
      $('#similar-products .owl-dots').addClass('bottom');
    }
  });
}
function setCardWidth() {
  $('#similar-products').addClass('widder');
}
function paginationCentr(){
  var length = $('#similar-products').find('button.owl-dot').length;
  var left = 'calc(50% - ' + Math.floor( (length * 30) / 2)  + 'px)';
  $('#similar-products').find('div.owl-dots').css('left', left);
}
function isProductSliderExist() {
  if($('div.slider-wrapper').length === 0 || $('div.slider-wrapper div.product-slider ').length === 0) {
    $('div.col-info').find('div.product-info__main-holder.old-price').addClass('margin-none');
    $('div.col-info').find('div.product-info__main-holder').addClass('slider-none');
  }
}
function initClipText() {
  var $prod_nav_prev = $('div.product-nav').find('a.product-nav__prev span.text');
  var $prod_nav_next = $('div.product-nav').find('a.product-nav__next span.text');

  var sliced_prev_origin = [], sliced_next_origin = [];
  $prod_nav_prev.each(function(i, el){
    sliced_prev_origin.push( $(el).eq(i).text() );
  });
  $prod_nav_next.each(function(i, el){
    sliced_next_origin.push( $(el).eq(i).text() );
  });

  var sliced_prev = substrAll($prod_nav_prev);
  var sliced_next = substrAll($prod_nav_next);

  if(window.innerWidth < 960) {
    $prod_nav_prev.each(function(i, el){
      $(el).text(sliced_prev[i]);
    });
    $prod_nav_next.each(function(i, el){
      $(el).text(sliced_next[i]);
    });
  }
  $(window).resize(function(){
    if(window.innerWidth < 960) {
      $prod_nav_prev.each(function(i, el){
        $(el).text(sliced_prev[i]);
      });
      $prod_nav_next.each(function(i, el){
        $(el).text(sliced_next[i]);
      });
    } else {
      $prod_nav_prev.each(function(i, el){
        $(el).text(sliced_prev_origin);
      });
      $prod_nav_next.each(function(i, el){
        $(el).text(sliced_next_origin);
      });
    }
  });
  function substrAll(array) {
    var text = [];
    array.each(function(i, el){
      text.push( substrFirstWord( $(el).text() ) );
    });
    return text;
  }
  function substrFirstWord(str) {
    var tmpStr = str.split(' ');
    tmpStr[0] = tmpStr[0].substr(0, 4);
    tmpStr = tmpStr.join('. ');
    return tmpStr;
  }
}
$(document).ready(function() {
  setMargin();
  initProductSlider();
  initProductAddCart();
  openCategory();
  openCategoryTop();
  sliderChanger();
  initWishlist();
  initClipText();
  isProductSliderExist();
  var Owl = $('section.category.container').find('#similar-products');
  Owl.on('initialized.owl.carousel', function() {
    Owl.css('visibility', 'visible');
    Owl.addClass('fadeIn');
  });
  $(window).resize( function(){
    Owl.on('resized.owl.carousel', function() {
      setNumberPagination();
      paginationCentr();
    });
  });
  Owl.owlCarousel({
    autoPlay: 3000,
    loop:true,
    center: true,
    items: 3,
    margin: 20,
    slideBy: 3,
    nav: true,
    dots: false,
    navText: ['<img class="owl-nav__icon" src="/templ/img/icons/arrow-small.svg" />',
            '<img class="owl-nav__icon" src="/templ/img/icons/arrow-small.svg" />'],
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav: false,
                dots: false,
                slideBy: 1,
                mouseDrag: false,
                touchDrag: true
            },
            640:{
                items:2,
                center: false,
                nav: false,
                dots: false,
                slideBy: 2,
                mouseDrag: false,
                touchDrag: true
            },
            960:{
                items:3,
                nav: false,
                dots: false,
                slideBy: 3,
                mouseDrag: false,
                touchDrag: true
            },
            1200:{
                items:3,
                nav:true,
                dots: false,
                slideBy: 3,
                mouseDrag: true,
                touchDrag: false
            },
            1920:{
              items:4,
              nav:true,
              dots: false,
              slideBy: 4,
              mouseDrag: true,
              touchDrag: false,
              center: false,
            }
        }
  });
  setNumberPagination();
  setCardWidth();
  paginationCentr();
});