document.addEventListener("DOMContentLoaded", function () {
    const contenedorIntermedio = document.getElementById("contenedorIntermedio");
    const contenedorBuscador = document.querySelector(".contenedor-buscador");

    const buscadorExpanded = document.querySelector(".contenedor-buscador-expanded");
    const contenedorBuscadorExpanded = document.querySelector(".container-contenedor-buscador-expanded");
    const searchBtnExpanded = document.getElementById("searchBtnExpanded");
    const backBtn = document.getElementById("backBtn");

    const buscadorRutinasExpanded = document.querySelector(".contenedor-buscador-rutinas-expanded");
    const contenedorBuscadorRutinasExpanded = document.querySelector(".container-contenedor-buscador-rutinas-expanded");
    const searchBtnRutinasExpanded = document.getElementById("searchBtnRutinasExpanded");
    const backBtnRutinas = document.getElementById("backBtnRutinas");

    function adaptarHeader() {
        if (window.innerWidth <= 768) {
            if (contenedorBuscadorExpanded) {
                contenedorBuscadorExpanded.appendChild(contenedorBuscador);
            } else if (contenedorBuscadorRutinasExpanded) {
                contenedorBuscadorRutinasExpanded.appendChild(contenedorBuscador);
            }
        } else {
            if (contenedorIntermedio && contenedorBuscador) {
                contenedorIntermedio.appendChild(contenedorBuscador);
            }
    
            if (buscadorExpanded && buscadorExpanded.classList.contains("show")) {
                buscadorExpanded.classList.remove("show");
                contenedorBuscador.classList.remove("show");
            }
            if (buscadorRutinasExpanded && buscadorRutinasExpanded.classList.contains("show")) {
                buscadorRutinasExpanded.classList.remove("show");
                contenedorBuscador.classList.remove("show");
            }
        }
    }

    if (searchBtnExpanded && buscadorExpanded && contenedorBuscadorExpanded) {
        searchBtnExpanded.addEventListener("click", function () {
            buscadorExpanded.classList.toggle("show");
            contenedorBuscadorExpanded.classList.toggle("show");
        });
    }
    
    if (backBtn && buscadorExpanded && contenedorBuscadorExpanded) {
        backBtn.addEventListener("click", function () {
            buscadorExpanded.classList.toggle("show");
            contenedorBuscadorExpanded.classList.toggle("show");
        });
    }
    
    if (searchBtnRutinasExpanded && buscadorRutinasExpanded && contenedorBuscadorRutinasExpanded) {
        searchBtnRutinasExpanded.addEventListener("click", function () {
            buscadorRutinasExpanded.classList.toggle("show");
            contenedorBuscadorRutinasExpanded.classList.toggle("show");
        });
    }
    
    if (backBtnRutinas && buscadorRutinasExpanded && contenedorBuscadorRutinasExpanded) {
        backBtnRutinas.addEventListener("click", function () {
            buscadorRutinasExpanded.classList.toggle("show");
            contenedorBuscadorRutinasExpanded.classList.toggle("show");
        });
    }

    adaptarHeader();
    window.addEventListener("resize", adaptarHeader);
});