<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Helpers\EjemploCertificado;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Symfony\Component\HttpFoundation\StreamedResponse;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;



class GenerarTitulo
{

    protected $id_Institucion = 20633;
    protected $nombre_Institucion = "CENTRO DE ESTUDIOS DE IRAPUATO";

    // Debe de arrojar true, es parte fundamental del proceso
    public static function catalogoTablasCompleto(){

        $tablas = ["tablas"=>[
                    "modulo_alumnos_pruebas"=>false, // quitar o agregar el modulo_alumnos sin _pruebas
                    "modulo_autorizacion_reconocimiento"=>false,
                    "modulo_info_carreras_actualizada"=>false,
                    "modulo_entidades_federativas"=>false,
                    "modulo_servicio_social"=>false,
                    "modulo_tipo_estudio_antecedente"=>false,
                    "modulo_modalidad_titulacion"=>false,
                    "modulo_cargos_responsables"=>false,
                    "modulo_instituciones"=>false
        ]];
        foreach($tablas["tablas"] as $index=>$valor){
                if (!Schema::hasTable($index)) {
                    Log::channel('titulos')->error('Tabla de base de datos no encontrada: '.$index.' por favor asegúrate de tener todas las tablas necesarias.');
                    return ["estado"=>false,"tabla"=>$index];
                }
        }
        return ["estado"=>true];
    }

    public static function verificarExistenciaObjetosXML($alumno,$carrera,$modalidad,$entidad,$servicio,$tipo_estudio_antecedente,$entidad_antecedente){
    
        if(!$alumno){
            Log::channel('titulos')->error('Hubo un error asociado a la tabla de alumnos de pruebas');
            return [false,"Hubo un error asociado a la tabla de alumnos de pruebas"];
        }
        if(!$carrera){
            Log::channel('titulos')->error('Hubo un error asociado a la tabla de Carreras irapuato');
            return [false,"Hubo un error asociado a la tabla de Carreras irapuato"];
        }
        if(!$modalidad){
            Log::channel('titulos')->error('Hubo un error asociado a la tabla modalidad de titulación');
            return [false,"Hubo un error asociado a la tabla modalidad de titulación"];
        }
        if(!$entidad){
            Log::channel('titulos')->error('Hubo un error asociado a la tabla entidades');
            return [false,"Hubo un error asociado a la tabla entidades"];
        }
        if(!$servicio){
            Log::channel('titulos')->error('Hubo un error asociado a la tabla servicio social');
            return [false,"Hubo un error asociado a la tabla servicio social"];
        }
        if(!$tipo_estudio_antecedente){
            Log::channel('titulos')->error('Hubo un error asociado a la tabla de tipos de estudios antecedentes');
            return [false,"Hubo un error asociado a la tabla de tipos de estudios antecedentes"];
        }
        if(!$entidad_antecedente){
            Log::channel('titulos')->error('Hubo un error asociado a la tabla entidades');
            return [false,"Hubo un error asociado a la tabla de entidades para estudios antecedentes"];
        }

        Log::channel('titulos')->info('Todos los objetos identificados en los catálogos.');
        return [true,"Todos los objetos identificados en los catálogos"];
    }

    public static function atributosTituloElectronico($folio_control){
            $top_part = [
                'TituloElectronico' => [
                    '@attributes' => [
                        'xmlns' => 'https://www.siged.sep.gob.mx/titulos/',
                     //   'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                        'version' => '1.0',
                        'folioControl' => $folio_control // Se genera dinamicamente
                    // 'xsi:schemaLocation' => 'https://www.siged.sep.gob.mx/titulos/ schema.xsd'
                    ]
            ]];

            return $top_part;
    }

    public static function topXMLElement($arr) {
        // Verificar si existen las claves necesarias antes de acceder a ellas
        $xmlns = $arr["TituloElectronico"]["@attributes"]["xmlns"] ?? '';
        $version = $arr["TituloElectronico"]["@attributes"]["version"] ?? '';
        $folioControl = $arr["TituloElectronico"]["@attributes"]["folioControl"] ?? '';
        
        // Crear la estructura XML correctamente
        $xml = new \SimpleXMLElement(
            '<TituloElectronico xmlns="'.$xmlns.'" version="'.$version.'" folioControl="'.$folioControl.'"></TituloElectronico>'
    );

    return $xml;
}

