<?php 

//realización de calculos
include_once("conexion_3seed.php");

$ultimo_id=0;
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

<meta name="title" content="3Seeds Commercial"/>

<!--Descripción de la página no mayor a 155 caracteres--><meta name="description" content="Contáctanos hoy mismo y dejanos guiarte hacia tu nueva propiedad."/>

<!--Aquí deben ir las palabras claves --><meta name="keywords" content="Inmobiliaria zona norte, 3seeds, 3seedsdevelopments, 3seeds industrial, Asesores inmobiliarios profesionales, Asesoría inmobiliaria de vanguardia, Asesoría, inmobiliaria con tecnología, Renta de locales/oficinas/terrenos/casas/departamentos, Venta de locales/oficinas/terrenos/casas/departamentos, Proyectos de inversión, Desarrollos industriales, Desarrollos comerciales, Gerencia inmobiliaria, Opiniones de valor, Consutoria hipotecaria, Valuación de propiedades, Valoración de mercado inmobiliario, Asesor inmobiliario biligue, Asesor inmobiliario bajio, Asesoria inmobiliaria con tecnología de vanguardia, Promoción inmobiliaria, Publicidad inmobiliaria">
<!-- Open Graph / Facebook -->

<meta property="og:type" content="website" />

<meta property="og:url" content="https://3seedscommercial.mx"/>

<meta property="og:title" content="3Seeds Commercial"/>

<meta property="og:description" content="Contáctanos hoy mismo y dejanos guiarte hacia tu nueva propiedad."/>

<!-- aquí debe hacer referencia la imagen destacada --><meta property="og:image" content="https://3seedscommercial.mx/images/Logo3sdc.png"/>
<meta property="og:image:width" content="800" /><!-- Importante -->
<meta property="og:image:height" content="418" /><!-- Importante -->
<meta property="fb:app_id" content="1298752174093559"/>  
<meta property="fb:admins" content="3SeedsCommercial"/>

<!-- Schema.org para Google+ -->
<meta itemprop="name" content="3Seeds Commercial">
<meta itemprop="description" content="Contáctanos hoy mismo y dejanos guiarte hacia tu nueva propiedad.">
<meta itemprop="image" content="https://3seedscommercial.mx/images/Logo3sdc.png">

<!-- Twitter -->

<meta property="twitter:card" content="summary_large_image"/>
<meta property="twitter:url" content="https://3seedscommercial.mx"/>
<meta property="twitter:title" content="3Seeds Commercial" />
<meta property="twitter:description" content="Contáctanos hoy mismo y dejanos guiarte hacia tu nueva propiedad." />
<!-- aquí debe hacer referencia la imagen destacada --><meta property="twitter:image" content="https://3seedscommercial.mx/images/Logo3sdc.png"/>  

<!-- Fin Meta Tags-->

<!-- pinterest-->
<meta name="p:domain_verify" content="2c6c608b65fa4ebc13ceb268cbee4c65"/>
    <!-- Bootstrap -->
    <link href="..//css/bootstrap-4.4.1.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

.iconos{

	height: 16px;

	width: 16px;

	}
