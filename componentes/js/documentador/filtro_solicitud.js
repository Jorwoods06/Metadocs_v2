

  const filtro = document.getElementById('tipo-filtro');
  const mensajes = document.querySelectorAll('.mensaje');

  filtro.addEventListener('change', () => {
    const valor = filtro.value;

    mensajes.forEach(mensaje => {
      const tipo = mensaje.dataset.tipo;
      if (valor === 'todos' || tipo === valor) {
        mensaje.style.display = 'flex';
      } else {
        mensaje.style.display = 'none';
      }
    });
  });
