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
    <link rel="stylesheet" href="../../../componentes/css/admin/controles.css">
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
                    <a href="../admin/panel_control.php" class="activo">
                        <i class="bi bi-bar-chart-line"></i>
                        Panel Control
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios">
                        <i class="bi bi-people"></i>
                        Gestión Usuarios
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li>
                            <a href="../../vistas/admin/creacion_usuario.php">
                                <i class="bi bi-person-plus"></i>
                                Crear usuario
                            </a>
                        </li>
                        <li>
                            <a href="../admin/ver_usuarios.php">
                                <i class="bi bi-eye"></i>
                                Ver usuario
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="../admin/admin_reporte.php">
                        <i class="bi bi-file-earmark-text"></i>
                        Reportes
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
                        <i class="bi bi-arrow-left"></i>
                        Volver
                    </a>
                </li>
            </ul>
        </nav>
       
        <section id="admin-contenido" class="admin">
            <h1>Panel control</h1>

            <div class="dashboard">
                <div class="card-mediana">
                    <div class="iconos">
                        <i class="bi bi-collection"></i>
                    </div>
                    <h3> Total de Documentos</h3>
                    <p>+100 el mes pasado</p>
                    <h2>320</h2>
                </div>

                <div class="card-mediana">
                    <div class="iconos">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <h3> Documentos del Mes</h3>
                    <p>+50 en el mes</p>
                    <h2>85</h2>
                </div>

                <div class="card-mediana">
                    <div class="iconos">
                       <i class="bi bi-archive"></i>
                    </div>
                    <h3> Archivos historicos</h3>
                    <p>+2,3 archivos historicos</p>
                    <h2>1134</h2>
                </div>

                <div class="card-mediana">
                    <div class="iconos">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3> En revisión</h3>
                    <p>+200 revisiones</p>
                    <h2>387</h2>
                </div>

                <div class="card-mediana">
                    <div class="iconos">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3> Usuarios Activos</h3>
                    <p>+200 el mes pasado</p>
                    <h2>50</h2>
                </div>

                <div class="card-mediana">
                    <div class="iconos">
                        <i class="bi bi-hdd"></i>
                    </div>
                    <h3>Almacenamiento Usado</h3>
                    <P>+1tb en el mes</P>
                    <h2>1.2TB</h2>
                    </div>
                </div>

            </div>
        </section>

      
    </main>
</body>
</html>