    public static function retornarXMLString($xml){
         // Crear un DOMDocument para formatear el XML
        $dom = new \DOMDocument('1.0', 'UTF-8'); // Especificar versión y encoding
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        // Cargar el XML generado por SimpleXMLElement en el DOMDocument
        $dom->loadXML($xml->asXML());
        // Guardar el XML formateado
        $xmlString = $dom->saveXML();
        if (strpos($xmlString, '<?xml') === 0) {
                // Si ya tiene una declaración XML, reemplazarla con una que incluya el encoding
                $xmlString = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . substr($xmlString, strpos($xmlString, "\n") + 1);
        }
        return $xmlString;
    }

     

    public static function nodoFirmaResponsables(){
        $tituloElectronico = [
               
                    'FirmaResponsables' => [
                        'FirmaResponsable' => [
                            '@attributes' => [
                                'nombre' => Str::upper('Eugenio'),
                                'primerApellido' => Str::upper('Ortiz'),
                                'segundoApellido' => Str::upper('del Hoyo'),
                                'curp' => 'OIHE660420HGTRYG00',
                                'idCargo' => '9', // Director General
                                'cargo' => Str::upper('Director General'),
                                'abrTitulo' => 'LIC.',
                                'sello' => '', // Se consigue dinamicamente en el paso 2
                                'certificadoResponsable' => 'MIIGSDCCBDCgAwIBAgIUMDAwMDEwMDAwMDA3MDUxMTgyOTQwDQYJKoZIhvcNAQEL
                                    BQAwggGVMTUwMwYDVQQDDCxBQyBERUwgU0VSVklDSU8gREUgQURNSU5JU1RSQUNJ
                                    T04gVFJJQlVUQVJJQTEuMCwGA1UECgwlU0VSVklDSU8gREUgQURNSU5JU1RSQUNJ
                                    T04gVFJJQlVUQVJJQTEaMBgGA1UECwwRU0FULUlFUyBBdXRob3JpdHkxMjAwBgkq
                                    hkiG9w0BCQEWI3NlcnZpY2lvc2FsY29udHJpYnV5ZW50ZUBzYXQuZ29iLm14MSYw
                                    JAYDVQQJDB1Bdi4gSGlkYWxnbyA3NywgQ29sLiBHdWVycmVybzEOMAwGA1UEEQwF
                                    MDYzMDAxCzAJBgNVBAYTAk1YMQ0wCwYDVQQIDARDRE1YMRMwEQYDVQQHDApDVUFV
                                    SFRFTU9DMRUwEwYDVQQtEwxTQVQ5NzA3MDFOTjMxXDBaBgkqhkiG9w0BCQITTXJl
                                    c3BvbnNhYmxlOiBBRE1JTklTVFJBQ0lPTiBDRU5UUkFMIERFIFNFUlZJQ0lPUyBU
                                    UklCVVRBUklPUyBBTCBDT05UUklCVVlFTlRFMB4XDTI0MDIxMzIxNDIwM1oXDTI4
                                    MDIxMzIxNDI0M1owgdMxHzAdBgNVBAMTFkVVR0VOSU8gT1JUSVogREVMIEhPWU8x
                                    HzAdBgNVBCkTFkVVR0VOSU8gT1JUSVogREVMIEhPWU8xHzAdBgNVBAoTFkVVR0VO
                                    SU8gT1JUSVogREVMIEhPWU8xCzAJBgNVBAYTAk1YMSwwKgYJKoZIhvcNAQkBFh1j
                                    dWVudGFzcG9yY29icmFyQGxtZXJjLmNvbS5teDEWMBQGA1UELRMNT0lIRTY2MDQy
                                    MFFYMjEbMBkGA1UEBRMST0lIRTY2MDQyMEhHVFJZRzAwMIIBIjANBgkqhkiG9w0B
                                    AQEFAAOCAQ8AMIIBCgKCAQEArj+u5941YgAwoQXcFCeeGm0vjhJYhq0M+6l5refS
                                    5P4L6udcRoVWO6w+21n7ceKsdZ9CAL4sr3F9XiGjapZNHBrhy6Fz4NKXMp8FNZfC
                                    VXA2RzkXbyQcmFtYZU4iYqEtZ2FdCh3uobPSEuiiKWATObG/1yK2E0V6vlrqRfuL
                                    WmmgjJ6mbnH+yH9cL5b4lAxb7oTWcmfYd5GH+a99eXbdKByigecqlZxa/FJ/zzJr
                                    BeLFjdFy0pkOmyK/dxLkDzQVuGpqoArQoy0Pa4ZOfVFlA6TVtAYJoBSimXp0ztG6
                                    Ki8FNXfY33sTrwXO9BlHGfcYwogCPn4+TAc5RmREm9Z/XQIDAQABo08wTTAMBgNV
                                    HRMBAf8EAjAAMAsGA1UdDwQEAwID2DARBglghkgBhvhCAQEEBAMCBaAwHQYDVR0l
                                    BBYwFAYIKwYBBQUHAwQGCCsGAQUFBwMCMA0GCSqGSIb3DQEBCwUAA4ICAQAS5oD+
                                    B/r1Uz0mmpyPaZjE6w5M41XaF5bZpr2W+hSpkI0mqElQYXnKp7xj6B/a7xOCpZll
                                    pWkrqtQmq9+yH9ysIv2ij3bnAI8twpmGSIP/oGUSM0hoX4f7eRU1A6SrjZG7fiHd
                                    LWIjKWJjo/yuMXBP0eXSthL6DE2SMsS5Ohd4Vqp8zV8+6n7683Ce4axwPefAQ8qc
                                    l0SLkKpCnQRPSK3lZaEI2MbM8R7EzRSsCM2U3UmNGeSKn87jGgB9yNakK4/AOj5f
                                    /TvdKQlIY9giFacu1vyn+XBq+856sZy4G6BefHEn7eWocP5vl+b3O4RFh77FupBt
                                    Qi9rLs4kecbwXwuM3EwKRjhFxD2aX35yRgAmqH6Wzj1NIN5ez8AqxX/d3lzEY/Aj
                                    DMTexI0IWKnICzWqbJ4cu50+QsnVhwHqH0xYL102fj4s3YXaMitrdvokP9deWBU1
                                    w2QAMuwxHummtYZBVVLxFCEvSiz41KKZxbBr2o5PZQV5qZ8vsBT47RJDFMT9wTMg
                                    6qC5+wAZbEOj59OGGjhNdcmVrrHJ/c0fu+V70leHb1Vd2Ppo0B3qOSvl9+axNq3C
                                    IyfjHNkhjVVHZcs4Dv+jiKYUZHF3pK4tfboUQvXsTT/pmrIk3An90pL17K0766Ak
                                    Z+wtDcP+URaMnMhGWihAzz3lSI/IUQZzIXcgGA==',
                                'noCertificadoResponsable'=>'00001000000705118294'
                                ]
                        ]
                    ]
            ];
        
            $tituloElectronico["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["certificadoResponsable"] = preg_replace('/\s+/', '', $tituloElectronico["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["certificadoResponsable"]);
            return $tituloElectronico;
    }

