<?php 
     //conexión

    include_once("conexion_3seed.php");

    //funcion para formatear fecha
    function fecha_bonita($fecha){
        //Recibe una fecha en formato formato aaaa-mm-dd
        $f_ant=explode(' ',$fecha);
        $f=explode('-',$f_ant[0]);
        $dia=$f[2];
        $mes=$f[1];
        $ano=$f[0];

        switch($mes)
            {
                case '1':
                $mes='enero';
                break;
            
                case '2':
                $mes='febrero';
                break;
            
                case '3':
                $mes='marzo';
                break;
            
                case '4':
                $mes='abril';
                break;
            
                case '5':
                $mes='mayo';
                break;
            
                case '6':
                $mes='junio';
                break;
            
                case '7':
                $mes='julio';
                break;
            
                case '8':
                $mes='agosto';
                break;
            
                case '9':
                $mes='septiembre';
                break;
            
                case '10':
                $mes='octubre';
                break;
            
                case '11':
                $mes='noviembre';
                break;
            
                case '12':
                $mes='diciembre';
                break;
            }

        $fecha_final=$dia." de ".$mes." del ".$ano;
        return $fecha_final;
    }



    //PAGINACIÓN
    error_reporting(E_ALL ^ E_NOTICE);

    //Cantidad de resultados por página (debe ser INT, no string/varchar)
    $cantidad_resultados_por_pagina = 30;

    //Comprueba si está seteado el GET de HTTP
    if (isset($_POST["paginacion"])) {
        //Si el GET de HTTP SÍ es una string / cadena, procede
        if (is_string($_POST["paginacion"])) {
            //Si la string es numérica, define la variable 'pagina'
             if (is_numeric($_POST["paginacion"])) {
                 //Si la petición desde la paginación es la página uno
                 //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
                 if ($_POST["paginacion"] == 1) {
                      /*header("Location: busqueda.php");
                      echo"<script language='javascript'>window.location=' busqueda.php'</script>;";           
                     die();*/
                     $pagina = $_POST["paginacion"];
                 } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
                     $pagina = $_POST["paginacion"];
                }
             } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
                  header("Location: busqueda.php");
                  echo"<script language='javascript'>window.location=' busqueda.php'</script>;";
                die();
             };
        };
    }else if (isset($_GET["paginacion"])) {
        //Si el GET de HTTP SÍ es una string / cadena, procede
        if (is_string($_GET["paginacion"])) {
            //Si la string es numérica, define la variable 'pagina'
             if (is_numeric($_GET["paginacion"])) {
                 //Si la petición desde la paginación es la página uno
                 //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
                 if ($_GET["paginacion"] == 1) {
                      /*header("Location: busqueda.php");
                      echo"<script language='javascript'>window.location=' busqueda.php'</script>;";           
                     die();*/
                     $pagina = $_GET["paginacion"];
                 } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
                     $pagina = $_GET["paginacion"];
                }
             } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
                  header("Location: busqueda.php");
                  echo"<script language='javascript'>window.location=' busqueda.php'</script>;";
                die();
             };
        };
    } else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
        $pagina = 1;
    }
 
    //echo $pagina;
    //Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
    $empezar_desde = ($pagina-1) * $cantidad_resultados_por_pagina;

    //DETERMINAMOS EL TIPO DE BÚSQUEDA
    $deciciom_where="";
    $define_entrada=0;
    //echo $_POST['ubicacion']." ".$_POST['select_cat']." ".$_POST['precio_min']." ".$_POST['precio_max'];
    
    //TIPO DE PRECIO- VENTA/RENTA
    if($_GET['tprecio']=="R"){  //renta
        $deciciom_where=" AND (opcion_idopcion=1 OR opcion_idopcion=3)";
    }else if($_GET['tprecio']=="V"){   //venta
        $deciciom_where=" AND (opcion_idopcion=2 OR opcion_idopcion=3)";
    }

    //verificamos tipo de zonna
    if($_GET['tbusqda']=="N"){

        //estado
        $consulta_est="SELECT `municipio`, `estado` FROM `inmuebles` WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 $deciciom_where GROUP BY estado ORDER BY estado ASC"; 
        $resultado_est = mysqli_query($con,$consulta_est);
        $numrows_est=mysqli_num_rows($resultado_est);

        //municipio
        $consulta_mun="SELECT `municipio`, `estado` FROM `inmuebles` WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 $deciciom_where GROUP BY municipio ORDER BY municipio ASC"; 
        $resultado_mun = mysqli_query($con,$consulta_mun);
        $numrows_mun=mysqli_num_rows($resultado_mun);

        //Consulta para TODOS LOS TIPOS DE INMUEBLE
        $consulta_inm="SELECT `idcat_tipo`, `nombre_tipo` FROM `cat_tipo` INNER JOIN inmuebles ON cat_tipo.idcat_tipo=inmuebles.cat_tipo_idcat_tipo WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 $deciciom_where GROUP BY idcat_tipo";
        $resultado_inm = mysqli_query($con,$consulta_inm);
        $numrows_inm=mysqli_num_rows($resultado_inm);

         $deciciom_where.=" AND (SELECT `zona` FROM `estados` WHERE estado=inmuebles.estado)='N'";

         $opciones_bus='<option value="" disabled>Elige una zona</option>
                    <option value="zona-norte.php" selected>Zona Norte</option>
                    <option value="zona-centro.php">Zona Centro</option>';

    }else if($_GET['tbusqda']=="C"){

        //estado
        $consulta_est="SELECT `municipio`, `estado` FROM `inmuebles` WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='C') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 $deciciom_where GROUP BY estado ORDER BY estado ASC"; 
        $resultado_est = mysqli_query($con,$consulta_est);
        $numrows_est=mysqli_num_rows($resultado_est);

        //municipio
        $consulta_mun="SELECT `municipio`, `estado` FROM `inmuebles` WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='C') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 $deciciom_where GROUP BY municipio ORDER BY municipio ASC"; 
        $resultado_mun = mysqli_query($con,$consulta_mun);
        $numrows_mun=mysqli_num_rows($resultado_mun);

        //Consulta para TODOS LOS TIPOS DE INMUEBLE
        $consulta_inm="SELECT `idcat_tipo`, `nombre_tipo` FROM `cat_tipo` INNER JOIN inmuebles ON cat_tipo.idcat_tipo=inmuebles.cat_tipo_idcat_tipo WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='C') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 $deciciom_where GROUP BY idcat_tipo";
        $resultado_inm = mysqli_query($con,$consulta_inm);
        $numrows_inm=mysqli_num_rows($resultado_inm);

        $deciciom_where.=" AND (SELECT `zona` FROM `estados` WHERE estado=inmuebles.estado)='C'";

        $opciones_bus='<option value="" disabled>Elige una zona</option>
                    <option value="zona-norte.php" >Zona Norte</option>
                    <option value="zona-centro.php" selected>Zona Centro</option>';
    }else{

        //estado
        $consulta_est="SELECT `municipio`, `estado` FROM `inmuebles` WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado) AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 GROUP BY estado ORDER BY estado ASC"; 
        $resultado_est = mysqli_query($con,$consulta_est);
        $numrows_est=mysqli_num_rows($resultado_est);

        //municipio
        $consulta_mun="SELECT `municipio`, `estado` FROM `inmuebles` WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado) AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 GROUP BY municipio ORDER BY municipio ASC"; 
        $resultado_mun = mysqli_query($con,$consulta_mun);
        $numrows_mun=mysqli_num_rows($resultado_mun);

        //Consulta para TODOS LOS TIPOS DE INMUEBLE
        $consulta_inm="SELECT `idcat_tipo`, `nombre_tipo` FROM `cat_tipo` INNER JOIN inmuebles ON cat_tipo.idcat_tipo=inmuebles.cat_tipo_idcat_tipo WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado) AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 GROUP BY idcat_tipo";
        $resultado_inm = mysqli_query($con,$consulta_inm);
        $numrows_inm=mysqli_num_rows($resultado_inm);

        $opciones_bus='<option value="" disabled selected>Elige una zona</option>
                    <option value="zona-norte.php" >Zona Norte</option>
                    <option value="zona-centro.php" >Zona Centro</option>';
    }


    

    //Consulta para el inmueble seleccionado GRAL
    $consulta_cs="SELECT `idinmuebles`, `nombre`, `descripcion`, `cat_tipo_idcat_tipo`, `opcion_idopcion`, `ubicacion`, `fecha_publicacion`, `direccion`, `colonia`, `fraccionamiento`, `municipio`, `estado`, `agentes_idagente`, `vigencia`, `cat_estatus_idcat_estatus`, `vistas`, `idempresa`,Precio,precio_renta,moneda_cat,precio_venta_basado,precio_renta_basado FROM `inmuebles` WHERE cat_estatus_idcat_estatus=1 AND agentes_idagente='".$_GET['id_gnt']."' ".$deciciom_where; 


    

        $resultado_cs1 = mysqli_query($con,$consulta_cs);
        $numrows_cs=mysqli_num_rows($resultado_cs1);


        //Obtiene el total de páginas existentes
        $total_paginas = ceil($numrows_cs / $cantidad_resultados_por_pagina); 

        //Realiza la consulta en el orden de ID ascendente (cambiar "id" por, por ejemplo, "nombre" o "edad", alfabéticamente, etc.)
        //Limitada por la cantidad de cantidad por página
        $resultado_cs = mysqli_query($con, $consulta_cs." LIMIT $empezar_desde, $cantidad_resultados_por_pagina");


        //$row_cs=mysqli_fetch_assoc($resultado_cs);
  


        //obtenemos tipo de modalidad de inmueble
        /*$consulta_top="SELECT `idopcion`, `nombre_opcion` FROM `cat_opcion` WHERE idopcion=".$row_cs['opcion_idopcion']; 
        $resultado_top = mysqli_query($con,$consulta_top);
        $row_top=mysqli_fetch_assoc($resultado_top);

        //obtenemos nombre de empresa
        $consulta_emp="SELECT `id_empresa`, `nombre`, `tel_1`, `tel_2`, `email_1`, `eimal_2`, `sitio_web`, `direccion` FROM `cat_empresa` WHERE id_empresa=".$row_cs['idempresa']; 
        $resultado_emp = mysqli_query($con,$consulta_emp);
        $row_emp=mysqli_fetch_assoc($resultado_emp);
                                               

        //obtenemos restante de dias
        $d_hoy=date('Y-m-d');
        $des_fech=explode(" ",$row_cs['fecha_publicacion']);
        $fecha1= new DateTime($des_fech[0]);
        $fecha2= new DateTime($d_hoy);
        $diff = $fecha1->diff($fecha2);

        // El resultados sera 3 dias
        $et_fecha="";
        if($diff->days==0){
            $et_fecha="Hoy";
        }else if($diff->days==1){
            $et_fecha="Hace 1 día";
        }else if($diff->days>1){
            $et_fecha="Hace ".$diff->days." días";
        }*/
                                            
    

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tenemos un lugar para ti">
  	<meta name="keywords" content="Inmobiliaria, casas, departamentos, terrenos, hogar">

    <title>3Seeds Commercial</title>

    <!-- Bootstrap -->

    <link href="css/bootstrap-4.4.1.css" rel="stylesheet" type="text/css">

	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
