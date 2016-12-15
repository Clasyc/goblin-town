
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
            deleteCheckReader(this.$target.attr('data-reader'));
        },
        Ne: function(){
        }
    }
});

$('a.penalty-info').confirm({
    icon: 'glyphicon glyphicon-info-sign',
    onOpen: function(){
        this.setContent('Skaitytojas: '+this.$target.attr('data-reader-name')+'<br>'+
            '<b>Nuobaudos data: '+this.$target.attr('data-penalty-date')+'<br></b>'+
            'Pavadinimas: '+this.$target.attr('data-penalty-name')+'<br>'+
            'Komentaras: '+this.$target.attr('data-penalty-comment'));
    },
    buttons:{
        Šalinti: function(){
            var tar = this.$target;
            deletePenalty(tar.attr('data-penalty-id'), tar, tar.attr("data-reader"));
        },
        Atšaukti: function(){

        }
    }
});