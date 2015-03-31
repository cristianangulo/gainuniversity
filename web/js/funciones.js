$(document).ready(function(){
  $( ".datepicker" ).datepicker();

  $("#sortable").sortable();
  //$("#sortable").disableSelection();

  $('.delete').click(function(){

    event.preventDefault();
    var son = $(this).parent();
    var parent = son.parent();

    parent.remove();

  });

  var ordenesColeccion;

  $('.add').on('click', function(){

    ordenesColeccion = $('tbody.ordenes');

    ordenesColeccion.data('index', ordenesColeccion.find(':input').length);

    addOrdenForm(ordenesColeccion);
  });

  function addOrdenForm(ordenesColeccion){
    var prototype = ordenesColeccion.data('prototype');

    var index = ordenesColeccion.data('index');

    var nuevaOrden = prototype.replace(/__name__/g, index);

    ordenesColeccion.data('index', index + 1);

    $('tbody.ordenes').append(nuevaOrden);
    var nuevaOrdenTR = $('<tr></tr>').append(nuevaOrden);
  }
});
