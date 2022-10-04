function getURL() {
    var getUrl = window.location;
    return getUrl.protocol + "//" +getUrl.host;

}

$.fn.dataTable.ext.errMode = 'throw';

var gUploadedFiles = new Array();

$('#table_persons').DataTable({
    "ajax":{

        "url" : getURL()+"/trabajo_oracle/functions.php?action=list",
        "type" : "GET",
        "data" : function(d) {
            d.startDate = $("#filtroFechaInicial").val(),
            d.endDate = $("#filtroFechaFinal").val(),
            d.surname = $("#filtroApellidoPaterno").val()
        }
    },
    "columns": [
        { "data": "idPersona" },
        { "data": "nombres"},
        { "data": "apellidoPaterno"},
        { "data": "apellidoMaterno"},
        { "data": "domicilio"},
        { "data": "telefonoFijo"},
        { "data": "fechaRegistro"},
        { "data": null}
    ],
    'columnDefs': [
        {     
                       
            'targets': [1],
            'class': 'text-center'
            
        },
        {
            'targets': [7],
            'sortable': false,
            'class': 'text-center',
            'render': function(data, type, full, meta) {

                let btn_group = '<button type="button" class="btn btn-warning" onclick="getPerson(' +full.idPersona +')"><i class="fas fa-edit"></i></button>'
                btn_group += '<button type="button" class="btn btn-danger" onclick="deletePerson(' +full.idPersona +')"><i class="fas fa-trash-alt"></i></button>'

                
                return btn_group;
            }
        }
        
    ],
    fixedColumns: true,
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "_MENU_",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "",
        "sSearchPlaceholder": "Buscar",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    },
    'order': [] //[[0, 'desc']]
});


function deletePerson(id)
{
    //var paginacion = $('.pagination').children('.page-item.active').text();
    swal({
        title: "Eliminar",
        text: "¿Está seguro de eliminar al trabajador?",
        icon: "warning",
        buttons: {
            cancel: 'Cancelar',
            delete: 'Sí'
        }
    }).then(function(isConfirm){
        if (isConfirm) {
            $.ajax({
                type: "POST",
                url: getURL()+"/trabajo_oracle/functions.php?action=delete",
                data: { idPerson : id },
                success: function(data){
                    var result = JSON.parse(data);
                    if (result.error){
                        swal({
                            title: "Error",
                            text: result.message,
                            icon: "error",
                        });
                    }
                    else {
                        swal( {
                            title: "Eliminar",
                            text: "Usuario eliminado satisfactoriamente",
                            icon: "success",
                            timer: 3000
                        });
                        let table = $('#table_persons').DataTable();
                        table.ajax.reload();
                          
                    }
                },
                complete: function(data){
                    let table = $('#table_persons').DataTable();
                    table.ajax.reload();
                },
                error: function (request, status, error) {
                    swal({
                        title: 'Error',
                        text: 'Se produjo un error de envio de datos',
                        icon: 'error',
                        showConfirmButton:false
                      })
                }
                
            });
        }
    });      
}

function getPerson(id)
{

    //LIMPIANDO DATOS DEL MODAL
    limpiarDatosModal();
    //MODIFICAMOS DATOS DEL MODAL



    $.ajax({
        type:'POST',
        url: getURL()+"/trabajo_oracle/functions.php?action=get",
        data:{idPerson : id},
        success: function(data){

            var result = JSON.parse(data);
            var mensaje = result.message
            if (result.error){
                swal({
                    title: 'Error',
                    text: mensaje,
                    icon: 'error',
                    showConfirmButton:false
                  })
            }
            else{

                //$("#exampleModal").modal("hide");
                $("#idPersona").val(result.data.idPersona);
                $("#nombres").val(result.data.nombres);
                $("#apellidoPaterno").val(result.data.apellidoPaterno);
                $("#apellidoMaterno").val(result.data.apellidoMaterno);
                $("#domicilio").val(result.data.domicilio);
                $("#telefonoFijo").val(result.data.telefonoFijo);

                $("#tituloModalRegistrar").text("Actualizar");
                $("#exampleModal").modal("show");

            } 
        },
        error: function (request, status, error) {
            swal({
                title: 'Error',
                text: 'Se produjo un error al obtener datos',
                icon: 'error',
                showConfirmButton:false
              })
        }
    });
    

}

