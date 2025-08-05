// dashboard_documentador.js - Script para cargar y mostrar datos del dashboard

document.addEventListener('DOMContentLoaded', function() {
    cargarDatosDashboard();
});

async function cargarDatosDashboard() {
    try {
        // Mostrar indicador de carga
        mostrarCargando(true);

        // Realizar petición al backend
        const response = await fetch('../../backend/documentador/inicio_documentador.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }

        const data = await response.json();

        if (data.success) {
            actualizarInterfaz(data);
        } else {
            mostrarError(data.error || 'Error desconocido al cargar los datos');
        }

    } catch (error) {
        console.error('Error al cargar dashboard:', error);
        mostrarError('Error de conexión. Por favor, intenta nuevamente.');
    } finally {
        mostrarCargando(false);
    }
}

function actualizarInterfaz(data) {
    // Actualizar información del usuario
    actualizarInfoUsuario(data.usuario);
    
    // Actualizar estadísticas
    actualizarEstadisticas(data.estadisticas);
    
    // Actualizar actividad reciente
    actualizarActividadReciente(data.actividad_reciente);
}

function actualizarInfoUsuario(usuario) {
    const elementoUsuario = document.querySelector('.user-info div');
    if (elementoUsuario && usuario.nombre_completo) {
        elementoUsuario.textContent = `Bienvenido ${usuario.nombre_completo}`;
    }
}

function actualizarEstadisticas(estadisticas) {
    // Actualizar solicitudes pendientes
    actualizarTarjetaEstadistica(
        '.stat-card:nth-child(1)',
        estadisticas.solicitudes_pendientes.total,
        estadisticas.solicitudes_pendientes.cambio_semanal,
        'esta semana'
    );

    // Actualizar documentos subidos
    actualizarTarjetaEstadistica(
        '.stat-card:nth-child(2)',
        estadisticas.documentos_subidos.total,
        estadisticas.documentos_subidos.cambio_mensual,
        'este mes'
    );

    // Actualizar expedientes creados
    actualizarTarjetaEstadistica(
        '.stat-card:nth-child(3)',
        estadisticas.expedientes_creados.total,
        estadisticas.expedientes_creados.cambio_mensual,
        'este mes'
    );

    // Actualizar items aprobados
    actualizarTarjetaEstadistica(
        '.stat-card:nth-child(4)',
        estadisticas.items_aprobados.total,
        estadisticas.items_aprobados.cambio_mensual,
        'este mes'
    );

    // Actualizar badge de solicitudes en la tarjeta de acción "Ver Solicitudes"
    actualizarBadgeSolicitudes(estadisticas.ver_solicitudes.totalSolicitudes);
}

// Nueva función para actualizar el badge de solicitudes
function actualizarBadgeSolicitudes(totalSolicitudes) {
    const tarjetaSolicitudes = document.querySelector('a[href="solicitudes_doc.php"] .action-badge');
    if (tarjetaSolicitudes) {
        tarjetaSolicitudes.textContent = totalSolicitudes || '0';
        
        // Opcional: ocultar el badge si no hay solicitudes
        if (totalSolicitudes === 0) {
            tarjetaSolicitudes.style.display = 'none';
        } else {
            tarjetaSolicitudes.style.display = 'inline-block';
        }
    }
}
function actualizarTarjetaEstadistica(selector, total, cambio, periodo) {
    const tarjeta = document.querySelector(selector);
    if (!tarjeta) return;

    // Actualizar número principal
    const numeroElemento = tarjeta.querySelector('.stat-number');
    if (numeroElemento) {
        numeroElemento.textContent = total;
    }

    // Actualizar cambio
    const cambioElemento = tarjeta.querySelector('.stat-change');
    if (cambioElemento) {
        const signo = cambio >= 0 ? '+' : '';
        cambioElemento.textContent = `${signo}${cambio} ${periodo}`;
        
        // Actualizar clase según el cambio
        cambioElemento.className = 'stat-change ' + (cambio >= 0 ? 'positive' : 'negative');
    }
}

function actualizarActividadReciente(actividades) {
    const contenedorActividad = document.querySelector('.recent-activity');
    if (!contenedorActividad) return;

    // Limpiar actividades existentes (excepto el título)
    const actividadesExistentes = contenedorActividad.querySelectorAll('.activity-item');
    actividadesExistentes.forEach(item => item.remove());

    // Si no hay actividades, mostrar mensaje
    if (!actividades || actividades.length === 0) {
        const mensajeVacio = document.createElement('div');
        mensajeVacio.className = 'activity-item';
        mensajeVacio.innerHTML = `
            <div class="activity-content">
                <div class="activity-text">No hay actividad reciente</div>
                <div class="activity-time">-</div>
            </div>
        `;
        contenedorActividad.appendChild(mensajeVacio);
        return;
    }

    // Agregar cada actividad
    actividades.forEach(actividad => {
        const elementoActividad = crearElementoActividad(actividad);
        contenedorActividad.appendChild(elementoActividad);
    });
}

function crearElementoActividad(actividad) {
    const div = document.createElement('div');
    div.className = 'activity-item';

    const iconoClase = obtenerClaseIcono(actividad.accion, actividad.entidad);
    const textoActividad = generarTextoActividad(actividad);

    div.innerHTML = `
        <div class="activity-icon ${iconoClase}"></div>
        <div class="activity-content">
            <div class="activity-text">${textoActividad}</div>
            <div class="activity-time">${actividad.tiempo}</div>
        </div>
    `;

    return div;
}

function obtenerClaseIcono(accion, entidad) {
    const mapeoIconos = {
        'subió_documento': 'uploaded icon-uploaded',
        'subió_expediente': 'created icon-created',
        'editó_documento': 'uploaded icon-uploaded',
        'editó_expediente': 'created icon-created',
        'creó_documento': 'uploaded icon-uploaded',
        'creó_expediente': 'created icon-created',
        'eliminó_documento': 'deleted icon-deleted',
        'eliminó_expediente': 'deleted icon-deleted',
        'subió': entidad === 'documento' ? 'uploaded icon-uploaded' : 'created icon-created'
    };

    const clave = `${accion}_${entidad}`;
    return mapeoIconos[clave] || mapeoIconos[accion] || 'uploaded icon-uploaded';
}

function generarTextoActividad(actividad) {
    const nombreEntidad = actividad.nombre_entidad || 'Elemento';
    const accion = actividad.accion || 'modificó';
    const entidad = actividad.entidad || 'elemento';

    // Mapeo directo de acciones comunes
    const mensajes = {
        'subió_documento': `Subiste el documento "${nombreEntidad}"`,
        'subió_expediente': `Subiste el expediente "${nombreEntidad}"`,
        'editó_documento': `Editaste el documento "${nombreEntidad}"`,
        'editó_expediente': `Editaste el expediente "${nombreEntidad}"`,
        'creó_documento': `Creaste el documento "${nombreEntidad}"`,
        'creó_expediente': `Creaste el expediente "${nombreEntidad}"`,
        'eliminó_documento': `Eliminaste el documento "${nombreEntidad}"`,
        'eliminó_expediente': `Eliminaste el expediente "${nombreEntidad}"`,
        'aprobó_documento': `Aprobaste el documento "${nombreEntidad}"`,
        'aprobó_expediente': `Aprobaste el expediente "${nombreEntidad}"`,
        'rechazó_documento': `Rechazaste el documento "${nombreEntidad}"`,
        'rechazó_expediente': `Rechazaste el expediente "${nombreEntidad}"`,
        'actualizó_documento': `Actualizaste el documento "${nombreEntidad}"`,
        'actualizó_expediente': `Actualizaste el expediente "${nombreEntidad}"`,
    };

    // Intentar con acción + entidad
    const claveCompuesta = `${accion}_${entidad}`;
    if (mensajes[claveCompuesta]) {
        return mensajes[claveCompuesta];
    }

    // Fallback para casos generales
    if (entidad === 'documento') {
        return `Modificaste el documento "${nombreEntidad}"`;
    } else if (entidad === 'expediente') {
        return `Modificaste el expediente "${nombreEntidad}"`;
    } else {
        return `Modificaste el elemento "${nombreEntidad}"`;
    }
}

function mostrarCargando(mostrar) {
    // Puedes personalizar esto según tu diseño
    const estadisticas = document.querySelectorAll('.stat-number');
    estadisticas.forEach(stat => {
        if (mostrar) {
            stat.textContent = '...';
        }
    });
}

function mostrarError(mensaje) {
    console.error('Error:', mensaje);
    
    // Mostrar notificación de error (puedes personalizar esto)
    const notificacion = document.createElement('div');
    notificacion.className = 'alert alert-error';
    notificacion.textContent = mensaje;
    notificacion.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ff4444;
        color: white;
        padding: 15px;
        border-radius: 5px;
        z-index: 9999;
        max-width: 300px;
    `;

    document.body.appendChild(notificacion);

    // Remover después de 5 segundos
    setTimeout(() => {
        if (notificacion.parentNode) {
            notificacion.parentNode.removeChild(notificacion);
        }
    }, 5000);
}

// Función para refrescar los datos (opcional)
function refrescarDashboard() {
    cargarDatosDashboard();
}

// Auto-refresh cada 5 minutos (opcional)
setInterval(cargarDatosDashboard, 300000); // 300000ms = 5 minutos