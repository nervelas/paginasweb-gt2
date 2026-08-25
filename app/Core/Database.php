<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Conexión PDO única (MySQL o SQLite) con helpers cortos.
 */
class Database
{
    private static ?PDO $pdo = null;
    private static string $driver = 'mysql';

    public static function connect(array $cfg): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }
        self::$driver = $cfg['driver'] ?? 'mysql';

        if (self::$driver === 'sqlite') {
            $path = $cfg['sqlite_path'];
            $dir  = dirname($path);
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            $dsn = 'sqlite:' . $path;
            self::$pdo = new PDO($dsn, null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            self::$pdo->exec('PRAGMA foreign_keys = ON');
            return self::$pdo;
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $cfg['host'],
            (int)($cfg['port'] ?? 3306),
            $cfg['database'],
            $cfg['charset'] ?? 'utf8mb4'
        );
        self::$pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
        return self::$pdo;
    }

    public static function pdo(): PDO
    {
        if (!self::$pdo instanceof PDO) {
            throw new PDOException('La base de datos no está conectada.');
        }
        return self::$pdo;
    }

    public static function driver(): string
    {
        return self::$driver;
    }

    public static function isConnected(): bool
    {
        return self::$pdo instanceof PDO;
    }

    public static function run(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function all(string $sql, array $params = []): array
    {
        return self::run($sql, $params)->fetchAll();
    }

    public static function first(string $sql, array $params = []): ?array
    {
        $row = self::run($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    public static function value(string $sql, array $params = [])
    {
        $row = self::run($sql, $params)->fetch(PDO::FETCH_NUM);
        return $row === false ? null : $row[0];
    }

    public static function insert(string $table, array $data): int
    {
        $cols = array_keys($data);
        $sql  = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', $cols),
            implode(', ', array_map(fn($c) => ':' . $c, $cols))
        );
        self::run($sql, $data);
        return (int) self::pdo()->lastInsertId();
    }

    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $sets = implode(', ', array_map(fn($c) => $c . ' = :' . $c, array_keys($data)));
        $sql  = sprintf('UPDATE %s SET %s WHERE %s', $table, $sets, $where);
        return self::run($sql, array_merge($data, $whereParams))->rowCount();
    }

    public static function delete(string $table, string $where, array $params = []): int
    {
        return self::run(sprintf('DELETE FROM %s WHERE %s', $table, $where), $params)->rowCount();
    }

    /**
     * Ejecuta un archivo .sql completo: quita comentarios de línea y
     * corre cada sentencia por separado.
     */
    public static function runSchema($sql)
    {
        $clean = preg_replace('/^\s*--.*$/m', '', $sql);
        foreach (explode(';', $clean) as $statement) {
            $statement = trim($statement);
            if ($statement === '') {
                continue;
            }
            self::pdo()->exec($statement);
        }
    }

    /** Devuelve true si la tabla existe (sirve para saber si ya se instaló). */
    public static function tableExists(string $table): bool
    {
        try {
            if (self::driver() === 'sqlite') {
                return (bool) self::value(
                    "SELECT COUNT(*) FROM sqlite_master WHERE type='table' AND name = ?",
                    [$table]
                );
            }
            self::run('SELECT 1 FROM ' . $table . ' LIMIT 1');
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
