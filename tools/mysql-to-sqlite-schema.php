<?php
/**
 * Convierte database/schema.sql (MySQL) a database/schema.sqlite.sql.
 * Se ejecuta a mano cuando se modifica el esquema:  php tools/mysql-to-sqlite-schema.php
 */
$src = dirname(__DIR__) . '/database/schema.sql';
$out = dirname(__DIR__) . '/database/schema.sqlite.sql';
$sql = file_get_contents($src);

preg_match_all('/CREATE TABLE IF NOT EXISTS\s+(\w+)\s*\((.*?)\)\s*ENGINE=/s', $sql, $tables, PREG_SET_ORDER);
$result  = ["-- paginasweb.gt — Esquema SQLite (generado por tools/mysql-to-sqlite-schema.php)", ""];
$indexes = [];

foreach ($tables as $m) {
    $table = $m[1];
    $body  = $m[2];
    $lines = array_filter(array_map('trim', explode("\n", $body)));
    $cols  = [];

    foreach ($lines as $line) {
        $line = rtrim($line, ',');
        if ($line === '' || str_starts_with($line, '--')) {
            continue;
        }
        if (preg_match('/^PRIMARY KEY \(id\)$/i', $line)) {
            continue;
        }
        if (preg_match('/^UNIQUE KEY \w+ \((.+)\)$/i', $line, $u)) {
            $cols[] = 'UNIQUE (' . $u[1] . ')';
            continue;
        }
        if (preg_match('/^KEY (\w+) \((.+)\)$/i', $line, $k)) {
            $indexes[] = sprintf('CREATE INDEX IF NOT EXISTS %s ON %s (%s);', $k[1], $table, $k[2]);
            continue;
        }
        if (preg_match('/^CONSTRAINT \w+ (FOREIGN KEY .+)$/i', $line, $f)) {
            $cols[] = $f[1];
            continue;
        }
        // Columna normal
        $line = preg_replace('/\bINT UNSIGNED NOT NULL AUTO_INCREMENT\b/i', 'INTEGER PRIMARY KEY AUTOINCREMENT', $line);
        $line = preg_replace('/\bINT UNSIGNED\b/i', 'INTEGER', $line);
        $line = preg_replace('/\bTINYINT\(1\)/i', 'INTEGER', $line);
        $line = preg_replace('/\bINT\b(?!EGER)/i', 'INTEGER', $line);
        $line = preg_replace('/\bVARCHAR\((\d+)\)/i', 'TEXT', $line);
        $line = preg_replace('/\b(LONGTEXT|MEDIUMTEXT)\b/i', 'TEXT', $line);
        $line = preg_replace('/\bDECIMAL\(\d+,\d+\)/i', 'REAL', $line);
        $line = preg_replace('/\bDATETIME\b/i', 'TEXT', $line);
        $cols[] = $line;
    }

    $result[] = sprintf("CREATE TABLE IF NOT EXISTS %s (\n  %s\n);", $table, implode(",\n  ", $cols));
    $result[] = '';
}

$result = array_merge($result, $indexes, ['']);
file_put_contents($out, implode("\n", $result));
echo "Generado: {$out}\n";
