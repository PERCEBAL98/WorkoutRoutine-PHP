<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid"></div>
        <?php include("templates/menuOpciones1.php"); ?>
        <div class="mt-3 mb-3 row">
            <div class="col-12 col-sm-12 col-md-6">
                <div class="mb-2 border-bottom">
                    <h5>Plan actual</h5>
                </div>
                <div class="d-flex align-items-center mt-1 plan-actual">
                    <img src="<?= baseUrl() ?>/assets/icons/plan-<?= session()->get('plan') ?>.svg" alt="Plan" class="plan-img me-2">
                    <h4 class="m-0">Básico</h4>
                </div>
            </div>
        </div>
        <div class="border-bottom">
            <h5>Gestionar plan de cuenta</h5>
        </div>
        <div class="row gx-2">
            <div class="col-12 col-md-6 col-xl-4 mt-2 card-planes">
                <div class="card text-center">
                    <div class="card-body d-flex flex-column">
                        <h4>Básico</h4>
                        <p>Ideal para empezar</p>
                        <ul class="list-unstyled flex-grow-1 my-1">
                            <li class="border-bottom mx-2 p-2">Anuncios visibles</li>
                            <li class="border-bottom mx-2 p-2">Crear hasta 3 rutinas</li>
                            <li class="mx-2 p-2">No puedes registrar progresos</li>
                        </ul>
                        <button class="btn btn-principal mt-1" disabled>Elegir Básico</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4 mt-2 card-planes">
                <div class="card text-center">
                    <div class="card-body d-flex flex-column">
                        <h4>Avanzado</h4>
                        <p>Para entrenar con más libertad</p>
                        <ul class="list-unstyled flex-grow-1 my-1">
                            <li class="border-bottom mx-2 p-2">Sin anuncios</li>
                            <li class="border-bottom mx-2 p-2">Crear rutinas sin limites</li>
                            <li class="mx-2 p-2">Realizar rutina sin limites</li>
                        </ul>
                        <button class="btn btn-principal mt-1" disabled>Elegir Avanzado</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4 mt-2 card-planes">
                <div class="card text-center">
                    <div class="card-body d-flex flex-column">
                        <h4>Profesional</h4>
                        <p>Para aprovechar todo el potencial</p>
                        <ul class="list-unstyled flex-grow-1 my-1">
                            <li class="border-bottom mx-2 p-2">Soporte prioritario</li>
                            <li class="border-bottom mx-2 p-2">Registrar progreso en el calendario</li>
                            <li class="mx-2 p-2">Todas las funciones del plan Avanzado</li>
                        </ul>
                        <button class="btn btn-principal mt-1" disabled>Elegir Profesional</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("templates/parte2.php"); ?>