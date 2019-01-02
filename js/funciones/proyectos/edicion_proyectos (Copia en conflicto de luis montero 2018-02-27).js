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
        url: url + 'proyectos/traer_procesos',
        type: 'POST',
        timeout: 10000,
       
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
                div_contenido = div_contenido.replace(/{Proceso}/g, obj.Nombre);
                //div_contenido = div_contenido.replace(/{total}/g, obj.total);
                //div_contenido = div_contenido.replace(/{preregistrados}/g, obj.preregistrados);
                 
                
                //console.log(div_contenido)
                div.innerHTML = div_contenido;
                //console.log(respuesta[i].idTipoProceso)
                document.getElementById('contenido').appendChild(div);
                
               
            }
            //
            traer_subprocesos()
            traer_estimaciones()
            traer_solicitudes()
            
            
        }
    })

}

function traer_subprocesos(){
    $.ajax({
        async:false,    
        cache:false,
        url: url + 'proyectos/traer_subprocesos',
        type: 'POST',
        timeout: 10000,
        
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
                
               
                
               
                div_contenido = div_contenido.replace(/{idSubProceso}/g, obj.idSubProceso);
                div_contenido = div_contenido.replace(/{SubProceso}/g, obj.Nombre);
                //div_contenido = div_contenido.replace(/{total}/g, obj.total);
                //div_contenido = div_contenido.replace(/{preregistrados}/g, obj.preregistrados);       
               
               
               
               
                //console.log(obj.idProceso)
                
                div.innerHTML = div_contenido;
                
                $("#panel-body-proceso-"+obj.idProceso).append(div);
                
               
                
            }
            //Poner row de Estimaciones y ExtraOrdinarios
            
            
            
        }
       
    });
    traer_extraordinarios()
    traer_documentos()
   
}


function  traer_extraordinarios(){
    console.log("Traer Extraordinarios")
    //Añadir row Estimaciones
    div = document.createElement('div');
    div_contenido = $('#documento-estimaciones').html();
    div.innerHTML = div_contenido;
    $("#panel-body-subproceso-61").append(div);
    
    //Añadir row Extra
    div = document.createElement('div');
    div_contenido= $('#documento-extra').html();
    div.innerHTML = div_contenido;
    $("#panel-body-subproceso-62").append(div);
               
}

function  traer_estimaciones(){
    console.log("traer estimaciones")
   
    idProyecto = $("#idProyecto").val();
    
    
    $.post( url + "proyectos/traer_no_estimaciones",
    { idProyecto: idProyecto}, function( data ) {
                    
        console.log(data) 
        var no = data;
        if (data > 0){
            traer_documentos_estimaciones(no)
        }
        
        
                 
    });
    
   
               
}

function  traer_solicitudes(){
    
    idProyecto = $("#idProyecto").val();
    
    
    $.post( url + "proyectos/traer_no_solicitudes",
    { idProyecto: idProyecto}, function( data ) {
                    
        console.log(data) 
        var no = data;
        if (data > 0){
            traer_documentos_solicitudes(no)
        }
                
    });
                
}

function traer_documentos_solicitudes(no){
    $.post( url + "proyectos/traer_documentos_solicitudes",
            function( data ) {
     
                $("#c-solicitudes").html("");
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
                    traer_preregistros_solicitudes()
                }

            
            
    
        });
}

function traer_documentos_estimaciones(no){
    $.post( url + "proyectos/traer_documentos_estimaciones",
            function( data ) {
     
                $("#c-estimaciones").html("");
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
                    traer_preregistros_estimaciones()
                }

            
            
    
        });
}

function  agregar_estimaciones(){
   
    no = $('#noEstimaciones').val();
    idProyecto = $("#idProyecto").val();
    
    
    $.post( url + "proyectos/agregar_estimaciones",
    { 
        idProyecto: idProyecto,
        no: no,
       
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
                 
    }, "json");
    
   
               
}

