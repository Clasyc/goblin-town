$(document).ready(function() {

    var pressedButton;

    $('form.accept-order-form, form.reject-order-form, form.accept-return-form').click(function(e) {
        e.preventDefault();
        pressedButton = $(this);
    })

    $('.accept-order-form').confirm({
        title: 'Patvirtinimas',
        icon: 'glyphicon glyphicon-book',
        content: 'Patvirtinti užsakymą?',
        buttons: {
            Taip: function () {
                pressedButton.submit();
            },
            Ne: function () {

            }

        }
    });

    $('.reject-order-form').confirm({
        title: 'Atmetimas',
        icon: 'glyphicon glyphicon-remove',
        content: 'Atmesti užsakymą?',
        buttons: {
            Taip: function () {
                pressedButton.submit();
            },
            Ne: function () {

            }

        }
    });
});