$("#contactForm").validate({
    rules: {
        uname: {
            required: true,
            minlength: 3
        },
        surname: {
            required: true
        },
        email: {
            required: true,
            email:true
        },
        phone: {
            required: true,
            minlength: 12
        },
        password: {
            required: true,
            minlength: 6
        }
    },
    messages: {
        uname:{
            required: "Enter a your name",
            minlength: "Enter at least 3 characters"
        },
        surname: {
            required: "Enter a your surname",
        },
        email: {
            required: "Enter a your email address",
            email: "Enter a valid email address"
        },
        phone: {
            required: "Enter your phone number"
        },
        password: {
            required: "Enter your password",
            minlength: "Enter at least 6 characters"
        }
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }
});

$('input.contacts__input').each( (index, el) => {
    el.addEventListener('change', (e) => {
        console.log(e.target.value.length);
        if(e.target.value.length === 0) {
            e.target.nextSibling.nextSibling.classList.add('empty');
            e.target.nextSibling.nextSibling.classList.remove('has');
        } else {
            e.target.nextSibling.nextSibling.classList.remove('empty');
            e.target.nextSibling.nextSibling.classList.add('has');
        }
    });
});

$('#passVisible').mousedown( () => {
    $('#pass').attr('type', 'text');
});

$('#passVisible').mouseup( () => {
    $('#pass').attr('type', 'password');
});

$('#passVisible').on('touchstart', () => {
    $('#pass').attr('type', 'text');
});

$('#passVisible').on('touchend', () => {
    $('#pass').attr('type', 'password');
});
