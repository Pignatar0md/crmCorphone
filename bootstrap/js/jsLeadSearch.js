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
        if (dateStart < dateEnd) {
            mensaje = 'Asegúrese que "Fecha" sea mayor o igual a la actual.';
        }
        return mensaje;
    }
    $('#fecha2').datetimepicker({
        pickTime: false
    });
    $("#modaledit").on('change','#contacto',function () {
        debugger;
        console.log($("#contacto").val());
        $.ajax({
            type: "POST",
            url: "../Controller/CtlAgInfo.php",
            dataType: "html",
            data: "contacto=" + $("#contacto").val(),
            success: function (msg) {
                $("#resulcontacto").html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    });
    $("#save").click(function () {
        debugger;
        if ($("#resulcontacto").val()) {
            if ($("#resulcontacto").val() != 'NULL') {
                var x = $("#ctlfecha3").val();
                //var msg = validate_fechaMayorQue(x);
//                if (msg) {
//                    alert(msg);
//                    $('#ctlfecha3').val('');
//                } else {
                    if ($("#resulcontacto").val() == "acepta") {
                        UpdateInfoContact($("#valorRegistroLista").val(),  $("#coment").val(), 1, $("#contacto").val(), $("#resulcontacto").val(), $("#ctlfecha3").val(), $("#hora3").val());
                    } else {
                        UpdateInfoContact($("#valorRegistroLista").val(),  $("#coment").val(), 0, $("#contacto").val(), $("#resulcontacto").val(), $("#ctlfecha3").val(), $("#hora3").val());
                    }
                    updateContact($("#valorLista").val(), $("#valorRegistroLista").val(), $('#nomm').val(), $('#apell').val(), $('#dni').val(), $('#direc').val(), $('#codpostal').val(),
                            $('#tell').val(), $('#telalt').val(), $('#email').val());
                    $("#modalFormEdit").modal('hide');
                    $("#nomm").val('');$("#apell").val('');$("#dni").val('');$("#direc").val('');$("#codpostal").val('');
                    $("#tell").val('');$("#telalt").val('');$("#email").val('');$("#fechanac").val('');$("#resulcontacto").val('Seleccionar..');
                    $("#ctlfecha3").val('');$("#hora3").val('');$("#coment").val('');
                    $("#modalSave").modal('show');
                    ocultarModalSave();
//                }
            } else {
                var msg = 'Seleccione al menos un Resultado de Contacto';
                alert(msg);
            }
        } else {
            alert('Seleccione al menos un Resultado de Contacto');
        }
    });
    function updateContact(idl, idc, nom, apel, dni, direc, codpost, tel, tel_alt, mail) {
        debugger;
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
    function UpdateInfoContact(idc, coment, vta, contact, rescontact, fecha, hora) {
        debugger;
        $.ajax({
            type: "POST",
            url: "../Controller/CtlLeadSearch.php",
            dataType: "html",
            data: "updateinfocontact=true&idc=" + idc + "&checkVta=" + vta + "&Contacto=" + contact + "&resulContacto=" + rescontact + "&txtFecha2=" + fecha + "&txtHora2=" + hora + "&coment=" + coment,
            success: function (msg) {
                console.log(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
    $('#search').click(function () {
debugger;
        if ($("#tel").val() || $("#nom").val() || $("#apel").val() || $("#resulContacto").val() != 'null') {
            SearchLead($('#nom').val(), $('#apel').val(), $('#tel').val(), $('#resulContacto').val(), $('#fechanota').val(), $("#lstcamp").val());
        } else {
            alert('Debe ingresar completar al menos un campo distinto de "Campaña"');
        }
    });

    function SearchLead(name, surname, phone, resulnote, datenote, nrocamp) {
debugger;
        $.ajax({
            type: "POST",
            url: "../Controller/CtlLeadSearch.php",
            dataType: "html",
            data: "buscar=true&tel=" + phone + "&nom=" + name + "&apel=" + surname + "&resulnota=" + resulnote + "&fechanota=" + datenote + "&nrocamp=" + nrocamp,
            success: function (msg) {
//console.log(msg);
                $("#manualcall").html(msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error al ejecutar => " + textStatus + " - " + errorThrown);
            }
        });
    }
    $("#manualcall").on('click', '.llammanual', function () {
        $("#modalCallm").modal('show');
        $.ajax({
            type: "POST",
            url: "../Controller/CtlAgInfo.php",
            dataType: "html",
            data: "pausa=true"
        });
    });
    $("#edit").on('click', '.editar', function () {
debugger;
        $.ajax({
            type: "POST",
            url: "../Controller/CtlLeadSearch.php",
            dataType: "html",
            data: "editar=true&id="+$("#valorRegistroLista").val()+"&lstcamp="+$("#lstcamp").val(),
            success: function(msg) {
//console.log(msg);
                $("#modaledit").html(msg);
            }
        });
        $("#modalFormEdit").modal('show');
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
    function ocultarModalSave() {
        ed = setTimeout(ocMdlsave, 2000);
    }
    function ocMdlsave() {
        $("#modalSave").modal('hide');
    }
});
