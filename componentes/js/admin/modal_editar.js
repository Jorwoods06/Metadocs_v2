document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal-editar');
  const form = document.getElementById('form_editar');

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

  form.addEventListener('submit', e => {
    e.preventDefault();
    alert('Cambios guardados (simulado)');
    modal.style.display = 'none';
  });
});
