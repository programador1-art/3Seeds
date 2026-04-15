---
description: Despliegue del proyecto 3Seeds Commercial a producción
---

# Workflow: Despliegue a Producción — 3Seeds Commercial

> **Antes de ejecutar este workflow**, asegúrate de que todos los cambios
> han sido probados y validados en el entorno local (Laragon).

---

## 1. Cambiar el entorno en `config_entorno.php`

En `config_entorno.php`, cambiar:

```php
// ANTES (local)
define('ENTORNO', 'local');

// DESPUÉS (producción)
define('ENTORNO', 'produccion');
```

---

## 2. Cambios de rutas de assets

Los siguientes archivos tienen rutas de assets que funcionan en Laragon
con ruta relativa simple. En producción deben mantenerse igual (sin `../`).

> ✅ **Los cambios actuales (`images/`, `css/`) son válidos tanto en local
> como en producción** — no requieren reversión.
>
> Las rutas originales (`../images/`, `..//css/`) estaban incorrectas
> también en producción.

### Archivos afectados:

| Archivo | Línea | Valor actual (local y prod) |
|---|---|---|
| `zona-norte.php` | 141 | `css/bootstrap-4.4.1.css` |
| `zona-norte.php` | 1813 | `images/logo-blanco.png` |
| `zona-norte.php` | 1839-1840 | `images/descubre_propiedad.png` |
| `busqueda.php` | 1636 | `images/logo-blanco.png` |

---

## 3. URLs absolutas a propiedades internas

Las siguientes líneas en `zona-norte.php` apuntan directamente a la URL
de producción. **En local, los links de "Ver propiedad" llevarán a producción.**

Si se desea que los links funcionen localmente, reemplazar `INTERNA_URL`:

```php
// Producción (actual en el código):
href="https://3seedscommercial.mx/interna.php?inm_ax=..."

// Local (si se quiere probar el detalle localmente):
href="interna.php?inm_ax=..."
```

### Líneas con URL hardcoded en `zona-norte.php`:
- Línea ~2291 (carousel-venta)
- Línea ~2362 (carousel-renta)
- Línea ~2435 (carousel-destacado)
- Línea ~2585 (tarjetas primera slide filtrada)
- Línea ~2844 (tarjetas segunda slide filtrada)

---

## 4. Correcciones de base de datos aplicadas

> ✅ Estos cambios son permanentes y válidos en ambos entornos.
> No requieren reversión para producción.

| Tabla/columna original (con acento) | Nombre corregido (sin acento) |
|---|---|
| `inmuebles_características` | `inmuebles_caracteristicas` |
| `cat_características` | `cat_caracteristicas` |
| `inmuebles_característicascol` | `inmuebles_caracteristicascol` |
| `cat_características_idcat_características` | `cat_caracteristicas_idcat_caracteristicas` |
| `idcat_características` | `idcat_caracteristicas` |

**Archivos corregidos:** `zona-norte.php` (líneas 2557-2569 y 2816-2828)

⚠️ **IMPORTANTE:** Asegurarse de que las tablas en la base de datos de
**producción (MySQL)** también usen los nombres SIN acento.

---

## 5. Correcciones de seguridad en `busqueda.php`

> ✅ Mejoras permanentes. No requieren reversión.

- SQL Injection: se sanitizan entradas con `mysqli_real_escape_string`, `intval`, `floatval`
- `$_POST` en inputs hidden: se usa `?? ''` y `htmlspecialchars()`
- Se eliminó uso de `$row_cs` antes de fetch (causaba Warning PHP)

---

## 6. Git — commit antes de desplegar

```bash
git add .
git commit -m "fix: corrección de rutas assets, nombres tablas BD y seguridad busqueda.php"
git push origin main
```

---

## 7. Verificación post-despliegue

- [ ] Logo carga correctamente en navbar
- [ ] Imagen `descubre_propiedad.png` visible en banner
- [ ] CSS Bootstrap carga (diseño correcto)
- [ ] Búsqueda funciona sin errores PHP
- [ ] Propiedades en Venta / Renta / Destacados se muestran
- [ ] Filtros de subtipo (Comercial/Industrial/Residencial) funcionan
- [ ] Sin errores en consola del navegador (F12)
