<?php
$f = 'c:\Proyectos\Desarrollo\aplicaciones\3seeds\principal.php';
$lines = file($f);
$start = -1;
$end = -1;
for ($i = 0; $i < count($lines); $i++) {
    if (strpos($lines[$i], '<?php } else { ?>') !== false && strpos($lines[$i + 1], '<!-- VISTA FILTRADA (CAROUSEL ORIGINAL) -->') !== false) {
        $start = $i;
    }
    if ($start !== -1 && $i > $start + 10 && strpos($lines[$i], '<?php } ?>') !== false && strpos($lines[$i + 3], '</section>') !== false) {
        $end = $i;
        break;
    }
}
if ($start !== -1 && $end !== -1) {
    $out = array();
    for ($i = 0; $i < count($lines); $i++) {
        if ($i >= $start && $i <= $end)
            continue;
        $out[] = $lines[$i];
    }
    file_put_contents($f, implode("", $out));
    echo "Removidos de linea " . ($start + 1) . " a " . ($end + 1);
} else {
    echo "No encontrado. Start: $start, End: $end";
}
