<?php

namespace App\Support;

class WhatsApp
{
    /**
     * Buat link wa.me dengan pesan otomatis.
     */
    public static function link(string $message): string
    {
        $number = preg_replace('/\D+/', '', (string) config('tepikebun.whatsapp'));

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }
}
