
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
/**
 * Created by Clasyc on 14/12/2016.
 */

function checkPopup(active_orders_count, url, id){
    var jc = $.confirm({
        title: 'Skola!',
        icon: 'glyphicon glyphicon-book',
        content: 'Skaitytojo pasiimtų knygų skaičius: '+active_orders_count+'.\n Vistiek šalinti skaitytoją?',
        buttons: {
            Taip: function(){
                deleteReader(id, url);
            },
            Atšaukti: function(){

            }

        }
    });


}

function deleteReader(id, url){
    $(".loader").show();
    var data = {reader: id};
    $.ajax({
        type: "GET",
        url: reader_delete_url.toString(),
        data: data,
        dataType: 'json',
        success: function (response) {
            if(response.deleted == true){
                location.href = url;
            }else{
                var jc = $.confirm({
                    title: 'Klaida!',
                    icon: 'glyphicon glyphicon-book',
                    content: 'Nepavyko pašalinti skaitytojo.',
                    buttons: {
                        Uždaryti: function(){
                            deleteReader(id);
                        }

                    }
                });
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

function deleteCheckReader(id) {

    $(".loader").show();

    var data = {reader: id};
    $.ajax({
        type: "GET",
        url: reader_check_delete_url.toString(),
        data: data,
        dataType: 'json',
        success: function (response) {
            if(response.orders_number > 0){
                $(".loader").hide();
                checkPopup(response.orders_number, response.url, id);
            }else{
                deleteReader(id, response.url);
            }

        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}


$('a.add-penalty').click(function(){
    checkForPenalty($(this).attr("data-reader"), $(this).attr("data-reader-name"), $(this));
});
$('body').on('focus',".penalty-date", function(){
    $(this).datepicker({
        format: 'yyyy-mm-dd'
    });
});


function checkForPenalty(id, reader_name, obj) {
    var typ = "check";
    var data = {reader: id, type: typ};
    $.ajax({
        type: "GET",
        url: reader_check_penalty_url.toString(),
        data: data,
        dataType: 'json',
        success: function (response) {
            if(response.status == "empty"){
                alert("empty");
            }else if(response.status == "active"){
                alert("active");
            }else if(response.status == "ok"){
                var p_id = response.id;
                var r_name = response.name;
                $.confirm({
                    icon: 'glyphicon glyphicon-ban-circle',
                    title: "Pridėti nuobaudą",
                    content: '<div class="penalty-container" style="margin: 10px;"><input type="text" class="form-control" value="'+response.name+'" disabled>'+
                    '<hr>Nuobauda iki:<div class="input-group date"><input type="text" id="penaltyDate" data-toggle="datepicker" class="form-control penalty-date"><span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span></div>'+
                    '<hr>Pavadinimas:<input type="text" id="penaltyName" class="form-control">'+
                    'Komentaras:<input type="text" id="penaltyComment" class="form-control">'+

                    '</div>',
                    buttons: {
                        Pridėti: function(){
                            var date = this.$content.find('#penaltyDate').val();
                            var name = this.$content.find('#penaltyName').val();
                            var comment = this.$content.find('#penaltyComment').val();
                            addPenalty(obj, id, date, name, comment, r_name, p_id);
                        },
                        Atšaukti: function(){

                        }

                    }
                });

            }else{
                alert("Something went wrong.");
            }

        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

function addPenalty(obj, id, date, title, comment, reader_name, penalty_id){
    $(".loader").show();
    var typ = "delete";
    var data = {reader: id, type: typ, date: date, name: title, comment: comment};
    $.ajax({
        type: "GET",
        url: reader_check_penalty_url.toString(),
        data: data,
        dataType: 'json',
        success: function (response) {
            $(".loader").hide();
            if(response.status == "error"){
                $.confirm({
                    title: "Klaida!",
                    content: "Nepavyko įterpti nuobaudos",
                    closeIcon: true
                });
            }else if(response.status == "ok"){
                changeReaderElement(obj, id, reader_name, response.date, title, comment, response.id);
                $.confirm({
                    title: "Nuobauda pridėta!",
                    content: "Nuobauda sėkmingai pridėta skaitytojui "+response.name,
                    closeIcon: true
                });
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

}
function changeReaderElement(obj, reader, reader_name, penalty_date, penalty_name, penalty_comment, penalty_id){
    var par = obj.parent();
    obj.parent().parent().parent().addClass("penalty");
    if(penalty_name == undefined)
        penalty_name = '';
    if(penalty_comment == undefined)
        penalty_comment = '';
    obj.remove();
    var appended = par.append(''+
        ' <a href="#" data-reader="'+reader+'" data-title="Informacija apie nuobaudą" data-reader-name="'+reader_name+'" data-penalty-date="'+penalty_date+'" data-penalty-name="'+penalty_name+'" data-penalty-comment="'+penalty_comment+'" data-penalty-id="'+penalty_id+'" class="btn btn-xs btn-default penalty-info"><span class="glyphicon glyphicon-ban-circle"></span> Šalinti nuobaudą</a>')
        .unbind().confirm({
            icon: 'glyphicon glyphicon-info-sign',
            onOpenBefore: function(){
                this.setContent('Skaitytojas: '+reader_name+'<br>'+
                    '<b>Nuobaudos data: '+penalty_date+'<br></b>'+
                    'Pavadinimas: '+penalty_name+'<br>'+
                    'Komentaras: '+ penalty_comment);
                this.setTitle('Informacija apie nuobaudą');
            },
            buttons:{
                Šalinti: function(){
                    var tar = this.$target;
                    deletePenalty(penalty_id, appended.find("a.penalty-info"), reader);
                },
                Atšaukti: function(){

                }
            }
        });

}
function deletePenalty(id, obj, reader){

    $(".loader").show();
    var data = {penalty: id};
    $.ajax({
        type: "GET",
        url: reader_delete_penalty_url.toString(),
        data: data,
        dataType: 'json',
        success: function (response) {
            $(".loader").hide();
            if(response.deleted == true){
                clearReaderElement(obj, reader);
                $.confirm({
                    title: "Nuobauda panaikinta!",
                    content: "Nuobauda sėkmingai panaikinta!",
                    closeIcon: true
                });
            }else if(response.deleted == false){
                $.confirm({
                    title: "Klaida!",
                    content: "Nepavyko pašalinti nuobaudos.",
                    closeIcon: true
                });
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

function clearReaderElement(obj, reader){
    var par = obj.parent();
    obj.parent().parent().parent().removeClass("penalty");
    obj.remove();
    var appended = par.append('<a href="#" data-title="Pridėti nuobaudą." data-reader="'+reader+'" onclick= "return false;" class="btn btn-xs btn-default add-penalty"><span class="glyphicon glyphicon-ban-circle"></span> Pridėti nuobaudą</a>')
        .unbind().click(function(){
        checkForPenalty(reader, $(this).attr("data-reader-name"), appended.find("a.add-penalty"));
    });

}