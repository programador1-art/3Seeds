<?php 
     //conexión
    include_once("conexion_3seed.php");

    $estadopost=$_POST['estadop'];
    $tipop=$_POST['tip'];

    $consulta_csl="SELECT `municipio`, `estado` FROM `inmuebles` WHERE estado='$estadopost' AND cat_estatus_idcat_estatus=1 GROUP BY municipio ORDER BY municipio ASC"; 
    $resultado_csl = mysqli_query($con,$consulta_csl);

    // Construir opciones para el select de elementos

    if($tipop==1) $options = "<option value=''>Selecciona</option>";
    else $options = "<option value=''>Municipio</option>";
    
    while($row_csl=mysqli_fetch_assoc($resultado_csl))
    {
          $options .= "<option value='" . $row_csl['municipio'] . "'>" . $row_csl['municipio'] . "</option>"; 
    }

    
    // Devolver las opciones al cliente
     echo $options;
?>


