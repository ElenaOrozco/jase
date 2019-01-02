$(document).ready(function(){ 
    llenar_plantilla();
    
})


function llenar_plantilla(){
    traer_procesos()    

        
} 

function traer_procesos(){
    console.log($("#idArchivo").val())
    $.ajax({
        async:false,    
        cache:false,
        url: url + 'preregistro/traer_procesos',
        type: 'POST',
        timeout: 10000,
        data: {
            idPreregistro: $("#idPreregistro").val(),
            idPlantilla: $("#idPlantilla").val(),
            idArchivo: $("#idArchivo").val(),
        },
        beforeSend: function(){
            $("#contenido").html('<div class="spinner" ><i class="fa fa-spinner fa-5x" aria-hidden="true"></i></div>');
        },
        error: function(){
            $("#contenido").html('');
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){
            console.log(respuesta)
            //pintar procesos
            pintar_procesos(respuesta.qProcesos)
            //pintar subprocesos
            pintar_subprocesos(respuesta.qSubProcesos)
            pintar_documentos(respuesta.qDocumentos)
            pintar_preregistrados(respuesta.qPreregistrados)
            pintar_row_extraordinarios()
            
            if(respuesta.noEstimaciones > 0){
                pintar_estimaciones(respuesta.doc_Estimaciones, respuesta.noEstimaciones)
                pintar_estimaciones_preregistros(respuesta.pre_Estimaciones)
            }
            
            if(respuesta.noSolicitudes > 0){
                pintar_solicitudes(respuesta.doc_Solicitudes, respuesta.noSolicitudes)
                pintar_solicitudes_preregistros(respuesta.pre_Solicitudes)
            }
            
            
            
            
            
        }
        //traer_subprocesos()
    })

}
function pintar_procesos(respuesta){
    $("#contenido").html('');
    console.log(respuesta)
    var contenido = "";
    for (i = 0; i < respuesta.length;  i++) {

        obj = respuesta[i];
        div = document.createElement('div');
        div_contenido = $('#procesos').html();

        //Remplazamos el contenido
        div_contenido = div_contenido.replace(/{idProceso}/g, obj.idProceso);
        div_contenido = div_contenido.replace(/{Proceso}/g, obj.Nombre);
        div_contenido = div_contenido.replace(/{total}/g, obj.total);
        div_contenido = div_contenido.replace(/{preregistrados}/g, obj.preregistrados);



        div.innerHTML = div_contenido;
        document.getElementById('contenido').appendChild(div);
    }
                
}

function pintar_subprocesos(respuesta){
    console.log(respuesta)
    var contenido = "";
    for (i = 0; i < respuesta.length;  i++) {

        obj = respuesta[i]
        div = document.createElement('div');
        div_contenido = $('#subproceso').html();

        //Remplazar Contenido
        div_contenido = div_contenido.replace(/{idSubProceso}/g, obj.idSubProceso);
        div_contenido = div_contenido.replace(/{SubProceso}/g, obj.Nombre);
        div_contenido = div_contenido.replace(/{total}/g, obj.total);
        div_contenido = div_contenido.replace(/{preregistrados}/g, obj.preregistrados);       


        div.innerHTML = div_contenido;

        $("#panel-body-proceso-"+obj.idProceso).append(div);


    } 
}

function pintar_documentos(respuesta){
    console.log("Documentos")
    console.log(respuesta)
    var Ejecutora = $("#ejecutora").val();


    var contenido = "";
    for (i = 0; i < respuesta.length;  i++) {

        id = respuesta[i].idSubProceso;

        obj = respuesta[i]
        div = document.createElement('div');
        div_contenido = $('#documento').html();

        //Remplazar en el contenido
        div_contenido = div_contenido.replace( /{id}/g, obj.id);
        div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
        div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
        div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);
        div_contenido = div_contenido.replace(/{idDocumento}/g, obj.idDocumento);


        if (obj.idDireccion == -1 ){
           div_contenido = div_contenido.replace('{Direccion}', Ejecutora);
        } else{
           div_contenido = div_contenido.replace('{Direccion}', obj.Direccion);
        } 
        //Fin Remplazar en el contenido

        div.innerHTML = div_contenido;
        $("#panel-body-subproceso-"+id).append(div);
    }
}

