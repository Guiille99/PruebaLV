let actualTheme = localStorage.getItem("theme"); //Tema almacenado

function getTheme(){
    if (actualTheme!=null) { //Si hay un tema almacenado en la cookie
        return actualTheme;
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'; //Devolvemos el tema dependiendo del tema del SO
}

function setTheme(theme){
    if (theme==="auto" && window.matchMedia('(prefers-color-scheme: dark)').matches) { //Si lo ponemos en auto y el tema del SO es oscuro
        $("html").attr("data-bs-theme", "dark");
    }
    else{
        $("html").attr("data-bs-theme", theme);
    }
}

function showActualTheme(theme){
    let iconTheme = $(".theme-icon");
    document.querySelectorAll(".theme").forEach(element => {
        element.classList.remove("active");
    });

    $("."+theme+"-mode").addClass("active");
    if (theme=="light") {
        iconTheme.removeClass("bi bi-moon-fill");
        iconTheme.removeClass("bi bi-circle-half");
        iconTheme.addClass("bi bi-sun");
    }
    else if(theme=="dark"){
        iconTheme.removeClass("bi bi-sun");
        iconTheme.removeClass("bi bi-circle-half");
        iconTheme.addClass("bi bi-moon-fill");
    }
    else{
        iconTheme.removeClass("bi bi-sun");
        iconTheme.removeClass("bi bi-moon-fill");
        iconTheme.addClass("bi bi-circle-half");
    }
}

setTheme(getTheme());

//Si cambiamos la configuración de tema del SO y el tema actual es auto
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    actualTheme = localStorage.getItem("theme");
    if (actualTheme !== 'light' || actualTheme !== 'dark') {
      setTheme(getTheme())
    }
})

$(document).ready(function(){
    showActualTheme(actualTheme);
    document.querySelectorAll(".theme").forEach(themeBtn =>{
        themeBtn.addEventListener("click", ()=>{
            let theme = themeBtn.getAttribute("data-theme-value");
            localStorage.setItem("theme", theme); //Actualizamos la cookie
            setTheme(theme); //Actualizamos el tema dependiendo del que seleccionemos
            showActualTheme(theme);
            // alert(theme);
        })
    })
})