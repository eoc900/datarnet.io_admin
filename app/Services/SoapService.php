<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Helpers\EjemploCertificado;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ZipArchive;
use SoapClient;
use SoapFault;
use SoapHeader;
use Exception;
use SoapVar;

class SoapService
{
    protected $client;


    // Detalle del servicio de Carga de Títulos Electrónicos
    //https://metqa.siged.sep.gob.mx/met-ws/services/TitulosElectronicos.wsdl

    public function __construct($wsdl)
    {
        $wsdl = $wsdl; // Reemplaza con la URL del servicio
        $options = [
            'trace' => true,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'soap_version' => SOAP_1_1,
            'encoding' => 'UTF-8', // Asegurar que las peticiones se envíen en UTF-8
            'stream_context' => stream_context_create([
                'ssl' => [
                    'cafile' => storage_path('certs/cacert.pem'),
                    'verify_peer' => true, 
                    'verify_peer_name' => true,
                ],
            ]),
        ];


      

        $this->client = new SoapClient($wsdl, $options);
    }

    public function generarTitulo($nombreArchivo, $archivoBase64, $usuario, $password)
    {
         try {
            // Definir el namespace correcto
            $namespace = "http://ws.web.mec.sep.mx/schemas";

            // Estructura de autenticación
            $autenticacion = [
                'usuario' => $usuario,
                'password' => $password
            ];

            // Estructura de los parámetros
            $params = [
                'nombreArchivo' => $nombreArchivo,
                'archivoBase64' => $archivoBase64,
                'autenticacion' => $autenticacion // 🔹 Ahora el usuario y password están dentro de 'autenticacion'
            ];

            // Definir el Header vacío como lo requiere el servicio
            $header = new SoapHeader($namespace, 'Header');

            // Asignar el header a la petición
            $this->client->__setSoapHeaders([$header]);

            // Llamar al servicio SOAP
            $response = $this->client->__soapCall('cargaTituloElectronico', [$params]);

            // Verificar el request enviado (debugging)
            //echo $this->client->__getLastRequest();  
            $xmlRequest = $this->client->__getLastRequest();
            Storage::disk('local')->put('soap_requests/ultimo_request.xml', $xmlRequest);
            Log::channel('soap')->info("XML Enviado:\n" . $xmlRequest);
            return $response;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function generarTituloV2($nombreArchivo, $archivoBase64, $usuario, $password)
{
    try {
        Storage::disk('local')->put('valor_base64/antes_de_envia_en_generarTituloV2.xml',$archivoBase64);
        $namespace = "http://ws.web.mec.sep.mx/schemas";

         // Estructura de autenticación
        $autenticacion = [
            'usuario' => $usuario,
            'password' => $password
        ];

        // Parámetros corregidos (sin array de autenticación)
        $params = [
            'nombreArchivo'  => $nombreArchivo,
            'archivoBase64'  => new SoapVar($archivoBase64, XSD_STRING, 'string', 'http://www.w3.org/2001/XMLSchema'),
            'autenticacion' => $autenticacion // 🔹 Ahora el usuario y password están dentro de 'autenticacion'
        ];

        // Header vacío (como lo requiere el servicio)
        $header = new SoapHeader($namespace, 'Header');
        $this->client->__setSoapHeaders([$header]);

        // Llamar al servicio SOAP
        $response = $this->client->__soapCall('cargaTituloElectronico', [$params]);

        // Guardar el request XML enviado (para depuración)
        $xmlRequest = $this->client->__getLastRequest();
        Storage::disk('local')->put('soap_requests/ultimo_request.xml', $xmlRequest);
        Log::channel('soap')->info("XML Enviado:\n" . $xmlRequest);

        return $response;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}


     public function consultarLote($num_lote,$usuario, $password)
    {
         try {
            // Definir el namespace correcto
            $namespace = "http://ws.web.mec.sep.mx/schemas";

            // Estructura de autenticación
            $autenticacion = [
                'usuario' => $usuario,
                'password' => $password
            ];

            // Estructura de los parámetros
            $params = [
                'numeroLote' => $num_lote,
                'autenticacion' => $autenticacion // 🔹 Ahora el usuario y password están dentro de 'autenticacion'
            ];

            // Definir el Header vacío como lo requiere el servicio
            $header = new SoapHeader($namespace, 'Header');

            // Asignar el header a la petición
            $this->client->__setSoapHeaders([$header]);

            // Llamar al servicio SOAP
            $response = $this->client->__soapCall('consultaProcesoTituloElectronico', [$params]);

            // Verificar el request enviado (debugging)
            //echo $this->client->__getLastRequest();  

            return $response;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

  public function descargarLote($num_lote,$usuario, $password)
    {
         try {
            // Definir el namespace correcto
            $namespace = "http://ws.web.mec.sep.mx/schemas";
            $beanNamespace = "http://ws.web.mec.sep.mx/schemas/beans";
            // Estructura de autenticación
            $autenticacion = [
                'usuario' =>  new SoapVar($usuario, XSD_STRING, null, null, 'usuario', $beanNamespace),
                'password' => new SoapVar($password, XSD_STRING, null, null, 'password', $beanNamespace)
            ];

            // Estructura de los parámetros
            $params = [
                'numeroLote' => $num_lote,
                'autenticacion' => $autenticacion // 🔹 Ahora el usuario y password están dentro de 'autenticacion'
            ];

            // Definir el Header vacío como lo requiere el servicio
            $header = new SoapHeader($namespace, 'Header');
            $header2 = new SoapHeader($beanNamespace, 'Header');

            // Asignar el header a la petición
            $this->client->__setSoapHeaders([]);

            // Llamar al servicio SOAP
            $response = $this->client->__soapCall('descargaTituloElectronico', [$params]);

            // Verificar el request enviado (debugging)
            $xml = $this->client->__getLastRequest();  
            echo "<pre>" . htmlspecialchars($xml) . "</pre>";
            exit;

            // dd($xml);

            //return $response;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function descargarLoteV2($num_lote, $usuario, $password,$id_archivo)
    {
        try {
            $namespace = "http://ws.web.mec.sep.mx/schemas";
            $beanNamespace = "http://ws.web.mec.sep.mx/schemas/beans";

             // Estructura de autenticación
            // $autenticacion = [
            //     'usuario' =>  new SoapVar($usuario, XSD_STRING, null, null, 'usuario', $beanNamespace),
            //     'password' => new SoapVar($password, XSD_STRING, null, null, 'password', $beanNamespace)
            // ];

             $autenticacion = [
                'usuario' => $usuario,
                'password' => $password
            ];

            // Estructura de los parámetros
            $params = [
                'numeroLote' => $num_lote,
                'autenticacion' => $autenticacion // 🔹 Ahora el usuario y password están dentro de 'autenticacion'
            ];

            // Definir el Header vacío como lo requiere el servicio
            $header = new SoapHeader($namespace, 'Header');
            //$header2 = new SoapHeader($beanNamespace, 'Header');


            // NO agregamos headers porque el XML lo requiere vacío
            $this->client->__setSoapHeaders([]);

            // Llamar al servicio SOAP
            $response = $this->client->__soapCall('descargaTituloElectronico', [$params]);

            if (!isset($response->titulosBase64) || empty($response->titulosBase64)) {
                Log::error("Error: La respuesta SOAP no contiene 'titulosBase64'");
            }

            $contenido = $response->titulosBase64; // Extrae la cadena base64
            // Detectar la codificación
            $encoding = mb_detect_encoding($contenido, ['UTF-8', 'ISO-8859-1', 'Windows-1252', 'ASCII'], true);

            // Registrar la codificación detectada
 
            Log::warning("Codificación detectada: " . $encoding);

            if ($encoding && $encoding !== 'UTF-8') {
                $contenido = mb_convert_encoding($contenido, 'UTF-8', $encoding);
            }

            $xmlRequest = $this->client->__getLastRequest();
            Storage::disk('local')->put('soap_requests/ultimo_request.xml', $xmlRequest);
            Log::channel('soap')->info("XML Enviado:\n" . $xmlRequest);

            // OBTENEMOS EL VALOR REAL DE LA CODIFICACIÓN
              try {
                    // Obtener la respuesta cruda
                    $xmlResponse = $this->client->__getLastResponse();
                    Storage::disk('local')->put('soap_requests/ultimo_response.xml', $xmlResponse);
                     // Parsear el XML
                    $xml = new \SimpleXMLElement($xmlResponse);

                    // Registrar los namespaces
                    $namespaces = $xml->getNamespaces(true);

                    // Ir al Body
                    $body = $xml->children($namespaces['env'])->Body;

                    // Ir al nodo descargaTituloElectronicoResponse dentro del namespace correcto
                    $response = $body->children($namespaces[''])->descargaTituloElectronicoResponse;

                    // Obtener el contenido de titulosBase64
                    $titulosBase64 = (string) $response->titulosBase64;

                    // Puedes hacer algo con $titulosBase64 aquí
                    Log::info("Valor de titulosBase64: " . $titulosBase64);

                     // Define un nombre para el archivo
                    $nombreArchivo = 'ResultadoCargaTitulos' . $num_lote . '.zip';

                    $zipBinary = base64_decode($titulosBase64);
                    $nombreArchivo = 'ResultadoCargaTitulos' .$num_lote. '.zip';
                    $rutaZip = storage_path('app/archivos_zip/' . $nombreArchivo);
                    $rutaExtraccion = storage_path('app/archivos_zip/temp_' . $num_lote);
                    Storage::disk('local')->put('archivos_zip/' . $nombreArchivo, $zipBinary);
                    // Extraer ZIP
                    $zip = new ZipArchive;
                    if ($zip->open($rutaZip) === TRUE) {
                        $zip->extractTo($rutaExtraccion);
                        $zip->close();
                    } else {
                        throw new \Exception("No se pudo abrir el archivo ZIP.");
                    }

                    // Buscar el primer archivo .xls extraído
                    $archivos = glob($rutaExtraccion . '/*.xls');
                    if (empty($archivos)) {
                        throw new \Exception("No se encontró ningún archivo .xls en el ZIP.");
                    }
                    $rutaXLS = $archivos[0]; // Primer archivo .xls
                    
                    $spreadsheet = IOFactory::load($rutaXLS);
                    $sheet = $spreadsheet->getActiveSheet();
                    $filas = $sheet->toArray(null, true, true, true); // Opciones para conservar letras de columna

                    $datosJson = [];

                    foreach ($filas as $i => $fila) {
                        if ($i === 1) continue; // Saltar encabezado

                        $folioControl = trim($fila['D'] ?? '');

                        if (!empty($folioControl)) {
                            $datosJson[$folioControl] = [
                                'ESTATUS' => trim($fila['B'] ?? ''),
                                'DESCRIPCION' => trim($fila['C'] ?? '')
                            ];
                        }
                    }

                    $nombreJson = 'resultado_' . $num_lote . '.json';
                    Storage::disk('local')->put('archivos_json/' . $nombreJson, json_encode($datosJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));




                } catch (SoapFault $e) {
                    Storage::disk('local')->put('soap_requests/ultimo_response.txt', $e->getMessage());
                }

            // $response->titulosBase64 = $contenido;
            // Log::warning("base64: " .json_encode($response));

            return $response;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



// Esta función se asemeja lo más posible a la estructura xml requerida pero muestra mensaje: 
// public function descargarLote($num_lote, $usuario, $password)
// {
//     try {
//         // Definir los namespaces
//         $namespace = "http://ws.web.mec.sep.mx/schemas"; // ns1
//         $beanNamespace = "http://ws.web.mec.sep.mx/schemas/beans"; // ns2

//         // Estructura de autenticación con el namespace correcto (ns2)
//         $autenticacion = [
//             'usuario' => new SoapVar($usuario, XSD_STRING, null, null, 'usuario', $beanNamespace),
//             'password' => new SoapVar($password, XSD_STRING, null, null, 'password', $beanNamespace)
//         ];

//         // Estructura de los parámetros
//         $params = [
//             'numeroLote' => $num_lote,
//             'autenticacion' => new SoapVar($autenticacion, SOAP_ENC_OBJECT, null, null, 'autenticacion', $beanNamespace),
//         ];

//         // No es necesario agregar headers adicionales, ya que el header debe estar vacío
//         $this->client->__setSoapHeaders([]);

//         // Llamar al servicio SOAP
//         $response = $this->client->__soapCall('descargaTituloElectronico', [$params]);

//         // Verificar el request enviado (debugging)
//         $xml = $this->client->__getLastRequest();
//         dd($xml);

//         return $response;
//     } catch (Exception $e) {
//         return ['error' => $e->getMessage()];
//     }
// }

 

}