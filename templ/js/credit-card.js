$('#sidebar-nav__control').on('click', (e) => {
    if ( $('.sidebar-nav').hasClass('open') ) {
        $('.sidebar-nav').removeClass('open');
        $('.sidebar-nav').css('height', '46px');
        $('.sidebar-nav').css('backgroundColor', '#fff');
        $('.sidebar-nav__control').removeClass('open');
    } else {
        $('.sidebar-nav').addClass('open');
        $('.sidebar-nav').css('height', '300px');
        $('.sidebar-nav__control').addClass('open');
    }
});

$('.sidebar-nav__item').each( (i, el) => {
    el.addEventListener('click', (e) => {
        const target = e.target.closest('.sidebar-nav__item');
        const log = target.classList.contains('active');
        if (log) {
            $('.sidebar-nav__item').removeClass('active');
            $('.sidebar-nav__control .icon').removeClass('marked');
        } else {
            $('.sidebar-nav__item').removeClass('active');
            $('.sidebar-nav__control .icon').addClass('marked');
            target.classList.add('active');
        }
    });
});

//################### show hide address input ukraine address 5/23/2018
function openAddForm (selector) {
  $(selector).on('click', e => {
    const target = e.target;
    const children = [].slice.call(e.target.closest('.row').children);
    const editForm = children[2];
    const wrapper = editForm.children.item(0);
    const dCards = children.slice(3, children.length);
    $(dCards).css('opacity', '0');
    $(editForm).css('display', 'block');
    $(editForm).css('height', 'initial');
    $(wrapper).css('opacity', '1');
  });
}
function closeAddForm (selector) {
  $(selector).on('click', e => {
    const children = [].slice.call(e.target.closest('.row').children);
    const editForm = children[2];
    const dCards = children.slice(3, children.length);
    const wrapper = editForm.children.item(0);
    $(dCards).css('opacity', '1');
    $(wrapper).css('opacity', '0');
    setTimeout( () => {
      $(editForm).css('height', '0px');
      $(editForm).css('display', 'none');
    }, 300);
  });
}
function openEditForm (selector) {
  $(selector).on('click', e => {
    const target = e.target;
    const children = [].slice.call(e.target.closest('.row').children);
    const editForm = children[2];
    const wrapper = editForm.children.item(0);
    const dCards = children.slice(3, children.length);
    $(dCards).css('opacity', '0');
    $(editForm).css('display', 'block');
    $(editForm).css('height', 'initial');
    $(wrapper).css('opacity', '1');
  });
}
openAddForm('#addCard');
openEditForm('.edit');

closeAddForm('#closeCardEditing');