function pintar_preregistrados(respuesta){
    console.log("preregistrados" + respuesta)
    for(var i=0; i <respuesta.length; i++){

        console.log("origina" +respuesta[i].original)
        console.log("copia" +respuesta[i].copia)
        console.log("na" +respuesta[i].NA)
        
        console.log("idDocumento" +respuesta[i].idDocumento)
        console.log("--------------------" )
        
        idDocumento = respuesta[i].idDocumento;
        if( respuesta[i].original != 0){
            original = respuesta[i].original;
        }else{
            original = "";
        }
        
        if( respuesta[i].copia != 0){
            copia = respuesta[i].copia;
        }else{
            copia = "";
        }
        $('#observacion'+ idDocumento).removeAttr("disabled"); 
        $('#observacion'+ idDocumento).val(respuesta[i].observacion); 
        if(respuesta[i].NA == 1){
            $('#no_aplica'+ idDocumento).attr("checked", true);
        }
        
        $('#original'+ idDocumento).val(original)
        $('#copia'+ idDocumento).val(copia)
        

    }  
}

function pintar_row_extraordinarios(){
    //Añadir row Estimaciones
    div = document.createElement('div');
    div_contenido = $('#documento-estimaciones').html();
    div.innerHTML = div_contenido;
    $("#panel-body-subproceso-11").append(div);
    
    //Añadir row Extra
    div = document.createElement('div');
    div_contenido= $('#documento-extra').html();
    div.innerHTML = div_contenido;
    $("#panel-body-subproceso-12").append(div);
}

function pintar_estimaciones(data, no){
    for (i= 0; i < no ; i++){
        //agregar panel
        //Añadir row Estimaciones
        div = document.createElement('div');
        div_contenido = $('#p-estimaciones').html();

        div_contenido = div_contenido.replace( /{numero}/g, i+1);
        div.innerHTML = div_contenido;
        console.log(div_contenido)
        $("#c-estimaciones").append(div);

        //agregar los documentos

        for (j = 0; j < data.length;  j++) {

            console.log("datos estimaciones")
            obj = data[j]
            div = document.createElement('div');


            div_contenido = $('#d-estimacion').html();

            //Remplazar en el contenido
            div_contenido = div_contenido.replace( /{id}/g, obj.id);
            div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
            div_contenido = div_contenido.replace(/{numero}/g, i+1);
            div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
            div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);


            //Fin Remplazar en el contenido

            div.innerHTML = div_contenido;


            $("#panel-body-estimacion-"+ (i+1)).append(div);


        }
        
    }
}

function pintar_solicitudes(data, no){
    for (i= 0; i < no ; i++){
        //agregar panel
        //Añadir row Estimaciones
        div = document.createElement('div');
        div_contenido = $('#p-solicitudes').html();

        div_contenido = div_contenido.replace( /{numero}/g, i+1);
        div.innerHTML = div_contenido;
        console.log(div_contenido)
        $("#c-solicitudes").append(div);

        //agregar los documentos

        for (j = 0; j < data.length;  j++) {

            console.log("datos estimaciones")
            obj = data[j]
            div = document.createElement('div');


            div_contenido = $('#d-solicitud').html();

            //Remplazar en el contenido
            div_contenido = div_contenido.replace( /{id}/g, obj.id);
            div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
            div_contenido = div_contenido.replace(/{numero}/g, i+1);
            div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
            div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);


            //Fin Remplazar en el contenido

            div.innerHTML = div_contenido;


            $("#panel-body-solicitud-"+ (i+1)).append(div);


        }
        
    }
}

function pintar_estimaciones_preregistros(respuesta){
    for(i=0; i <respuesta.length; i++){
                
        obj = respuesta[i]
        idDocumento = obj.idDocumento;

        console.log( idDocumento+'-'+obj.noEstimacion)

        $('#original'+ idDocumento+'-'+respuesta[i].noEstimacion).val(respuesta[i].original)
        $('#copia'+ idDocumento+'-'+respuesta[i].noEstimacion).val(respuesta[i].copia)
        $('#observacion'+ idDocumento+'-'+respuesta[i].noEstimacion).removeAttr("disabled"); 
        $('#observacion'+ idDocumento+'-'+respuesta[i].noEstimacion).val(respuesta[i].observacion); 
        if(respuesta[i].NA == 1){
            $('#no_aplica'+ idDocumento+'-'+respuesta[i].noEstimacion).attr("checked", true);
        }


   }  
}

