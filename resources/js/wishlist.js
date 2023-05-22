$(document).ready(function(){
    //Al pulsar el botón de eliminar de la wishlist en la tabla
    $(".btn-delete-wishlist").click(function(){
        let id = $(this).attr("data-idlibro");
        url = url.replace('num', id);
        // console.log(url);
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
                $(".data").prepend(
                    "<div class='spinner-container position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center'>"+
                    "<div class='spinner spinner-border' role='status'>"+
                        "<span class='visually-hidden'>Loading...</span>"+
                    "</div>"+
                "</div>");
            },
            success: function (data) {
                location.reload();
            },
        });
    })
})