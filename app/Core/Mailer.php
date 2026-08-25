<?php
namespace App\Core;

/**
 * Envío de correo por mail() o SMTP simple (sin dependencias externas).
 */
class Mailer
{
    public static function send($to, $subject, $htmlBody, $replyTo = null)
    {
        $cfg  = \config('mail', []);
        $from = isset($cfg['from_email']) ? $cfg['from_email'] : 'no-reply@paginasweb.gt';
        $name = isset($cfg['from_name']) ? $cfg['from_name'] : 'paginasweb.gt';

        if (isset($cfg['driver']) && $cfg['driver'] === 'smtp' && !empty($cfg['smtp_host'])) {
            return self::sendSmtp($cfg, $to, $subject, $htmlBody, $replyTo);
        }

        $headers   = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: ' . self::encodeName($name) . ' <' . $from . '>';
        if ($replyTo) {
            $headers[] = 'Reply-To: ' . $replyTo;
        }
        $headers[] = 'X-Mailer: paginasweb.gt';

        return @mail($to, self::encodeName($subject), $htmlBody, implode("\r\n", $headers));
    }

    private static function encodeName($text)
    {
        return '=?UTF-8?B?' . base64_encode($text) . '?=';
    }

    private static function sendSmtp($cfg, $to, $subject, $htmlBody, $replyTo)
    {
        $host   = $cfg['smtp_host'];
        $port   = isset($cfg['smtp_port']) ? (int) $cfg['smtp_port'] : 587;
        $secure = isset($cfg['smtp_secure']) ? $cfg['smtp_secure'] : 'tls';
        $prefix = $secure === 'ssl' ? 'ssl://' : '';

        $socket = @fsockopen($prefix . $host, $port, $errno, $errstr, 15);
        if (!$socket) {
            return false;
        }
        $read = function () use ($socket) {
            $data = '';
            while ($line = fgets($socket, 515)) {
                $data .= $line;
                if (isset($line[3]) && $line[3] === ' ') {
                    break;
                }
            }
            return $data;
        };
        $cmd = function ($command) use ($socket, $read) {
            fwrite($socket, $command . "\r\n");
            return $read();
        };

        $read();
        $cmd('EHLO ' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost'));
        if ($secure === 'tls') {
            $cmd('STARTTLS');
            if (!@stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                fclose($socket);
                return false;
            }
            $cmd('EHLO ' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost'));
        }
        if (!empty($cfg['smtp_user'])) {
            $cmd('AUTH LOGIN');
            $cmd(base64_encode($cfg['smtp_user']));
            $cmd(base64_encode($cfg['smtp_pass']));
        }
        $cmd('MAIL FROM:<' . $cfg['from_email'] . '>');
        $cmd('RCPT TO:<' . $to . '>');
        $cmd('DATA');

        $headers  = 'From: ' . self::encodeName($cfg['from_name']) . ' <' . $cfg['from_email'] . ">\r\n";
        $headers .= 'To: <' . $to . ">\r\n";
        $headers .= 'Subject: ' . self::encodeName($subject) . "\r\n";
        if ($replyTo) {
            $headers .= 'Reply-To: ' . $replyTo . "\r\n";
        }
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";

        $result = $cmd($headers . $htmlBody . "\r\n.");
        $cmd('QUIT');
        fclose($socket);

        return strpos($result, '250') === 0;
    }

    /** Aviso al correo de la empresa cuando entra un mensaje del formulario. */
    public static function notifyNewMessage(array $data)
    {
        $to = Settings::get('form_notify_email', Settings::get('email'));
        if (!$to) {
            return false;
        }
        $rows = [
            'Nombre'   => $data['name'],
            'Correo'   => $data['email'],
            'Teléfono' => $data['phone'] !== '' ? $data['phone'] : '(no indicado)',
            'Servicio' => $data['service'] !== '' ? $data['service'] : '(no indicado)',
        ];
        $html = '<h2 style="font-family:sans-serif">Nueva solicitud desde paginasweb.gt</h2><table style="font-family:sans-serif;border-collapse:collapse">';
        foreach ($rows as $label => $value) {
            $html .= '<tr><td style="padding:4px 12px 4px 0"><strong>' . $label . '</strong></td><td style="padding:4px 0">' . htmlspecialchars((string) $value) . '</td></tr>';
        }
        $html .= '</table><p style="font-family:sans-serif"><strong>Mensaje:</strong></p><p style="font-family:sans-serif;white-space:pre-wrap">'
            . htmlspecialchars($data['message']) . '</p>';

        return self::send($to, 'Solicitud de cotización: ' . $data['name'], $html, $data['email']);
    }
}
