<?php

//realización de calculos
include_once("conexion_3seed.php");

$ultimo_id = 0;

// Leer subtipo desde querystring (?subtipo=ID)
$subtipo_id = null;
if (isset($_GET['subtipo']) && is_numeric($_GET['subtipo'])) {
    $subtipo_id = intval($_GET['subtipo']);
}

// Fragmentos SQL para filtrar por id_subtipo
$subtipo_sql_join = '';
$subtipo_sql_where = '';
if ($subtipo_id !== null) {
    $subtipo_sql_join = " INNER JOIN cat_tipo ON cat_tipo.idcat_tipo=inmuebles.cat_tipo_idcat_tipo ";
    $subtipo_sql_where = " AND cat_tipo.id_subtipo = " . $subtipo_id . " ";
}

$subtipo_value = ($subtipo_id !== null) ? $subtipo_id : '';
$baseUrl = strtok($_SERVER['REQUEST_URI'], '?');

//OBTENEMOS DATOS DE MUNICIPIO, ESTADOS Y TIPO DE PROPIEDAD
//Consulta para TODOS estados ZONA NORTE
$consulta_est = "SELECT `municipio`, `estado` FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . " GROUP BY estado ORDER BY estado ASC";
$resultado_est = mysqli_query($con, $consulta_est);
$numrows_est = mysqli_num_rows($resultado_est);

//Consulta para TODOS municipios ZONA NORTE
$consulta_mun = "SELECT `municipio`, `estado` FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . " GROUP BY municipio ORDER BY municipio ASC";
$resultado_mun = mysqli_query($con, $consulta_mun);
$numrows_mun = mysqli_num_rows($resultado_mun);

//Consulta para tipo venta estados ZONA NORTE
$consulta_estv = "SELECT `municipio`, `estado` FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . " AND (opcion_idopcion=2 OR opcion_idopcion=3) GROUP BY estado ORDER BY estado ASC";
$resultado_estv = mysqli_query($con, $consulta_estv);
$numrows_estv = mysqli_num_rows($resultado_estv);

//Consulta para tipo venta municipios ZONA NORTE
$consulta_munv = "SELECT `municipio`, `estado` FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . " AND (opcion_idopcion=2 OR opcion_idopcion=3) GROUP BY municipio ORDER BY municipio ASC";
$resultado_munv = mysqli_query($con, $consulta_munv);
$numrows_munv = mysqli_num_rows($resultado_munv);

//Consulta para tipo RENTA estados ZONA NORTE
$consulta_estr = "SELECT `municipio`, `estado` FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . " AND (opcion_idopcion=1 OR opcion_idopcion=3) GROUP BY estado ORDER BY estado ASC";
$resultado_estr = mysqli_query($con, $consulta_estr);
$numrows_estr = mysqli_num_rows($resultado_estr);

//Consulta para tipo RENTA municipios ZONA NORTE
$consulta_munr = "SELECT `municipio`, `estado` FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . " AND (opcion_idopcion=1 OR opcion_idopcion=3) GROUP BY municipio ORDER BY municipio ASC";
$resultado_munr = mysqli_query($con, $consulta_munr);
$numrows_munr = mysqli_num_rows($resultado_munr);

//Consulta para TODOS LOS TIPOS DE INMUEBLE
$consulta_inm = "SELECT `idcat_tipo`, `nombre_tipo` FROM `cat_tipo` INNER JOIN inmuebles ON cat_tipo.idcat_tipo=inmuebles.cat_tipo_idcat_tipo WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1" . ($subtipo_id !== null ? (" AND cat_tipo.id_subtipo=" . $subtipo_id) : "") . " GROUP BY idcat_tipo";
$resultado_inm = mysqli_query($con, $consulta_inm);
$numrows_inm = mysqli_num_rows($resultado_inm);

//Consulta para RENTA LOS TIPOS DE INMUEBLE
$consulta_inmr = "SELECT `idcat_tipo`, `nombre_tipo` FROM `cat_tipo` INNER JOIN inmuebles ON cat_tipo.idcat_tipo=inmuebles.cat_tipo_idcat_tipo WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 AND (opcion_idopcion=1 OR opcion_idopcion=3)" . ($subtipo_id !== null ? (" AND cat_tipo.id_subtipo=" . $subtipo_id) : "") . " GROUP BY idcat_tipo";
$resultado_inmr = mysqli_query($con, $consulta_inmr);
$numrows_inmr = mysqli_num_rows($resultado_inmr);

//Consulta para VENTA LOS TIPOS DE INMUEBLE
$consulta_inmv = "SELECT `idcat_tipo`, `nombre_tipo` FROM `cat_tipo` INNER JOIN inmuebles ON cat_tipo.idcat_tipo=inmuebles.cat_tipo_idcat_tipo WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 AND (opcion_idopcion=2 OR opcion_idopcion=3)" . ($subtipo_id !== null ? (" AND cat_tipo.id_subtipo=" . $subtipo_id) : "") . " GROUP BY idcat_tipo";
$resultado_inmv = mysqli_query($con, $consulta_inmv);
$numrows_inmv = mysqli_num_rows($resultado_inmv);

//Consulta para OPCIONES (Renta/Venta/etc) filtradas por zona/subtipo
$consulta_opc = "SELECT DISTINCT cat_opcion.idopcion, cat_opcion.nombre_opcion
                 FROM cat_opcion
                 INNER JOIN inmuebles ON cat_opcion.idopcion=inmuebles.opcion_idopcion" . $subtipo_sql_join . "
                 WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N')
                 AND inmuebles.cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . "
                 ORDER BY cat_opcion.nombre_opcion ASC";
