<?php 

require_once "..\..\backend/administrador/interfaz_usuario.php";
require_once '../../helpers/verificacion_roles.php';

AutorizacionRol('documentador');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentador | Metadocs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <script src="../../../componentes/js/admin/panel.js"></script>
    <link rel="stylesheet" href="../../../componentes/css/admin/informacion_usuario.css">
</head>
<body>
    
        <header id="cabezote">
        <i class="fas fa-bars" id="menu_opciones"></i>
    </header>
    <main id="cuerpo">
         <nav id="menu-lateral" class="menu-lateral">
            <figure id="img_menu">
                <img src="../../../componentes/img/image.png" alt="imagen del menu lateral">
            </figure>
            <ul>
             <div class="menu-opciones-principales">
                <li><a href="inicio_documentador.php"><i class="fas fa-home"></i>Inicio</a></li>
                <li><a href="ver_documentos.php"><i class="fas fa-file-alt"></i>Archivos</a></li>
                <li><a href="solicitudes_doc.php" ><i class="fas fa-envelope"></i>Solicitudes</a></li>
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios" class="activo">
                        <i class="fas fa-user"></i>Documentador
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                     
                        <li><a href="#" ><i class="fas fa-info-circle"></i> Info documentador</a></li>
                        <li><a href="cambiar_contraseña.php"><i class="fas fa-key"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>
                <li class="solo_mobil">
                    <a href="#" id="solo_mobil"><i class="fas fa-arrow-left"></i>Volver</a>
                </li>
                  </div>
                   <li  class="cerrar-sesion-separado"><a href="#" id="cerrar_sesion"><i class="fas fa-sign-out-alt"></i>Cerrar sesion</a></li>
            </ul>
        
           
        </nav>
        
        <section class="contenido-usuario">
            <h1 class="titulo-usaurio">Informacion del Usuario</h1>
            <div class="info-usuario">
                <div class="info-usuarios">
                    <img src="../../../componentes/img/usuario.png" alt="logo de usuario" class="avatar-usuario">
                    <div class="nombre-usuario"><?=htmlspecialchars($fila["nombres"])?></div>
                </div>
            
            <div class="contenedor-datos">

            <div class="datos">
                <label>Descripción laboral</label>
                <div class="valor">
                    <?=htmlspecialchars($mensaje)?>
                </div>
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
                <label>Correo Electronico</label>
                <div class="valor"><?= htmlspecialchars($fila["correo"]) ?></div>
            </div>

            <div class="datos">
                <label>Numero telefónico</label>
                <div class="valor"><?= htmlspecialchars($fila["telefono"]) ?></div>
            </div>
            
            <div class="datos">
                <label>Cedula</label>
                <div class="valor"><?= htmlspecialchars($fila["cedula"]) ?></div>
            </div>

            <div class="datos">
                <label>Area</label>
                <div class="valor"><?= htmlspecialchars($fila["area"]) ?></div>
            </div>

            <div class="datos">
                <label>Rol</label>
                <div class="valor"><?= htmlspecialchars($fila["rol"]) ?></div>
            </div>

        </div>
            </div>
        </section>
    </main>

    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>
</html>