/*#Icono WA footer*/
.fab {
padding: 5px;
font-size: 20px;
width: 30px;
text-align: center;
text-decoration: none;
border-radius: 50%;
}

.fab:hover {
opacity: 0.9;
}

.fa-whatsapp {
background: #4CED69;
color: white;
}
.fa-whatsapp:hover {
    color: white;
}
/*#Palabras Clave*/

.product-tags a {

    float: left;

    margin-right: 5px;

    margin-bottom: 5px;

    padding: 5px 10px;

    border-radius: 2px;

    color: #a6a3ba;

    font-size: 12px;

    border: 1px solid #e8ebf3;

}

.bg-secondary-transparent {

	background-color: rgba(89, 1, 255, 0.14);

}



.bg-primary-transparent {

	background-color: rgba(241, 202, 214, 0.6);

}

	.card-body {

    -ms-flex: 1 1 auto;

    flex: 1 1 auto;

    margin: 0;

    padding: 1.5rem 1.5rem;

    position: relative;

    height: 100%;

}

.card-body {

    -ms-flex: 1 1 auto;

    flex: 1 1 auto;

    padding: 1.25rem;

}

	.mb-4, .my-4 {

    margin-bottom: 1rem !important;

}

	

	.product-slider #thumbcarousel {

    margin: 10px 0 0 0;

    padding: 0;

}



.carousel {

    position: relative;

}

.carousel {

    position: relative;

}

.carousel-inner {

    position: relative;

    width: 100%;

    overflow: hidden;

}

.carousel-inner {

    position: relative;

    width: 100%;

    overflow: hidden;

}

	

.product-slider #thumbcarousel .carousel-item {

    text-align: center;

}



.carousel-item-next, .carousel-item-prev, .carousel-item.active {

    display: block;

}

.carousel-item-next, .carousel-item-prev, .carousel-item.active {

    display: block;

}

