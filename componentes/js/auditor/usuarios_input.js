document.addEventListener('DOMContentLoaded', function() {
    const inputResponsable = document.getElementById('responsable');
    const inputResponsableId = document.getElementById('responsable_id');
    const dropdown = document.getElementById('usuario-dropdown');
    
    let documentadoresData = [];
    
    // Obtener datos de documentadores via AJAX
    cargarDocumentadores();
    
    // Función para cargar documentadores via AJAX
    function cargarDocumentadores() {
        fetch('../../backend/auditor/lista_documentadores.php?ajax=1')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    documentadoresData = data.documentadores;
                } else {
                    console.error('Error al cargar documentadores');
                    documentadoresData = [];
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                documentadoresData = [];
            });
    }
    
    // Función para mostrar todos los documentadores
    function mostrarTodosDocumentadores() {
        dropdown.innerHTML = '';
        
        if (documentadoresData.length === 0) {
            dropdown.innerHTML = '<div class="dropdown-item">No hay documentadores disponibles</div>';
            dropdown.style.display = 'block';
            return;
        }
        
        documentadoresData.forEach(doc => {
            const item = document.createElement('div');
            item.className = 'dropdown-item';
            item.textContent = doc.nombre;
            item.dataset.id = doc.id;
            
            item.addEventListener('click', function() {
                inputResponsable.value = doc.nombre;
                inputResponsableId.value = doc.id;
                dropdown.style.display = 'none';
            });
            
            dropdown.appendChild(item);
        });
        
        dropdown.style.display = 'block';
    }
    
    // Función para filtrar documentadores
    function filtrarDocumentadores(texto) {
        dropdown.innerHTML = '';
        
        const filtrados = documentadoresData.filter(doc => 
            doc.nombre.toLowerCase().includes(texto.toLowerCase())
        );
        
        if (filtrados.length === 0) {
            dropdown.innerHTML = '<div class="dropdown-item">No se encontraron resultados</div>';
            dropdown.style.display = 'block';
            return;
        }
        
        filtrados.forEach(doc => {
            const item = document.createElement('div');
            item.className = 'dropdown-item';
            item.textContent = doc.nombre;
            item.dataset.id = doc.id;
            
            item.addEventListener('click', function() {
                inputResponsable.value = doc.nombre;
                inputResponsableId.value = doc.id;
                dropdown.style.display = 'none';
            });
            
            dropdown.appendChild(item);
        });
        
        dropdown.style.display = 'block';
    }
    
    // Event listeners
    inputResponsable.addEventListener('focus', function() {
        if (this.value.trim() === '') {
            mostrarTodosDocumentadores();
        } else {
            filtrarDocumentadores(this.value);
        }
    });
    
    inputResponsable.addEventListener('input', function() {
        const valor = this.value.trim();
        if (valor === '') {
            inputResponsableId.value = '';
            mostrarTodosDocumentadores();
        } else {
            filtrarDocumentadores(valor);
        }
    });
    
    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!inputResponsable.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
    
    // Manejar teclas de navegación
    inputResponsable.addEventListener('keydown', function(e) {
        const items = dropdown.querySelectorAll('.dropdown-item');
        let selectedIndex = -1;
        
        // Encontrar item seleccionado actual
        items.forEach((item, index) => {
            if (item.classList.contains('selected')) {
                selectedIndex = index;
            }
        });
        
        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                if (selectedIndex < items.length - 1) {
                    if (selectedIndex >= 0) items[selectedIndex].classList.remove('selected');
                    items[selectedIndex + 1].classList.add('selected');
                }
                break;
                
            case 'ArrowUp':
                e.preventDefault();
                if (selectedIndex > 0) {
                    items[selectedIndex].classList.remove('selected');
                    items[selectedIndex - 1].classList.add('selected');
                }
                break;
                
            case 'Enter':
                e.preventDefault();
                if (selectedIndex >= 0) {
                    items[selectedIndex].click();
                }
                break;
                
            case 'Escape':
                dropdown.style.display = 'none';
                break;
        }
    });
});