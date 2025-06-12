<?php 

require_once '../../helpers/verificacion_roles.php';

AutorizacionRol('auditor');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentador | Metadocs</title>
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
                
                    <!-- cerrado sesion -->  
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
             <h1>Documentos</h1>

            <div class="buscar-documentos">
                <input type="text" class="input-buscar" placeholder="Buscar carpeta o archivo...">
                <button class="btn-crear" id="btn_crear">Crear expediente</button>
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

                        <!-- falta quitar el boton de opciones-->
                    <tr class="documentos">
                        <td class="documento-nombre"><i class="bi bi-folder2"></i>  expediente 1</td>
                        <td class="documento-tipo">expediente</td>
                        <td class="documento-fecha">2025-03-09</td>
                        <td class="documento-accion">
                            <button class="btn_accion">⋮</button>
                        </td>
                    </tr>
                      <tr class="documentos">
                        <td class="documento-nombre"><i class="bi bi-folder2"></i> expediente 2</td>
                        <td class="documento-tipo">expediente</td>
                        <td class="documento-fecha">2025-03-09</td>
                        <td class="documento-accion">
                            <button class="btn_accion">⋮</button>
                        </td>
                    </tr>
                      <tr class="documentos">
                        <td class="documento-nombre"><i class="bi bi-folder2"></i> expediente 3</td>
                        <td class="documento-tipo">expediente</td>
                        <td class="documento-fecha">2025-03-09</td>
                        <td class="documento-accion">
                            <button class="btn_accion">⋮</button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </section>


</main>

<div id="modal_expediente">
        <div id="form_carpeta">
                <form action="../../backend/auditor/gestor_archivos_auditor.php" method="post">
                    <div id="titulo_carpeta_header">
                        
                        <h2>Crear expediente</h2>
                        <span class="close" id="close">&times;</span>
                    </div>
                    <div id="input_carpeta">
                        <label for="titulo_carpeta_input">Ingrese el título</label>
                        <input type="hidden" name="expediente_padre" value="<?= $expediente_seleccionado ?>">
                        <input type="text" id="titulo_carpeta_input" name="titulo_carpeta" placeholder="Ingrese el título de la expediente" required>
                        
                        <label for="desc_carpeta_input">Descripción</label>
                        <textarea id="desc_carpeta_input" name="desc_carpeta" placeholder="Ingrese la descripción de la expediente" required></textarea>
                    </div>
                    <div id="btn_carpeta">
                        <button type="submit" name="accion" value="subir_expediente">Crear</button>
                    </div>  
                   
                </form>
            </div>
    
</div>
</body>
</html>
