<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid">
        <?php include("templates/menuOpciones1.php"); ?>
        <div id="contenido-calendario" class="row justify-content-center mt-2">
            <div class="col-12 col-xl-10 mt-1">
                <div id="calendario"></div>
            </div>
        </div>
        <div id="detalle-dia" class="row justify-content-center d-none mt-2">
            <div class="col-12 col-xl-10 mt-1">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <button id="btn-volver-atras" class="btn btn-secundario">
                        ← Volver
                    </button>
                    <button id="btnAñadirRutina" class="ms-1 btn btn-principal">
                        Añadir rutina
                    </button>
                </div>
            </div>
            <div id="contenidoCards" class="row justify-content-center mt-2"></div>
        </div> 
    </div>
</main>
<?php include("templates/parte2.php"); ?>