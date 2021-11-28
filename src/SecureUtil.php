<?php


namespace Xcy\Hutool;


/**
 * https://my.oschina.net/u/3403514/blog/1809008
 * Class SecureUtil
 * @package Xcy\Hutool
 */
class SecureUtil
{
    static $AES_128_CBC = "AES-128-CBC";

    static $AES_128_ECB = "AES-128-ECB";

    /**
     * 解密字符串
     * @param string $str
     * @param string $key
     * @param string|null $cipher
     * @return false|string
     */
    public static function decryptAes(string $str, string $key, string $cipher = null)
    {
        if (is_null($cipher)) {
            $cipher = self::$AES_128_CBC;
        }
        return openssl_decrypt(base64_decode($str), $cipher, $key,
            OPENSSL_RAW_DATA, $key);
    }

    /**
     * 加密字符串
     * @param string $str 字符串
     * @param string $key
     * @param string|null $cipher
     * @return string
     */
    public static function encryptAes(string $str, string $key, string $cipher = null): string
    {
        if (is_null($cipher)) {
            $cipher = self::$AES_128_CBC;
        }
        return base64_encode(openssl_encrypt($str, $cipher, $key,
            OPENSSL_RAW_DATA, $key));
    }
}
