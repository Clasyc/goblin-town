

$(document).ready(function(){

    $('.form-registration').hide();

    $('.message a').click(function(){
        $('.form-login').animate({height: "toggle", opacity: "toggle"}, "slow");
        $('.form-registration').slideDown();
    });

});
