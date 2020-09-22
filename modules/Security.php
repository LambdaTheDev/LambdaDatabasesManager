<?php


class Security
{
    private static $AES_METHOD = 'aes-256-cbc';

    public static function AESEncrypt($data, $key)
    {
        $ivSize = openssl_cipher_iv_length(self::$AES_METHOD);
        $iv = openssl_random_pseudo_bytes($ivSize);

        $encryptedData = openssl_encrypt($data, self::$AES_METHOD, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encryptedData);
    }

    public static function AESDecrypt($data, $key)
    {
        $data = base64_decode($data);

        $ivSize = openssl_cipher_iv_length(self::$AES_METHOD);
        $iv = mb_substr($data, 0, $ivSize, '8bit');
        $decryptedData = mb_substr($data, $ivSize, null, '8bit');

        return openssl_decrypt($decryptedData, self::$AES_METHOD, $key, OPENSSL_RAW_DATA, $iv);
    }

    public static function randomString($length = 64)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = strlen($chars);
        $result = '';
        for ($i = 0; $i < $length; $i++)
        {
            $result .= $chars[rand(0, $length - 1)];
        }
        return $result;
    }

    public static function createSession($host, $port, $user, $pass)
    {
        $_SESSION['dbData']['host'] = $host;
        $_SESSION['dbData']['port'] = $port;
        $_SESSION['dbData']['user'] = $user;
        $_SESSION['dbData']['pass'] = $pass;
        $_SESSION['dbData']['loggedIn'] = true;
    }

    public static function isLoggedIn()
    {
        if(!empty($_SESSION['dbData']) && $_SESSION['dbData']['loggedIn']) return true;
        return false;
    }
}