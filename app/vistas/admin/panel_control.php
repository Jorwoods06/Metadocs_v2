
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
</head>
<body>
    <header id="cabezote">
        <i class="bi bi-list" id="menu_opciones"></i>
        <i   class="bi bi-person-circle" id="btn_cerrar"></i>
    </header>

    <main id="cuerpo">
        <nav id="menu-lateral" class="menu-lateral">
            <figure id="img_menu">
                <img src="../../../componentes/img/Imagen de WhatsApp 2025-05-01 a las 11.52.47_deffc20c.jpg" alt="imagen del menu lateral">
            </figure>
            <ul>
                <li>
                    <a href="../admin/panel_control.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18"/>
                            <path d="M7 14v4"/>
                            <path d="M11 10v8"/>
                            <path d="M15 6v12"/>
                        </svg>
                        Panel Control
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="7" r="4"/>
                            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
                        </svg>
                        Gestión Usuarios
                    </a>
                    <ul class="sub_menu" id="sub_menu">
                        <li><a href="../../app/views/admin_user.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="17" y1="11" x2="23" y2="11"/>
                          </svg>
                          Crear usuario</a></li>
                        <li><a href="../admin/ver_usuarios.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                          </svg>
                          Ver usuario</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../admin/admin_reporte.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
                            <path d="M9 8h6"/>
                            <path d="M9 12h4"/>
                            <path d="M9 16h6"/>
                        </svg>
                        Reportes
                    </a>
                </li>
                <li class="solo_mobil" >
                    <a href="#" id ="solo_mobil" >
                        
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 19L8 12L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="8" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                                Volver
                    </a>
                </li>
            </ul>
        </nav>
       
        <section id="admin-contenido" class="admin">
            <h1>Panel control</h1>
        </section>

        <?php include '../log/tarjeta_cerrar.php'; ?>

</main>
</body>
</html>