.carousel-item {

    position: relative;

    display: none;

    -ms-flex-align: center;

    align-items: center;

    width: 100%;

    transition: -webkit-transform .6s ease;

    transition: transform .6s ease;

    transition: transform .6s ease, -webkit-transform .6s ease;

    -webkit-backface-visibility: hidden;

    backface-visibility: hidden;

    -webkit-perspective: 1000px;

    perspective: 1000px;

}

.carousel-item {

    position: relative;

    display: none;

    float: left;

    width: 100%;

    margin-right: -100%;

    -webkit-backface-visibility: hidden;

    backface-visibility: hidden;

    transition: -webkit-transform .6s ease-in-out;

    transition: transform .6s ease-in-out;

    transition: transform .6s ease-in-out,-webkit-transform .6s ease-in-out;

}

	

	.product-slider #thumbcarousel .carousel-item .thumb {

    width: 100%;

    margin: 0 2px;

    display: inline-block;

    vertical-align: middle;

    cursor: pointer;

    max-width: 137px;

}

	

	#myCarousel .list-inline {

    white-space:nowrap;

    overflow-x:auto;

}



#myCarousel .carousel-indicators {

    position: static;

    left: initial;

    width: initial;

    margin-left: initial;

}



#myCarousel .carousel-indicators > li {

    width: initial;

    height: initial;

    text-indent: initial;

}



#myCarousel .carousel-indicators > li.active img {

    opacity: 0.7;

}

.card-body {

    -ms-flex: 1 1 auto;

    flex: 1 1 auto;

    margin: 0;

    padding: 1.5rem 1.5rem;

    position: relative;

    height: 100%;

}

/*Etiquetas y palabras clave*/

.product-tags li a:hover {

    background: #60A66B;

    border-color: #60A66B;

}

.product-tags li a:hover {

    border-radius: 2px;

    color: #fff !important;

}

a:active, a:focus, a:hover {

    outline: 0;

    text-decoration: none;

}

/*termina Etiquetas y palabras clave*/

/*Color de botones*/

.btn-primary {

    color: #fff;

    background-color: #ed5151;

    border-color: #ed5151;

}

.btn-info {

    color: #fff;

    background-color: #0ab2e6;

    border-color: #0ab2e6;

}

/*Termina Color de botones*/

.sptb-1 {

    padding-top: 8.5rem;

    padding-bottom: 4.5rem;

}

/*Etiqueta oferta*/

.ribbon-top-right span {

    left: -8px;

    top: 30px;

    transform: rotate(

45deg);

}

.text-danger {

    color: 29943F !important;

}

.bg-danger {

    background-color: #29943F!important;

}

.ribbon {

    width: 150px;

    height: 150px;

    overflow: hidden;

    position: absolute;

    z-index: 10;

}

.ribbon-top-right::before {

    border-top-color: transparent;

    border-right-color: transparent;

    top: 0;

    left: 36px;

}

.ribbon::after, .ribbon::before {

    position: absolute;

    z-index: -1;

    content: '';

    display: block;

    border: 5px solid;

}

.ribbon span {

    position: absolute;

    display: block;

    width: 225px;

    padding: 8px 0;

    box-shadow: 0 5px 10px rgb(0 0 0 / 10%);

    color: #fff;

    text-shadow: 0 1px 1px rgb(0 0 0 / 20%);

    text-transform: capitalize;

    text-align: center;

}

.ribbon-top-right {

    top: -10px;

    right: -10px;

}

/*Termina etiqueta oferta*/

.carousel-item-next, .carousel-item-prev, .carousel-item.active {

    display: block;

}

/*Etiqueta precio*/

.arrow-ribbon2 {

    color: #fff;

    padding: 3px 8px;

    position: absolute;

    top: 10px;

    left: -1px;

    z-index: 98;

    font-size: 30px;

}

.bg-primary {

    background-color: #29943F !important;

}

.arrow-ribbon2:before {

    position: absolute;

    right: 0;

    top: 0;

    bottom: 0;

    content: "";

    right: -24px;

    border-top: 24px solid transparent;

    border-bottom: 24px solid transparent;

    width: 0;

}

.arrow-ribbon2:before {

    border-left: 24px solid #29943F;

}

/*Termina etiqueta precio*/

/*Iconos del titulo*/

a.icons {

    text-decoration: none;

    cursor: pointer;

}

a {

    color: #070510;

    text-decoration: none;

    background-color: transparent;

    -webkit-text-decoration-skip: objects;

}

.mr-5, .mx-5 {

    margin-right: 1.5rem !important;

}

ul {

    list-style-type: none;

    padding: 0;

    margin: 0;

}

/*Termina Iconos del titulo*/

	

.bg-transparent {

    background-color: transparent !important;

}

.search-background {

    background: #fff;

    border-radius: 3px;

    overflow: hidden;

}

	

.mb-0, .my-0 {

    margin-bottom: 0 !important;

}

.bg-white {

    background-color: #fff !important;

}

.bg-dark {

    background-color: #29943F !important;

}

.bg-background{

    background-color: #60A66B;

}

.card-footer {

  padding: 0.75rem 1.10rem;

  background-color: rgba(0, 0, 0, 0.03);

  border-top: 1px solid rgba(0, 0, 0, 0.125);

}

.profile-pic {

    text-align: center;

}

.btn-primary {

    color: #fff;

    background-color: #717CA6;

    border-color: #717CA6;

}

.btn-primary:hover {

    color: #fff;

    background-color: #7971a6;

    border-color: #7971a6;

}

.card-title {

    font-size: 1.125rem;

    line-height: 1.2;

    font-weight: 500;

    margin-bottom: 1.5rem;

}

.menu{

	font-weight: 600;

	font-size: 16px;

	}

.text-muted {

    color: #278C36 !important;

}

.footer {

    background-color: #0D0D0D;

	color:#ffffff;

	font-size: 12px;

}

.paddingf{

	 padding: 30px 50px;

	}

.facebook-bg {

    background: #3b5998;

    color: #fff;

}

.instagram-bg {

    background: #F33269;

    color: #fff;

}
.Linkedin-bg {

    background: #0A66C2;

    color: #fff;

}
.youtube-bg {

    background: #FF0000;

    color: #fff;

}

.google-bg {

    background: #c63224;

    color: #fff;

}

.item-user .item-user-icons a {

    display: inline-block;

    width: 2rem;

    height: 2rem;

    text-align: center;

    border-radius: 100px;

    line-height: 2rem;

    margin-top: .3rem;

}

.list-inline-item:not(:last-child) {

    margin-right: .5rem;

}

.btn-floating.btn-sm i {

    font-size: .96154rem;

    line-height: 36.15385px;

}

.bg-facebook {

    background: #3C5A99;

}

.bg-linkedin {

    background: #0077b5;

}

.btn-floating.btn-sm i {

    font-size: .96154rem;

    line-height: 36.15385px;

}

