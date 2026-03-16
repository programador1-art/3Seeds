<?php
//conexión
include_once("conexion_3seed.php");
$idinmueble_aux = isset($_GET['inm_ax']) ? intval($_GET['inm_ax']) : 0;
if ($idinmueble_aux <= 0) {
    header('Location: busqueda.php');
    exit;
}
// Función para escapar salida HTML y prevenir XSS
function esc($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}
$hoy = date("Y-m-d");
$id_p = $idinmueble_aux;
//funcion para formatear fecha
function fecha_bonita($fecha)
{
    //Recibe una fecha en formato formato aaaa-mm-dd
    $f_ant = explode(' ', $fecha);
    $f = explode('-', $f_ant[0]);
    $dia = $f[2];
    $mes = $f[1];
    $ano = $f[0];
    switch ($mes) {
        case '1':
            $mes = 'enero';
            break;

        case '2':
            $mes = 'febrero';
            break;

        case '3':
            $mes = 'marzo';
            break;

        case '4':
            $mes = 'abril';
            break;

        case '5':
            $mes = 'mayo';
            break;

        case '6':
            $mes = 'junio';
            break;

        case '7':
            $mes = 'julio';
            break;

        case '8':
            $mes = 'agosto';
            break;

        case '9':
            $mes = 'septiembre';
            break;

        case '10':
            $mes = 'octubre';
            break;

        case '11':
            $mes = 'noviembre';
            break;

        case '12':
            $mes = 'diciembre';
            break;
    }
    $fecha_final = $dia . " de " . $mes . " del " . $ano;
    return $fecha_final;
}
//Consulta para el inmueble seleccionado
$consulta_cs = "SELECT `idinmuebles`, `nombre`, `descripcion`, `cat_tipo_idcat_tipo`, `opcion_idopcion`, `ubicacion`,`ubicacion_google`, `fecha_publicacion`, `direccion`, `colonia`, `fraccionamiento`, `municipio`, `estado`, `agentes_idagente`, `vigencia`, `cat_estatus_idcat_estatus`, `vistas`, `idempresa`,Precio,superficie_terreno,superficie_construccion,precio_renta,meta_tags,codigo_postal,moneda_cat,precio_venta_basado,precio_renta_basado FROM `inmuebles` WHERE idinmuebles=" . $idinmueble_aux;
$resultado_cs = mysqli_query($con, $consulta_cs);
$numrows_cs = mysqli_num_rows($resultado_cs);
$row_cs = mysqli_fetch_assoc($resultado_cs);
$consulta_vis = "UPDATE inmuebles SET vistas=vistas+1 WHERE idinmuebles=" . $idinmueble_aux;
mysqli_query($con, $consulta_vis);

//obtenemos la primera imagen del inmueble
//$consulta_img0="SELECT `idinmuebles_fotos`, `ruta_archivo`, `inmuebles_idinmuebles` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=".$row_cs['idinmuebles']." ORDER BY order_img ASC, idinmuebles_fotos ASC";
$consulta_img0 = "SELECT `idinmuebles_fotos`, `ruta_archivo`, `inmuebles_idinmuebles` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . " ORDER BY order_img ASC";
$resultado_img0 = mysqli_query($con, $consulta_img0);
$numrows_img0 = mysqli_num_rows($resultado_img0);
$row_img0 = mysqli_fetch_assoc($resultado_img0);

if ($numrows_img0 > 0) {
    $img_principal = "https://" . $_SERVER['SERVER_NAME'] . "/aplicacion/_lib/file/img/3simg/" . $row_img0['ruta_archivo'];
} else {
    $img_principal = "https://" . $_SERVER['SERVER_NAME'] . "/aplicacion/_lib/file/img/3simg/sin_imagen.png";
}


//palabras clave
$palabraclav = "Inmobiliaria, casas, departamentos, terrenos, hogar, " . $row_cs['nombre'];
if ($row_cs['meta_tags'] != "") {
    $palabraclav = $row_cs['meta_tags'];
}


//ubicaciones
$armadoenlace = "https://maps.google.com/?q=" . str_replace(" ", "+", $row_cs['direccion']) . ", " . str_replace(" ", "+", $row_cs['colonia']) . ", " . str_replace(" ", "+", $row_cs['municipio']) . ", " . str_replace(" ", "+", $row_cs['estado']) . ", CP+" . str_replace(" ", "+", $row_cs['codigo_postal']);

//$mapa_google ='<a class="button2" href="'.$armadoenlace.'" target="_blank">Ver Mapa en Maps</a>';

//verificamos la zona del inmueble
$consulta_zona = "SELECT `zona` FROM `estados` WHERE estado='" . $row_cs['estado'] . "'";
$resultado_zona = mysqli_query($con, $consulta_zona);
$row_zona = mysqli_fetch_assoc($resultado_zona);

