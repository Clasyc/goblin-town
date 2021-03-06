/**
 * Created by Clasyc on 10/12/2016.
 */
$(document).ready(function(){
    $('.wishlist-toggle-btn').click(function(){
        var book = $(this).attr("data-book");
        toogleBookToWishlist(book);
    });
});



function toogleBookToWishlist(id) {

    var data = {book: id};
    $.ajax({
        type: "GET",
        url: update_url.toString(),
        data: data,
        dataType: 'json',
        success: function (response) {
            if(response.empty){
                $( "a[data-book='"+id+"']" ).find("span").removeClass("glyphicon-star-empty").addClass("glyphicon-star");
            }else{
                $( "a[data-book='"+id+"']" ).find("span").removeClass("glyphicon-star").addClass("glyphicon-star-empty");
            }

        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

$('a.wishlist-toggle-btn').confirm({
    icon: 'glyphicon glyphicon-star-empty',
    content: 'Šalinti knygą iš norų sąrašo?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
            this.$target.parent().parent().parent().slideUp('slow', function(){});
        },
        Ne: function(){
        }
    }
});