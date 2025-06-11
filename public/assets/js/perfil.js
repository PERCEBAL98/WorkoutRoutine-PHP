const scrollContainer = document.querySelector('.scroll-container');
const scrollLeftBtn = document.querySelector('.scroll-left');
const scrollRightBtn = document.querySelector('.scroll-right');

function updateScrollButtons() {
  const scrollLeft = scrollContainer.scrollLeft;
  const scrollWidth = scrollContainer.scrollWidth;
  const clientWidth = scrollContainer.clientWidth;

  if (scrollLeft > 0) {
    scrollLeftBtn.classList.remove('d-none');
  } else {
    scrollLeftBtn.classList.add('d-none');
  }

  if (scrollLeft + clientWidth < scrollWidth - 1) {
    scrollRightBtn.classList.remove('d-none');
  } else {
    scrollRightBtn.classList.add('d-none');
  }
}

scrollContainer.addEventListener('scroll', updateScrollButtons);
window.addEventListener('resize', updateScrollButtons);

scrollLeftBtn.addEventListener('click', () => {
  scrollContainer.scrollBy({ left: -72, behavior: 'smooth' });
});

scrollRightBtn.addEventListener('click', () => {
  scrollContainer.scrollBy({ left: 72, behavior: 'smooth' });
});

updateScrollButtons();

$(document).on("click", ".seleccion-avatar", function (e) {
    e.preventDefault();

    let avatar = $(this).data("avatar");

    if (!avatar) return;

    Swal.fire({
        title: "¿Quieres usar este avatar?",
        imageUrl: $(this).attr("src"),
        showCancelButton: true,
        confirmButtonText: "Sí, usar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                data: { avatar: avatar },
                method: "POST",
                url: `${BASE_URL}/perfil/avatar`,
                success: function(result) {
                    if (result.success) {
                        location.reload();
                    } else {
                        console.error("Error al actualizar el avatar");
                    }
                }
            });
        }
    });
});

$('#formCambiarContraseña').on('submit', function(e) {
    e.preventDefault();

    const nueva = $('#contraseña').val();
    const confirmar = $('#confirmar_contraseña').val();

    if (!nueva || !confirmar) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: 'Completa los dos campos de contraseña',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#fff',
            color: '#3C3C43',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        return;
    }

    if (nueva !== confirmar) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: 'Las contraseñas no coinciden',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#fff',
            color: '#3C3C43',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        return;
    }

    if (nueva.length < 8) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: 'La contraseña debe tener al menos 8 caracteres',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#fff',
            color: '#3C3C43',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        return;
    }

    Swal.fire({
        title: 'Confirma tu identidad',
        input: 'password',
        inputLabel: 'Introduce tu contraseña actual',
        inputPlaceholder: 'Contraseña actual',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Cambiar contraseña',
        showLoaderOnConfirm: true,
        preConfirm: (actual) => {
            return $.ajax({
                method: 'POST',
                url: `${BASE_URL}/perfil/cambiar-password`,
                data: {
                    actual: actual,
                    contraseña: nueva,
                    confirmar_contraseña: confirmar
                }
            }).then(response => {
                if (response.status === 'ok') {
                    return true;
                } else {
                    throw new Error(response.message || 'Error al cambiar la contraseña');
                }
            }).catch(error => {
                Swal.showValidationMessage(error.message);
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: 'La contraseña ha sido cambiada correctamente',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                background: '#fff',
                color: '#3C3C43',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            $('#formCambiarContraseña')[0].reset();
        }
    });
});