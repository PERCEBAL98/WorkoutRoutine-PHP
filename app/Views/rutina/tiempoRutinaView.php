<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid">
        <div id="rutinaContenido" class="d-none">
            <div class="mt-2 mt-md-4 mb-2 representacion-ejercicios d-flex justify-content-center align-items-center">
                <div class="col-3 d-none d-lg-block text-center ejercicio-anterior">
                    <span>Anterior</span>
                    <img id="imgAnterior" src="" alt="">
                </div>
                <div class="col-12 col-lg-6 px-lg-3 text-center ejercicio-actual">
                    <h4 id="ejercicioActual" class="mb-3"></h4>
                    <img id="imgCentral" class="central" src="" alt="">
                </div> 
                <div class="col-3 d-none d-lg-block text-center ejercicio-siguiente">
                    <span>Siguiente</span>
                    <img id="imgSiguiente" src="" alt="">
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-end mb-1 px-2">
                    <span id="temporizador"></span>
                    <span id="vueltas"></span>
                </div>
                <div class="barra-contenedor mb-2">
                    <div id="barraProgreso" class="barra-interna"></div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center flex-column flex-md-row leyenda-colores mb-2">
                <div class="color-container d-flex align-items-center mb-2 mb-md-0 me-md-3">
                    <div class="color-azul"></div>
                    <span>Tiempo de preparación</span>
                </div>
                <div class="color-container d-flex align-items-center mb-2 mb-md-0 me-md-3">
                    <div class="color-verde"></div>
                    <span>Tiempo de actividad</span>
                </div>
                <div class="color-container d-flex align-items-center">
                    <div class="color-rojo"></div>
                    <span>Tiempo de descanso</span>
                </div>
            </div>
        </div>
        <div id="spinnerContainer" style="height: 60vh;" class="container-fluid d-flex flex-column justify-content-center align-items-center mt-2">
            <div id="spinner" class="spinner-border" role="status"></div>
            <span id="mensajeCargandoRutina" class="mt-3">Preparando tu entrenamiento...</span>
        </div>
    </div>
</main>
<div id="footerBtn" class="d-flex justify-content-center expanded d-none">
    <button id="btnPausar" class="btn rutina" disabled>
        <img src="<?= baseUrl() ?>/assets/icons/parar.svg">
        <span>Pausar</span>
    </button>
    <button id="btnIniciar" class="btn rutina">
        <img src="<?= baseUrl() ?>/assets/icons/iniciar.svg">
        <span>Iniciar</span>
    </button>
    <button id="btnReanudar" class="btn rutina d-none">
        <img src="<?= baseUrl() ?>/assets/icons/reanudar.svg">
        <span>Reanudar</span>
    </button>
    <button id="btnFinalizar" class="btn rutina">
        <img src="<?= baseUrl() ?>/assets/icons/terminar.svg">
        <span>Finalizar</span>
    </button>
</div>
<?php include("templates/parte2.php"); ?>