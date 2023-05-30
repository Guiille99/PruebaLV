import './bootstrap'
import '../css/app.scss'
import * as bootstrap from 'bootstrap'

$(document).ready(function(){
    ellipsis_box(".libro__titulo", 18);
    $("#togglePassword").click(togglerPassword);
    $(".togglePassword").click(togglerPassword);
    $("#togglePasswordConfirm").click(togglerPasswordConfirm);
    $("#btnBack").click(goToUp);

    //Evento que se ejecuta cuando añado o elimino un libro a la wishlist
    $(document).on('toggle-wishlist', function(event){
        $('body').append("<div id='alert-index' class='alert alert-success'><i class='bi bi-check-circle'></i> "+ event.detail.message +"</div>");
        setTimeout(function(){
        $(".alert-success").fadeOut(2000, function(){
            $(".alert-success").remove();
        });
        }, 3000)
    });

    //Evento que se ejecuta cuando hay un error con el manejo de la wishlist
    $(document).on('wishlist-error', function(event){
        if ($("#alert-error").length > 0) {
            $("#alert-error").remove();
        }
        $("header").after("<div id='alert-error' class='alert alert-danger alert-dismissible fade show my-2' role='alert'>"+
        "<i class='bi bi-exclamation-circle'></i> "+ 
        event.detail.message+ 
        "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>"+
    "</div>")
    });

    //Evento que se ejecuta cuando se realiza una ejecución correctamente en un livewire en la parte del administrador
    $(document).on('alert-admin-live-success', function(event){
        $('main').prepend("<div id='alert-index' class='alert alert-success'><i class='bi bi-check-circle'></i> "+ event.detail.message +"</div>");
        setTimeout(function(){
        $(".alert-success").fadeOut(2000, function(){
            $(".alert-success").remove();
        });
        }, 3000)
    });

    //Evento que se ejecuta cuando hay un error en un livewire en la parte del administrador
    $(document).on('alert-admin-live-error', function(event){
        if ($("#alert-error").length > 0) {
            $("#alert-error").remove();
        }
        $("main").prepend("<div id='alert-error' class='alert alert-danger alert-dismissible fade show my-2' role='alert'>"+
        "<i class='bi bi-exclamation-circle'></i> "+ 
        event.detail.message+ 
        "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>"+
    "</div>")
    });



    //Cambio el contenido del modal dependiendo del método de pago seleccionado
    $(".metodos-pago input[type='radio']").click(modalMetodoPago);

    //Alerta cuando actualiza el perfil en la página principal
    setTimeout(function(){
        $("#alert-index").fadeOut(2000);
    }, 3000)
    

    $(document).scroll(function(){
        //Al hacer scroll el sub-nav no se verá
        if (scrollY>3) {
            $('header').attr('class', 'header-2');
            $('.nav-top').attr('class', 'nav-top container-fluid position-fixed top-0 w-100 z-3');
        }
        else{
            $('header').attr('class', '');
            $('.nav-top').attr('class', 'nav-top container-fluid');
        }
        //Aparecerá el botón para volver hacia arriba de la página
        if (scrollY>100) {
            $("#btnBack").fadeIn();
        }
        else{
            $("#btnBack").fadeOut();
        }
    });
    if (scrollY>3) { //Lo pongo de nuevo para que cuando se pulse en el botón de comprar siga apareciendo el navbar sin la necesidad de hacer scroll
        $('header').attr('class', 'header-2');
        $('.nav-top').attr('class', 'nav-top container-fluid position-fixed top-0 w-100 z-3');
    }

    //Cuando escribe una letra para el título del post
    $("#form-new-post #titulo").keyup(getSlug);
})


function goToUp() {
    scrollTo(0,0);
}

function ellipsis_box(elemento, max_chars){
	let titulos = $(elemento);
    for (let i = 0; i < titulos.length; i++) {
        if (titulos[i].innerHTML.length > max_chars) {
            let limite = titulos[i].innerHTML.substr(0, max_chars)+"...";
            titulos[i].innerHTML= limite;
        }   
    }
}

// OJO DE LOS CAMPOS PASSWORD
function togglerPassword(e){
    const password = $(this).prev();
    const type = password.attr('type') === 'password' ? 'text' : 'password';
    password.attr('type', type);

    if (type =='password') {
        $(this).removeClass('bi-eye-slash');
        $(this).addClass('bi-eye');
    }
    else{
        $(this).removeClass('bi-eye');
        $(this).addClass('bi-eye-slash');
    }
}
function togglerPasswordConfirm(e){
    const password = $('#password_confirmation');
    const type = password.attr('type') === 'password' ? 'text' : 'password';
    password.attr('type', type);
    // toggle the eye slash icon
    if (type=='password') {
        $(this).removeClass('bi-eye-slash');
        $(this).addClass('bi-eye');
    }
    else{
        $(this).removeClass('bi-eye');
        $(this).addClass('bi-eye-slash');
    }
}

