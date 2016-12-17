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