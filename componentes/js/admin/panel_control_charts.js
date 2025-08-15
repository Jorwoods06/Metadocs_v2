// panel_control_charts.js
// Archivo JavaScript separado para manejar las gráficas del panel de control

// Variables globales
let datosDocumentos = {};
let datosUsuarios = {};
let chartDocumentos;
let chart;
let tipoActualDocumentos = 'mes';
let tipoActual = 'roles';

// Paleta de colores complementarios basada en #3D688A
const colorPalette = {
    primary: '#3D688A',
    secondary: '#5B8DB3',
    accent1: '#8AAFCC',
    accent2: '#B3D1E6',
    complement1: '#121f29',
    complement2: '#A67C52',
    success: '#243E52',
    warning: '#3d8a86',
    danger: '#B35B5B',
    info: '#5B8AB3'
};

const coloresDocumentos = {
    mes: [colorPalette.primary],
    area: [colorPalette.primary, colorPalette.secondary, colorPalette.accent1, colorPalette.accent2, colorPalette.complement1, colorPalette.complement2, colorPalette.success, colorPalette.warning],
    estado: [colorPalette.primary, colorPalette.success, colorPalette.warning, colorPalette.danger],
    tipo: [colorPalette.primary, colorPalette.secondary, colorPalette.complement1, colorPalette.complement2, colorPalette.accent1, colorPalette.accent2]
};

const colores = {
    roles: ['#2A4860', '#3D688A', '#5B8DB3'],
    areas: ['#2A4860', '#3D688A', '#5B8DB3', '#B3D1E6'],
    estado: ['#3D688A', '#ef4444']
};

// Función para inicializar datos de documentos desde PHP
function initializeDatosDocumentos(datos) {
    datosDocumentos = datos;
    crearGraficoDocumentos('mes');
}

// Función para inicializar datos de usuarios desde PHP
function initializeDatosUsuarios(datos) {
    datosUsuarios = datos;
    crearGrafico('roles');
}

// CORRECCIÓN PARA LOS GRÁFICOS DE DOCUMENTOS
function crearGraficoDocumentos(categoria) {
    const ctx = document.getElementById('documentosChart').getContext('2d');
    
    if (chartDocumentos) {
        chartDocumentos.destroy();
    }

    const datos = datosDocumentos[categoria];
    const tipoGrafico = datos.tipo;
    const coloresFondo = coloresDocumentos[categoria];

    let configGrafico = {
        type: tipoGrafico,
        data: {
            labels: datos.labels,
            datasets: [{
                label: categoria === 'mes' ? 'Documentos Subidos' : 'Cantidad de Documentos',
                data: datos.data,
                backgroundColor: tipoGrafico === 'line' ? coloresFondo[0] + '20' : coloresFondo,
                borderColor: tipoGrafico === 'line' ? coloresFondo[0] : '#ffffff',
                borderWidth: tipoGrafico === 'line' ? 3 : (tipoGrafico === 'bar' ? 0 : 3),
                borderRadius: tipoGrafico === 'bar' ? 4 : 0,
                fill: tipoGrafico === 'line' ? true : false,
                tension: tipoGrafico === 'line' ? 0.4 : 0,
                pointBackgroundColor: tipoGrafico === 'line' ? coloresFondo[0] : undefined,
                pointBorderColor: tipoGrafico === 'line' ? '#ffffff' : undefined,
                pointBorderWidth: tipoGrafico === 'line' ? 2 : undefined,
                pointRadius: tipoGrafico === 'line' ? 5 : undefined,
                hoverBorderWidth: (tipoGrafico === 'doughnut' || tipoGrafico === 'pie') ? 4 : undefined
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: tipoGrafico === 'doughnut' || tipoGrafico === 'pie',
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            // CORRECCIÓN AQUÍ - Usar la propiedad correcta según el tipo de gráfico
                            let valor;
                            
                            if (tipoGrafico === 'doughnut' || tipoGrafico === 'pie') {
                                // Para gráficos circulares, usar context.parsed
                                valor = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const porcentaje = ((valor / total) * 100).toFixed(1);
                                return `${context.label}: ${valor} (${porcentaje}%)`;
                            } else if (tipoGrafico === 'line') {
                                // Para gráficos de línea, usar context.parsed.y
                                valor = context.parsed.y;
                                return `${context.dataset.label}: ${valor}`;
                            } else {
                                // Para gráficos de barras, usar context.parsed.y
                                valor = context.parsed.y;
                                return `${context.dataset.label}: ${valor}`;
                            }
                        }
                    }
                }
            },
            scales: (tipoGrafico === 'doughnut' || tipoGrafico === 'pie') ? {} : {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e0e0e0'
                    },
                    ticks: {
                        color: '#6b7280'
                    }
                },
                x: {
                    grid: {
                        color: tipoGrafico === 'bar' ? 'transparent' : '#e0e0e0',
                        display: tipoGrafico !== 'bar'
                    },
                    ticks: {
                        color: '#6b7280'
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    };

    // Configuración especial para gráfico de líneas
    if (tipoGrafico === 'line') {
        configGrafico.options.cutout = undefined;
    }

    // Configuración especial para gráfico doughnut
    if (tipoGrafico === 'doughnut') {
        configGrafico.options.cutout = '60%';
    }

    chartDocumentos = new Chart(ctx, configGrafico);
}

// CORRECCIÓN PARA LOS GRÁFICOS DE USUARIOS
function crearGrafico(tipo) {
    const ctx = document.getElementById('mainChart').getContext('2d');
    
    if (chart) {
        chart.destroy();
    }

    let datos, etiquetas, coloresFondo;
    
    switch(tipo) {
        case 'roles':
            etiquetas = datosUsuarios.roles.labels;
            datos = datosUsuarios.roles.data;
            coloresFondo = colores.roles.slice(0, datos.length);
            break;
        case 'areas':
            etiquetas = datosUsuarios.areas.labels;
            datos = datosUsuarios.areas.data;
            coloresFondo = colores.areas.slice(0, datos.length);
            break;
        case 'estado':
            etiquetas = datosUsuarios.estado.labels;
            datos = datosUsuarios.estado.data;
            coloresFondo = colores.estado;
            break;
    }

    const esEstado = tipo === 'estado';

    chart = new Chart(ctx, {
        type: esEstado ? 'doughnut' : 'bar',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Cantidad de usuarios',
                data: datos,
                backgroundColor: coloresFondo,
                borderColor: coloresFondo.map(color => color + '80'),
                borderWidth: 2,
                borderRadius: esEstado ? 0 : 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: esEstado,
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            // CORRECCIÓN AQUÍ - Usar la propiedad correcta según el tipo de gráfico
                            let valor;
                            
                            if (esEstado) {
                                // Para gráfico doughnut (estado), usar context.parsed
                                valor = context.parsed;
                            } else {
                                // Para gráficos de barras (roles y areas), usar context.parsed.y
                                valor = context.parsed.y;
                            }
                            
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const porcentaje = ((valor / total) * 100).toFixed(1);
                            return `${context.label}: ${valor} (${porcentaje}%)`;
                        }
                    }
                }
            },
            scales: esEstado ? {} : {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#6b7280'
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: '#6b7280'
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

function cambiarGraficoDocumentos(categoria) {
    // Actualizar botones
    document.querySelectorAll('.chart-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Cambiar gráfico
    tipoActualDocumentos = categoria;
    crearGraficoDocumentos(categoria);
}

function cambiarGrafico(tipo) {
    // Actualizar botones
    document.querySelectorAll('.chart-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Cambiar gráfico
    tipoActual = tipo;
    crearGrafico(tipo);
}