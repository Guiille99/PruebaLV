$(document).ready(function(){$(".form-add-to-cart").submit(function(t){t.preventDefault();let a=$(this)[0][1].attributes["data-id"].value,e=$("input[name='_token']").val();return $.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$.ajax({async:!0,method:"POST",dataType:"html",contentType:"application/x-www-form-urlencoded",url,data:{token:e,id:a},success:function(){$(".carrito__cantidad").load(urlCantidadCarrito),$("#add-to-cart__message").css("display","block"),$.ajax({type:"GET",url:urlCartContent,data:{token:e},success:function(n){$(".offcanvas-content").html(n)}}),setTimeout(function(){$("#add-to-cart__message").fadeOut(2e3)},3e3)}}),!1}),$(".btn-delete-to-cart").click(function(){let t=$(this).attr("data-idlibro");url=url.replace("num",t),$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$.ajax({async:!0,url,method:"DELETE",beforeSend:function(){$(".productos__carrito").prepend("<div class='spinner-container position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center'><div class='spinner spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div></div>")},success:function(a){location.reload()}})})});