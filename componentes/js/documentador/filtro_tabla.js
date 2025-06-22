// Función principal para filtrar la tabla de documentos y expedientes (CORREGIDA)
function inicializarFiltroBusqueda() {
    const inputBuscar = document.querySelector('.input-buscar');
    const tablaDocumentos = document.querySelector('.tabla-documentos tbody');
    
    if (!inputBuscar || !tablaDocumentos) {
        console.warn('No se encontraron los elementos necesarios para el filtro de búsqueda');
        return;
    }

    // Función para filtrar las filas (expedientes y documentos)
    function filtrarTabla() {
        const textoBusqueda = inputBuscar.value.toLowerCase().trim();
        
        // Obtener todas las filas cada vez para manejar contenido dinámico
        const todasLasFilas = document.querySelectorAll('.tabla-documentos tbody tr.documentos');
        let filasVisibles = 0;
        
        console.log('Buscando:', textoBusqueda);
        console.log('Filas encontradas:', todasLasFilas.length);
        
        todasLasFilas.forEach((fila, index) => {
            // CORRECCIÓN: Buscar las celdas por posición también, no solo por clase
            const nombre = fila.querySelector('.documento-nombre') || fila.children[0];
            const tipo = fila.querySelector('.documento-tipo') || fila.children[1];
            const fecha = fila.querySelector('.documento-fecha') || fila.children[2];
            
            if (!nombre || !tipo || !fecha) {
                console.log('Fila sin elementos necesarios:', index);
                return;
            }
            
            // CORRECCIÓN: Función mejorada para obtener texto
            function obtenerTextoLimpio(elemento) {
                if (!elemento) return '';
                
                // Si tiene enlaces, obtener el texto del enlace
                const enlace = elemento.querySelector('a');
                if (enlace) {
                    return enlace.textContent.toLowerCase().trim();
                }
                
                // Si no, obtener el texto completo pero limpiar íconos
                let texto = elemento.textContent || elemento.innerText || '';
                
                // Remover caracteres de íconos de Bootstrap (si los hay)
                texto = texto.replace(/[\uE000-\uF8FF]|\uD83C[\uDF00-\uDFFF]|\uD83D[\uDC00-\uDDFF]/g, '');
                
                return texto.toLowerCase().trim();
            }
            
            const textoNombre = obtenerTextoLimpio(nombre);
            const textoTipo = obtenerTextoLimpio(tipo);
            const textoFecha = obtenerTextoLimpio(fecha);
            
            console.log(`Fila ${index}:`, { textoNombre, textoTipo, textoFecha });
            
            // Si no hay texto de búsqueda, mostrar todo
            if (textoBusqueda === '') {
                fila.style.display = '';
                filasVisibles++;
                return;
            }
            
            // Verificar si alguna columna contiene el texto de búsqueda
            const coincide = textoNombre.includes(textoBusqueda) || 
                           textoTipo.includes(textoBusqueda) || 
                           textoFecha.includes(textoBusqueda);
            
            if (coincide) {
                fila.style.display = '';
                filasVisibles++;
                console.log(`Coincidencia encontrada en fila ${index}`);
            } else {
                fila.style.display = 'none';
            }
        });
        
        console.log('Filas visibles:', filasVisibles);
        
        // Manejar mensaje de "sin resultados"
        manejarMensajeSinResultados(filasVisibles, textoBusqueda);
    }
    
    // Función para manejar el mensaje cuando no hay resultados
    function manejarMensajeSinResultados(filasVisibles, textoBusqueda) {
        let mensajeSinResultados = document.querySelector('.mensaje-sin-resultados');
        const filaNoContent = document.querySelector('tbody tr td.no-content');
        
        // Si hay una fila de "no content" original, ocultarla durante la búsqueda
        if (filaNoContent && textoBusqueda.length > 0) {
            filaNoContent.parentElement.style.display = 'none';
        } else if (filaNoContent && textoBusqueda.length === 0) {
            filaNoContent.parentElement.style.display = '';
        }
        
        if (filasVisibles === 0 && textoBusqueda.length > 0) {
            // Crear mensaje si no existe
            if (!mensajeSinResultados) {
                mensajeSinResultados = document.createElement('tr');
                mensajeSinResultados.className = 'mensaje-sin-resultados';
                mensajeSinResultados.innerHTML = `
                    <td colspan="4" style="text-align: center; padding: 20px; color: #666; font-style: italic;">
                        No se encontraron resultados para "${textoBusqueda}"
                    </td>
                `;
                tablaDocumentos.appendChild(mensajeSinResultados);
            } else {
                mensajeSinResultados.style.display = '';
                mensajeSinResultados.querySelector('td').innerHTML = 
                    `No se encontraron resultados para "${textoBusqueda}"`;
            }
        } else if (mensajeSinResultados) {
            mensajeSinResultados.style.display = 'none';
        }
    }
    
    // Función para limpiar el filtro
    function limpiarFiltro() {
        inputBuscar.value = '';
        const todasLasFilas = document.querySelectorAll('.tabla-documentos tbody tr.documentos');
        todasLasFilas.forEach(fila => {
            fila.style.display = '';
        });
        
        const mensajeSinResultados = document.querySelector('.mensaje-sin-resultados');
        if (mensajeSinResultados) {
            mensajeSinResultados.style.display = 'none';
        }
        
        // Restaurar mensaje original de "no content" si existe
        const filaNoContent = document.querySelector('tbody tr td.no-content');
        if (filaNoContent) {
            filaNoContent.parentElement.style.display = '';
        }
    }
    
    // CORRECCIÓN: Event listeners con debounce para mejor performance
    let timeoutId;
    
    function filtrarConDebounce() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(filtrarTabla, 150); // Esperar 150ms después del último input
    }
    
    inputBuscar.addEventListener('input', filtrarConDebounce);
    inputBuscar.addEventListener('keyup', filtrarConDebounce);
    
    // Trigger inicial para verificar que funciona
    console.log('Filtro inicializado correctamente');
}