.btn-floating {

    width: 35px;

    height: 35px;

    line-height: 1.7;

    position: relative;

    z-index: 1;

    vertical-align: middle;

    display: inline-block;

    overflow: hidden;

    -webkit-transition: all .2s ease-in-out;

    -o-transition: all .2s ease-in-out;

    transition: all .2s ease-in-out;

    -webkit-border-radius: 50%;

    /* border-radius: 50%; */

    padding: 0;

    cursor: pointer;

    background: rgba(255, 255, 255, 0.2);

    box-shadow: 0 5px 11px 0 rgb(0 0 0 / 10%), 0 4px 15px 0 rgb(0 0 0 / 10%);

}



.ml-1, .mx-1 {

    margin-left: 0.25rem !important;

}

.btn-floating {

    width: 35px;

    height: 35px;

    line-height: 1.7;

    position: relative;

    z-index: 1;

    vertical-align: middle;

    display: inline-block;

    overflow: hidden;

    -webkit-transition: all .2s ease-in-out;

    -o-transition: all .2s ease-in-out;

    transition: all .2s ease-in-out;

    -webkit-border-radius: 50%;

    /* border-radius: 50%; */

    padding: 0;

    cursor: pointer;

    background: rgba(255, 255, 255, 0.2);

    box-shadow: 0 5px 11px 0 rgb(0 0 0 / 10%), 0 4px 15px 0 rgb(0 0 0 / 10%);

}

.btn-group-sm>.btn, .btn-sm {

    font-size: .75rem;

    min-width: 1.625rem;

}

.btn-floating i {

    display: inline-block;

    width: inherit;

    text-align: center;

    color: #fff;

}

.btn-outline-success {

    color: #000000;

    border-color: #f2f2f2;

    background: #f2f2f2;

}

.btn-outline-success:hover {

    color: #fff;

    background-color: #545b62;

    border-color: #545b62;

}

.form-control {

  display: block;

  width: 100%;

  height: calc(1.5em + 0.75rem + 12px);

  padding: 0.375rem 0.75rem;

  font-size: 1rem;

  font-weight: 400;

  line-height: 1.5;

  color: #495057;

  background-color: #fff;

  background-clip: padding-box;

  border: 1px solid #ced4da;

  border-radius: 0.25rem;

  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;

}

.iconos{

	height: 16px;

	width: 16px;

	}

.page-link {

    position: relative;

    display: block;

    padding: 0.5rem 0.75rem;

    margin-left: -1px;

    line-height: 1.25;

    color: #000000;

    background-color: #fff;

    border: 1px solid #dee2e6;

}

.page-item.active .page-link {

    z-index: 3;

    color: #fff;

    background-color: #218838;

    border-color: #218838;

}

.page-link:hover {

    z-index: 2;

    color: #10A056;

    text-decoration: none;

    background-color: #e9ecef;

    border-color: #dee2e6;

}

.KeyInformation_v2 {

    height: 48px;

    margin-bottom: 10px;

    padding: 0;

    display: flex;

    width: 100%;

}

.ListingCell-agent-redesign .ListingCell-KeyInfo-price .ListingCell-keyInfo-details, .ListingCell-agent-redesign .ListingCell-KeyInfo-price a {

    flex: 1 1 50%;

}

.KeyInformation_v2 .KeyInformation-attribute_v2 {

    font-size: 17px;

    font-weight: 700;

    margin-right: 8%;

	text-align: center;

}

.KeyInformation_v2 .KeyInformation-attribute_v2 .KeyInformation-label_v2 {

    font-size: 11px;

    color: #999;

    font-weight: 600;

    min-width: 100%;

    white-space: nowrap;

}

.KeyInformation_v2 .KeyInformation-attribute_v2 .KeyInformation-description_v2 .KeyInformation-value_v2 {

    white-space: nowrap;

    max-width: 75%;

}

.ListingCell-row .KeyInformation_v2 .KeyInformation-label_v2 {

    margin-top: 5px;

}

.img-busqueda {

    max-width: 270px;

    height: 250px;

}

.Pagination .row {

    margin: auto;

    display: flex;

}

.row:not(.expanded) .row {

    max-width: none;

}

.Pagination .nav-box, .Pagination .nav-box-center {

    display: table-cell;

}

.Pagination .next, .Pagination .previous {

    display: flex;

    justify-content: center;

    align-items: center;

    width: 50px;

    height: 37px;

    background-color: #218838;

    font-size: 18px;

}

</style>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-230519516-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-230519516-2');
</script>


  </head>

  <body>

<div>

	<div>

		<div>

			<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding-bottom: 5px;padding-top: 5px;">

			 <div class="container" style="padding-top: -20px; padding-bottom: -20px;">

			  <a class="navbar-brand" href="https://3seedscommercial.mx"><img src="../images/logo-blanco.png" alt="3Seeds Commercial" style="max-width: inherit; max-height: 60px;"></a>

			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

			  <span class="navbar-toggler-icon"></span>

			  </button>

			  <div class="collapse navbar-collapse " id="navbarSupportedContent">

				<ul class="navbar-nav mr-auto">

				  <li class="nav-item active">

					<a class="nav-link menu" href="https://3seedscommercial.mx">Inicio<span class="sr-only">(current)</span></a>

				  </li>

				 <!-- <li class="nav-item">

					<a class="nav-link menu" href="mailto:hola@3seeds.mx">Contacto</a>

				  </li> -->

				</ul>

                    <form  action="busqueda.php" method="post" class="form-inline my-2 my-lg-0" style="margin-right: 100px;">

                      <input type="text" class="form-control mr-sm-2" id="tex4" placeholder="Buscar" name="busqueda">

                    <div class="col-xl-2 col-lg-3 col-md-12 mb-0">
                    <!--<a href="#" class="btn btn-lg btn-block btn-primary br-tl-md-0 br-bl-md-0">Buscar</a>-->
                    <input type="hidden" id="tipo_bus1" name="tipo_busq1" value="0">
                    <input type="hidden" id="busquedaprin" name="busquedaprin" value="1">
                    <input type="hidden" id="tbusqda" name="tbusqda" value="<? echo $_GET['tbusqda']; ?>"> <!--zona -->
                    <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="Buscar">
                    </div>
                    </form>
			<form action="#action_page.php">
			  	<select name="zonas" id="zonas" onchange="location = this.value" style="margin-top: 20px;padding: 10px;">
			  	    <!--<option value="" disabled selected>Elige una zona</option>
                    <option value="zona-norte.php">Zona Norte</option>
					<option value="zona-centro.php">Zona Centro</option>-->
                    <? echo $opciones_bus; ?>
			  	</select>
			  <br><br>
	   		</form>
                    </div>
			  </div>

			</div>

			</nav>

		</div>	

	<div>

	<h3 class=" mt-5 mb-5 text-center">
        <?  
            $etiqueta_nombre=0;
            if($numrows_cs>1){
                $etiqueta_nombre=$numrows_cs." Resultados";
            }else{
                $etiqueta_nombre=$numrows_cs." Resultado";
            }

            $descubi="";
            if(!empty($_POST['ubicacion'])) $descubi="(".$_POST['ubicacion'].")";

            echo $etiqueta_nombre." ".$descubi; 

        ?>
    </h3>

	</div>

	</div>

    <div class="container">

    <hr>

    <section>

      <div class="">

        <div class="row">

    <div>

      <div class="row">

        <div class="col-lg-9 col-12">

          <div class="row">


