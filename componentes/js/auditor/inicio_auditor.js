// dashboard.js - Script para cargar datos dinámicos del dashboard del auditor

class DashboardManager {
    constructor() {
        this.apiUrl = '../../../app/backend/auditor/inicio_auditor.php';
        this.init();
    }

    async init() {
        try {
            await this.cargarDatos();
            this.configurarRefrescoAutomatico();
        } catch (error) {
            console.error('Error al inicializar dashboard:', error);
            this.mostrarError('Error al cargar los datos del dashboard');
        }
    }

    async cargarDatos() {
        try {
            const response = await fetch(this.apiUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }

            this.actualizarInterfaz(data);
            
        } catch (error) {
            console.error('Error al cargar datos:', error);
            this.mostrarError('Error al conectar con el servidor');
        }
    }

    actualizarInterfaz(data) {
        // Actualizar información del usuario
        this.actualizarUsuario(data.usuario);
        
        // Actualizar estadísticas
        this.actualizarEstadisticas(data.estadisticas);
        
        // Actualizar actividad reciente
        this.actualizarActividadReciente(data.actividad_reciente);
        
        // Actualizar badges en acciones rápidas
        this.actualizarAccionesRapidas(data.estadisticas);
    }

    actualizarUsuario(usuario) {
        const userInfoElement = document.querySelector('.user-info div');
        if (userInfoElement) {
            userInfoElement.textContent = `Bienvenido ${usuario.nombre_completo}`;
        }
    }

    actualizarEstadisticas(stats) {
        // Actualizar cada tarjeta de estadística
        this.actualizarTarjetaEstadistica(0, stats.documentos_pendientes);
        this.actualizarTarjetaEstadistica(1, stats.total_documentos);
        this.actualizarTarjetaEstadistica(2, stats.expedientes_activos);
        this.actualizarTarjetaEstadistica(3, stats.acciones_realizadas);
    }

    actualizarTarjetaEstadistica(index, data) {
        const tarjetas = document.querySelectorAll('.stat-card');
        if (tarjetas[index]) {
            const numero = tarjetas[index].querySelector('.stat-number');
            const cambio = tarjetas[index].querySelector('.stat-change');
            
            if (numero) {
                numero.textContent = data.total;
            }
            
            if (cambio) {
                const signo = data.cambio > 0 ? '+' : '';
                cambio.textContent = `${signo}${data.cambio} ${data.periodo}`;
                
                // Actualizar clase CSS según el cambio
                cambio.className = 'stat-change';
                if (data.cambio > 0) {
                    cambio.classList.add('positive');
                } else if (data.cambio < 0) {
                    cambio.classList.add('negative');
                }
            }
        }
    }

    actualizarActividadReciente(actividades) {
        const contenedor = document.querySelector('.recent-activity');
        if (!contenedor) return;

        // Buscar el contenedor de actividades (después del h2)
        const actividadesContainer = contenedor.querySelector('h2').nextElementSibling;
        if (!actividadesContainer) return;

        // Limpiar actividades actuales (excepto el título)
        const actividadesExistentes = contenedor.querySelectorAll('.activity-item');
        actividadesExistentes.forEach(item => item.remove());

        // Agregar nuevas actividades
        actividades.forEach(actividad => {
            const actividadElement = this.crearElementoActividad(actividad);
            contenedor.appendChild(actividadElement);
        });
    }

   crearElementoActividad(actividad) {
    const div = document.createElement('div');
    div.className = 'activity-item';

    const iconClass = this.obtenerClaseIcono(actividad.tipo_accion);
    const iconBootstrap = this.obtenerIconoBootstrap(actividad.tipo_accion);
    const textoActividad = this.generarTextoActividad(actividad);

    div.innerHTML = `
        <div class="activity-icon ${actividad.tipo_accion} ${iconClass}">
            <i class="bi ${iconBootstrap}"></i>
        </div>
        <div class="activity-content">
            <div class="activity-text">${textoActividad}</div>
            <div class="activity-time">${actividad.tiempo}</div>
        </div>
    `;

    return div;
}

  obtenerClaseIcono(tipoAccion) {
    const clases = {
        'approved': 'icon-approved',
        'rejected': 'icon-rejected',
        'requested': 'icon-request',
        'pending': 'icon-clock'
    };
    return clases[tipoAccion] || 'icon-clock';
}

obtenerIconoBootstrap(tipoAccion) {
    const iconos = {
        'approved': 'bi-check-circle-fill',
        'rejected': 'bi-x-circle-fill', 
        'requested': 'bi-file-earmark-plus',
        'pending': 'bi-clock'
    };
    return iconos[tipoAccion] || 'bi-clock';
}
    generarTextoActividad(actividad) {
    const entidadTipo = actividad.entidad === 'documento' ? 'Documento' : 'Expediente';
    
    // Casos especiales para mejorar la legibilidad
    if (actividad.accion === 'solicitaste' && actividad.entidad === 'documento') {
        return `Solicitaste documento`;
    }
    
    return `${entidadTipo} "${actividad.nombre_entidad}" ${actividad.accion}`;
}

    actualizarAccionesRapidas(stats) {
        // Actualizar el badge de documentos pendientes en las acciones rápidas
        const accionPendientes = document.querySelector('a[href="recibir_documentos.php"] .action-badge');
        if (accionPendientes) {
            accionPendientes.textContent = stats.documentos_pendientes.total;
        }

        // Actualizar el texto en la descripción de archivos pendientes
        const descripcionPendientes = document.querySelector('a[href="recibir_documentos.php"] .action-description');
        if (descripcionPendientes) {
            const pendientes = stats.documentos_pendientes.total;
            const texto = pendientes === 1 ? 
                'Revisar archivo que requiere aprobación o rechazo' :
                'Revisar archivos que requieren aprobación o rechazo';
            descripcionPendientes.textContent = texto;
        }
    }

    configurarRefrescoAutomatico() {
        // Refrescar datos cada 5 minutos
        setInterval(() => {
            this.cargarDatos();
        }, 300000); // 5 minutos en millisegundos
    }

    mostrarError(mensaje) {
        // Crear un toast o notification para mostrar errores
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-notification';
        errorDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        `;
        errorDiv.textContent = mensaje;

        document.body.appendChild(errorDiv);

        // Remover el error después de 5 segundos
        setTimeout(() => {
            if (errorDiv.parentNode) {
                errorDiv.parentNode.removeChild(errorDiv);
            }
        }, 5000);
    }

    // Método para refrescar manualmente los datos
    async refrescar() {
        await this.cargarDatos();
    }
}

// Inicializar el dashboard cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    window.dashboardManager = new DashboardManager();
});

// Opcional: Exponer función de refresco global
window.refrescarDashboard = function() {
    if (window.dashboardManager) {
        window.dashboardManager.refrescar();
    }
};