// CORRECCIÓN: Función de inicialización mejorada con múltiples intentos
function inicializarConReintentos() {
    let intentos = 0;
    const maxIntentos = 5;
    
    function intentarInicializar() {
        const inputBuscar = document.querySelector('.input-buscar');
        const tablaDocumentos = document.querySelector('.tabla-documentos tbody');
        
        if (inputBuscar && tablaDocumentos) {
            console.log('Elementos encontrados, inicializando filtro...');
            inicializarFiltroBusqueda();
            inicializarBusquedaAvanzada();
            filtrarPorTipoElemento();
            return;
        }
        
        intentos++;
        if (intentos < maxIntentos) {
            console.log(`Intento ${intentos}: Elementos no encontrados, reintentando en 500ms...`);
            setTimeout(intentarInicializar, 500);
        } else {
            console.warn('No se pudieron encontrar los elementos después de varios intentos');
        }
    }
    
    intentarInicializar();
}

// CORRECCIÓN: Múltiples formas de inicialización
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inicializarConReintentos);
} else {
    // Si ya está cargado, intentar inmediatamente y también con timeout
    inicializarConReintentos();
    setTimeout(inicializarConReintentos, 100);
}

// CORRECCIÓN: También inicializar cuando la ventana esté completamente cargada
window.addEventListener('load', function() {
    setTimeout(inicializarConReintentos, 100);
});

// Función de debug para verificar elementos
function debugElementos() {
    console.log('=== DEBUG ELEMENTOS ===');
    console.log('Input buscar:', document.querySelector('.input-buscar'));
    console.log('Tabla documentos:', document.querySelector('.tabla-documentos tbody'));
    console.log('Filas documentos:', document.querySelectorAll('.tabla-documentos tbody tr.documentos'));
    console.log('Todas las filas:', document.querySelectorAll('.tabla-documentos tbody tr'));
    console.log('=======================');
}

// Ejecutar debug después de un momento
setTimeout(debugElementos, 1000);