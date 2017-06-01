$(function () {
    function validate_fechaMayorQue(fechaInicial) {
        var fechaFinal = new Date();
        if ((fechaFinal.getMonth() + 1) <= 9) {
            fechaFinal = fechaFinal.getDate() + "/0" + (fechaFinal.getMonth() + 1) + "/" + fechaFinal.getFullYear();
        } else {
            fechaFinal = fechaFinal.getDate() + "/" + (fechaFinal.getMonth() + 1) + "/" + fechaFinal.getFullYear();
        }

        valuesStart = fechaInicial.split("/");
        valuesEnd = fechaFinal.split("/");
        // Verificamos que la fecha no sea posterior a la actual
        var mensaje = '';
        var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
        var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
        if (dateStart >= dateEnd) {
            mensaje = 'Asegúrese que "Fecha" sea mayor o igual a la actual.';
        }
        return mensaje;
    }
    $('#fecha2').datetimepicker({
        pickTime: false
    });
    $('#hora2').datetimepicker({
        pickDate: false,
        format: 'HH:mm'
    });
    $("#contacto").change(function () {
        $.ajax({
            type: "POST",
            url: "../Controller/CtlAgInfo.php",
            dataType: "html",
            data: "contacto=" + $("#contacto").val(),
            success: function (msg) {
                debugger;
                $("#resulContacto").html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
    $("#save").click(function () {
        if ($("#resulContacto").val()) {
            if ($("#resulContacto").val() != 'NULL') {
                var x = $("#ctlfecha2").val();
                var msg = validate_fechaMayorQue(x);
                if (msg) {
                    alert(msg);
                    $('#ctlfecha2').val('');
                } else {
                    SaveInfoContact($('#nom').val(), $('#apell').val(), $('#dni').val(), $('#direc').val(), $('#codpostal').val(),
                            $('#tel').val(), $('#telalt').val(), $('#email').val(), $('#fechanac').val(), $('#hora2').val(),
                            $('#resulContacto').val(), $('#ctlfecha2').val(), $('#contacto').val(), $('#coment').val());
                    $("#coment").val('');
                    $("#resulContacto").val('Seleccionar..');
                    $("#ctlfecha2").val('');
                    $("#hora2").val('');
                    $("#modalSave").modal('show');
                    ocultarModalSave();
                }
            } else {
                var msg = 'Seleccione al menos un Resultado de Contacto';
                alert(msg);
            }
        }else {alert('Seleccione al menos un Resultado de Contacto');}
    });
    function ocultarModalSave() {
        ed = setTimeout(ocMdlsave, 2000);
    }
    function ocMdlsave() {
        $("#modalSave").modal('hide');
    }
    function SaveInfoContact(nom, apel, dni, direc, codpost, tel, tel_alt, mail, fecnac, hora, rescontac, fecha, contac, coment) {
        debugger;
        $.ajax({
            type: "POST",
            url: "../Controller/CtlAgInfo2.php",
            dataType: "html",
            data: "guardar=true&nombre=" + nom + "&apellido=" + apel + "&dni=" + dni + "&direc=" + direc + "&codpostal=" + codpost + "&tel=" +
                    tel + "&telalt=" + tel_alt + "&email=" + mail + "&fecnac=" + fecnac + "&hora=" + hora + "&resulcontacto=" + rescontac +
                    "&fecha=" + fecha + "&contac=" + contac + "&coment=" + coment,
            success: function (msg) {
                debugger;
                console.log(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
    $('#search').click(function () {
        //    debugger;
        console.log($("#tel").val(), $("#nom").val(), $("#apel").val(), $("#resulContacto").val());
        if ($("#tel").val() || $("#nom").val() || $("#apel").val() || $("#resulContacto").val() != 'null') {
            SearchLead($('#nom').val(), $('#apel').val(), $('#tel').val(), $('#resulContacto').val(), $('#fechanota').val(), $("#lstcamp").val());
        } else {
            alert('Debe ingresar completar al menos un campo distinto de "Campaña"');
        }
    });

    function SearchLead(name, surname, phone, resulnote, datenote, nrocamp) {
        $.ajax({
            type: "POST",
            url: "../Controller/CtlLeadSearch.php",
            dataType: "html",
            data: "buscar=true&tel=" + phone + "&nom=" + name + "&apel=" + surname + "&resulnota=" + resulnote + "&fechanota=" + datenote + "&nrocamp=" + nrocamp,
            success: function (msg) {
                $("#LeadsList").html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
    $("#manualcall").click(function () {
        $("#modalCallm").modal('show');
        $.ajax({
            type: "POST",
            url: "../Controller/CtlAgInfo2.php",
            dataType: "html",
            data: "pausa=true"
        });
    });
    $("#Call").click(function () {
        ManualCall($("#agent").val(), $("#number").val());
        $("#modalCallm").modal('hide');
    });

    function ManualCall(agent, numb) {
        $.ajax({
            type: "GET",
            url: "../Controller/CtlClickToDial.php",
            dataType: "html",
            data: "agent=" + agent + "&number=" + numb,
            success: function (msg) {
                console.log(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
});
