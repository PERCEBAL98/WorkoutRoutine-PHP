<?php

use CodeIgniter\CodeIgniter;
use CodeIgniter\Encryption\Encryption;


if (!function_exists('baseUrl')) {
    function baseUrl()
    {
        $baseUrl = "http://workoutroutine.es";
        return $baseUrl;
    }
}

if (!function_exists('formatear_fecha_español')) {
    function formatear_fecha_español($fecha)
    {
        if ($fecha != "") {
            preg_match('/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
            $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
            return $lafecha;
        } else return "";
    }
}

if (!function_exists('formatear_fecha_hora_español')) {
    function formatear_fecha_hora_español($fecha)
    {
        if ($fecha != "") {
            preg_match('/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})\s?([0-9]{0,2}):?([0-9]{0,2})?:?([0-9]{0,2})?/', $fecha, $mifecha);
            
            $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
            
            $lahora = isset($mifecha[4]) && $mifecha[4] !== "" ? sprintf(" %02d:%02d:%02d", $mifecha[4], $mifecha[5] ?? 0, $mifecha[6] ?? 0) : "";
            
            return $lafecha . $lahora;
        } else return "";
    }
}


if (!function_exists('cambiarFormatoAMysql')) {
    function cambiarFormatoAMysql($fecha)
    {
        preg_match('/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2,4})/', $fecha, $mifecha);
        $lafecha = $mifecha[3] . "-" . $mifecha[2] . "-" . $mifecha[1];
        return $lafecha;
    }
}

if (!function_exists('encriptar')) {
    function encriptar($str)
    {
        $encrypter = \Config\Services::encrypter();
        $encriptado = $encrypter->encrypt($str);
        return rtrim(strtr(base64_encode($encriptado), '+/', '-_'), '=');
    }
}

if (!function_exists('desencriptar')) {
    function desencriptar($hash)
    {
        $encrypter = \Config\Services::encrypter();
        $decodificado = base64_decode(strtr($hash, '-_', '+/'));
        return $encrypter->decrypt($decodificado);
    }
}

?>