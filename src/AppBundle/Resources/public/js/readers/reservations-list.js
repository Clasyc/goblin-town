$(document).ready(function() {

    var pressedButton;

    $('form.cancel-reservation-form').click(function(e) {
        e.preventDefault();
        pressedButton = $(this);
    })

    $('.cancel-reservation-form').confirm({
        title: 'Patvirtinimas',
        icon: 'glyphicon glyphicon-remove',
        content: 'Patvirtinti rezervacijos panaikinimą?',
        buttons: {
            Taip: function () {
                pressedButton.submit();
            },
            Ne: function () {

            }
        }
    });
});