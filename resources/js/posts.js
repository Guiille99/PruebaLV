$(document).ready(function(){
    $(".play-btn").click(toggleSpeech);
    let utterance = new SpeechSynthesisUtterance();
    let isPlaying = false;

    function toggleSpeech() {
        let btnMicrofono = $(".play-btn");
        let isChecked = btnMicrofono.attr("aria-checked");
        let texto = $(".post__content-body").text();
        if (isChecked=="false") {
            btnMicrofono.attr("aria-checked", "true");
            btnMicrofono.removeClass("bi-volume-down-fill");
            btnMicrofono.addClass("bi-pause-fill");
            utterance.text = texto;
            speechSynthesis.speak(utterance);
            isPlaying = true;
        } else {
            btnMicrofono.attr("aria-checked", "false");
            btnMicrofono.removeClass("bi-pause-fill");
            btnMicrofono.addClass("bi-volume-down-fill");
            speechSynthesis.cancel();
            isPlaying = false;
        }
    }

    //Evento que se ejecuta cuando acaba de leer el texto
    utterance.onend = function(event){
        speechSynthesis.cancel();
        $(".play-btn").removeClass("bi-pause-fill")
        $(".play-btn").addClass("bi-volume-down-fill")
    }
    //Para dejear de reproducir cuando el usuario salga de la página
    $(window).on("beforeunload", function(){
        if (isPlaying) {
            speechSynthesis.cancel();
        }
    });
})