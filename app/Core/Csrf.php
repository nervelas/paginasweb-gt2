<?php
namespace App\Core;

/** Tokens CSRF por sesión, con rotación acotada. */
class Csrf
{
    private const KEY = '_csrf_tokens';
    private const MAX = 12;

    public static function token(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return '';
        }
        $tokens = $_SESSION[self::KEY] ?? [];
        $token  = bin2hex(random_bytes(32));
        $tokens[] = $token;
        if (count($tokens) > self::MAX) {
            $tokens = array_slice($tokens, -self::MAX);
        }
        $_SESSION[self::KEY] = $tokens;
        return $token;
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_token" value="' . htmlspecialchars(self::token(), ENT_QUOTES) . '">';
    }

    public static function check(?string $token): bool
    {
        if (!$token || session_status() !== PHP_SESSION_ACTIVE) {
            return false;
        }
        $tokens = $_SESSION[self::KEY] ?? [];
        foreach ($tokens as $i => $t) {
            if (hash_equals($t, $token)) {
                unset($_SESSION[self::KEY][$i]);
                $_SESSION[self::KEY] = array_values($_SESSION[self::KEY]);
                return true;
            }
        }
        return false;
    }

    /** Aborta con 419 si el token no es válido. */
    public static function verifyOrFail(): void
    {
        if (!self::check($_POST['_token'] ?? null)) {
            http_response_code(419);
            exit('Sesión expirada o token inválido. Recargá la página e intentá de nuevo.');
        }
    }
}