.categories {
    margin-top: -35px;
}
.mb-0, .my-0 {
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
    padding: .5rem 1.5rem 0.5rem 1.5rem;
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
.mb-0, .my-0 {
    margin-bottom: 0 !important;
}
.text-muted {
    color: #a6a3ba !important;
}
.mb-0, .my-0 {
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
	.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    margin: 0;
    padding: .5rem 1.5rem 0.5rem 1.5rem;;
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
    padding: .5rem 1.5rem 0.5rem 1.5rem;;
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
    background-color: red !important;
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
    border-left: 24px solid red;
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
    background-color: #29943F;
    border-color: #29943F;
}
.btn-primary:hover {
    color: #fff;
    background-color: #29943F;
    border-color: #29943F;
}
.card-title {
    font-size: 1.125rem;
    line-height: 1.2;
    font-weight: 400;
    margin-bottom: .5rem;
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
.sptb-2 {
    padding-top: .5rem;
    padding-bottom: 10rem;
}
.cover-image {
    background-size: cover !important;
    width: 100%;
    position: relative;
}
.bg-background2 .header-text {
    position: relative;
    z-index: 10;
    top: 70px;
    bottom: 70px;
}
.banner-1 .header-text, .banner-1 .header-text1 {
    left: 0;
    right: 0;
    color: #fff;
}
.mb-0, .my-0 {
    margin-bottom: 0 !important;
}
.text-white {
    color: #fff !important;
}
.text-center {
    text-align: center !important;
}
.mb-7, .my-7 {
    margin-bottom: 3rem !important;
}
.mb-1, .my-1 {
    margin-bottom: 0.25rem !important;
}
.ml-auto, .mx-auto {
    margin-left: auto !important;
}
.mr-auto, .mx-auto {
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
@media (min-width: 992px)
.br-br-md-0 {
    border-bottom-right-radius: 0 !important;
}
@media (min-width: 992px)
.br-tr-md-0 {
    border-top-right-radius: 0 !important;
}
.mr-1, .mx-1 {
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
.mb-0, .my-0 {
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
.owl-carousel .owl-item {
}
.owl-carousel .owl-item {
    position: relative;
    min-height: 1px;
    float: left;
    -webkit-backface-visibility: hidden;
    -webkit-tap-highlight-color: transparent;
    -webkit-touch-callout: none;
}
.owl-carousel .owl-wrapper, .owl-carousel .owl-item {
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
.owl-carousel .owl-item {
}
.owl-carousel .owl-item {
    position: relative;
    min-height: 1px;
    float: left;
    -webkit-backface-visibility: hidden;
    -webkit-tap-highlight-color: transparent;
    -webkit-touch-callout: none;
}
.owl-carousel .owl-wrapper, .owl-carousel .owl-item {
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
    transform: rotate(
45deg);
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
.cover-image {
    background-size: cover !important;
    width: 100%;
    position: relative;
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
a.bg-secondary:focus, a.bg-secondary:hover {
    background-color: #9c31df !important;
}
.font-weight-bold {
    font-weight: 700 !important;
}
.mb-3, .my-3 {
    margin-bottom: 0.75rem !important;
}
.item-card2-list li {
    width: 50%;
    float: left;
    margin-bottom: 0.5rem;
}
.card-bottom, .card-footer {
    padding: 0.5rem 1.5rem .5rem 1.5rem;
    background: 0 0;
}
.leading-normal {
    line-height: 1.5 !important;
}
.h5, h5 {
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
a.waves-effect, a.waves-light {
    display: inline-block;
}
.btn-floating {
    background: #29943F;
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
.bg-background-color .content-text, .bg-background .header-text1 {
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
    background: linear-gradient(
-225deg, rgba(74, 61, 184, 0.8) 48%, rgba(50, 228, 179, 0.8) 100%) !important;
}
*{margin: 0; padding: 0;}

.caja{

  display: flex;

  flex-flow: column wrap;

  justify-content: center;

  align-items: center;

  background: #333944;

}

.box{

    width: 100%;

    height: 160px;

  background: #CCC;

  overflow: hidden;

}
.box img{

  width: 100%;

  height: auto;

}

@supports(object-fit: cover){

    .box img{

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

    color:Gray;

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

.container-fluid {
    display: flex;
    justify-content: center;    
}


.col {
	margin: 10px;

}
.v-center{
  display: flex;
  align-items: center;
}

	.btn-zonas{
font-size: 18px;font-weight:bold;color:white;background: #29943f;border: 2px;border-color: white;width: 180px;height: 55px;border-style: solid;
	}
.btn:hover {
    color: #29943f;
    text-decoration: none;
    background-color: white;
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

<!-- Google tag (gtag.js) -->

<script async src="https://www.googletagmanager.com/gtag/js?id=G-7V6LNMERVY"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());
  gtag('config', 'G-7V6LNMERVY');

</script>
  </head>
  <body>
	  <div>
		<div>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding-bottom: 5px;padding-top: 5px;">
			 <div class="container" style="padding-top: -20px; padding-bottom: -20px;">
			  <a class="navbar-brand" href="https://www.3seedscommercial.mx/"><img src="../images/logo-blanco.png" alt="3Seeds Commercial" width="200px"></a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			  </button>
			  <div class="collapse navbar-collapse " id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
				  <li class="nav-item active">
					<a class="nav-link menu" href="https://www.3seedscommercial.mx/">Inicio<span class="sr-only">(current)</span></a>
				  </li>
		<!--		  <li class="nav-item">
					<a class="nav-link menu" href="mailto:hola@3seeds.mx">Contacto</a>
				  </li> -->
				</ul>
				<form  action="busqueda.php" method="post" class="form-inline my-2 my-lg-0">
				  <input type="text" class="form-control mr-sm-2" id="tex4" placeholder="Buscar" name="busqueda">
                    <div class="col-xl-2 col-lg-3 col-md-12 mb-0">

                    <!--<a href="#" class="btn btn-lg btn-block btn-primary br-tl-md-0 br-bl-md-0">Buscar</a>-->

                    <input type="hidden" id="tipo_bus1" name="tipo_busq1" value="0">
                    <input type="hidden" id="busquedaprin" name="busquedaprin" value="1">
                    <input type="hidden" id="tbusqda" name="tbusqda" value="M"> <!--zona -->
                    <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="Buscar">

                    </div>

				</form>
			  </div>
			</div>
			</nav>
		</div>	
	</div>
<!--Sliders Section-->		
<section>
	<div class="banner-1 cover-image sptb-2 sptb-tab bg-background2" data-image-src="..//images/3Seeds-min.png" style="background: url(&quot;..///images/3Seeds-min.png&quot;) center center;">
		<div class="header-text mb-0">
			<div class="container"> 
				<div class="text-center text-white mb-7">
					<h1 class="mb-1">3Seeds Commercial</h1>
					<p class="mt-5">En el competitivo mundo de bienes raíces, la clave para el éxito radica en la exposición adecuada de tu propiedad. En 3Seeds Commercial entendemos tus necesidades y estamos aquí para superar tus expectativas, nuestra tecnología de punta asegura que tu inversión inmobiliaria rinda frutos.</p>
					<p>Tus propiedades no solo se ven, se venden.</p>
				</div>
			</div>
		</div><!-- /header-text --> 
	</div>
</section>

<!--Selecciona zona-->
<section>
	<div class="bg-dark" style="background-color: green; padding-top: 80px; padding-bottom: 80px;">
		<div class=" pb-5"><img  src="../images/logo-blanco.png" alt="3Seeds Commercial" width="200px" style="display:block; margin-left:auto; margin-right:auto">
		</div>
		
		
		    <div class="container-fluid h-100"> 
        <div class="row w-100">
            <div class="col v-center">
               <a href="/principal.php" class="d-block mx-auto"><button class="btn btn-zonas d-block mx-auto" style="border-radius: 30px;"> Zona Norte </button></a>
            </div> 
        </div>
    </div>

		    <div class="container-fluid h-100"> 
        <div class="row w-100">
            <div class="col v-center">
              <a href="/zona-centro.php" class="d-block mx-auto"><button class="btn btn-zonas d-block mx-auto" style="border-radius: 30px;"> Zona Centro </button></a> 
            </div> 
        </div>
    </div>
		
		
	</div>
</section>
<!--Fin Selecciona zona-->
<section>
		  <div class="row col-12">
			<div class=" col-12">
			  <div class="row">
				<div class="col-lg-6 col-12 paddingf">
				  <h4>Zona Norte</h4>
					<img src="../images/logo-blanco.png" alt="3Seeds Commercial" width="200px">
				</div>
				<div class="col-lg-6 col-12 paddingf">
				  <h4 style="text-align: right">Zona Centro</h4>
					  <div>
						  <div>
						  <img src="../images/logo-blanco.png" alt="3Seeds Commercial" width="200px">
						  </div>
					  </div>
				</div>
				 <div class="paddingf">
					 <h3>Nosotros</h3>
					  <p>3Seeds Commercial es una empresa vanguardista, con gran experiencia y dinamismo; nace con el enfoque de conectar una extensa gama de servicios inmobiliarios.

						Nuestra meta es crear valor para nuestros clientes e inversionistas a través de soluciones inmobiliarias integrales en la renta, venta, desarrollo y búsquedas especializadas; en el sector residencial, oficinas, industrial y comercial; logrando proyectos patrimoniales, rentables y exitosos.</p>
				</div>
			  </div>
			</div>
		  </div>
</section>
	<footer>
		<div class="footer">
		  <div class="row col-12">
			<div class="col-md-8 col-12">
			  <div class="row">
				
			<div class="col-lg-4 col-12 paddingf">
						<h3>Contacto</h3>
							  <h6><span><i class="fa fa-map-marker mr-2 mb-2"></i></span><a href="#" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nuevo León, México</font></font></a></h6>
							  <h6><span><i class="fa fa-envelope mr-2 mb-2"></i></span><a href="mailto:hola@3seeds.mx" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> hola@3seeds.mx</font></font></a></h6>
							  <h6><span><i class="fa fa-phone mr-2  mb-2"></i></span><a href="tel:8125120161" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> +52 81 2512 0161</font></font></a>&nbsp;&nbsp;<a class="fab fa fa-whatsapp" href="https://wa.me/528125120161" target="_blank"></a></h6>
							 
				</div>
				<div class="col-lg-4 col-12 paddingf">
				   <h3></h3>
					<hr>
					  <div>
						  <div>
							  <h6><span><i class="fa fa-map-marker mr-2 mb-2"></i></span><a href="#" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Querétaro, México</font></font></a></h6>
							  <h6><span><i class="fa fa-envelope mr-2 mb-2"></i></span><a href="mailto:hola@3seeds.mx" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> hola@3seeds.mx</font></font></a></h6>
							  <h6><span><i class="fa fa-phone mr-2  mb-2"></i></span><a href="tel:4422448774" class="text-white"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> +52 442 244 8774</font></font></a>&nbsp;&nbsp;<a class="fab fa fa-whatsapp" href="https://wa.me/524422448774" target="_blank"></a></h6>
							
						  </div>
					  </div>
				</div>
			  </div>
			</div>
			<div class="col-md-4 col-4 mt-md-0 mt-2 paddingf">
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
        function actualizarElementos() {
            var categoriaSeleccionada = $('#ubicacionfrom').val();
            var elementoSelect = $('#municipiofrom');

            // Realizar una solicitud AJAX para obtener datos de MySQL
            $.ajax({
                type: 'POST',
                url: 'obtener_elementos.php', // Ruta al archivo PHP que manejará la consulta a la base de datos
                data: { estadop: categoriaSeleccionada, tip:2 },
                success: function(data) {
                    // Limpiar y llenar el segundo select con los datos obtenidos
                    elementoSelect.empty().append(data);
                }
            });
        }
    </script>
  </body>
</html>



