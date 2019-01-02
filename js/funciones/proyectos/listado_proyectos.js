$(document).ready(function(){ 
    
    $('#t_listado').dataTable({
                    'bProcessing': true,
                    //'sScrollY': '400px',                    

                    'sPaginationType': 'bs_normal',
                    'sDom': '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                    'iDisplayLength': 10,
                    'aaSorting': [[1, 'desc']],
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
    
    $("#orden_trabajo").select2({
        placeholder: "Asignar OT",
        ajax: {
            url: url + "proyectos/ot_json",
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
            return $.post( url + "proyectos/ot_json", { id: idInicial }, function( data ) {
                return callback(data.results[0]);
            }, "json");

        }
    });  
    
})

function marcar_obra(obj) {   
    if (obj.checked){
        document.getElementById('t-banco').disabled = true;
        $('#t-obra').val("1");
    }
    else{
        console.log("desmarcado obra")
        document.getElementById('t-banco').disabled = false;
        $('#t-obra').val("");
        
    }
}

function marcar_banco(obj) {   
    if (obj.checked){
        document.getElementById('t-obra').disabled = true;
        $('#t-banco').val("1");
    }
    else{
        console.log("desmarcado banco")
        document.getElementById('t-obra').disabled = false;
        $('#t-banco').val("");
       
    }
}

function validar(f){ 
    valido=false; 
    for(a=0;a<f.elements.length;a++){ 
        if(f[a].type == "text"){ 
            valor = document.getElementById("orden_trabajo").value;
            if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
                console.log("nulo")
              valido=false; 
               break 
            }
           
           
        }
        if(f[a].type=="checkbox" && f[a].checked==true){ 
            valido=true; 
            break 
            
        } 
        
        

    } 
    
    if(!valido){ 
        $.alert({
            icon: 'fa fa-warning',
            title: 'Error!',
            
            content: 'Falta Marcar alguno de los campos!',
            type: 'red',
            typeAnimated: true,
        });
        return false 
    } 

}

function nuevo_preregistro(){
    idArchivo  = $("#orden_trabajo").val();
    $.post( url + "proyectos/crear_folio", { idArchivo: idArchivo }, function( data ) {
        console.log(data)
        if (data > 0){
            location.href = url + "proyectos/editar/" + data;
        }
        
      });
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


