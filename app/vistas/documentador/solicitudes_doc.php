<?php 
require_once '../../helpers/verificacion_roles.php';
AutorizacionRol('documentador');
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
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <link rel="stylesheet" href="../../../componentes/css/documentador/solicitudes_doc.css">

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
                <li><a href=""><i class="bi bi-house-door"></i>Inicio</a></li>
                <li><a href="ver_documentos.php"><i class="bi bi-file-earmark-text"></i>Documentos</a></li>
                <li><a href="" class="activo"><i class="bi bi-envelope-paper"></i>Solicitudes</a></li>
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios">
                        <i class="bi bi-person"></i>Usuario
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                        <li>
                            <form action="../../backend/login/cerrar_sesion.php" method="post">
                                <button type="submit"><i class="bi bi-box-arrow-left"></i>Cerrar sesión</button>
                            </form>
                        </li>
                        <li><a href="../log/informacion_usuario.php"><i class="bi bi-info-circle"></i> Info usuario</a></li>
                        <li><a href=""><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>
                <li class="solo_mobil">
                    <a href="#" id="solo_mobil"><i class="bi bi-arrow-left-circle"></i>Volver</a>
                </li>
            </ul>
        </nav>

        
        <section class="contenedor-principal">
            <div class="contenedor-mensajes">
                <h1>Mensajes Recibidos</h1>

                <div class="filtros">
                    <input type="text" placeholder="Buscar por nombre...">
                    <select>
                        <option value="">Todos los roles</option>
                        <option value="auditor">Auditor</option>
                        <option value="administrador">Administrador</option>
                    </select>
                    <button><i class="bi bi-search"></i></button>
                </div>

                <div class="lista-mensajes">
  <div class="mensaje no-visto">
    <h2>Juan Pérez <span>(Auditor)</span></h2>
    <p>Hola, por favor envíame el documento X...</p>
    <div class="info-mensaje">
      <span class="fecha">12/06/2025</span>
      <span class="estado"><i class="bi bi-eye-slash-fill"></i> No visto</span>
    </div>
  </div>

  <div class="mensaje visto">
    <h2>Laura Gómez <span>(Auditor)</span></h2>
    <p>Recuerda cargar el informe mensual...</p>
    <div class="info-mensaje">
      <span class="fecha">11/06/2025</span>
      <span class="estado"><i class="bi bi-eye-fill"></i> Visto</span>
    </div>
  </div>
</div>

        </section>
    </main>
</body>
</html>
