let rutina;
let ejercicios;
let rutinaCompleta = [];
const btnIniciar = document.getElementById('btnIniciar');
const btnPausar = document.getElementById('btnPausar');
const btnReanudar = document.getElementById('btnReanudar');
const btnFinalizar = document.getElementById('btnFinalizar');
let inicioRutina = true;
let indiceActual = 0;
let indiceImagen = 0;
let inicioBloque = null;
let duracionBloque = 0;
let transcurridoEnPausa = 0;
let estaPausado = false;
let idAnimacion = null;
let numVuelta = 0;
const nombreEjercicioActual = document.getElementById('ejercicioActual');
const elementoTemporizador = document.getElementById('temporizador');
const elementoVueltas = document.getElementById('vueltas');
const barraProgreso = document.getElementById('barraProgreso');

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
            elementoTemporizador.textContent = `00:05`;
            elementoVueltas.textContent = `Vuelta ${numVuelta} de ${rutina.vueltas}`;

            rutinaCompleta.push({
                tipo: 1,
                nombre: "Preparación",
                duracion: 5
            });

            ejercicios.forEach((ejercicio, index) => {
                rutinaCompleta.push({
                    tipo: 2,
                    nombre: ejercicio.nombre,
                    duracion: rutina.duracion
                });

                if (index < ejercicios.length - 1) {
                    rutinaCompleta.push({
                        tipo: 3,
                        nombre: "Descanso",
                        duracion: rutina.descanso
                    });
                }
            });

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

function formatearTiempo(segundos) {
    const minutos = String(Math.floor(segundos / 60)).padStart(2, '0');
    const seg = String(Math.floor(segundos % 60)).padStart(2, '0');
    return `${minutos}:${seg}`;
}

function actualizarInterfaz(tiempoRestante, duracionTotal) {
    elementoTemporizador.textContent = formatearTiempo(tiempoRestante + 1);

    const porcentaje = Math.max(0, (tiempoRestante / duracionTotal) * 100);
    barraProgreso.style.width = `${porcentaje}%`;
}

function actualizarTemporizador() {
    if (estaPausado || inicioBloque === null) return;

    const ahora = Date.now();
    const transcurrido = (ahora - inicioBloque) / 1000;
    const tiempoRestante = Math.max(0, duracionBloque - transcurrido);

    //console.log(tiempoRestante);

    actualizarInterfaz(tiempoRestante, duracionBloque);

    if (tiempoRestante > 0) {
        idAnimacion = requestAnimationFrame(actualizarTemporizador);
    } else {
        siguienteBloque();
    }
}

function cambiarImagenes() {
    indiceImagen++;

    const anterior = ejercicios[indiceImagen - 1] || ejercicios[ejercicios.length - 1];
    const actual = ejercicios[indiceImagen] || ejercicios[0];
    const siguiente = ejercicios[indiceImagen + 1] || ejercicios[0];

    $("#imgAnterior").attr("src", `${BASE_URL}/assets/img/exercises/${anterior.imagen_2}`);
    $("#imgCentral").attr("src", `${BASE_URL}/assets/img/exercises/${actual.imagen_2}`);
    $("#imgSiguiente").attr("src", `${BASE_URL}/assets/img/exercises/${siguiente.imagen_2}`);
}

function iniciarRutina() {
    indiceActual = 0;
    indiceImagen = 0;
    transcurridoEnPausa = 0;
    estaPausado = false;
    iniciarBloque();
}

function iniciarBloque() {
    const bloque = rutinaCompleta[indiceActual];
    duracionBloque = bloque.duracion;
    inicioBloque = Date.now();
    transcurridoEnPausa = 0;

    if (bloque.tipo == 2) {
        if (inicioRutina) {
            inicioRutina = false;
            numVuelta = 1;
        }

        nombreEjercicioActual.textContent = bloque.nombre;
        barraProgreso.classList.add('actividad');
        barraProgreso.classList.remove('descanso');
        new Audio(`${BASE_URL}/assets/sounds/inicio_ejercicio.mp3`).play();
    }
    else if (bloque.tipo == 3) {
        nombreEjercicioActual.textContent = rutinaCompleta[indiceActual + 1].nombre;
        cambiarImagenes();
        barraProgreso.classList.add('descanso');
        barraProgreso.classList.remove('actividad');
        new Audio(`${BASE_URL}/assets/sounds/fin_ejercicio.mp3`).play();
    }

    elementoVueltas.textContent = `Vuelta ${numVuelta} de ${rutina.vueltas}`;
    barraProgreso.style.transition = 'none';
    barraProgreso.style.width = '100%';

    requestAnimationFrame(() => {
        barraProgreso.style.transition = 'width 0.2s linear';
    });

    actualizarTemporizador();
}

function pausarRutina() {
    if (estaPausado || inicioBloque === null) return;
    estaPausado = true;
    transcurridoEnPausa = (Date.now() - inicioBloque) / 1000;
    cancelAnimationFrame(idAnimacion);
}

function reanudarRutina() {
    if (!estaPausado) return;
    estaPausado = false;
    inicioBloque = Date.now() - (transcurridoEnPausa * 1000);
    actualizarTemporizador();
}

function siguienteBloque() {
    indiceActual++;
    if (indiceActual < rutinaCompleta.length) {
        iniciarBloque();
    } else {
        if (numVuelta < rutina.vueltas) {
            indiceActual = 0;
            indiceImagen = -1;
            rutinaCompleta.shift();
            rutinaCompleta.unshift(rutinaCompleta[1]);
            iniciarBloque();
            numVuelta++;
        } else {
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
    }
}

function finalizarRutina() {
    pausarRutina();
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
            } else {
                reanudarRutina()
            }
    });
}

btnIniciar.addEventListener('click', () => {
    iniciarRutina();
    btnIniciar.classList.add('d-none');
    btnReanudar.classList.remove('d-none');
    btnReanudar.disabled = true;
    btnPausar.disabled = false;
});

btnPausar.addEventListener('click', () => {
    pausarRutina();
    btnPausar.disabled = true;
    btnReanudar.disabled = false;
});

btnReanudar.addEventListener('click', () => {
    reanudarRutina();
    btnPausar.disabled = false;
    btnReanudar.disabled = true;
});

btnFinalizar.addEventListener('click', () => {
    finalizarRutina();
    btnIniciar.classList.remove('d-none');
    btnReanudar.classList.add('d-none');
    btnReanudar.disabled = true;
    btnPausar.disabled = true;
});