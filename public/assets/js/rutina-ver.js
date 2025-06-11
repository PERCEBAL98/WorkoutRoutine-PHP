const btnRepeticiones = document.getElementById("btnRepeticiones");
const btnTiempo = document.getElementById("btnTiempo");
const btnGuardarRutina = document.getElementById("btnGuardarRutina");
const btnRepeticionesMobile = document.getElementById("btnRepeticionesMobile");
const btnTiempoMobile = document.getElementById("btnTiempoMobile");
const btnGuardarRutinaMobile = document.getElementById("btnGuardarRutinaMobile");
let rutinaEjercicios = [];
let rutinaVueltas = parseInt(document.getElementById("numVueltas").textContent, 10);
let rutinaRepeticiones = parseInt(document.getElementById("numRepeticiones").textContent, 10);
let rutinaDuacion = parseInt(document.getElementById("numDuracion").textContent, 10);
let rutinaDescanso = parseInt(document.getElementById("numDescanso").textContent, 10);
let mensajeGuardarRutina = true;

document.addEventListener("DOMContentLoaded", function () {
    btnRepeticiones.addEventListener("click", function () {
        let rutinaId = window.location.href.split("=")[1];
        if (rutinaId) {
            window.location.href = BASE_URL + "/realizar/rutina?ver=" + rutinaId + "&tipo=repeticiones";
        }
    });

    btnTiempo.addEventListener("click", function () {
        let rutinaId = window.location.href.split("=")[1];
        if (rutinaId) {
            window.location.href = BASE_URL + "/realizar/rutina?ver=" + rutinaId + "&tipo=tiempo";
        }
    });

    const sortableContainer = document.querySelector(".sortable-ejercicios");
    document.querySelectorAll(".ejercicio-card").forEach((el, i) => {
        rutinaEjercicios.push({
            id: el.getAttribute("data-id"),
            orden: i + 1
        });
    });

    new Sortable(sortableContainer, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: function () {
            rutinaEjercicios = [];
            document.querySelectorAll(".ejercicio-card").forEach((el, i) => {
                rutinaEjercicios.push({
                    id: el.getAttribute("data-id"),
                    orden: i + 1
                });
            });
            
            mostrarAvisoGuardar();
            btnGuardarRutina.disabled = false;
            btnGuardarRutinaMobile.disabled = false;
        }
    });
});

//-----------------------------------------------------------------------------
// *: 
//-----------------------------------------------------------------------------
function sincronizarBotones(mobile, target) {
  if (mobile && target) {
    mobile.addEventListener('click', (e) => {
      e.preventDefault();
      target.click();
    });
  }
}

sincronizarBotones(btnRepeticionesMobile, btnRepeticiones);
sincronizarBotones(btnTiempoMobile, btnTiempo);
sincronizarBotones(btnGuardarRutinaMobile, btnGuardarRutina);

//-----------------------------------------------------------------------------
// *: 
//-----------------------------------------------------------------------------
function mostrarAvisoGuardar() {
    if (mensajeGuardarRutina) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'info',
            title: 'Recuerda guardar la rutina para preservar los cambios',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#fff',
            color: '#3C3C43',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        mensajeGuardarRutina = false;
    }
}

