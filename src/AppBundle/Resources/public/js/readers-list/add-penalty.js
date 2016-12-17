

$('a.add-penalty').click(function(){
    checkForPenalty($(this).attr("data-reader"), $(this).attr("data-reader-name"), $(this));
    console.log("TEST: ");
    console.log($(this));
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
                console.log("KURVA"+p_id+" "+r_name);
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
    console.log(id+" "+date+" "+title+" "+comment+" "+reader_name+" "+penalty_id);
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
            //console.log(response.status);
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

}
function changeReaderElement(obj, reader, reader_name, penalty_date, penalty_name, penalty_comment, penalty_id){
    //console.log("OBJ: "+reader);
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