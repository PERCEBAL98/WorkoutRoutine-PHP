<?php 
$page = basename($_SERVER['PHP_SELF']);
?>
<ul class="mt-2 mb-2 d-flex contenedor-menu">
    <?php if (session()->get('usuario')) { ?>
    <li class="ps-2 pe-2 me-2 pb-1 <?php if ($page == "perfil") {?>activo<?php } ?>">
        <a href="<?= baseUrl() ?>/perfil">Mi Perfil</a>
    </li>
    <li class="ps-2 pe-2 me-2 pb-1 <?php if ($page == "calendario") {?>activo<?php } ?>">
        <a href="<?= baseUrl() ?>/calendario">Calendario</a>
    </li>
    <li class="ps-2 pe-2 me-2 pb-1 <?php if ($page == "ajustes") {?>activo<?php } ?>">
        <a href="<?= baseUrl() ?>/ajustes">Ajustes</a>
    </li>
    <?php } ?>
    <li class="ps-2 pe-2 me-2 pb-1 <?php if ($page == "preguntas") {?>activo<?php } ?>">
        <a href="<?= baseUrl() ?>/preguntas">Preguntas</a>
    </li>
    <!--<li>
        <a href="<?= baseUrl() ?>/salir">Soporte</a>
    </li>-->
</ul>