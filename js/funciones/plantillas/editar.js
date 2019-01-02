 /*function agregar_documento(idDocumento,idPlantilla)
    {




       $.ajax({
                   type:"POST",
                   url:"<?php echo site_url('plantillas/agregar_documento'); ?>/" + idDocumento+"/"+idPlantilla,
                   data: {idDocumento:idDocumento,idPlantilla:idPlantilla} ,
                   success: function(data) {
                     //$('.center').html(data); 
                   }
                 });



    }*/

function eliminar(id, idPlantilla){
    
    $.confirm({
        title: "Eliminar",
        content: "¿Deseas Eliminar?",
        type: 'red',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-red',
                action: function(){
                    
                    $.post( url + "plantillas/cambiar_estatus/" + id +"/" + idPlantilla +  "/1",
                        function( data ) {  
                            console.log(data) 
                            location.reload();
                        });
                }
            },
            Cerrar: function () {
                
            }
        }
    });
}

function uf_modificar_documento(id) {
    
    
    $.post( url + 'plantillas/datos_documento',
        { id: id, }, 
        function( data ) {
            console.log(data);
            $("#Orden_doc_mod").val(data.Ordenar);
            $("#Prioritario_doc_mod").val(data.tipoDocumento);
            $("#Nombre_doc_mod").val(data.Nombre);
            $("#idProceso_doc_mod").val(data.idProceso);
            $("#idSubProceso_doc_mod").val(data.idSubProceso);
            $("#idDireccion_doc_mod").val(data.idDireccion);
            $("#nomProceso_mod").html(data.Proceso);
            $("#nomSubProceso_mod").html(data.SubProceso);
            $("#Direccion_doc_mod").val(data.idDireccion);   
            $("#nomDireccion_mod").html(data.Direccion);
            $("#idCatalogo_mod").val(id)
        }, "json");

} 

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

function modificar_proceso_documento(id) {
    
    
    $.post( url + 'plantillas/datos_proceso',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-procesos-mod").modal('hide');
            $("#idProceso_doc_mod").val(data.id);
            $("#nomProceso_mod").html(data.Nombre);
            
           
        }, "json");

}

function modificar_subproceso_documento(id) {
    
    
    $.post( url + 'plantillas/datos_subproceso',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-subprocesos-mod").modal('hide');
            $("#idSubProceso_doc_mod").val(data.id);
            $("#nomSubProceso_mod").html(data.Nombre);
           
        }, "json");

}

function modificar_direccion_documento(id) {
    
    
    $.post( url + 'plantillas/datos_direccion',
        { id: id, }, 
        function( data ) {
            $("#modal-cambiar-direcciones-mod").modal('hide');
            $("#idDireccion_doc_mod").val(data.id);
            $("#nomDireccion_mod").html(data.Nombre);
           
        }, "json");

}
/*
    function modificar_plantilla(id)
    {
        $("#idModalidad_mod").val(id);
        $("#modal-cambiar-modalidad").modal('hide');

        $.ajax({
            url: "<?php echo site_url('plantillas/datos_modalidad'); ?>/" + id,
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {

                $("#nommodalidad_mod").html(data['Modalidad']);

            }
        });
    }



    function uf_modificar_plantilla(id){

        $("#idModalidad_mod").val(id);

            $.ajax({
                url: "<?php echo site_url('plantillas/datos_modalidad'); ?>/" + id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $("#nommodalidad_mod").html(data['Modalidad']);

                }
            });
    }
    */
            