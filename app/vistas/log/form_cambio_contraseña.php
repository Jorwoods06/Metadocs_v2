<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/form_cambio.css">
    <title>Recuperar contraseña</title>
</head>
<body>
    <main id="cuerpo">
        <form action="">
            <h1>Recuperar contraseña</h1>
            <p>Ingrese una contraseña nueva</p>

            <label for="contrasena" id="contrasena">Ingrese su nueva contraseña</label>
            <input type="password" name="contrasena" id="contrasena" maxlength="16" minlength="8" pattern="[a-zA-Z0-9]{8,16}" title="solo números y letras, pueden ser mayúsculas o minúsculas; mínimo 8 hasta máximo 16 caracteres" placeholder="Ingrese su contraseña" required >

            <label for="conf_contrasena" id="conf_contrasena">Confirmar contraseña</label>
            <input type="password" name="conf_contrasena" id="conf_contrasena" maxlength="16" minlength="8" pattern="[a-zA-Z0-9]{8,16}" title="solo números y letras, pueden ser mayúsculas o minúsculas; mínimo 8 hasta máximo 16 caracteres" placeholder="Ingrese su contraseña" required >
            
            <button type="submit">Cambiar</button>

        </form>

    </main>
</body>
</html>