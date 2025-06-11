<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid">
        <div class="row mb-3 mt-2 justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-xl-4 bg-white p-4 rounded formulario">
                <div class="pb-1 mb-2 border-bottom">
                    <h4>Crear rol</h4>
                </div>
                <?php
                $errors = validation_errors();
                ?>
                <form action="<?php echo baseUrl(); ?>/roles/crear" method="post" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="nombre" class="form-label mb-0 ms-1 mb-0">Nombre</label>
                        <input type="nombre" class="form-control" id="nombre" name="nombre" placeholder="nombre"  value="<?= set_value('nombre'); ?>">
                        <?php if (isset($errors['nombre'])) ?>
                        <span class="text-danger"><?= validation_show_error('nombre'); ?></span>
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