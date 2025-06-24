 
 <!-- este archivo es el encargado en subir informacion estadistico del backend, si se quiere subir nueva info aqui se debe poner-->

 <?php
            // Total documentos
            $query = "SELECT COUNT(*) as total FROM documentos";
            $result = mysqli_query($conn, $query);
            $totalDocs = mysqli_fetch_assoc($result)['total'];

            // Total áreas
            $query = "SELECT COUNT(DISTINCT id_area) as total FROM documentos";
            $result = mysqli_query($conn, $query);
            $totalAreas = mysqli_fetch_assoc($result)['total'];

            // Documentos activos
            $query = "SELECT COUNT(*) as total FROM documentos WHERE estado_retencion = 'activo'";
            $result = mysqli_query($conn, $query);
            $docsActivos = mysqli_fetch_assoc($result)['total'];

            // Documentos rechazados
            $query = "SELECT COUNT(*) as total FROM documentos WHERE estado = 'rechazado'";
            $result = mysqli_query($conn, $query);
            $docsRechazados = mysqli_fetch_assoc($result)['total'];
            ?>