<!--primer resultado-->

        <?

        //recorremos todos los resultados
        while($row_cs=mysqli_fetch_assoc($resultado_cs)){
                                                                
            //obtenemos la primera imagen del inmueble
               // $consulta_img="SELECT `idinmuebles_fotos`, `ruta_archivo`, `inmuebles_idinmuebles` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=".$row_cs['idinmuebles']." ORDER BY order_img ASC, idinmuebles_fotos ASC"; 
                $consulta_img="SELECT `idinmuebles_fotos`, `ruta_archivo`, `inmuebles_idinmuebles` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=".$row_cs['idinmuebles']." ORDER BY order_img ASC";
                $resultado_img = mysqli_query($con,$consulta_img);
                $row_img=mysqli_fetch_assoc($resultado_img);

                //validamos si existe ruta de archivo de casa/inmueble
                $etq_ruta_arch=$row_img['ruta_archivo'];
                if($row_img['ruta_archivo']==""){
                       $etq_ruta_arch="sin_imagen.png";
                } 
        ?>

        <div class="col-md-12 col-sm-12">

		<div class="card mb-3" style="max-width: 840px;">

		  <div class="row g-0">

			<div class="col-md-4 col-sm-9 offset-sm-3 col-9 offset-1 offset-xl-0">

			  <img src="aplicacion/_lib/file/img/3simg/<?  echo $etq_ruta_arch; ?>" class="img-busqueda" alt="..." height="250px" width="380px">

			</div>

			<div class="col-md-7 offset-md-1 offset-sm-1 col-sm-10 offset-1 col-11 offset-xl-0 col-xl-8">

			  <div class="card-body pt-2 pl-0 pr-3 pb-1">

				 <div class="row">

					<div class="col-12 col-lg-10 offset-lg-0 col-xl-12" style="max-width: 100%;">

					  <h4> <?  
                                $etiqueta_nombre=$row_cs['nombre'];
                                if(strlen($row_cs['nombre'])>45){
                                   $etiqueta_nombre=substr($row_cs['nombre'], 0, 42)."...";
                                }

                                echo $etiqueta_nombre; ?></h4>

					</div>

				  </div>

				 <div class="col-12 col-lg-11 offset-lg-0">

					 <p class="mb-0">

						<i class="fa fa-map-marker text-danger mr-1"></i>

							<font style="vertical-align: inherit;">

								<font style="vertical-align: inherit;"> <?  echo $row_cs['colonia'].", ".$row_cs['municipio'].", ".$row_cs['estado']; ?></font>

							</font>

					  </p>

				 </div>

						<p class="mb-0">

							<font style="vertical-align: inherit;">

								<font style="vertical-align: inherit;"><?  
 
                                $etiqueta_nombre=$row_cs['descripcion'];
                                if(strlen($row_cs['descripcion'])>110){
                                   $etiqueta_nombre=substr($row_cs['descripcion'], 0, 105)." ...";
                                }

                                echo $etiqueta_nombre; ?></font>

							</font>

						</p>

         <div class="row">

            <div class="col-lg-4 col-md-4 col-4">

				  <h5 class="font-weight-bold mb-3">

					<!--<font style="vertical-align: inherit;">-->

					     <font style="vertical-align: inherit;"><?  
              
                                //obtenemos moneda
                                //verificamos que precio mostrar
                                if($row_cs['opcion_idopcion']==1){       //renta
                                    if($row_cs['precio_renta_basado']!="Valor total"){
                                      $precio_muestreo="$ ".number_format($row_cs['precio_renta'], 0, '.', ',')." <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">".$row_cs['moneda_cat']." ".$row_cs['precio_renta_basado']."</span>";
                                    }else{
                                       $precio_muestreo="$ ".number_format($row_cs['precio_renta'], 0, '.', ',')." <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">".$row_cs['moneda_cat']." por mes</span>"; 
                                    }
                                }else if($row_cs['opcion_idopcion']==2){       //venta
                                    if($row_cs['precio_venta_basado']!="Valor total"){
                                      $precio_muestreo="$ ".number_format($row_cs['Precio'], 0, '.', ',')." <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">".$row_cs['moneda_cat']." ".$row_cs['precio_venta_basado']."</span>";
                                    }else{
                                       $precio_muestreo="$ ".number_format($row_cs['Precio'], 0, '.', ',')." <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">".$row_cs['moneda_cat']."</span>"; 
                                    }
                                }else if($row_cs['opcion_idopcion']==3){       //venta y renta

                                    $precio_mrenta="Renta: <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">$ ".number_format($row_cs['precio_renta'], 0, '.', ',')." ".$row_cs['moneda_cat']." por mes</span>"; 
                                    if($row_cs['precio_renta_basado']!="Valor total"){
                                      $precio_mrenta="Renta: <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">$ ".number_format($row_cs['precio_renta'], 0, '.', ',')." ".$row_cs['moneda_cat']." ".$row_cs['precio_renta_basado']."</span>";
                                    }
                          
                                    $precio_mventa="Venta: <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">$ ".number_format($row_cs['Precio'], 0, '.', ',')." ".$row_cs['moneda_cat']."</span>";
                                    if($row_cs['precio_venta_basado']!="Valor total"){
                                      $precio_mventa="Venta:<span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\"> $ ".number_format($row_cs['Precio'], 0, '.', ',')." ".$row_cs['moneda_cat']." ".$row_cs['precio_venta_basado']."</span>";
                                    }
                                 
                                    $precio_muestreo=$precio_mrenta."<br>".$precio_mventa;

                                }else{
                                    if($row_cs['Precio']==0){
                                        $precio_muestreo="$ ".number_format($row_cs['precio_renta'], 0, '.', ',')." <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">".$row_cs['moneda_cat']."</span>"; 
                                    }else{
                                         $precio_muestreo="$ ".number_format($row_cs['Precio'], 0, '.', ',')." <span class=\"fs-12  font-weight-normal\" style=\"font-size:16px\">".$row_cs['moneda_cat']."</span>";
                                    }
                                }

                                echo $precio_muestreo;
                        ?></font>
					<!--</font>-->

					<span class="fs-12  font-weight-normal">

						<font style="vertical-align: inherit;">

						<font style="vertical-align: inherit;"><?  
                            /*$etq_opcion="";
                            
                            if($row_cs['opcion_idopcion']==1){
                                $etq_opcion="por mes";
                            }

                             echo $etq_opcion;*/ ?>
                                 
                             </font>

						</font>

					</span>

				  </h5>

            </div>


            <!--caracteristicas-->
            <?
                //Consulta para obtener las caracteristicas
                $consulta_car="SELECT `inmuebles_caracteristicascol`, `inmuebles_idinmuebles`, `cat_caracteristicas`, `valor` FROM `inmuebles_caracteristicas` WHERE inmuebles_idinmuebles=".$row_cs['idinmuebles']." LIMIT 4"; 
                $resultado_car = mysqli_query($con,$consulta_car);

               
                while($row_car=mysqli_fetch_assoc($resultado_car)){

                //realizamos consulta para obtener descripción de caracteristica
                    $consulta_dcar="SELECT `idcat_caracteristicas`, `nombre_car`, `unidad`,logo FROM `cat_caracteristicas` WHERE idcat_caracteristicas']; 
                    $resultado_dcar = mysqli_query($con,$consulta_dcar);
                    $row_dcar=mysqli_fetch_assoc($resultado_dcar);

                     //si es superficie
                    $etiqueta="";
                    if($row_car['cat_caracteristicas']==3){
                            $etiqueta=$row_dcar['nombre_car'];
                    }else{
                          $etiqueta=$row_dcar['nombre_car'];
                    }
                                 
            ?>

                    <div class="ListingCell-keyInfo-details">
        				<div class="KeyInformation_v2">
        					<div class="KeyInformation-attribute_v2 pt-1 pl-1 pr-1">
                                 <div class="KeyInformation-description_v2">
                                       <span class="KeyInformation-value_v2 text-muted" style="font-size:13px">
                                        <img src="aplicacion/_lib/file/img/3slogo/<?  echo $row_dcar['logo']; ?>" class="iconos">
                                        <?  echo $row_car['valor']." ".$row_dcar['unidad']; ?>
                                        </span>
                                 </div>
                               	 <span class="KeyInformation-label_v2"><?  echo $etiqueta; ?></span>
                            </div>
        				</div>
        			</div>

            <?
                }                                                              
                                                        
            ?>


            <!--
            <div class="ListingCell-keyInfo-details">

				<div class="KeyInformation_v2">

					<div class="KeyInformation-attribute_v2 pt-1 pl-1 pr-1">

                         <div class="KeyInformation-description_v2">

                           <span class="KeyInformation-value_v2 KeyInformation-amenities-icon_v2 fa fa-bath text-muted">

                                3

                           </span>

                         </div>

                       	 <span class="KeyInformation-label_v2">Baños</span>

                    </div>

				</div>

			</div>

            <div class="ListingCell-keyInfo-details">

				<div class="KeyInformation_v2">

					<div class="KeyInformation-attribute_v2 pt-1 pl-1 pr-1">

                         <div class="KeyInformation-description_v2">

                           <span class="KeyInformation-value_v2 KeyInformation-amenities-icon_v2 fa fa-car text-muted">

                                1

                           </span>

                         </div>

                       	 <span class="KeyInformation-label_v2">Estacionamiento</span>

                    </div>

				</div>

			</div>

            -->

          </div>

				<div class="container-fluid h-100 pt-2 pb-3"> 

					<div class="row w-100 align-items-center">

						<div class="col text-center col-11 offset-1 offset-xl-0 col-xl-5">

							<a href="https://3seedscommercial.mx/interna.php?inm_ax=<?  echo $row_cs['idinmuebles']; ?>"><button class="btn btn-success regular-button">Más información</button></a>

						</div>	

					</div>

				</div>

			  </div>

			</div>

		  </div>

		</div>

        </div>

  <?

          //end while
       }

       //no hay registros
       if($numrows_cs==0){
           echo "
        		<div class=\"col-md-12 col-sm-12\">
		<div class=\"card mb-3\" style=\"max-width: 840px;\">
		  <div class=\"row g-0 mb-5 mt-5\">
			<div class=\"offset-xl-0 col-xl-12 offset-lg-0 col-lg-12 offset-md-0 col-md-12 offset-sm-0 col-sm-12 offset-0 col-12\">
			  <img src=\"https://3seedscommercial.mx/images/sin_resultados.png\" class=\"img-busqueda\" style=\"display:block; margin-left: auto; margin-right: auto;\" alt=\"...\" height=\"250px\" width=\"380px\">
			</div>
			<div class=\"offset-1 col-11 offset-xl-0 col-xl-12 offset-lg-0 col-lg-12 offset-md-0 col-md-12 offset-sm-0 col-sm-12\">
			  <div class=\"card-body pt-2 pl-0 pr-3 pb-1\">
				 <div class=\"row\">
					<div class=\"col-12 offset-lg-0 col-xl-12 col-lg-12\">
					  <h4 style=\"text-align: center;\">No encontramos ningún resultado para tu búsqueda.</h4>
					</div>
				  </div>
				 <div class=\"col-12 offset-lg-0 col-xl-12 col-lg-12\">
					 <p class=\"mb-0\" style=\"text-align: center;\">
						<i class=\"fa fa-search text-danger mr-1\"></i>
						<font size=\"5\">Realiza una nueva búsqueda.</font>
					 </p>
				 </div>
			  </div>
			</div>
		  </div>
		</div>
        </div>   
           <div class=\"col-md-12 col-sm-12\"> </div>";
       }
                                                                
            