//FUNCIÓN PARA FORMATEAR UNA CADENA A TIPO CREDIT CARD NUMBER
function formatCardNumber() {
   let value = $(this).val().toString();
    var v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '')
    var matches = v.match(/\d{4,16}/g);
    var match = matches && matches[0] || ''
    var parts = []

    for (let i=0, len=match.length; i<len; i+=4) {
        parts.push(match.substring(i, i+4))
    }

    if (parts.length) {
        $(this).val(parts.join(' '));
    } 
    else{
        $(this).val(v);
    }
}

function formatCardExpiry() {
    let value = $(this).val().toString(); 
    value = value.replace(
        /[^0-9]/g, '' // To allow only numbers
    ).replace(
        /^([2-9])$/g, '0$1' // To handle 3 > 03
    ).replace(
        /^(1{1})([3-9]{1})$/g, '0$1/$2' // 13 > 01/3
    ).replace(
        /^0{1,}/g, '0' // To handle 00 > 0
    ).replace(
        /^([0-1]{1}[0-9]{1})([0-9]{1,2}).*/g, '$1/$2' // To handle 113 > 11/3
    );
    
    $(this).val(value);
}

//Función que cambia los datos del modal dependiendo del método de pago seleccionado
function modalMetodoPago() {
    $("#confirm-order").attr({"data-bs-toggle": "modal", "data-bs-target":"#modal-metodo-pago"});
    let metodo = $(this)[0].id;
    $("#modal-metodo-pago").attr("data-metodo", metodo);
    if (metodo=="tarjeta") {
        $("#modal-metodo-pago .modal-title").html("Introduzca los datos de su tarjeta de crédito");
        $("#modal-metodo-pago .modal-body").html(
        "<div class='input-group'>"+
            "<span class='input-group-text'><i class='bi bi-credit-card'></i></span>"+
            "<input type='tel' name='cc-number' id='cc-number' class='form-control' maxlength='19' placeholder='Número de cuenta' required>"+
        "</div>"+
        "<div class='col-5'>"+
            "<input type='tel' name='cc-expiry' id='cc-expiry' class='form-control' placeholder='MM / YY' maxlength='5' required>"+
        "</div>"+
        "<div class='col-5'>"+
            "<input type='tel' name='cvc' id='cvc' class='form-control' placeholder='CVC' maxlength='3' required>"+
        "</div>");
    }
    else if(metodo=="paypal"){
        $("#modal-metodo-pago .modal-title").html("Introduzca los datos de su cuenta de PayPal");
        $("#modal-metodo-pago .modal-body").html("<div>"+
        "<label for='mail'>Correo electrónico *</label>"+
        "<input type='email' name='mail' id='mail' class='form-control' required>"+
        "</div>"+
        "<div>"+
            "<label for='passwd'>Contraseña *</label>"+
            "<input type='password' name='passwd' id='passwd' class='form-control' required>"+
        "</div>");
    }
    else{
        $("#modal-metodo-pago .modal-title").html("Introduzca su número de teléfono");
        $("#modal-metodo-pago .modal-body").html("<div>"+
        "<label for='tlfn'>Número de teléfono *</label>"+
        "<input type='tel' name='tlfn' id='tlfn' class='form-control' required> "+
        "</div>");
    }
    $("#cc-number").keyup(formatCardNumber);
    $("#cc-expiry").keypress(formatCardExpiry);
}

//FUNCIÓN QUE CARGA EL SLUG EN EL INPUT
function getSlug() {
    let titulo = $(this).val();
    let slug = generateSlug(titulo);
    $("#slug").val(slug);
}

//FUNCIÓN QUE GENERA EL SLUG
function generateSlug(titulo) {
    titulo = titulo.toLowerCase()
            .trim()
            .split(" ").join("-") //Reemplaza los espacios en blanco entre las palabras por guiones
            .replace(/[áéíóú]/gi, match => { //Elimina las tildes de las vocales
                switch (match) {
                    case 'á': return 'a';
                    case 'é': return 'e';
                    case 'í': return 'i';
                    case 'ó': return 'o';
                    case 'ú': return 'u';
                }
            })
            //Elimina todos los caracteres que no son letras, números, espacios en blanco o guiones y las ñ las reemplaza por n
            .replace(/[^\w\s-]/g, function(char){ 
                char = char.toLowerCase();
                return (char=='ñ') ? 'n' : '';
            })
    return titulo;
}