$resultado_opc = mysqli_query($con, $consulta_opc);
$numrows_opc = mysqli_num_rows($resultado_opc);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;" charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="index">
    <!-- Meta Tags Principales -->

    <title>3Seeds Commercial</title>

    <meta name="title" content="3Seeds Commercial" />

    <!--Descripción de la página no mayor a 155 caracteres-->
    <meta name="description" content="Contáctanos hoy mismo y dejanos guiarte hacia tu nueva propiedad." />

    <!--Aquí deben ir las palabras claves -->
    <meta name="keywords"
        content="Inmobiliaria zona norte, 3seeds, 3seedsdevelopments, 3seeds industrial, Asesores inmobiliarios profesionales, Asesoría inmobiliaria de vanguardia, Asesoría, inmobiliaria con tecnología, Renta de locales/oficinas/terrenos/casas/departamentos, Venta de locales/oficinas/terrenos/casas/departamentos, Proyectos de inversión, Desarrollos industriales, Desarrollos comerciales, Gerencia inmobiliaria, Opiniones de valor, Consutoria hipotecaria, Valuación de propiedades, Valoración de mercado inmobiliario, Asesor inmobiliario biligue, Asesor inmobiliario bajio, Asesoria inmobiliaria con tecnología de vanguardia, Promoción inmobiliaria, Publicidad inmobiliaria">
    <!-- Open Graph / Facebook -->

    <meta property="og:type" content="website" />

    <meta property="og:url" content="https://3seedscommercial.mx" />

    <meta property="og:title" content="3Seeds Commercial" />

    <meta property="og:description" content="Contáctanos hoy mismo y dejanos guiarte hacia tu nueva propiedad." />

    <!-- Aquí debe hacer referencia la imagen destacada -->
    <meta property="og:image" content="https://3seedscommercial.mx/images/Logo3sdc.png" />
    <meta property="og:image:width" content="800" /><!-- Importante -->
    <meta property="og:image:height" content="418" /><!-- Importante -->
    <meta property="fb:app_id" content="1298752174093559" />
    <meta property="fb:admins" content="3SeedsCommercial" />

    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="3Seeds Commercial">
    <meta itemprop="description" content="Contáctanos hoy mismo y dejanos guiarte hacia tu nueva propiedad.">
    <meta itemprop="image" content="https://3seedscommercial.mx/images/Logo3sdc.png">

    <!-- Twitter -->

    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://3seedscommercial.mx" />
    <meta property="twitter:title" content="3Seeds Commercial" />
    <meta property="twitter:description" content="Contáctanos hoy mismo y dejanos guiarte hacia tu nueva propiedad." />
    <!-- Aquí debe hacer referencia la imagen destacada -->
    <meta property="twitter:image" content="https://3seedscommercial.mx/images/Logo3sdc.png" />

    <!-- Fin Meta Tags-->

    <!-- pinterest-->
    <meta name="p:domain_verify" content="2c6c608b65fa4ebc13ceb268cbee4c65" />
    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .iconos {

            height: 16px;

            width: 16px;

        }

        .categories {
            margin-top: -35px;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .box-shadow-0 {
            box-shadow: none !important;
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            border-radius: 4px;
            word-wrap: break-word;
            background-color: #f1f1f1;
            background-clip: border-box;
            border: 1px solid #eaeef9;
            border-radius: 5px;
            box-shadow: 0 0 40px 0 rgb(234 238 249 / 50%);
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .carta {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-clip: border-box;
            width: 100%;
        }


        .card2 {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            border-radius: 4px;
            word-wrap: break-word;
            background-color: #ffffff;
            background-clip: border-box;
            border: 1px solid #eaeef9;
            border-radius: 5px;
            box-shadow: 0 0 40px 0 rgb(234 238 249 / 50%);
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            margin: 0;
            padding: .5rem 0rem 0.5rem 0rem;
            position: relative;
            height: 100%;
        }

        .bg-primary-transparent {
            background-color: rgba(241, 202, 214, 0.6);
        }

        .text-primary {
            color: #ed5151 !important;
        }

        .icon-service1 {
            display: inline-flex;
            width: 50px;
            height: 50px;
            text-align: center;
            border-radius: 5px;
            align-items: center;
            justify-content: center;
        }

        .bg-secondary-transparent {
            background-color: rgba(89, 1, 255, 0.14);
        }

        .text-secondary {
            color: #9c31df !important;
        }

        /* Vertical Carousel for Sidebar */
        .carousel-vertical .carousel-inner {
            height: 620px;
            width: 100%;
            overflow: hidden;
            /* Fits 2 cards (300px each) + gap */
        }

        /* Definición de la transición: Fluida y optimizada para GPU */
        .carousel-vertical .carousel-item {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            transition: transform 1.2s cubic-bezier(0.645, 0.045, 0.355, 1);
            backface-visibility: hidden;
            /* Evita parpadeos en renderizado */
            perspective: 1000px;
            transform: translateY(100%);
        }

        /* Estado Activo: En el centro */
        .carousel-vertical .carousel-item.active {
            transform: translateY(0);
        }

        /* Movimiento hacia arriba (Next) */
        .carousel-vertical .active.left {
            transform: translateY(-100%);
        }

        .carousel-vertical .next.left {
            transform: translateY(0);
        }

        /* Movimiento hacia abajo (Prev) */
        .carousel-vertical .active.right {
            transform: translateY(100%);
        }

        .carousel-vertical .prev.right {
            transform: translateY(0);
        }

        /* Property Cards Styling */
        .prop-card-home {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .prop-card-home:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .prop-card-sidebar {
            border: 1px solid #eee;
            border-radius: 6px;
            margin-bottom: 10px;
            overflow: hidden;
            background: #fff;
            height: 300px;
            width: 100%;
        }

        .prop-img-container {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .prop-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .prop-sidebar-img {
            height: 150px;
        }

        .ver-mas-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #007bff;
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            text-decoration: none;
        }

        .text-warning {
            color: #ffa22b !important;
        }

        .bg-warning-transparent {
            background-color: rgba(255, 162, 43, 0.3);
        }

        .text-info {
            color: #0dabb7 !important;
        }

        .bg-info-transparent {
            background-color: rgba(0, 214, 230, 0.3);
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .text-muted {
            color: #a6a3ba !important;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
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
            background-color: #29943F;
            border-color: #29943F;
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
            padding: 2px 8px;
            position: absolute;
            top: 10px;
            left: 0px;
            z-index: 98;
            font-size: 18px;
        }

        .bg-primary {
            background-color: #29943F !important;
        }

        .bg-destacado {
            background-color: #29943f !important;
        }

        .arrow-ribbon2:before {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            content: "";
            right: -24px;
            border-top: 14px solid transparent;
            border-bottom: 15px solid transparent;
            width: 0;
        }

        .arrow-ribbon2:before {
            border-left: 24px solid #29943f;
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
            background-color: #29943F;
            border-color: #29943F;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #29943F;
            border-color: #29943F;
        }

        .card-title {
            font-size: 1rem;
            line-height: 1.2;
            font-weight: 500;
            margin-bottom: .5rem;
            color: black;
        }

        .menu {
            font-weight: 600;
            font-size: 16px;
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

        .btn-floating1 i {
            font-size: 1.25rem;
            line-height: 37px;
            display: inline-block;
            width: inherit;
            text-align: center;
            color: gray;
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

        .sptb-2 {
            padding-top: 4rem;
            padding-bottom: 5rem;
        }

        .bg-background2:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
        }

        .cover-image {
            background-size: cover !important;
            width: 100%;
            position: relative;
        }

        .bg-background2 .header-text {
            position: relative;
            z-index: 10;
            top: 0;
            bottom: 0;
        }

        .banner-1 .header-text,
        .banner-1 .header-text1 {
            left: 0;
            right: 0;
            color: #fff;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-center {
            text-align: center !important;
        }

        .mb-7,
        .my-7 {
            margin-bottom: 3rem !important;
        }

        .mb-1,
        .my-1 {
            margin-bottom: 0.25rem !important;
        }

        .ml-auto,
        .mx-auto {
            margin-left: auto !important;
        }

        .mr-auto,
        .mx-auto {
            margin-right: auto !important;
        }

        .d-block {
            display: block !important;
        }

        .bg-transparent {
            background-color: transparent !important;
        }

        .search-background {
            background: #fff;
            border-radius: 3px;
            overflow: hidden;
        }

        .search-background .form-control:first-child {
            border-right: 0;
        }

        @media (min-width: 992px) .br-br-md-0 {
            border-bottom-right-radius: 0 !important;
        }

        @media (min-width: 992px) .br-tr-md-0 {
            border-top-right-radius: 0 !important;
        }

        .mr-1,
        .mx-1 {
            margin-right: 0.25rem !important;
        }

        .location-gps {
            cursor: pointer;
            height: 20px;
            px: ;
            */: ;
            line-height: 33px;
            position: absolute;
            right: 12px;
            text-align: right;
            top: 14.5px;
            background: #fff;
            width: 15px;
            color: #a7b4c9;
        }

        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
        }

        .banner-1 .search-background .select2-container--default .select2-selection--single {
            border-radius: 0;
            border-right: 0 !important;
        }

        .select2-lg .select2-container .select2-selection--single {
            height: 2.875rem !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 28px;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-lg .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 45px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            display: block;
            padding-left: 8px;
            padding-right: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            text-align: left;
        }

        .banner-1 .search-background .select2-container--default .select2-selection--single {
            border-radius: 0;
            border-right: 0 !important;
        }

        .select2-lg .select2-container .select2-selection--single {
            height: 2.875rem !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .sptb {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .sptb1 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .text-center {
            text-align: center !important;
        }

        .center-block {
            float: none;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            float: inherit !important;
        }

        .section-title {
            padding-bottom: 2rem;
        }

        .no-js .owl-carousel {
            display: block;
        }

        .owl-carousel.owl-loaded {
            display: block;
        }

        .owl-carousel {
            display: none;
            width: 100%;
            -webkit-tap-highlight-color: transparent;
            position: relative;
        }

        .owl-carousel {
            position: relative;
        }

        .owl-carousel .owl-stage-outer {
            position: relative;
            overflow: hidden;
            -webkit-transform: translate3d(0px, 0px, 0px);
        }

        .owl-carousel .owl-stage {
            position: relative;
            -ms-touch-action: pan-Y;
            touch-action: manipulation;
            -moz-backface-visibility: hidden;
        }

        .owl-carousel.owl-drag .owl-item {
            -ms-touch-action: pan-y;
            touch-action: pan-y;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .owl-carousel.owl-drag .owl-item {
            left: 0 !important;
            right: 0;
        }

        .owl-carousel .owl-item {}

        .owl-carousel .owl-item {
            position: relative;
            min-height: 1px;
            float: left;
            -webkit-backface-visibility: hidden;
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
        }

        .owl-carousel .owl-wrapper,
        .owl-carousel .owl-item {
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            -ms-backface-visibility: hidden;
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
        }

        .owl-carousel .owl-item {
            position: relative;
            cursor: url(../images/other/cursor.png), move;
            overflow: hidden;
        }

        .owl-carousel.owl-drag .owl-item {
            -ms-touch-action: pan-y;
            touch-action: pan-y;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .owl-carousel.owl-drag .owl-item {
            left: 0 !important;
            right: 0;
        }

        .owl-carousel .owl-item {}

        .owl-carousel .owl-item {
            position: relative;
            min-height: 1px;
            float: left;
            -webkit-backface-visibility: hidden;
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
        }

        .owl-carousel .owl-wrapper,
        .owl-carousel .owl-item {
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            -ms-backface-visibility: hidden;
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
        }

        .owl-carousel .owl-item {
            position: relative;
            cursor: url(../images/other/cursor.png), move;
            overflow: hidden;
        }

        .text-warning {
            color: #ffa22b !important;
        }

        .power-ribbon-top-left {
            top: -6px;
            left: -9px;
        }

        .power-ribbon {
            width: 56px;
            height: 56px;
            overflow: hidden;
            position: absolute;
            z-index: 10;
        }

        .power-ribbon-top-left {
            top: -6px;
            left: -9px;
        }

        .power-ribbon {
            width: 56px;
            height: 56px;
            overflow: hidden;
            position: absolute;
            z-index: 10;
        }

        .power-ribbon-top-left span i {
            transform: rotate(45deg);
            padding-top: 2px;
            padding-left: 7px;
        }

        .item-card2-img {
            position: relative;
            overflow: hidden;
        }

        .item-card2-img a {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        img {
            max-width: 100%;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        .tag-text {
            position: absolute;
            bottom: 12px;
            z-index: 1;
            right: 6px;
        }

        .tag-text .tag-option {
            color: #fff;
            margin: 5px;
            padding: 3px 5px;
            font-size: 12px;
            border-radius: 3px;
        }

        .bg-danger {
            background-color: #ff382b !important;
        }

        .item-card2-icons {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 98;
        }

        .item-card2-icons a {
            width: 2rem;
            display: inline-block;
            height: 2rem;
            text-align: center;
            border-radius: 100px;
            line-height: 2.1rem;
            border-radius: 3px;
            color: #fff;
        }

        .bg-secondary {
            background-color: #9c31df !important;
        }

        a.bg-secondary:focus,
        a.bg-secondary:hover {
            background-color: #9c31df !important;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 0.75rem !important;
        }

        .item-card2-list li {
            width: 50%;
            float: left;
            margin-bottom: 0.5rem;
        }

        .card-bottom,
        .card-footer {
            padding: 0.5rem 1.5rem .5rem 1.5rem;
            background: 0 0;
        }

        .leading-normal {
            line-height: 1.5 !important;
        }

        .h5,
        h5 {
            font-size: 1rem;
            color: #212529;
        }

        .footerimg img {
            width: 35px;
            height: 35px;
        }

        .avatar {
            background: #29943F no-repeat center/cover;
        }

        .controls-top {
            text-align: center;
            margin-top: 1.88rem;
        }

        .controls-top1 {
            text-align: center;
            margin-top: 1.88rem;
        }

        a.waves-effect,
        a.waves-light {
            display: inline-block;
        }

        .btn-floating {
            background: white;
        }

        .btn-floating i {
            font-size: 1.25rem;
            line-height: 37px;
            display: inline-block;
            width: inherit;
            text-align: center;
            color: #fff;
        }

        .about-1 {
            position: relative;
        }

        .bg-background-color .content-text,
        .bg-background .header-text1 {
            position: relative;
            z-index: 10;
        }

        .info .counter-icon {
            border: 1px solid rgba(255, 255, 255, 0.9) !important;
            background: rgba(0, 0, 0, 0.2);
        }

        .info .counter-icon i {
            color: #fff;
        }

        .counter-icon {
            margin-bottom: 1rem;
            display: inline-flex;
            width: 4rem;
            height: 4rem;
            padding: 1.3rem 1.4rem;
            border-radius: 50%;
            text-align: center;
        }

        .bg-background-color:before {
            background: linear-gradient(-225deg, rgba(74, 61, 184, 0.8) 48%, rgba(50, 228, 179, 0.8) 100%) !important;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .caja {

            display: flex;

            flex-flow: column wrap;

            justify-content: center;

            align-items: center;

        }

        .box {

            width: 100%;
            height: 230px;
            background: white;
            overflow: hidden;
            border-radius: 15px;

        }

        .box img {

            width: 100%;

            height: auto;

        }

        @supports(object-fit: cover) {

            .box img {

                height: 100%;

                object-fit: cover;

                object-position: center center;

            }

        }

        .brround {

            border-radius: 50%;

        }

        .fs-12 {

            font-size: 12px !important;

            color: Gray;

        }

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

        /* Style the tab */
        .tab {
            overflow: hidden;
            margin-bottom: 15px;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: white;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            margin: 10px 12px 10px 0;
            border-radius: 2rem;
            color: #333;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: white;
            color: #29943f;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #29943f;
            color: white;
            box-shadow: 0 4px 15px rgba(41, 148, 63, 0.3);
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 4px 8px 4px 18px;
            border-top: none;
            background-color: white;
            border-radius: 4rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
        }

        .subtipo-tab {
            margin-bottom: 8px;
        }

        /* Removed conflicting button styles to use global .tab button styles */

        .subtipo-tab button:hover {
            background-color: white;
            color: #29943f;
        }

        .subtipo-tab button.active {
            background-color: #29943f;
            color: white;
        }

        /* Estilos para los divs */
        .contenedor {
            display: flex;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            margin: 10px;
        }

        .search-inline {
            display: flex;
            flex-wrap: nowrap;
            gap: 4px;
            align-items: center;
            flex: 1 1 auto;
            width: 100%;
        }

        .search-inline .form-group {
            margin: 0;
            flex: 0 0 auto;
        }

        .search-inline .fg-opcion {
            width: 130px;
        }

        .search-inline .fg-tipo {
            width: 170px;
        }

        .search-inline .fg-texto {
            flex: 1 1 auto;
            min-width: 150px;
        }

        .search-inline .fg-buscar {
            width: 64px;
        }

        .search-inline .btn-buscar {
            width: 100%;
            height: 36px;
            padding: 1px 6px;
            font-size: 13px;
            border-radius: 2rem;
            font-weight: 700;
            background-color: #29943f;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(41, 148, 63, 0.2);
        }

        .search-inline .btn-buscar:hover {
            background-color: #248137;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(41, 148, 63, 0.3);
        }

        .hero-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .hero-title-side {
            color: #fff;
            max-width: 400px;
            text-align: center;
            padding: 0;
            margin-left: 20px;
        }

        .hero-controls {
            flex: 1 1 auto;
        }

        .hero-title-side h1 {
            font-size: 30px;
            line-height: 1.02;
            margin: 0;
            font-weight: 800;
        }

        .search-inline .form-control {
            height: 42px;
            min-height: 42px;
            padding: 8px 15px;
            font-size: 13px;
            border: none;
            border-radius: 0;
            background: transparent;
            color: #333;
        }

        .search-inline .form-group:not(:last-child) {
            border-right: 1px solid #f0f0f0;
        }

        .search-inline .fg-texto .form-control::placeholder {
            color: #bbb;
        }

        .search-inline .form-control:focus {
            outline: none;
            box-shadow: none;
        }



        /* Estilos para los inputs y botones 
input[type="text"],
select {
   width: 100%;
   padding: 5px;
}*/
        button {
            padding: 5px 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .cambio {
            position: static;
            top: 0%;
            left: 50%;
            transform: translate(0%, -500%);
            /* background-color: red; */
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .cambio-destacado {
            position: static;
            top: 0%;
            left: 50%;
            transform: translate(0%, -500%);
            /* background-color: red; */
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .ocultar {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .contenedor-movil {
                display: block;
                flex-wrap: wrap;
            }

            .search-inline {
                display: block;
            }

            .search-inline .fg-opcion,
            .search-inline .fg-tipo,
            .search-inline .fg-texto,
            .search-inline .fg-buscar {
                width: 100%;
                margin-bottom: 8px;
            }

            .hero-head {
                display: block;
            }

            .hero-title-side {
                max-width: 100%;
                margin-bottom: 10px;
            }

            .hero-title-side h1 {
                font-size: 24px;
            }
        }
    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-230519516-2"></script>

    <script>

        window.dataLayer = window.dataLayer || [];

        function gtag() { dataLayer.push(arguments); }

        gtag('js', new Date());
        gtag('config', 'UA-230519516-2');

    </script>

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
    <div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding-bottom: 10px;padding-top: 15px;">
                <div class="container" style="padding-top: -20px; padding-bottom: -20px;">
                    <a class="navbar-brand" href="https://www.3seedscommercial.mx/"><img src="images/logo-blanco.png"
                            alt="3Seeds Commercial" style="max-width: inherit; max-height: 60px;"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link menu" href="https://www.3seedscommercial.mx/">Inicio<span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <!--		  <li class="nav-item">
                    <a class="nav-link menu" href="mailto:hola@3seeds.mx">Contacto</a>
                  </li> -->
                        </ul>

                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!--Sliders Section-->
    <section>
        <div class="banner-1 cover-image sptb-2 sptb-tab bg-background2" data-image-src="images/descubre_propiedad.png"
            style="background: url(&quot;images/descubre_propiedad.png&quot;) center center;">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="hero-head">
                        <div class="hero-controls">
                            <div class="tab subtipo-tab">
                                <button type="button"
                                    class="tablinks <?php echo ($subtipo_id === 1 ? 'active' : ''); ?>"
                                    onclick="window.location.href='<?php echo $baseUrl; ?>?subtipo=1'">Comercial</button>
                                <button type="button"
                                    class="tablinks <?php echo ($subtipo_id === 2 ? 'active' : ''); ?>"
                                    onclick="window.location.href='<?php echo $baseUrl; ?>?subtipo=2'">Industrial</button>
                                <button type="button"
                                    class="tablinks <?php echo ($subtipo_id === 3 ? 'active' : ''); ?>"
                                    onclick="window.location.href='<?php echo $baseUrl; ?>?subtipo=3'">Residencial</button>
                            </div>

                            <!--Tab Todos-->
                            <div id="Todos" class="tabcontent" style="display:block;">
                                <form action="busqueda.php" method="post">
                                    <input type="hidden" name="subtipo"
                                        value="<?php echo htmlspecialchars((string) $subtipo_value, ENT_QUOTES); ?>">
                                    <div class="contenedor contenedor-movil search-inline">
                                        <div class="form-group fg-opcion">
                                            <select class="form-control" name="select_opcion">
                                                <option selected="selected" value="">Venta</option>
                                                <?
                                                if ($numrows_opc != 0) {
                                                    while ($row_opc = mysqli_fetch_assoc($resultado_opc)) {
                                                        echo "<option value=\"" . $row_opc['idopcion'] . "\">" . $row_opc['nombre_opcion'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group fg-tipo">
                                            <select class="form-control" id="inmueble" name="select_cat">

                                                <option selected="selected" value="">Tipo de propiedad</option>

                                                <?
                                                //TIPO INMUEBLE
                                                if ($numrows_inm != 0) {
                                                    while ($row_cs = mysqli_fetch_assoc($resultado_inm)) {
                                                        echo "<option " . ($idtinmueble == $row_cs['idcat_tipo'] ? "selected=\"selected\"" : "") . " value=\"" . $row_cs['idcat_tipo'] . "\">" . $row_cs['nombre_tipo'] . "</option>";
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="form-group fg-texto">
                                            <input type="text" class="form-control" name="busqueda"
                                                placeholder="Ingresa ubicaciones o características">
                                        </div>
                                        <div class="form-group fg-buscar">
                                            <input type="hidden" id="tipo_bus" name="tipo_busq" value="1">
                                            <input type="hidden" id="tbusqda" name="tbusqda" value="N">
                                            <!--zona norte -->
                                            <input type="hidden" id="tprecio" name="tprecio" value="T">
                                            <!--tipo de precio TODOS -->
                                            <input type="hidden" id="busquedaprin" name="busquedaprin" value="1">
                                            <input type="submit" class="btn btn-primary btn-buscar" value="Buscar">
                                        </div>
                                    </div>
                                </form>
                            </div><!--Fin Tab Todos-->
                        </div>
                        <div class="hero-title-side ml-auto">
                            <h1 class="mb-1">Descubre tu propiedad ideal.</h1>
                        </div>
                    </div>

                    <!--Tab Ventas-->
                    <div id="Venta" class="tabcontent" style="display:none">
                        <form action="busqueda.php" method="post">
                            <input type="hidden" name="subtipo"
                                value="<?php echo htmlspecialchars((string) $subtipo_value, ENT_QUOTES); ?>">
                            <div class="contenedor contenedor-movil">
                                <div class="form-group">
                                    <select class="form-control select2-show-search select2-hidden-accessible"
                                        data-placeholder="Estado" data-select2-id="1" tabindex="-1" aria-hidden="true"
                                        name="ubicacion" onchange="actualizarElementos()" id="ubicacionfrom">
                                        <option selected="selected" value="">Estado</option>
                                        <?

                                        //ESTADOS
                                        if ($numrows_estv != 0) {
                                            while ($row_csl = mysqli_fetch_assoc($resultado_estv)) {
                                                echo "<option " . ($idestado == $row_csl['estado'] ? "selected=\"selected\"" : "") . " value=\"" . $row_csl['estado'] . "\">" . $row_csl['estado'] . "</option>";
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control select2-show-search select2-hidden-accessible"
                                        data-placeholder="Municipio" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true" name="municipiop" id="municipiofrom">
                                        <option selected="selected" value="">Municipio</option>
                                        <?

                                        //MUNICIPIOS
                                        if ($numrows_munv != 0) {
                                            while ($row_csl = mysqli_fetch_assoc($resultado_munv)) {
                                                echo "<option " . ($idmunicipio == $row_csl['municipio'] ? "selected=\"selected\"" : "") . " value=\"" . $row_csl['municipio'] . "\">" . $row_csl['municipio'] . "</option>";
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" id="inmueble" name="select_cat">

                                        <option selected="selected" value="">Tipo de Propiedad</option>

                                        <?
                                        //TIPO INMUEBLE
                                        
                                        if ($numrows_inmv != 0) {
                                            while ($row_cs = mysqli_fetch_assoc($resultado_inmv)) {
                                                echo "<option " . ($idtinmueble == $row_cs['idcat_tipo'] ? "selected=\"selected\"" : "") . " value=\"" . $row_cs['idcat_tipo'] . "\">" . $row_cs['nombre_tipo'] . "</option>";
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>

                            <div class="contenedor contenedor-movil">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="pricefrom" name="precio_min"
                                        placeholder="Precio mínimo">
                                </div>

                                <div class="form-group">
                                    <input type="number" class="form-control" id="pricefrom" name="precio_max"
                                        placeholder="Precio máximo">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="tipo_bus" name="tipo_busq" value="1">
                                    <input type="hidden" id="tbusqda" name="tbusqda" value="N"> <!--zona norte -->
                                    <input type="hidden" id="tprecio" name="tprecio" value="V">
                                    <!--tipo de precio VENTA-->
                                    <input type="submit" class="btn btn-lg btn-block btn-primary br-tl-md-0 br-bl-md-0"
                                        value="Buscar">
                                </div>
                            </div>
                        </form>
                    </div><!--Fin Tab Ventas-->

                    <!--Tab Renta-->
                    <div id="Renta" class="tabcontent" style="display:none">
                        <form action="busqueda.php" method="post">
                            <input type="hidden" name="subtipo"
                                value="<?php echo htmlspecialchars((string) $subtipo_value, ENT_QUOTES); ?>">
                            <div class="contenedor contenedor-movil">
                                <div class="form-group">
                                    <select class="form-control select2-show-search select2-hidden-accessible"
                                        data-placeholder="Estado" data-select2-id="1" tabindex="-1" aria-hidden="true"
                                        name="ubicacion" onchange="actualizarElementos()" id="ubicacionfrom">
                                        <option selected="selected" value="">Estado</option>
                                        <?

                                        //ESTADOS
                                        if ($numrows_estr != 0) {
                                            while ($row_csl = mysqli_fetch_assoc($resultado_estr)) {
                                                echo "<option " . ($idestado == $row_csl['estado'] ? "selected=\"selected\"" : "") . " value=\"" . $row_csl['estado'] . "\">" . $row_csl['estado'] . "</option>";
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control select2-show-search select2-hidden-accessible"
                                        data-placeholder="Municipio" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true" name="municipiop" id="municipiofrom">
                                        <option selected="selected" value="">Municipio</option>
                                        <?

                                        //MUNICIPIO 
                                        if ($numrows_munr != 0) {
                                            while ($row_csl = mysqli_fetch_assoc($resultado_munr)) {
                                                echo "<option " . ($idmunicipio == $row_csl['municipio'] ? "selected=\"selected\"" : "") . " value=\"" . $row_csl['municipio'] . "\">" . $row_csl['municipio'] . "</option>";
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" id="inmueble" name="select_cat">

                                        <option selected="selected" value="">Tipo de Propiedad</option>

                                        <?
                                        //TIPO DE INMUEBLE
                                        
                                        if ($numrows_inmr != 0) {
                                            while ($row_cs = mysqli_fetch_assoc($resultado_inmr)) {
                                                echo "<option " . ($idtinmueble == $row_cs['idcat_tipo'] ? "selected=\"selected\"" : "") . " value=\"" . $row_cs['idcat_tipo'] . "\">" . $row_cs['nombre_tipo'] . "</option>";
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>

                            <div class="contenedor contenedor-movil">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="pricefrom" name="precio_min"
                                        placeholder="Precio mínimo">
                                </div>

                                <div class="form-group">
                                    <input type="number" class="form-control" id="pricefrom" name="precio_max"
                                        placeholder="Precio máximo">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="tipo_bus" name="tipo_busq" value="1">
                                    <input type="hidden" id="tbusqda" name="tbusqda" value="N"> <!--zona norte -->
                                    <input type="hidden" id="tprecio" name="tprecio" value="R">
                                    <!--tipo de precio RENTA-->
                                    <input type="submit" class="btn btn-lg btn-block btn-primary br-tl-md-0 br-bl-md-0"
                                        value="Buscar">
                                </div>
                            </div>
                        </form>
                    </div><!--Fin Tab Renta-->
                    <div class="row">
                        <div class="col-xl-10 col-lg-12 col-md-12 d-block mx-auto">
                            <div class="search-background bg-transparent" data-select2-id="37">

                                <form action="busqueda.php" method="post" name="formevent">

                                    <div class="form row no-gutters" data-select2-id="36">

                                        <!--<div class="form-group  col-xl-4 col-lg-3 col-md-12 mb-0  ">
                                    < !--<input type="text" class="form-control input-lg br-tr-md-0 br-br-md-0" id="text4" placeholder="Ubicación" name="ubicacion"> 
                                    <span><i class="fa fa-map-marker location-gps mr-1"></i></span> -- >
                                     <select class="form-control select2-show-search border-bottom-0 select2-hidden-accessible" data-placeholder="Property Type" data-select2-id="1" tabindex="-1" aria-hidden="true" name="ubicacion">
                                         <option selected="selected" value="">Ubicación</option>
                                        <?
                                        //Consulta para las categorias
                                        /* $consulta_csl="SELECT `municipio`, `estado` FROM `inmuebles` WHERE municipio!='' AND estado!='' AND cat_estatus_idcat_estatus=1 GROUP BY municipio, estado ORDER BY estado ASC, municipio ASC"; 
                                         $resultado_csl = mysqli_query($con,$consulta_csl);
                                         $numrows_csl=mysqli_num_rows($resultado_csl);
                                         if($numrows_csl!=0)
                                             {
                                                 while($row_csl=mysqli_fetch_assoc($resultado_csl))
                                                 {
                                                     echo "<option ".( $idubicacion == $row_csl['municipio'] ? "selected=\"selected\"" : "" )." value=\"".$row_csl['municipio']."\">".$row_csl['municipio'].", ".$row_csl['estado']."</option>";
                                                 }
                                             }*/
                                        ?>
                                    </select>
                                </div>-->

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /header-text -->
        </div>
    </section>

    <!--	<section class="categories"> <div class="container">
        <div class="card mb-0 box-shadow-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 d-catmb mb-4 mb-lg-0">
                        <div class="d-flex">
                            <div>
                                <span class="bg-primary-transparent icon-service1 text-primary">

                                    <i class="fa fa-home"></i>

                                </span>
                            </div>
                            <?

                            //Consulta tipo CASA
                            
                            $consulta_casa = "SELECT `idinmuebles` FROM `inmuebles` WHERE cat_tipo_idcat_tipo=1";

                            $resultado_casa = mysqli_query($con, $consulta_casa);

                            $numrows_casa = mysqli_num_rows($resultado_casa);



                            ?>
                            <div class="ml-4 mt-1">

                                <h3 class=" mb-0 font-weight-bold"><? echo $numrows_casa; ?></h3>

                                <p class="mb-0 text-muted">Casas</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 d-catmb mb-4 mb-lg-0">
                        <div class="d-flex">
                            <div>

                                <span class="bg-secondary-transparent icon-service1 text-secondary">

                                    <i class="fa fa-map-o"></i>

                                </span>

                            </div>
                            <?

                            //Consulta tipo TERRENO
                            
                            $consulta_casa = "SELECT `idinmuebles` FROM `inmuebles` WHERE cat_tipo_idcat_tipo=2";

                            $resultado_casa = mysqli_query($con, $consulta_casa);

                            $numrows_casa = mysqli_num_rows($resultado_casa);



                            ?>
                            <div class="ml-4 mt-1">

                                <h3 class=" mb-0 font-weight-bold"><? echo $numrows_casa; ?></h3>

                                <p class="mb-0 text-muted">Terrenos</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 d-catmb mb-4 mb-sm-0">
                        <div class="d-flex">
                            <div>

                                <span class="bg-warning-transparent icon-service1 text-warning">

                                    <i class="fa fa-object-group"></i>

                                </span>

                            </div>
                            <?

                            //Consulta tipo OFICINAS
                            
                            $consulta_casa = "SELECT `idinmuebles` FROM `inmuebles` WHERE cat_tipo_idcat_tipo=5";

                            $resultado_casa = mysqli_query($con, $consulta_casa);

                            $numrows_casa = mysqli_num_rows($resultado_casa);



                            ?>
                            <div class="ml-4 mt-1">

                                <h3 class=" mb-0 font-weight-bold"><? echo $numrows_casa; ?></h3>

                                <p class="mb-0 text-muted">Oficinas</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 ">
                        <div class="d-flex">
                            <div>

                                <span class="bg-info-transparent icon-service1 text-info">

                                    <i class="fa fa-building-o"></i>

                                </span>

                            </div>
                            <?

                            //Consulta tipo DEPARTAMENTOS
                            
                            $consulta_casa = "SELECT `idinmuebles` FROM `inmuebles` WHERE cat_tipo_idcat_tipo=4";

                            $resultado_casa = mysqli_query($con, $consulta_casa);

                            $numrows_casa = mysqli_num_rows($resultado_casa);



                            ?>
                            <div class="ml-4 mt-1">

                                <h3 class=" mb-0 font-weight-bold "><? echo $numrows_casa; ?></h3>

                                <p class="mb-0 text-muted">Departamentos</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->

    <!--Inicia últimas propiedades-->

    <section style="margin-top: 15px">
        <div class="container">

            <!-- VISTA CON 3 SECCIONES (con filtro de subtipo si aplica) -->
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <!-- Propiedades en Venta -->
                    <div class="section-title text-left">
                        <h2>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;font-weight: 700;">Propiedades en venta</font>
                            </font>
                        </h2>
                    </div>
                    <div id="carousel-venta" class="carousel slide carousel-multi-item" data-ride="carousel"
                        data-interval="5000">
                        <div class="carousel-inner" role="listbox">
                            <?
                            $consulta_v = "SELECT `idinmuebles`, `nombre`, `descripcion`, `cat_tipo_idcat_tipo`, `opcion_idopcion`, `ubicacion`, `fecha_publicacion`, `direccion`, `colonia`, `fraccionamiento`, `municipio`, `estado`, `agentes_idagente`, `vigencia`, `cat_estatus_idcat_estatus`, `vistas`, `idempresa`,Precio,moneda_cat,precio_renta,superficie_terreno,superficie_construccion,precio_venta_basado,precio_renta_basado FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND cat_estatus_idcat_estatus=1 AND (opcion_idopcion=2 OR opcion_idopcion=3)" . $subtipo_sql_where . " ORDER BY idinmuebles DESC LIMIT 12";
                            $resultado_v = mysqli_query($con, $consulta_v);
                            $count = 0;
                            $first = true;
                            while ($row_cs = mysqli_fetch_assoc($resultado_v)) {
                                if ($count % 3 == 0) {
                                    if (!$first)
                                        echo '</div></div>';
                                    echo '<div class="carousel-item ' . ($first ? 'active' : '') . '"><div class="row">';
                                    $first = false;
                                }
                                ?>
                                <div class="col-md-4">
                                    <div class="prop-card-home">
                                        <a href="https://3seedscommercial.mx/interna.php?inm_ax=<? echo $row_cs['idinmuebles']; ?>"
                                            style="text-decoration:none; color:inherit;">
                                            <div class="prop-img-container">
                                                <?
                                                $c_img = "SELECT ruta_archivo FROM inmuebles_fotos WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . " ORDER BY order_img ASC LIMIT 1";
                                                $r_img = mysqli_query($con, $c_img);
                                                $row_img = mysqli_fetch_assoc($r_img);
                                                $img = $row_img['ruta_archivo'] ?: "sin_imagen.png";
                                                ?>
                                                <img src="aplicacion/_lib/file/img/3simg/<? echo $img; ?>" alt="Property">
                                                <div class="arrow-ribbon2 bg-destacado"
                                                    style="position:absolute; top:10px; left:0;">
                                                    <? echo ($row_cs['opcion_idopcion'] == 2 ? "Venta" : "Venta y Renta"); ?>
                                                </div>
                                            </div>
                                            <div class="card-body p-3">
                                                <h5 class="font-weight-bold"
                                                    style="font-size:1rem; height:2.4rem; overflow:hidden;">
                                                    <? echo $row_cs['nombre']; ?>
                                                </h5>
                                                <p class="text-muted mb-2" style="font-size:0.8rem;">
                                                    <? echo ($row_cs['superficie_terreno'] > 0 ? number_format($row_cs['superficie_terreno'], 0) : number_format($row_cs['superficie_construccion'], 0)) . " m2"; ?>
                                                </p>
                                                <h6 class="text-primary font-weight-bold">
                                                    <? echo "$ " . number_format($row_cs['Precio'], 0) . " " . $row_cs['moneda_cat']; ?>
                                                </h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?
                                $count++;
                            }
                            if ($count > 0)
                                echo '</div></div>';
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carousel-venta" role="button" data-slide="prev"
                            style="width:5%; background:rgba(0,0,0,0.1); border-radius:50%; height:40px; top:40%;"><i
                                class="fa fa-chevron-left"></i></a>
                        <a class="carousel-control-next" href="#carousel-venta" role="button" data-slide="next"
                            style="width:5%; background:rgba(0,0,0,0.1); border-radius:50%; height:40px; top:40%;"><i
                                class="fa fa-chevron-right"></i></a>
                    </div>

                    <!-- Propiedades en Renta -->
                    <div class="section-title text-left mt-5">
                        <h2>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;font-weight: 700;">Propiedades en renta</font>
                            </font>
                        </h2>
                    </div>
                    <div id="carousel-renta" class="carousel slide carousel-multi-item" data-ride="carousel"
                        data-interval="6000">
                        <div class="carousel-inner" role="listbox">
                            <?
                            $consulta_r = "SELECT `idinmuebles`, `nombre`, `descripcion`, `cat_tipo_idcat_tipo`, `opcion_idopcion`, `ubicacion`, `fecha_publicacion`, `direccion`, `colonia`, `fraccionamiento`, `municipio`, `estado`, `agentes_idagente`, `vigencia`, `cat_estatus_idcat_estatus`, `vistas`, `idempresa`,Precio,moneda_cat,precio_renta,superficie_terreno,superficie_construccion,precio_venta_basado,precio_renta_basado FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND cat_estatus_idcat_estatus=1 AND (opcion_idopcion=1 OR opcion_idopcion=3)" . $subtipo_sql_where . " ORDER BY idinmuebles DESC LIMIT 12";
                            $resultado_r = mysqli_query($con, $consulta_r);
                            $count = 0;
                            $first = true;
                            while ($row_cs = mysqli_fetch_assoc($resultado_r)) {
                                if ($count % 3 == 0) {
                                    if (!$first)
                                        echo '</div></div>';
                                    echo '<div class="carousel-item ' . ($first ? 'active' : '') . '"><div class="row">';
                                    $first = false;
                                }
                                ?>
                                <div class="col-md-4">
                                    <div class="prop-card-home">
                                        <a href="https://3seedscommercial.mx/interna.php?inm_ax=<? echo $row_cs['idinmuebles']; ?>"
                                            style="text-decoration:none; color:inherit;">
                                            <div class="prop-img-container">
                                                <?
                                                $c_img = "SELECT ruta_archivo FROM inmuebles_fotos WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . " ORDER BY order_img ASC LIMIT 1";
                                                $r_img = mysqli_query($con, $c_img);
                                                $row_img = mysqli_fetch_assoc($r_img);
                                                $img = $row_img['ruta_archivo'] ?: "sin_imagen.png";
                                                ?>
                                                <img src="aplicacion/_lib/file/img/3simg/<? echo $img; ?>" alt="Property">
                                                <div class="arrow-ribbon2 bg-destacado"
                                                    style="position:absolute; top:10px; left:0;">
                                                    <? echo ($row_cs['opcion_idopcion'] == 1 ? "Renta" : "Venta y Renta"); ?>
                                                </div>
                                            </div>
                                            <div class="card-body p-3">
                                                <h5 class="font-weight-bold"
                                                    style="font-size:1rem; height:2.4rem; overflow:hidden;">
                                                    <? echo $row_cs['nombre']; ?>
                                                </h5>
                                                <p class="text-muted mb-2" style="font-size:0.8rem;">
                                                    <? echo ($row_cs['superficie_terreno'] > 0 ? number_format($row_cs['superficie_terreno'], 0) : number_format($row_cs['superficie_construccion'], 0)) . " m2"; ?>
                                                </p>
                                                <h6 class="text-primary font-weight-bold">
                                                    <? echo "$ " . number_format($row_cs['precio_renta'], 0) . " " . $row_cs['moneda_cat']; ?>
                                                </h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?
                                $count++;
                            }
                            if ($count > 0)
                                echo '</div></div>';
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carousel-renta" role="button" data-slide="prev"
                            style="width:5%; background:rgba(0,0,0,0.1); border-radius:50%; height:40px; top:40%;"><i
                                class="fa fa-chevron-left"></i></a>
                        <a class="carousel-control-next" href="#carousel-renta" role="button" data-slide="next"
                            style="width:5%; background:rgba(0,0,0,0.1); border-radius:50%; height:40px; top:40%;"><i
                                class="fa fa-chevron-right"></i></a>
                    </div>
                </div>

                <!-- Sidebar Columna Derecha -->
                <div class="col-lg-3 col-md-12">
                    <div class="section-title text-left">
                        <h2>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;font-weight: 700;">Destacado</font>
                            </font>
                        </h2>
                    </div>
                    <div id="carousel-destacado" class="carousel slide carousel-vertical" data-ride="carousel"
                        data-interval="6000">
                        <div class="carousel-inner" role="listbox">
                            <?
                            $consulta_d = "SELECT `idinmuebles`, `nombre`, `descripcion`, `cat_tipo_idcat_tipo`, `opcion_idopcion`, `ubicacion`, `fecha_publicacion`, `direccion`, `colonia`, `fraccionamiento`, `municipio`, `estado`, `agentes_idagente`, `vigencia`, `cat_estatus_idcat_estatus`, `vistas`, `idempresa`,Precio,moneda_cat,precio_renta,superficie_terreno,superficie_construccion,precio_venta_basado,precio_renta_basado FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND cat_estatus_idcat_estatus=1 AND inmueble_destacado=1" . $subtipo_sql_where . " ORDER BY idinmuebles DESC LIMIT 8";
                            $resultado_d = mysqli_query($con, $consulta_d);
                            $count_d = 0;
                            $first_d = true;
                            while ($row_cs = mysqli_fetch_assoc($resultado_d)) {
                                if ($count_d % 2 == 0) {
                                    if (!$first_d)
                                        echo '</div>';
                                    echo '<div class="carousel-item ' . ($first_d ? 'active' : '') . '">';
                                    $first_d = false;
                                }
                                ?>
                                <div class="prop-card-sidebar">
                                    <a href="https://3seedscommercial.mx/interna.php?inm_ax=<? echo $row_cs['idinmuebles']; ?>"
                                        style="display:block; position:relative;">
                                        <?
                                        $c_img = "SELECT ruta_archivo FROM inmuebles_fotos WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . " ORDER BY order_img ASC LIMIT 1";
                                        $r_img = mysqli_query($con, $c_img);
                                        $row_img = mysqli_fetch_assoc($r_img);
                                        $img = $row_img['ruta_archivo'] ?: "sin_imagen.png";
                                        ?>
                                        <img src="aplicacion/_lib/file/img/3simg/<? echo $img; ?>" alt="Destacado"
                                            style="width:100%; height:300px; object-fit:cover;">
                                        <div class="ver-mas-btn">Ver más</div>
                                    </a>
                                </div>
                                <?
                                $count_d++;
                            }
                            if ($count_d > 0)
                                echo '</div>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <? if (false) { /* BLOQUE OBSOLETO */ ?>
                    <!-- VISTA FILTRADA (CAROUSEL ORIGINAL) -->
                    <div class="section-title center-block text-center">
                        <h2>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;font-weight: 700;">Propiedades encontradas</font>
                            </font>
                        </h2>
                    </div>
                    <div class="container my-4">
                        <!--Carousel Wrapper-->
                        <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">
                            <!--/.Controls-->
                            <!--Indicators
          <ol class="carousel-indicators">
            <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
            <li data-target="#multi-item-example" data-slide-to="1"></li>
          </ol>
Indicators-->


                            <!--Slides-->
                            <div class="carousel-inner" role="listbox">
                                <!--First slide-->
                                <?
                                //Consulta para obtener los INMUEBLES DE ZONA NORTE
                                $consulta_cs = "SELECT `idinmuebles`, `nombre`, `descripcion`, `cat_tipo_idcat_tipo`, `opcion_idopcion`, `ubicacion`, `fecha_publicacion`, `direccion`, `colonia`, `fraccionamiento`, `municipio`, `estado`, `agentes_idagente`, `vigencia`, `cat_estatus_idcat_estatus`, `vistas`, `idempresa`,Precio,moneda_cat,precio_renta,superficie_terreno,superficie_construccion,precio_venta_basado,precio_renta_basado FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . " ORDER BY idinmuebles DESC LIMIT 4";
                                $resultado_cs = mysqli_query($con, $consulta_cs);
                                $numrows_cs = mysqli_num_rows($resultado_cs);

                                if ($numrows_cs > 0) {
                                    ?>

                                        <div class="carousel-item active">

                                            <?
                                            while ($row_cs = mysqli_fetch_assoc($resultado_cs)) {

                                                $etiqueta_nombre = $row_cs['nombre'];

                                                if (strlen($row_cs['nombre']) <= 24) {
                                                    $etiqueta_nombre = $row_cs['nombre'] . "<br><br>";
                                                } else if (strlen($row_cs['nombre']) > 37) {
                                                    $etiqueta_nombre = substr($row_cs['nombre'], 0, 33) . " ...";
                                                }
                                                $ultimo_id = $row_cs['idinmuebles'];
                                                $etiqueta_ubica = $row_cs['ubicacion'];

                                                if (strlen($row_cs['ubicacion']) > 37) {
                                                    $etiqueta_ubica = substr($row_cs['ubicacion'], 0, 33) . " ...";
                                                }
                                                //obtenemos la primera imagen del inmueble
                                                //$consulta_img="SELECT `idinmuebles_fotos`, `ruta_archivo`, `inmuebles_idinmuebles` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=".$row_cs['idinmuebles']." ORDER BY order_img ASC, idinmuebles_fotos ASC"; 
                                                $consulta_img = "SELECT `idinmuebles_fotos`, `ruta_archivo`, `inmuebles_idinmuebles` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . " ORDER BY order_img ASC";
                                                $resultado_img = mysqli_query($con, $consulta_img);
                                                $row_img = mysqli_fetch_assoc($resultado_img);
                                                $etq_opcion = "";
                                                $etq_opcion1 = "";

                                                //OBTENEMOS NOMBRE DE LA ETQ DE OPCION
                                                $consulta_opc = "SELECT `nombre_opcion` FROM `cat_opcion` WHERE idopcion='" . $row_cs['opcion_idopcion'] . "'";
                                                $resultado_opc = mysqli_query($con, $consulta_opc);
                                                $row_opc = mysqli_fetch_assoc($resultado_opc);

                                                $etq_opcion1 = $row_opc['nombre_opcion'];
                                                /*if($row_cs['opcion_idopcion']==1){
                                                   $etq_opcion="por mes";
                                                }*/

                                                /*else if($row_cs['opcion_idopcion']==2){
                                                   $etq_opcion1="Venta";
                                                }else if($row_cs['opcion_idopcion']==3){
                                                   $etq_opcion1="Venta y Renta";
                                                }else if($row_cs['opcion_idopcion']==4){
                                                   $etq_opcion1="Traspaso";
                                                }else if($row_cs['opcion_idopcion']==5){
                                                   $etq_opcion1="Aportación";
                                                }else if($row_cs['opcion_idopcion']==6){
                                                   $etq_opcion1="Administración";
                                                }*/

                                                //validamos si existe ruta de archivo de casa/inmueble
                                                $etq_ruta_arch = $row_img['ruta_archivo'];
                                                if ($row_img['ruta_archivo'] == "") {
                                                    $etq_ruta_arch = "sin_imagen.png";
                                                }

                                                //verificamos si superficie o construcción
                                                if ($row_cs['superficie_terreno'] > 0) {
                                                    $etiqueta = '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> • ' . number_format($row_cs['superficie_terreno'], 2, '.', ',') . ' m2</font></font>&nbsp;';
                                                } else {
                                                    $etiqueta = '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> • ' . number_format($row_cs['superficie_construccion'], 2, '.', ',') . ' m2</font></font>&nbsp;';
                                                }


                                                //Consulta para obtener las características
                                                $consulta_car = "SELECT `inmuebles_caracteristicascol`, `inmuebles_idinmuebles`, `cat_caracteristicas_idcat_caracteristicas`, `valor` FROM `inmuebles_caracteristicas` WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . " LIMIT 2";
                                                $resultado_car = mysqli_query($con, $consulta_car);

                                                while ($row_car = mysqli_fetch_assoc($resultado_car)) {
                                                    //realizamos consulta para obtener descripción de característica
                                    
                                                    $consulta_dcar = "SELECT `idcat_caracteristicas`, `nombre_car`, `unidad`,logo,nombre_plural FROM `cat_caracteristicas` WHERE idcat_caracteristicas=" . $row_car['cat_caracteristicas_idcat_caracteristicas'];

                                                    $resultado_dcar = mysqli_query($con, $consulta_dcar);
                                                    $row_dcar = mysqli_fetch_assoc($resultado_dcar);
                                                    //si es superficie
                                    
                                                    if ($row_car['cat_caracteristicas_idcat_caracteristicas'] == 3) { //superficie terreno
                                                        /* $etiqueta.='<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">. '.$row_car['valor']." ".$row_dcar['unidad'].'</font></font>';*/
                                                    } else {
                                                        if ($row_car['valor'] > 1) {
                                                            $etiqueta .= '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> • ' . $row_car['valor'] . " " . $row_dcar['nombre_plural'] . " </font></font>&nbsp;";
                                                        } else {
                                                            $etiqueta .= '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> • ' . $row_car['valor'] . $row_dcar['unidad'] . " " . $row_dcar['nombre_car'] . '</font></font>&nbsp;';
                                                        }
                                                    }
                                                }


                                                ?>

                                                    <!--Primer ficha de inmueble-->

                                                    <div class="col-md-3" style="float:left">
                                                        <div class="carta mb-2" style="min-height: 400px;">
                                                            <a
                                                                href="https://3seedscommercial.mx/interna.php?inm_ax=<? echo $row_cs['idinmuebles']; ?>">

                                                                <!--Etiqueta destacado-->
                                                                <div class="arrow-ribbon2 bg-destacado"><? echo $etq_opcion1; ?></div>
                                                                <!--fin Etiqueta destacado-->

                                                                <div class="caja">

                                                                    <div class="box">

                                                                        <img class="card-img-top"
                                                                            src="aplicacion/_lib/file/img/3simg/<? echo $etq_ruta_arch; ?>"
                                                                            alt="Card image cap">

                                                                    </div>

                                                                </div>
                                                                <div class="card-body">
                                                                    <h4 class="card-title"><? echo $etiqueta_nombre; ?></h4>
                                                                    <!--<p class="mb-2">
                        <i class="fa fa-map-marker text-danger mr-1"></i>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;font-size: 13px;"> <?  //echo $etiqueta_ubica; ?></font>
                            </font>
                      </p> -->
                                                                    <span class="fs-12  font-weight-normal">
                                                                        <? echo $etiqueta; ?>
                                                                        <!--<font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">· 600.00 m2</font>
                            </font>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">· 2 recamaras</font>
                            </font>	-->
                                                                    </span>
                                                                    <h5 class="font-weight-bold mb-3">
                                                                        <font style="vertical-align: inherit;">
                                                                            <font style="vertical-align: inherit;">
                                                                                <?

                                                                                //verificamos que precio mostrar
                                                                                if ($row_cs['opcion_idopcion'] == 1) {       //renta
                                                                                    if ($row_cs['precio_renta_basado'] != "Valor total" && !empty($row_cs['precio_renta_basado'])) {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_renta_basado'] . "";
                                                                                    } else {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " por mes";
                                                                                    }
                                                                                } else if ($row_cs['opcion_idopcion'] == 2) {       //venta
                                                                                    if ($row_cs['precio_venta_basado'] != "Valor total" && !empty($row_cs['precio_venta_basado'])) {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_venta_basado'] . "";
                                                                                    } else {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . "";
                                                                                    }
                                                                                } else if ($row_cs['opcion_idopcion'] == 3) {       //venta y renta
                                                                    
                                                                                    $precio_mrenta = "Renta: $ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " por mes";
                                                                                    if ($row_cs['precio_renta_basado'] != "Valor total" && !empty($row_cs['precio_renta_basado'])) {
                                                                                        $precio_mrenta = "Renta: $ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_renta_basado'] . "";
                                                                                    }

                                                                                    $precio_mventa = "Venta: $ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . "";
                                                                                    if ($row_cs['precio_venta_basado'] != "Valor total" && !empty($row_cs['precio_venta_basado'])) {
                                                                                        $precio_mventa = "Venta: $ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_venta_basado'] . "";
                                                                                    }

                                                                                    $precio_muestreo = $precio_mrenta . "<br>" . $precio_mventa;

                                                                                } else {
                                                                                    if ($row_cs['Precio'] == 0) {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . "";
                                                                                    } else {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . "";
                                                                                    }
                                                                                }

                                                                                echo $precio_muestreo;

                                                                                ?>
                                                                            </font>
                                                                        </font>
                                                                        <span class="fs-12  font-weight-normal">
                                                                            <font style="vertical-align: inherit;">
                                                                                <font style="vertical-align: inherit;"><? echo $etq_opcion; ?>
                                                                                </font>
                                                                            </font>
                                                                        </span>
                                                                    </h5>
                                                                    <ul class="item-card2-list">
                                                                        <!--características-->

                                                                        <?
                                                                        //Consulta para obtener las características
                                                                        /* $consulta_car="SELECT `inmuebles_característicascol`, `inmuebles_idinmuebles`, `cat_características_idcat_características`, `valor` FROM `inmuebles_características` WHERE inmuebles_idinmuebles=".$row_cs['idinmuebles']." LIMIT 4"; 
                                                                         $resultado_car = mysqli_query($con,$consulta_car);

                                                                         while($row_car=mysqli_fetch_assoc($resultado_car)){
                                                                             //realizamos consulta para obtener descripción de característica

                                                                             $consulta_dcar="SELECT `idcat_características`, `nombre_car`, `unidad`,logo FROM `cat_características` WHERE idcat_características=".$row_car['cat_características_idcat_características']; 

                                                                             $resultado_dcar = mysqli_query($con,$consulta_dcar);
                                                                             $row_dcar=mysqli_fetch_assoc($resultado_dcar);
                                                                             //si es superficie

                                                                             $etiqueta="";
                                                                             if($row_car['cat_características_idcat_características']==3){
                                                                                      $etiqueta=$row_car['valor']." ".$row_dcar['unidad'];
                                                                             }else{
                                                                                 if($row_car['valor']>1){
                                                                                      $etiqueta=$row_car['valor']." ".$row_dcar['nombre_car']."s";
                                                                                 }else{
                                                                                      $etiqueta=$row_car['valor'].$row_dcar['unidad']." ".$row_dcar['nombre_car'];
                                                                                 }
                                                                             }*/
                                                                        ?>

                                                                        <!--<li>
                                    <a href="#"><img src="aplicacion/_lib/file/img/3slogo/<?  //echo $row_dcar['logo']; ?>" class="iconos">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;font-size: 12px;"> <?  //echo $etiqueta; ?></font>
                                        </font>
                                    </a>
                                  </li>-->

                                                                        <?

                                                                        // }                                                              
                                                            
                                                                        ?>
                                                                    </ul>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <!--END de inmueble-->
                                                    <?
                                                //END WHILE
                                            }

                                            ?>
                                        </div>
                                        <!--/.First slide-->
                                        <?
                                    //END IF
                                }


                                //Consulta para los ultimos inmuebles DE LA ZONA NORTE
                            
                                $consulta_cs = "SELECT `idinmuebles`, `nombre`, `descripcion`, `cat_tipo_idcat_tipo`, `opcion_idopcion`, `ubicacion`, `fecha_publicacion`, `direccion`, `colonia`, `fraccionamiento`, `municipio`, `estado`, `agentes_idagente`, `vigencia`, `cat_estatus_idcat_estatus`, `vistas`, `idempresa`,Precio,moneda_cat,precio_renta,superficie_terreno,superficie_construccion,precio_venta_basado,precio_renta_basado FROM `inmuebles`" . $subtipo_sql_join . " WHERE EXISTS (SELECT estado FROM estados WHERE estado=inmuebles.estado AND zona='N') AND cat_estatus_idcat_estatus=1 " . $subtipo_sql_where . " AND idinmuebles<$ultimo_id ORDER BY idinmuebles DESC LIMIT 4";

                                $resultado_cs = mysqli_query($con, $consulta_cs);
                                $numrows_cs = mysqli_num_rows($resultado_cs);


                                if ($numrows_cs > 0) {

                                    ?>

                                        <!--Second slide-->
                                        <div class="carousel-item">
                                            <?
                                            $ultimo_id = 0;

                                            while ($row_cs = mysqli_fetch_assoc($resultado_cs)) {

                                                $etiqueta_nombre = $row_cs['nombre'];
                                                if (strlen($row_cs['nombre']) <= 26) {
                                                    $etiqueta_nombre = $row_cs['nombre'] . "<br><br>";
                                                } else if (strlen($row_cs['nombre']) > 37) {

                                                    $etiqueta_nombre = substr($row_cs['nombre'], 0, 33) . " ...";

                                                }
                                                $etiqueta_ubica = $row_cs['ubicacion'];

                                                if (strlen($row_cs['ubicacion']) > 37) {
                                                    $etiqueta_ubica = substr($row_cs['ubicacion'], 0, 33) . " ...";
                                                }
                                                //obtenemos la primera imagen del inmueble
                                                // $consulta_img="SELECT `idinmuebles_fotos`, `ruta_archivo`, `inmuebles_idinmuebles` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=".$row_cs['idinmuebles']."  ORDER BY order_img ASC, idinmuebles_fotos ASC"; 
                                                $consulta_img = "SELECT `idinmuebles_fotos`, `ruta_archivo`, `inmuebles_idinmuebles` FROM `inmuebles_fotos` WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . "  ORDER BY order_img ASC";
                                                $resultado_img = mysqli_query($con, $consulta_img);
                                                $row_img = mysqli_fetch_assoc($resultado_img);

                                                $etq_opcion = "";
                                                $etq_opcion1 = "";

                                                //OBTENEMOS NOMBRE DE LA ETQ DE OPCION
                                                $consulta_opc = "SELECT `nombre_opcion` FROM `cat_opcion` WHERE idopcion='" . $row_cs['opcion_idopcion'] . "'";
                                                $resultado_opc = mysqli_query($con, $consulta_opc);
                                                $row_opc = mysqli_fetch_assoc($resultado_opc);

                                                $etq_opcion1 = $row_opc['nombre_opcion'];
                                                /*if($row_cs['opcion_idopcion']==1){
                                                   $etq_opcion="por mes";
                                                }*/

                                                /*if($row_cs['opcion_idopcion']==1){
                                                    $etq_opcion1="Renta";
                                                    $etq_opcion="por mes";
                                                }else if($row_cs['opcion_idopcion']==2){
                                                    $etq_opcion1="Venta";
                                                }else if($row_cs['opcion_idopcion']==3){
                                                    $etq_opcion1="Venta y Renta";
                                                }else if($row_cs['opcion_idopcion']==4){
                                                    $etq_opcion1="Traspaso";
                                                }else if($row_cs['opcion_idopcion']==5){
                                                    $etq_opcion1="Aportación";
                                                }else if($row_cs['opcion_idopcion']==6){
                                                    $etq_opcion1="Administración";
                                                }*/

                                                //validamos si existe ruta de archivo de casa/inmueble
                                                $etq_ruta_arch = $row_img['ruta_archivo'];
                                                if ($row_img['ruta_archivo'] == "") {
                                                    $etq_ruta_arch = "sin_imagen.png";
                                                }


                                                //verificamos si superficie o construcción
                                                if ($row_cs['superficie_terreno'] > 0) {
                                                    $etiqueta = '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> • ' . number_format($row_cs['superficie_terreno'], 2, '.', ',') . ' m2</font></font>&nbsp;';
                                                } else {
                                                    $etiqueta = '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> • ' . number_format($row_cs['superficie_construccion'], 2, '.', ',') . ' m2</font></font>&nbsp;';
                                                }

                                                //Consulta para obtener las características
                                                $consulta_car = "SELECT `inmuebles_caracteristicascol`, `inmuebles_idinmuebles`, `cat_caracteristicas_idcat_caracteristicas`, `valor` FROM `inmuebles_caracteristicas` WHERE inmuebles_idinmuebles=" . $row_cs['idinmuebles'] . " LIMIT 2";
                                                $resultado_car = mysqli_query($con, $consulta_car);

                                                while ($row_car = mysqli_fetch_assoc($resultado_car)) {
                                                    //realizamos consulta para obtener descripción de característica
                                    
                                                    $consulta_dcar = "SELECT `idcat_caracteristicas`, `nombre_car`, `unidad`,logo,nombre_plural FROM `cat_caracteristicas` WHERE idcat_caracteristicas=" . $row_car['cat_caracteristicas_idcat_caracteristicas'];

                                                    $resultado_dcar = mysqli_query($con, $consulta_dcar);
                                                    $row_dcar = mysqli_fetch_assoc($resultado_dcar);
                                                    //si es superficie
                                    
                                                    if ($row_car['cat_caracteristicas_idcat_caracteristicas'] == 3) { //superficie terreno
                                                        /* $etiqueta.='<font style="vertical-align: inherit;"><font style="vertical-align: inherit;">. '.$row_car['valor']." ".$row_dcar['unidad'].'</font></font>';*/
                                                    } else {
                                                        if ($row_car['valor'] > 1) {
                                                            $etiqueta .= '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> • ' . $row_car['valor'] . " " . $row_dcar['nombre_plural'] . " </font></font>&nbsp;";
                                                        } else {
                                                            $etiqueta .= '<font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> • ' . $row_car['valor'] . $row_dcar['unidad'] . " " . $row_dcar['nombre_car'] . '</font></font>&nbsp;';
                                                        }
                                                    }
                                                }



                                                ?>
                                                    <!--Primer ficha de inmueble-->

                                                    <div class="col-md-3" style="float:left">
                                                        <div class="carta mb-2" style="min-height: 400px;">
                                                            <a
                                                                href="https://3seedscommercial.mx/interna.php?inm_ax=<? echo $row_cs['idinmuebles']; ?>">

                                                                <!--Etiqueta destacado-->
                                                                <div class="arrow-ribbon2 bg-destacado"><? echo $etq_opcion1; ?></div>
                                                                <!--fin Etiqueta destacado-->

                                                                <div class="caja">

                                                                    <div class="box">

                                                                        <img class="card-img-top"
                                                                            src="aplicacion/_lib/file/img/3simg/<? echo $etq_ruta_arch; ?>"
                                                                            alt="Card image cap">

                                                                    </div>

                                                                </div>
                                                                <div class="card-body">
                                                                    <h4 class="card-title"><? echo $etiqueta_nombre; ?></h4>

                                                                    <!--<p class="mb-2">
                        <i class="fa fa-map-marker text-danger mr-1"></i>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;font-size: 13px;"> <?  //echo $etiqueta_ubica; ?></font>
                            </font>
                      </p> -->
                                                                    <span class="fs-12  font-weight-normal">

                                                                        <? echo $etiqueta; ?>
                                                                        <!--<font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">· 600.00 m2</font>
                            </font>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">· 2 recamaras</font>
                            </font>	-->
                                                                    </span>
                                                                    <h5 class="font-weight-bold mb-3">
                                                                        <font style="vertical-align: inherit;">
                                                                            <font style="vertical-align: inherit;">
                                                                                <?

                                                                                //verificamos que precio mostrar
                                                                                if ($row_cs['opcion_idopcion'] == 1) {       //renta
                                                                                    if ($row_cs['precio_renta_basado'] != "Valor total" && !empty($row_cs['precio_renta_basado'])) {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_renta_basado'] . "";
                                                                                    } else {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " por mes";
                                                                                    }
                                                                                } else if ($row_cs['opcion_idopcion'] == 2) {       //venta
                                                                                    if ($row_cs['precio_venta_basado'] != "Valor total" && !empty($row_cs['precio_venta_basado'])) {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_venta_basado'] . "";
                                                                                    } else {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . "";
                                                                                    }
                                                                                } else if ($row_cs['opcion_idopcion'] == 3) {       //venta y renta
                                                                    
                                                                                    $precio_mrenta = "Renta: $ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " por mes";
                                                                                    if ($row_cs['precio_renta_basado'] != "Valor total" && !empty($row_cs['precio_renta_basado'])) {
                                                                                        $precio_mrenta = "Renta: $ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_renta_basado'] . "";
                                                                                    }

                                                                                    $precio_mventa = "Venta: $ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . "";
                                                                                    if ($row_cs['precio_venta_basado'] != "Valor total" && !empty($row_cs['precio_venta_basado'])) {
                                                                                        $precio_mventa = "Venta: $ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . " " . $row_cs['precio_venta_basado'] . "";
                                                                                    }

                                                                                    $precio_muestreo = $precio_mrenta . "<br>" . $precio_mventa;

                                                                                } else {
                                                                                    if ($row_cs['Precio'] == 0) {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['precio_renta'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . "";
                                                                                    } else {
                                                                                        $precio_muestreo = "$ " . number_format($row_cs['Precio'], 0, '.', ',') . " " . $row_cs['moneda_cat'] . "";
                                                                                    }
                                                                                }

                                                                                echo $precio_muestreo;

                                                                                ?>
                                                                            </font>
                                                                        </font>
                                                                        <span class="fs-12  font-weight-normal">
                                                                            <font style="vertical-align: inherit;">
                                                                                <font style="vertical-align: inherit;"> <? echo $etq_opcion; ?>
                                                                                </font>
                                                                            </font>
                                                                        </span>
                                                                    </h5>
                                                                    <ul class="item-card2-list">
                                                                        <!--características-->

                                                                        <?
                                                                        //Consulta para obtener las características
                                                                        /*$consulta_car="SELECT `inmuebles_característicascol`, `inmuebles_idinmuebles`, `cat_características_idcat_características`, `valor` FROM `inmuebles_características` WHERE inmuebles_idinmuebles=".$row_cs['idinmuebles']." LIMIT 4"; 
                                                                        $resultado_car = mysqli_query($con,$consulta_car);

                                                                        while($row_car=mysqli_fetch_assoc($resultado_car)){

                                                                            //realizamos consulta para obtener descripción de característica

                                                                            $consulta_dcar="SELECT `idcat_características`, `nombre_car`, `unidad`,logo FROM `cat_características` WHERE idcat_características=".$row_car['cat_características_idcat_características']; 

                                                                            $resultado_dcar = mysqli_query($con,$consulta_dcar);

                                                                            $row_dcar=mysqli_fetch_assoc($resultado_dcar);

                                                                            //si es superficie

                                                                            $etiqueta="";

                                                                            if($row_car['cat_características_idcat_características']==3){

                                                                                     $etiqueta=$row_car['valor']." ".$row_dcar['unidad'];

                                                                            }else{

                                                                                if($row_car['valor']>1){

                                                                                     $etiqueta=$row_car['valor']." ".$row_dcar['nombre_car']."s";

                                                                                }else{

                                                                                     $etiqueta=$row_car['valor'].$row_dcar['unidad']." ".$row_dcar['nombre_car'];

                                                                                }
                                                                            }*/

                                                                        ?>

                                                                        <!--<li>
                                    <a href="#"><img src="aplicacion/_lib/file/img/3slogo/<?  //echo $row_dcar['logo']; ?>" class="iconos">
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;font-size: 12px;"> <?  //echo $etiqueta; ?></font>
                                        </font>
                                    </a>
                                  </li>-->

                                                                        <?

                                                                        // }                                                              
                                                            
                                                                        ?>
                                                                    </ul>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <!--END de inmueble-->
                                                    <?

                                                //END WHILE
                                    
                                            }
                                            ?>
                                        </div>
                                        <!--/.Second slide-->

                                        <?
                                    //END IF
                                }
                                ?>

                            </div>
                            <!--/.Slides-->
                        </div>
                        <!--/.Carousel Wrapper-->
                        <!--Controls-->
                        <div class="controls-top cambio ocultar">
                            <a class="btn-floating" href="#multi-item-example" data-slide="prev" style="left: -50%;"><i
                                    class="icon-arrow-left" style="color: gray;"></i></a>
                            <a class="btn-floating" href="#multi-item-example" data-slide="next" style="right: -50%;"><i
                                    class="icon-arrow-right" style="color: gray;"></i></a>
                        </div>
                    </div>
            <? } ?>

        </div>
    </section>
    <footer>
        <div class="footer">
            <div class="row col-12">
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
                                                <font style="vertical-align: inherit;">Nuevo León, México</font>
                                            </font>
                                        </a></h6>
                                    <h6><span><i class="fa fa-envelope mr-2 mb-2"></i></span><a
                                            href="mailto:hola@3seeds.mx" class="text-white">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;"> hola@3seeds.mx</font>
                                            </font>
                                        </a></h6>
                                    <h6><span><i class="fa fa-phone mr-2  mb-2"></i></span><a href="tel:8125120161"
                                            class="text-white">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;"> +52 81 2512 0161</font>
                                            </font>
                                        </a>&nbsp;&nbsp;<a class="fab fa fa-whatsapp" href="https://wa.me/528125120161"
                                            target="_blank"></a></h6>
                                    <!-- <h6><span class="font-weight-semibold"><i class="fa fa-link mr-2 "></i></span><a href="#" class="text-body"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">http://spruko.com/</font></font></a></h6>-->
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
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mt-2 mb-0">Copyright © 3Seeds Commercial. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        // Sin auto-apertura de pestañas.
    </script>

    <script>
        function actualizarElementos() {
            var categoriaSeleccionada = $('#ubicacionfrom').val();
            var elementoSelect = $('#municipiofrom');

            // Realizar una solicitud AJAX para obtener datos de MySQL
            $.ajax({
                type: 'POST',
                url: 'obtener_elementos.php', // Ruta al archivo PHP que manejará la consulta a la base de datos
                data: { estadop: categoriaSeleccionada, tip: 2, subtipo: <?php echo json_encode($subtipo_value); ?> },
                success: function (data) {
                    // Limpiar y llenar el segundo select con los datos obtenidos
                    elementoSelect.empty().append(data);
                }
            });
        }
    </script>
</body>

</html>