?>




<!--Paginación-->

<div class="col-12 mt-5 mb-5 col" style="display: flex; justify-content: center;">
    <div class="BaseSection Pagination">

                 <?php
                    //Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
                    //Nota: X = $total_paginas
                    /*$mas_cinco=$pagina+5;
                    if($total_paginas<$mas_cinco){
                           $mas_cinco=$total_paginas;
                    }*/

                    if($pagina==1){
                       $pg_actual=1;
                    }else{
                        $pg_actual=$pagina-1;
                    }

                     if($pagina==$total_paginas){
                       $pg_siguiente=$pagina;
                    }else{
                        $pg_siguiente=$pagina+1;
                    }

                    if($total_paginas==0){
                       $pg_siguiente=0;
                       $pg_actual=0;
                    }
                       

              ?>
            <form action="busqueda.php" method="post" name="formevent2" id="formevent2">
                <div class="row">
                   
                    <div class="nav-box">                                    
                        <div class="previous">
                        <?php
                              //echo "<a data-previous-page=\"2\" href=\"?paginacion=".$pg_actual."\">";
                              //echo "<a data-previous-page=\"2\" href=\"#\" onclick=\"document.getElementById('formevent2').submit();\">";

                               echo "<a data-previous-page=\"2\" href=\"#\" onclick=\"document.getElementById('paginacion').value =".$pg_actual.";
        document.getElementById('formevent2').submit();\">";
                      
                         ?> 

                            <span class="icon-chevron-left" style="color: white;"></span>

                             </a>

                        </div>
                    </div> <!--nav-box-->

                    <div class="">
                        <div class="form-group row">
                          <select class="form-control" name="paginacion" id="paginacion" style="height: 40px;" onchange="this.form.submit()">

                            <?php
                              for ($i=1; $i<=$total_paginas; $i++) {

                                if($i==$pagina){
                                        echo "<option value=\"".$i."\" selected>Página ".$i."</option>";
                                 }else{
                                       echo "<option value=\"".$i."\">Página ".$i."</option>";
                                 }
                              }
                            ?>                 

                          </select>
                        </div>
                    </div> <!-- -->

                    <div class="nav-box">             
                        <div class="next">

                            <?php
                                  //echo "<a data-next-page=\"2\" href=\"?paginacion=".$pg_siguiente."\">";
                                 // echo "<a data-next-page=\"2\" href=\"#\" onclick=\"document.getElementById('formevent2').submit();\">";
                                  echo "<a data-next-page=\"2\" href=\"#\" onclick=\"document.getElementById('paginacion').value =".$pg_siguiente.";
            document.getElementById('formevent2').submit();\">";
                          
                             ?> 

                                 <span class="icon-chevron-right" style="color: white;"></span>

                            </a>

                        </div>
                    </div>  <!--nav-box-->

                    <input type="hidden" id="tipo_busq" name="tipo_busq" value="2">
                    <input type="hidden" id="ubicacion" name="ubicacion" value="<?php echo $_POST['ubicacion'];?>">
                    <input type="hidden" id="municipiop" name="municipiop" value="<?php echo $_POST['municipiop'];?>">
                    <input type="hidden" id="select_cat" name="select_cat" value="<?php echo $_POST['select_cat'];?>">
                    <input type="hidden" id="precio_min" name="precio_min" value="<?php echo $_POST['precio_min'];?>">
                    <input type="hidden" id="precio_max" name="precio_max" value="<?php echo $_POST['precio_max'];?>">
                    <input type="hidden" id="recamara" name="recamara" value="<?php echo $_POST['recamara'];?>">
                    <input type="hidden" id="tbusqda" name="tbusqda" value="<?php echo $_POST['tbusqda'];?>">
                    <input type="hidden" id="tprecio" name="tprecio" value="<?php echo $_POST['tprecio'];?>">
                    <input type="hidden" id="busquedaprin" name="busquedaprin" value="<?php echo $_POST['busquedaprin'];?>">
                    
              </form>

                </div>

            </div>

            <?php
                     
                 //}
            ?> 
     </div>
