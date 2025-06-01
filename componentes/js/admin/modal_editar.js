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

});