if ($row_zona['zona'] == "N") {   //zona norte
    $opciones_bus = '<option value="" disabled>Elige una zona</option>
                    <option value="principal.php" selected>Zona Norte</option>
                    <option value="zona-centro.php">Zona Centro</option>';
    $numwat = "528125120161";
} else if ($row_zona['zona'] == "C") {   //zona centro
    $opciones_bus = '<option value="" disabled>Elige una zona</option>
                    <option value="principal.php" >Zona Norte</option>
                    <option value="zona-centro.php" selected>Zona Centro</option>';
    $numwat = "524422448774";
} else {
    $opciones_bus = '<option value="" disabled selected>Elige una zona</option>
                    <option value="principal.php" >Zona Norte</option>
                    <option value="zona-centro.php">Zona Centro</option>';
    $numwat = "";
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index">

    <!-- Meta Tags Principales -->
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="apple-touch-icon" href="images/logo.png">
    <title>3Seeds Commercial</title>
    <meta name="title" content="<?= esc($row_cs['nombre']); ?>" />
    <!--Descripción de la página no mayor a 155 caracteres-->
    <meta name="description" content="<?= esc($row_cs['descripcion']); ?>" />
    <!--Aquí deben ir las palabras claves -->
    <meta name="keywords" content="<?= esc($palabraclav); ?>">
    <!--Aquí deben ir las palabras claves <meta name="keywords" content="Inmobiliaria, casas, departamentos, terrenos, hogar">-->
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url"
        content="https://3seedscommercial.mx/interna.php?inm_ax=<?= $row_cs['idinmuebles']; ?>" />
    <meta property="og:title" content="3Seeds Commercial | <?= esc($row_cs['nombre']); ?>" />
    <meta property="og:description" content="<?= esc($row_cs['descripcion']); ?>" />
    <!-- aquí debe hacer referencia la imagen destacada -->
    <meta property="og:image" content="<?= $img_principal; ?>" />
    <meta property="og:image:width" content="800" /><!-- Importante -->
    <meta property="og:image:height" content="418" /><!-- Importante -->
    <meta property="fb:app_id" content="1298752174093559" />
    <meta property="fb:admins" content="3SeedsCommercial" />

    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="3Seeds Commercial | <?= esc($row_cs['nombre']); ?>">
    <meta itemprop="description" content="<?= esc($row_cs['descripcion']); ?>">
    <meta itemprop="image" content="<?= $img_principal; ?>">
    <meta property="image:width" content="800" /><!-- Importante -->
    <meta property="image:height" content="418" /><!-- Importante -->

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url"
        content="https://3seedscommercial.mx/interna.php?inm_ax=<?= $row_cs['idinmuebles']; ?>" />
    <meta property="twitter:title" content="3Seeds Commercial | <?= esc($row_cs['nombre']); ?>" />
    <meta property="twitter:description" content="<?= esc($row_cs['descripcion']); ?>" />
    <!-- aquí debe hacer referencia la imagen destacada -->
    <meta property="twitter:image" content="<?= $img_principal; ?>" />
    <!-- Fin Meta Tags-->

    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
        type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Scripts Base (jQuery primero, luego plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>

    <!-- Plugins de Galería e Isotope -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>

    <!-- Slick Carousel -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <style>
        /* Similar Properties Styles */
        .similar-properties-section {
            padding: 60px 0;
            background: #fdfdfd;
        }

        .section-title-premium {
            font-size: 2.2rem;
            font-weight: 900;
            color: #1e272e;
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
        }

        .section-title-premium::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 60px;
            height: 4px;
            background: #4eed6b;
            border-radius: 2px;
        }

        .property-card-premium {
            margin: 15px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #f0f0f0;
        }

        .property-card-premium:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .card-img-container {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .property-card-premium:hover .card-img-container img {
            transform: scale(1.1);
        }

        .modality-badge-premium {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(30, 39, 46, 0.85);
            color: #fff;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(5px);
            z-index: 1;
        }

        .card-content-premium {
            padding: 20px;
        }

        .card-content-premium h4 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 10px;
            height: 2.6em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .card-content-premium .location {
            font-size: 13px;
            color: #95a5a6;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .card-content-premium .location i {
            margin-right: 6px;
            color: #4eed6b;
        }

        .card-price-premium {
            font-size: 1.2rem;
            font-weight: 900;
            color: #1e272e;
            border-top: 1px solid #f5f5f5;
            padding-top: 15px;
        }

        /* Nav Arrows */
        .slick-prev,
        .slick-next {
            width: 45px;
            height: 45px;
            background: #fff !important;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 2;
            transition: all 0.3s;
        }

        .slick-prev:before,
        .slick-next:before {
            color: #1e272e;
            font-size: 20px;
        }

        .slick-prev {
            left: -22px;
        }

        .slick-next {
            right: -22px;
        }

        .slick-prev:hover,
        .slick-next:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /*#Icono WA footer*/
        .wa-icon {
            padding: 5px;
            font-size: 20px;
            width: 30px;
            height: 30px;
            text-align: center;
            text-decoration: none;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
        }

        .wa-icon:hover {
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

        .mb-4,
        .my-4 {
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
            height: 90px !important;
            overflow: hidden;
        }

        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 0;
            bottom: 0;
            z-index: 1;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 6%;
            color: #fff;
            text-align: center;
            opacity: 0.6;
            transition: opacity 0.15s ease;
            background-color: rgb(41 148 63);
        }

        .carousel-control-prev2,
        .carousel-control-next2 {
            position: absolute;
            top: 0;
            bottom: 0;
            z-index: 1;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 6%;
            color: #212529;
            text-align: center;
            opacity: 0.5;
            transition: opacity 0.15s ease;
        }

        .product-slider #thumbcarousel .carousel-item {
            text-align: center;
        }

        .carousel-item-next,
        .carousel-item-prev,
        .carousel-item.active {
            display: block;
        }

        .carousel-item-next,
        .carousel-item-prev,
        .carousel-item.active {
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

        .product-slider .carousel-item img {
            width: 100%;
            height: auto;
        }

        @media (min-width: 992px) and (max-width: 1300px) .product-slider #thumbcarousel .carousel-item .thumb {
            max-width: 85px !important;
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
            transition: transform .6s ease-in-out, -webkit-transform .6s ease-in-out;
        }

        .product-slider #thumbcarousel .carousel-item .thumb {
            width: 100%;
            margin: 0 2px;
            display: inline-block;
            vertical-align: middle;
            cursor: pointer;
            max-width: 137px;
        }

        .thumb {
            width: 100%;
            margin: 0 2px;
            display: inline-block;
            vertical-align: middle;
            cursor: pointer;
            max-width: 150px;
            max-height: 100px;
            background-image: cover;
            object-position: center center;
        }

        #myCarousel .list-inline {
            white-space: nowrap;
            overflow-x: auto;
        }

        #myCarousel .carousel-indicators {
            position: static;
            left: initial;
            width: initial;
            margin-left: initial;
        }

        #myCarousel .carousel-indicators>li {
            width: initial;
            height: initial;
            text-indent: initial;
        }

        #myCarousel .carousel-indicators>li.active img {
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

        a:active,
        a:focus,
        a:hover {
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
            transform: rotate(45deg);
        }

        .text-danger {
            color: 29943F !important;
        }

        .bg-danger {
            background-color: #29943F !important;
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

        .ribbon::after,
        .ribbon::before {
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
        .carousel-item-next,
        .carousel-item-prev,
        .carousel-item.active {
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

        .mr-5,
        .mx-5 {
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

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .bg-white {
            background-color: #fff !important;
        }

        .bg-dark {
            background-color: #29943F !important;
        }

        .bg-background {
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

        /* Sticky Sidebar Styles */
        .sticky-sidebar {
            position: sticky;
            top: 100px;
            z-index: 10;
            padding-bottom: 100px;
            /* Space for scrolling */
        }

        .contact-card-sidebar {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 25px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .agent-info-compact {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .agent-info-compact img {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 18px;
            border: 3px solid #4eed6b;
            box-shadow: 0 4px 10px rgba(78, 237, 107, 0.3);
        }

        .agent-details h5 {
            margin: 0;
            font-weight: 800;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .agent-details p {
            margin: 0;
            font-size: 13px;
            color: #7f8c8d;
        }

        .contact-form-sidebar .form-control {
            border-radius: 8px;
            border: 1px solid #dfe6e9;
            margin-bottom: 12px;
            padding: 12px;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: all 0.2s;
        }

        .contact-form-sidebar .form-control:focus {
            background-color: #fff;
            border-color: #4eed6b;
            box-shadow: 0 0 0 3px rgba(78, 237, 107, 0.1);
        }

        .sidebar-btn-email {
            background: linear-gradient(135deg, #636e72 0%, #2d3436 100%);
            color: white;
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-btn-whatsapp {
            background: linear-gradient(135deg, #4eed6b 0%, #4eed6b 100%);
            color: white;
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
        }

        .sidebar-btn-email:hover,
        .sidebar-btn-whatsapp:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            opacity: 1;
            color: white;
        }

        .sidebar-btn-email i,
        .sidebar-btn-whatsapp i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .header-section {
            padding: 30px 0;
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
        }

        .header-section h1 {
            font-size: 32px;
            font-weight: 900;
            color: #1e272e;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .header-meta {
            display: flex;
            gap: 25px;
            color: #808e9b;
            font-size: 15px;
            font-weight: 500;
        }

        .header-meta span i {
            color: #2ecc71;
        }

        /* Hide price ribbon temporarily */
        .arrow-ribbon2 {
            display: none !important;
        }

        .btn-primary2 {
            color: #fff;
            background-color: #29943F;
            border-color: #29943F;
        }

        .btn-primary2:hover {
            color: #fff;
            background-color: #29943e;
            border-color: #29943e;
        }

        .card-title {
            font-size: 1.125rem;
            line-height: 1.2;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .menu {
            font-weight: 600;
            font-size: 16px;
            color: #fff;
        }
        .menu:hover {
            color: #fff;
        }
        .navbar-dark .navbar-nav .nav-link.menu {
            color: #fff !important;
            opacity: 1;
        }
        .navbar-dark .navbar-nav .nav-link.menu:hover,
        .navbar-dark .navbar-nav .nav-link.menu:focus {
            color: #fff !important;
            opacity: 1;
        }

        .text-muted {
            color: #278C36 !important;
        }

        .footer {
            background-color: #0D0D0D;
            color: #ffffff;
            font-size: 12px;
        }

        .paddingf {
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

        .ml-1,
        .mx-1 {
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

        .btn-group-sm>.btn,
        .btn-sm {
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

        .avatar-xxl {
            width: 130px;
            height: auto;
            line-height: 5rem;
            font-size: 2rem;
            clip-path: circle(35%);
            padding-top: 5px;

        }

        .brround {
            border-radius: 50%;
        }

        /*CSS para botón de compartir*/

        .mt-100 {
            margin-top: 100px
        }

        /*
.modal {
    background-image: linear-gradient(rgb(35, 79, 71) 0%, rgb(36, 121, 106) 100.2%)
}
*/
        .modal-title {
            font-weight: 900
        }

        .modal-content {
            border-radius: 13px
        }

        .modal-body {
            color: #3b3b3b
        }

        .img-thumbnail {
            border-radius: 33px;
            width: 61px;
            height: 61px
        }

        .fab:before {
            position: relative;
            top: 13px
        }

        .smd {
            width: 200px;
            font-size: small;
            text-align: center
        }

        .modal-footer {
            display: block
        }

        .ur {
            border: none;
            background-color: #e6e2e2;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px
        }

        .cpy {
            border: none;
            background-color: #e6e2e2;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
            cursor: pointer
        }

        button.focus,
        button:focus {
            outline: 0;
            box-shadow: none !important
        }

        .ur.focus,
        .ur:focus {
            outline: 0;
            box-shadow: none !important
        }

        .message {
            font-size: 11px;
            color: #ee5535
        }

        /* FIN CSS para botón de compartir*/
        .icon {
            width: 40px;
            height: 40px;
            padding: 3px;
        }

        .fcc-btn {
            color: white;
        }

        .fcc-btn:hover {
            color: white;
        }

        .box {
            width: 100%;
            height: auto !important;
            background: #ffffff;
            overflow: hidden;
        }

        .box img {
            width: 100%;
            max-width: 100%;
            max-height: 500px;
            min-height: 300px;
        }

        @supports(object-fit: contain) {
            .box img {
                height: 100%;
                object-fit: contain;
                object-position: center center;
            }
        }

        .caja {
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;
            background: #333944;
        }

        .img-fluid {
            max-width: 100%;
            width: 100px !important;
            height: 120px !important;
        }

        /* CSS para galería*/
        .portfolio-menu {
            text-align: center;
        }

        .portfolio-menu ul li {
            display: inline-block;
            margin: 0;
            list-style: none;
            padding: 10px 15px;
            cursor: pointer;
            -webkit-transition: all 05s ease;
            -moz-transition: all 05s ease;
            -ms-transition: all 05s ease;
            -o-transition: all 05s ease;
            transition: all .5s ease;
        }

        .portfolio-item {
            /*width:100%;*/
        }

        .portfolio-item .item {
            /*width:303px;*/
            float: left;
            margin-bottom: 10px;
        }

        /* Collage Gallery Styles - 3 Photos */
        .collage-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: 225px 225px;
            gap: 10px;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
            background: #f8f9fa;
        }

        .collage-item {
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }

        .collage-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .collage-item:hover img {
            transform: scale(1.05);
        }

        .collage-item-main {
            grid-column: 1 / 2;
            grid-row: 1 / 3;
        }

        .collage-item-sub {
            grid-column: 2 / 3;
        }

        .collage-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            pointer-events: none;
        }

        .collage-overlay .count {
            font-size: 28px;
            font-weight: bold;
        }

        .collage-overlay .text {
            font-size: 14px;
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            .collage-container {
                grid-template-columns: 1fr;
                grid-template-rows: 300px 150px 150px;
            }

            .collage-item-main,
            /* Magnific Popup Zoom Animation */
            .mfp-with-zoom .mfp-container,
            .mfp-with-zoom.mfp-bg {
                opacity: 0;
                -webkit-backface-visibility: hidden;
                transition: all 0.3s ease-out;
            }

            .mfp-with-zoom.mfp-ready .mfp-container {
                opacity: 1;
            }

            .mfp-with-zoom.mfp-ready.mfp-bg {
                opacity: 0.8;
            }

            .mfp-with-zoom.mfp-removing .mfp-container,
            .mfp-with-zoom.mfp-removing.mfp-bg {
                opacity: 0;
            }

            /* Sticky Sidebar Styles */
            .sticky-sidebar {
                position: sticky;
                top: 100px;
                z-index: 10;
            }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7V6LNMERVY"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-7V6LNMERVY');
    </script>
</head>

<body>
    <div style="background:#F2F2F2;">
        <div>
            <div>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding-bottom: 10px;padding-top: 15px;">
                    <div class="container" style="padding-top: -20px; padding-bottom: -20px;">
                        <a class="navbar-brand" href="https://3seedscommercial.mx"><img src="images/logo-blanco.png"
                                alt="3Seeds Commercial" style="max-width: inherit; max-height: 60px;"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse " id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link menu" href="https://3seedscommercial.mx">Inicio<span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu" href="#nosotros">Nosotros</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu" href="#contacto">Contacto</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link menu dropdown-toggle" href="busqueda.php" id="navPropiedades"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Propiedades
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navPropiedades">
                                        <a class="dropdown-item" href="busqueda.php">Todas</a>
                                        <a class="dropdown-item" href="busqueda.php?subtipo=1">Comercial</a>
                                        <a class="dropdown-item" href="busqueda.php?subtipo=2">Industrial</a>
                                        <a class="dropdown-item" href="busqueda.php?subtipo=3">Residencial</a>
                                    </div>
                                </li>
                            </ul>
                            <form action="busqueda.php" method="post" class="form-inline my-2 my-lg-0">
                                <input type="text" class="form-control mr-sm-2" id="tex4" placeholder="Buscar"
                                    name="busqueda">
                                <input type="hidden" name="tipo_busq" value="1">
                                <input type="hidden" name="busquedaprin" value="1">
                                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="Buscar">
                            </form>
                        </div>
                    </div>
            </div>
            </nav>
        </div>
    </div>
    <?php

    //obtenemos tipo de modalidad de inmueble
    $consulta_top = "SELECT `idopcion`, `nombre_opcion` FROM `cat_opcion` WHERE idopcion=" . $row_cs['opcion_idopcion'];
    $resultado_top = mysqli_query($con, $consulta_top);
    $row_top = mysqli_fetch_assoc($resultado_top);
    //verificamos que precio mostrar
    if ($row_top['idopcion'] == 1) {       //renta
        if ($row_cs['precio_renta_basado'] != "Valor total" && !empty($row_cs['precio_renta_basado'])) {
            $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_renta_basado'];
        } else {
            $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " por mes";
        }
    } else if ($row_top['idopcion'] == 2) {       //venta
        if ($row_cs['precio_venta_basado'] != "Valor total" && !empty($row_cs['precio_venta_basado'])) {
            $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_venta_basado'];
        } else {
            $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'];
        }
    } else if ($row_top['idopcion'] == 3) {       //venta y renta
    
        $precio_mrenta = "Renta: $ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " por mes";
        if ($row_cs['precio_renta_basado'] != "Valor total" && !empty($row_cs['precio_renta_basado'])) {
            $precio_mrenta = "Renta: $ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_renta_basado'];
        }

        $precio_mventa = "Venta: $ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'];
        if ($row_cs['precio_venta_basado'] != "Valor total" && !empty($row_cs['precio_venta_basado'])) {
            $precio_mventa = "Venta: $ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_venta_basado'];
        }

        $precio_muestreo = $precio_mrenta . " | " . $precio_mventa;

    } else {
        if ($row_cs['Precio'] == 0) {
            $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'];
        } else {
            $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'];
        }
    }
    //obtenemos opcion del inmueble
    $consulta_tip = "SELECT `idcat_tipo`, `nombre_tipo` FROM `cat_tipo` WHERE idcat_tipo=" . $row_cs['cat_tipo_idcat_tipo'];
    $resultado_tip = mysqli_query($con, $consulta_tip);
    $row_tip = mysqli_fetch_assoc($resultado_tip);
    //obtenemos nombre de empresa
    $consulta_emp = "SELECT `id_empresa`, `nombre`, `tel_1`, `tel_2`, `email_1`, `eimal_2`, `sitio_web`, `direccion` FROM `cat_empresa` WHERE id_empresa=" . $row_cs['idempresa'];
    $resultado_emp = mysqli_query($con, $consulta_emp);
    $row_emp = mysqli_fetch_assoc($resultado_emp);

    //obtenemos restante de dias
    $d_hoy = date('Y-m-d');
    $des_fech = explode(" ", $row_cs['fecha_publicacion'] ?? '');
    $fecha1 = new DateTime($des_fech[0]);
    $fecha2 = new DateTime($d_hoy);
    $diff = $fecha1->diff($fecha2);
    // El resultados sera 3 dias
    $et_fecha = "";
    if ($diff->days == 0) {
        $et_fecha = "Hoy";
    } else if ($diff->days == 1) {
        $et_fecha = "Hace 1 día";
    } else if ($diff->days > 1) {
        $et_fecha = "Hace " . $diff->days . " días";
    }
    //obtenemos direccion del inmueble  `direccion`, `colonia`, `fraccionamiento`, `municipio`, `estado`
    $etq_descripcion = "";
    /*
            if($row_cs['direccion']!=""){
                $etq_descripcion.="<br><b>Dirección: </b> ".$row_cs['direccion'];
            }
            if($row_cs['colonia']!=""){
                $etq_descripcion.="<br><b>Colonia: </b> ".$row_cs['colonia'];
            }
            if($row_cs['fraccionamiento']!=""){
                $etq_descripcion.="<br><b>Fraccionamiento: </b> ".$row_cs['fraccionamiento'];
            }
            if($row_cs['municipio']!=""){
                $etq_descripcion.="<br><b>Municipio: </b> ".$row_cs['municipio'];
            }
            if($row_cs['estado']!=""){
                $etq_descripcion.="<br><b>Estado: </b> ".$row_cs['estado'];
            }
           */
    ?>
    <style>
        .header-meta {
            display: flex;
            gap: 20px;
            color: #666;
            font-size: 15px;
        }

        /* Hide price ribbon temporarily */
        .arrow-ribbon2 {
            display: none !important;
        }
    </style>
    <div class="header-section mb-4">
        <div class="container">
            <h1><?= esc($row_cs['nombre']); ?></h1>
            <div class="header-meta">
                <span><i class="icon icon-briefcase text-success mr-1"></i> <?= esc($row_emp['nombre']); ?></span>
                <span><i class="icon-map-marker text-success mr-1"></i>
                    <?= esc($row_cs['colonia'] . ", " . $row_cs['municipio'] . ", " . $row_cs['estado']); ?></span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Columna Izquierda: Contenido Principal (8/12) -->
            <div class="col-lg-8">
                <!-- Galería -->
                <div class="collage-container mb-4" style="position: relative;">
                    <?php
                    // Obtenemos todas las imágenes para el collage y para Fancybox
                    $consulta_full = "SELECT `idinmuebles_fotos`, `ruta_archivo` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . " ORDER BY order_img ASC";
                    $resultado_full = mysqli_query($con, $consulta_full);
                    $fotos = [];
                    while ($f = mysqli_fetch_assoc($resultado_full)) {
                        $fotos[] = $f;
                    }
                    $total_fotos = count($fotos);

                    // Mostrar las primeras 3 fotos
                    for ($i = 0; $i < min(3, $total_fotos); $i++) {
                        $class = ($i == 0) ? "collage-item-main" : "collage-item-sub";
                        ?>
                        <div class="collage-item <?php echo $class; ?> popup-btn" data-fancybox-group="light"
                            href="aplicacion/_lib/file/img/3simg/<?php echo $fotos[$i]['ruta_archivo']; ?>">
                            <img src="aplicacion/_lib/file/img/3simg/<?php echo $fotos[$i]['ruta_archivo']; ?>"
                                alt="Foto <?php echo $i + 1; ?>">
                            <?php if ($i == 2 && $total_fotos > 3) { ?>
                                <div class="collage-overlay">
                                    <div class="count">+<?php echo $total_fotos - 2; ?></div>
                                    <div class="text">Ver Fotos</div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                    }

                    // Generar enlaces ocultos para el resto de las fotos (a partir de la 4ta, index 3)
                    for ($i = 3; $i < $total_fotos; $i++) {
                        ?>
                        <a class="popup-btn d-none" data-fancybox-group="light"
                            href="aplicacion/_lib/file/img/3simg/<?= $fotos[$i]['ruta_archivo']; ?>"></a>
                    <?php
                    }
                    if ($total_fotos == 0) {
                        ?>
                        <div class="collage-item collage-item-main w-100">
                            <img src="aplicacion/_lib/file/img/3simg/sin_imagen.png" alt="Sin imagen">
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <!-- Descripción y Especificaciones -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Descripción</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <p>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        <?= str_replace("\n", '<br>', esc($row_cs['descripcion'])) . "<br>" . esc($etq_descripcion); ?>
                                    </font>
                                </font>
                            </p>
                            <button type="submit" name="ver_ubi" class="btn  btn-success"><a
                                    href="<?= $armadoenlace; ?>" class="fcc-btn" target="_blank">Ver
                                    Ubicación</a></button>
                        </div>
                        <h4 class="mb-4">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Especificaciones</font>
                            </font>
                        </h4>
                        <div class="row">
                            <div class="col-xl-6 col-md-12">
                                <ul class="list-unstyled widget-spec mb-0">
                                    <?php
                                    //SUPERFICIE DE TERRENO
                                    
                                    if (!empty($row_cs['superficie_terreno'])) {
                                        ?>
                                        <li>
                                            <img src="aplicacion/_lib/file/img/3slogo/terreno.gif"
                                                style="width: auto; height: 30px;" class="iconos icon">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">
                                                    <?= $row_cs['superficie_terreno']; ?> m2 de terreno
                                                </font>
                                            </font>
                                        </li>
                                    <?php
                                    }

                                    //SUPERFICIE DE CONSTRUCCIÓN
                                    
                                    if (!empty($row_cs['superficie_construccion'])) {
                                        ?>
                                        <li>
                                            <img src="aplicacion/_lib/file/img/3slogo/construccion.gif"
                                                style="width: auto; height: 30px;" class="iconos icon">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">
                                                    <?= $row_cs['superficie_construccion']; ?> m2 de
                                                    construcción
                                                </font>
                                            </font>
                                        </li>
                                    <?php
                                    }

                                    ?>
                                    <!--características-->
                                    <?php
                                    //Consulta para obtener las caracteristicas
                                    $consulta_car = "SELECT `inmuebles_caracteristicascol`, `inmuebles_idinmuebles`, `cat_caracteristicas_idcat_caracteristicas`, `valor` FROM `inmuebles_caracteristicas` WHERE cat_caracteristicas_idcat_caracteristicas!=3 AND cat_caracteristicas_idcat_caracteristicas!=32 AND inmuebles_idinmuebles=" . $row_cs['idinmuebles'];
                                    $resultado_car = mysqli_query($con, $consulta_car);
                                    $numrows_car = mysqli_num_rows($resultado_car);
                                    $val_cosiderar_ant = intval($numrows_car / 2); //6
                                    $val_cosiderar_desp = $val_cosiderar_ant + 1;
                                    $idntifica = 1;
                                    while ($row_car = mysqli_fetch_assoc($resultado_car)) {
                                        //realizamos consulta para obtener descripción de caracteristica
                                        $consulta_dcar = "SELECT `idcat_caracteristicas`, `nombre_car`, `unidad`,logo,nombre_plural FROM `cat_caracteristicas` WHERE idcat_caracteristicas=" . $row_car['cat_caracteristicas_idcat_caracteristicas'];
                                        $resultado_dcar = mysqli_query($con, $consulta_dcar);
                                        $row_dcar = mysqli_fetch_assoc($resultado_dcar);
                                        //si es superficie
                                        $etiqueta = "";
                                        /*if($row_car['cat_caracteristicas_idcat_caracteristicas']==3){  //SUPERFICIE
                                                 $etiqueta=$row_car['valor']." ".$row_dcar['unidad'];
                                        }else{*/
                                        if ($row_car['valor'] > 1) {
                                            $etiqueta = $row_car['valor'] . " " . $row_dcar['nombre_plural'];
                                        } else {
                                            $etiqueta = $row_car['valor'] . $row_dcar['unidad'] . " " . $row_dcar['nombre_car'];
                                        }
                                        //}
                                    
                                        //if($idntifica==1 || $idntifica==$val_cosiderar_desp){                                      
                                        //ARMADO DE CARACTERISTICAS
                                        ?>
                                        <li>

                                            <?php if (!empty($row_dcar['logo'])) { ?>
                                                <img src="aplicacion/_lib/file/img/3slogo/<?= $row_dcar['logo']; ?>"
                                                    style="width: auto; height: 30px;" class="iconos icon">
                                            <?php } ?>
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;"><?= $etiqueta; ?>
                                                </font>
                                            </font>
                                        </li>
                                        <?php

                                        //verificamos para poder armarlas columnas de caracteristicas
                                        //if($idntifica==$val_cosiderar_ant || $idntifica==$numrows_car){ 
                                        if ($idntifica == $numrows_car) {    //fin de registros de la segunda columna                  
                                            ?>
                                        </ul>
                                    </div>
                                <?php
                                        } else if ($idntifica == $val_cosiderar_desp) {  //para terminar la columna               
                                            ?>

                                        </ul>
                                    </div>
                                    <div class="col-xl-6 col-md-12">
                                        <ul class="list-unstyled widget-spec mb-0">
                                    <?php
                                        } //end if  
                                    
                                        $idntifica++;
                                    } //end while
                                    //verificamos si NO existe listado de caracteristicas
                                    if ($numrows_car == 0) {
                                        ?>
                                </ul>
                            </div>
                        <?php
                                    }//end if                                                               
                                    
                                    ?>
                    </div>
                    <!--END características-->
                    <!-- Ver Plano <div style="margin-top: 15px"> <a href="#" style="font-weight: 600;text-decoration-line: underline;margin-top: 15px;color: #28a745;">Ver plano</a></div> -->
                </div>
                <div class="pt-4 pb-4 pl-5 pr-5 border-top border-top">
                    <div class="list-id">
                        <div class="row">
                            <div class="col-xl-9 col-12">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Publicado por </font>
                                </font>
                                <a class="mb-0 font-weight-bold">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">
                                            <?= $row_emp['nombre']; ?>
                                        </font>
                                    </font>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="icons">
                        <!-- boton PDF --><button type="submit" name="" class="btn  btn-success"><a
                                href="https://3seedscommercial.mx/aplicacion/ficha_tecnica_1/ficha_tecnica_1.php?inmueble_local=<?php echo $idinmueble_aux; ?>"
                                class="fcc-btn" target="_blank">Descargar PDF</a></button><!---->
                        <button type="button" class="btn btn-success mx-auto" data-toggle="modal"
                            data-target="#exampleModal"> Compartir</button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content col-12">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Compartir por:</h5> <button type="button" class="close"
                                            data-dismiss="modal" aria-label="Close"> <span
                                                aria-hidden="true">&times;</span> </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="icon-container1 d-flex">
                                            <div class="smd"> <a
                                                    href="http://www.facebook.com/sharer.php?u=https://3seedscommercial.mx/interna.php?inm_ax%3D<?php echo $idinmueble_aux ?>"
                                                    target="_blank"><i class="img-thumbnail fab fa-facebook fa-2x"
                                                        style="color:#3B5998; background-color: #eceff5;"></i>
                                                    <p>Facebook</p>
                                                </a>
                                            </div>
                                            <div class="smd"><a
                                                    href="https://twitter.com/intent/tweet?text=<?= urlencode($row_cs['descripcion']); ?>&url=https://3seedscommercial.mx/interna.php?inm_ax=<?php echo $idinmueble_aux ?>&hashtags=inmuebles,renta,venta"
                                                    target="_blank"><i class=" img-thumbnail fab fa-twitter fa-2x"
                                                        style="color:#4c6ef5;background-color: aliceblue"></i>
                                                    <p>Twitter</p>
                                                </a>
                                            </div>
                                            <div class="smd"><a
                                                    href="https://www.linkedin.com/shareArticle?mini=true&url=https://3seedscommercial.mx/interna.php?inm_ax%3D<?php echo $idinmueble_aux ?>"
                                                    target="_blank"><i class="img-thumbnail fab fa-linkedin fa-2x"
                                                        style="color: #0e76a8;background-color: #f0f8ff;"></i>
                                                    <p>LinkedIn</p>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="icon-container2 d-flex">
                                            <div class="smd"><a
                                                    href="whatsapp://send?text=<?= urlencode($row_cs['descripcion'] . ' con https://3seedscommercial.mx/interna.php?inm_ax=' . $idinmueble_aux); ?>"
                                                    target="_blank"> <i class="img-thumbnail fab fa-whatsapp fa-2x"
                                                        style="color: #25D366;background-color: #f0f8ff;"></i>
                                                    <p>Whatsapp</p>
                                                </a>
                                            </div>
                                            <div class="smd"> <a
                                                    href="https://www.facebook.com/dialog/send?link=https://3seedscommercial.mx/interna.php?inm_ax%3D<?php echo $idinmueble_aux ?>&app_id=291494419107518&redirect_uri=https://3seedscommercial.mx/interna.php?inm_ax%3D<?php echo $idinmueble_aux ?>">
                                                    <i class="img-thumbnail fab fa-facebook-messenger fa-2x"
                                                        style="color: #3b5998;background-color: #eceff5;"></i>
                                                    <p>Messenger</p>
                                                </a>
                                            </div>
                                            <div class="smd"><a
                                                    href="https://xn--r1a.link/share/url?url=<?= urlencode('https://3seedscommercial.mx/interna.php?inm_ax=' . $idinmueble_aux); ?>&text=<?= urlencode($row_cs['descripcion']); ?>"
                                                    target="_blank"> <i class="img-thumbnail fab fa-telegram fa-2x"
                                                        style="color: #4c6ef5;background-color: aliceblue"></i>
                                                    <p>Telegram</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                        <a href="http://www.facebook.com/sharer.php?u=https://3seedscommercial.mx/interna.php?inm_ax=<?php  //echo $row_agn['idinmuebles']; ?>" target="_blank" class="btn btn-info icons">
                            <i class="icon icon-share mr-1"></i>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;"> Compartir anuncio</font>
                            </font>
                        </a>
                        <a href="3seedscommercial.mx/aplicacion/pdfreport_inmuebles/pdfreport_inmuebles.php?inmueble_local=<?php  //echo $idinmueble_aux; ?>" class="btn btn-secondary icons" target="_blank">
                            <i class="icon icon-printer  mr-1"></i>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;"> Impresión</font>
                            </font>
                        </a>-->
                    </div> <!-- Fin icons -->
                </div> <!-- Fin card-footer -->
            </div> <!-- Fin card mb-4 -->
        </div> <!-- Fin Columna Izquierda -->

        <!-- Columna Derecha: Sidebar Persistente -->
        <div class="col-lg-4">
            <div class="sticky-sidebar">
                <div class="contact-card-sidebar">
                    <h4 class="mb-3">Contacta al agente</h4>

                    <?php
                    // Obtenemos datos del agente
                    $consulta_agn = "SELECT `name`, `telefono`, `email`, foto_agente FROM `sec_3seedsusers` WHERE login='" . $row_cs['agentes_idagente'] . "'";
                    $resultado_agn = mysqli_query($con, $consulta_agn);
                    $row_agn = mysqli_fetch_assoc($resultado_agn);
                    ?>

                    <div class="agent-info-compact">
                        <?php if ($row_agn['foto_agente'] != "") { ?>
                            <img src="../aplicacion/_lib/file/img/img_agente1/<?php echo esc($row_agn['foto_agente']); ?>"
                                alt="Agente">
                        <?php } else { ?>
                            <img src="../images/usuario.png" alt="Agente">
                        <?php } ?>
                        <div class="agent-details">
                            <h5><?php echo esc($row_agn['name']); ?></h5>
                            <p><?php echo esc($row_agn['email']); ?></p>
                        </div>
                    </div>

                    <form method="post" class="contact-form-sidebar">
                        <div class="form-group mb-2">
                            <input type="text" class="form-control" name="nombre_f" placeholder="Nombre" required>
                        </div>
                        <div class="form-group mb-2">
                            <input type="email" class="form-control" name="email_f" placeholder="Email" required>
                        </div>
                        <div class="form-group mb-2">
                            <input type="email" class="form-control" name="email_f2" placeholder="Email (Confirmar)">
                        </div>
                        <div class="form-group mb-2">
                            <input type="tel" class="form-control" name="telefono_f" placeholder="Teléfono" required>
                        </div>
                        <div class="form-group mb-2">
                            <textarea name="message_f" class="form-control"
                                placeholder="¡Hola! Quiero que se comuniquen conmigo por esta propiedad."
                                style="height: 100px;"></textarea>
                        </div>

                        <div class="mb-2">
                            <button type="submit" name="enviar" class="sidebar-btn-email btn-block">
                                <i class="fa fa-envelope"></i> Enviar correo
                            </button>
                        </div>
                        <div>
                            <button type="submit" name="enviar_w" class="sidebar-btn-whatsapp btn-block">
                                <i class="fa fa-whatsapp"></i> Enviar WhatsApp
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- Fin Columna Derecha -->
    </div> <!-- Fin Container -->

    <!-- SECCIÓN: TE PODRÍA INTERESAR -->
    <section class="similar-properties-section">
        <div class="container">
            <h2 class="section-title-premium">Te podría interesar</h2>
            <div class="similar-properties-carousel">
                <?php
                // Query para propiedades similares
                // 1. Misma modalidad (renta/venta)
                // 2. Mismo tipo (bodega/oficina/etc)
                // 3. Misma zona/municipio
                $sql_sim = "SELECT idinmuebles, nombre, municipio, estado, Precio, precio_renta, moneda_cat, opcion_idopcion FROM inmuebles
                            WHERE (opcion_idopcion = " . intval($row_cs['opcion_idopcion']) . "
                            OR cat_tipo_idcat_tipo = " . intval($row_cs['cat_tipo_idcat_tipo']) . "
                            OR municipio = '" . mysqli_real_escape_string($con, $row_cs['municipio']) . "')
                            AND idinmuebles != " . intval($row_cs['idinmuebles']) . "
                            AND cat_estatus_idcat_estatus = 1
                            LIMIT 10";
                $res_sim = mysqli_query($con, $sql_sim);

                while ($row_sim = mysqli_fetch_assoc($res_sim)) {
                    // Obtener imagen principal
                    $sql_imgp = "SELECT ruta_archivo FROM inmuebles_fotos WHERE inmuebles_idinmuebles = " . $row_sim['idinmuebles'] . " ORDER BY order_img ASC LIMIT 1";
                    $res_imgp = mysqli_query($con, $sql_imgp);
                    $row_imgp = mysqli_fetch_assoc($res_imgp);
                    $thumb = ($row_imgp) ? "aplicacion/_lib/file/img/3simg/" . $row_imgp['ruta_archivo'] : "aplicacion/_lib/file/img/3simg/sin_imagen.png";

                    // Formatear precio
                    $precio_sim = "";
                    if ($row_sim['opcion_idopcion'] == 1) { // Renta
                        $precio_sim = "$ " . number_format($row_sim['precio_renta'], 0) . " " . $row_sim['moneda_cat'];
                    } else { // Venta o ambos
                        $precio_sim = "$ " . number_format($row_sim['Precio'], 0) . " " . $row_sim['moneda_cat'];
                    }
                    ?>
                    <div class="property-slide">
                        <div class="property-card-premium">
                            <a href="interna.php?inm_ax=<?php echo $row_sim['idinmuebles']; ?>">
                                <div class="card-img-container">
                                    <div class="modality-badge-premium">
                                        <?php echo ($row_sim['opcion_idopcion'] == 1) ? 'Renta' : 'Venta'; ?>
                                    </div>
                                    <img src="<?php echo esc($thumb); ?>" alt="<?php echo esc($row_sim['nombre']); ?>">
                                </div>
                                <div class="card-content-premium">
                                    <h4><?php echo esc($row_sim['nombre']); ?></h4>
                                    <div class="location">
                                        <i class="fa fa-map-marker"></i>
                                        <?php echo esc($row_sim['municipio'] . ", " . $row_sim['estado']); ?>
                                    </div>
                                    <div class="card-price-premium">
                                        <?php echo $precio_sim; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('.similar-properties-carousel').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                dots: false,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            arrows: false,
                            dots: true
                        }
                    }
                ]
            });
        });
    </script>

    <?php
    // Procesamiento de formulario
    $nombre_f = trim($_POST["nombre_f"] ?? '');
    $telefono_f = $_POST["telefono_f"] ?? '';
    $email_f = trim($_POST["email_f"] ?? '');
    $message_f = $_POST["message_f"] ?? '';

    if (isset($_POST['enviar'])) {
        if (empty($nombre_f) || empty($telefono_f) || empty($email_f)) {
            echo '<script language="javascript">alert("Faltaron campos por llenar");</script>';
        } else {
            //enviar correo
            $para = 'hola@3seeds.mx';
            $asunto = 'Solicitud de información - 3seedscomercial';
            $cabeceras = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $cabeceras .= 'From: Notificaciones 3seedscomercial <hola@3seeds.mx>' . "\r\n";

            $mensaje = '<html><body>';
            $mensaje .= '<h3>Solicitud de más información</h3>';
            $mensaje .= '<p><b>Nombre: </b>' . $nombre_f . '<br><b>Teléfono: </b>' . $telefono_f . '<br><b>Correo eletrónico: </b>' . $email_f . '<br><b>Mensaje: </b>' . $message_f . '<br><b>Propiedad de interés: </b>' . $idinmueble_aux . ' - ' . $row_cs['nombre'] . '<br></p>';
            $mensaje .= '</body></html>';

            mail($para, $asunto, $mensaje, $cabeceras);
            echo '<script language="javascript">alert("¡Recibimos tu información!, en breve nos contactaremos contigo para brindarte una mejor atención.");</script>';
        }
    }
    if (isset($_POST['enviar_w'])) {
        if (empty($nombre_f) || empty($telefono_f) || empty($email_f)) {
            echo '<script language="javascript">alert("Faltaron campos por llenar");</script>';
        } else {
            //abrir enlace de WA
            $mensajewa = 'Nombre: ' . $nombre_f . '\n Teléfono:' . $telefono_f . '\n Correo eletrónico: ' . $email_f . '\n Mensaje: ' . $message_f . '\n Propiedad de interés: ' . $idinmueble_aux . ' - ' . $row_cs['nombre'];
            $mensajewa = str_replace(" ", "%20", $mensajewa);
            echo '<script>window.open("https://wa.me/' . $numwat . '?text=' . $mensajewa . '", "_blank");</script>';
        }
    }
    ?>
    </div><!-- cierre container de linea 1555 -->
    <footer>
        <div class="footer">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="row">
                        <div class="col-lg-6 col-12 paddingf">
                            <h3>Nosotros</h3>
                            <hr>
                            <p>3Seeds Commercial es una empresa vanguardista, con gran experiencia y dinamismo; nace con
                                el enfoque de conectar una extensa gama de servicios inmobiliarios.
                                Nuestra meta es crear valor para nuestros clientes e inversionistas a través de
                                soluciones inmobiliarias integrales en la renta, venta, desarrollo y búsquedas
                                especializadas; en el sector residencial, oficinas, industrial y comercial; logrando
                                proyectos patrimoniales, rentables y exitosos.</p>
                        </div>
                        <div class="col-lg-6 col-12 paddingf">
                            <h3>Contacto</h3>
                            <hr>
                            <div>
                                <div>
                                    <h6><span><i class="fa fa-map-marker mr-2 mb-2"></i></span><a href="#"
                                            class="text-white">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">Querétaro, México</font>
                                            </font>
                                        </a></h6>
                                    <h6><span><i class="fa fa-envelope mr-2 mb-2"></i></span><a
                                            href="mailto:hola@3seeds.mx" class="text-white">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;"> hola@3seeds.mx</font>
                                            </font>
                                        </a></h6>
                                    <h6><span><i class="fa fa-phone mr-2  mb-2"></i></span><a href="tel:4422448774"
                                            class="text-white">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;"> +52 442 244 8774</font>
                                            </font>
                                        </a>&nbsp;&nbsp;<a class="wa-icon fa fa-whatsapp" href="https://wa.me/524422448774"
                                            target="_blank"></a></h6>
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
                            <a class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light"
                                href="https://www.facebook.com/3SeedsCommercial" target="_blank">
                                <i class="fa fa-facebook bg-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light"
                                href="https://www.instagram.com/3seedscommercial/" target="_blank">
                                <i class="fa fa-instagram instagram-bg"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light"
                                href="https://www.linkedin.com/company/3seeds-commercial/" target="_blank">
                                <i class="fa fa-linkedin Linkedin-bg"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light"
                                href="https://www.youtube.com/@3SeedsCommercial" target="_blank">
                                <i class="fa fa-youtube-play youtube-bg"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mt-2 mb-0">Copyright © 3seeds Commercial. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Script galería-->
    <script>
        // $('.portfolio-item').isotope({
        //  	itemSelector: '.item',
        //  	layoutMode: 'fitRows'
        //  });
        $('.portfolio-menu ul li').click(function () {
            $('.portfolio-menu ul li').removeClass('active');
            $(this).addClass('active');

            var selector = $(this).attr('data-filter');
            $('.portfolio-item').isotope({
                filter: selector
            });
            return false;
        });
        $(document).ready(function () {
            var popup_btn = $('.popup-btn');
            popup_btn.magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                image: {
                    tError: '<a href="%url%">La imagen #%curr%</a> no pudo ser cargada.',
                    titleSrc: function (item) {
                        return item.el.attr('title') || '';
                    }
                },
                mainClass: 'mfp-with-zoom',
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out',
                    opener: function (openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                }
            });
        });
    </script>
    <!-- Fin Script galería-->

    <!-- Scripts al final (Opcional, pero mantengo los básicos que ya tenía el sitio) -->
    <script src="https://3seedscommercial.mx/js/popper.min.js"></script>
    <script src="https://3seedscommercial.mx/js/bootstrap-4.4.1.js"></script>
    </div>

</body>

</html>
