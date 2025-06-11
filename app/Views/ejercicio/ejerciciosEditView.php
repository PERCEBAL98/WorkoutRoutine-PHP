<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid">
        <div class="row mb-3 mt-2 justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 bg-white p-4 rounded formulario">
                <div class="pb-1 mb-2 border-bottom">
                    <h4>Crear ejercicio</h4>
                </div>
                <?php
                $errors = validation_errors();
                ?>
                <form action="<?php echo baseUrl(); ?>/ejercicios/actualizar" method="post" enctype="multipart/form-data" class="row">
                    <input type="hidden" name="id" value="<?= encriptar($datos["id"]); ?>">
                    <div class="col-12 col-xl-6">
                        <div class="mb-2">
                            <label for="nombre" class="form-label ms-1 mb-0">Nombre</label>
                            <input type="nombre" class="form-control" id="nombre" name="nombre" placeholder="nombre" value="<?= rellenarDato($errors, $datos, "nombre"); ?>">
                            <?php if (isset($errors['nombre'])) ?>
                            <span class="text-danger"><?= validation_show_error('nombre'); ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="instrucciones" class="form-label ms-1 mb-0">Instrucciones</label>
                            <textarea class="form-control" id="instrucciones" name="instrucciones"><?= rellenarDato($errors, $datos, "instrucciones"); ?></textarea>
                            <?php if (isset($errors['instrucciones'])) ?>
                            <span class="text-danger"><?= validation_show_error('instrucciones'); ?></span>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="mb-2">
                            <label for="musculo_primario" class="form-label ms-1 mb-0">Musculo primario</label>
                            <?php echo form_dropdown('musculo_primario', $optionsMusculoPrimario, rellenarDato($errors, $datos, "musculo_primario"), 'class="form-control select2" id="musculo_primario"')?>
                            <?php if (isset($errors['musculo_primario'])) ?>
                            <span class="text-danger"><?= validation_show_error('musculo_primario'); ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="musculo_secundario" class="form-label ms-1 mb-0">Musculo secundario</label>
                            <?php echo form_dropdown('musculo_secundario', $optionsMusculoSecundario, rellenarDato($errors, $datos, "musculo_secundario"), 'class="form-control select2" id="musculo_secundario"')?>
                            <?php if (isset($errors['musculo_secundario'])) ?>
                            <span class="text-danger"><?= validation_show_error('musculo_secundario'); ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="nivel" class="form-label ms-1 mb-0">Nivel</label>
                            <?php echo form_dropdown('nivel', $optionsNivel, rellenarDato($errors, $datos, "nivel"), 'class="form-control select2" id="nivel"')?>
                            <?php if (isset($errors['nivel'])) ?>
                            <span class="text-danger"><?= validation_show_error('nivel'); ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="movimiento" class="form-label ms-1 mb-0">Movimineto</label>
                            <?php echo form_dropdown('movimiento', $optionsMovimiento, rellenarDato($errors, $datos, "movimiento"), 'class="form-control select2" id="movimiento"')?>
                            <?php if (isset($errors['movimiento'])) ?>
                            <span class="text-danger"><?= validation_show_error('movimiento'); ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="categoria" class="form-label ms-1 mb-0">Categoria</label>
                            <?php echo form_dropdown('categoria', $optionsCategoria, rellenarDato($errors, $datos, "categoria"), 'class="form-control select2" id="categoria"')?>
                            <?php if (isset($errors['categoria'])) ?>
                            <span class="text-danger"><?= validation_show_error('categoria'); ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="mecanica" class="form-label ms-1 mb-0">Mecánica</label>
                            <?php echo form_dropdown('mecanica', $optionsMecanica, rellenarDato($errors, $datos, "mecanica"), 'class="form-control select2" id="mecanica"')?>
                            <?php if (isset($errors['mecanica'])) ?>
                            <span class="text-danger"><?= validation_show_error('mecanica'); ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-xl-6 mb-2">
                                <div>
                                    <label for="imagen_1" class="form-label ms-1 mb-0">Imagen 1</label>
                                    <div class="mb-2">
                                        <input class="form-control" type="file" id="imagen1" name="imagen_1" accept="image/*">
                                    </div>
                                    <?php if (isset($errors['imagen_1'])) ?>
                                    <span class="text-danger"><?= validation_show_error('imagen_1'); ?></span>
                                </div>
                                <div>
                                    <img id="imagen-1-preview" src="<?= baseUrl() . "/assets/img/exercises/" . rellenarDato($errors, $datos, "imagen_1"); ?>" class="img-fluid border rounded w-100">
                                </div>
                            </div>
                            <div class="col-12 col-xl-6 mb-2">
                                <div>
                                    <label for="imagen_2" class="form-label ms-1 mb-0">Imagen 2</label>
                                    <div class="mb-2">
                                        <input class="form-control" type="file" id="imagen2" name="imagen_2" accept="image/*">
                                    </div>
                                    <?php if (isset($errors['imagen_2'])) ?>
                                    <span class="text-danger"><?= validation_show_error('imagen_2'); ?></span>
                                </div>
                                <div>
                                    <img id="imagen-2-preview" src="<?= baseUrl() . "/assets/img/exercises/" . rellenarDato($errors, $datos, "imagen_2"); ?>" class="img-fluid border rounded w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center row">
                        <div class="col-12 col-xl-6">
                            <input type="submit" class="form-control btn btn-principal mt-1" value="Aceptar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include("templates/parte2.php"); ?>