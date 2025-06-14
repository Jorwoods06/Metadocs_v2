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
                <img src="../../../componentes/img/Imagen de WhatsApp 2025-05-01 a las 11.52.47_deffc20c.jpg" alt="imagen del menu lateral">
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
                        <li><a href="#"><i class="bi bi-eye"></i> Ver documentos</a></li>
                        <li><a href="solicitar_documento.php"><i class="bi bi-file-earmark-plus"></i> Solicitar documentos</a></li>
                         <li><a href=""> <i class="bi bi-clock-history"></i> Archivo historico</a></li>
                    </ul>
                </li>
               
                <li>
                    <a href="">
                        <i class="bi bi-list-check"></i>
                        Pista auditoria
                    </a>
                </li>
                
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios">
                        <i class="bi bi-person"></i>
                        Usuario
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                        <li><form action="../../backend/login/cerrar_sesion.php" method="post"><button type="submit"><i class="bi bi-box-arrow-left"></i>Cerrar sesion</button></form></li>
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
            <!-- Título y botones cuando hay expediente seleccionado -->
            <?php if ($expediente_seleccionado): ?>
            <div class="title-button-container">
                <h1>Documentos</h1>
                <div class="header-buttons">
                    <button type="button" id="btn_documento">
                        <i class="bi bi-cloud-upload"></i> Subir documento
                    </button>
                    <button type="button" id="btn_crear">
                        <i class="bi bi-plus-circle"></i> Crear expediente
                    </button>
                </div>
            </div>
            <?php else: ?>
            <h1>Documentos</h1>
            <?php endif; ?>

            <!-- Breadcrumb de navegación -->
            <?php if ($expediente_seleccionado): ?>
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
            <?php endif; ?>

            <div class="buscar-documentos">
                <input type="text" class="input-buscar" placeholder="Buscar carpeta o archivo...">
                <?php if (!$expediente_seleccionado): ?>
                <button class="btn-crear" id="btn_crear">Crear expediente</button>
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
                                <button class="btn_accion" data-id="<?= $carpeta['id_expediente']; ?>">⋮</button>
                                <div class="action-dropdown-menu">
                                    <button class="action-dropdown-item edit-expediente">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </button>
                                   
                                </div>
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
                                <button class="btn_accion" data-id="doc-<?= $documento['id_documento'] ?>">⋮</button>
                                <div class="action-dropdown-menu">
                                    <button class="action-dropdown-item view-document">
                                        <i class="bi bi-eye"></i> Ver
                                    </button>
                                    <button class="action-dropdown-item delete-document">
                                        <i class="bi bi-trash3"></i> Eliminar
                                    </button>
                                    <form method="post" action="../../backend/auditor/gestor_archivos_auditor.php" style="display:inline;">
                                        <input type="hidden" name="accion" value="descargar_documento">
                                        <input type="hidden" name="documento_id" value="<?= $documento['id_documento'] ?>">
                                        <button type="submit" class="action-dropdown-item">
                                            <i class="bi bi-download"></i> Descargar
                                        </button>
                                    </form>
                                </div>
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

    <!-- Modal para subir documento 
    <div id="modal_documento" class="modal">
        <form action="../../backend/auditor/gestor_archivos_auditor.php" method="post" enctype="multipart/form-data" id="upload-form">
            <div class="file-uploader">
                <span class="close">&times;</span>
                <h2>Subir archivo</h2>
            
                <div id="upload-area" class="upload-area">
                    <input type="file" id="file-input" name="file-input">
                    <label for="file-input" class="upload-label">
                        <i class="bi bi-cloud-upload"></i>
                        <p>Arrastre y suelte archivos o haga clic para cargar</p>
                    </label>
                </div>
                
                <input type="hidden" name="expediente_id" value="<?= $expediente_seleccionado ?>">
                
                <div class="form-group">
                    <label class="form-label" for="documentCategory">Categoría del documento:</label>
                    <select class="form-select" id="documentCategory" name="categoria" required>
                        <option value="" disabled selected>Seleccione una categoría</option>
                        <option value="estrategicos">Estratégicos</option>
                        <option value="operativos">Operativos</option>
                        <option value="soporte">Soporte</option>
                        <option value="legales_contractuales">Legales</option>
                        <option value="financieros_contables">Financieros</option>
                        <option value="correspondencia">Correspondencia</option>
                    </select>
                </div>
                
                <div id="action-buttons-container" style="display: none; margin-top: 1rem;">
                    <button id="cancel-upload" type="button" style="margin-right: 1rem;">Cancelar</button>
                    <button id="upload-file" type="submit" name="accion" value="subir_documento">Subir</button>
                </div>
            </div>
        </form>
    </div> -->


    <!-- Modal para editar expediente 
    <div id="editModal" class="modal">
        <div class="modal-content">
            <form action="../../backend/auditor/gestor_archivos_auditor.php" method="post">
                <div id="titulo_carpeta_header">
                    <span class="close">&times;</span>
                    <h2>Editar expediente</h2>
                </div>
                <div id="input_carpeta">
                    <input type="hidden" name="id_expediente" id="edit_expediente_id">
                    <label for="nuevo_titulo">Título</label>
                    <input type="text" id="nuevo_titulo" name="nuevo_titulo" required>
                    
                    <label for="nueva_descripcion">Descripción</label>
                    <textarea id="nueva_descripcion" name="nueva_descripcion" required></textarea>
                </div>
                <div id="btn_carpeta">
                    <input type="hidden" name="accion" value="editar_expediente">
                    <button type="submit">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div> -->

    <script src="../../../componentes/js/auditor/modal_documento.js"></script>
</body>
</html>