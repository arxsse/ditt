$(function() {
    const wizard = document.querySelector("#wizard-checkout");
    const form = wizard.querySelector("#wizard-checkout-form");

    stepper = new Stepper(wizard, { linear: true });
    const allTriggers = Array.from(wizard.querySelectorAll(".step-trigger"));

    wizard.addEventListener(
        "click",
        function(e) {
            const trigger = e.target.closest(".step-trigger");
            if (!trigger) return;

            const idx = allTriggers.indexOf(trigger);

            if (idx > stepper._currentIndex) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        },
        true
    );

    // (Opcional) Apariencia y accesibilidad: marca como deshabilitados los futuros
    function refreshHeaderLocks() {
        allTriggers.forEach((btn, i) => {
            const locked = i > stepper._currentIndex;
            btn.classList.toggle("disabled", locked);
            btn.setAttribute("aria-disabled", locked ? "true" : "false");
            // Si quieres bloqueo por CSS duro:
            // btn.style.pointerEvents = locked ? "none" : "";
        });
    }
    refreshHeaderLocks();
    wizard.addEventListener("shown.bs.stepper", refreshHeaderLocks);

    const btnNextList = Array.from(form.querySelectorAll(".btn-next"));
    const btnPrevList = Array.from(form.querySelectorAll(".btn-prev"));

    btnNextList.forEach(btn => {
        btn.addEventListener("click", () => {
            if (stepper._currentIndex === 0) {
                if ($('#titulo').val().trim() === '') {
                    const msj = "El campo título es obligatorio.";
                    $("#titulo").addClass("is-invalid");
                    $(`[for="titulo"]`).addClass('is_invalid')
                    $("#msjerror_titulo").text(msj);
                    $('#wizard-checkout-form .is-invalid').first().focus()
                    return;
                } else {
                    limpieza('#wizard-checkout-form', true)
                }
            }
            if (stepper._currentIndex === 1) {

                if ($('input[name="idtipoderechoautor"]:checked').val() == 1) {
                    if ($('#urlcodigofuente').val().trim() === '') {
                        const msj = "El campo URL código fuente es obligatorio.";
                        $("#urlcodigofuente").addClass("is-invalid");
                        $(`[for="urlcodigofuente"]`).addClass('is_invalid')
                        $("#msjerror_urlcodigofuente").text(msj);
                        $('#wizard-checkout-form .is-invalid').first().focus()
                        return;
                    } else {
                        limpieza('#wizard-checkout-form', true)
                    }
                }
                if (files_tmp.length != max_files) {
                    const msj = "Por favor, suba los " + max_files + " archivos requeridos.";
                    $("#dropzone-basic").addClass("is_invalidfile");
                    $("#msjerror_dropzone-basic").html(msj);
                    return;
                }

                if (validar_archivos(data_requisitos, files_tmp) === false) {
                    const msj = "Es necesario que los nombres de los archivos coincidan, por favor ajústelos para continuar.";
                    $("#dropzone-basic").addClass("is_invalidfile");
                    $("#msjerror_dropzone-basic").html(msj);
                    return;
                }
            }
            stepper.next();
        });
    });

    btnPrevList.forEach(btn => {
        btn.addEventListener("click", () => {
            if (stepper._currentIndex > 0) stepper.previous();
        });
    });

    function validar_archivos(data_requisitos, files_tmp) {
        const requisitosNombres = data_requisitos.map(r => r.descripcion.trim())
        const archivosNombres = files_tmp.map(f => f.name.trim())

        requisitosNombres.sort()
        archivosNombres.sort()
        return requisitosNombres.every((nombre, index) => nombre === archivosNombres[index])
    }
});
