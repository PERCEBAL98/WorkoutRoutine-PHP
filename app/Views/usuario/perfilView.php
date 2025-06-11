<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid"></div>
        <?php include("templates/menuOpciones1.php"); ?>
        <div class="d-flex align-items-center mt-3">
            <img src="<?= baseUrl() ?>/assets/img/<?= session()->get('avatar') ?>" alt="Perfil" class="perfil-img me-2 border">
            <h3 class="m-0"><?= $datos['nombre'] ?></h3>
        </div>
        <div class="mt-3 row">
            <div class="col-12 col-sm-12 col-md-6">
                <div class="mb-2 border-bottom">
                    <h5>Cambiar imagen de avatar</h5>
                </div>
                <div class="position-relative">
                    <div class="scroll-wrapper d-flex align-items-stretch">
                        <button class="scroll-btn scroll-left btn d-flex align-items-center">
                            <img src="<?= baseUrl() ?>/assets/icons/flecha-izquierda.svg" alt="felcha">
                        </button>
                        <div class="scroll-container d-flex align-items-center">
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/hombre/negro.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/hombre/negro.svg" alt="Perfil" data-avatar="avatares/hombre/negro.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/hombre/negro.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/hombre/marron.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/hombre/marron.svg" alt="Perfil" data-avatar="avatares/hombre/marron.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/hombre/marron.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/hombre/amarillo.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/hombre/amarillo.svg" alt="Perfil" data-avatar="avatares/hombre/amarillo.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/hombre/amarillo.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/hombre/rojo.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/hombre/rojo.svg" alt="Perfil" data-avatar="avatares/hombre/rojo.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/hombre/rojo.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/hombre/gris.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/hombre/gris.svg" alt="Perfil" data-avatar="avatares/hombre/gris.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/hombre/gris.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/hombre/transparente.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/hombre/transparente.svg" alt="Perfil" data-avatar="avatares/hombre/transparente.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/hombre/transparente.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/mujer/negro.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/mujer/negro.svg" alt="Perfil" data-avatar="avatares/mujer/negro.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/mujer/negro.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/mujer/marron.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/mujer/marron.svg" alt="Perfil" data-avatar="avatares/mujer/marron.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/mujer/marron.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/mujer/amarillo.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/mujer/amarillo.svg" alt="Perfil" data-avatar="avatares/mujer/amarillo.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/mujer/amarillo.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/mujer/rojo.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/mujer/rojo.svg" alt="Perfil" data-avatar="avatares/mujer/rojo.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/mujer/rojo.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/mujer/gris.svg") { ?>selected<?php } ?> me-2">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/mujer/gris.svg" alt="Perfil" data-avatar="avatares/mujer/gris.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/mujer/gris.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>
                            <div class="avatar-wrapper <?php if (session()->get('avatar') == "avatares/mujer/transparente.svg") { ?>selected<?php } ?>">
                                <img src="<?= baseUrl() ?>/assets/img/avatares/mujer/transparente.svg" alt="Perfil" data-avatar="avatares/mujer/transparente.svg" class="perfil-img border <?php if (session()->get('avatar') != "avatares/mujer/transparente.svg") { ?>seleccion-avatar<?php } ?>">
                                <div class="avatar-overlay">✔</div>
                            </div>    
                        </div>
                        <button class="scroll-btn scroll-right btn d-flex align-items-center">
                            <img src="<?= baseUrl() ?>/assets/icons/flecha-derecha.svg" alt="felcha">
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 mb-3 row">
            <div class="col-12 col-sm-12 col-md-6">
                <div class="mb-2 border-bottom">
                    <h5>Cambiar contraseña</h5>
                </div>
                <form id="formCambiarContraseña" class="row">
                    <div class="col-12 col-xl-10">
                        <div class="mb-2">
                            <label for="contraseña" class="form-label ms-1 mb-0">Contraseña</label>
                            <input class="form-control" type="password" id="contraseña" placeholder="contraseña" name="contraseña">
                            <?php if (isset($errors['contraseña']))?>
                            <span class="text-danger"><?= validation_show_error('contraseña'); ?></span>
                        </div>
                        <div class="mb-2">
                            <label for="confirmar_contraseña" class="form-label ms-1 mb-0">Confirmar Contraseña</label>
                            <input class="form-control" type="password" id="confirmar_contraseña" placeholder="confirmar contraseña" name="confirmar_contraseña">
                            <?php if (isset($errors['confirmar_contraseña']))?>
                            <span class="text-danger"><?= validation_show_error('confirmar_contraseña'); ?></span>
                        </div>
                        <input type="submit" class="form-control btn btn-principal mt-1" value="Aceptar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include("templates/parte2.php"); ?>