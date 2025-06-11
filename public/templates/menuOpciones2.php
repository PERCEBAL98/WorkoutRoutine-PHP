<?php 
$page = basename($_SERVER['PHP_SELF']);
?>
<ul class="mt-2 mb-2 d-flex contenedor-menu">
    <li class="ps-2 pe-2 me-2 pb-1 <?php if ($page == "terminos-condiciones") {?>activo<?php } ?>">
        <a href="<?= baseUrl() ?>/terminos-condiciones">Terminos y condiciones</a>
    </li>
    <li class="ps-2 pe-2 me-2 pb-1 <?php if ($page == "privacidad") {?>activo<?php } ?>">
        <a href="<?= baseUrl() ?>/privacidad">Privacidad</a>
    </li>
    <li class="ps-2 pe-2 me-2 pb-1 <?php if ($page == "cookies") {?>activo<?php } ?>">
        <a href="<?= baseUrl() ?>/cookies">Cookies</a>
    </li>
    <li class="ps-2 pe-2 me-2 pb-1 <?php if ($page == "aviso-legal") {?>activo<?php } ?>">
        <a href="<?= baseUrl() ?>/aviso-legal">Aviso legal</a>
    </li>
</ul>