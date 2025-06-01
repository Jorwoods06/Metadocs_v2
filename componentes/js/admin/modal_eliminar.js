document.addEventListener('DOMContentLoaded', () => {
    const modalEliminar = document.getElementById('modal-eliminar');
    const closeEliminar = modalEliminar.querySelector('.close');
    const cancelarBtn = modalEliminar.querySelector('.btn-cancelar');
    const botonesEliminar = document.querySelectorAll('.bi-trash');

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
});