<!--Paginación-->


		</div>

        </div>

        <hr>




<!--barra de busqueda -------------------------------------------------------------------------------------------------------->

        <div class="col-lg-3 col-12">

          <div class="row mx-0">

            <div class="col-12 card bg-light mx-auto">

              <h3 class="text-center card-header">Encuentra tu mejor opción&nbsp;</h3>

              <form class="card-body" action="busqueda.php" method="post" name="formevent">

                <div class="form-group row">

                  <label for="location1" class="col-form-label">Estado</label>   <!-- antes ubicación-->

                  <!--<input type="text" class="form-control" id="ubicacionfrom" aria-describedby="basic-addon1" name="ubicacion">-->
                  <select class="form-control" id="ubicacionfrom" aria-hidden="true" name="ubicacion" onchange="actualizarElementos()">
                        <option selected="selected" value="">Selecciona</option>
                            <?
                                //Consulta para las estados
                                /*$consulta_csl="SELECT `municipio`, `estado` FROM `inmuebles` WHERE municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 GROUP BY estado ORDER BY estado ASC"; 
                                $resultado_csl = mysqli_query($con,$consulta_csl);
                                $numrows_csl=mysqli_num_rows($resultado_csl);*/
                                if($numrows_est!=0)
                                {
                                    while($row_est=mysqli_fetch_assoc($resultado_est))
                                    {
                                            echo "<option ".( $idubicacion == $row_est['estado'] ? "selected=\"selected\"" : "" )." value=\"".$row_est['estado']."\">".$row_est['estado']."</option>";
                                    }
                                }
                            ?>
                    </select>
                </div>



                <div class="form-group row">

                  <label for="location1" class="col-form-label">Municipio</label>   

                  <!--<input type="text" class="form-control" id="ubicacionfrom" aria-describedby="basic-addon1" name="ubicacion">-->
                    <select class="form-control" id="municipiofrom" aria-hidden="true" name="municipiop">
                            <option selected="selected" value="">Selecciona</option>
                            <?
                                //Consulta para los municipios
                                /*$consulta_csl="SELECT `municipio`, `estado` FROM `inmuebles` WHERE municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 GROUP BY municipio ORDER BY municipio ASC"; 
                                $resultado_csl = mysqli_query($con,$consulta_csl);
                                $numrows_csl=mysqli_num_rows($resultado_csl);*/
                                if($numrows_mun!=0)
                                {
                                    while($row_mun=mysqli_fetch_assoc($resultado_mun))
                                    {
                                        echo "<option ".( $idmunicipio == $row_mun['municipio'] ? "selected=\"selected\"" : "" )." value=\"".$row_mun['municipio']."\">".$row_mun['municipio']."</option>";
                                    }
                                }
                            ?>
                    </select>


                </div>



                <div class="form-group row">

                  <label for="inmueble" class="col-form-label">Tipo de inmueble</label>

                  <select class="form-control" id="inmueble" name="select_cat">

                     <option selected="selected" value="">Selecciona</option>

                    <?
                        //Consulta para las categorias
                        /*$consulta_cs="SELECT `idcat_tipo`, `nombre_tipo` FROM `cat_tipo`"; 
                        $resultado_cs = mysqli_query($con,$consulta_cs);
                        $numrows_cs=mysqli_num_rows($resultado_cs);*/

                         if($numrows_inm!=0)
                         {
                            while($row_inm=mysqli_fetch_assoc($resultado_inm))
                            {
                                echo "<option ".( $idestado == $row_inm['idcat_tipo'] ? "selected=\"selected\"" : "" )." value=\"".$row_inm['idcat_tipo']."\">".$row_inm['nombre_tipo']."</option>";
                            }
                        }
                    ?>				  

                  </select>

                </div>

                <div class="form-group row">

                  <label for="recamara" class="col-form-label">Recámaras</label>

                  <select class="form-control" name="recamara" id="recamara" >
                    <option value="">Selecciona</option>   
                    <option value="1">1</option>            
      				<option value="2">2</option>
      				<option value="3">3</option>
      				<option value="4">4</option>
                    <option value="5">5</option> 
                    <option value="6">6</option> 					  
                  </select>

                </div>

                <div class="form-group row">

                  <label for="pricefrom" class="col-form-label">Precio mínimo</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text" id="basic-addon1">$</div>
                    </div>
                    <input type="text" class="form-control" id="pricefrom" aria-describedby="basic-addon1" name="precio_min">
                  </div>

                </div>

                <div class="form-group row">

                  <label for="priceto" class="col-form-label">Precio máximo</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text" id="basic-addon2">$</div>
                    </div>
                    <input type="text" class="form-control" id="priceto" aria-describedby="basic-addon2" name="precio_max">

                  </div>

                </div>
                <input type="hidden" id="tipo_bus" name="tipo_busq" value="2">
                <input type="hidden" id="tbusqda" name="tbusqda" value="<?php echo $_POST['tbusqda'];?>">
                <input type="hidden" id="tprecio" name="tprecio" value="<?php echo $_POST['tprecio'];?>">
                <p class="text-center"><input type="submit" class="btn btn-dark" value="Buscar"> </p>

              </form>

            </div>

          </div>

        </div> <!--barra de busqueda-->	

      </div>

    </div>

        </div>

      </div>

    </section>

    <hr>