function pintar_solicitudes_preregistros(respuesta){
    for(i=0; i <respuesta.length; i++){
                
        obj = respuesta[i]
        idDocumento = obj.idDocumento;

        //console.log( idDocumento+'-s'+obj.noSolicitud)
        //console.log(obj);
        
        //console.log('copia'+ idDocumento+'-'+respuesta[i].noSolicitud);
        $('#original'+ idDocumento+'-s'+respuesta[i].noSolicitud).val(respuesta[i].original)
        $('#copia'+ idDocumento+'-s'+respuesta[i].noSolicitud).val(respuesta[i].copia)
        $('#observacion'+ idDocumento+'-s'+respuesta[i].noSolicitud).removeAttr("disabled"); 
        $('#observacion'+ idDocumento+'-s'+respuesta[i].noSolicitud).val(respuesta[i].observacion); 
        if(respuesta[i].NA == 1){
            $('#no_aplica'+ idDocumento+'-s'+respuesta[i].noSolicitud).attr("checked", true);
        }


   }  
}

function  agregar_estimaciones(){
   
    no = $('#noEstimaciones').val();
    idPreregistro = $("#idPreregistro").val();
    idPlantilla = $("#idPlantilla").val();
    
    
    $.post( url + "preregistro/agregar_estimaciones",
    { 
        idPreregistro: idPreregistro,
        no: no,
        idPlantilla: idPlantilla
       
    }, function( data ) {
                    
        console.log(data) 
        $("#c-estimaciones").html("");
        for (i= 0; i < no ; i++){
            //agregar panel
            //Añadir row Estimaciones
            div = document.createElement('div');
            div_contenido = $('#p-estimaciones').html();
            
            div_contenido = div_contenido.replace( /{numero}/g, i+1);
            div.innerHTML = div_contenido;
            console.log("Estima Doc")
            $("#c-estimaciones").append(div);
            
            //agregar los documentos
            console.log(data.length)
            for (j = 0; j < data.length;  j++) {

                console.log("datos estimaciones")
                obj = data[j]
                div = document.createElement('div');

                
                div_contenido = $('#d-estimacion').html();
                
                //Remplazar en el contenido
                div_contenido = div_contenido.replace( /{id}/g, obj.id);
                div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
                div_contenido = div_contenido.replace(/{numero}/g, i+1);
                div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
                div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);
               

                //Fin Remplazar en el contenido
               
                div.innerHTML = div_contenido;
                
                
                $("#panel-body-estimacion-"+ (i+1)).append(div);
                
                
            }
            
            
            
    
        }
                 
    }, "json");
    
   
               
}

function  agregar_solicitudes(){
   
    no = $('#noSolicitudes').val();
     idPreregistro = $("#idPreregistro").val();
    idPlantilla = $("#idPlantilla").val();
    
    $.post( url + "preregistro/agregar_solicitudes",
    { 
        idPreregistro: idPreregistro,
        no: no,
        idPlantilla: idPlantilla
       
    }, function( data ) {
                    
        console.log(data) 
        $("#c-solicitudes").html("");
        for (i= 0; i < no ; i++){
            //agregar panel
            //Añadir row Estimaciones
            div = document.createElement('div');
            div_contenido = $('#p-solicitudes').html();
            
            div_contenido = div_contenido.replace( /{numero}/g, i+1);
            div.innerHTML = div_contenido;
            
            $("#c-solicitudes").append(div);
            
            //agregar los documentos
            
            for (j = 0; j < data.length;  j++) {

               
                obj = data[j]
                console.log("objeto")
                console.log(obj)
                div = document.createElement('div');

                
                div_contenido = $('#d-solicitud').html();
                
                //Remplazar en el contenido
                div_contenido = div_contenido.replace( /{id}/g, obj.id);
                div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
                div_contenido = div_contenido.replace(/{numero}/g, i+1);
                div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
                div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);
               

                //Fin Remplazar en el contenido
               
                div.innerHTML = div_contenido;
                
                
                $("#panel-body-solicitud-"+ (i+1)).append(div);
                
                
            }
            
            
            
    
        }
                 
    }, "json");
    
   
               
}

function preregistrar_estimacion(idDocumento, tipo, numero){
    if (tipo == 1){
        tipo_documento = 'original';
        valor = $("#original" +idDocumento+'-'+numero).val();
    }else {
        tipo_documento = 'copia';
        valor = $("#copia" +idDocumento+'-'+numero).val();
    }
    
    preregistrar_documento_estimacion(idDocumento, valor, tipo_documento, numero);
    
    
}

