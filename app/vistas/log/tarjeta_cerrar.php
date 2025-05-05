<?php

require_once '../../helpers/info_usuario.php';


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../componentes/css/tarjeta_cerrar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    
    
</head>
<body>
    <div class="carta">
        <div class="informacion">
          <h2><?php echo htmlspecialchars($usuario['nombres'] ?? 'Usuario');?></h2>
          <p><?php echo htmlspecialchars($usuario['correo'] ?? 'ejemplo@gmail.com'); ?></p>
        </div>
          <div class="botones">
              <button>informacion<i class="bi bi-info-circle"></i></button>
              <a href="../log/recuperacion.php"><button> Cambiar contraseña<i class="bi bi-person-fill-lock"></i></button></a>
          
              <form action="../../backend/login/cerrar_sesion.php" method="post">
              
              <button type="submit" class="cerrar"> Cerrar sesión<i class="bi bi-box-arrow-left"></i></button>
                
             </form>
          
            </div>
      </div>
      
</body>
</html>