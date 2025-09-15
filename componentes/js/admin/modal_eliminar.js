document.addEventListener('DOMContentLoaded', () => {
    const modalEliminar = document.getElementById('modal-eliminar');
    const closeEliminar = modalEliminar.querySelector('.close');
    const cancelarBtn = modalEliminar.querySelector('.btn-cancelar');
    const botonesEliminar = document.querySelectorAll('.fa-trash');
    window.addEventListener('click', e => {
        if (e.target === modalEliminar) {
            modalEliminar.style.display = 'none';
        }
    });

    function abrirModalEliminar() {
        modalEliminar.style.display = 'flex';
    }

    function cerrarModalEliminar() {
        modalEliminar.style.display = 'none';
    }

    botonesEliminar.forEach(button => {
        button.addEventListener('click', abrirModalEliminar);
    });
    closeEliminar.addEventListener('click', cerrarModalEliminar);
    cancelarBtn.addEventListener('click', cerrarModalEliminar);

    let correoAEliminar = '';
    let filaAEliminar = null;

    document.querySelectorAll('.fa-trash').forEach(icono => {
        icono.addEventListener('click', function(e) {
            filaAEliminar = e.target.closest('tr');
            correoAEliminar = filaAEliminar.getElementsByTagName('td')[1].textContent.trim();
        });
    });

    document.querySelector('.btn-eliminar').addEventListener('click', function() {
        const formData = new FormData();
        formData.append('accion', 'eliminar_usuario');
        formData.append('correo', correoAEliminar);

        fetch('../../../app/backend/administrador/editar_eliminar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.text();
        })
        .then(() => {
            // Ocultar modal de eliminación
            document.getElementById('modal-eliminar').style.display = 'none';
            // Mostrar modal de éxito
            const modaleliminacion = document.getElementById('modal-exito-eliminar');
            modaleliminacion.style.display = 'flex';
            // Eliminar la fila de la tabla
            if (filaAEliminar) {
                filaAEliminar.remove();
            }
        })
        .catch(() => {
            alert('Error al intentar eliminar el usuario.');
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-modal-ok')) {
            const modalId = e.target.closest('.modal-notificacion').id;
            document.getElementById(modalId).style.display = 'none';
        }
    });

    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-notificacion')) {
            e.target.style.display = 'none';
        }
    });
});
