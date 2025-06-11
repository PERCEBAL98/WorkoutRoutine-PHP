<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid info-rutina mt-1">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <?php if ($rutina["nivel"] == "principiante") { ?>
                    <span class="nivel-principiante"><?= $rutina["nivel"] ?></span>
                <?php } else if ($rutina["nivel"] == "intermedio") { ?>
                    <span class="nivel-intermedio"><?= $rutina["nivel"] ?></span>
                <?php } else if ($rutina["nivel"] == "experto") { ?>
                    <span class="nivel-experto"><?= $rutina["nivel"] ?></span>
                <?php } ?>
                <button id="editarBtn" class="btn-icon ms-1" href="#"><img src="<?= baseUrl() ?>/assets/icons/mini-editar.svg" alt="editar"></button>
            </div>
            <div class="d-none d-lg-flex">
                <button id="btnRepeticiones" class="ms-1 btn btn-secundario">
                    Iniciar rutina por repeticiones
                </button>
                <button id="btnTiempo" class="ms-1 btn btn-secundario">
                    Iniciar rutina por tiempo
                </button>
                <button id="btnGuardarRutina" class="ms-1 btn btn-principal" disabled>
                    Guardar
                </button>
            </div> 
        </div>
        <div class="d-flex w-100">
            <h3 id="tituloRutina" class="editable col-12 col-lg-8" contenteditable="false"><?= $rutina["nombre"] ?></h3>
        </div>
        <div class=" w-100">
            <p id="descripcionRutina" class="editable col-12 col-lg-8" contenteditable="false"><?= $rutina["descripcion"] ?></p>
        </div>
        <div class="row g-3 mt-2 mb-4 w-100">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded h-100 info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/vueltas.svg" class="mb-2" alt="Vueltas">
                    <p class="mb-2">Vueltas</p>
                    <div class="d-flex align-items-center">
                        <img class="icono-accion" data-accion="reducir" data-tipo="vueltas" src="<?= baseUrl() ?>/assets/icons/reducir.svg" alt="Reducir">
                        <p class="text-center" id="numVueltas"><?= $rutina["vueltas"] ?></p>
                        <img class="icono-accion" data-accion="aumentar" data-tipo="vueltas" src="<?= baseUrl() ?>/assets/icons/aumentar.svg" alt="Aumentar">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded h-100 info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/repeticiones.svg" class="mb-2" alt="Repeticiones">
                    <p class="mb-2">Repeticiones</p>
                    <div class="d-flex align-items-center">
                        <img class="icono-accion" data-accion="reducir" data-tipo="repeticiones" src="<?= baseUrl() ?>/assets/icons/reducir.svg" alt="Reducir">
                        <p class="text-center" id="numRepeticiones"><?= $rutina["repeticiones"] ?></p>
                        <img class="icono-accion" data-accion="aumentar" data-tipo="repeticiones" src="<?= baseUrl() ?>/assets/icons/aumentar.svg" alt="Aumentar">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded h-100 info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/duracion.svg" class="mb-2" alt="Duración">
                    <p class="mb-2">Duración</p>
                    <div class="d-flex align-items-center">
                        <img class="icono-accion" data-accion="reducir" data-tipo="duracion" src="<?= baseUrl() ?>/assets/icons/reducir.svg" alt="Reducir">
                        <p class="text-center" id="numDuracion"><?= $rutina["duracion"] ?></p>
                        <img class="icono-accion" data-accion="aumentar" data-tipo="duracion" src="<?= baseUrl() ?>/assets/icons/aumentar.svg" alt="Aumentar">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded h-100 info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/descanso.svg" class="mb-2" alt="Descanso">
                    <p class="mb-2">Descanso</p>
                    <div class="d-flex align-items-center">
                        <img class="icono-accion" data-accion="reducir" data-tipo="descanso" src="<?= baseUrl() ?>/assets/icons/reducir.svg" alt="Reducir">
                        <p class="text-center" id="numDescanso"><?= $rutina["descanso"] ?></p>
                        <img class="icono-accion" data-accion="aumentar" data-tipo="descanso" src="<?= baseUrl() ?>/assets/icons/aumentar.svg" alt="Aumentar">
                    </div>
                </div>
            </div>
        </div>
        <h4 class="mt-1 w-100">Lista de ejercicios</h4>
        <div id="contenidoCards" class="row sortable-ejercicios">
            <?php 
                if (count($ejercicios) > 0) {
                    foreach ($ejercicios as $ejercicio) {
            ?>
                <div class="col-12 col-md-12 col-lg-6 col-xl-4 ejercicio">
                    <a class="ejercicio-card card" data-bs-toggle="modal" data-bs-target="#ejercicioModal" data-id="<?= $ejercicio["id"] ?>">
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
<div id="footerBtn" class="d-flex d-lg-none justify-content-center expanded">
    <button id="btnRepeticionesMobile" class="btn rutina">
        <img src="<?= baseUrl() ?>/assets/icons/repeticiones.svg">
        <span>Iniciar</span>
    </button>
    <button id="btnGuardarRutinaMobile" class="btn rutina" disabled>
        <img src="<?= baseUrl() ?>/assets/icons/guardar.svg">
        <span>Guardar</span>
    </button>
    <button id="btnTiempoMobile" class="btn rutina">
        <img src="<?= baseUrl() ?>/assets/icons/duracion.svg">
        <span>Iniciar</span>
    </button>
</div>
<?php include("templates/parte2.php"); ?>