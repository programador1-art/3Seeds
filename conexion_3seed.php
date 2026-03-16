<?php
/**
 * Conexión a base de datos — las credenciales se cargan desde un archivo
 * que en producción debe estar FUERA de public_html.
 *
 * Ruta en producción: /home/seedscom/config/db_credentials.php
 * Ruta en local:      config/db_credentials.php (dentro del proyecto)
 */

require_once __DIR__ . '/config_entorno.php';

// Control de errores según entorno
if (ENTORNO === 'produccion') {
    error_reporting(0);
    ini_set('display_errors', '0');
} else {
    error_reporting(E_ALL ^ E_NOTICE);
    ini_set('display_errors', '1');
}

// En producción, buscar credenciales fuera de public_html; en local, dentro del proyecto
$credentials_path_prod = dirname(__DIR__) . '/config/db_credentials.php';
$credentials_path_local = __DIR__ . '/config/db_credentials.php';

if (ENTORNO === 'produccion' && file_exists($credentials_path_prod)) {
    require_once $credentials_path_prod;
} elseif (file_exists($credentials_path_local)) {
    require_once $credentials_path_local;
} else {
    die('No se encontró el archivo de credenciales de base de datos.');
}

$con = mysqli_connect($hostname_connect, $username_connect, $password_connect, $database_connect) or die(mysqli_connect_error());
mysqli_select_db($con, $database_connect) or die("Cannot select DB");
$con->set_charset("utf8");

// Desactivar ONLY_FULL_GROUP_BY para compatibilidad local
mysqli_query($con, "SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