    public static function datosTitulo($carrera,$fecha_terminacion,$alumno,$fecha_expedicion,$modalidad,$entidad,$servicio=[],$fecha_examen_prof=null,$fecha_exencion=null,$inicio_carrera=null,$antecedente=[]){
            // Obtener idModalidadTitulacion
        $idModalidadTitulacion = $modalidad->id_modalidad_titulacion ?? null;

        // Obtener valores de fechas
        $fechaExamenProfesional = $fecha_examen_prof ?? null;
        $fechaExencionExamenProfesional = $fecha_exencion ?? null;
         // Validaciones según la modalidad de titulación
        if ($idModalidadTitulacion >= 2 && $idModalidadTitulacion <= 6) {
            if ($fechaExencionExamenProfesional === null) {
                Log::channel('titulos')->error("Error: función datosTitulos fechaExencionExamenProfesional no puede ser null si idModalidadTitulacion = {$idModalidadTitulacion}");
                return false;
            }
            $fechaExamenProfesional = null; // Debe ser una cadena vacía
        } elseif ($idModalidadTitulacion == 1) {
            if ($fechaExamenProfesional === null) {
                Log::channel('titulos')->error("Error: función datosTitulos fechaExencionExamenProfesional no puede ser null si idModalidadTitulacion = 1");
                return false;
            }
            $fechaExencionExamenProfesional = null; // Debe ser null
        }
        
        $datosTitulo = [
                'Institucion' => ["@attributes"=>[
                    'cveInstitucion' => '110468', //cambió antes estaba puesto con valor de id_Institucion
                    'nombreInstitucion' => 'CENTRO DE ESTUDIOS DE IRAPUATO',
                ]],
                'Carrera' => ["@attributes"=>[
                    'cveCarrera' => trim($carrera->cve_carrera), // contamos con 4 claves
                    'nombreCarrera' => Str::upper(trim($carrera->desc_titulo)),
                    'fechaInicio' => $inicio_carrera ?? '',
                    'fechaTerminacion' => $fecha_terminacion,
                    'idAutorizacionReconocimiento' => '1',
                    'autorizacionReconocimiento' => 'RVOE FEDERAL',
                    'numeroRvoe'=> trim($carrera->num_rvoe)
                ]],
                'Profesionista' => ["@attributes"=>[
                    'curp' => Str::upper(trim($alumno->curp)),
                    'nombre' => self::escapeXmlAttributeValue(Str::upper(trim($alumno->nombre))),
                    'primerApellido' => self::escapeXmlAttributeValue(Str::upper(trim($alumno->primer_apellido))),
                    'segundoApellido' => self::escapeXmlAttributeValue(Str::upper(trim($alumno->segundo_apellido))),
                    'correoElectronico' => trim($alumno->correo_electronico),
                ]],
                'Expedicion' => ["@attributes"=>[
                    'fechaExpedicion' => $fecha_expedicion,
                    'idModalidadTitulacion' => $modalidad->id_modalidad_titulacion,
                    'modalidadTitulacion' => $modalidad->modalidad_titulacion,
                    'fechaExamenProfesional' => $fechaExamenProfesional ?? '', // opcional
                    'fechaExencionExamenProfesional'=>$fechaExencionExamenProfesional?? '',  // opcional
                    'cumplioServicioSocial' => 1, 
                    'idFundamentoLegalServicioSocial' =>(empty($servicio))?'1':$servicio->id_fundamento_legal_servicio_social, // VALOR FIJO
                    'fundamentoLegalServicioSocial' => (empty($servicio))?'ART. 52 LRART. 5 CONST':$servicio->fundamento_legal_servicio_social,
                    'idEntidadFederativa' => $entidad->id_excel,
                    'entidadFederativa' => $entidad->entidad,
                ]],
                'Antecedente' => ["@attributes"=>[
                    'institucionProcedencia' => self::escapeXmlAttributeValue(Str::upper(trim($antecedente["escuela_antecedente"]))),
                    'idTipoEstudioAntecedente' => $antecedente["id_tipo_antecedente"],
                    'tipoEstudioAntecedente' => $antecedente["nombre_tipo_antecedente"],
                    'idEntidadFederativa' => $antecedente['id_entidad_federativa_antecedente'],
                    'entidadFederativa' => $antecedente["entidad_antecedente"],
                    'fechaInicio' => $antecedente["fecha_inicio"],
                    'fechaTerminacion' => $antecedente["fecha_terminacion"],
                ]],
            ];

            // Verificar y eliminar 'segundoApellido' si está vacío
            if (isset($datosTitulo['Profesionista']['@attributes']['segundoApellido']) && $datosTitulo['Profesionista']['@attributes']['segundoApellido'] === '') {
                unset($datosTitulo['Profesionista']['@attributes']['segundoApellido']);
            }

            // Verificar y eliminar 'fechaExamenProfesional' si está vacío
            if (isset($datosTitulo['Carrera']['@attributes']['fechaInicio']) && $datosTitulo['Carrera']['@attributes']['fechaInicio'] === '') {
                unset($datosTitulo['Carrera']['@attributes']['fechaInicio']);
            }


            // Verificar y eliminar 'fechaExamenProfesional' si está vacío
            if (isset($datosTitulo['Expedicion']['@attributes']['fechaExamenProfesional']) && $datosTitulo['Expedicion']['@attributes']['fechaExamenProfesional'] === '') {
                unset($datosTitulo['Expedicion']['@attributes']['fechaExamenProfesional']);
            }

            // Verificar y eliminar 'fechaExencionExamenProfesional' si está vacío
            if (isset($datosTitulo['Expedicion']['@attributes']['fechaExencionExamenProfesional']) && $datosTitulo['Expedicion']['@attributes']['fechaExencionExamenProfesional'] === '') {
                unset($datosTitulo['Expedicion']['@attributes']['fechaExencionExamenProfesional']);
            }


            return $datosTitulo;
    }

