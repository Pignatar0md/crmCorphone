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
        $.ajax({
            type: "GET",
            url: "Controller/download.php",
            dataType: "html",
            data: "task=reciclar&file=1&contacto=" + contacto + "&resulContacto=" + resulContacto + "&listId=" + listId,
            success: function (msg) {
                window.location.href = msg;
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
