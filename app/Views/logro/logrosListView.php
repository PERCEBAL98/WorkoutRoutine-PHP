<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 col-md-12">
                <div class="bg-white p-4 mt-2 rounded contenedor-tabla">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h4>Listado de logros</h4>
                        <a href="<?= baseUrl(); ?>/logros/nuevo" class="ms-1 btn btn-principal d-flex align-items-center gap-1">
                            <img src="<?= baseUrl() ?>/assets/icons/tabla-añadir.svg" alt="añadir">
                            Crear
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover w-100 datatable-buttons" id="tablaLogros">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($datos) > 0) {
                                    foreach ($datos as $dato) {
                                ?>
                                        <tr>
                                            <td><?= $dato["id"]; ?></td>
                                            <td><?= $dato["nombre"]; ?></td>
                                            <td>
                                                <a href="<?= baseUrl(); ?>/logros/editar?id=<?= encriptar($dato["id"]); ?>" class="btn btn-editar"><img src="<?= baseUrl() ?>/assets/icons/tabla-editar.svg" alt="editar"></a>
                                                <a data-id="<?= encriptar($dato["id"]); ?>" data-name="logro" class="btn btn-borrar borrar"><img src="<?= baseUrl() ?>/assets/icons/tabla-borrar.svg" alt="eliminar"></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("templates/parte2.php"); ?>