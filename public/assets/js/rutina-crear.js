$(document).ready(function () {
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: "Seleccione una opción",
        allowClear: true
    });

    $('#formRutina').on('submit', function (e) {
        e.preventDefault();

        let datos = $(this).serialize();       
        $.ajax({
            url: `${BASE_URL}/rutinas/automaticamente/crear`,
            method: 'POST',
            data: datos,
            success: function (response) {
                window.location.href = BASE_URL + "/rutina?ver=" + response.id;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.text-aviso').text('');

                if (jqXHR.status === 422) {
                    const errores = jqXHR.responseJSON.errors;

                    for (const campo in errores) {
                        $(`.error-${campo}`).text(errores[campo]);
                    }
                } else {
                    console.error('Error en la petición:', textStatus, errorThrown);
                }
            }
        });
    });
});

$('#rutinaPersonalizada').on('click', function (e) {
    e.preventDefault();

    let ejercicios = $('.container-ejercicios .card');
    let ids = [];

    ejercicios.each(function () {
        let id = $(this).data('id');
        if (id) {
            ids.push(id);
        }
    });

    if (ids.length < 3) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'warning',
            title: 'Debes añadir al menos 3 ejercicios para continuar.',
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

    $.ajax({
        url: `${BASE_URL}/rutinas/personalizada/crear`,
        method: 'POST',
        data: { ejercicios: ids },
        success: function (response) {
            window.location.href = BASE_URL + "/rutina?ver=" + response.id;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.text-aviso').text('');

            if (jqXHR.status === 422) {
                const errores = jqXHR.responseJSON.errors;

                for (const campo in errores) {
                    $(`.error-${campo}`).text(errores[campo]);
                }
            } else {
                console.error('Error en la petición:', textStatus, errorThrown);
            }
        }
    });
});

function drag(ev) {
    const target = ev.target.closest('.ejercicio-card');
    if (!target) return;

    const data = {
        id: target.dataset.id,
        img: target.dataset.img
    };
    ev.dataTransfer.setData("application/json", JSON.stringify(data));
}
function allowDrop(ev) {
    ev.preventDefault();
}

function drop(ev) {
    ev.preventDefault();

    const data = JSON.parse(ev.dataTransfer.getData("application/json"));

    const container = ev.target.closest('.container-ejercicios');
    if (!container) return;

    if (container.querySelector(`[data-id="${data.id}"]`)) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'warning',
            title: 'El ejercicio ya está en la lista de ejercicios.',
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
    };

    const currentCards = container.querySelectorAll('.card');
    if (currentCards.length >= 8) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: 'Máximo alcanzado, no puedes añadir más de 8 ejercicios.',
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

    if (currentCards.length === 0) {
        document.querySelector('.btn-info-personalizada')?.classList.remove('show');
    }
    
    const newCard = document.createElement('div');
    newCard.className = 'card mb-1 mb-2';
    newCard.dataset.id = data.id;
    newCard.innerHTML = `
        <button type="button" class="btn btn-eliminar position-absolute top-0 end-0 m-1 btn-remove-card" title="eliminar">
            <img src="${BASE_URL}/assets/icons/eliminar.svg" alt="eliminar">
        </button>
        <img src="${data.img}" class="card-img" alt="ejercicio">
    `;

    newCard.querySelector('.btn-remove-card').addEventListener('click', function (e) {
        e.stopPropagation();
        newCard.remove();
            
        if (container.querySelectorAll('.card').length === 0) {
            document.querySelector('.btn-info-personalizada')?.classList.add('show');
        }
    });

    container.appendChild(newCard);
}

$('.btn-info-personalizada').on('click', function (e) {
    e.preventDefault();

    Swal.fire({
        icon: 'info',
        title: 'Arrastra los ejercicios',
        text: 'Para añadir a la lista un ejercicio debes arrastrarlo a la caja de lista de ejercicios.'
    });
});