function updatePerson(id)
{


    $.ajax({
        type: "POST",
        url: getURL()+"/trabajo_oracle/functions.php?action=update",
        data: { 
            idPersona: $('input[name=txtIdPersona]').val(),
            nombres : $('input[name=txtNombres]').val(),
            apellidoPaterno : $('input[name=txtApellidoPaterno]').val(), 
            apellidoMaterno : $('input[name=txtApellidoMaterno]').val(),
            domicilio : $('input[name=txtDomicilio]').val(), 
            telefonoFijo : $('input[name=txtTelefonoFijo]').val()
        },
        beforeSend(){
            $("#exampleModal").modal("hide");
            limpiarDatosModal();
        },
        success: function(data){
            var result = JSON.parse(data);
            var mensaje = result.message
                if (result.error){
                    swal({
                        title: 'Error',
                        text: mensaje,
                        icon: 'error',
                        showConfirmButton:false
                      })
                }
                else{
                    swal({
                        title: 'Exito',
                        text: mensaje,
                        icon: 'success',
                        timer:2000,
                        timerProgressBar: true,
                        showConfirmButton:false
                      }) 
                } 
           
        },
        complete: function(){
            let table = $('#table_persons').DataTable();
            table.ajax.reload();
        },
        error: function (request, status, error) {
            Swal.fire({
                title: 'Error',
                text: 'Se produjo un error de envio de datos',
                icon: 'error',
                showConfirmButton:false
              })
        }
        
    });

}

function savePerson(){
    $.ajax({
        type: "POST",
        url: getURL()+"/trabajo_oracle/functions.php?action=save",
        data: { 
            idPersona: $('input[name=txtIdPersona]').val(),
            nombres : $('input[name=txtNombres]').val(),
            apellidoPaterno : $('input[name=txtApellidoPaterno]').val(), 
            apellidoMaterno : $('input[name=txtApellidoMaterno]').val(),
            domicilio : $('input[name=txtDomicilio]').val(), 
            telefonoFijo : $('input[name=txtTelefonoFijo]').val()
        },
        beforeSend(){
            $("#exampleModal").modal("hide");
            limpiarDatosModal();
        },
        success: function(data){
            var result = JSON.parse(data);
            var mensaje = result.message
                if (result.error){
                    swal({
                        title: 'Error',
                        text: mensaje,
                        icon: 'error',
                        showConfirmButton:false
                      })
                }
                else{
                    swal({
                        title: 'Exito',
                        text: mensaje,
                        icon: 'success',
                        timer:2000,
                        timerProgressBar: true,
                        showConfirmButton:false
                      }) 
                } 
           
        },
        complete: function(){
            let table = $('#table_persons').DataTable();
            table.ajax.reload();
        },
        error: function (request, status, error) {
            swal({
                title: 'Error',
                text: 'Se produjo un error de envio de datos',
                icon: 'error',
                showConfirmButton:false
              })
        }
        
    });
}

function limpiarDatosModal()
{
    //LIMPIANDO DATOS DEL MODAL
    $("#idPersona").val("");
    $("#nombres").val("");
    $("#apellidoPaterno").val("");
    $("#apellidoMaterno").val("");
    $("#domicilio").val("");
    $("#telefonoFijo").val("");
    
}


$(document).ready(function () {

    $("#nuevaPersonaModal").on('click',function(){
        limpiarDatosModal();
        $("#tituloModalRegistrar").text("Registrar");
        $("#exampleModal").modal("show");
    });

    $("#btnGuardarPersona").on('click', function () {
        
        
        if($("#tituloModalRegistrar").text() == "Registrar"){
            savePerson();
        }
        else {
            updatePerson();
        }
        

    });

    $("#buscarPersona").on('click', function () {
        let table = $('#table_persons').DataTable();
        table.ajax.reload();
    });
    
});