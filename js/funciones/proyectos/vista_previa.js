function enviar(idProyecto){
    
    $.confirm({
        title: "Enviar Proyecto",
        content: "¿Deseas enviar proyecto?",
        type: 'orange',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-orange',
                action: function(){
                    
                    $.post( url + "proyectos/cambiar_estatus/" +idProyecto + "/2",
                         function( data ) {
                            
                            console.log(data) 
                            location.href= url + "proyectos/listado/";

                        });
                }
            },
            Cerrar: function () {
                
            }
        }
    });
}

function asignar_ubicacion(){
                
                
    $.ajax({
        data:  $("#form-detalles").serialize(),
        url:   url + "proyectos/asignar_ubicacion",
        dataType: 'json',                  
        type:  'POST',
        success:  function (data) {
            console.log(data.retorno)
            if (data.retorno){
               // location.reload();
            } else {
                $("#ubicacion_dinamica").css("display", "block");
                $("#str_ubicacion").html("Error al agregar proyectos, intenta nuevamente")
                $("#select2-chosen-1").html("");
                $("#carpeta").val("");
                $("#div_carpetas").html("")
                $("#div_carpetas").css("display", "none")
            }
            //$("#tabla-principal").hide();

            //actualizar_tabla();
            //$("#modal-agregar-cat").modal('hide');
            //$("#str_ubicacion").html($("#select2-chosen-1").html() + ": " +data["Isla"] + "." + data["Columna"] + "." + data["Fila"] + "." + data["numero"])
            //$("#ubicacion_dinamica").css("display", "block");
            //$("#select2-chosen-1").html("");
            //$("#carpeta").val("");
            //$("#cm").val("");

        }
    });

}

function ver_div_carpetas(){
    $("#div_carpetas").html("");
  
    obj = {};
     noCarpetas = $('#carpeta').val();
     for(i=0 ; i < noCarpetas ;i++){

         obj.noCarpeta = "Carpeta "+ (i+1);
         obj.idCarpeta = i+1;
         //console.log(obj);
         nuevaCarpeta(obj)

     }

     $("#asignar").removeAttr("disabled");



}

function nuevaCarpeta(obj){
    div = document.createElement('div');

    div_contenido = $('#text-carpeta').val();

    for( prop in obj){
        //console.log(prop  + "  " +  obj[prop]);
        div_contenido = div_contenido.replace('{'+prop+'}', obj[prop] );
        //console.log(div_contenido)
    }
    div.innerHTML = div_contenido;

    document.getElementById('div_carpetas').appendChild(div);
    $("#div_carpetas").css("display", "block")


}

function retornar(idProyecto){
    
    $.confirm({
        title: "Retornar Proyecto",
        content: "¿Deseas regresar el proyecto?",
        type: 'orange',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-orange',
                action: function(){
                    
                    $.post( url + "proyectos/cambiar_estatus/" +idProyecto + "/1",
                         function( data ) {
                            
                            console.log(data) 
                            location.href= url + "proyectos/listado/";

                        });
                }
            },
            Cerrar: function () {
                
            }
        }
    });
}
function aceptar(idProyecto){
    
    $.confirm({
        title: "Enviar Proyecto",
        content: "¿Deseas aceptar proyecto?",
        type: 'orange',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-orange',
                action: function(){
                    
                    $.post( url + "proyectos/cambiar_estatus/" +idProyecto + "/3",
                         function( data ) {
                            
                            console.log(data) 
                            $(".btn-warning").removeAttr("disabled");
                            $("#aceptar").attr("disabled", true);
                            $("#regresar").attr("disabled", true);
                            //location.href= url + "proyectos/listado/";

                        });
                }
            },
            Cerrar: function () {
                
            }
        }
    });
}