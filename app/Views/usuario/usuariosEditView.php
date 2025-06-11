<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid">
        <div class="row mb-3 mt-2 justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-xl-4 bg-white p-4 rounded formulario">
                <div class="pb-1 mb-2 border-bottom">
                    <h4>Editar usuario</h4>
                </div>
                <?php
                $errors = validation_errors();
                ?>
                <form action="<?php echo baseUrl(); ?>/usuarios/actualizar" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= encriptar($datos["id"]); ?>">
                    <div class="mb-2">
                        <label for="nombre" class="form-label ms-1 mb-0">Nombre</label>
                        <input type="nombre" class="form-control" id="nombre" name="nombre" placeholder="nombre" value="<?= rellenarDato($errors, $datos, "nombre"); ?>">
                        <?php if (isset($errors['nombre'])) ?>
                        <span class="text-danger"><?= validation_show_error('nombre'); ?></span>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label ms-1 mb-0">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="email" value="<?= rellenarDato($errors, $datos, "email"); ?>">
                        <?php if (isset($errors['email'])) ?>
                        <span class="text-danger"><?= validation_show_error('email'); ?></span>
                    </div>
                    <div class="mb-2">
                        <label for="id_rol" class="form-label ms-1 mb-0">Rol</label>
                        <?php echo form_dropdown('id_rol', $optionsRoles, rellenarDato($errors, $datos, "id_rol"), 'class="form-control select2" id="id_rol"')?>
                        <?php if (isset($errors['id_rol'])) ?>
                        <span class="text-danger"><?= validation_show_error('id_rol'); ?></span>
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
