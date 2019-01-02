$(document).ready(function(){
    
    inicializar ($("#idTransferencia").val());
    
    
     // para ahorrar un poco de espacio voy a definir a las listas como variables
    var $lista1 = $('#lista1'), $lista2 = $('#lista2');
    // Activo draggable a la primera lista
    $('li',$lista1).draggable({
        revert: 'invalid',      
        helper: 'clone',        
        cursor: 'move'
    });
       // asigno droppable en la lista1 hacia la lista2
    $lista1.droppable({
        accept: '#lista2 li',
        drop: function(ev, ui) {
                       // Al hacer drop se borra el elemento
            deleteLista2(ui.draggable);
        }
    });
    // Asigno draggable a la lista2
    $('li',$lista2).draggable({
        revert: 'invalid',
        helper: 'clone',    
        cursor: 'move'
    });
       // Genero droppable para la segunda lista
    $lista2.droppable({
        accept: '#lista1 > li',
        drop: function(ev, ui) {
            deleteLista1(ui.draggable);     
        }
    });
    // Genero el borrado de items con el evento drop
    function deleteLista1($item) {
        $item.fadeOut(function() {
                     // Agrego el item dropeado y lo hago aparecer
            $($item).appendTo($lista2).fadeIn();
        });
        $item.fadeIn();
    }
    function deleteLista2($item) {
        $item.fadeOut(function() {          
                        /// Agrego el item dropeado y lo hago aparecer
            $item.appendTo($lista1).fadeIn();
        });
    }
    
    $("#obra").select2({
        placeholder: "Ingresa OT",
        ajax: {
            url: url + 'transferencia/ot_json',
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
            var idInicial = $("#obra").val();
            return $.post( url + 'transferencia/ot_json', { id: idInicial }, function( data ) {
                return callback(data.results[0]);

            }, "json");

        }
    });
    
    $("#checkTodos").change(function () {
      $("input[name='detalles[]']").prop('checked', $(this).prop("checked"));
  });
});


 function inicializar(idTransferencia){
    console.log("inicializar " + idTransferencia ); 
    $.post( url + "transferencia/get_cajas_envio" ,{ idTransferencia:idTransferencia }, function( data ) {
        console.log( data ); 

        for (var i=0; i < data.length; i++){

            //Pintar Cajas
            obj = {};
            obj.idCaja = data[i].id;
            obj.numeroCaja = caja +1;
            console.log(obj) 
            agregarCaja(obj)
            caja = caja +1
            console.log(caja +" Cajas Totales")
            //buscar Filas de la Caja

            
            /*$.post( url + "transferencia/get_detalles_envio",{ idCaja:data[i].id }, function( data ) {
                console.log( data ); 
                /*
                for (var j=0; j < data.length; j++){

                    //Pintar Filas
                    obj = {};

                    obj.idDetalle = data[j].id;
                    obj.numeroCaja = data[j].No_Caja;
                    obj.idCaja = data[j].idCaja;

                    if (data[j].No_Carpeta) {
                         obj.No_carpeta = data[j].No_Carpeta;
                    } else {
                         obj.No_carpeta =  "";
                    }



                    if (data[j].ot) {
                        obj.ot = data[j].ot;
                    } else {
                         obj.ot =  "";
                    }

                    if (data[j].Obra) {
                         obj.obra = data[j].Obra;
                    } else {
                         obj.obra =  "";
                    }

                    if (data[j].identificador) {
                         obj.identificador = data[j].identificador;
                    } else {
                         obj.identificador=  "";
                    }

                    if (data[j].idEjercicio) {
                          obj.anio = data[j].idEjercicio;
                    } else {
                          obj.anio =  "";
                    }

                    if (data[j].fojas) {
                          obj.fojas = data[j].fojas;
                    } else {
                          obj.fojas =  "";
                    }

                    obj.adm = data[j].adm;
                    obj.leg = data[j].leg;
                    obj.con = data[j].con;

                    if (data[j].observaciones) {
                          obj.observaciones = data[j].observaciones;
                    } else {
                          obj.observaciones =  "";
                    }



                    console.log(obj)
                    agregarFila(obj, data[j].idCaja);


                    //buscar Filas de la Caja

                } */
/*
            }, "json");*/
        }

    }, "json");

}

//Visualmente
function agregarCaja(obj){

    div = document.createElement('div');

    div_contenido = $('#text-caja').val();

    //Como ocpamos 4 veces la propiedad 
    for(i=0 ; i <5 ;i++){
        for( prop in obj){
            console.log(prop  + "  " +  obj[prop]);
            div_contenido = div_contenido.replace('{'+prop+'}', obj[prop]);

        }
    }

    //console.log(div_contenido)
    div.innerHTML = div_contenido;

    document.getElementById('div-cajas').appendChild(div);
    $("#div-cajas").css("display", "block")
}


function traer_detalles_entregados(){
    obra = $("#obra").val();
    console.log(obra)
    $.post( url + 'transferencia/traer_detalles_entregados', { id: obra }, function( data ) {
                console.log(data)
                $("#principal").css("display", "none");
                
                
                for(i=0 ; i < data.length ;i++){
                    obj = data[i];
                    tr = document.createElement('tr');
                    cont = $('#text-tr').val();
                    //console.log(cont)
                    //remplazar contenido
                    
                    cont = cont.replace(/{id}/g, obj.id);
                    cont = cont.replace(/{Folio}/g, obj.folio);
                    cont = cont.replace(/{Direccion}/g, obj.Nombre);
                    cont = cont.replace(/{Caja}/g, obj.No_Caja);
                    cont = cont.replace(/{Carpeta}/g, obj.No_Carpeta);
                    
                    //Agregar el tbody
                    tr.innerHTML = cont;
                    $("#contenido").append(tr);
                    
                    console.log(cont)
                  
                }
                
                

            }, "json");
}

function enviar_a_caja(elemento){
   
            
            //eliminar td
            //console.log($(this).val());
            padre = $(elemento).parents('tr');
            console.log(padre)
            envio = padre;
            envio_html = "<tr>" + envio.html() + "</tr>";
            envio_html = envio_html.replace(/enviar_a_caja/g, "regresar_a_listado");
            envio_html = envio_html.replace(/fa-caret-right/g, "fa-caret-left");
            envio_html = envio_html.replace(/detalles_listado/g, "detalles_envio");
            console.log(envio_html);
            padre.remove();
            
            //agregar en contenido envio
            $("#contenido_envio").append(envio_html);
            
            
        
}

function regresar_a_listado(elemento){
   
            
            //eliminar td
            //console.log($(this).val());
            padre = $(elemento).parents('tr');
            envio = padre;
            envio_html = "<tr>" + envio.html() + "</tr>";
            envio_html = envio_html.replace(/regresar_a_listado/g, "enviar_a_caja");
            envio_html = envio_html.replace(/fa-caret-left/g, "fa-caret-right");
            envio_html = envio_html.replace(/detalles_envio/g, "detalles_listado");
            console.log(envio_html);
            padre.remove();
            
            //agregar en contenido envio
            $("#contenido").append(envio_html);
            
            
        
}




