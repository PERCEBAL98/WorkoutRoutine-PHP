const formEjercicios = document.getElementById("formEjercicios");
const inputEjercicios = document.getElementById("searchInput");
const filterModal = new bootstrap.Modal(document.getElementById("filterModal"));
const filtroGrupos = document.querySelectorAll(".col-filtro .col");
const aplicarFiltrosBtn = document.getElementById("aplicarFiltros");
const borrarFiltrosBtn = document.getElementById("borrarFiltros");
const contenidoMain = document.getElementById("contenido");
const contenedorFiltrosModal = document.getElementById("contenedorFiltros");
const filtrosSeleccionadosDiv = document.getElementById("filtrosSeleccionados");
const contenidoCards = document.getElementById("contenidoCards");
const spinner = document.getElementById("spinner");
const msgNoHayEjercicios = document.getElementById("mensajeNoHayEjercicios");
const msgNoHayMasEjercicios = document.getElementById("mensajeNoHayMasEjercicios");
let numPagina = 1;
let estaCargando = false;
let tieneEjercicios = true;
let filtros = {};
let tieneFiltros = false;
let busqueda = null;
let tieneBusqueda = false;

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
// *: maneja cuando se puede detectar el scroll para obtener ejercicios
//-----------------------------------------------------------------------------
function manejarScroll() {
    if (estaCargando || !tieneEjercicios) return;

    const { scrollHeight, clientHeight, scrollTop } = document.documentElement;

    if (scrollTop + clientHeight >= scrollHeight - 3) {
        estaCargando = true;
        spinner.classList.add("show");

        setTimeout(() => obtenerEjercicios(tieneFiltros ? filtros : null, tieneBusqueda ? busqueda : null), 100);
    }
}

//-----------------------------------------------------------------------------
// *: realiza el submit del formulario de busqueda cargando los nuevos
//    ejercicios
//-----------------------------------------------------------------------------
formEjercicios.addEventListener("submit", function(event) {
    event.preventDefault();
    busqueda = inputEjercicios.value.trim().replace(/\s+/g, " ");
    
    if (busqueda === "") return;

    tieneBusqueda = true;
    contenidoCards.innerHTML = '';
    numPagina = 0;

    window.removeEventListener("scroll", manejarScroll);
    obtenerEjercicios(filtros, busqueda);
});

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
//    cargar las cards con los ejercicios correspondientes
//-----------------------------------------------------------------------------
aplicarFiltrosBtn.addEventListener("click", function () {
    contenedorFiltrosModal.classList.add("show");
    contenidoMain.classList.add("show-filters");

    document.activeElement.blur();
    filterModal.hide();
    mostrarFiltrosSeleccionados();

    contenidoCards.innerHTML = '';
    numPagina = 0;

    window.removeEventListener("scroll", manejarScroll);
    obtenerEjercicios(tieneFiltros ? filtros : null, tieneBusqueda ? busqueda : null);
});

