function deletePenalty(id, obj, reader){

    $(".loader").show();
    console.log("penalty id: "+id);
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
            console.log(response.status);
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

function clearReaderElement(obj, reader){
    console.log("OBJ: "+reader);
    var par = obj.parent();
    obj.parent().parent().parent().removeClass("penalty");

    obj.remove();
    var appended = par.append('<a href="#" data-title="Pridėti nuobaudą." data-reader="'+reader+'" onclick= "return false;" class="btn btn-xs btn-default add-penalty"><span class="glyphicon glyphicon-ban-circle"></span> Pridėti nuobaudą</a>')
        .unbind().click(function(){
        checkForPenalty(reader, $(this).attr("data-reader-name"), appended.find("a.add-penalty"));
    });

}