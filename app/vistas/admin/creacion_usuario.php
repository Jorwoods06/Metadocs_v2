<?php 

session_start();

require_once '../../helpers/verificacion_roles.php';
AutorizacionRol('administrador');


$exito = $_SESSION['exito'] ?? null;
unset($_SESSION['exito']);

$corre_exitente = $_SESSION['correo_existente'] ?? null;
unset($_SESSION['correo_existente']);



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin | Metadocs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css" />
    <link rel="stylesheet" href="../../../componentes/css/admin/creacion_usuario.css" />
    <script src="../../../componentes/js/admin/panel.js"></script>
</head>
<body>
    <header id="cabezote">
        <i class="bi bi-list" id="menu_opciones"></i>
    </header>

    <main id="cuerpo">
        <nav id="menu-lateral" class="menu-lateral">
            <figure id="img_menu">
                <img src="../../../componentes/img/Imagen de WhatsApp 2025-05-01 a las 11.52.47_deffc20c.jpg" alt="imagen del menu lateral" />
            </figure>
            <ul>
                <li>
                    <a href="../admin/panel_control.php">
                        <i class="bi bi-bar-chart-line"></i> Panel Control
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios">
                        <i class="bi bi-people"></i> Gestión Usuarios
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li><a href="../../vistas/admin/creacion_usuario.php"><i class="bi bi-person-plus"></i> Crear usuario</a></li>
                        <li><a href="../admin/ver_usuarios.php"><i class="bi bi-eye"></i> Ver usuario</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../admin/admin_reporte.php">
                        <i class="bi bi-file-earmark-text"></i> Reportes
                    </a>
                </li>

                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios">
                        <i class="bi bi-person"></i> Usuario
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                        <li>
                            <form action="../../backend/login/cerrar_sesion.php" method="post">
                            <button type="submit"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</button>
                            </form>
                        </li>
                        <li><a href="#"><i class="bi bi-info-circle"></i> Info usuario</a></li>
                        <li><a href="#"><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>
                <li class="solo_mobil">
                    <a href="#" id="solo_mobil">
                        <i class="bi bi-arrow-left-circle"></i> Volver
                    </a>
                </li>
            </ul>
        </nav>
    

         <?php if ($exito): ?>
        <div class="mensaje_exito" id="mensaje-exito">
            <p><?= htmlspecialchars($exito) ?></p>
        </div>
    

        <?php endif; ?>

        <?php if ($corre_exitente): ?>
            <div class="correo_existente" id="correo_existente">
            <p><?= htmlspecialchars($corre_exitente) ?></p>
        </div>
        <?php endif; ?>


        <section id="admin-contenido" class="admin">
            <div class="form-container">
                <h2>Crear Usuario</h2>
                <p class="subtitle">Ingrese los datos del nuevo usuario</p>
                
                <form action="../../backend/administrador/subir_usuario.php" method="post">


                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input 
                                type="text" id="nombre" name="nombre" maxlength="32" minlength="2" 
                                pattern="^[A-Za-z]+( [A-Za-z]+)?$" 
                                title="Tu nombre no puede llevar números o caracteres especiales, solo letras y espacios." 
                                required placeholder="Ingresa tu nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input 
                                type="text" id="apellido" name="apellido" maxlength="32" minlength="2" 
                                pattern="^[A-Za-z]+( [A-Za-z]+)?$"
                                title="Tu apellido no puede llevar números o caracteres especiales, solo letras y espacios." 
                                required placeholder="Ingresa tu apellido">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input 
                                type="email" id="email" name="email" maxlength="64" minlength="7" 
                                pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
                                title="Ingresa una dirección de email válida." placeholder="Ingresa tu correo"
                                required class="<?= $corre_exitente ? 'input-error' : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input 
                                type="number" id="telefono" name="telefono" placeholder="Ingresa tu número telefónico"
                                pattern="^\+?[0-9]{6,15}$" 
                                title="Número telefónico válido, puede incluir prefijo internacional (+)." 
                            >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contrasena">Contraseña</label>
                            <input 
                                type="password" id="contrasena" name="contrasena" placeholder="Ingresa tu contraseña" 
                                minlength="6" title="Mínimo 6 caracteres" required
                            >
                        </div>
                        <div class="form-group">
                            <label for="password">Confirmar Contraseña</label>
                            <input 
                                type="password" id="conf_contrasena" name="conf_contrasena" placeholder="Confirma tu contraseña" 
                                minlength="6" title="Mínimo 6 caracteres" required>
                                
                            <span id="mensaje_err">Las contraseñas no coinciden</span> 
                        </div>
                        <div class="form-group">
                            <label for="cedula">Cédula</label>
                            <input 
                                type="number" id="cedula" name="cedula" placeholder="Ingresa tu cédula" 
                                pattern="^[0-9]{6,15}$" 
                                title="Solo números, entre 6 y 15 dígitos" 
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select id="rol" name="rol" required>
                                <option value="" disabled selected>Seleccione rol</option>
                                <option value="administrador">Administrador</option>
                                <option value="visualizador">Visualizador</option>
                                <option value="auditor">Auditor</option>
                                <option value="documentador">Documentador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="area">Área</label>
                            <select id="area" name="area" required>
                                <option value="" disabled selected>Seleccione área</option>
                                <option value="logistica">Logística</option>
                                <option value="contabilidad">Contabilidad</option>
                                <option value="administracion">Administración</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions" >
                        <button type="submit" class="btn-crear">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </section>
            <script src="../../../componentes/js/log/conincidir_contraseña.js"></script>
    </main>
</body>
</html>
