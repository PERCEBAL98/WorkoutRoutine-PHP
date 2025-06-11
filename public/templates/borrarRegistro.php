<script>
    $(".borrar").click(function(e) {
        let id = $(this).attr('data-id');
        let nombre = $(this).attr('data-name');
        let padre = $(this).parent().parent();
        let urlNombre = (nombre == "rol") ? nombre + "es" : nombre + "s";
        let url = `<?php echo baseUrl(); ?>/${urlNombre}/eliminar`

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger me-2"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: `Desea eliminar el ${nombre}?`,
            text: "no hay vuelta atrás!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, borrar",
            cancelButtonText: "No, mantener",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    data: {
                        id: id
                    },
                    method: "POST",
                    url: url,
                    success: function(result) {
                        alert(result)
                        if (result.success) {
                            swalWithBootstrapButtons.fire({
                                title: "Eliminado!",
                                text: `${nombre} dado de baja`,
                                icon: "success"
                            });
                            padre.hide();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "No Eliminado!",
                                text: `${nombre} dado de baja`,
                                icon: "error"
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {}
        });
    });
</script>