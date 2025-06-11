<?php 
$page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkoutRoutine</title>
    <link rel="icon" type="image/x-icon" href="<?= baseUrl() ?>/assets/favicon.ico">
    <link href="<?= baseUrl(); ?>/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= baseUrl(); ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= baseUrl(); ?>/assets/libs/select2/css/select2-bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= baseUrl(); ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <?php if ($page == "sigin" || $page == "register") { ?>
        <link href="<?= baseUrl(); ?>/assets/css/sigin.css" rel="stylesheet" type="text/css">
    <?php } ?>
    <?php if ($page == "listado") { ?>
        <link href="<?= baseUrl(); ?>/assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= baseUrl(); ?>/assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= baseUrl(); ?>/assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= baseUrl(); ?>/assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= baseUrl(); ?>/assets/css/tablas.css" rel="stylesheet" type="text/css">
    <?php } ?>
    <?php if ($page == "nuevo" || $page == "editar") { ?>
        <link href="<?= baseUrl(); ?>/assets/css/formularios.css" rel="stylesheet" type="text/css">
    <?php } ?>
    <?php if ($page == "calendario") { ?>
        <link href="<?= baseUrl(); ?>/assets/libs/fullcalendar/css/main.min.css" rel="stylesheet" type="text/css" />
    <?php } ?>
    <link href="<?= baseUrl(); ?>/assets/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>