var t;
$('.cart-page').on('click', '.quantity__minus, .quantity__plus', function () {

    var $count = $(this).closest('.quantity').find('.quantity__text input');
    var quanity = Number($count.val());

    if ($(this).hasClass('quantity__minus')) {
        quanity = quanity - 1;
    }

    if ($(this).hasClass('quantity__plus')) {
        quanity = quanity + 1;
    }

    if (quanity < $count.data('min')) {
        quanity = Number($count.data('min'));
    }

    $count.val(quanity);

    // console.log($count.data('key'));

    update_quanity($count);

});

function update_quanity_all(inp = false) {

    if (inp !== false) {
        var key = inp.attr('data-key');
        var quantity = inp.val();

        cart.update(key, quantity);

        return true;
    }

    var $inputs = $('#formCart').find('.quantity__text input');

    $inputs.each(function () {
        var key = $(this).attr('data-key');
        var quantity = $(this).val();

        cart.update(key, quantity);
    });
}

$('.cart-page').on('change', '.quantity input', function (e) {
    update_quanity($(e.target));
});

function update_quanity(inp = false) {
    // remember window position before reloading page
    sessionStorage.setItem('scrollTop_cart', `${window.scrollY}`);

    if (inp !== false) {
        var key = inp.attr('data-key');
        var quantity = inp.val();

        cart.updateBig(key, quantity);

        return true;
    } else {
        var $inputs = $('#formCart').find('.quantity__text input');

        $inputs.each(function () {
            var key = $(this).attr('data-key');
            var quantity = $(this).val();
    
            //cart.updateBig(key, quantity);
            setTimeout(cart.updateBig, 150, key, quantity);
        });
    }

    // clearTimeout(t);
    //
    // t = setTimeout(function () {
    //     $('#formCart').submit();
    // }, 10); // 500
}

$('.cart-page').on('click', '.remove', function () {
    if (!confirm('Удалить ?'))
        return false;

    var id = Number($(this).attr('data-id'));

    if (!id)
        return false;

    cart.remove(id);

    $(this).closest('tr').hide(300, function () {
        $(this).remove();

        productQuantity();

        if ($('form#formCart').length !== 0)
            location.reload();
    });

    return false;
});