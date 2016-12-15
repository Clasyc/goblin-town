$('a.accept-order').confirm({
    title: 'Patvirtinimas',
    icon: 'glyphicon glyphicon-book',
    content: 'Patvirtinti užsakymą?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
        },
        Ne: function(){

        }

    }
});

$('a.remove-order').confirm({
    title: 'Atmetimas',
    icon: 'glyphicon glyphicon-remove',
    content: 'Atmesti užsakymą?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
        },
        Ne: function(){

        }

    }
});

$('a.confirm-order').confirm({
    title: 'Grąžinimas',
    icon: 'glyphicon glyphicon-ok',
    content: 'Patvirtinti knygos grąžinima?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
        },
        Ne: function(){

        }

    }
});

$('a.debt-order').confirm({
    title: 'Skola',
    icon: 'glyphicon glyphicon-euro',
    content: 'Sudaryti skolą?',
    buttons: {
        Taip: function(){
            location.href = this.$target.attr('href');
        },
        Ne: function(){

        }

    }
});