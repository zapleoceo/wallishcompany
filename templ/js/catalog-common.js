function initDropDown() {
  function toggleControl() {
    $('div.top-drop').find('ul.sidebar.category__sidebar').find('label.sidebar__control').on('click', function() {
      $('div.top-drop').find('ul.sub-items.open').removeClass('open');
      $('div.top-drop').find('label.sidebar__control.sidebar__control--open').removeClass('sidebar__control--open');
      var $this = $(this);
      var $content = $(this.closest('li.sidebar__item')).find('ul.sub-items');
      $this.toggleClass('sidebar__control--open');
      if($content.hasClass('open')) {
        $content.removeClass('open');
      } else {
        $content.addClass('open');
      }
    });
  }

  function toggleWrapper() {
    $('div.top-drop').find('label.top-drop__control').on('click', function() {
      $(this).toggleClass('top-drop__control--open');
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
    });
  }

  toggleWrapper();
  toggleControl();
}

function openCategory(){
  var $container = $('div.d-xl-block.d-lg-block.d-none.col-xl-2.col-3');
    $container.find('label.sidebar__control').on('click', function(){
    var $this = $(this);
    var $content = $(this.closest('li.sidebar__item')).find('ul.sub-items');
    var length = $content[0].children.length;

    if($content.hasClass('open')) {
      $content.removeClass('open');
      $content.css('height', '0px');
      $this.removeClass('sidebar__control--open');
    } else {
      closeAll();
      $content.addClass('open');
      $content.css('height', length * 30 + 'px');
      $this.addClass('sidebar__control--open');
    }

    function closeAll() {
      var $openedContent = $container.find('ul.sub-items');
      var $control = $container.find('label.sidebar__control.sidebar__control--open');
      $openedContent.removeClass('open');
      $openedContent.css('height', '0px');
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

function initFilters() {
  filterCategory('#sharesNew');
  filterCategory('#sharesSale');
}