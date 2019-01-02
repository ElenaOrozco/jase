$(document).ready(function(){ 
    llenar_plantilla();
    
})


function llenar_plantilla(){
    traer_procesos()    

        
} 

function traer_procesos(){
    $.ajax({
        async:false,    
        cache:false,
        url: url + 'preregistro/traer_procesos',
        type: 'POST',
        timeout: 10000,
        data: {
            idArchivo: $("#idArchivo").val(),
            idPreregistro: $("#idPreregistro").val(),
        },
        beforeSend: function(){
            $("#contenido").html('<div class="spinner" ><i class="fa fa-spinner fa-5x" aria-hidden="true"></i></div>');
        },
        error: function(){
            $("#contenido").html('');
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){
            $("#contenido").html('');
            console.log(respuesta)
            var contenido = "";
            for (i = 0; i < respuesta.length;  i++) {

                obj = respuesta[i];
                div = document.createElement('div');
                div_contenido = $('#procesos').html();
                
                //Como ocpamos 4 veces la propiedad 
                div_contenido = div_contenido.replace(/{idProceso}/g, obj.idProceso);
                div_contenido = div_contenido.replace(/{Proceso}/g, obj.Proceso);
                div_contenido = div_contenido.replace(/{total}/g, obj.total);
                div_contenido = div_contenido.replace(/{preregistrados}/g, obj.preregistrados);
                 
                
                //console.log(div_contenido)
                div.innerHTML = div_contenido;
                //console.log(respuesta[i].idTipoProceso)
                document.getElementById('contenido').appendChild(div);
                
               
            }
            //
            traer_subprocesos()
            //traer_documentos_alternos();
            
        }
    })

}

function traer_subprocesos(){
    $.ajax({
        async:false,    
        cache:false,
        url: url + 'preregistro/traer_subprocesos_de_archivo',
        type: 'POST',
        timeout: 10000,
        data: {idArchivo: $("#idArchivo").val()},
        beforeSend: function(){
           // $("#panel-body-proceso-"+idTipoProceso).html('<div class="spinner" ><i class="fa fa-spinner fa-5x" aria-hidden="true"></i></div>');
        },
        error: function(){
           // $("#panel-body-proceso-"+idTipoProceso).html('Error');
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){
            //$("#panel-body-proceso-"+idTipoProceso).html('');
            //console.log(respuesta)
            var contenido = "";
            for (i = 0; i < respuesta.length;  i++) {

                obj = respuesta[i]
                div = document.createElement('div');
                div_contenido = $('#subproceso').html();
                
               
                //Como ocupamos 4 veces la propiedad 
               
                div_contenido = div_contenido.replace(/{idSubProceso}/g, obj.idSubProceso);
                div_contenido = div_contenido.replace(/{SubProceso}/g, obj.SubProceso);
                div_contenido = div_contenido.replace(/{total}/g, obj.total);
                div_contenido = div_contenido.replace(/{preregistrados}/g, obj.preregistrados);       
               
               
               
                console.log(div_contenido)
                console.log(obj.idProceso)
                
                div.innerHTML = div_contenido;
                
                $("#panel-body-proceso-"+obj.idProceso).append(div);
                
               
                
            }
            
            
        }
       
    });
    traer_documentos()
}

function traer_documentos(){
     $.ajax({
        url: url + 'preregistro/traer_documentos_de_archivo',
        type: 'POST',
        timeout: 10000,
        data: {idArchivo: $("#idArchivo").val()},
        beforeSend: function(){
            console.log('Ha surgido un esperar.')
            //$("#panel-body-subproceso-"+id).html('<div class="spinner" ><i class="fa fa-spinner fa-5x" aria-hidden="true"></i></div>');
        },
        error: function(){
            $("#panel-body-subproceso-"+id).html('Error');
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){


            
            //console.log(respuesta)
            var Ejecutora = $("#ejecutora").val();

            
            var contenido = "";
            for (i = 0; i < respuesta.length;  i++) {

                id = respuesta[i].idSubProceso;
                ///console.log("Sunproceso " +id)
                //$("#panel-body-subproceso-"+id).html('');

                obj = respuesta[i]
                div = document.createElement('div');

                console.log(obj.idDocumento)
                if(obj.idDocumento != 114){
                    div_contenido = $('#documento').html();
                } else {
                    div_contenido = $('#documento-contenedor').html();
                }
                //Remplazar en el contenido
                div_contenido = div_contenido.replace( /{id}/g, obj.id);
                div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
                div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
                div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);
                div_contenido = div_contenido.replace(/{idDocumento}/g, obj.idDocumento);

                
                if (obj.Direccion == 0 ){
                   obj.Direccion = Ejecutora; 
                }   
                if (obj.Direccion == null){
                   obj.Direccion = "Sin Definir";   
                }                    
                div_contenido = div_contenido.replace('{Direccion}', obj.Direccion);
                //Fin Remplazar en el contenido
               
                div.innerHTML = div_contenido;
                
                
                $("#panel-body-subproceso-"+id).append(div);
                
                
            }
            //traer_preregistrados()
            
        }
    });
}



