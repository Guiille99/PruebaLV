$(document).ready(function(){
    $(".microfono-icon").click(toggleSpeech);
    let utterance = new SpeechSynthesisUtterance();
    let isPlaying = false;

    function toggleSpeech() {
        let btnMicrofono = $(".microfono-icon");
        let isChecked = btnMicrofono.attr("aria-checked");
        let texto = $(".post__content-body").html();
        // let utterance = new SpeechSynthesisUtterance();
        if (isChecked=="false") {
            btnMicrofono.attr("aria-checked", "true");
            btnMicrofono.removeClass("bi-mic-fill");
            btnMicrofono.addClass("bi-pause-fill");
            utterance.text = texto;
            speechSynthesis.speak(utterance);
            isPlaying = true;
        } else {
            btnMicrofono.attr("aria-checked", "false");
            btnMicrofono.removeClass("bi-pause-fill");
            btnMicrofono.addClass("bi-mic-fill");
            speechSynthesis.cancel();
            isPlaying = false;
        }
    }

    //Evento que se ejecuta cuando acaba de leer el texto
    utterance.onend = function(event){
        speechSynthesis.cancel();
        $(".microfono-icon").removeClass("bi-pause-fill")
        $(".microfono-icon").addClass("bi-mic-fill")
    }
    //Para de reproducir cuando el usuario salga de la página
    $(window).on("beforeunload", function(){
        if (isPlaying) {
            speechSynthesis.cancel();
        }
    });
})