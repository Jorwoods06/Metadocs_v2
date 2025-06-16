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
    <link rel="stylesheet" href="../../../componentes/css/documentador/subir_documento.css">
    <script src="../../../componentes/js/admin/panel.js" defer></script>
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
                <li><a href="documentador_inicio.php"><i class="bi bi-house-door"></i>Inicio</a></li>
                <li><a href="ver_documentos.php" class="activo"><i class="bi bi-file-earmark-text"></i>Documentos</a></li>
                <li><a href="solicitudes_doc.php" ><i class="bi bi-envelope-paper"></i>Solicitudes</a></li>
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
           <h1>Subir documento</h1>

            <article id="form_contenedor">
        <form id="form_documento" action="../../backend/documentador/gestor_archivos.php" method="post" enctype="multipart/form-data">
            
            <!-- Área de subida de archivos -->
            <div id="area_division">
                <i class="bi bi-cloud-arrow-up-fill"></i>
                <h3>Arraste y suelte archivos o haga click para cargar</h3>
                <p>Formatos soportados: PDF, DOC, DOCX, XLS, XLSX</p>
                <input type="file" id="input_documento" class="input-documento" accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>
            </div>

            <!-- Vista previa de archivos -->
            <div id="vista_previa" class="vista-previa">
                <div class="archivo-preview">
                    <div class="archivo-icono">📄</div>
                    <div class="archivo-info">
                        <div class="archivo-nombre" id="nombre_archivo"></div>
                        <div class="archivo-tamano" id="tamano_archivo"></div>
                    </div>
                    <button type="button" class="btn-remover" onclick="removerArchivo()">×</button>
                </div>
            </div>

            <!-- Campos del formulario -->
            <div class="campos-formulario">
                
                <!-- Categoría -->
                <div class="grupo-campo">
                    <label class="etiqueta-campo" for="categoria">Categoría del documento *</label>
                    <select class="campo-select" id="categoria" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <option value="identificacion">Documento de Identificación</option>
                        <option value="academico">Documento Académico</option>
                        <option value="laboral">Documento Laboral</option>
                        <option value="financiero">Documento Financiero</option>
                        <option value="legal">Documento Legal</option>
                        <option value="medico">Documento Médico</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <!-- Fila de campos -->
                <div class="fila-campos">
                    <div class="grupo-campo">
                        <label class="etiqueta-campo" for="ubicacion">Ubicación *</label>
                        <select class="campo-select" id="ubicacion" name="ubicacion" required>
                            <option value="">Seleccione una ubicación</option>
                            <option value="bogota">Bogotá D.C.</option>
                            <option value="medellin">Medellín</option>
                            <option value="cali">Cali</option>
                            <option value="barranquilla">Barranquilla</option>
                            <option value="cartagena">Cartagena</option>
                            <option value="bucaramanga">Bucaramanga</option>
                            <option value="pereira">Pereira</option>
                            <option value="manizales">Manizales</option>
                            <option value="palmira">Palmira</option>
                            <option value="otra">Otra ciudad</option>
                        </select>
                    </div>

                    <div class="grupo-campo">
                        <label class="etiqueta-campo" for="estado">Estado *</label>
                        <select class="campo-select" id="estado" name="estado" required>
                            <option value="">Seleccione un estado</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="vencido">Vencido</option>
                            <option value="en_revision">En Revisión</option>
                        </select>
                    </div>

                    <div class="grupo-campo">
                        <label class="etiqueta-campo" for="prioridad">Prioridad</label>
                        <select class="campo-select" id="prioridad" name="prioridad">
                            <option value="">Seleccione prioridad</option>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                </div>


                <!-- Descripción -->
                <div class="grupo-campo">
                    <label class="etiqueta-campo" for="descripcion">Descripción</label>
                    <textarea class="campo-input" id="descripcion" name="descripcion" rows="3" placeholder="Descripción opcional del documento"></textarea>
                </div>

                <!-- Botón de envío -->
                <button type="submit" class="btn-enviar">
                    <span class="btn-texto">Subir Documento</span>
                    <span class="btn-cargando" style="display: none;">Subiendo...</span>
                </button>

            </div>

        </form>
    </article>

        </section>

    </main>
</body>
</html>
