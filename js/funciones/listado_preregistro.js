$(document).ready(function(){ 
    
    $('#t_listado_preregistro').dataTable({
                    'bProcessing': true,
                    //'sScrollY': '400px',                    

                    'sPaginationType': 'bs_normal',
                    'sDom': '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                    'iDisplayLength': 10,
                    //'aaSorting': [[1, 'desc']],
                    'aLengthMenu': [[10, 50, 100, 200, -1], [10, 50, 100, 200, "Todo"]],
                    'bDeferRender': true,
                    'bAutoWidth': false,
                    'bScrollCollapse': false,                    
                    'oLanguage': {
                        'sProcessing': 'Procesando...',
                        'sLengthMenu': 'Mostrar _MENU_ archivos',
                        'sZeroRecords': 'Buscando Archivos...',
                        'sInfo': 'Mostrando desde _START_ hasta _END_ de _TOTAL_ archivos',
                        'sInfoEmpty': 'Mostrando desde 0 hasta 0 de 0 archivos',
                        'sInfoFiltered': '(filtrado de _MAX_ archivos en total)',
                        'sInfoPostFix': '',
                        'sSearch': 'Buscar:',
                        'sUrl': '',
                        'oPaginate': {
                            'sFirst': '&nbsp;Primero&nbsp;',
                            'sPrevious': '&nbsp;Anterior&nbsp;',
                            'sNext': '&nbsp;Siguiente&nbsp;',
                            'sLast': '&nbsp;&Uacute;ltimo&nbsp;'
                        }
                    },
                    'aoColumns': [
                        {'sClass': 'small'},
                        {'sClass': 'small'},
                        {'sClass': 'small'},
                        {'sClass': 'small'},
                        {'sClass': 'small'},
                        {'sClass': 'small'},
                       
                      
                       
                    ],
    });
    
   
    var dataTable = $('#t_listado').DataTable({  
           "processing":true,  
           "serverSide":true, 
           "responsive":true,
           "scrollX": false,
           "order":[],  
           "ajax":{  
                url:url + 'preregistro/fetch_archivos',  
                type:"POST" 
           }, 
           "language": {
                url: url + 'assets/dataTables.spanish.lang'
            }, 

           "columnDefs":[  
                {  
                    "targets":[5], 
                    "orderable":false,  
                },  
           ]
      });
      
       var dataTable = $('#t_recibidos').DataTable({  
           "processing":true,  
           "serverSide":true, 
           "responsive":true,
           "scrollX": false,
           "order":[],  
           "ajax":{  
                url:url + 'preregistro/fetch_recibidos',  
                type:"POST" 
           }, 
           "language": {
                url: url + 'assets/dataTables.spanish.lang'
            }, 

           "columnDefs":[  
                {  
                    "targets":[5], 
                    "orderable":false,  
                },  
           ]
      });
      
      
      
   
      
    var dataTable = $('#t_listado_ot').DataTable({  
           "destroy": true,
           "processing":true,  
           "serverSide":true, 
           "responsive":true,
           "scrollX": true,
           "autoWidth": true,
           "order":[],  
           "ajax":{  
                url:url + 'preregistro/fetch_archivos_ot',  
                type:"POST" ,
                data:{
                    ejercicio:$('#ejercicio').val(),
                    estatus:$('#estatus').val(),
                    grupo:$('#grupo').val()
                }
           }, 
           "language": {
                url: url + 'assets/dataTables.spanish.lang'
            }, 

           "columnDefs":[  
                {  
                    "targets":[6], 
                    "orderable":false,  
                },  
           ]
      }); 
     
    
    $("#orden_trabajo").select2({
        placeholder: "Asignar OT",
        ajax: {
            url: url + "preregistro/ot_json",
            dataType: 'json',
            quietMillis: 100,
            type: 'POST',
            data: function (term, page) {
                return {
                    term: term, //search term
                    page_limit: 100 // page size                               
                };
            },
            results: function (data, page) {
                return { results: data.results };
            }
        },
        initSelection: function(element, callback) {
            var idInicial = $("#orden_trabajo").val();
            return $.post( url + "preregistro/ot_json", { id: idInicial }, function( data ) {
                return callback(data.results[0]);
            }, "json");

        }
    }); 
    
    $("#orden_trabajo_pre").select2({
        placeholder: "Asignar OT",
        ajax: {
            url: url + "preregistro/ot_json",
            dataType: 'json',
            quietMillis: 100,
            type: 'POST',
            data: function (term, page) {
                return {
                    term: term, //search term
                    page_limit: 100 // page size                               
                };
            },
            results: function (data, page) {
                return { results: data.results };
            }
        },
        initSelection: function(element, callback) {
            var idInicial = $("#orden_trabajo_pre").val();
            return $.post( url + "preregistro/ot_json", { id: idInicial }, function( data ) {
                return callback(data.results[0]);
            }, "json");

        }
    });
    
    $("#orden_trabajo_dig").select2({
        placeholder: "Asignar OT",
        ajax: {
            url: url + "preregistro/ot_json",
            dataType: 'json',
            quietMillis: 100,
            type: 'POST',
            data: function (term, page) {
                return {
                    term: term, //search term
                    page_limit: 100 // page size                               
                };
            },
            results: function (data, page) {
                return { results: data.results };
            }
        },
        initSelection: function(element, callback) {
            var idInicial = $("#orden_trabajo_pre").val();
            return $.post( url + "preregistro/ot_json", { id: idInicial }, function( data ) {
                return callback(data.results[0]);
            }, "json");

        }
    });
    
    $("#usuario_asignado").select2({
        placeholder: "Asignar Usuario",
        ajax: {
            url: url + "preregistro/ot_json_usuarios",
            dataType: 'json',
            quietMillis: 100,
            type: 'POST',
            data: function (term, page) {
                return {
                    term: term, //search term
                    page_limit: 100 // page size                               
                };
            },
            results: function (data, page) {
                return { results: data.results };
            }
        },
        initSelection: function(element, callback) {
            var idInicial = $("#usuario_asignado").val();
            return $.post( url + "preregistro/ot_json_usuarios", { id: idInicial }, function( data ) {
                return callback(data.results[0]);
            }, "json");

        }
    });  
    
})

