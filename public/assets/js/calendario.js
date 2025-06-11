document.addEventListener('DOMContentLoaded', function() {
    const calendarDiv = document.getElementById('calendario');
    const contenidoCards = document.getElementById("contenidoCards");

    const calendario = new FullCalendar.Calendar(calendarDiv, {
        locale: 'es',
        initialView: 'dayGridMonth',
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: '',
            right: 'title'
        },
        dayMaxEvents: true,
        
        events: {
            url: `${BASE_URL}/calendario/cargar`,
            method: 'GET',
            failure: function () {
                Swal.fire('Error', 'No se pudieron cargar las rutinas del calendario', 'error');
            }
        },

        dateClick: function (info) {
            const fecha = info.dateStr;
            history.pushState(null, '', `${BASE_URL}/calendario?dia=${fecha}`);
            $('#contenido-calendario').addClass('d-none');
            $('#detalle-dia').removeClass('d-none');

            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            const fechaSeleccionada = new Date(fecha);
            fechaSeleccionada.setHours(0, 0, 0, 0);
            if (fechaSeleccionada < hoy) {
                $('#btnAñadirRutina').prop('disabled', true);
            } else {
                $('#btnAñadirRutina').prop('disabled', false);
            }
            $.ajax({
                url: `${BASE_URL}/calendario/detalle`,
                method: 'POST',
                data: { fecha: fecha },
                success: function (rutinas) {
                    $('#detalle-dia').addClass('d-flex');
                    crearCardsRutinas(rutinas);
                },
                error: function () {
                    $('#detalle-dia').html('<p class="text-danger">Error al cargar el detalle del día.</p>');
                }
            });
        },

        datesSet: function () {
            const toolbar = document.querySelector('.fc-toolbar-chunk h4');
            if (toolbar) {
                toolbar.remove();
            }

            const newTitle = document.querySelector('.fc-toolbar-title');
            if (newTitle && newTitle.tagName === 'H2') {
                const h4 = document.createElement('h4');
                h4.className = newTitle.className;
                h4.innerHTML = newTitle.innerHTML;
                newTitle.parentNode.replaceChild(h4, newTitle);
            }

            const hoy = new Date().toLocaleDateString('sv-SE');
            const celda = document.querySelector(`[data-date="${hoy}"]`);
            if (celda) {
                celda.style.backgroundColor = '#73d0b954';
                celda.style.border = '1px solid #6cbeaa54';
            }
        }
    });

    calendario.render();
});

function crearCardsRutinas(rutinas) {
    let fragmento = document.createDocumentFragment();

    rutinas.forEach(rutina => {
        let div = document.createElement("div");

        div.classList.add("rutina-calendario", "col-12", "col-xl-10", "mt-1");
        div.innerHTML = `
            <a data-id="${rutina.id}" class="rutina-card ${rutina.nivel} d-flex py-2 px-2 align-items-center mb-2">
                <img src="./assets/icons/mancuerna.svg" alt="mancuerna" class="ms-1 me-2 ${rutina.nivel}">
                <div class="rutina-card-info d-flex justify-content-between w-100">
                    <div class="info d-flex flex-column ms-1 me-2">
                        <div class="d-flex justify-content-between w-100">
                            <h5>${rutina.nombre}</h5>
                        </div>
                        <p class="nivel">Nivel: <b>${rutina.nivel}</b></p>
                        <p class="descripcion">${rutina.descripcion}</p>
                    </div>
                    <div class="d-flex flex-column fecha ms-1 me-1 show">
                        <p class="fecha-title">Fecha de creación</p>
                        <p>${formatearFechaEspañol(rutina.fecha)}</p>
                    </div>
                </div>
            </a>
        `;

        fragmento.appendChild(div);
    });

    contenidoCards.appendChild(fragmento);
}

//-----------------------------------------------------------------------------
// *: realiza petición AJAX para obtener la rutina seleccionado por ID y
//    redirigir a la venta para verla
//-----------------------------------------------------------------------------
$(document).on("click", ".rutina-card", function () {
    let rutinaId = $(this).data("id");
    if (rutinaId) {
        window.location.href = BASE_URL + "/rutina?ver=" + rutinaId;
    }
});

$('#btn-volver-atras').on('click', function () {
    window.addEventListener('popstate', () => {
        location.reload();
    });
    history.back();
});

function formatearFechaEspañol(fechaHora) {
    let fecha = fechaHora.split(" ")[0];
    let fechaES = fecha.split("-");
    return fechaES[2] + "/" + fechaES[1] + "/" + fechaES[0];
}