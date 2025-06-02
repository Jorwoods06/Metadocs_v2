<?php

if ($_SERVER['REQUEST_METHOD'] != 'post'){
    echo "tu peticion ha sido rechazada";


}else{

    $correo = $_POST['correo'];
    echo $correo;
}

?>