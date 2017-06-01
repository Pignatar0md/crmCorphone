$(function () {
    $("#contacto").change(function () {
        $.ajax({
            type: "POST",
            url: "Controller/CtlAgInfo.php",
            dataType: "html",
            data: "contacto=" + $("#contacto").val(),
            success: function (msg) {
                $("#resulContacto").html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
    $("#save").attr('disabled', true);
    function traerBdatos() {
        $.ajax({
            type: "POST",
            url: "Controller/CtlImport.php",
            dataType: "html",
            data: "getCmp=1",
            success: function (msg) {
                $('#CampaignsList').html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
    traerBdatos();
    var listId = null;
    $('#CampaignsList').on('click', '#recycle', function (e) {
        listId = e.currentTarget.attributes.value.nodeValue;
        $('#myModalRecycle').modal('show');
    });
    $("#reciclar").click(function () {
        var contacto = $("#contacto option:selected").val();
        var resulContacto = $("#resulContacto option:selected").val();
        var datos = 'task=reciclar&file=1&listId=' + listId;
        
        if($("#contestador").prop('checked')){
            datos += '&contestador=true';
        } if($("#nocontesta").prop('checked')){
            datos += '&nocontesta=true';
        } if($("#ocupado").prop('checked')){
            datos += '&ocupado=true';
        } if($("#notitular").prop('checked')){
            datos += '&notitular=true';
        } if($("#conforme").prop('checked')){
            datos += '&conforme=true';
        } if($("#noconforme").prop('checked')){
            datos += '&noconforme=true';
        } if($("#lineapymes").prop('checked')){
            datos += '&lineapymes=true';
        } if($("#agendagral").prop('checked')){
            datos += '&agendagral=true';
        } if($("#pendiente").prop('checked')){
            datos += '&pendiente=true';
        }
        
        $.ajax({
            type: "GET",
            url: "Controller/download.php",
            dataType: "html",
            data: datos,
            success: function (msg) {
                window.location = 'Controller/download.php?file='+msg+"&task=download&contentType=csv";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
    $('#CampaignsList').on('click', '#delete', function (e) {
        var id = e.currentTarget.attributes.value.nodeValue;
        var elimino = function (a) {
            confirmar = confirm("Esta seguro de eliminar los datos de la lista " + a + "?");
            return confirmar;
        };
        if (elimino(id)) {
            $.ajax({
                type: "POST",
                url: "Controller/CtlImport.php",
                dataType: "html",
                data: "eliminar=true&id=" + id,
                success: function (msg) {
                    traerBdatos();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
                }
            });
        }
    });
    function deleteLista() {
        $.ajax({
            type: "POST",
            url: "Controller/CtlImport.php",
            dataType: "html",
            data: "getCmp=1",
            success: function (msg) {
                $('#CampaignsList').html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
});
