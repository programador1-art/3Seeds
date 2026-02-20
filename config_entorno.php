<?php
/**
 * config_entorno.php
 * ═══════════════════════════════════════════════════════════
 * Archivo de configuración de entorno para 3Seeds Commercial.
 * Cambia SOLO la constante ENTORNO para alternar entre local y producción.
 *
 * ENTORNOS DISPONIBLES:
 *   'local'      → Laragon (http://localhost/3seeds/ o http://3seeds.test/)
 *   'produccion' → Servidor real (https://3seedscommercial.mx)
 * ═══════════════════════════════════════════════════════════
 */

// ┌─────────────────────────────────────────────────────────┐
// │  ⚙️  CAMBIA ESTE VALOR SEGÚN EL ENTORNO ACTUAL          │
// └─────────────────────────────────────────────────────────┘
define('ENTORNO', 'local'); // 'local' | 'produccion'


// ─────────────────────────────────────────────────────────────
// Configuración automática según el entorno seleccionado
// ─────────────────────────────────────────────────────────────
if (ENTORNO === 'produccion') {

    // URL base del sitio en producción
    define('BASE_URL', 'https://3seedscommercial.mx/');

    // Prefijo de rutas para assets (css, js, images)
    // En producción los PHP están en la raíz del dominio
    define('ASSET_PATH', '');

    // URL interna de propiedades
    define('INTERNA_URL', 'https://3seedscommercial.mx/interna.php');

} else {
    // ENTORNO LOCAL (Laragon)

    // URL base del sitio local
    define('BASE_URL', 'http://localhost/3seeds/');

    // Prefijo de rutas para assets
    define('ASSET_PATH', '');

    // URL interna de propiedades (local)
    define('INTERNA_URL', 'interna.php');
}
