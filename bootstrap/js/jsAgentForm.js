$(function () {
    function validate_fechaMayorQue(fechaInicial) {
        debugger;
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
        if (dateStart < dateEnd) {
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
                    if ($("#resulContacto").val() == "acepta") {
                        SaveInfoContact($("#idc").val(), $("#idlista").val(), $("#coment").val(), 1, $("#contacto").val(), $("#resulContacto").val(), $("#ctlfecha2").val(), $("#hora2").val(), $("#camp").val(),$("#grabac").val());
                    } else {
                        SaveInfoContact($("#idc").val(), $("#idlista").val(), $("#coment").val(), 0, $("#contacto").val(), $("#resulContacto").val(), $("#ctlfecha2").val(), $("#hora2").val(), $("#camp").val(),$("#grabac").val());
                    }
                    updateContact($("#idlista").val(), $("#idc").val(), $('#nom').val(), $('#apell').val(), $('#dni').val(), $('#direc').val(), $('#codpostal').val(),
                            $('#tel').val(), $('#telalt').val(), $('#email').val());
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
        } else {
            alert('Seleccione al menos un Resultado de Contacto');
        }
    });
    function ocultarModalSave() {
        ed = setTimeout(ocMdlsave, 2000);
    }
    function ocMdlsave() {
        $("#modalSave").modal('hide');
    }
    function updateContact(idl, idc, nom, apel, dni, direc, codpost, tel, tel_alt, mail) {
        $.ajax({
            type: "POST",
            url: "../Controller/CtlAgInfo.php",
            dataType: "html",
            data: "actualizar=true&nombre=" + nom + "&apell=" + apel + "&dni=" + dni + "&direc=" + direc + "&codpostal=" + codpost + "&tel=" + tel + "&telalt=" + tel_alt + "&email=" + mail + "&list_id=" + idl + "&idc=" + idc,
            success: function (msg) {
                console.log(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
    function SaveInfoContact(idc, idl, coment, vta, contact, rescontact, fecha, hora, camp, grab) {
        $.ajax({
            type: "POST",
            url: "../Controller/CtlAgInfo.php",
            dataType: "html",
            data: "guardar=true&idc=" + idc + "&list_id=" + idl + "&checkVta=" + vta + "&Contacto=" + contact + "&resulContacto=" + rescontact + "&txtFecha2=" + fecha + "&txtHora2=" + hora + "&coment=" + coment + "&campaign=" + camp + "&grabacion=" + grab,
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
        //      debugger;
//        console.log($("#tel").val(), $("#nom").val(), $("#apel").val(), $("#resulContacto").val());
        if ($("#tel").val() || $("#nom").val() || $("#apel").val() || $("#resulContacto").val() != 'null') {
            SearchLead($('#nom').val(), $('#apel').val(), $('#tel').val(), $('#resulContacto').val(), $('#fechanota').val(), $("#lstcamp").val());
        } else {
            alert('Debe ingresar completar al menos un campo distinto de "Campaña"');
        }
        //console.log($('#nom').val()+$('#apel').val()+$('#tel').val()+$('#resulnota').val()+$('#fechanota').val());
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
        debugger;
        $("#modalCallm").modal('show');
        $.ajax({
            type: "POST",
            url: "../Controller/CtlAgInfo.php",
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
