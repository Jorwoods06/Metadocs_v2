<?php 

require_once '../../backend/auditor/archivos_solicitados.php';
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
    <link rel="stylesheet" href="../../../componentes/css/auditor/recibir_documentos.css">
    <link rel="stylesheet" href="../../../componentes/css/auditor/modal_aprobar_expediente.css">
    <script src="../../../componentes/js/auditor/recibir_documentos.js"></script>
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
                    <a href="#" id="gestion-usuarios"  class="activo">
                        <i class="bi bi-file-earmark-text"></i>
                        Gestión Documentos
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li><a href="#"><i class="bi bi-envelope-paper"></i>Solicitudes</a></li>
                        <li><a href="archivos_auditor.php"><i class="bi bi-eye"></i> Ver documentos</a></li>
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
            
            <div id="titulo">

                <h1>Solicitudes de documentos</h1>
                <p>Revisa y aprueba documentos pendientes de validación</p>

            </div>


            <div class="navegacion-doc-expe">
                <div class="botones-navegacion">
                    <button type="button"  id="btn-documentos" data-tipo="documento"><i class="bi bi-file-earmark"></i>Documentos</button>
                    <button type="button" id="btn-expedientes" data-tipo="expediente"><i class="bi bi-folder"></i>Expedientes</button>
                </div>
            </div>

            <?php
            if ( $resultado_expediente->num_rows > 0) {
            while ($expediente = $resultado_expediente->fetch_assoc()) {
            ?>
            <article class="carta" id="carta_expediente" data-tipo="expediente">
                <div class="info">
                    <div id="icono"><i class="bi bi-folder"></i></div>
                    <div id="info">
                        
                        <h3><?php echo htmlspecialchars($expediente['nombre']); ?></h3>
                        <p>Expediente</p>
                    </div>
                </div>
                  <p id="descripcion_expediente"><?php echo htmlspecialchars($expediente['descripcion']); ?></p>
                    <div id="autor_fecha">
                        <p><i class="bi bi-person-fill"></i><?php echo htmlspecialchars($expediente['nombre_autor']); ?></p>
                        <p><i class="bi bi-calendar-fill"></i> <?php echo htmlspecialchars($expediente['fecha_creacion']); ?></p>
                    </div>
                       
                    <div id="botones">  
                        
                         <button type="button" class="aprobado btn-aprobar" data-id="<?php echo $expediente['id_expediente']; ?>">Aprobar</button>
                        <button type="button"  class="rechazado" id="expe_rechazado">Rechazar</button>
                    </div>
               
            </article>
            
        <?php
    }
} else {
   
    echo "<p>No hay expedientes en revisión.</p>";
}
?>


            <article class="carta" id="carta_documento" data-tipo="documento">
                <div class="info">
                    <div id="icono"><i class="bi bi-file-earmark"></i></div>
                    <div id="info">
                        <h3>Nombre del documento</h3>
                        <p>tipo "contrato"</p>
                    </div>
                </div>
                    <div id="autor_fecha">
                        <p><i class="bi bi-person-fill"></i>Jorge </p>
                        <p><i class="bi bi-calendar-fill"></i> 12/06/25</p>
                    </div>
                    <div id="botones">  
                        <button type="button" class="ver">Ver</button>
                        <button type="button" class="aprobado">Aprobar</button>
                        <button type="button" class="rechazado">Rechazar</button>
                    </div>
                
            </article>
            
            
            
            




        </section>


</main>

<div id="modal_confirmar">
    <form id="modal_contenedor" action="../../backend/auditor/aprobar_expediente_documento.php" method="POST">
        <span class="close">&times;</span>
        <h3>¿Confirmas la aprobación de este expediente?</h3>
        <p>¿Estás seguro de que deseas aprobar este expediente? Esta acción no se puede deshacer y el expediente pasará al siguiente estado del flujo de trabajo.</p>
        <div id="botones">
            <button type="submit" id="aprobar">Aprobar</button>
            <button type="button" id="cancelar">Cancelar</button>
        </div>

        <!-- input que guarda el id del expediente a aprobar (en js)-->
        <input type="hidden" name="datos_expediente" id="datos_expediente" value="">


        <!-- inptu que guarda un valor para el switch del backend -->
         <input type="hidden" name="accion" value="aprobar_expediente">
    </form>
</div>

</body>
</html>
