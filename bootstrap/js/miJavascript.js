$(function () {
    $("#save").attr('disabled',true);
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
