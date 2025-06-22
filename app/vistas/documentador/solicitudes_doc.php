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
    <script src="../../../componentes/js/admin/panel.js" defer></script>
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
                <li><a href="documentador_inicio.php"><i class="bi bi-house-door"></i>Inicio</a></li>
                <li><a href="ver_documentos.php"><i class="bi bi-file-earmark-text"></i>Documentos</a></li>
                <li><a href="" class="activo"><i class="bi bi-envelope-paper"></i>Solicitudes</a></li>
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios">
                        <i class="bi bi-person"></i>Usuario
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                         <li><a href="#" id="cerrar_sesion"><i class="bi bi-box-arrow-left"></i>Cerrar sesion</a></li>
                        <li><a href="info_documentador.php"><i class="bi bi-info-circle"></i> Info usuario</a></li>
                        <li><a href=""><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>
                <li class="solo_mobil">
                    <a href="#" id="solo_mobil"><i class="bi bi-arrow-left-circle"></i>Volver</a>
                </li>
            </ul>
        </nav>

  <section class="contenedor-principal">
  <h1>Solicitudes Recibidas</h1>

  <div class="filtro-mensajes">
    <label for="tipo-filtro">Filtrar por tipo:</label>
    <select id="tipo-filtro">
      <option value="todos">Todos</option>
      <option value="documento">Solicitud de documento</option>
      <option value="aprobado">Documento aprobado</option>
      <option value="rechazado">Expediente rechazado</option>
    </select>
  </div>

  <div class="contenedor-mensajes">
    <div class="lista-mensajes">

      <div class="mensaje no-visto" data-tipo="documento">
        <div class="icono-mensaje">
          <i class="bi bi-file-earmark-arrow-up"></i>
        </div>
        <div class="contenido-mensaje">
          <h2>Juan Pérez</h2>
          <p>Solicitud de documento</p>
        </div>
        <div class="fecha-mensaje">
          <p>hace 2h</p>
        </div>
      </div>

      <div class="mensaje no-visto" data-tipo="aprobado">
        <div class="icono-mensaje">
          <i class="bi bi-file-earmark-check"></i>
        </div>
        <div class="contenido-mensaje">
          <h2>Juan Pérez</h2>
          <p>Tu documento fue aprobado</p>
        </div>
        <div class="fecha-mensaje">
          <p>hace 5h</p>
        </div>
      </div>

      <div class="mensaje no-visto" data-tipo="rechazado">
        <div class="icono-mensaje">
          <i class="bi bi-folder-x"></i>
        </div>
        <div class="contenido-mensaje">
          <h2>Juan Pérez</h2>
          <p>Tu expediente fue rechazado</p>
        </div>
        <div class="fecha-mensaje">
          <p>hace 1h</p>
        </div>
      </div>

    </div>
  </div>
</section>




    </main>


    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
    <script src="../../../componentes/js/documentador/filtro_solicitud.js"></script>
</body>
</html>
