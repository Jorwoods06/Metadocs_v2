<?php 

require_once '../../helpers/verificacion_roles.php';
require_once '../../backend/auditor/gestor_archivos_auditor.php';
AutorizacionRol('auditor');

$padre_id = isset($_GET['id_expediente']) ? $_GET['id_expediente'] : 0;
$expediente_seleccionado = $padre_id;
$carpetas = obtenerExpedientes($conexion_metadocs, $padre_id, $area);
$documentos = obtenerDocumentos($conexion_metadocs, $padre_id, $area);

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
    <link rel="stylesheet" href="../../../componentes/css/documentador/modal_expediente.css">
    <link rel="stylesheet" href="../../../componentes/css/auditor/archivos_auditor.css">
    <link rel="stylesheet" href="../../../componentes/css/documentador/visor.css">
    <link rel="stylesheet" href="../../../componentes/css/auditor/modal_editar_expediente.css">
    <script src="../../../componentes/js/auditor/editar_expediente.js"></script>
    <script src="../../../componentes/js/auditor/auditor_ver_docs.js"></script>
    <script src="../../../componentes/js/admin/panel.js"></script>
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
             <div class="menu-opciones-principales">
                <li>
                    <a href="auditor_inicio.php" >
                        <i class="bi bi-house-door"></i>
                        Inicio
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios" class="activo">
                        <i class="bi bi-file-earmark-text" ></i>
                        Gestión Archivos
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li><a href="recibir_documentos.php"><i class="bi bi-envelope-paper"></i>pendientes</a></li>
                        <li><a href="#"  class="submenu-activo"><i class="bi bi-eye"></i>Archivos</a></li>
                        <li><a href="solicitar_documento.php"><i class="bi bi-file-earmark-plus"></i> Solicitar archivos</a></li>
                        <li><a href="archivo_historico.php" > <i class="bi bi-clock-history"></i> Archivo historico</a></li>
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
                        Auditor
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                        
                        <li><a href="../log/informacion_usuario.php"><i class="bi bi-info-circle"></i> Info auditor</a></li>
                        <li><a href=""><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>

                <li class="solo_mobil">
                    <a href="#" id="solo_mobil">
                        <i class="bi bi-arrow-left-circle"></i>
                        Volver
                    </a>
                </li>
            </div>

            <li class="cerrar-sesion-separado">
            <a href="#" id="cerrar_sesion"><i class="bi bi-box-arrow-left"></i>Cerrar sesión</a>
        </li>
            </ul>
        </nav>
        
        
        <section id="admin-contenido" class="admin">
            <!-- Título y botones cuando hay expediente seleccionado -->
            <?php if ($expediente_seleccionado): ?>
<div class="title-button-container">
    <!-- Contenedor para título y botones en la misma fila en tablet+ -->
    <div class="title-header-row">
        <h1>Documentos</h1>
        
    </div>
    
    <!-- Breadcrumb de navegación -->
    <div class="breadcrumb">
        <a href="?">Inicio</a> / 
        <a href="javascript:history.back()" class="back-button">Atrás</a> /
        <?php 
        $carpeta_actual = obtenerInfoExpediente($conexion_metadocs, $expediente_seleccionado);
        if ($carpeta_actual) {
            echo htmlspecialchars($carpeta_actual['nombre']);
        } else {
            echo "Expediente no encontrado";
        }
        ?>
    </div>
</div>
<?php else: ?>
<div class="title-button-container">
    <h1>Carpetas</h1>