//-----------------------------------------------------------------------------
// *: realiza petición AJAX para obtener el ejercicio seleccionado por ID y
//    rellena el modal de forma dinámica
//-----------------------------------------------------------------------------
$(document).on("click", ".ejercicio-card", function () {
    let ejercicioId = $(this).data("id");

    $.ajax({
        url: `${BASE_URL}/ejercicios/ejercicio/${ejercicioId}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $("#modalTitulo").text(data.nombre);
            $("#modalNivel").text(data.nivel);
            $("#modalImagen1").attr("src", `${BASE_URL}/assets/img/exercises/${data.imagen_1}`);
            $("#modalImagenCarrusel1").attr("alt", data.nombre);
            $("#modalImagen2").attr("src", `${BASE_URL}/assets/img/exercises/${data.imagen_2}`);
            $("#modalImagen2").attr("alt", data.nombre);
            $("#modalDescripcion").text(data.instrucciones);
            $("#modalMusculoPrimario").text(data.musculo_primario);

            if (data.musculo_secundario != "null") {
                $("#textoMusculoSecundario").removeClass('ocultar');
                $("#modalMusculoSecundario").text(data.musculo_secundario);
            }
            else {
                $("#textoMusculoSecundario").addClass('ocultar');
                $("#modalMusculoSecundario").text("");
            }
            
            $("#modalNivel").removeClass('nivel-principiante nivel-intermedio nivel-experto');
            switch (data.nivel) {
                case 'principiante':
                    $("#modalNivel").addClass('nivel-principiante');
                    break;
                case 'intermedio':
                    $("#modalNivel").addClass('nivel-intermedio');
                    break;
                case 'experto':
                    $("#modalNivel").addClass('nivel-experto');
                    break;
                default:
                    break;
            }
        },
        error: function (xhr, status, error) {
            console.error("Error cargando detalles del ejercicio:", error);
        }
    });
});


//-----------------------------------------------------------------------------
// *: editar título y descripción de la rutina
//-----------------------------------------------------------------------------
document.querySelectorAll(".editable").forEach(el => {
    el.addEventListener("click", () => {
        if (!el.isContentEditable) {
            el.setAttribute("contenteditable", "true");
            el.focus();
            mostrarAvisoGuardar();
        }

        btnGuardarRutina.disabled = false;
        btnGuardarRutinaMobile.disabled = false;
    });
});

const editarRutinaBtn = document.getElementById("editarBtn")
editarRutinaBtn.addEventListener("click", () => {
    document.querySelectorAll(".editable").forEach(el => {
        el.setAttribute("contenteditable", "true");
    });
    
    editarRutinaBtn.style.display = "none";
    mostrarAvisoGuardar();

    btnGuardarRutina.disabled = false;
    btnGuardarRutinaMobile.disabled = false;
});

//-----------------------------------------------------------------------------
// Botones acerca de la rutina
//-----------------------------------------------------------------------------
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("icono-accion")) {
        const accion = e.target.dataset.accion;
        const tipo = e.target.dataset.tipo;
        switch (tipo) {
            case "vueltas":
                if (accion === "aumentar") {
                    if (rutinaVueltas < 6) {
                        rutinaVueltas++;
                    }
                } else {
                    if (rutinaVueltas > 1) {
                        rutinaVueltas--;
                    }
                }
                $("#numVueltas").text(rutinaVueltas);
                break;

            case "repeticiones":
                if (accion === "aumentar") {
                    if (rutinaRepeticiones < 99) {
                        rutinaRepeticiones++;
                    }
                } else {
                    if (rutinaRepeticiones > 1) {
                        rutinaRepeticiones--;
                    }
                }
                $("#numRepeticiones").text(rutinaRepeticiones);
                break;

            case "duracion":
                if (accion === "aumentar") {
                    if (rutinaDuacion < 60) {
                        rutinaDuacion += 5;
                    }
                } else {
                    if (rutinaDuacion > 20) {
                        rutinaDuacion -= 5;
                    }
                }
                $("#numDuracion").text(rutinaDuacion);
                break;

            case "descanso":
                if (accion === "aumentar") {
                    if (rutinaDescanso < 60) {
                        rutinaDescanso += 5;
                    }
                } else {
                    if (rutinaDescanso > 10) {
                        rutinaDescanso -= 5;
                    }
                }
                $("#numDescanso").text(rutinaDescanso);
                break;

            default:
                console.warn("Tipo desconocido:", tipo);
        }

        mostrarAvisoGuardar();
        btnGuardarRutina.disabled = false;
        btnGuardarRutinaMobile.disabled = false;
    }
});

btnGuardarRutina.addEventListener("click", function () {
    document.querySelectorAll(".editable").forEach(el => {
        el.setAttribute("contenteditable", "false");
    });
    editarRutinaBtn.style.display = "inline-block";

    let titulo = document.getElementById("tituloRutina").innerText.trim();
    let descripcion = document.getElementById("descripcionRutina").innerText.trim();
    let rutinaId = window.location.href.split("=")[1];
    const rutina = {
        id: rutinaId,
        nombre: titulo,
        descripcion: descripcion,
        vueltas: rutinaVueltas,
        repeticiones: rutinaRepeticiones,
        duracion: rutinaDuacion,
        descanso: rutinaDescanso,
        ejercicios: rutinaEjercicios
    };

    fetch(`${BASE_URL}/rutina/guardar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(rutina)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: 'Rutina guardada con éxito',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                background: '#fff',
                color: '#3C3C43',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        } else {
            console.error('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });

    btnGuardarRutina.disabled = true;
    btnGuardarRutinaMobile.disabled = true;
});