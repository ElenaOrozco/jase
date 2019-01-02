$(function() {                
   radio = function(radio){
        radio =$(radio);
        $(radio).buttonset()
    }
    marcar = function(elemento){
        elemento = $(elemento);
        elemento.prop("checked", true);
    }
    desmarcar = function(elemento){
        elemento = $(elemento);
        elemento.prop("checked", false);
    }
    //$("#radioTodo").buttonset();
});