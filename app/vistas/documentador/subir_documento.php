<?php 
require_once '../../helpers/verificacion_roles.php';
require_once '../../backend/documentador/gestor_archivos.php';
AutorizacionRol('documentador');

$padre_id = isset($_GET['id_expediente']) ? $_GET['id_expediente'] : 0;
$expediente_seleccionado = $padre_id;
$carpetas = obtenerExpedientes($conexion_metadocs, $padre_id, $area);
$documentos = obtenerDocumentos($conexion_metadocs, $padre_id, $area);


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
    <link rel="stylesheet" href="../../../componentes/css/documentador/subir_documento.css">
    <script src="../../../componentes/js/admin/panel.js" defer></script>
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
                <li><a href="ver_documentos.php" class="activo"><i class="fas fa-file-alt"></i>Archivos</a></li>
                <li><a href="solicitudes_doc.php" ><i class="fas fa-envelope"></i>Solicitudes</a></li>
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios" >
                        <i class="fas fa-user"></i>Documentador
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                     
                        <li><a href="info_documentador.php" ><i class="fas fa-info-circle"></i> Info documentador</a></li>
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

        <section class="contenedor-principal">
            <h1>Subir documento</h1>

            <article id="form_contenedor">
        <form id="form_documento" action="../../backend/documentador/gestor_archivos.php" method="post" enctype="multipart/form-data">
            

            <div id="area_division">
                <i class="fas fa-cloud-upload-alt"></i>
                <h3>Haga click para cargar</h3>
                <p>Formatos soportados: PDF, DOC, DOCX, XLS, XLSX</p>
                <input type="file" id="input_documento" name = "input_documento"class="input-documento" accept=".pdf,.doc,.docx,.xls,.xlsx" multiple>
            </div>


            <div id="vista_previa" class="vista-previa">
                <div class="archivo-preview">
                    <div class="archivo-icono"><i class="fas fa-file"></i></div>
                    <div class="archivo-info">
                        <div class="archivo-nombre" id="nombre_archivo"></div>
                        <div class="archivo-tamano" id="tamano_archivo"></div>
                    </div>
                    <button type="button" class="btn-remover" onclick="removerArchivo()">×</button>
                </div>
            </div>


            <div class="campos-formulario">
                
           
                <div class="grupo-campo">
                    <label class="etiqueta-campo" for="categoria">Categoría del documento *</label>
                    <select class="campo-select" id="categoria" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <option value="Estratégicos">Estratégicos</option>
                        <option value="Operativos">Operativos</option>
                        <option value="Soporte">Soporte</option>
                        <option value="Legales">Legales</option>
                        <option value="Financieros">Financieros</option>
                        <option value="Correspondencia">Correspondencia</option>
                        
                    </select>
                </div>

                <!-- Fila de campos -->
                <div class="fila-campos">
                    <div class="grupo-campo">
                        <label class="etiqueta-campo" for="ubicacion">Ubicación *</label>
                        <select class="campo-select" id="ubicacion" name="ubicacion" required>
                            <option value="">Seleccione una ubicación</option>
                            <option value="archivo">Archivo</option>
                            <option value="estante">Estante</option>
                            <option value="caja">Caja</option>
                            <option value="boveda">Boveda</option>
                            
                        </select>
                    </div>

                    <div class="grupo-campo">
                        <label class="etiqueta-campo" for="edifico">Edificio *</label>
                        <select class="campo-select" id="edificio" name="edificio" required>
                            <option value="">Seleccione un edifico</option>
                            <option value="principal">Principal</option>
                            <option value="anexo_a">Anexo-a</option>
                            <option value="anexo_b">Anexo-b</option>
                            <option value="deposito">deposito</option>
                            <option value="archivo_central">Archivo central</option>
                            
                        </select>
                    </div>

                    <div class="grupo-campo">
                        <label class="etiqueta-campo" for="piso">Piso</label>
                        <select class="campo-select" id="piso" name="piso">
                            <option value="">Seleccione el piso</option>
                            <option value="sotano">Sotano</option>
                            <option value="planta_baja">Planta baja</option>
                            <option value="primer_piso">Primer piso</option>
                            <option value="segundo_piso">Segundo piso</option>
                            <option value="tercer_piso">Tercer piso</option>
                            <option value="cuarto_piso">Cuarto piso</option>
                        </select>
                    </div>
                </div>


                <!-- Observacion -->
                <div class="grupo-campo">
                    <label class="etiqueta-campo" for="observacion">Observaciones</label>
                    <textarea class="campo-input" id="observacion" name="observacion" rows="3" placeholder="Observacion del documento"></textarea>
                </div>

                <!-- Botón de envío -->
                <button type="submit" class="btn-enviar">
                    <span class="btn-texto">Subir Documento</span>
                    <span class="btn-cargando" style="display: none;">Subiendo...</span>
                </button>

            </div>
                <input type="hidden" name="accion" value="subir_documento">
                    <input type="hidden" name="expediente_id" value="<?= $expediente_seleccionado ?>">
        </form>
    </article>

        </section>

    </main>
    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
    <script src="../../../componentes/js/auditor/subir_archivo.js"> </script>
</body>
</html>