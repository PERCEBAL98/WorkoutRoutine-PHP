<div id="sidebar" class="sidebar expanded">
    <ul class="menu">
        <?php if (session()->get('id_rol') == 1) { ?>
            <div id="menuAdmin">
                <li id="tituloMenuAdmin" class="show"><span class="titulo">Menú administración</span></li>
                <div>
                    <!-- <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/admin/panel">
                        <img src="<?= baseUrl() ?>/assets/icons/dashboard.svg" alt="dashboard">
                        <span id="tituloPanel">Panel de Control</span>
                    </a></li> -->
                    <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/ejercicios/listado">
                        <img src="<?= baseUrl() ?>/assets/icons/lista.svg" alt="lista">
                        <span>Ejercicios</span>
                    </a></li>
                    <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/logros/listado">
                        <img src="<?= baseUrl() ?>/assets/icons/medalla.svg" alt="medalla">
                        <span>Logros</span>
                    </a></li>
                    <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/usuarios/listado">
                        <img src="<?= baseUrl() ?>/assets/icons/usuario.svg" alt="usuario">
                        <span>Usuarios</span>
                    </a></li>
                    <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/roles/listado">
                        <img src="<?= baseUrl() ?>/assets/icons/usuario-rol.svg" alt="rol">
                        <span>Roles</span>
                    </a></li>
                </div>
            </div>
            <li><hr class="divider" id="menuDividerAdmin"></li>
        <?php } ?>
        <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/ejercicios">
            <img src="<?= baseUrl() ?>/assets/icons/lupa.svg" alt="lupa">
            <span>Ejercicios</span>
        </a></li>
        <!-- <li class="me-2"><a class="btn link" href="#">
            <img src="<?= baseUrl() ?>/assets/icons/bandera.svg" alt="bandera">
            <span>Retos</span> -->
        </a></li>
        <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/logros">
            <img src="<?= baseUrl() ?>/assets/icons/medalla.svg" alt="medalla">
            <span>Logros</span>
        </a></li>
        <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/rutinas">
            <img src="<?= baseUrl() ?>/assets/icons/mancuerna.svg" alt="mancuerna">
            <span>Rutinas</span>
        </a></li>
        <?php if (session()->get('usuario')) { ?>
            <li><hr class="divider show" id="menuDivider1"></li>
            <div class="show" id="menuInicial">
                <li><span class="titulo">Crear rutina</span></li>
                <div>
                    <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/rutinas/automaticamente">
                        <img src="<?= baseUrl() ?>/assets/icons/varita.svg" alt="mancuerna">
                        <span>Automáticamente</span>
                    </a></li>
                    <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/rutinas/personalizada">
                        <img src="<?= baseUrl() ?>/assets/icons/personalizar.svg" alt="mancuerna">
                        <span>Personalizada</span>
                    </a></li>
                </div>
            </div>
        <?php } ?>
        <?php if (session()->get('id_rol') != 1) { ?>
            <li><hr class="divider show" id="menuDivider2"></li>
            <div class="show" id="menuIntermedio">
                <?php if (session()->get('usuario')) { ?>
                    <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/ajustes">
                        <img src="<?= baseUrl() ?>/assets/icons/ajustes.svg" alt="mancuerna">
                        <span>Ajustes</span>
                    </a></li>
                <?php } ?>
                <li class="me-2"><a class="btn link" href="<?= baseUrl() ?>/preguntas">
                    <img src="<?= baseUrl() ?>/assets/icons/pregunta.svg" alt="mancuerna">
                    <span>Preguntas</span>
                </a></li>
                <!--<li class="me-2"><a class="btn link" href="#">
                    <img src="<?= baseUrl() ?>/assets/icons/soporte.svg" alt="mancuerna">
                    <span>Soporte</span>
                </a></li>-->
            </div>
        <?php } ?>
        <li><hr class="divider show" id="menuDivider3"></li>
        <div class="menu-footer show" id="menuFooter">
            <div>
                <p><a href="<?= baseUrl() ?>/terminos-condiciones">Términos y condiciones</a></p>
                <p><a href="<?= baseUrl() ?>/privacidad">Política de privacidad</a></p>
                <p><a href="<?= baseUrl() ?>/cookies">Política de cookies</a></p>
                <p><a href="<?= baseUrl() ?>/aviso-legal">Aviso legal</a></p>
            </div>
            <span class="copyright">© 2025 WorkoutRoutine</span>
        </div>
    </ul>
</div>
