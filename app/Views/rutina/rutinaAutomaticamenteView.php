<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="mt-1 container-fluid">
        <div class="msg-aviso d-inline-flex align-items-center p-2 mb-1 rounded">
            <img src="<?= baseUrl() ?>/assets/icons/aviso.svg" class="me-1" alt="aviso">
            <p class="mb-0 mt-0">Importante: los campos con * son obligatorios</p>
        </div>
        <form id="formRutina" class="row d-flex justify-content-center" href="#" method="POST" enctype="multipart/form-data">
            <div class="my-2 col-12 col-md-12 col-lg-6 col-xl-4">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/nivel.svg" class="mb-2" alt="Nivel">
                    <p>Nivel*</p>
                    <select name="nivel" class="select2 w-100 mt-2">
                        <option value=""></option>
                        <option value="principiante">Principiante</option>
                        <option value="intermedio">Intermedio</option>
                        <option value="experto">Experto</option>
                    </select>
                    <div class="text-aviso error-nivel"></div>
                </div>
            </div>
            <div class="my-2 col-12 col-md-12 col-lg-6 col-xl-4">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/musculo-primario.svg" class="mb-2" alt="Musculo primario">
                    <p>Músculo primario*</p>
                    <select name="musculo_primario" class="select2 w-100 mt-2">
                        <option value=""></option>
                        <option value="hombros">Hombros</option>
                        <option value="tríceps">Tríceps</option>
                        <option value="bíceps">Bíceps</option>
                        <option value="antebrazos">Antebrazos</option>
                        <option value="pecho">Pecho</option>
                        <option value="dorsales">Dorsales</option>
                        <option value="abdominales">Abdominales</option>
                        <option value="espalda">Espalda</option>
                        <option value="glúteos">Glúteos</option>
                        <option value="abductores">Abductores</option>
                        <option value="aductores">Aductores</option>
                        <option value="isquiotibiales">Isquiotibiales</option>
                        <option value="cuádriceps">Cuádriceps</option>
                        <option value="gemelos">Gemelos</option>
                    </select>
                    <div class="text-aviso error-musculo_primario"></div>
                </div>
            </div>
            <div class="my-2 col-12 col-md-12 col-lg-6 col-xl-4">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/musculo-secundario.svg" class="mb-2" alt="Musculo secundario">
                    <p>Músculo secundario</p>
                    <select name="musculo_secundario" class="select2 w-100 mt-2">
                        <option value=""></option>
                        <option value="hombros">Hombros</option>
                        <option value="tríceps">Tríceps</option>
                        <option value="bíceps">Bíceps</option>
                        <option value="antebrazo">Antebrazos</option>
                        <option value="pecho">Pecho</option>
                        <option value="dorsales">Dorsales</option>
                        <option value="abdominales">Abdominales</option>
                        <option value="espalda">Espalda</option>
                        <option value="glúteos">Glúteos</option>
                        <option value="abductores">Abductores</option>
                        <option value="aductores">Aductores</option>
                        <option value="isquiotibiales">Isquiotibiales</option>
                        <option value="cuádriceps">Cuádriceps</option>
                        <option value="gemelos">Gemelos</option>
                    </select>
                </div>
            </div>
            <div class="my-2 col-12 col-md-12 col-lg-6 col-xl-4">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/movimiento.svg" class="mb-2" alt="Movimiento">
                    <p>Movimiento</p>
                    <select name="movimiento" class="select2 w-100 mt-2">
                        <option value=""></option>
                        <option value="tirar">Tirar</option>
                        <option value="empujar">Empujar</option>
                        <option value="estático">Estático</option>
                    </select>
                </div>
            </div>
            <div class="my-2 col-12 col-md-12 col-lg-6 col-xl-4">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/categoria.svg" class="mb-2" alt="Categoria">
                    <p>Categoria</p>
                    <select name="categoria" class="select2 w-100 mt-2">
                        <option value=""></option>
                        <option value="pliométricos">Pliométricos</option>
                        <option value="fuerza">Fuerza</option>
                    </select>
                </div>
            </div>
            <div class="my-2 col-12 col-md-12 col-lg-6 col-xl-4">
                <div class="d-flex flex-column align-items-center text-center p-3 rounded info-rutina-container">
                    <img src="<?= baseUrl() ?>/assets/icons/mecanica.svg" class="mb-2" alt="Mecánica">
                    <p>Mecánica</p>
                    <select name="mecanica" class="select2 w-100 mt-2">
                        <option value=""></option>
                        <option value="aislado">Aislado</option>
                        <option value="compuesto">Compuesto</option>
                    </select>
                </div>
            </div>
            <div class="mt-2 col-12 col-md-12 col-lg-6 col-xl-4">
                <input type="submit" class="form-control btn btn-principal" value="Crear" id="crearRutinaAutomticamente">
            </div>
        </form>
    </div>
</main>
<?php include("templates/parte2.php"); ?>