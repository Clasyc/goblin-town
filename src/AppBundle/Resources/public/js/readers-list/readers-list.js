
$('a.edit-reader').confirm({
    icon: 'glyphicon glyphicon-pencil',
    content: 'Redaguoti skaitytojo profilį?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
        },
        Atšaukti: function(){

        }

    }
});


$('a.delete-reader').confirm({
    icon: 'glyphicon glyphicon-trash',
    content: 'Šalinti skaitytoją?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
        },
        Ne: function(){

        }

    }
});