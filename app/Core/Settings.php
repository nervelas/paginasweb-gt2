<?php
namespace App\Core;

/** Configuración global editable desde el panel (tabla settings). */
class Settings
{
    private static array $cache = [];
    private static bool $loaded = false;

    public static function load(): void
    {
        if (self::$loaded) {
            return;
        }
        self::$cache = [];
        foreach (Database::all('SELECT setting_key, setting_value FROM settings') as $row) {
            self::$cache[$row['setting_key']] = $row['setting_value'];
        }
        self::$loaded = true;
    }

    public static function get(string $key, $default = null)
    {
        self::load();
        $v = self::$cache[$key] ?? null;
        return ($v === null || $v === '') ? $default : $v;
    }

    public static function all(): array
    {
        self::load();
        return self::$cache;
    }

    public static function set(string $key, ?string $value): void
    {
        self::load();
        $exists = Database::value('SELECT COUNT(*) FROM settings WHERE setting_key = ?', [$key]);
        if ($exists) {
            Database::update('settings', ['setting_value' => $value], 'setting_key = :k', ['k' => $key]);
        } else {
            Database::insert('settings', ['setting_key' => $key, 'setting_value' => $value]);
        }
        self::$cache[$key] = $value;
    }

    /** Número de WhatsApp en formato internacional solo dígitos. */
    public static function whatsappDigits(): string
    {
        return preg_replace('/\D+/', '', (string) self::get('whatsapp', ''));
    }

    public static function whatsappLink(?string $message = null): string
    {
        $msg = $message ?? self::get('whatsapp_message', 'Hola, quiero cotizar una página web.');
        return 'https://wa.me/' . self::whatsappDigits() . '?text=' . rawurlencode($msg);
    }

    public static function telLink(): string
    {
        return 'tel:' . preg_replace('/[^\d\+]/', '', (string) self::get('phone_e164', self::get('phone', '')));
    }
}
