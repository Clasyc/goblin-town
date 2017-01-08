$(document).ready(function(){

    var btn = $('.show-filters');
    btn.click(function(){
        $(this).parent().find(".filter-invisible").slideDown();
    });

});