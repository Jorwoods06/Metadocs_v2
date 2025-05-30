document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal-editar');
  const closeBtn = document.querySelector('.close');

  // Abrir modal (ya lo debes tener)
  document.querySelectorAll('.bi-pencil').forEach(button => {
    button.addEventListener('click', () => {
      modal.style.display = 'flex';
    });
  });

  document.querySelector('.bi-pencil').addEventListener('click', function(){
    document.getElementById('modal-editar').style.display = 'block'
  })

  document.querySelector('#modal-editar .close').addEventListener('click', function (){
    document.getElementById('modal-editar').style.display = 'none';
  })

 
  // Cerrar al hacer clic en la X
  closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });


});
