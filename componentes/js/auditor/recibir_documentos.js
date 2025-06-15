document.addEventListener('DOMContentLoaded', () => {
    
    // Obtener elementos
    const btnDocumentos = document.getElementById('btn-documentos');
    const btnExpedientes = document.getElementById('btn-expedientes');
    const todasLasCartas = document.querySelectorAll('.carta');

    // Función para mostrar solo documentos
    function mostrarDocumentos() {
        // Cambiar clases activas en los botones
        btnDocumentos.classList.add('active');
        btnExpedientes.classList.remove('active');
        
        // Mostrar solo cartas de documentos, ocultar expedientes
        todasLasCartas.forEach(carta => {
            if (carta.dataset.tipo === 'documento') {
                carta.classList.remove('oculto');
            } else {
                carta.classList.add('oculto');
            }
        });
    }

    // Función para mostrar solo expedientes
    function mostrarExpedientes() {
        // Cambiar clases activas en los botones
        btnExpedientes.classList.add('active');
        btnDocumentos.classList.remove('active');
        
        // Mostrar solo cartas de expedientes, ocultar documentos
        todasLasCartas.forEach(carta => {
            if (carta.dataset.tipo === 'expediente') {
                carta.classList.remove('oculto');
            } else {
                carta.classList.add('oculto');
            }
        });
    }

    // Event listeners para los botones
    btnDocumentos.addEventListener('click', mostrarDocumentos);
    btnExpedientes.addEventListener('click', mostrarExpedientes);

    // Estado inicial: mostrar solo documentos
    mostrarDocumentos();






const botonesModal = document.querySelectorAll(".aprobado"); // Botones de aprobar
const btn_cancelar = document.getElementById("cancelar");
const btn_salir = document.querySelector(".close");
const modal_expediente = document.getElementById("modal_confirmar");
const inputHidden = document.getElementById("datos_expediente"); // Input hidden del modal

// Agregar event listener a cada botón de aprobar
botonesModal.forEach(boton => {
    boton.addEventListener("click", (e) => {
        // Obtener la tarjeta específica
        const tarjeta = e.target.closest('.carta');
        
        // Obtener el ID del expediente desde el atributo data-id del botón
        const idExpediente = e.target.getAttribute('data-id');
        
        // Asignar el ID al input hidden del modal
        if (inputHidden && idExpediente) {
            inputHidden.value = idExpediente;
        }
        
        // Mostrar el modal
        if(modal_expediente.style.display == 'block'){
            modal_expediente.style.display = 'none';
        } else {
            modal_expediente.style.display = 'block';
        }
    });
});

// Cerrar modal con botón cancelar
btn_cancelar.addEventListener("click", () => {
    modal_expediente.style.display = 'none';
});

// Cerrar modal con la X
btn_salir.addEventListener("click", () => {
    modal_expediente.style.display = 'none';
});

// Opcional: Cerrar modal al hacer clic fuera de él
window.addEventListener("click", (e) => {
    if (e.target === modal_expediente) {
        modal_expediente.style.display = 'none';
    }
});
});