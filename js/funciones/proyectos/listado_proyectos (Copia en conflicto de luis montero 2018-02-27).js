$(document).ready(function(){ 
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

function nuevo_preregistro(){
    idArchivo  = $("#orden_trabajo").val();
    $.post( url + "proyectos/crear_folio", { idArchivo: idArchivo }, function( data ) {
        console.log(data)
        if (data > 0){
            location.href = url + "proyectos/editar/" + data;
        }
        
      });
}


