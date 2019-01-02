$(document).ready(function(){
    $('#t_previa').dataTable({
                    'bProcessing': true,
                    //'sScrollY': '400px',                    

                    'sPaginationType': 'bs_normal',
                    'sDom': '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                    'iDisplayLength': 200,
                    
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
                        {'sClass': 'small'},
                        
                      
                       
                    ],
    });
})

function enviar(idProyecto){
    
    $.confirm({
        title: "Enviar",
        content: "¿Deseas enviar Preregistro? <br>Una vez enviado solo podrá ser modificado con autorización del CID.",
        type: 'orange',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-orange',
                action: function(){
                    
                    $.post( url + "preregistro/cambiar_estatus/" +idProyecto + "/1",
                         function( data ) {
                            
                            console.log(data) 
                            //location.href= url + "preregistro";
                            $("#imprimir").removeAttr("disabled")
                            $("#enviar").attr("disabled", true);
                            $("#editar").attr("disabled", true);

                        });
                }
            },
            Cerrar: function () {
                
            }
        }
    });
}

function aceptar(idProyecto){
                    
    $.post( url + "preregistro/cambiar_estatus/" +idProyecto + "/2",
         function( data ) {

            console.log(data) 
            location.href= url + "preregistro";
            

        });
            
   
}


function cambiar_direccion(idPreregistro){
    idDireccion = $("#idDireccion").val();               
    $.post( url + "preregistro/cambiar_direccion/" +idPreregistro + "/" +idDireccion,
         function( data ) {

            console.log(data) 
            location.href= url + "preregistro";
            

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

function alerta(idPreregistro){
    $.confirm({
        title: "Alerta",
        content: "¿Deseas eliminar el Preregistro?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-red',
                action: function(){
                    $.post( url + "preregistro/retornar/" +idPreregistro,
                        function( data ) {

                           console.log(data) 
                           location.href= url + "preregistro";


                       });
                }    
                  
            },
            Cerrar: function () {
                
            }
        }
    });
}