//-----------------------------------------------------------------------------
// *: escucha el evento borrar filtros obteniendo los primeros ejercicios sin
//    filtros
//-----------------------------------------------------------------------------
borrarFiltrosBtn.addEventListener("click", function () {
    contenedorFiltrosModal.classList.remove("show");
    contenidoMain.classList.remove("show-filters");
    document.querySelectorAll(".modal-body a.selected").forEach(link => link.classList.remove("selected"));

    if (tieneFiltros) {
        contenidoCards.innerHTML = '';
        numPagina = 0;
        tieneFiltros = false;

        window.removeEventListener("scroll", manejarScroll);
        obtenerEjercicios(tieneFiltros ? filtros : null);
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

    document.querySelectorAll("#filterModal .modal-body a.selected").forEach(link => {
        let campo = link.getAttribute("data-campo");
        let valor = link.getAttribute("data-valor");

        if (campo && valor) {
            filtros[campo] = valor;
            filtrosArray.push(`<span class="me-1">${link.innerText}</span>`);
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
function obtenerEjercicios(filtros = null, busqueda = null) {
    const urlBase = (filtros || busqueda) ? `${BASE_URL}/ejercicios/filtrados/pagina/${numPagina}` : `${BASE_URL}/ejercicios/pagina/${numPagina}`;
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
                tieneEjercicios = false;
                spinner.classList.remove("show");
                numPagina = 1;
            } else {
                tieneEjercicios = true;
                msgNoHayEjercicios.classList.remove("show");
                msgNoHayMasEjercicios.classList.remove("show");
                crearCardsEjercicios(data);
                numPagina++;
            }
        },
        error: function(xhr, status, error) {
            console.error('Error cargando los ejercicios:', error);
        },
        complete: function () {
            estaCargando = false;
           
            if (!tieneEjercicios) {
                spinner.classList.remove("show");
                msgNoHayMasEjercicios.classList.remove("show");

                contenidoCards.children.length > 0 ? msgNoHayMasEjercicios.classList.add("show") : msgNoHayEjercicios.classList.add("show");
            }
            else {
                window.addEventListener("scroll", manejarScroll);
            }
        }
    });
}

//-----------------------------------------------------------------------------
// *: crea y añade cards de ejercicios al elemento contenidoCards
// >: [array ejercicios] lista de ejercicios
//-----------------------------------------------------------------------------
function crearCardsEjercicios(ejercicios) {
    let fragmento = document.createDocumentFragment();

    ejercicios.forEach(ejercicio => {
        let div = document.createElement("div");
        if (window.location.pathname.split("/").pop() != "personalizada") {
            if (document.getElementById("sidebar").classList.contains("expanded")) {
                div.classList.add("ejercicio", "col-12", "col-md-12", "col-lg-6", "col-xl-4");
                div.innerHTML = `
                    <a class="ejercicio-card card" data-bs-toggle="modal" data-bs-target="#ejercicioModal" data-id="${ejercicio.id}">
                        <img src="${BASE_URL}/assets/img/exercises/${ejercicio.imagen_1}" class="card-img-top" alt="${ejercicio.nombre}">
                        <div class="card-body">
                            <h5 class="card-title">${ejercicio.nombre}</h5>
                            <p class="card-text">${ejercicio.musculo_primario}</p>
                        </div>
                    </a>
                `;
            }
            else {
                div.classList.add("ejercicio", "col-12", "col-md-6", "col-lg-4", "col-xl-3");
                div.innerHTML = `
                    <a class="ejercicio-card card" data-bs-toggle="modal" data-bs-target="#ejercicioModal" data-id="${ejercicio.id}">
                        <img src="${BASE_URL}/assets/img/exercises/${ejercicio.imagen_1}" class="card-img-top" alt="${ejercicio.nombre}">
                        <div class="card-body">
                            <h5 class="card-title">${ejercicio.nombre}</h5>
                            <p class="card-text">${ejercicio.musculo_primario}</p>
                        </div>
                    </a>
                `;
            }
        } else {
            if (document.getElementById("sidebar").classList.contains("expanded")) {
                div.classList.add("ejercicio", "col-12", "col-md-12", "col-lg-6", "col-xl-4");
                div.innerHTML = `
                    <a class="ejercicio-card card" data-bs-toggle="modal" data-bs-target="#ejercicioModal" draggable="true" ondragstart="drag(event)"
                        data-id="${ejercicio.id}" data-img="${BASE_URL}/assets/img/exercises/${ejercicio.imagen_1}">
                        <img src="${BASE_URL}/assets/img/exercises/${ejercicio.imagen_1}" class="card-img-top" alt="${ejercicio.nombre}">
                        <div class="card-body">
                            <h5 class="card-title">${ejercicio.nombre}</h5>
                            <p class="card-text">${ejercicio.musculo_primario}</p>
                        </div>
                    </a>
                `;
            }
            else {
                div.classList.add("ejercicio", "col-12", "col-md-6", "col-lg-4", "col-xl-3");
                div.innerHTML = `
                    <a class="ejercicio-card card" data-bs-toggle="modal" data-bs-target="#ejercicioModal" draggable="true" ondragstart="drag(event)"
                        data-id="${ejercicio.id}" data-img="${BASE_URL}/assets/img/exercises/${ejercicio.imagen_1}">
                        <img src="${BASE_URL}/assets/img/exercises/${ejercicio.imagen_1}" class="card-img-top" alt="${ejercicio.nombre}">
                        <div class="card-body">
                            <h5 class="card-title">${ejercicio.nombre}</h5>
                            <p class="card-text">${ejercicio.musculo_primario}</p>
                        </div>
                    </a>
                `;
            }
        }

        fragmento.appendChild(div);
    });

    contenidoCards.appendChild(fragmento);
}