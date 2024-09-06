<?php

namespace Atomir\AtomirCore\Encryption;

class Cardnumberencryption
{

    function encryptCardNumber($cardNumber, $key) {
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($cardNumber, $cipher, $key, 0, $iv);
        return base64_encode($iv . $ciphertext);
    }


    function decryptCardNumber($encryptedCardNumber, $key) {
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $data = base64_decode($encryptedCardNumber);
        $iv = substr($data, 0, $ivlen);
        $ciphertext = substr($data, $ivlen);
        return openssl_decrypt($ciphertext, $cipher, $key, 0, $iv);
    }

}