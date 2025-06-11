const formRutinas = document.getElementById("formRutinas");
const inputRutinas = document.getElementById("searchInputRutinas");
const filterModal = new bootstrap.Modal(document.getElementById("filterRutinasModal"));
const filtroGrupos = document.querySelectorAll(".col-filtro .col");
const aplicarFiltrosBtn = document.getElementById("aplicarFiltros");
const borrarFiltrosBtn = document.getElementById("borrarFiltros");
const contenidoMain = document.getElementById("contenido");
const contenedorFiltrosModal = document.getElementById("contenedorFiltros");
const filtrosSeleccionadosDiv = document.getElementById("filtrosSeleccionados");
const contenidoCards = document.getElementById("contenidoCards");
const spinner = document.getElementById("spinner");
const msgNoHayRutinas = document.getElementById("mensajeNoHayRutinas");
const msgNoHayMasRutinas = document.getElementById("mensajeNoHayMasRutinas");
let numPagina = 1;
let estaCargando = false;
let tieneRutinas = true;
let filtros = {};
let tieneFiltros = false;
let busqueda = null;
let tieneBusqueda = false;

document.addEventListener("DOMContentLoaded", function () {
    const contenedorFecha = document.querySelectorAll(".fecha");
    function ocultarFecha() {
        if (window.innerWidth <= 768) {
            contenedorFecha.forEach(element => {
                element.classList.remove("show");
            });
        }
        else {
            contenedorFecha.forEach(element => {
                element.classList.add("show");
            });
        }
    }

    ocultarFecha();
    window.addEventListener("resize", ocultarFecha);
});

//-----------------------------------------------------------------------------
// *: al recargar la página se redirige al principio de la página y detecta el
//    scroll para cargar datos conforme va llegando al final
//-----------------------------------------------------------------------------
$(document).ready(function () {
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0, 0);

    window.addEventListener("scroll", manejarScroll);
});

//-----------------------------------------------------------------------------
// *: maneja cuando se puede detectar el scroll para obtener rutinas
//-----------------------------------------------------------------------------
function manejarScroll() {
    if (estaCargando || !tieneRutinas) return;

    const { scrollHeight, clientHeight, scrollTop } = document.documentElement;

    if (scrollTop + clientHeight >= scrollHeight - 3) {
        estaCargando = true;
        spinner.classList.add("show");

        setTimeout(() => obtenerRutinas(tieneFiltros ? filtros : null, tieneBusqueda ? busqueda : null), 100);
    }
}

//-----------------------------------------------------------------------------
// *: realiza el submit del formulario de busqueda cargando las nuevas rutinas
//-----------------------------------------------------------------------------
if (formRutinas)
    formRutinas.addEventListener("submit", function(event) {
        event.preventDefault();
        busqueda = inputRutinas.value.trim().replace(/\s+/g, " ");
        
        if (busqueda === "") return;

        tieneBusqueda = true;
        contenidoCards.innerHTML = '';
        numPagina = 0;

        window.removeEventListener("scroll", manejarScroll);
        obtenerRutinas(filtros, busqueda);
    });

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

//-----------------------------------------------------------------------------
// *: bucle para manejar la selección de un solo filtro por categoría
//-----------------------------------------------------------------------------
filtroGrupos.forEach(columna => {
    const links = columna.querySelectorAll("a");

    links.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            if (this.classList.contains('selected')) {
                this.classList.remove("selected");
            }
            else {
                links.forEach(item => item.classList.remove("selected"));
                this.classList.add("selected");
            }
        });
    });
});

//-----------------------------------------------------------------------------
// *: escucha el evento aplicar filtro y se encarga de mostrar los filtros y
//    cargar las cards con las rutinas correspondientes
//-----------------------------------------------------------------------------
if (aplicarFiltrosBtn)
    aplicarFiltrosBtn.addEventListener("click", function () {
        contenedorFiltrosModal.classList.add("show");
        contenidoMain.classList.add("show-filters");

        document.activeElement.blur();
        filterModal.hide();
        mostrarFiltrosSeleccionados();

        contenidoCards.innerHTML = '';
        numPagina = 0;

        window.removeEventListener("scroll", manejarScroll);
        obtenerRutinas(tieneFiltros ? filtros : null, tieneBusqueda ? busqueda : null);
    });

//-----------------------------------------------------------------------------
// *: escucha el evento borrar filtros obteniendo las primeras rutnas sin
//    filtros
//-----------------------------------------------------------------------------
if (borrarFiltrosBtn)
    borrarFiltrosBtn.addEventListener("click", function () {
        contenedorFiltrosModal.classList.remove("show");
        contenidoMain.classList.remove("show-filters");
        document.querySelectorAll(".modal-body a.selected").forEach(link => link.classList.remove("selected"));

        if (tieneFiltros) {
            contenidoCards.innerHTML = '';
            numPagina = 0;
            tieneFiltros = false;

            window.removeEventListener("scroll", manejarScroll);
            obtenerRutinas(tieneFiltros ? filtros : null);
        }
    });

//-----------------------------------------------------------------------------
// *: guarda y muestra sihay filtros seleccionados, en caso contrario muestra
//    que no hay filtros seleccionados
//-----------------------------------------------------------------------------
function mostrarFiltrosSeleccionados() {
    filtros = {};
    let filtrosArray = [];

    filtrosArray.push(`<span class="me-2">Filtros:</span>`);

    document.querySelectorAll("#filterRutinasModal .modal-body a.selected").forEach(link => {
        let campo = link.getAttribute("data-campo");
        let valor = link.getAttribute("data-valor");
        let texto = (campo == "favorito") ? `${link.innerText} favoritos` : `${link.innerText}`;

        if (campo && valor) {
            filtros[campo] = valor;
            filtrosArray.push(`<span class="me-1">${texto}</span>`);
        }
    });

    tieneFiltros = filtrosArray.length > 0;
    filtrosSeleccionadosDiv.innerHTML = filtrosArray.length != 1 ? filtrosArray.join(' ') : '<span>No hay filtros seleccionados</span>';
}

