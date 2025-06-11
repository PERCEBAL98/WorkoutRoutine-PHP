<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid">
        <div class="row mb-3 mt-2 justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-xl-4 bg-white p-4 rounded formulario">
                <div class="pb-1 mb-2 border-bottom">
                    <h4>Editar logro</h4>
                </div>
                <?php
                $errors = validation_errors();
                ?>
                <form action="<?php echo baseUrl(); ?>/logros/actualizar" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= encriptar($datos["id"]); ?>">
                    <div class="mb-2">
                        <label for="nombre" class="form-label ms-1 mb-0">Nombre</label>
                        <input type="nombre" class="form-control" id="nombre" name="nombre" placeholder="nombre" value="<?= rellenarDato($errors, $datos, "nombre"); ?>">
                        <?php if (isset($errors['nombre'])) ?>
                        <span class="text-danger"><?= validation_show_error('nombre'); ?></span>
                    </div>
                    <div class="mb-2">
                        <label for="puntos_facil" class="form-label ms-1 mb-0">Puntos nivel fácil</label>
                        <input type="number" class="form-control" id="puntos_facil" name="puntos_facil" placeholder="puntos"  value="<?= rellenarDato($errors, $datos, "puntos_facil"); ?>">
                        <?php if (isset($errors['puntos_facil'])) ?>
                        <span class="text-danger"><?= validation_show_error('puntos_facil'); ?></span>
                        <?php if (isset($erroresExtra['puntos_facil'])) { ?>
                            <span class="text-danger"><?= $erroresExtra['puntos_facil'] ?></span>
                        <?php } ?>
                    </div>
                    <div class="mb-2">
                        <label for="puntos_normal" class="form-label ms-1 mb-0">Puntos nivel normal</label>
                        <input type="number" class="form-control" id="puntos_normal" name="puntos_normal" placeholder="puntos" value="<?= rellenarDato($errors, $datos, "puntos_normal"); ?>">
                        <?php if (isset($errors['puntos_normal'])) ?>
                        <span class="text-danger"><?= validation_show_error('puntos_normal'); ?></span>
                        <?php if (isset($erroresExtra['puntos_normal'])) { ?>
                            <span class="text-danger"><?= $erroresExtra['puntos_normal'] ?></span>
                        <?php } ?>
                    </div>
                    <div class="mb-2">
                        <label for="puntos_dificil" class="form-label ms-1 mb-0">Puntos nivel difícil</label>
                        <input type="number" class="form-control" id="puntos_dificil" name="puntos_dificil" placeholder="puntos" value="<?= rellenarDato($errors, $datos, "puntos_dificil"); ?>">
                        <?php if (isset($errors['puntos_dificil'])) ?>
                        <span class="text-danger"><?= validation_show_error('puntos_dificil'); ?></span>
                        <?php if (isset($erroresExtra['puntos_dificil'])) { ?>
                            <span class="text-danger"><?= $erroresExtra['puntos_dificil'] ?></span>
                        <?php } ?>
                    </div>
                    <div>
                        <input type="submit" class="form-control btn btn-principal mt-1" value="Aceptar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include("templates/parte2.php"); ?>
