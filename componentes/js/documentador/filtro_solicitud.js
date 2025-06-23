

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


  const cuerpo_contenido = document.getElementById('contenido_solicitud');
  const cerrar = document.getElementById("cerrar_contenido");

  cerrar.addEventListener('click', ()=>{

 
       if (cuerpo_contenido.style.display == 'none') {
        cuerpo_contenido.style.display = 'flex';
        }else{
          cuerpo_contenido.style.display = 'none';
        }

  });