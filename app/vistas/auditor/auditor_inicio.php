<?php 

require_once '../../helpers/verificacion_roles.php';

AutorizacionRol('auditor');
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
    <script src="../../../componentes/js/documentador/ver_documentos.js"></script>
    <script src="../../../componentes/js/admin/panel.js"></script>
    <link rel="stylesheet" href="../../../componentes/css/auditor/inicio_auditor.css">
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
                    <a href="#" class="activo">
                        <i class="bi bi-house-door"></i>
                        Inicio
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios" >
                        <i class="bi bi-file-earmark-text"></i>
                        Gestión Documentos
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li><a href="recibir_documentos.php"><i class="bi bi-envelope-paper"></i>pendientes</a></li>
                        <li><a href="archivos_auditor.php"><i class="bi bi-eye"></i> Carpetas</a></li>
                        <li><a href="solicitar_documento.php"><i class="bi bi-file-earmark-plus"></i> Solicitar documentos</a></li>
                        <li><a href="archivo_historico.php"> <i class="bi bi-clock-history"></i> Archivo historico</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="../../vistas/auditor/pista_auditoria.php">
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
                        
                        <li><a href="info_auditor.php"><i class="bi bi-info-circle"></i> Info usuario</a></li>
                        <li><a href=""><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>

                        
                    </ul>

                    <li><a href="#" id="cerrar_sesion"><i class="bi bi-box-arrow-left"></i>Cerrar sesion</a></li>

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

            <h1 class="titulo-auditor">Bienvenido auditor</h1>

            <h2 class="titulo-mediano">Aqui podras seleccionar con que quieres estar informado</h2>
            

            <div class="contenedor-general">
                
                <a href="solicitar_documento.php" class="card-link">
                    <div class="card-opcion">
                        <img src="https://cdn-icons-png.flaticon.com/128/8212/8212410.png" alt="Solicitar documentos">
                        <label>Solicitar documentos</label>
                    </div>
                </a>

                <a href="recibir_documentos.php" class="card-link">
                    <div class="card-opcion">

                        <img src="https://cdn-icons-png.flaticon.com/128/12824/12824819.png" alt="Solicitudes">
                        <label>Solicitudes</label>
                    </div>
                </a>


                <a href="archivos_auditor.php" class="card-link">
                    <div class="card-opcion">
                        <img src="https://cdn-icons-png.flaticon.com/128/11907/11907348.png" alt="archivo historico">
                        <label> archivo histórico</label>
                    </div>
                </a>

                <a href="../../vistas/auditor/pista_auditoria.php" class="card-link">
                    <div class="card-opcion">
                        <img src="https://cdn-icons-png.flaticon.com/128/15400/15400355.png" alt="pista de auditoria">
                        <label> pista de auditoría</label>
                    </div>
                </a>

                <a href="info_auditor.php" class="card-link">
                    <div class="card-opcion">
                        <img src="https://cdn-icons-png.flaticon.com/128/5655/5655237.png" alt="Informacion auditor">
                        <label>Información del auditor</label>
                    </div>
                </a>


            </div>
        </section>



</main>

<?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>
</html>