function filtrar(){
    ejercicio = $("#ejercicio").val();
    estatus   = $("#estatus").val();
    grupo     = $("#grupo").val();
    
    $("#t_listado_ot").dataTable().fnDestroy();
     var dataTable = $('#t_listado_ot').DataTable({  
           "processing":true,  
           "serverSide":true, 
           "responsive":true,
           "scrollX": true,
           "order":[],  
           "ajax":{  
                url:url + 'preregistro/fetch_archivos_ot',  
                type:"POST" ,
                data:{
                    ejercicio:ejercicio,
                    estatus:estatus,
                    grupo:grupo
                }
           }, 
           "language": {
                url: url + 'assets/dataTables.spanish.lang'
            }, 

           "columnDefs":[  
                {  
                    "targets":[6], 
                    "orderable":false,  
                },  
           ]
      }); 
    
}

function nuevo_preregistro(){
    idArchivo  = $("#orden_trabajo").val();
    
    if (idArchivo > 0){
        $.post( url + "preregistro/crear_folio", { idArchivo: idArchivo }, function( data ) {
            console.log(data)
            if (data > 0){
                location.href = url + "preregistro/editar/" + data;
            }

          });
    }else{
        alerta()
    }
}

function open_modal_faltantes(idArchivo){
    
    $("#idOT-modal-faltantes-ot").val(idArchivo);
}

function alerta(){
    $.confirm({
        title: "Error",
        content: "Necesitas llenar el campo Orden de Trabajo",
        type: 'red',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-red',
                action: function(){
                }    
                  
            },
            Cerrar: function () {
                
            }
        }
    });
}

function agregar_direccion_documento(id) {
    
    
    $.post( url + 'preregistro/datos_direccion',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-direcciones").modal('hide');
            $("#idDireccion").val(data.id);
            $("#nomDireccion").html(data.Nombre);
           
        }, "json");

}

function agregar_direccion_documento_dig(id) {
    
    
    $.post( url + 'preregistro/datos_direccion',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-direcciones-dig").modal('hide');
            $("#idDireccion_dig").val(data.id);
            $("#nomDireccion_dig").html(data.Nombre);
           
        }, "json");

}

function agregar_direccion_faltantes(id) {
    
    
    $.post( url + 'preregistro/datos_direccion',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-direcciones-faltantes").modal('hide');
            $("#idDireccion-modal-faltantes").val(data.id);
            $("#nomDireccion-faltantes").html(data.Nombre);
            $("#nomDireccion-faltantes2").val(data.Nombre)
           
        }, "json");

}

function preregistrar_como(tipo){
    if(tipo == 0){
        idArchivo  = $("#orden_trabajo_pre").val();
        idDireccion = $("#idDireccion").val()
    }else{
        idArchivo  = $("#orden_trabajo_dig").val();
        idDireccion = $("#idDireccion_dig").val()
    }
    
   
    $.post( url + "preregistro/crear_folio", { idArchivo: idArchivo, idDireccion:idDireccion, tipo:tipo }, function( data ) {
        console.log(data)
        if (data > 0){
            location.href = url + "preregistro/editar/" + data;
        }
        
      });
}

function editar_plantilla_ot(){
    idArchivo  = $("#orden_trabajo").val();
    location.href = url + "preregistro/editar_plantilla/" + idArchivo;
}

function uf_asignar_usuario(idPreregistro){
    $("#idPreregistro_asignacion").val(idPreregistro);
}



