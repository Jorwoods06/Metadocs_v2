<?php 
require_once "..\..\backend/administrador/interfaz_usuario.php"
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Metadocs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <img src="../../../componentes/img/image.png" alt="imagen del menu lateral">
    </figure>
    <ul>
       
        <div class="menu-opciones-principales">
            <li>
                <a href="../admin/panel_control.php" >
                    <i class="fas fa-chart-line"></i>
                    Panel Control
                </a>
            </li>

              <li>
                <a href="../admin/pista_auditoria.php">
                    <i class="fas fa-clipboard-check"></i>
                    Actividades usuarios
                </a>
            </li>

            <li class="gestion_usuario">
                <a href="#" id="gestion-usuarios" ><i class="fas fa-users"></i> Gestión Usuarios</a>
                <ul class="sub_menu gestion-submenu" id="sub_menu">
                    <li><a href="../../vistas/admin/creacion_usuario.php"><i class="fas fa-user-plus"></i> Crear usuario</a></li>
                    <li><a href="../admin/ver_usuarios.php" ><i class="fas fa-eye"></i> Ver usuario</a></li>
                </ul>
            </li>
            
       
            
            <li class="gestion-usuarios">
                <a href="#" id="cerrado-usuarios"  class="activo"><i class="fas fa-user"></i> Admin</a>
                <ul class="sub_menu usuario-submenu" id="sub_menu">
                    <li><a href="#"><i class="fas fa-info-circle"></i> Info usuario</a></li>
                    <li><a href="cambiar_contraseña.php"><i class="fas fa-key"></i> Cambiar contraseña</a></li>
                </ul>
            </li>
            
            <li class="solo_mobil">
                <a href="#" id="solo_mobil"><i class="fas fa-arrow-left"></i> Volver</a>
            </li>
        </div>

       
        <li class="cerrar-sesion-separado">
            <a href="#" id="cerrar_sesion"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
        </li>
    </ul>
</nav>
            <section class="contenido-usuario">
                <h1 class="titulo-usaurio">Informacion del Usuario</h1>
                <div class="contenedor-general">
                    <div class="info-usuarios">
                        <img src="../../../componentes/img/usuario.png" alt="logo de usuario" class="avatar-usuario">
                        <div class="nombre-usuario">Bienvenido <?=htmlspecialchars($fila["nombres"])?></div>
                    </div>

                    <div class="contenedor-datos"> 
                        <div class="datos">
                            <label>Descripción laboral</label>
                            <div class="valor"><?=htmlspecialchars($mensaje)?></div>
                        </div>

                        <div class="datos">
                            <label>Nombre</label>
                            <div class="valor"><?= htmlspecialchars($fila["nombres"]) ?></div>  
                        </div>

                        <div class="datos">
                            <label>Apellido</label>
                            <div class="valor"><?= htmlspecialchars($fila["apellidos"]) ?></div>
                        </div>

                        <div class="datos">
                            <label>Correo Electrónico</label>
                            <div class="valor"><?= htmlspecialchars($fila["correo"]) ?></div>
                        </div>

                        <div class="datos">
                            <label>Número telefónico</label>
                            <div class="valor"><?= htmlspecialchars($fila["telefono"]) ?></div>
                        </div>

                        <div class="datos">
                            <label>Cédula</label>
                            <div class="valor"><?= htmlspecialchars($fila["cedula"]) ?></div>
                        </div>

                        <div class="datos">
                            <label>Área</label>
                            <div class="valor"><?= htmlspecialchars($fila["area"]) ?></div>
                        </div>

                        <div class="datos">
                            <label>Rol</label>
                            <div class="valor"><?= htmlspecialchars($fila["rol"]) ?></div>
                        </div>
                    </div> <!-- <- Cierre correcto -->
                </div>

            </section>
    </main>
    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>
</html>
