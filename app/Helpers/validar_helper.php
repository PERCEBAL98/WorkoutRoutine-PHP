<?php
use CodeIgniter\CodeIgniter;

if (!function_exists('rellenarDato')) {
    function rellenarDato($errors, $datos, $campo) {
        $valor = "";

        if (isset($errors[$campo]))
            $valor = $datos[$campo];
        else {
            $valor = (set_value($campo) != "") ? set_value($campo) : $datos[$campo];
        }

        return $valor;
    }
}
?>