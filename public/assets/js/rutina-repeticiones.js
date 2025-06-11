const btnAnterior = document.getElementById('btnAnterior');
const btnSiguiente = document.getElementById('btnSiguiente');
const btnCompletar = document.getElementById('btnCompletar');
const btnFinalizar = document.getElementById('btnFinalizar');

let rutina;
let ejercicios;
let rutinaCompleta = [];
let indiceActual = 0;
let numVuelta = 1;

const elementoRepeticiones = document.getElementById('repeticiones');
const elementoVueltas = document.getElementById('vueltas');
const nombreEjercicioActual = document.getElementById('ejercicioActual');
const barraProgreso = document.getElementById('barraProgreso');
const elementoEjercicios = document.getElementById('ejercicios');
$(document).ready(function () {
    $("#spinner").show();
    let rutinaId = new URLSearchParams(window.location.search).get('ver');

    $.ajax({
        url: `${BASE_URL}/rutina/${rutinaId}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }

            rutina = data.rutina;
            ejercicios = data.ejercicios;

            $("#imgAnterior").attr("src", `${BASE_URL}/assets/img/exercises/${ejercicios[ejercicios.length - 1].imagen_2}`);
            $("#imgCentral").attr("src", `${BASE_URL}/assets/img/exercises/${ejercicios[0].imagen_2}`);
            $("#imgSiguiente").attr("src", `${BASE_URL}/assets/img/exercises/${ejercicios[1].imagen_2}`);

            nombreEjercicioActual.textContent = ejercicios[0].nombre;
            elementoVueltas.textContent = `Vuelta ${numVuelta} de ${rutina.vueltas}`;
            elementoRepeticiones.textContent = `Repeticiones: ${rutina.repeticiones}`;
            elementoEjercicios.textContent = `Ejercicio 1 de ${ejercicios.length}`;

            ejercicios.forEach((ejercicio) => {
                rutinaCompleta.push({
                    tipo: 2,
                    nombre: ejercicio.nombre
                });
            });

            const progreso = (1 / (rutinaCompleta.length)) * 100;
            barraProgreso.style.width = `${progreso}%`;

            setTimeout(() => {
                $('#spinnerContainer').addClass('d-none');
                $('#rutinaContenido').removeClass('d-none');
                $('#footerBtn').removeClass('d-none');
            }, 500);
        },
        error: function (xhr, status, error) {
            console.error("Error cargando detalles de la rutina:", error);
        }
    });
});

function cambiarImagenes() {
    const bloque = rutinaCompleta[indiceActual];
    if (bloque.tipo !== 2) return;

    const idxEjercicio = ejercicios.findIndex(e => e.nombre === bloque.nombre);
    if (idxEjercicio === -1) return;

    const anterior = ejercicios[(idxEjercicio - 1 + ejercicios.length) % ejercicios.length];
    const actual = ejercicios[idxEjercicio % ejercicios.length];
    const siguiente = ejercicios[(idxEjercicio + 1) % ejercicios.length];

    $("#imgAnterior").attr("src", `${BASE_URL}/assets/img/exercises/${anterior.imagen_2}`);
    $("#imgCentral").attr("src", `${BASE_URL}/assets/img/exercises/${actual.imagen_2}`);
    $("#imgSiguiente").attr("src", `${BASE_URL}/assets/img/exercises/${siguiente.imagen_2}`);
}

function mostrarBloque() {
    const bloque = rutinaCompleta[indiceActual];
    nombreEjercicioActual.textContent = bloque.nombre;
    elementoVueltas.textContent = `Vuelta ${numVuelta} de ${rutina.vueltas}`;
    elementoEjercicios.textContent = `Ejercicio ${indiceActual + 1} de ${rutinaCompleta.length}`;

    const progreso = ((indiceActual + 1) / rutinaCompleta.length) * 100;
    barraProgreso.style.width = `${progreso}%`;

    cambiarImagenes();

    const esPrimero = indiceActual === 0;
    const esUltimo = indiceActual === rutinaCompleta.length - 1 && numVuelta == rutina.vueltas;

    btnAnterior.disabled = esPrimero;

    if (esUltimo) {
        btnSiguiente.classList.add('d-none');
        btnCompletar.classList.remove('d-none');
    } else {
        btnSiguiente.classList.remove('d-none');
        btnCompletar.classList.add('d-none');
    }
}

function siguienteBloque() {
    if (indiceActual === rutinaCompleta.length - 1 && numVuelta === rutina.vueltas) {
        completarRutina();
        return;
    }

    indiceActual++;

    if (indiceActual >= rutinaCompleta.length) {
        if (numVuelta < rutina.vueltas) {
            numVuelta++;
            indiceActual = 0;
        } else {
            completarRutina();
            return;
        }
    }

    mostrarBloque();
}

function anteriorBloque() {
    if (indiceActual > 0) {
        indiceActual--;
        mostrarBloque();
    }
}

function completarRutina() {
    new Audio(`${BASE_URL}/assets/sounds/fin_rutina.mp3`).play();
    const params = new URLSearchParams(window.location.search);
    const idEncriptado = params.get('ver');

    Swal.fire({
        icon: 'success',
        title: '¡Rutina completada!',
        text: 'Has finalizado tu rutina con éxito.',
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        willClose: async () => {
            try {
                await fetch(`${BASE_URL}/rutina/completar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: idEncriptado })
                });

                await fetch(`${BASE_URL}/logros/rutinas`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                window.location.href = `${BASE_URL}/rutinas`;
            } catch (error) {
                console.error('Error al completar las acciones:', error);
            }
        }
    });
}

function finalizarRutina() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres finalizar la rutina sin terminarla?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'No, continuar',
        customClass: {
            icon: 'warning-class',
            confirmButton: 'confirm-btn',
            cancelButton: 'cancel-btn'
        }
    }).then((result) => {
            if (result.isConfirmed) {
                history.back();
            }
    });
}

btnAnterior.addEventListener('click', anteriorBloque);
btnSiguiente.addEventListener('click', siguienteBloque);
btnCompletar.addEventListener('click', completarRutina);
btnFinalizar.addEventListener('click', finalizarRutina);