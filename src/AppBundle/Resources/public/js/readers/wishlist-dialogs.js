
$('a.wishlist-toggle-btn').confirm({
    icon: 'glyphicon glyphicon-star-empty',
    content: 'Šalinti knygą iš norų sąrašo?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
            this.$target.parent().parent().parent().slideUp('slow', function(){ $target.remove(); });
        },
        Ne: function(){

        }

    }
});