function dibujar_tabla_ubicaciones(idArchivo){
    

    $.ajax({

            type: "POST",
            url: url +  'preregistro/ver_ubicaciones_archivo/' +idArchivo,
            success: function (data) {

                 //alert("dib" +data["tabla"])
                 $("#tabla_ubi_actualizada").html("");
                 $("#tabla_ubi_actualizada").html(data["tabla"]); 
                 $("#tabla_ubi_actualizada").show();
                 $("#orden_tabajo").val(idArchivo)

            }
        }) ;

}

function uf_ver_ubicacion_fisica_libre(idArchivo) {
                        
       

       $.ajax({
          type:"POST",
          url: url + "preregistro/ver_ubicaciones_libres_captura/" +idArchivo, 
          success: function(data) {

               $('#idUbicacionFisica_libre').html(data["ubicacion_fisica_libre"]); 
          }
        });

}

function ubicacion_libre() {
                        
        idArchivo = $("#idArchivo_u").val();

       $.ajax({
          type:"POST",
          url: url + "preregistro/ver_ubicaciones_libres_captura/" +idArchivo, 
          success: function(data) {

               $('#idUbicacionFisica_libre').html(data["ubicacion_fisica_libre"]); 
          }
        });

}
            
            
function imprimir_procesos(idArchivo) {

         

    $.ajax({
       type:"POST",
       url:url + "preregistro/imprimir_procesos/" +idArchivo, 
       success: function(data) {

            $('#proceso_ubi').html(data["resultado"]); 
            $('#idArchivo_u').val(idArchivo)
            $('#myModal').modal('hide');

       }
     });

}
            
function uf_agregar_ubicacion_fisica(id,ubicacion_fisica)
{
   $("#idUbicacionFisica").val(id);
   $("#nomubicacionfisica").html(ubicacion_fisica);
   $("#modal-cambiar-ubicacionfisica").modal('hide');

}
            
            
function agregar_ubicacion_fisica(idArchivo){


    var ubicacion = $("#nomubicacionfisica").html()
    //alert(ubicacion)
    var proceso = $("#procceso").val()
    //alert("Proceso " +proceso)
    $("#modal-agregar-ubicacion-fisica").modal('hide');
        $.ajax({
            beforeSend: function(){
                $("#tabla_ubi_actualizada_"+proceso).html("Cargando...")

            },
            data: {
                "idUbicacionFisica" :$("#idUbicacionFisica").val(), 
                "idArchivo" :  $("#idArchivo_u").val()  ,     
                "idTipoProceso" : $("#proceso_ubi").val(),

            },
            type: "POST",
            url: url + "preregistro/agregar_ubicacion_fisica",
             success: function (data, textStatus, jqXHR) {
                //dibujar_tabla_ubicaciones()
                //$("#idUbicacionFisica").val("") 
                //$("#idTipoProceso_ubicacion").val("")

             },
             error: function(jqXHR, estado, error){
                console.log(estado)
                console.log(error)
             }
        }) ;


}

function eliminar_ubicacion(id, idUbi){
            //alert("OK" +idRel);
            //var idRel = idRel
            
    var idArchivo = $("#idArchivo_l").val()


        $.confirm({
        title: 'Eliminar Ubicación',
        content: '¿Deseas Eliminar Ubicación?',
        buttons: {
            Si: function () {
                $.ajax({

                    type: "POST",
                    url: url + 'preregistro/eliminar_ubicacion/' +id  + "/" +idUbi+ "/" +idArchivo,
                     success: function (data, textStatus, jqXHR) {
                            //alert("Eliminado")
                             

                     },
                     error: function(jqXHR, estado, error){
                        console.log(estado)
                        console.log(error)
                     }
                }) ;
            },
            No: function () {
                //$.alert('Canceled!');
            }

        }});
            
}

function ver_ot(){
    
    $("#por_recibir").addClass("hidden");
    $("#recibidos").addClass("hidden");
    $("#link-ot").addClass("active");
    $("#link-recibir").removeClass("active");
    $("#por_ot").removeClass("hidden");
    $("#link-recibidos").removeClass("active");
    
}
function ver_reporte(){
    location.href = url + "impresion/reporte_relacion_obras_2017";
    
    
    
}

function ver_por_recibir(){
    $("#por_ot").addClass("hidden");
    $("#recibidos").addClass("hidden");
    $("#por_recibir").removeClass("hidden");
    $("#link-recibir").addClass("active");
    $("#link-ot").removeClass("active");
    $("#link-recibidos").removeClass("active");
    
}

function ver_recibidos(){
    $("#por_ot").addClass("hidden");
    $("#por_recibir").addClass("hidden");
    $("#recibidos").removeClass("hidden");
    $("#link-recibir").removeClass("active");
    $("#link-ot").removeClass("active");
    $("#link-recibidos").addClass("active");
    
    
}


        

