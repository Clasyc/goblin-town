
$('a.delete-book').confirm({
    title: "Knygos šalinimas",
    icon: 'glyphicon glyphicon-trash',
    content: 'Tikrai šalinti knygą?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
        },
        Ne: function(){
        }
    }
});