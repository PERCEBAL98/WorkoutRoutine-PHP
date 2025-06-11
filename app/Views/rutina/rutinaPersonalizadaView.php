<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded rutina">
    <div class="container-fluid">
        <nav class="navbar contenedor-filtros fixed-top expanded" id="contenedorFiltros">
            <div id="filtrosSeleccionados"></div>
        </nav>
        <div id="contenidoCards" class="row">
            <?php 
                if (count($ejercicios) > 0) {
                    foreach ($ejercicios as $ejercicio) {
            ?>
                <div class="col-12 col-md-12 col-lg-6 col-xl-4 ejercicio">
                    <a class="ejercicio-card card" data-bs-toggle="modal" data-bs-target="#ejercicioModal"
                        draggable="true" ondragstart="drag(event)"
                        data-id="<?= $ejercicio["id"] ?>" data-img="<?= baseUrl() ?>/assets/img/exercises/<?= $ejercicio["imagen_1"] ?>">
                        <img src="<?= baseUrl() ?>/assets/img/exercises/<?= $ejercicio["imagen_1"] ?>" class="card-img-top" alt="<?= $ejercicio["nombre"] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $ejercicio["nombre"] ?></h5>
                            <p class="card-text"><?= $ejercicio["musculo_primario"] ?></p>
                        </div>
                    </a>
                </div>
            <?php
                    }
                }
            ?>
        </div>
        <div class="container-fluid d-flex justify-content-center align-items-center mt-2">
            <div id="spinner" class="spinner-border" role="status"></div>
            <div id="mensajeNoHayEjercicios">
                <img src="<?= baseUrl() ?>/assets/icons/mancuerna.svg" alt="mancuerna">
                <span>Parece que no hay ejercicios disponibles. ¿Quieres probar con otros filtros o buscar de nuevo?</span>
            </div>
            <span id="mensajeNoHayMasEjercicios">(No hay más ejercicios disponibles)</span>
        </div>
    </div>
    <div id="ejercicioModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-start">
                    <div>
                        <span id="modalNivel"></span>
                        <h5 id="modalTitulo" class="modal-title mt-1"></h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div id="carouselImgEjercicio" class="carousel slide mb-2" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img id="modalImagen1" class="d-block w-100" alt="Imagen 1">
                            </div>
                            <div class="carousel-item">
                                <img id="modalImagen2" class="d-block w-100" alt="Imagen 2">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImgEjercicio" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImgEjercicio" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                    <span id="modalDescripcion" class=""></span>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <div class="col-12">
                        <span class="titulo">Músculo Primario:</span>
                        <span id="modalMusculoPrimario" class=""></span>
                    </div>
                    <div id="textoMusculoSecundario" class="col-12">
                        <span class="titulo">Músculo Secundario:</span>
                        <span id="modalMusculoSecundario" class=""></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("templates/listaEjercicios.php"); ?>
<?php include("templates/parte2.php"); ?>