</div>

<!--footer-->

	<footer>

    <div class="footer">

      <div class="row col-12">

        <div class="col-md-8 col-12">

          <div class="row">

            <div class="col-lg-6 col-12 paddingf">

              <h3>Nosotros</h3>

              <hr>

				  <p>3Seeds Commercial es una empresa vanguardista, con gran experiencia y dinamismo; nace con el enfoque de conectar una extensa gama de servicios inmobiliarios.
                    Nuestra meta es crear valor para nuestros clientes e inversionistas a través de soluciones inmobiliarias integrales en la renta, venta, desarrollo y búsquedas especializadas; en el sector residencial, oficinas, industrial y comercial; logrando proyectos patrimoniales, rentables y exitosos.</p>

            </div>

            <div class="col-lg-6 col-12 paddingf">

              <h3>Contacto</h3>

 				<hr>

				  <div>

					  <div>

                        <?
                        if($_GET['tbusqda']=="N"){   //zona norte
                         ?>
                              <h6><span><i class="fa fa-map-marker mr-2 mb-2"></i></span><a href="#" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nuevo León, México</font></font></a></h6>

                              <h6><span><i class="fa fa-envelope mr-2 mb-2"></i></span><a href="mailto:hola@3seeds.mx" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> hola@3seeds.mx</font></font></a></h6>

                              <h6><span><i class="fa fa-phone mr-2  mb-2"></i></span><a href="tel:8125120161" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> +52 81 2512 0161</font></font></a>&nbsp;&nbsp;<a class="fab fa fa-whatsapp" href="https://wa.me/528125120161" target="_blank"></a></h6>

                             <!-- <h6><span class="font-weight-semibold"><i class="fa fa-link mr-2 "></i></span><a href="#" class="text-body"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">http://spruko.com/</font></font></a></h6>-->

                         <?
                         }else{   //zona centro y otros
                         ?>


						  <h6><span><i class="fa fa-map-marker mr-2 mb-2"></i></span><a href="#" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Querétaro, México</font></font></a></h6>

						  <h6><span><i class="fa fa-envelope mr-2 mb-2"></i></span><a href="mailto:hola@3seeds.mx" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> hola@3seeds.mx</font></font></a></h6>

						  <h6><span><i class="fa fa-phone mr-2  mb-2"></i></span><a href="tel:4422448774" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> +52 442 244 8774</font></font></a>&nbsp;&nbsp;<a class="fab fa fa-whatsapp" href="https://wa.me/524422448774" target="_blank"></a></h6>

						 <!-- <h6><span class="font-weight-semibold"><i class="fa fa-link mr-2 "></i></span><a href="#" class="text-body"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">http://spruko.com/</font></font></a></h6>-->

                        <?
                            }
                         ?>


					  </div>

				  </div>

            </div>

          </div>

        </div>

        <div class="col-md-4 col-12 mt-md-0 mt-2 paddingf">

          <h3>Redes Sociales</h3>

          <hr>

							<ul class="list-unstyled list-inline mt-3">

					<li class="list-inline-item">

						<a class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light" href="https://www.facebook.com/3SeedsCommercial" target="_blank">

							<i class="fa fa-facebook bg-facebook"></i>

						</a>

					</li>

					<li class="list-inline-item">

						<a class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light" href="https://www.instagram.com/3seedscommercial/" target="_blank">

							<i class="fa fa-instagram instagram-bg"></i>

						</a>

					</li>
					<li class="list-inline-item">

						<a class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light" href="https://www.linkedin.com/company/3seeds-commercial/" target="_blank">

							<i class="fa fa-linkedin Linkedin-bg"></i>

						</a>

					</li>
					<li class="list-inline-item">

						<a class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light" href="https://www.youtube.com/@3SeedsCommercial" target="_blank">

							<i class="fa fa-youtube-play youtube-bg"></i>

						</a>

					</li>

				</ul>

        </div>

      </div>

    </div>

      <div class="container">

        <div class="row">

          <div class="col-12 text-center"> 

            <p class="mt-2 mb-0">Copyright © 3seeds Commercial. All rights reserved.</p>

          </div>

        </div>

      </div>

    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <script src="https://3seedscommercial.mx/js/jquery-3.4.1.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script src="https://3seedscommercial.mx/js/popper.min.js"></script>

    <script src="https://3seedscommercial.mx/js/bootstrap-4.4.1.js"></script>
    
     <script>
        function actualizarElementos() {
            var categoriaSeleccionada = $('#ubicacionfrom').val();
            var elementoSelect = $('#municipiofrom');

            // Realizar una solicitud AJAX para obtener datos de MySQL
            $.ajax({
                type: 'POST',
                url: 'obtener_elementos.php', // Ruta al archivo PHP que manejará la consulta a la base de datos
                data: { estadop: categoriaSeleccionada, tip:1 },
                success: function(data) {
                    // Limpiar y llenar el segundo select con los datos obtenidos
                    elementoSelect.empty().append(data);
                }
            });
        }
    </script>


  </div>



</body>

</html>



