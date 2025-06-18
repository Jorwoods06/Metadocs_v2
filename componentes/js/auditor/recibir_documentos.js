document.addEventListener('DOMContentLoaded', () => {
    
    // Obtener elementos
    const btnDocumentos = document.getElementById('btn-documentos');
    const btnExpedientes = document.getElementById('btn-expedientes');
    const contenedorDocumentos = document.getElementById('contenedor-documentos');
    const contenedorExpedientes = document.getElementById('contenedor-expedientes');

    // Función para mostrar solo documentos
    function mostrarDocumentos() {
        // Cambiar clases activas en los botones
        btnDocumentos.classList.add('active');
        btnExpedientes.classList.remove('active');
        
        // Mostrar contenedor de documentos, ocultar expedientes
        if (contenedorDocumentos) {
            contenedorDocumentos.style.display = 'block';
        }
        if (contenedorExpedientes) {
            contenedorExpedientes.style.display = 'none';
        }
    }

    // Función para mostrar solo expedientes
    function mostrarExpedientes() {
        // Cambiar clases activas en los botones
        btnExpedientes.classList.add('active');
        btnDocumentos.classList.remove('active');
        
        // Mostrar contenedor de expedientes, ocultar documentos
        if (contenedorExpedientes) {
            contenedorExpedientes.style.display = 'block';
        }
        if (contenedorDocumentos) {
            contenedorDocumentos.style.display = 'none';
        }
    }

    // Event listeners para los botones
    if (btnDocumentos) {
        btnDocumentos.addEventListener('click', mostrarDocumentos);
    }
    if (btnExpedientes) {
        btnExpedientes.addEventListener('click', mostrarExpedientes);
    }

    // Estado inicial: mostrar solo documentos
    mostrarDocumentos();

    // =================== MODALES ===================

    // Elementos del modal de expedientes
    const modalExpediente = document.getElementById("modal_confirmar_expediente");
    const btnCancelarExpediente = modalExpediente?.querySelector(".btn_cancelar");
    const btnSalirExpediente = modalExpediente?.querySelector(".close");
    const inputHiddenExpediente = modalExpediente?.querySelector("input[name='datos_expediente']");

    // Elementos del modal de documentos
    const modalDocumento = document.getElementById("modal_confirmar_documento");
    const btnCancelarDocumento = modalDocumento?.querySelector(".btn_cancelar");
    const btnSalirDocumento = modalDocumento?.querySelector(".close");
    const inputHiddenDocumento = modalDocumento?.querySelector("input[name='datos_documento']");

    // Función para mostrar modal
    function mostrarModal(modal) {
        if (modal) {
            modal.style.display = 'block';
        }
    }

    // Función para ocultar modal
    function ocultarModal(modal) {
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Event listeners para botones de aprobar EXPEDIENTES
    const botonesAprobarExpedientes = document.querySelectorAll("#contenedor-expedientes .aprobado");
    botonesAprobarExpedientes.forEach(boton => {
        boton.addEventListener("click", (e) => {
            // Obtener el ID del expediente desde el atributo data-id del botón
            const idExpediente = e.target.getAttribute('data-id');
            
            // Asignar el ID al input hidden del modal de expedientes
            if (inputHiddenExpediente && idExpediente) {
                inputHiddenExpediente.value = idExpediente;
            }
            
            // Mostrar el modal de expedientes
            mostrarModal(modalExpediente);
        });
    });

    // Event listeners para botones de aprobar DOCUMENTOS
    const botonesAprobarDocumentos = document.querySelectorAll("#contenedor-documentos .aprobado");
    botonesAprobarDocumentos.forEach(boton => {
        boton.addEventListener("click", (e) => {
            // Obtener el ID del documento desde el atributo data-id del botón
            const idDocumento = e.target.getAttribute('data-id');
            
            // Asignar el ID al input hidden del modal de documentos
            if (inputHiddenDocumento && idDocumento) {
                inputHiddenDocumento.value = idDocumento;
            }
            
            // Mostrar el modal de documentos
            mostrarModal(modalDocumento);
        });
    });

    // Event listeners para cerrar modal de expedientes
    if (btnCancelarExpediente) {
        btnCancelarExpediente.addEventListener("click", () => {
            ocultarModal(modalExpediente);
        });
    }

    if (btnSalirExpediente) {
        btnSalirExpediente.addEventListener("click", () => {
            ocultarModal(modalExpediente);
        });
    }

    // Event listeners para cerrar modal de documentos
    if (btnCancelarDocumento) {
        btnCancelarDocumento.addEventListener("click", () => {
            ocultarModal(modalDocumento);
        });
    }

    if (btnSalirDocumento) {
        btnSalirDocumento.addEventListener("click", () => {
            ocultarModal(modalDocumento);
        });
    }

    // =================== MODALES DE RECHAZO ===================

    // Elementos del modal de rechazo de expedientes
    const modalRechazarExpediente = document.getElementById("modal_rechazar_expediente");
    const btnCancelarRechazarExp = modalRechazarExpediente?.querySelector(".btn_cancelar");
    const btnSalirRechazarExp = modalRechazarExpediente?.querySelector(".close");
    const inputHiddenRechazarExp = modalRechazarExpediente?.querySelector("input[name='datos_expediente']");

    // Elementos del modal de rechazo de documentos
    const modalRechazarDocumento = document.getElementById("modal_rechazar_documento");
    const btnCancelarRechazarDoc = modalRechazarDocumento?.querySelector(".btn_cancelar");
    const btnSalirRechazarDoc = modalRechazarDocumento?.querySelector(".close");
    const inputHiddenRechazarDoc = modalRechazarDocumento?.querySelector("input[name='datos_documento']");

    // Event listeners para botones de rechazar EXPEDIENTES
    const botonesRechazarExpedientes = document.querySelectorAll("#contenedor-expedientes .rechazado");
    botonesRechazarExpedientes.forEach(boton => {
        boton.addEventListener("click", (e) => {
            // Buscar el botón de aprobar en la misma carta para obtener el data-id
            const tarjeta = e.target.closest('.carta');
            const botonAprobar = tarjeta?.querySelector('.aprobado');
            const idExpediente = botonAprobar ? botonAprobar.getAttribute('data-id') : null;
            
            // Asignar el ID al input hidden del modal de rechazo
            if (inputHiddenRechazarExp && idExpediente) {
                inputHiddenRechazarExp.value = idExpediente;
            }
            
            // Limpiar el textarea
            const textarea = modalRechazarExpediente?.querySelector('textarea[name="motivo_rechazo"]');
            if (textarea) {
                textarea.value = '';
            }
            
            // Mostrar el modal de rechazo de expedientes
            mostrarModal(modalRechazarExpediente);
        });
    });

    // Event listeners para botones de rechazar DOCUMENTOS
    const botonesRechazarDocumentos = document.querySelectorAll("#contenedor-documentos .rechazado");
    botonesRechazarDocumentos.forEach(boton => {
        boton.addEventListener("click", (e) => {
            // Buscar el botón de aprobar en la misma carta para obtener el data-id
            const tarjeta = e.target.closest('.carta');
            const botonAprobar = tarjeta?.querySelector('.aprobado');
            const idDocumento = botonAprobar ? botonAprobar.getAttribute('data-id') : null;
            
            // Asignar el ID al input hidden del modal de rechazo
            if (inputHiddenRechazarDoc && idDocumento) {
                inputHiddenRechazarDoc.value = idDocumento;
            }
            
            // Limpiar el textarea
            const textarea = modalRechazarDocumento?.querySelector('textarea[name="motivo_rechazo"]');
            if (textarea) {
                textarea.value = '';
            }
            
            // Mostrar el modal de rechazo de documentos
            mostrarModal(modalRechazarDocumento);
        });
    });

    // Event listeners para cerrar modal de rechazo de expedientes
    if (btnCancelarRechazarExp) {
        btnCancelarRechazarExp.addEventListener("click", () => {
            ocultarModal(modalRechazarExpediente);
        });
    }

    if (btnSalirRechazarExp) {
        btnSalirRechazarExp.addEventListener("click", () => {
            ocultarModal(modalRechazarExpediente);
        });
    }

    // Event listeners para cerrar modal de rechazo de documentos
    if (btnCancelarRechazarDoc) {
        btnCancelarRechazarDoc.addEventListener("click", () => {
            ocultarModal(modalRechazarDocumento);
        });
    }

    if (btnSalirRechazarDoc) {
        btnSalirRechazarDoc.addEventListener("click", () => {
            ocultarModal(modalRechazarDocumento);
        });
    }

    // =================== EVENT LISTENERS GLOBALES ===================

    // Cerrar modales al hacer clic fuera de ellos
    window.addEventListener("click", (e) => {
        if (e.target === modalExpediente) {
            ocultarModal(modalExpediente);
        }
        if (e.target === modalDocumento) {
            ocultarModal(modalDocumento);
        }
        if (e.target === modalRechazarExpediente) {
            ocultarModal(modalRechazarExpediente);
        }
        if (e.target === modalRechazarDocumento) {
            ocultarModal(modalRechazarDocumento);
        }
    });

    // Cerrar modales con la tecla ESC
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            ocultarModal(modalExpediente);
            ocultarModal(modalDocumento);
            ocultarModal(modalRechazarExpediente);
            ocultarModal(modalRechazarDocumento);
        }
    });

});