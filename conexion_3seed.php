<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/*$hostname_connect = "localhost";
$database_connect = "seedscom_pruebas_laragon";
$username_connect = "root";
$password_connect = "";*/

$hostname_connect = "3seedscommercial.mx";
$database_connect = "seedscom_pruebas_laragon";
$username_connect = "seedscom";
$password_connect = "46BekX]6Id51Ap1";

$con = mysqli_connect($hostname_connect, $username_connect, $password_connect, $database_connect) or die(mysqli_connect_error());
mysqli_select_db($con, $database_connect) or die("Cannot select DB");
$con->set_charset("utf8");

// Desactivar ONLY_FULL_GROUP_BY para compatibilidad local
mysqli_query($con, "SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");




?>