function traer_preregistrados(){
     $.ajax({
        url: url + 'preregistro/traer_preregistrados',
        type: 'POST',
        timeout: 10000,
        data: {idArchivo: $("#idArchivo").val()},
        beforeSend: function(){
            
        },
        error: function(){
            
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){
            console.log(respuesta)
           

           for(var i=0; i <respuesta.length; i++){
                

                idRAD = respuesta[i].id_Rel_Archivo_Documento;
                valor = respuesta[i].tipo_documento;

                $('#tipo_documento'+ idRAD + ' > option[value="' + valor +'"]').attr('selected', 'selected');
                $('#noHojas_doc_'+ idRAD).val(respuesta[i].noHojas)

           }  
            
        }
    });
}

function preregistrar(idDocumento, tipo){
    if (tipo == 1){
        tipo_documento = 'original';
        valor = $("#original" +idDocumento).val();
    }else {
        tipo_documento = 'copia';
        valor = $("#copia" +idDocumento).val();
    }
    
    preregistrar_documento(idDocumento, tipo, valor);
    
    
}

function preregistrar_documento(idDocumento, tipo, valor){
    idPreregistro = $("#idPreregistro").val();
    
    $.post( url + "preregistro/preregistrar",
    { 
        tipo_documento:tipo_documento,
        idPreregistro: idPreregistro,
        idDocumento: idDocumento,
        valor: valor,
    }, function( data ) {
                    
        console.log(data)   
        $("#"+tipo_documento+idDocumento).css("border", "green");   
        $("#observacion"+idDocumento).removeAttr("disabled");           
    });
}

function preregistrar_observacion(idDocumento){
    idPreregistro = $("#idPreregistro").val();
    observacion   = $("#observacion"+idDocumento).val();
    
    $.post( url + "preregistro/preregistrar_observacion",
    { 
        idPreregistro: idPreregistro,
        idDocumento: idDocumento,
        observacion: observacion,
    }, function( data ) {
                    
        console.log(data)           
                 
    });
}

function check_preregistrar(obj, idDocumento, tipo){
    
    tipo_documento = 'NA';
    
    if (obj.checked){
       valor = 1; 
    }
    else{
        valor = 0;    
    }
    preregistrar_documento(idDocumento, tipo, valor);
	
}

/*function preregistrar_documento(id, idTipoProceso, idDocumento){

    var tipo_documento = $("#tipo_documento"+id).val();
    var idArchivo = $("#idArchivo").val();
    
    url = $("#base_url").val()+ "archivo/preregistrar_documento";
   
    $.ajax({
        data:  { 
            id: id,
            idArchivo:idArchivo,
            tipo_documento: tipo_documento,
            idTipoProceso: idTipoProceso,
            idSubTipoProceso: idSubTipoProceso
        },
        url:  url , 
        dataType: 'json',
        quietMillis: 100,
        type:  'POST',
        success:  function (data) {
            console.log(data.retorno);
            if(data.retorno == 1){
                $("#tipo_documento"+id).css("border-color", "green");
                $("#noPreregistrados-"+idTipoProceso).html(data.preregistrados_proceso);
                $("#noPreregistrados-subproceso-"+idSubTipoProceso).html(data.preregistrados_subproceso);
            }else{
                $("#tipo_documento"+id).css("border-color", "red");
            }
        }
    });
    
                       
}*/

function validar(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  return (tecla!=13)
  
}

function preregistrar_hojas(e, idRAD){
    //tecla = (document.all) ? e.keyCode : e.which;
    if (validar(e)){

        var hojas     = $("#noHojas_doc_"+idRAD).val();
        var url       = $("#base_url").val()+ "archivo/preregistrar_hojas";
        

        $.post( url, { noHojas: hojas, idRAD: idRAD })
            .done(function( data ) {
                console.log(data);
                console.log(data.retorno);
                if(data.retorno > 0){
                     $("#noHojas_doc_"+idRAD).css("border-color", "green");
                }else{
                    console.log("Error")
                    $.alert({
                        title: 'Alerta!',
                        content: 'Selecciona un tipo de documento!',
                        icon: 'fa fa-exclamation-circle',
                        type: 'red',
                        typeAnimated: true
                    });
                    //$("#noHojas_doc_"+idRAD).css("border-color", "red");
                    $("#noHojas_doc_"+idRAD).val("");

                }
               
            });
    }               
}

function cargar_estimaciones(e, idRel, idArchivo, preregistro){
        
    //tecla = (document.all) ? e.keyCode : e.which;
    if (validar(e)){
        $("#tipo_documento"+idRel).val(4);


        uf_recibir_tipo_documento(idRel, idArchivo, preregistro)


        var estimaciones = $("#noEstimaciones").val(); 
            $.ajax({
                beforeSend: function(){

                    $("#div_estimaciones_"+idRel).html("Cargando...")

                },
                type: "POST",

                url: "<?php echo site_url('archivo/cargar_estimaciones'); ?>/" + idRel+"/"+idArchivo+"/"+estimaciones,
                success: function (data) {

                    dibujar_tabla_estimaciones(idRel, idArchivo)
                    //$("#div_estimaciones_"+idRel).html(data["estimaciones"]); 
                     //$('#div_estimaciones').html("Hola");

                }
            }) ;
    }

  
}





