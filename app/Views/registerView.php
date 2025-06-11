<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">

    <div class="container">
        <div class="register-container">
            <h3 class="text-center mb-3">Crear Cuenta</h3>

            <!-- Mensaje de éxito -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <form action="<?= base_url(); ?>/sigin/registerUser" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Nombre de Usuario</label>
                    <input class="form-control" type="text" id="usuario" placeholder="nombre de usuario" name="usuario" value="<?= set_value('usuario'); ?>">
                    <?php if (isset($errors['usuario']))?>
                    <span class="text-danger"><?= validation_show_error('usuario'); ?></span>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input class="form-control" type="email" id="email" placeholder="correo electrónico" name="email" value="<?= set_value('email'); ?>">
                    <?php if (isset($errors['email']))?>
                    <span class="text-danger"><?= validation_show_error('email'); ?></span>
                </div>

                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña</label>
                    <input class="form-control" type="password" id="contraseña" placeholder="contraseña" name="contraseña">
                    <?php if (isset($errors['contraseña']))?>
                    <span class="text-danger"><?= validation_show_error('contraseña'); ?></span>
                </div>

                <div class="mb-3">
                    <label for="confirmar_contraseña" class="form-label">Confirmar Contraseña</label>
                    <input class="form-control" type="password" id="confirmar_contraseña" placeholder="confirmar contraseña" name="confirmar_contraseña">
                    <?php if (isset($errors['confirmar_contraseña']))?>
                    <span class="text-danger"><?= validation_show_error('confirmar_contraseña'); ?></span>
                </div>

                <button type="submit" class="btn btn-principal w-100">Registrarme</button>
            </form>

            <p class="mt-3 text-center">
                ¿Ya tienes cuenta? <a class="register-link" href="<?= baseUrl(); ?>/sigin">Inicia sesión</a>
            </p>
        </div>
    </div>
</main>
<?php include("templates/parte2.php"); ?>