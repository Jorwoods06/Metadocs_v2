const newPasswordInput = document.getElementById('newPassword');
const confirmPasswordInput = document.getElementById('confirmPassword');
const confirmError = document.getElementById('confirmError');
const confirmSuccess = document.getElementById('confirmSuccess');
const submitBtn = document.getElementById('submitBtn');
const passwordForm = document.getElementById('passwordForm');

// Elementos de requisitos de contraseña
const requirements = {
    length: document.querySelector('[data-requirement="length"]'),
    uppercase: document.querySelector('[data-requirement="uppercase"]'),
    lowercase: document.querySelector('[data-requirement="lowercase"]'),
    number: document.querySelector('[data-requirement="number"]')
};

// Función para validar requisitos de contraseña
function validatePasswordRequirements(password) {
    const checks = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password)
    };

    // Actualizar UI de requisitos
    Object.keys(checks).forEach(requirement => {
        const element = requirements[requirement];
        if (element) {
            const icon = element.querySelector('.icon');
            
            if (checks[requirement]) {
                element.classList.add('valid');
                if (icon) icon.className = 'bi bi-check-circle-fill icon';
            } else {
                element.classList.remove('valid');
                if (icon) icon.className = 'bi bi-circle icon';
            }
        }
    });

    return Object.values(checks).every(check => check);
}

// Función para validar coincidencia de contraseñas
function validatePasswordMatch() {
    const newPassword = newPasswordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    
    if (confirmPassword === '') {
        // Campo vacío - sin validación
        confirmPasswordInput.classList.remove('error', 'success');
        confirmError.classList.remove('show');
        confirmSuccess.classList.remove('show');
        return false;
    }
    
    if (newPassword === confirmPassword) {
        // Contraseñas coinciden
        confirmPasswordInput.classList.remove('error');
        confirmPasswordInput.classList.add('success');
        confirmError.classList.remove('show');
        confirmSuccess.classList.add('show');
        return true;
    } else {
        // Contraseñas no coinciden
        confirmPasswordInput.classList.add('error');
        confirmPasswordInput.classList.remove('success');
        confirmError.classList.add('show');
        confirmSuccess.classList.remove('show');
        
        return false;
    }
}

// Función para actualizar el estado del botón de envío
function updateSubmitButton() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = newPasswordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    
    const allFieldsFilled = currentPassword && newPassword && confirmPassword;
    const passwordRequirementsMet = validatePasswordRequirements(newPassword);
    const passwordsMatch = validatePasswordMatch();
    
    if (allFieldsFilled && passwordRequirementsMet && passwordsMatch) {
        submitBtn.disabled = false;
    } else {
        submitBtn.disabled = true;
    }
}

// Función para crear y mostrar modal - MEJORADA
function showModal(type, title, message) {
    // Crear modal si no existe
    let modal = document.getElementById('passwordModal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'passwordModal';
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-close">&times;</span>
                </div>
                <div class="modal-body">
                    <div id="modalIcon"></div>
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn" id="modalAcceptBtn">Aceptar</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Configurar contenido del modal
    const modalMessage = document.getElementById('modalMessage');
    const modalIcon = document.getElementById('modalIcon');
    const modalAcceptBtn = document.getElementById('modalAcceptBtn');
    const modalHeader = modal.querySelector('.modal-header');
    const modalFooter = modal.querySelector('.modal-footer');

    modalMessage.textContent = message;

    // Determinar si es un error de contraseña igual a la actual
    const isPasswordSameError = message.toLowerCase().includes('no puede ser igual') ||
                               message.toLowerCase().includes('misma que la actual') ||
                               message.toLowerCase().includes('debe ser diferente');

    // Configurar icono y estilos según el tipo
    if (type === 'success') {
        modal.className = 'modal success-modal';
        modalIcon.innerHTML = '<i class="bi bi-check-circle-fill success-icon"></i>';
        // Ocultar header y footer para modal de éxito
        modalHeader.style.display = 'none';
        modalFooter.style.display = 'none';
    } else if (type === 'error' && isPasswordSameError) {
        // Modal de error simple - solo mensaje y X
        modal.className = 'modal simple-error-modal';
        modalIcon.innerHTML = '<i class="bi bi-x-circle-fill error-icon"></i>';
        modalHeader.style.display = 'block';
        modalFooter.style.display = 'none'; // Sin botón Aceptar
    } else {
        // Modal de error normal con botón Aceptar
        modal.className = 'modal error-modal';
        modalIcon.innerHTML = '<i class="bi bi-x-circle-fill error-icon"></i>';
        modalHeader.style.display = 'flex';
        modalFooter.style.display = 'block';
    }

    // Mostrar modal
    modal.style.display = 'flex'; // Cambiado a flex para centrado

    // Event listeners para cerrar modal
    const closeModal = () => {
        modal.style.display = 'none';
        if (type === 'success') {
            // Limpiar formulario después de éxito
            passwordForm.reset();
            updateSubmitButton();
            // Reiniciar validaciones visuales
            confirmPasswordInput.classList.remove('error', 'success');
            confirmError.classList.remove('show');
            confirmSuccess.classList.remove('show');
            validatePasswordRequirements('');
        }
    };

    // Solo agregar event listeners si los elementos existen
    if (modalAcceptBtn) {
        modalAcceptBtn.onclick = closeModal;
    }
    
    const closeButton = modal.querySelector('.modal-close');
    if (closeButton) {
        closeButton.onclick = closeModal;
    }
    
    // Cerrar modal al hacer clic fuera de él
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Para modal de éxito, cerrar automáticamente después de 2 segundos
    if (type === 'success') {
        setTimeout(closeModal, 2000);
    }
}

// Event listeners para validación en tiempo real
newPasswordInput.addEventListener('input', () => {
    validatePasswordRequirements(newPasswordInput.value);
    if (confirmPasswordInput.value) {
        validatePasswordMatch();
    }
    updateSubmitButton();
});

confirmPasswordInput.addEventListener('input', () => {
    validatePasswordMatch();
    updateSubmitButton();
});

confirmPasswordInput.addEventListener('keyup', validatePasswordMatch);

document.getElementById('currentPassword').addEventListener('input', updateSubmitButton);

// Funcionalidad para mostrar/ocultar contraseñas
document.querySelectorAll('.password-toggle').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const targetInput = document.getElementById(targetId);
        
        if (targetInput.type === 'password') {
            targetInput.type = 'text';
            this.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            targetInput.type = 'password';
            this.innerHTML = '<i class="bi bi-eye"></i>';
        }
    });
});

