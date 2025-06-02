document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal-editar');
  const close = document.querySelector('.close');

  document.querySelectorAll('.bi-pencil').forEach(button => {
    button.addEventListener('click', () => {
      modal.style.display = 'block';
    });
  });

  window.addEventListener('click', e => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });

   close.addEventListener('click', e => {
    modal.style.display = 'none';
   });


   
  //==== capturar datos y enviarlo a php, con el fin de editar el usuario ====//

   // Variable global para guardar el correo original
let correoOriginal = '';

document.querySelectorAll('.bi-pencil').forEach(icono => {
    icono.addEventListener('click', function(e) {
        const fila = e.target.closest('tr');
        const celdas = fila.getElementsByTagName('td');
        
        document.getElementById('nombre_editar').value = celdas[0].textContent;
        document.getElementById('correo_editar').value = celdas[1].textContent;
        document.getElementById('rol_editar').value = celdas[2].textContent.toLowerCase();
        document.getElementById('area_editar').value = celdas[3].textContent.toLowerCase();
        
        // Guardar el correo original para la actualización
        correoOriginal = celdas[1].textContent;
        
        // Mostrar el modal
        document.getElementById('modal-editar').style.display = 'block';
    });
});

// Enviar al PHP
document.querySelector('.btn_editar').addEventListener('click', function(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del botón
    
    const formData = new FormData();
    
    formData.append('accion', 'editar_usuario');
    formData.append('correo', correoOriginal); // Correo original para identificar el usuario
    formData.append('nombre', document.getElementById('nombre_editar').value);
    formData.append('correo_nuevo', document.getElementById('correo_editar').value);
    formData.append('rol', document.getElementById('rol_editar').value);
    formData.append('area', document.getElementById('area_editar').value);
    
    fetch('../../../app/backend/administrador/editar_eliminar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Usuario editado correctamente');
            // Cerrar modal
            document.getElementById('modal-editar').style.display = 'none';
            // Recargar la página para mostrar los cambios
            location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
    });
});

});
