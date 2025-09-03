function pdfPrepare() {

  var table = document.querySelector(".order-align");

    $('.order.align-product').hide();
    $('.order-details__btn-holder').hide();
    $('.main-info.main-info--center.order-details__main-info').hide();

    //$(".order-align").replaceWith(table);


  html2canvas(table).then(canvas => {
        var img    = canvas.toDataURL("image/png");
        $('#pdfContain').val(img);

        $('.order.align-product').show();
        $('.order-details__btn-holder').show();
        $('.main-info.main-info--center.order-details__main-info').show();
  });

  $('body').on('click', '.toPdf', function(e){
    e.preventDefault();
    $('#pdfform').submit();
  })
}

$(document).ready(function(){
  toggleAccount();
  pdfPrepare();
});