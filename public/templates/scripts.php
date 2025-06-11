<?php 
$page = basename($_SERVER['PHP_SELF']);
?>
<!-- BOOTSTRAP -->
<script src="<?= baseUrl() ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- JQUERY -->
<script src="<?= baseUrl() ?>/assets/libs/jquery/js/jquery-3.7.1.min.js"></script>
<!-- DATATABLES -->
<script src="<?php echo baseUrl(); ?>/assets/libs/datatables/jquery.dataTables.min.js"></script>
<!-- SELECT2 -->
<script src="<?php echo baseUrl(); ?>/assets/libs/select2/js/select2.min.js"></script>
<!-- SWEETALERT2 -->
<script src="<?php echo baseUrl(); ?>/assets/libs/sweetalert2/sweetalert2.all.js"></script>
<!-- SORTABLEJS -->
<script src="<?php echo baseUrl(); ?>/assets/libs/sortable/sortable.min.js"></script>
<!-- CHART -->
<script src="<?php echo baseUrl(); ?>/assets/libs/chart/chart.js"></script>

<!-- MIS JS -->
<script src="<?= baseUrl() ?>/assets/js/menu.js"></script>
<script src="<?= baseUrl() ?>/assets/js/header.js"></script>

<?php if ($page == "ejercicios") { ?>
<script src="<?= baseUrl() ?>/assets/js/ejercicios.js"></script>
<?php } ?>
<?php if ($page == "logros") {
    include("borrarRegistro.php");
?>
<script src="<?= baseUrl() ?>/assets/js/logros.js"></script>
<?php } ?>
<?php if ($page == "rutinas" || $page == "rutina") { ?>
<script src="<?= baseUrl() ?>/assets/js/rutinas.js"></script>
<?php } ?>
<?php if ($page == "rutina") {?>
<script src="<?= baseUrl() ?>/assets/js/rutina-ver.js"></script>
<?php } ?>
<?php if (isset($_GET['tipo']) && $_GET['tipo'] == "repeticiones") {?>
<script src="<?= baseUrl() ?>/assets/js/rutina-repeticiones.js"></script>
<?php } ?>
<?php if (isset($_GET['tipo']) && $_GET['tipo'] == "tiempo") {?>
<script src="<?= baseUrl() ?>/assets/js/rutina-tiempo.js"></script>
<?php } ?>
<?php if ($page == "automaticamente" || $page == "personalizada") { ?>
<script src="<?= baseUrl() ?>/assets/js/rutina-crear.js"></script>
<?php } ?>
<?php if ($page == "personalizada") { ?>
<script src="<?= baseUrl() ?>/assets/js/ejercicios.js"></script>
<?php } ?>
<?php if ($page == "perfil") { ?>
<script src="<?= baseUrl() ?>/assets/js/perfil.js"></script>
<?php } ?>   
<?php if ($page == "calendario") { ?>
<script src="<?= baseUrl() ?>/assets/libs/fullcalendar/js/main.min.js"></script>
<script src="<?= baseUrl() ?>/assets/libs/fullcalendar/lang/es.js"></script>
<script src="<?= baseUrl() ?>/assets/js/calendario.js"></script>
<?php } ?>   
<?php if ($page == "preguntas") { ?>
<script src="<?= baseUrl() ?>/assets/js/preguntas.js"></script>
<?php } ?>  
<?php if ($page == "listado") {
    include("scriptDataTable.php");
    include("borrarRegistro.php");
} ?>
<?php if ($page == "nuevo" || $page == "editar") { ?>
<script src="<?php echo baseUrl(); ?>/assets/libs/tinymce/js/tinymce/tinymce.min.js"></script>
<?php
    include("scriptFormularios.php");
} ?>