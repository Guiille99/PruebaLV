$(document).ready(function () {
    let id = "";
    $("#btnAddTask").click(agregarTarea);
    $("#btnModifyTask").click(modificarTarea);
    $("#btnDeleteTask").click(eliminarTarea);

    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        height: "auto",
        dayMaxEvents: 3,
        expandRows: true,
        windowResize: function () {},
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        buttonText: {
            today: "Hoy"
        },
        views: {
            dayGridMonth: { buttonText: "Mes" },
            timeGridWeek: { buttonText: "Semana" },
            timeGridDay: { buttonText: "Día" },
        },
        selectable: true,
        events: url,
        eventDidMount: function(info) {
            if (info.event.extendedProps.status === 1) {
                var el = info.el;
                el.style.textDecoration = 'line-through';
            }
        },
        eventMouseEnter: function (info) {
            $(info.el).tooltip({
                title: info.event.title,
                placement: "top",
            });
        },
        dateClick: function (info) {
            limpiarFormulario();
            if (info.allDay) {
                $("#fecInicio").val(info.dateStr);
                $("#fecFin").val(info.dateStr);
            } else {
                let fechaHora = info.dateStr.split("T");
                $("#fecInicio").val(fechaHora[0]);
                $("#fecFin").val(fechaHora[0]);
                $("#horaInicio").val(fechaHora[1].substring(0, 5));
            }
            $("#tareaModal").html("Nueva tarea");
            $("#tarea_check-label").hide();
            $("#btnModifyTask").hide();
            $("#btnDeleteTask").hide();
            $("#btnAddTask").show();
            $("#modal-tarea").modal("show");
        },
        eventClick: function (info) {
            $("#tareaModal").html("Tarea");
            $("#btnAddTask").hide();
            $("#btnModifyTask").show();
            $("#btnDeleteTask").show();
            id = info.event.id;
            $("#tarea").val(info.event.title);
            $("#fecInicio").val(moment(info.event.start).format("YYYY-MM-DD"));
            $("#horaInicio").val(moment(info.event.start).format("HH:mm"));
            $("#fecFin").val(moment(info.event.end).format("YYYY-MM-DD"));
            $("#horaFin").val(moment(info.event.end).format("HH:mm"));
            $("#tarea_check-label").show();
            $("#colorFondo").val(info.event.backgroundColor);
            $("#colorTexto").val(info.event.textColor);

            if (info.event.extendedProps.status === 1) {
                $("#tarea_check").prop("checked", true);
            }

            $("#modal-tarea").modal("show");
        },
    });
    calendar.render();
    calendar.setOption("locale", "es");

    function agregarTarea() {
        let tarea = recuperarDatosFormulario();
        let token = $("input[name='_token']").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            async: true,
            method: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url: addTaskURL,
            data: {
                token: token,
                tarea: tarea.tarea,
                fechaInicio: tarea.fechaInicio,
                fechaFin: tarea.fechaFin,
                horaInicio: tarea.horaInicio,
                horaFin: tarea.horaFin,
                colorFondo: tarea.colorFondo,
                colorTexto: tarea.colorTexto,
            },
            success: function (data) {
                console.log(data);
                $("#modal-tarea").modal("hide");
                //Con esto refrescamos la vista
                calendar.prev();
                calendar.next();
            },
            error: function (error) {
                console.log(error);
            },
        });
    }

    function modificarTarea() {
        let tarea = recuperarDatosFormulario();
        let token = $("input[name='_token']").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            async: true,
            method: "PUT",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url: modifyTaskURL,
            data: {
                "id": id,
                "token": token,
                "tarea": tarea.tarea,
                "fechaInicio": tarea.fechaInicio,
                "fechaFin": tarea.fechaFin,
                "horaInicio": tarea.horaInicio,
                "horaFin": tarea.horaFin,
                "tareaRealizada": tarea.check,
                "colorFondo": tarea.colorFondo,
                "colorTexto": tarea.colorTexto,
            },
            success: function (data) {
                console.log(data);
                $("#modal-tarea").modal("hide");
                //Con esto refrescamos la vista
                calendar.prev();
                calendar.next();
            },
            error: function (error) {
                console.log(error);
            },
        });
    }

    function eliminarTarea(){
        let token = $("input[name='_token']").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            }
        });
        $.ajax({
            async: true,
            method: "DELETE",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url: deleteTaskURL,
            data: {
                "id": id,
                "token": token,
            },
            success: function (data) {
                $("#modal-tarea").modal("hide");
                //Con esto refrescamos la vista
                calendar.prev();
                calendar.next();
            },
            error: function (error) {
                console.log(error);
            },
        });
    }

    function recuperarDatosFormulario() {
        let tarea = {
            tarea: $("#tarea").val(),
            fechaInicio: $("#fecInicio").val(),
            horaInicio: $("#horaInicio").val(),
            fechaFin: $("#fecFin").val(),
            horaFin: $("#horaFin").val(),
            check: $("#tarea_check").prop("checked"),
            colorFondo: $("#colorFondo").val(),
            colorTexto: $("#colorTexto").val(),
        };
        return tarea;
    }

    function limpiarFormulario(){
        $("#tarea").val("");
        $("#fecInicio").val("");
        $("#horaInicio").val("");
        $("#fecFin").val("");
        $("#horaFin").val("");
        $("#colorFondo").val("#2596be");
        $("#colorTexto").val("#111111");
    }

    // $(".task .task-list-mark").click(function(){
    //     let parentContainer = $(this).parent().parent();
    //     let taskTitle = parentContainer.find(".title");
    //     let checkbox = parentContainer.find(".tarea_check");
    //     if (checkbox.prop("checked") == false) {
    //         taskTitle.css("text-decoration", "line-through");
    //     }
    //     else{
    //         taskTitle.css("text-decoration", "none");
    //     }
    // })

    // if ($(".task .tarea_check").prop("checked") == true) {
    //     taskTitle.css("text-decoration", "line-through");
    // }

    $(".tasks").change(function(){
        $(".tasklist__container .btn-modify").css("display", "block");
    })

});
