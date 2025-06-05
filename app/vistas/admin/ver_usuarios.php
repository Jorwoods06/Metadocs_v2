<?php 
require_once '../../backend/administrador/consulta_usuarios.php';
require_once '../../helpers/verificacion_roles.php';
AutorizacionRol('administrador');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Metadocs</title>
    
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <script src="../../../componentes/js/admin/panel.js"></script>
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <link rel="stylesheet" href="../../../componentes/css/admin/ediciones_u.css">
    <script src="../../../componentes/js/admin/modal_editar.js" ></script>
    <link rel="stylesheet" href="../../../componentes/css/admin/eliminar_u.css">
    <script src="../../../componentes/js/admin/modal_eliminar.js" ></script>
    <link rel="stylesheet" href="../../../componentes/css/admin/lista_u.css">

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

                <li class="gestion_usuario" >
                    <a href="#" id="gestion-usuarios" class="activo"><i class="bi bi-people"></i> Gestión Usuarios</a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li><a href="../../vistas/admin/creacion_usuario.php"><i class="bi bi-person-plus"></i> Crear usuario</a></li>
                        <li><a href="../admin/ver_usuarios.php"><i class="bi bi-eye"></i> Ver usuario</a></li>
                    </ul>
                </li>
                <li><a href="../admin/admin_reporte.php"><i class="bi bi-file-earmark-text"></i> Reportes</a></li>
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios"><i class="bi bi-person"></i> Usuario</a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                        <li>
                            <form action="../../backend/login/cerrar_sesion.php" method="post">
                                <button type="submit"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</button>
                            </form>
                        </li>
                        <li><a href=""><i class="bi bi-info-circle"></i> Info usuario</a></li>
                        <li><a href=""><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>
                <li class="solo_mobil">
                    <a href="#" id="solo_mobil"><i class="bi bi-arrow-left"></i> Volver</a>
                </li>
            </ul>
        </nav>

       <section id="admin-contenido" class="admin">

            <h1>Lista de usuarios</h1>

            <div class="cont_nombre">

                <input type="text" name="buscar_usuario" id="buscar_usuario" placeholder="Buscar usuario...">
                <select id="areas">
                    <option value="">Todas las áreas</option>
                    <option value="administracion">Administración</option>
                    <option value="logistica">Logística</option>
                    <option value="contabilidad">Contabilidad</option>
                </select>
            </div>

            <div class="tabla-contenedor">
                <table class="tabla-usuarios">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Área</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado->num_rows <= 0) {
                            echo '<tr><td colspan="5">No hay usuarios en el sistema</td></tr>';
                        } else {
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($fila['nombres']) . "</td>";
                                echo "<td>" . htmlspecialchars($fila['correo']) . "</td>";
                                echo "<td>" . htmlspecialchars($fila['rol']) . "</td>";
                                echo "<td>" . htmlspecialchars($fila['area']) . "</td>";
                                echo "<td class='acciones'>
                                        <i class='bi bi-pencil'></i>
                                        <i class='bi bi-trash'></i>
                                    </td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

   
    <!-- Modal editar -->


    <div id="modal-editar" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar usuario</h2>
            <form id="form_editar">
                <label>Nombre(s):</label>
                <input type="text" id="nombre_editar" required>

                <label>Correo electrónico:</label>
                <input type="email" id="correo_editar" required>

                <label>Rol:</label>
                <select id="rol_editar">
                    <option value="administrador">Administrador</option>
                    <option value="usuario">Usuario</option>
                    <option value="documentador">Documentador</option>
                    <option value="auditor">Auditor</option>
                </select>

                <label>Área:</label>
                <select id="area_editar">
                    <option value="administracion">Administración</option>
                    <option value="logistica">Logística</option>
                    <option value="contabilidad">Contabilidad</option>
                    <option value="otro">Otro</option>
                </select>

                <button type="submit" class="btn_editar">Guardar cambios</button>
            </form>
        </div>
    </div>

    <!-- Modal eliminar -->

    <div id="modal-eliminar" class="modal">
        <form class="modal-contenedor" >
            <span class="close">&times;</span>
            <h2>Confirmar eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar este usuario?</p>
            <div class="modal-acciones">
                <button class="btn-cancelar">Cancelar</button>
                <button class="btn-eliminar">Eliminar</button>
                
            </div>
            
        </form>
    </div>
</body>
</html>
