<?php 

require_once '../../helpers/verificacion_roles.php';

AutorizacionRol('administrador');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Metadocs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <script src="../../../componentes/js/admin/panel.js"></script>
    <link rel="stylesheet" href="../../../componentes/css/admin/informacion_usuario.css">
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
                    <a href="../admin/panel_control.php">
                        <i class="bi bi-bar-chart-line"></i>
                        Panel Control
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios" >
                        <i class="bi bi-people"></i>
                        Gestión Usuarios
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li><a href="../../vistas/admin/creacion_usuario.php"><i class="bi bi-person-plus"></i> Crear usuario</a></li>
                        <li><a href="../admin/ver_usuarios.php"><i class="bi bi-eye"></i> Ver usuario</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../admin/admin_reporte.php">
                        <i class="bi bi-file-earmark-text"></i>
                        Reportes 
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
                        <li><a href="../../vistas/admin/informacion_usuario.php"><i class="bi bi-info-circle"></i> Info usuario</a></li>
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
       
        <section class="contenido-usuario">
            <h1 class="titulo-usaurio">Informacion del Usuario</h1>
            <div class="info-usuario">
                <div class="info-usuarios">
                    <img src="../../../componentes/img/usuario.png" alt="logo de usuario" class="avatar-usuario">
                    <div class="nombre-usuario">Jorge Admin</div>
                </div>
            
                
                

                <div class="contenedor-datos">
                    <div class="datos">
                        <label>Nombre</label>
                        <div class="valor">jorge</div>  
                    </div>
                    <div class="datos">
                        <label>area</label>
                        <div class="valor">Administración</div>
                    </div>
                    <div class="datos">
                        <label>Apellido</label>
                        <div class="valor">admin</div>
                    </div>
                    <div class="datos">
                        <label>Rol</label>
                        <div class="valor">Administrador</div>
                    </div>
                    <div class="datos">
                        <label>Correo Elctronico</label>
                        <div class="valor">dg24004@gmail.com</div>
                    </div>
                    <div class="datos">
                        <label>Descripcion laboral</label>
                        <div class="valor">Jorge se desempeña como administrador en gestión documental, encargado de organizar, clasificar y custodiar los documentos tanto físicos como digitales de la empresa. </div>
                    </div>
                </div>
            </div>
        </section>





    </main>
</body>
</html>
