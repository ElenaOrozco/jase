function agregar_proceso_documento(id) {
    
    
    $.post( url + 'plantillas/datos_proceso',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-procesos").modal('hide');
            $("#idProceso_doc").val(data.id);
            $("#nomProceso").html(data.Nombre);
            
           
        }, "json");

}

function agregar_subproceso_documento(id) {
    
    
    $.post( url + 'plantillas/datos_subproceso',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-subprocesos").modal('hide');
            $("#idSubProceso_doc").val(data.id);
            $("#nomSubProceso").html(data.Nombre);
           
        }, "json");

}

function agregar_direccion_documento(id) {
    
    
    $.post( url + 'plantillas/datos_direccion',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-direcciones").modal('hide');
            $("#idDireccion_doc").val(data.id);
            $("#nomDireccion").html(data.Nombre);
           
        }, "json");

}