function preregistrar_solicitud(idDocumento, tipo, numero){
    if (tipo == 1){
        tipo_documento = 'original';
        valor = $("#original" +idDocumento+'-s'+numero).val();
    }else {
        tipo_documento = 'copia';
        valor = $("#copia" +idDocumento+'-s'+numero).val();
    }
    
    preregistrar_documento_solicitud(idDocumento, valor, tipo_documento, numero);
    
    
}

function preregistrar_documento_estimacion(idDocumento, valor, tipo_documento, numero){
    idPreregistro = $("#idPreregistro").val();
    
    $.post( url + "preregistro/preregistrar_estimacion",
    { 
        tipo_documento:tipo_documento,
        idPreregistro: idPreregistro,
        idDocumento: idDocumento,
        valor: valor,
        noEstimacion : numero
    }, function( data ) {
                    
        console.log(data)  
        if (data == 1){
            $("#"+tipo_documento+idDocumento+'-'+numero).css("border", "1px solid green");   
            $("#observacion"+idDocumento+'-'+numero).removeAttr("disabled"); 
        }else {
            $("#"+tipo_documento+idDocumento+'-'+numero).css("border", "1px solid red"); 
        }
    });
}

function preregistrar_documento_solicitud(idDocumento, valor, tipo_documento, numero){
    idPreregistro = $("#idPreregistro").val();
    
    $.post( url + "preregistro/preregistrar_solicitud",
    { 
        tipo_documento:tipo_documento,
        idPreregistro: idPreregistro,
        idDocumento: idDocumento,
        valor: valor,
        noSolicitud : numero
    }, function( data ) {
                    
        console.log(data)  
        if (data == 1){
            $("#"+tipo_documento+idDocumento+'-s'+numero).css("border", "1px solid green");   
            $("#observacion"+idDocumento+'-s'+numero).removeAttr("disabled"); 
        }else {
            $("#"+tipo_documento+idDocumento+'-s'+numero).css("border", "1px solid red"); 
        }
    });
}

function preregistrar_observacion_estimacion(idDocumento, numero){
    idPreregistro = $("#idPreregistro").val();
    observacion   = $("#observacion"+idDocumento+'-'+numero).val();
    
    $.post( url + "preregistro/preregistrar_observacion_estimacion",
    { 
        idPreregistro: idPreregistro,
        idDocumento: idDocumento,
        observacion: observacion,
        noEstimacion:numero
    }, function( data ) {
                    
        console.log(data) 
        if (data == 1){
            $("#observacion"+idDocumento+"-"+numero).css("border", "1px solid green");   
          
        }else {
            $("#observacion"+idDocumento+"-"+numero).css("border", "1px solid red");
        }
                 
    });
}


function preregistrar_observacion_solicitud(idDocumento, numero){
    idPreregistro = $("#idPreregistro").val();
    observacion   = $("#observacion"+idDocumento+'-s'+numero).val();
    
    $.post( url + "preregistro/preregistrar_observacion_solicitud",
    { 
        idPreregistro: idPreregistro,
        idDocumento: idDocumento,
        observacion: observacion,
        noSolicitud:numero
    }, function( data ) {
                    
        console.log(data) 
        if (data == 1){
            $("#observacion"+idDocumento+"-s"+numero).css("border", "1px solid green");   
          
        }else {
            $("#observacion"+idDocumento+"-s"+numero).css("border", "1px solid red");
        }
                 
    });
}


function traer_subprocesos(){
    $.ajax({
        async:false,    
        cache:false,
        url: url + 'preregistro/traer_subprocesos_de_archivo',
        type: 'POST',
        timeout: 10000,
        data: {
            idPreregistro: $("#idPreregistro").val(),
            idPlantilla: $("#idPlantilla").val(),
        },
        beforeSend: function(){
           // $("#panel-body-proceso-"+idTipoProceso).html('<div class="spinner" ><i class="fa fa-spinner fa-5x" aria-hidden="true"></i></div>');
        },
        error: function(){
            //$("#panel-body-proceso-"+idTipoProceso).html('Error');
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){
            //$("#panel-body-proceso-"+idTipoProceso).html('');
            console.log(respuesta)
            var contenido = "";
            for (i = 0; i < respuesta.length;  i++) {

                obj = respuesta[i]
                div = document.createElement('div');
                div_contenido = $('#subproceso').html();
                
                //Remplazar Contenido
                div_contenido = div_contenido.replace(/{idSubProceso}/g, obj.idSubProceso);
                div_contenido = div_contenido.replace(/{SubProceso}/g, obj.Nombre);
                div_contenido = div_contenido.replace(/{total}/g, obj.total);
                div_contenido = div_contenido.replace(/{preregistrados}/g, obj.preregistrados);       
               
                
                div.innerHTML = div_contenido;
                
                $("#panel-body-proceso-"+obj.idProceso).append(div);
                
               
            } 
        }
       
    });
    traer_documentos()
}

