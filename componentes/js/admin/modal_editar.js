document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal-editar');
  const close = document.querySelector('.close');


  document.querySelectorAll('.fa-edit').forEach(button => {
    button.addEventListener('click', () => {
      modal.style.display = 'block';
    });
  });

 
   close.addEventListener('click', e => {
    modal.style.display = 'none';
   });


   
  //==== capturar datos y enviarlo a php, con el fin de editar el usuario ====//

  
let correoOriginal = '';

// ACTUALIZADO: Cambié .bi-pencil por .fa-edit
document.querySelectorAll('.fa-edit').forEach(icono => {
    icono.addEventListener('click', function(e) {
        const fila = e.target.closest('tr');
        const celdas = fila.getElementsByTagName('td');
        
        document.getElementById('nombre_editar').value = celdas[0].textContent;
        document.getElementById('correo_editar').value = celdas[1].textContent;
        document.getElementById('rol_editar').value = celdas[2].textContent.toLowerCase();
        document.getElementById('area_editar').value = celdas[3].textContent.toLowerCase();
        
    
        correoOriginal = celdas[1].textContent;
        
       
        document.getElementById('modal-editar').style.display = 'block';
    });
});

// Enviar al PHP
document.querySelector('.btn_editar').addEventListener('click', function(e) {
    e.preventDefault(); 
    
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
            const modaledicion = document.getElementById('modal-exito-editar');
            if(modaledicion.style.display == 'flex'){
                modaledicion.style.display = 'none'
            }else{
                modaledicion.style.display = 'flex'
            }
            
            document.getElementById('modal-editar').style.display = 'none';
           
           
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