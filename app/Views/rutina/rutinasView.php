<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid">
        <div id="contenidoCards" class="row justify-content-center mt-2">
            <div class="rutina col-12 col-xl-10">
            <?php 
                if (count($datos) > 0) {
                    foreach ($datos as $dato) {
            ?>
                <a data-id="<?= $dato["id"] ?>" class="rutina-card <?= $dato["nivel"] ?> d-flex py-2 px-2 align-items-center mb-2">
                    <img src="<?= baseUrl() ?>/assets/icons/mancuerna.svg" alt="mancuerna" class="ms-1 me-2 <?= $dato["nivel"] ?>">
                    <div class="rutina-card-info d-flex justify-content-between w-100">
                        <div class="info d-flex flex-column ms-1 me-2">
                            <div class="d-flex justify-content-between w-100">
                                <h5><?= $dato["nombre"] ?></h5>
                                <div>
                                    <button data-id="<?= $dato["id"] ?>" data-name="rutina" class="btn-sin-efecto favorito-rutina">
                                        <?php if ($dato["favorito"] == 0) { ?>
                                            <img class="icono-corazon me-1" src="<?= baseUrl() ?>/assets/icons/corazon.svg" alt="corazon">
                                        <?php } else { ?>
                                            <img class="icono-corazon me-1" src="<?= baseUrl() ?>/assets/icons/corazon-activo.svg" alt="corazon">
                                        <?php } ?>
                                    </button>
                                    <button data-id="<?= $dato["id"] ?>" data-name="rutina" class="btn-sin-efecto borrar-rutina">
                                        <img class="icono-papelera" src="<?= baseUrl() ?>/assets/icons/papelera-rutina.svg" alt="papelera">
                                    </button>
                                </div>
                            </div>
                            <p class="nivel">Nivel: <b><?= $dato["nivel"] ?></b></p>
                            <p class="descripcion"><?= $dato["descripcion"] ?></p>
                        </div>
                        <div class="d-flex flex-column fecha ms-1 me-1 show">
                            <p class="fecha-title">Fecha de creación</p>
                            <p><?= formatear_fecha_español($dato["fecha"]) ?></p>
                        </div>
                    </div>
                </a>
            <?php 
                    }
                } else {
            ?>
                <div class="container-fluid d-flex justify-content-center align-items-center mt-2">
                    <div id="mensajeSinRutinas" class="show">
                        <img src="<?= baseUrl() ?>/assets/icons/mancuerna.svg" alt="mancuerna">
                        <span>No tienes ninguna rutina todavía. Empieza creando una para comenzar tu entrenamiento.</span>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>  
        <div class="container-fluid d-flex justify-content-center align-items-center mt-2">
            <div id="spinner" class="spinner-border" role="status"></div>
            <div id="mensajeNoHayRutinas">
                <img src="<?= baseUrl() ?>/assets/icons/mancuerna.svg" alt="mancuerna">
                <span>Parece que no hay rutinas disponibles. ¿Quieres probar con otros filtros o buscar de nuevo?</span>
            </div>
            <span id="mensajeNoHayMasRutinas">(No hay más rutinas disponibles)</span>
        </div>
    </div>
</main>
<?php include("templates/parte2.php"); ?>