//-----------------------------------------------------------------------------
// *: realiza petición AJAX para obtener ejercicios pudiendo estar filtrados
//    de forma paginada
// >: [objeto filtros] diccionario de filtros, en caso contrario null
//-----------------------------------------------------------------------------
function obtenerRutinas(filtros = null, busqueda = null) {
    const urlBase = (filtros || busqueda) ? `${BASE_URL}/rutinas/filtrados/pagina/${numPagina}` : `${BASE_URL}/rutinas/pagina/${numPagina}`;
    let parametros = filtros ? { ...filtros } : {};
    
    if (busqueda && busqueda.trim() !== "") {
        parametros.busqueda = busqueda;
    }

    $.ajax({
        url: urlBase,
        type: 'GET',
        data: parametros,
        dataType: 'json',
        success: function (data) {
            if (data.length === 0) {
                tieneRutinas = false;
                spinner.classList.remove("show");
                numPagina = 1;
            } else {
                tieneRutinas = true;
                msgNoHayRutinas.classList.remove("show");
                msgNoHayMasRutinas.classList.remove("show");
                crearCardsRutinas(data);
                numPagina++;
            }
        },
        error: function(xhr, status, error) {
            console.error('Error cargando las rutinas:', error);
        },
        complete: function () {
            estaCargando = false;
           
            if (!tieneRutinas) {
                spinner.classList.remove("show");
                msgNoHayMasRutinas.classList.remove("show");

                contenidoCards.children.length > 0 ? msgNoHayMasRutinas.classList.add("show") : msgNoHayRutinas.classList.add("show");
            }
            else {
                window.addEventListener("scroll", manejarScroll);
            }
        }
    });
}

//-----------------------------------------------------------------------------
// *: crea y añade cards de rutinas al elemento contenidoCards
// >: [array rutinas] lista de rutinas
//-----------------------------------------------------------------------------
function crearCardsRutinas(rutinas) {
    let fragmento = document.createDocumentFragment();

    rutinas.forEach(rutina => {
        let div = document.createElement("div");

        imgFavorito = (rutina.favorito == 0) 
            ? `<img class="icono-corazon me-1" src="./assets/icons/corazon.svg" alt="corazon">`
            : `<img class="icono-corazon me-1" src="./assets/icons/corazon-activo.svg" alt="corazon">`;

        div.classList.add("rutina", "col-12", "col-xl-10");
        div.innerHTML = `
            <a data-id="${rutina.id}" class="rutina-card ${rutina.nivel} d-flex py-2 px-2 align-items-center mb-2">
                <img src="./assets/icons/mancuerna.svg" alt="mancuerna" class="ms-1 me-2 ${rutina.nivel}">
                <div class="rutina-card-info d-flex justify-content-between w-100">
                    <div class="info d-flex flex-column ms-1 me-2">
                        <div class="d-flex justify-content-between w-100">
                            <h5>${rutina.nombre}</h5>
                            <div>
                                <button data-id="${rutina.id}" data-name="rutina" class="btn-sin-efecto favorito-rutina">
                                    ${imgFavorito}
                                </button>
                                <button data-id="${rutina.id}" data-name="rutina" class="btn-sin-efecto borrar-rutina">
                                    <img class="icono-papelera" src="./assets/icons/papelera-rutina.svg" alt="papelera">
                                </button>        
                            </div>
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

$(document).on("click", ".favorito-rutina", function (e) {
    e.preventDefault();
    e.stopPropagation();

    let id = $(this).data("id");
    if (id) {
        let url = `${BASE_URL}/rutinas/favorito`

        $.ajax({
            data: {
                id: id
            },
            method: "POST",
            url: url,
            success: function(result) {
                if (result.success) {
                    let imgFavorito = (result.favorito == 0)
                        ? `<img class="icono-corazon me-1" src="./assets/icons/corazon.svg" alt="corazon">`
                        : `<img class="icono-corazon me-1" src="./assets/icons/corazon-activo.svg" alt="corazon">`;

                    $(e.currentTarget).html(imgFavorito);
                }
            }
        });
    }
});

$(document).on("click", ".borrar-rutina", function (e) {
    e.preventDefault();
    e.stopPropagation();

    let id = $(this).data("id");
    if (id) {
        let nombre = $(this).data("name");
        let padre = $(this).parent().parent().parent().parent().parent().parent();
        let url = `${BASE_URL}/rutinas/eliminar`

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger me-2"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: `Desea eliminar la ${nombre}?`,
            text: "no hay vuelta atrás!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, borrar",
            cancelButtonText: "No, mantener",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    data: {
                        id: id
                    },
                    method: "POST",
                    url: url,
                    success: function(result) {
                        if (result.success) {
                            swalWithBootstrapButtons.fire({
                                title: "Eliminado!",
                                text: `${nombre} dada de baja`,
                                icon: "success"
                            });
                            padre.hide();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "No Eliminado!",
                                text: `${nombre} no dada de baja`,
                                icon: "error"
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {}
        });
    }
});

function formatearFechaEspañol(fechaHora) {
    let fecha = fechaHora.split(" ")[0];
    let fechaES = fecha.split("-");
    return fechaES[2] + "/" + fechaES[1] + "/" + fechaES[0];
}