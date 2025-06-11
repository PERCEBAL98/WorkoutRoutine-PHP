<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container">
        <div class="login-container">
            <h3 class="text-center mb-3">Iniciar Sesión</h3>

            <!-- Mensajes de error -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= baseUrl(); ?>/sigin/loginAuth" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario o Correo Electrónico</label>
                    <input class="form-control" type="text" id="usuario" placeholder="usuario o correo electrónico" name="usuario" value="<?= set_value('usuario'); ?>">
                    <?php if (isset($errors['usuario']))?>
                    <span class="text-danger"><?= validation_show_error('usuario'); ?></span>
                </div>
                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña</label>
                    <input class="form-control" type="password" id="contraseña" placeholder="contraseña" name="contraseña" value="<?= set_value('contraseña'); ?>">
                    <?php if (isset($errors['contraseña']))?>
                    <span class="text-danger"><?= validation_show_error('contraseña'); ?></span>
                </div>
                <button type="submit" class="btn btn-principal w-100">Ingresar</button>
            </form>

            <p class="mt-3 text-center">
                ¿No tienes cuenta? <a class="register-link" href="<?= baseUrl(); ?>/sigin/register">Regístrate</a>
            </p>
        </div>
    </div>
</main>
<?php include("templates/parte2.php"); ?>
