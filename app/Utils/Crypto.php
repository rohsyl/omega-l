<?php
namespace Omega\Utils;

/*
 * @author : Roh Sylvain
 * @date : 2015.12.05 21:06
 *
 * @source :
 *  http://stackoverflow.com/questions/16600708/how-do-you-encrypt-and-decrypt-a-php-string#answer-30063506
 *
 * @comments :
 *  - If you run code and get this error: Fatal error: Call to undefined function mcrypt_create_iv(), make this:
 *      1. Edit php.ini file.
 *      2. Find ;mcrypt.so line and remove semicolon
 *      3. Restart Apache.
 *      4. Enjoy!
 *
 */
class Crypto
{
    private static $encrypt_method = "AES-256-CBC";

    public static function Encrypt($pure_string, $encryption_key) {

        $key = self::Key($encryption_key);
        $iv = self::Iv($encryption_key);
        $output = openssl_encrypt($pure_string, self::$encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public static function Decrypt($encrypted_string, $encryption_key) {
        $key = self::Key($encryption_key);
        $iv = self::Iv($encryption_key);
        $output = openssl_decrypt(base64_decode($encrypted_string), self::$encrypt_method, $key, 0, $iv);
        return $output;
    }

    private static function Key($key){
        return hash('sha256', $key);
    }

    private static function Iv($key){
        return substr(hash('sha256', $key), 0, 16);
    }
}
