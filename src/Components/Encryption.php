<?php

namespace App\Components;

class Encryption
{
    /**
     * @var string
     */
    private static string $method = 'aes256';

    /**
     * @var string
     */
    private static string $iv = '4nf6Jx9AU80Ns6s5';

    /**
     * @param string $str
     * 
     * @return string|false
     */
    public static function encrypt(string $str)
    {
        return base64_encode(openssl_encrypt($str, self::$method, $_ENV['ENCRYPTION_KEY'], OPENSSL_RAW_DATA, self::$iv));
    }

    /**
     * @param string $str
     * 
     * @return string|false
     */
    public static function decrypt(string $str)
    {
        return openssl_decrypt(base64_decode($str), self::$method, $_ENV['ENCRYPTION_KEY'], OPENSSL_RAW_DATA, self::$iv);
    }
}
