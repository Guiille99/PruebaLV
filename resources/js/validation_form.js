(() => {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
  
        form.classList.add('was-validated')
      }, false)
    })
})()

$(document).ready(function(){
  $("#confirm-order").click(validaCP);
  $("#confirm-order").click(function(){
    $(".needs-validation").addClass("was-validated")
  });

  // $("#btn-finalizar-compra").click(validaTarjeta);
  // $("#btn-finalizar-compra").click(validaTlfn);
  $("#btn-finalizar-compra").click(validaciones);
})

function validaciones(){
  let metodo = $(this).parent().parent().parent().parent().attr("data-metodo");
  if (metodo=="tarjeta") {
    validaTarjeta();
  }
  else if(metodo=="bizum"){
    validaTlfn();
  }
}
function validaCP() {
  let input = document.getElementById("cp");
  let cp = input.value;
  let patron = /^\d{5}$/

  if (!patron.test(cp)) {
    input.setCustomValidity("Formato incorrecto. Ej: 12345");
  } else {
    input.setCustomValidity("");
  }
}

function validaTarjeta(){
  let input = document.getElementById("cc-number");
  let cc = input.value;
  let patron = /^\d{4}\s\d{4}\s\d{4}\s\d{4}$/

  if (!patron.test(cc)) {
    input.setCustomValidity("Formato incorrecto. Ej: #### #### #### ####");
  } else {
    input.setCustomValidity("");
  }
}

function validaTlfn() {
  let input = document.getElementById("tlfn");
  let tlfn = input.value;
  let patron=/^[6-7]\d{8}$/;

  if (!patron.test(tlfn)) {
    input.setCustomValidity("Formato incorrecto. Ej: 612345678");
  } else {
    input.setCustomValidity("");
  }
}