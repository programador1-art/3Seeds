<?php
     //conexión

    include_once("conexion_3seed.php");

    $idinmueble_aux="1";
    $hoy = date("Y-m-d");
    $id_p=$idinmueble_aux;

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?  echo $row_cs['descripcion']; ?>">
      <meta name="keywords" content="Inmobiliaria, casas, departamentos, terrenos, hogar">

    <title>3Seeds Comercial</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" rel="stylesheet" type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
/*#Icono WA footer*/
.fabs {
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
.product-slider .carousel-item img {
    width: 100%;
    height: auto;
}
@media (min-width: 992px) and (max-width: 1300px)
.product-slider #thumbcarousel .carousel-item .thumb {
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

.thumb {

    width: 100%;

    margin: 0 2px;

    display: inline-block;

    vertical-align: middle;

    cursor: pointer;

    max-width: 150px;
    max-height:100px;
    background-image: cover;
    object-position: center center;
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
.avatar-xxl {
    width: 5rem;
    height: 5rem;
    line-height: 5rem;
    font-size: 2rem;
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
.icon{
   width:40px;
   height: 40px;
   padding:3px;
}
.fcc-btn {
  color: white;
}
.fcc-btn:hover {
  color: white;
}
.box{
    width: 100%;
    height: 400px;
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
.caja {
    display: flex;
    flex-flow: column wrap;
    justify-content: center;
    align-items: center;
    background: #333944;
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

<!-- Más información-->

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Más información</font></font></h3>
    </div>
    <div class="card-body product-filter-desc">
      <form method="post">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingnombre" name="nombre_f" placeholder="Nombre completo" required>
      </div>
      <div class="form-floating mb-3">
        <input type="tel" class="form-control" id="floatingtelefono" name="telefono_f" placeholder="Teléfono" required>
      </div>
      <div class="form-floating mb-3">
        <input type="email" class="form-control" id="floatingmail" name="email_f" placeholder="Correo Electrónico" required>
      </div>
        <div class="form-floating mb-3">
          <textarea name="message_f" class="form-control" placeholder="Escribe tu mensaje..." style="auto; height:80px;" ></textarea>
      </div>
   <button type="submit" name="enviar" class="btn btn-primary">Enviar</button>

  </form>
    </div>
</div>
<?
$nombre_f = $_POST["nombre_f"];
$telefono_f = $_POST["telefono_f"];
$email_f = $_POST["email_f"];
$message_f = $_POST["message_f"];

if (isset($_POST['enviar'])) {
if (empty($nombre_f) || empty($telefono_f) ||empty($email_f) ) {
    echo '<script language="javascript">alert("Faltaron campos por llenar");</script>';

}else{
    $consulta_form="INSERT INTO historial_de_contacto(nombre, telefono, email, mensaje, inmuebles_idinmuebles, metodo_contacto) VALUES ('$nombre_f','$telefono_f','$email_f','$message_f','$idinmueble_aux', 'Formulario web')";
    $resultado_form = mysqli_query($con,$consulta_form);
    echo '<script language="javascript">alert("¡Recibimos tu información!, en breve nos contactaremos contigo para brindarte una mejor atención.");</script>';

 }}

?>
<!--Termina Más información-->
         


</body>

</html>



