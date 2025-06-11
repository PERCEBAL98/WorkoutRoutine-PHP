<script>
    $(document).ready(function () {
        $(".table").DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 to 0 of 0 registros",
                "infoFiltered": "(Filtrado de _MAX_ registros)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": 'Ver _MENU_ registros por página',
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": '<img src="<?= baseUrl() ?>/assets/icons/flecha-derecha.svg" alt="flecha">',
                    "previous": '<img src="<?= baseUrl() ?>/assets/icons/flecha-izquierda.svg" alt="flecha">'
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            },
            pageLength: 5,
            lengthMenu: [
                [5, 10, 20, -1],
                [5, 10, 20, 'Todos']
            ]/*,
            initComplete: function() {
                $("#spinner").fadeOut("fast", function () {
                    $("#tablaRoles").fadeIn("fast");
                });
            }*/
        });
    });
</script>