function  agregar_solicitudes(){
   
    no = $('#noSolicitudes').val();
    idProyecto = $("#idProyecto").val();
    
    
    $.post( url + "proyectos/agregar_solicitudes",
    { 
        idProyecto: idProyecto,
        no: no,
       
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
            console.log(div_contenido)
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

function traer_documentos(){
     $.ajax({
        url: url + 'proyectos/traer_documentos',
        type: 'POST',
        timeout: 10000,
        beforeSend: function(){
            console.log('Ha surgido un esperar.')
            //$("#panel-body-subproceso-"+id).html('<div class="spinner" ><i class="fa fa-spinner fa-5x" aria-hidden="true"></i></div>');
        },
        error: function(){
            $("#panel-body-subproceso-"+id).html('Error');
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){

            var contenido = "";
            for (i = 0; i < respuesta.length;  i++) {

                id = respuesta[i].idSubProceso;
                ///console.log("Sunproceso " +id)
                //$("#panel-body-subproceso-"+id).html('');

                obj = respuesta[i]
                div = document.createElement('div');

                
                div_contenido = $('#documento').html();
                
                //Remplazar en el contenido
                div_contenido = div_contenido.replace( /{id}/g, obj.id);
                div_contenido = div_contenido.replace(/{Nombre}/g, obj.Nombre);
                div_contenido = div_contenido.replace(/{idTipoProceso}/g, obj.idProceso);
                div_contenido = div_contenido.replace(/{idSubTipoProceso}/g, obj.idSubProceso);
               

                //Fin Remplazar en el contenido
               
                div.innerHTML = div_contenido;
                
                
                $("#panel-body-subproceso-"+id).append(div);
                
                
            }
            traer_preregistrados()
            
        }
    });
}



function traer_preregistrados(){
     $.ajax({
        url: url + 'proyectos/traer_preregistrados',
        type: 'POST',
        timeout: 10000,
        data: {idProyecto: $("#idProyecto").val()},
        beforeSend: function(){
            
        },
        error: function(){
            
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){
            console.log(respuesta)
           

           for(var i=0; i <respuesta.length; i++){
                

                idDocumento = respuesta[i].idDocumento;
                

                $('#original'+ idDocumento).val(respuesta[i].original)
                $('#copia'+ idDocumento).val(respuesta[i].copia)
                $('#observacion'+ idDocumento).removeAttr("disabled"); 
                $('#observacion'+ idDocumento).val(respuesta[i].observacion); 
                if(respuesta[i].NA == 1){
                    $('#no_aplica'+ idDocumento).attr("checked", true);
                }

           }  
            
        }
    });
}

function traer_preregistros_estimaciones(){
     $.ajax({
        url: url + 'proyectos/traer_preregistros_estimaciones',
        type: 'POST',
        timeout: 10000,
        data: {idProyecto: $("#idProyecto").val()},
        beforeSend: function(){
            
        },
        error: function(){
            
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){
            console.log(respuesta)
           

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
    });
}

function traer_preregistros_solicitudes(){
     $.ajax({
        url: url + 'proyectos/traer_preregistros_solicitudes',
        type: 'POST',
        timeout: 10000,
        data: {idProyecto: $("#idProyecto").val()},
        beforeSend: function(){
            
        },
        error: function(){
            
            console.log('Ha surgido un error.')
        },
        success: function(respuesta){
            console.log(respuesta)
           

           for(i=0; i <respuesta.length; i++){
                
                obj = respuesta[i]
                idDocumento = obj.idDocumento;
                
                console.log( idDocumento+'-s'+obj.noSolicitud)
                
                $('#original'+ idDocumento+'-s'+respuesta[i].noSolicitud).val(respuesta[i].original)
                $('#copia'+ idDocumento+'-'+respuesta[i].noSolicitud).val(respuesta[i].copia)
                $('#observacion'+ idDocumento+'-s'+respuesta[i].noSolicitud).removeAttr("disabled"); 
                $('#observacion'+ idDocumento+'-s'+respuesta[i].noSolicitud).val(respuesta[i].observacion); 
                if(respuesta[i].NA == 1){
                    $('#no_aplica'+ idDocumento+'-s'+respuesta[i].noSolicitud).attr("checked", true);
                }
                

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
    
    preregistrar_documento(idDocumento, valor, tipo_documento);
    
    
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

function preregistrar_documento(idDocumento, valor, tipo_documento){
    idProyecto = $("#idProyecto").val();
    
    $.post( url + "proyectos/preregistrar_estimacion",
    { 
        tipo_documento:tipo_documento,
        idProyecto: idProyecto,
        idDocumento: idDocumento,
        valor: valor,
    }, function( data ) {
                    
        console.log(data)  
        if (data == 1){
            $("#"+tipo_documento+idDocumento).css("border", "1px solid green");   
            $("#observacion"+idDocumento).removeAttr("disabled"); 
        }else {
            $("#"+tipo_documento+idDocumento).css("border", "1px solid red"); 
        }
    });
}

function preregistrar_documento_estimacion(idDocumento, valor, tipo_documento, numero){
    idProyecto = $("#idProyecto").val();
    
    $.post( url + "proyectos/preregistrar_estimacion",
    { 
        tipo_documento:tipo_documento,
        idProyecto: idProyecto,
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
    idProyecto = $("#idProyecto").val();
    
    $.post( url + "proyectos/preregistrar_solicitud",
    { 
        tipo_documento:tipo_documento,
        idProyecto: idProyecto,
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

function check_preregistrar(obj, idDocumento){
    
    tipo_documento = 'NA';
    
    if (obj.checked){
       valor = 1; 
    }
    else{
        valor = 0;    
    }
    preregistrar_documento(idDocumento, valor, tipo_documento);
	
}

function check_preregistrar_estimacion(obj, idDocumento, numero){
    
    tipo_documento = 'NA';
    
    if (obj.checked){
       valor = 1; 
    }
    else{
        valor = 0;    
    }
    preregistrar_documento_estimacion(idDocumento, valor, tipo_documento, numero);
	
}

function check_preregistrar_solicitud(obj, idDocumento, numero){
    
    tipo_documento = 'NA';
    
    if (obj.checked){
       valor = 1; 
    }
    else{
        valor = 0;    
    }
    preregistrar_documento_solicitud(idDocumento, valor, tipo_documento, numero);
	
}

function preregistrar_observacion(idDocumento){
    idProyecto = $("#idProyecto").val();
    observacion   = $("#observacion"+idDocumento).val();
    
    $.post( url + "proyectos/preregistrar_observacion",
    { 
        idProyecto: idProyecto,
        idDocumento: idDocumento,
        observacion: observacion,
    }, function( data ) {
                    
        console.log(data) 
        if (data == 1){
            $("#observacion"+idDocumento).css("border", "1px solid green");   
          
        }else {
            $("#observacion"+idDocumento).css("border", "1px solid red");
        }
                 
    });
}

function preregistrar_observacion_estimacion(idDocumento, numero){
    idProyecto = $("#idProyecto").val();
    observacion   = $("#observacion"+idDocumento+'-'+numero).val();
    
    $.post( url + "proyectos/preregistrar_observacion_estimacion",
    { 
        idProyecto: idProyecto,
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
    idProyecto = $("#idProyecto").val();
    observacion   = $("#observacion"+idDocumento+'-s'+numero).val();
    
    $.post( url + "proyectos/preregistrar_observacion_solicitud",
    { 
        idProyecto: idProyecto,
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
                //console.log(data.retorno);
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





