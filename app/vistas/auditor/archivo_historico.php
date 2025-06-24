<?php 
require_once '../../helpers/verificacion_roles.php';
require_once '../../backend/auditor/lista_doc_archivados.php';

AutorizacionRol('auditor');

// DEBUG: Verifica si la variable existe
if (isset($documentos_archivados)) {
    echo "<!-- DEBUG: Documentos encontrados: " . count($documentos_archivados) . " -->";
} else {
    echo "<!-- DEBUG: Variable documentos_archivados no existe -->";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor | Metadocs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <link rel="stylesheet" href="../../../componentes/css/auditor/archivo_historico.css">
</head>
<body>
   
   <header id="cabezote">
        <i class="bi bi-list" id="menu_opciones"></i>
    </header>

    <main id="cuerpo">
        <nav id="menu-lateral" class="menu-lateral">
            <figure id="img_menu">
                  <img src="../../../componentes/img/image.png" alt="imagen del menu lateral">
            </figure>
            <ul>
                <li>
                    <a href="auditor_inicio.php" >
                        <i class="bi bi-house-door"></i>
                        Inicio
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios" class="activo">
                        <i class="bi bi-file-earmark-text" ></i>
                        Gestión Documentos
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li><a href="recibir_documentos.php"><i class="bi bi-envelope-paper"></i>Solicitudes</a></li>
                        <li><a href="archivos_auditor.php"><i class="bi bi-eye"></i> Ver documentos</a></li>
                        <li><a href="solicitar_documento.php"><i class="bi bi-file-earmark-plus"></i> Solicitar documentos</a></li>
                         <li><a href=""  class="submenu-activo"> <i class="bi bi-clock-history"></i> Archivo historico</a></li>
                    </ul>
                </li>
               
                <li>
                    <a href="../../vistas/auditor/pista_auditoria.php">
                        <i class="bi bi-list-check"></i>
                        Pista auditoria
                    </a>
                </li>
                
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios" >
                        <i class="bi bi-person"></i>
                        Usuario
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                        <li><a href="#" id="cerrar_sesion"><i class="bi bi-box-arrow-left"></i>Cerrar sesion</a></li>
                        <li><a href="../log/informacion_usuario.php"><i class="bi bi-info-circle"></i> Info usuario</a></li>
                        <li><a href=""><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>

                <li class="solo_mobil">
                    <a href="#" id="solo_mobil">
                        <i class="bi bi-arrow-left-circle"></i>
                        Volver
                    </a>
                </li>
            </ul>
        </nav>
       
       <section id="admin-contenido" class="admin">
    <div class="contenedor_archivo">

        <h1>Archivo historico</h1>

        <!-- Filtros -->
        <div class="filtros_archivo">
            <div class="grupo-filtro">
                <label class="etiqueta-filtro" for="entradaBusqueda">Buscar por nombre</label>
                <input 
                    type="text" 
                    id="entradaBusqueda" 
                    class="entrada-filtro" 
                    placeholder="Escriba para buscar..."
                    onkeyup="filtrarTabla()"
                >
            </div>
            <div class="grupo-filtro">
                <label class="etiqueta-filtro" for="filtroCategoria">Filtrar por categoría</label>
                <select id="filtroCategoria" class="seleccion-filtro" onchange="filtrarTabla()">
                    <option value="">Todas las categorías</option>
                    <option value="Estrategicos">Estrategicos</option>
                    <option value="Operativos">Operativos</option>
                    <option value="Soporte">Soporte</option>
                    <option value="Legales">Legales</option>
                    <option value="Financieros">Financieros</option>
                    <option value="Correspondencia">Correspondencia</option>
                </select>
            </div>
        </div>

        <!-- Tabla -->
        <div class="envoltorio-tabla">
            <table class="tablaArchivo" id="tablaArchivo">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Tipo</th>
                        <th>Fecha Archivado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="cuerpoTabla">
                    <?php if (isset($documentos_archivados) && !empty($documentos_archivados)): ?>
                        <?php foreach ($documentos_archivados as $documento): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($documento['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($documento['categoria']); ?></td>
                                <td><?php echo htmlspecialchars($documento['tipo']); ?></td>
                                <td>
                                    <?php 
                                    // Formatear la fecha
                                    if ($documento['fin_retencion']) {
                                        $fecha = new DateTime($documento['fin_retencion']);
                                        echo $fecha->format('d/m/Y');
                                    } else {
                                        echo 'No disponible';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn-accion" onclick="verDocumento('<?php echo htmlspecialchars($documento['titulo']); ?>')">
                                        <i class="bi bi-eye"></i> Ver
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="filaVacia">
                            <td colspan="5" style="text-align: center; padding: 20px;">
                                No hay documentos archivados disponibles.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="sin-resultados" id="sinResultados" style="display: none;">
                No se encontraron documentos que coincidan con los filtros seleccionados.
            </div>
        </div>
    </div>
</section>

    </main>
    
    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>

    <!-- Scripts -->
    <script src="../../../componentes/js/admin/panel.js"></script>
    <script>
        // Función para filtrar la tabla
        function filtrarTabla() {
            const busqueda = document.getElementById('entradaBusqueda').value.toLowerCase().trim();
            const categoriaFiltro = document.getElementById('filtroCategoria').value.toLowerCase();
            const tbody = document.getElementById('cuerpoTabla');
            const filas = tbody.getElementsByTagName('tr');
            let filasVisibles = 0;
            let hayDocumentos = false;

            // Verificar si hay documentos reales (no solo la fila vacía)
            for (let i = 0; i < filas.length; i++) {
                const fila = filas[i];
                if (fila.id !== 'filaVacia' && fila.id !== 'filaSinResultados') {
                    hayDocumentos = true;
                    break;
                }
            }

            // Si no hay documentos, no hacer filtrado
            if (!hayDocumentos) {
                return;
            }

            // Remover fila de "sin resultados" si existe
            const filaSinResultados = document.getElementById('filaSinResultados');
            if (filaSinResultados) {
                filaSinResultados.remove();
            }

            // Ocultar fila vacía original si existe
            const filaVacia = document.getElementById('filaVacia');
            if (filaVacia) {
                filaVacia.style.display = 'none';
            }

            // Filtrar filas
            for (let i = 0; i < filas.length; i++) {
                const fila = filas[i];
                
                // Saltar filas especiales
                if (fila.id === 'filaSinResultados' || fila.id === 'filaVacia') {
                    continue;
                }
                
                const celdas = fila.getElementsByTagName('td');
                if (celdas.length >= 2) {
                    const nombre = celdas[0].textContent.toLowerCase().trim();
                    const categoria = celdas[1].textContent.toLowerCase().trim();
                    
                    const coincideNombre = busqueda === '' || nombre.includes(busqueda);
                    const coincideCategoria = categoriaFiltro === '' || categoria === categoriaFiltro;
                    
                    if (coincideNombre && coincideCategoria) {
                        fila.style.display = '';
                        filasVisibles++;
                    } else {
                        fila.style.display = 'none';
                    }
                }
            }

            // Si no hay filas visibles después del filtrado, mostrar mensaje
            if (filasVisibles === 0 && hayDocumentos) {
                const nuevaFila = document.createElement('tr');
                nuevaFila.id = 'filaSinResultados';
                nuevaFila.innerHTML = `
                    <td colspan="5" style="text-align: center; padding: 20px; color: #6c757d; font-style: italic;">
                        No se encontraron documentos que coincidan con los filtros seleccionados.
                    </td>
                `;
                tbody.appendChild(nuevaFila);
            }
        }

        // Función para ver documento
        function verDocumento(titulo) {
            // Aquí puedes implementar la lógica para ver el documento
            // Por ejemplo, abrir un modal o redirigir a otra página
            alert('Funcionalidad para ver documento: ' + titulo + '\n\nImplementar según los requerimientos del sistema.');
            
            // Ejemplo de implementación:
            // window.open('ver_documento.php?titulo=' + encodeURIComponent(titulo), '_blank');
            // o mostrar un modal con los detalles del documento
        }

        // Función para limpiar filtros
        function limpiarFiltros() {
            document.getElementById('entradaBusqueda').value = '';
            document.getElementById('filtroCategoria').value = '';
            filtrarTabla();
        }

        // Inicialización cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Cualquier inicialización adicional aquí
            console.log('Página de archivo histórico cargada correctamente');
        });
    </script>
</body>
</html>