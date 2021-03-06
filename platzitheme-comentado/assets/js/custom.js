(function($) {  //ese inicio sirve para que wordpress sepa que es jquery
  console.log('Hola WordPress');
  $("#categorias-productos").change(function(){  //funcion que se ejecuta cuando el objeto categorias-productos cambia
      $.ajax({  //parametros fundamentales que recibe
          url: pg.ajaxurl,  //objeto definido en functions
          method: "POST",
          data:{
              "action" : "filtroProductos",   //funcion que procesa los datos
              "categoria" : $(this).find(":selected").val() //busca el opcion marcado en el selector
          },
          beforeSend: function(){ //antes de ejecutarse
              $("#resultado").html("Cargando...");
          },
          success:function(data){ //lo hace cuando se ejecuta correctamente
              let html = "";
              data.forEach(item => {  //agrega cada item a la variable
                  html += `<div class="col-md-4 col-12 my-3">
                      <figure>${item.imagen}</figure>
                      <h4 class="my-2">
                          <a href="${item.link}">${item.titulo}</a>
                      </h4>
                  </div>`;
              })
              $("#resultado").html(html); //cambia el div resultado por la variable html
          },
          error: function(error){ //cuando falla
              console.log(error);
          }
      });
  });


    //funcion para llamar a la API, cuando la pagina esta cargada
  $(document).ready(function(){
    $.ajax({
        url: pg.apiurl+"novedades/3", //se completa la ruta con los parametros a enviar
        method: "GET",
        beforeSend: function(){
            $("#resultado-novedades").html("Cargando...");
        },
        success:function(data){
            let html = "";
            data.forEach(item => {
                html += `<div class="col-md-4 col-12 my-3">
                    <figure>${item.imagen}</figure>
                    <h4 class="my-2">
                        <a href="${item.link}">${item.titulo}</a>
                    </h4>
                </div>`;
            })
            $("#resultado-novedades").html(html);
        },
        error: function(error){
            console.log(error);
        }
    });
  });
})(jQuery); //ese final sirve para que wordpress sepa que es jquery