</div>
<?php endif; ?>

            <div class="buscar-documentos">
                <input type="text" class="input-buscar" placeholder="Buscar carpeta o archivo...">
                <?php if (!$expediente_seleccionado): ?>
                <button class="btn-crear" id="btn_crear">Crear Carpeta</button>
                <?php endif; ?>
            </div>

            <article class="tabla-documentos">
                <table>
                <thead>
                    <tr class="table-cabeza">
                        <th>NOMBRE</th>
                        <th>TIPO</th>
                        <th>FECHA SUBIDA</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Variable para controlar si hay contenido
                    $tiene_contenido = false;
                    
                    // Mostrar expedientes/carpetas
                    if (!empty($carpetas)):
                        $tiene_contenido = true;
                        foreach ($carpetas as $carpeta): 
                    ?>
                        <tr class="documentos" data-url="?id_expediente=<?= $carpeta['id_expediente']; ?>">
                            <td class="documento-nombre">
                                <a href="?id_expediente=<?= $carpeta['id_expediente']; ?>">
                                    <i class="bi bi-folder2"></i> <?= htmlspecialchars($carpeta['nombre']); ?>
                                </a>
                            </td>
                            <td class="documento-tipo">expediente</td>
                            <td class="documento-fecha"><?= htmlspecialchars($carpeta['fecha_creacion']); ?></td>
                            <td class="documento-accion">
                                <button class="btn_accion" data-id="<?= $carpeta['id_expediente']; ?>"><i class="bi bi-pencil-square"></i></button>
                                
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                    endif;
                    
                    // Mostrar documentos si hay expediente seleccionado
                    if ($expediente_seleccionado && !empty($documentos)): 
                        $tiene_contenido = true;
                        foreach ($documentos as $documento): 
                    ?>
                        <tr class="documentos" data-document-id="<?= $documento['id_documento'] ?>">
                            <td class="documento-nombre">
                                <i class="bi bi-file-earmark-text"></i> 
                                <?= htmlspecialchars($documento['titulo']); ?>
                            </td>
                            <td class="documento-tipo"><?= htmlspecialchars($documento['tipo']); ?></td>
                            <td class="documento-fecha"><?= htmlspecialchars($documento['fecha_creacion']); ?></td>
                            <td class="documento-accion">
                                <button class="btn_accion btn_ver_modal escritorio" onclick="verDocumento('<?= urlencode($documento['titulo'] . '.' . $documento['tipo']) ?>', '<?= strtolower($documento['tipo']) ?>')">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button class="btn_accion btn_ver_nueva_ventana movil" onclick="abrirNuevaVentana('<?= urlencode($documento['titulo'] . '.' . $documento['tipo']) ?>')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    <?php 
                        endforeach;
                    endif;
                    
                    // Mostrar mensaje si no hay contenido
                    if (!$tiene_contenido): 
                    ?>
                        <tr>
                            <td colspan="4" class="no-content">No hay expedientes ni documentos para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                </table>
            </article>
        </section>
    </main>

    <!-- Modal para crear expediente -->
    <div id="modal_expediente" class="modal">
        <div id="form_carpeta">
            <form action="../../backend/auditor/gestor_archivos_auditor.php" method="post">
                <div id="titulo_carpeta_header">
                    <h2>Crear expediente</h2>
                    <span class="close" id="close">&times;</span>
                </div>
                <div id="input_carpeta">
                    <label for="titulo_carpeta_input">Ingrese el título</label>
                    <input type="hidden" name="expediente_padre" value="<?= $expediente_seleccionado ?>">
                    <input type="text" id="titulo_carpeta_input" name="titulo_carpeta" placeholder="Ingrese el título del expediente" required>
                    
                    <label for="desc_carpeta_input">Descripción</label>
                    <textarea id="desc_carpeta_input" name="desc_carpeta" placeholder="Ingrese la descripción del expediente" required></textarea>
                </div>
                <div id="btn_carpeta">
                    <button type="submit" name="accion" value="subir_expediente">Crear</button>
                </div>  
            </form>
        </div>
    </div>

    <!-- Modal para visualizar documentos -->
    <div id="modal_visor">
        <div id="modal_visor_content">
            <span id="cerrar_visor">&times;</span>
            <iframe id="visor_documento" src=""></iframe>
        </div>
    </div>

    
<div id="modal_edicion_expediente" class="modal_expediente">
    <div class="contenido_modal_expediente">
        <form action="../../backend/auditor/gestor_archivos_auditor.php" method="post">
            
            <div class="cabecera_modal_expediente">
                
                <h2 class="titulo_modal_expediente">Editar expediente</h2>
                <span class="cerrar_modal_expediente">&times;</span>
            </div>
            
            <div class="cuerpo_formulario_expediente">
                <input type="hidden" name="id_expediente" id="campo_id_expediente">
                
                <label for="campo_titulo_expediente">Título</label>
                <input type="text" id="campo_titulo_expediente" name="nuevo_titulo" required>
                
                <label for="campo_descripcion_expediente">Descripción</label>
                <textarea id="campo_descripcion_expediente" name="nueva_descripcion" required></textarea>
            </div>
            
            <div class="acciones_formulario_expediente">
                <input type="hidden" name="accion" value="editar_expediente">
                <button type="submit" class="boton_guardar_expediente">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>


    <script src="../../../componentes/js/documentador/tabla_click.js"></script>
    <script src="../../../componentes/js/documentador/visor.js"></script>
    <script src="../../../componentes/js/documentador/filtro_tabla.js"></script>
    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>
</html>