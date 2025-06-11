const btnMenu = document.getElementById("menuBtn");
const sidebar = document.getElementById("sidebar");
const contenido = document.getElementById("contenido");
const footerBtn = document.getElementById("footerBtn");
const contenedorFiltros = document.getElementById("contenedorFiltros");
const tituloMenuAdmin = document.getElementById("tituloMenuAdmin");
const tituloPanel = document.getElementById("tituloPanel");
const menuDivider1 = document.getElementById("menuDivider1");
const menuInicial = document.getElementById("menuInicial");
const menuDivider2 = document.getElementById("menuDivider2");
const menuIntermedio = document.getElementById("menuIntermedio");
const menuDivider3 = document.getElementById("menuDivider3");
const menuFooter = document.getElementById("menuFooter");

document.addEventListener("DOMContentLoaded", function () {
    let currentPath = window.location.pathname.split("/").pop();
    let currentPathExtra = window.location.pathname.split("/");

    document.querySelectorAll(".link").forEach(link => {
        let linkPath = link.getAttribute("href").split("/").pop();
        if (currentPath == "listado" || currentPath == "nuevo" || currentPath == "editar") {
            let linkPathExtra = link.getAttribute("href").split("/");
            let currentModulo = currentPathExtra[currentPathExtra.length - 2];
            let linkModulo = linkPathExtra[linkPathExtra.length - 2];

            if (currentModulo == linkModulo) {
                link.classList.add("active");
            }
        }
        else {
            if (linkPath.includes(currentPath)) {
                link.classList.add("active");
            }
        }
    });
});

btnMenu.addEventListener("click", function() {
    sidebar.classList.toggle("expanded");
    contenido.classList.toggle("expanded");
    if (contenedorFiltros)
        contenedorFiltros.classList.toggle("expanded");
    if (footerBtn)
        footerBtn.classList.toggle("expanded");
    if (tituloMenuAdmin)
        tituloMenuAdmin.classList.toggle("show");
    if (tituloPanel) {
        if (tituloPanel.textContent.trim() == "Panel") {
            tituloPanel.textContent = "Panel de Control";
        } else {
            tituloPanel.textContent = "Panel";
        }
    }
    if (menuDivider1)
        menuDivider1.classList.toggle("show");
    if (menuInicial)
        menuInicial.classList.toggle("show");
    if (menuDivider2)
        menuDivider2.classList.toggle("show");
    if (menuIntermedio)
        menuIntermedio.classList.toggle("show");
    if (menuDivider3)
        menuDivider3.classList.toggle("show");
    if (menuFooter)
        menuFooter.classList.toggle("show");

    const imagen = btnMenu.querySelector("img");
    let imagenSrc = imagen.src;
    let nombreImagen = imagenSrc.substring(imagenSrc.lastIndexOf("/") + 1);
    imagen.src = (nombreImagen === "menu.svg")
        ? imagenSrc.replace("menu.svg", "menu-cerrar.svg")
        : imagenSrc.replace("menu-cerrar.svg", "menu.svg");
        
    if (sidebar.classList.contains("expanded")) {
        sidebar.querySelectorAll("li").forEach(li => li.classList.remove("ms-2"));
    } else {
        sidebar.querySelectorAll("li").forEach(li =>{
            const hr = li.querySelector("#menuDividerAdmin");
            if (!hr) {
                li.classList.add("ms-2");
            }
        });
    }

    document.querySelectorAll(".ejercicio").forEach((cardEjercicio) => {
        if (sidebar.classList.contains("expanded")) {
            cardEjercicio.classList.remove("col-xl-3", "col-lg-4", "col-md-6");
            cardEjercicio.classList.add("col-xl-4", "col-lg-6", "col-md-12");
        } else {
            cardEjercicio.classList.remove("col-xl-4", "col-lg-6", "col-md-12");
            cardEjercicio.classList.add("col-xl-3", "col-lg-4", "col-md-6");
        }
    });
});
