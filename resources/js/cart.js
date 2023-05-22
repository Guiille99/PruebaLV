$(document).ready(function(){
   
    //AÑADIR UN LIBRO AL CARRITO
    $(".form-add-to-cart").submit(function(e){
        e.preventDefault();
        // let url = "{{route('add_to_cart')}}";
        let id = $(this)[0][1].attributes['data-id'].value; //ID del libro
        let token = $("input[name='_token']").val();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            async: true, //Indica si la comunicación será asincrónica (true)
            method: "POST", //Indica el método que se envían los datos (GET o POST)
            dataType: "html", //Indica el tipo de datos que se va a recuperar
            contentType: "application/x-www-form-urlencoded", //cómo se
            url: url, //el nombre de la página que procesará la petición
            data: {
                "token": token,
                "id": id
            },
            success: function(data){
                data = JSON.parse(data);
                $(".carrito__cantidad").html(data.cantidad); //Actualizamos solo el número del carrito
                // location.reload();
                $('#add-to-cart__message').css("display", "block");
                //Obtenemos de nuevo el contenido del carrito a través de AJAX para que se actualice el offcanvas sin recargar la página
                $.ajax({
                    type: "GET",
                    url: urlCartContent,
                    data:{
                        "token": token
                    },
                    success: function(data){
                        $(".offcanvas-content").html(data);
                    }
                })
                
                setTimeout(function(){ //Degradado al desaparecer la alerta
                     $("#add-to-cart__message").fadeOut(2000);
                }, 3000)

            }
            });
         return false;
    });

    //ELIMINAR UN LIBRO DEL CARRITO MEDIANTE AJAX
    $('.btn-delete-to-cart').click(function(){
        // let url = "{{route('delete_to_cart', 'num')}}";
        let id = $(this).attr("data-idlibro");
        url = url.replace('num', id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            async: true,
            url: url,
            method: "DELETE",
            beforeSend: function(){
                $(".productos__carrito").prepend(
                    "<div class='spinner-container position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center'>"+
                    "<div class='spinner spinner-border' role='status'>"+
                        "<span class='visually-hidden'>Loading...</span>"+
                    "</div>"+
                "</div>");
            },
            success: function (data) {
                location.reload();
                // $('#alert-index').text(data.message);
                // $('#alert-index').css('display', 'block');
            },
        });
    })
})