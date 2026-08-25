<?php
namespace App\Core;

/**
 * Autenticación del panel: hash seguro, límite de intentos y bloqueo temporal.
 */
class Auth
{
    private const MAX_ATTEMPTS = 5;
    private const LOCK_MINUTES = 15;

    public static function startSession(array $config): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => $https,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_name('PWGT_SESS');
        session_start();
    }

    public static function attempt(string $email, string $password, string $ip): array
    {
        $email = mb_strtolower(trim($email));

        if (self::isLocked($email, $ip)) {
            return ['ok' => false, 'error' => 'Demasiados intentos fallidos. Esperá ' . self::LOCK_MINUTES . ' minutos antes de volver a intentar.'];
        }

        $user = Database::first('SELECT * FROM users WHERE email = ? AND active = 1', [$email]);
        $valid = $user && password_verify($password, $user['password_hash']);

        self::logAttempt($email, $ip, $valid);

        if (!$valid) {
            return ['ok' => false, 'error' => 'Correo o contraseña incorrectos.'];
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            Database::update('users', ['password_hash' => password_hash($password, PASSWORD_DEFAULT)], 'id = :id', ['id' => $user['id']]);
        }

        session_regenerate_id(true);
        $_SESSION['user_id']   = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['must_change_password'] = (int) $user['must_change_password'];
        $_SESSION['last_activity'] = time();

        Database::update('users', ['last_login_at' => date('Y-m-d H:i:s')], 'id = :id', ['id' => $user['id']]);

        return ['ok' => true, 'user' => $user];
    }

    private static function logAttempt(string $email, string $ip, bool $success): void
    {
        Database::insert('login_attempts', [
            'email'      => mb_substr($email, 0, 190),
            'ip'         => mb_substr($ip, 0, 45),
            'success'    => $success ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        if ($success) {
            Database::delete('login_attempts', 'email = ? AND success = 0', [$email]);
        }
        // Limpieza de registros viejos (más de 7 días)
        Database::delete('login_attempts', 'created_at < ?', [date('Y-m-d H:i:s', time() - 604800)]);
    }

    public static function isLocked(string $email, string $ip): bool
    {
        $since = date('Y-m-d H:i:s', time() - self::LOCK_MINUTES * 60);
        $count = (int) Database::value(
            'SELECT COUNT(*) FROM login_attempts WHERE success = 0 AND created_at > ? AND (email = ? OR ip = ?)',
            [$since, mb_strtolower($email), $ip]
        );
        return $count >= self::MAX_ATTEMPTS;
    }

    public static function check(): bool
    {
        if (empty($_SESSION['user_id'])) {
            return false;
        }
        // Expiración por inactividad: 2 horas
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 7200) {
            self::logout();
            return false;
        }
        $_SESSION['last_activity'] = time();
        return true;
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        return Database::first('SELECT * FROM users WHERE id = ?', [$_SESSION['user_id']]);
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    public static function requireLogin(string $loginUrl): void
    {
        if (!self::check()) {
            header('Location: ' . $loginUrl);
            exit;
        }
    }
}