    public static function arregloCadenaOriginal($nodoTituloElectronico,$nodoFirmasResponsables,$nodoDatosTitulo){
        // Obtener idModalidadTitulacion
        $idModalidadTitulacion = $nodoDatosTitulo["Expedicion"]["@attributes"]["idModalidadTitulacion"] ?? null;

        // Obtener valores de fechas
        $fechaExamenProfesional = $nodoDatosTitulo["Expedicion"]["@attributes"]["fechaExamenProfesional"] ?? null;
        $fechaExencionExamenProfesional = $nodoDatosTitulo["Expedicion"]["@attributes"]["fechaExencionExamenProfesional"] ?? null;
         // Validaciones según la modalidad de titulación
        if ($idModalidadTitulacion >= 2 && $idModalidadTitulacion <= 6) {
            if ($fechaExencionExamenProfesional === null) {
                Log::channel('titulos')->error("Error: La fecha de exención de examen profesional no puede ser null para idModalidadTitulacion {$idModalidadTitulacion}");
                return false;
            }
            $fechaExamenProfesional = null; // Debe ser una cadena vacía
        } elseif ($idModalidadTitulacion == 1) {
            if ($fechaExamenProfesional === null) {
                Log::channel('titulos')->error("Error: La fecha de examen profesional no puede ser null para idModalidadTitulacion 1");
                return false;
            }
            $fechaExencionExamenProfesional = null; // Debe ser null
        }


         
        $cadena_original = [
                $nodoTituloElectronico["TituloElectronico"]["@attributes"]["version"]??'',
                $nodoTituloElectronico["TituloElectronico"]["@attributes"]["folioControl"]??'',
                $nodoFirmasResponsables["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["curp"]??'',
                $nodoFirmasResponsables["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["idCargo"]??'',
                $nodoFirmasResponsables["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["cargo"]??'',
                $nodoFirmasResponsables["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["abrTitulo"]??'',
                $nodoDatosTitulo["Institucion"]["@attributes"]["cveInstitucion"]??'',
                $nodoDatosTitulo["Institucion"]["@attributes"]["nombreInstitucion"]??'',
                $nodoDatosTitulo["Carrera"]["@attributes"]["cveCarrera"]??'',
                $nodoDatosTitulo["Carrera"]["@attributes"]["nombreCarrera"]??'',
                $nodoDatosTitulo["Carrera"]["@attributes"]["fechaInicio"]??'',
                $nodoDatosTitulo["Carrera"]["@attributes"]["fechaTerminacion"]??'',
                $nodoDatosTitulo["Carrera"]["@attributes"]["idAutorizacionReconocimiento"]??'',
                $nodoDatosTitulo["Carrera"]["@attributes"]["autorizacionReconocimiento"]??'', 
                $nodoDatosTitulo["Carrera"]["@attributes"]["numeroRvoe"], // En nuestro caso no es opcional
                $nodoDatosTitulo["Profesionista"]["@attributes"]["curp"],
                $nodoDatosTitulo["Profesionista"]["@attributes"]["nombre"],
                $nodoDatosTitulo["Profesionista"]["@attributes"]["primerApellido"],
                $nodoDatosTitulo["Profesionista"]["@attributes"]["segundoApellido"]??'',
                $nodoDatosTitulo["Profesionista"]["@attributes"]["correoElectronico"],
                $nodoDatosTitulo["Expedicion"]["@attributes"]["fechaExpedicion"],
                $idModalidadTitulacion,
                $nodoDatosTitulo["Expedicion"]["@attributes"]["modalidadTitulacion"],
                $fechaExamenProfesional??'', // Modificado según validación
                $fechaExencionExamenProfesional??'', // Modificado según validación
                $nodoDatosTitulo["Expedicion"]["@attributes"]["cumplioServicioSocial"],
                $nodoDatosTitulo["Expedicion"]["@attributes"]["idFundamentoLegalServicioSocial"],
                $nodoDatosTitulo["Expedicion"]["@attributes"]["fundamentoLegalServicioSocial"],
                $nodoDatosTitulo["Expedicion"]["@attributes"]["idEntidadFederativa"],
                $nodoDatosTitulo["Expedicion"]["@attributes"]["entidadFederativa"],
                $nodoDatosTitulo["Antecedente"]["@attributes"]["institucionProcedencia"],
                $nodoDatosTitulo["Antecedente"]["@attributes"]["idTipoEstudioAntecedente"],
                $nodoDatosTitulo["Antecedente"]["@attributes"]["tipoEstudioAntecedente"],
                $nodoDatosTitulo["Antecedente"]["@attributes"]["idEntidadFederativa"],
                $nodoDatosTitulo["Antecedente"]["@attributes"]["entidadFederativa"],
                $nodoDatosTitulo["Antecedente"]["@attributes"]["fechaInicio"]??'',
                $nodoDatosTitulo["Antecedente"]["@attributes"]["fechaTerminacion"]??'',
                "" //noCedula
            ];
           // Generar la cadena con formato correcto
            $cadena = "||" . implode("|", $cadena_original) . "||";

            // Construir la ruta del archivo asegurando la extensión .txt
            $nombreArchivo = $nodoTituloElectronico["TituloElectronico"]["@attributes"]["folioControl"] . ".txt";
            $ruta = "cadenas_generadas/{$nombreArchivo}";

            // Guardar el archivo en storage/app/cadenas_generadas/
            Storage::put($ruta, $cadena);
          

            return $cadena;
    }

    public static function escapeXmlAttributeValue($value) {
        // Reemplaza los caracteres especiales por sus entidades correspondientes
        $value = str_replace('&', '&amp;', $value);  // & -> &amp;
        $value = str_replace('"', '&quot;', $value); // " -> &quot;
        $value = str_replace('<', '&lt;', $value);   // < -> &lt;
        $value = str_replace('>', '&gt;', $value);   // > -> &gt;
        $value = str_replace("â", '&apos;', $value); // ' -> &apos;
        return $value;
    }

    public function getIDInstitucion(){
        return $this->id_Institucion;
    }
    public function getNombreInstitucion(){
        return $this->nombre_Institucion;
    }

   public function generarZipBase64($arr_docs_xml, $filename = "nombre_no_asignado.zip")
{
    $folder = 'titulos'; // Carpeta donde están los archivos XML
    $zipFileName = Str::endsWith($filename, '.zip') ? $filename : "$filename.zip";
    $zipPath = storage_path("app/zips/$zipFileName"); // Ruta del ZIP
    $archivosLocalizados = []; // Agregamos los nombres si existen (sin .xml sólo nombre o num de folio)

    // Verificar si el array está vacío
    if (empty($arr_docs_xml)) {
        return response()->json(["error" => "No se proporcionaron identificadores"], 400);
    }

    // Crear el objeto ZIP
    $zip = new ZipArchive;
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        return response()->json(["error" => "No se pudo crear el archivo ZIP"], 500);
    }

    $archivosAgregados = 0;

    // Iterar sobre los identificadores para agregar archivos al ZIP
    foreach ($arr_docs_xml as $identificador) {
        $filePath = storage_path("app/$folder/$identificador.xml");

        // Verificar si el archivo existe antes de agregarlo
        if (file_exists($filePath)) {
            $zip->addFile($filePath, "$identificador.xml");
            $archivosLocalizados[] = $identificador;
            $archivosAgregados++;
        }
    }

    // Cerrar el ZIP
    $zip->close();

    // Si no se agregaron archivos, eliminar el ZIP y devolver error
    if ($archivosAgregados === 0) {
        unlink($zipPath);
        return response()->json(["error" => "No se encontraron archivos XML"], 404);
    }

    // Leer el ZIP y convertirlo a Base64
    $zipContent = file_get_contents($zipPath);
    $base64Zip = base64_encode($zipContent);
    $base64Zip = str_replace(["\r", "\n"], '', $base64Zip);

    // Eliminar el ZIP después de la conversión
   // unlink($zipPath);

   // Guardar el archivo base64
   
    Storage::disk('local')->put("zips_base64/$filename.base64", $base64Zip);
    Log::channel('titulos')->info("El documento $filename.base64 fue guardado exitosamente.");

    return ["base64_zip" =>$base64Zip,
    "archivos_encontrados"=>$archivosAgregados,
    "archivos_utilizados"=>$archivosLocalizados,
    "nombre_archivo"=>$zipFileName];
}

public function generarZipBase64Prueba($arr_docs_xml, $filename = "nombre_no_asignado.zip")
{
    $folderOrigen = 'titulos';
    $zipBaseName = pathinfo($filename, PATHINFO_FILENAME);
    $folderPadre = "padre_$zipBaseName";
    $folderHija = "$folderPadre/$zipBaseName";
    $zipFileName = Str::endsWith($filename, '.zip') ? $filename : "$filename.zip";
    $zipPath = storage_path("app/zips/$zipFileName");
    $archivosLocalizados = [];

    if (empty($arr_docs_xml)) {
        return response()->json(["error" => "No se proporcionaron identificadores"], 400);
    }

    // Crear ZIP
    $zip = new ZipArchive;
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        return response()->json(["error" => "No se pudo crear el archivo ZIP"], 500);
    }

    $archivosAgregados = 0;

    foreach ($arr_docs_xml as $identificador) {
        $filePathOrigen = storage_path("app/$folderOrigen/$identificador.xml");

        if (file_exists($filePathOrigen)) {
            $zip->addFile($filePathOrigen, "$folderHija/$identificador.xml");
            $archivosLocalizados[] = $identificador;
            $archivosAgregados++;
        }
    }

    $zip->close();

    if ($archivosAgregados === 0) {
        unlink($zipPath);
        return response()->json(["error" => "No se encontraron archivos XML"], 404);
    }

    // Validar que el ZIP existe antes de leerlo
    if (!file_exists($zipPath)) {
        return response()->json(["error" => "El archivo ZIP no fue encontrado en $zipPath"], 404);
    }

    $zipContent = file_get_contents($zipPath);
    $base64Zip = base64_encode($zipContent);

    // Asegurar que la carpeta exista
    Storage::makeDirectory('zips_base64');
    $base64Path = storage_path("app/zips_base64/$zipBaseName.base64");
    file_put_contents($base64Path, $base64Zip);

    Log::channel('titulos')->info("ZIP creado: $zipPath");
    Log::channel('titulos')->info("Base64 guardado en: $base64Path");

    return [
        "base64_zip" => $base64Zip,
        "archivos_encontrados" => $archivosAgregados,
        "archivos_utilizados" => $archivosLocalizados,
        "nombre_archivo" => $zipBaseName
    ];
}

public function generarZipBase64Simple($arr_docs_xml, $filename = "nombre_no_asignado.zip")
{
    $folderOrigen = 'titulos';
    $zipBaseName = pathinfo($filename, PATHINFO_FILENAME);
    $folderContenedor = $zipBaseName; // Carpeta única dentro del ZIP
    $zipFileName = Str::endsWith($filename, '.zip') ? $filename : "$filename.zip";
    $zipPath = storage_path("app/zips/$zipFileName");
    $archivosLocalizados = [];

    if (empty($arr_docs_xml)) {
        return response()->json(["error" => "No se proporcionaron identificadores"], 400);
    }

    // Crear ZIP
    $zip = new ZipArchive;
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        return response()->json(["error" => "No se pudo crear el archivo ZIP"], 500);
    }

    $archivosAgregados = 0;

    foreach ($arr_docs_xml as $identificador) {
        $filePathOrigen = storage_path("app/$folderOrigen/$identificador.xml");

        if (file_exists($filePathOrigen)) {
            $zip->addFile($filePathOrigen, "$folderContenedor/$identificador.xml");
            $archivosLocalizados[] = $identificador;
            $archivosAgregados++;
        }
    }

    $zip->close();

    if ($archivosAgregados === 0) {
        unlink($zipPath);
        return response()->json(["error" => "No se encontraron archivos XML"], 404);
    }

    // Validar que el ZIP existe antes de leerlo
    if (!file_exists($zipPath)) {
        return response()->json(["error" => "El archivo ZIP no fue encontrado en $zipPath"], 404);
    }

    $zipContent = file_get_contents($zipPath);
    $base64Zip = base64_encode($zipContent);

    // Asegurar que la carpeta exista
    Storage::makeDirectory('zips_base64');
    $base64Path = storage_path("app/zips_base64/$zipBaseName.base64");
    file_put_contents($base64Path, $base64Zip);

    Log::channel('titulos')->info("ZIP creado: $zipPath");
    Log::channel('titulos')->info("Base64 guardado en: $base64Path");

    return [
        "base64_zip" => $base64Zip,
        "archivos_encontrados" => $archivosAgregados,
        "archivos_utilizados" => $archivosLocalizados,
        "nombre_archivo" => $zipBaseName
    ];
}






public function cancelarLote(Request $request){
    
}

}