// Función para mostrar error en contraseña actual
function showCurrentPasswordError(message) {
    const currentPasswordInput = document.getElementById('currentPassword');
    const inputGroup = currentPasswordInput.closest('.form-group');
    let errorElement = document.getElementById('currentPasswordError');
    
    // Crear elemento de error si no existe
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.id = 'currentPasswordError';
        errorElement.className = 'error-message';
        errorElement.innerHTML = '<i class="bi bi-x-circle"></i> <span></span>';
        inputGroup.appendChild(errorElement);
    }
    
    // Mostrar error
    currentPasswordInput.classList.add('error');
    errorElement.querySelector('span').textContent = message;
    errorElement.classList.add('show');
    
    // Limpiar error cuando el usuario empiece a escribir
    const clearError = () => {
        currentPasswordInput.classList.remove('error');
        errorElement.classList.remove('show');
        currentPasswordInput.removeEventListener('input', clearError);
    };
    
    currentPasswordInput.addEventListener('input', clearError);
}

// Manejar envío del formulario
passwordForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Limpiar errores anteriores
    const currentPasswordInput = document.getElementById('currentPassword');
    const currentPasswordError = document.getElementById('currentPasswordError');
    currentPasswordInput.classList.remove('error');
    if (currentPasswordError) {
        currentPasswordError.classList.remove('show');
    }
    
    // Deshabilitar botón durante el envío
    submitBtn.disabled = true;
    submitBtn.textContent = 'Cambiando...';
    
    try {
        // Crear FormData con los datos del formulario
        const formData = new FormData(passwordForm);
        
        // Enviar petición al servidor
        const response = await fetch(passwordForm.action, {
            method: 'POST',
            body: formData
        });
        
        // Verificar si la respuesta es válida
        if (!response.ok) {
            throw new Error('Error en la comunicación con el servidor');
        }
        
        // Obtener respuesta JSON
        const result = await response.json();
        
        // Manejar respuesta según el estado
        if (result.status === 'success') {
            showModal('success', 'Éxito', result.message);
        } else {
            // Verificar si es error de contraseña actual incorrecta
            if (result.message.toLowerCase().includes('contraseña actual') || 
                result.message.toLowerCase().includes('incorrecta')) {
                showCurrentPasswordError(result.message);
            } else {
                // Todos los demás errores se muestran en modal
                // La función showModal determinará automáticamente si usar modal simple o normal
                showModal('error', 'Error', result.message);
            }
        }
        
    } catch (error) {
        console.error('Error:', error);
        showModal('error', 'Error', 'Ocurrió un error inesperado. Por favor, inténtalo de nuevo.');
    } finally {
        // Rehabilitar botón
        submitBtn.disabled = false;
        submitBtn.textContent = 'Cambiar Contraseña';
        updateSubmitButton(); // Volver a validar estado del botón
    }
});