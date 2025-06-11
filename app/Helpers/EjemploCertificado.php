<?php

namespace App\Helpers;

use Exception;

class EjemploCertificado
{
    /**
     * Firma una cadena original con una llave privada y genera el sello
     *
     * @param string $cadena_original Cadena a firmar
     * @param string $rutaKey Ruta de la llave privada (.key.pem)
     * @param string $rutaCer Ruta del certificado público (.cer.pem)
     * @return array
     */
    public static function firmarCadena($cadena_original, $rutaKey, $rutaCer,$pass)
    {
        try {
            if (!file_exists($rutaKey) || !file_exists($rutaCer)) {
                throw new Exception("No se encontraron los archivos de llave o certificado.");
            }

            // Obtener clave privada
            $private_key = openssl_get_privatekey(file_get_contents($rutaKey),$pass);

            if (!$private_key) {
                $errorMessage = openssl_error_string(); // Obtiene el error específico
                throw new Exception("No se pudo obtener la clave privada: ".$errorMessage);
            }

            // Firmar la cadena original
            $exito = openssl_sign($cadena_original, $firma, $private_key, OPENSSL_ALGO_SHA256);
            openssl_free_key($private_key);

            if (!$exito) {
                throw new Exception("No se pudo firmar la cadena.");
            }

            // Convertir la firma a Base64
            $sello = base64_encode($firma);

            // Obtener clave pública
            $public_key = openssl_pkey_get_public(file_get_contents($rutaCer));

            if (!$public_key) {
                $errorMessage = openssl_error_string(); 
                throw new Exception("No se pudo obtener la clave pública. Error: ".$errorMessage);
            }

            // Verificar la firma
            $resultado = openssl_verify($cadena_original, $firma, $public_key, "sha256WithRSAEncryption");

            return [
                "cadena_original" => $cadena_original,
                "sello" => base64_encode($firma),
                "verificacion" => $resultado === 1 ? 1 : 0,
            ];
        } catch (Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