function traer_documentos(){
    $.post( url + 'preregistro/traer_documentos_de_archivo', 
        { 
            idPreregistro: $("#idPreregistro").val(),
            idPlantilla: $("#idPlantilla").val(),
        }, function( data ) {
            respuesta = data.Documentos 
            console.log("Documentos")
            console.log(respuesta)
            var Ejecutora = $("#ejecutora").val();

            
            var contenido = "";
            for (i = 0; i < respuesta.length;  i++) {

                id = respuesta[i].idSubProceso;
                
                obj = respuesta[i]
                div = document.createElement('div');
                div_contenido = $('#documento').html();
                
                //Remplazar en el contenido
                div_contenido = div_contenido.replace( /{id}/g, obj.id);
                div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
                div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
                div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);
                div_contenido = div_contenido.replace(/{idDocumento}/g, obj.idDocumento);

                
                if (obj.idDireccion == -1 ){
                   div_contenido = div_contenido.replace('{Direccion}', Ejecutora);
                } else{
                   div_contenido = div_contenido.replace('{Direccion}', obj.Direccion);
                } 
                //Fin Remplazar en el contenido
               
                div.innerHTML = div_contenido;
                $("#panel-body-subproceso-"+id).append(div);
            }
            console.log("Mostrar Preregistrados")
            mostrar_preregistrados(data.Preregistrados)
        }, "json");
     
     /*
     $.ajax({
        url: url + 'preregistro/traer_documentos_de_archivo',
        type: 'POST',
        dataType: "json",
        data: {
            idPreregistro: $("#idPreregistro").val(),
            idPlantilla: $("#idPlantilla").val(),
        },
        beforeSend: function(){
            console.log('Ha surgido un esperar.')
            //$("#panel-body-subproceso-"+id).html('<div class="spinner" ><i class="fa fa-spinner fa-5x" aria-hidden="true"></i></div>');
        },
        error: function(){
           // $("#panel-body-subproceso-"+id).html('Error');
            console.log('Ha surgido un error.')
        },
        success: function(data){


            data.Documentos = respuesta
            console.log("Documentos")
            console.log(respuesta)
            var Ejecutora = $("#ejecutora").val();

            
            var contenido = "";
            for (i = 0; i < respuesta.length;  i++) {

                id = respuesta[i].idSubProceso;
                
                obj = respuesta[i]
                div = document.createElement('div');
                div_contenido = $('#documento').html();
                
                //Remplazar en el contenido
                div_contenido = div_contenido.replace( /{id}/g, obj.id);
                div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
                div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
                div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);
                div_contenido = div_contenido.replace(/{idDocumento}/g, obj.idDocumento);

                
                if (obj.idDireccion == -1 ){
                   div_contenido = div_contenido.replace('{Direccion}', Ejecutora);
                } else{
                   div_contenido = div_contenido.replace('{Direccion}', obj.Direccion);
                } 
                //Fin Remplazar en el contenido
               
                div.innerHTML = div_contenido;
                $("#panel-body-subproceso-"+id).append(div);
                
                
            }
            console.log("Mostrar Preregistrados")
            mostrar_preregistrados(data.Preregistrados)
        }
    });*/
}



function mostrar_preregistrados(respuesta){
    console.log(respuesta)
    for(var i=0; i <respuesta.length; i++){


         idRAD = respuesta[i].id_Rel_Archivo_Documento;
         valor = respuesta[i].tipo_documento;

         $('#tipo_documento'+ idRAD + ' > option[value="' + valor +'"]').attr('selected', 'selected');
         $('#noHojas_doc_'+ idRAD).val(respuesta[i].noHojas)

    }  
        
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
        $("#"+tipo_documento+idDocumento).css("border-color", "green");   
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





