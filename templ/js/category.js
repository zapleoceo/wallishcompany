// function initDropDown() {
//   function toggleControl() {
//     $('div.top-drop').find('ul.sidebar.category__sidebar').find('label.sidebar__control').on('click', function() {
//       $('div.top-drop').find('ul.sub-items.open').removeClass('open');
//       $('div.top-drop').find('label.sidebar__control.sidebar__control--open').removeClass('sidebar__control--open');
//       var $this = $(this);
//       var $content = $(this.closest('li.sidebar__item')).find('ul.sub-items');
//       $this.toggleClass('sidebar__control--open');
//       if($content.hasClass('open')) {
//         $content.removeClass('open');
//       } else {
//         $content.addClass('open');
//       }
//     });
//   }

//   function toggleWrapper() {
//     $('div.top-drop').find('label.top-drop__control').on('click', function() {
//       $(this).toggleClass('top-drop__control--open');
//       var $wrapper = $('div.top-drop').find('div.top-drop__wrapper');
//       if($wrapper.hasClass('zoomIn')) {
//         $wrapper.addClass('zoomOut');
//         $wrapper.removeClass('zoomIn');
//         setTimeout(function(){
//           $('div.top-drop').find('div.top-drop__wrapper').toggle();
//         },1000);
//       } else {
//         $wrapper.addClass('zoomIn');
//         $wrapper.removeClass('zoomOut');
//         $('div.top-drop').find('div.top-drop__wrapper').toggle();
//       }
//     });
//   }

//   toggleWrapper();
//   toggleControl();
// }

function openCategoryTop(){
  var $container = $('div.top-drop');
    $container.on('click', 'li.sidebar__item', function(e){
      e.stopPropagation();
      var $this = $(e.target);
      if($this.hasClass('sidebar__item') ||
       $this.hasClass('sidebar__control') ||
       $this.hasClass('sidebar__link')) {
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
function openCategory(){
  var $container = $('div.d-xl-block.d-lg-block.d-none.col-xl-2.col-3');
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
        $content.css('height', length * 35 + 'px');
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
        $content.css('height', length * 35 + 'px');
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
function filterCategory(sharesId) {
  var locationPath = location.href;
  var $shares = document.querySelector(sharesId);
  var filter = $shares.dataset.filter;
  if(locationPath.indexOf(filter + '=1') !== -1) {
    $($shares).attr('checked', 'checked');
  }
  $(sharesId).on('change', function() {
    var locationPath = location.href;
    if(this.checked) {
      if(locationPath.indexOf('?') === -1) {
        location.href = locationPath +  '?' + this.dataset.filter + '=1';
      } else {
        location.href = locationPath + '&' + this.dataset.filter + '=1';
      }
    } else {
      location.href = locationPath.replace('?' + this.dataset.filter + '=1', '').replace('&' + this.dataset.filter + '=1', '');
    }
  });
}
function filterAllProd() {
  var loc = location.href;
  var $btn = $('#allprod');
  if(loc.indexOf('?limit=300') !== -1) {
    $btn.attr('checked', 'checked');
  }
  $btn.on('change', function(){
    console.log('changed');
    if(this.checked) {
      if(loc.indexOf('?limit=300') === -1) {
        location.href = location.pathname + '?limit=300';
      } else {
        location.href = loc.replace('?limit=300', '');
      }
    } else {
      location.href = loc.replace('?limit=300', '');
    }
  });
}

function initFilters() {
  filterCategory('#sharesNew');
  filterCategory('#sharesSale');
  filterAllProd();
}

$(document).ready(function(){
    initSelect('.select-size');
    //initDropDown();

    initFilters();
    openCategory();
    openCategoryTop();

    $('.select-size').on('change', function(){
      location.href = $(this).val();
    });

    var $active = $('.category__sidebar .sub-items__item.act');
    if ($active.length)
        $active.closest('.sidebar__item').find('.sidebar__control').click();
});