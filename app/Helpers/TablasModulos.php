<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class TablasModulos{

        // En tu método crearTablaDinamica:
        public function crearTablaDinamica($nombreTabla, $columnas, $tipos_datos, $llavePrimaria = null, $assoc_nullable = [], $assoc_limites = [], $assoc_foraneas = [], $assoc_unicos=[]) 
        {
        if (!Schema::hasTable($nombreTabla)) {
            Schema::create($nombreTabla, function (Blueprint $table) use ($columnas, $tipos_datos, $llavePrimaria, $assoc_nullable, $assoc_limites,$assoc_foraneas,$assoc_unicos) {
                
                // Si no se especifica llave primaria, usar id automático
                if (!$llavePrimaria && !in_array('id', $columnas)) {
                    $table->id();
                }
                
                foreach ($columnas as $index => $columna) {
                    $tipo = $tipos_datos[$index] ?? "Cadena";
                    $isNullable = $assoc_nullable[$columna] ?? false;
                    $limit = $assoc_limites[$columna] ?? null;
                    
                    // Convertir tipo almacenado ("varchar") a tipo para creación ("Cadena")
                    $tipoCreacion = match(strtolower($tipo)) {
                        'bigint' => 'BigEntero/Llaveforanea',
                        'varchar' => 'Cadena',
                        'int' => 'Entero',
                        'boolean' => 'Booleano',
                        'datetime' => 'Fecha/Tiempo',
                        'date' => 'Fecha',
                        'time' => 'Tiempo',
                        'decimal' => 'Decimal',
                        default => $tipo
                    };
                    
                    $column = match ($tipoCreacion) {
                        "Entero" => $table->integer($columna),
                        "BigEntero" => $table->unsignedBigInteger($columna),
                        "Decimal" => $table->decimal($columna, 8, 2),
                        "Booleano" => $table->boolean($columna),
                        "Cadena" => isset($limit) ? $table->string($columna, $limit) : $table->string($columna),
                        "Fecha/Tiempo" => $table->datetime($columna),
                        "Fecha" => $table->date($columna),
                        "Tiempo" => $table->time($columna),
                        "BigEntero/Llaveforanea"=>$table->unsignedBigInteger($columna),
                        default => $table->string($columna)
                    };

                    if ($assoc_unicos[$columna] ?? false) {
                        $column->unique();
                    }
                    
                    if ($isNullable) {
                        $column->nullable();
                    }

                      // 👇 Si es llave foránea, agregar la relación
                    if (array_key_exists($columna, $assoc_foraneas)) {
                        $referencia = $assoc_foraneas[$columna];
                        $table->foreign($columna)
                            ->references($referencia['columna'])
                            ->on($referencia['tabla'])
                            ->onDelete('cascade'); // puedes cambiar esto si deseas restrict, set null, etc.
                    }
                }
                
                // Establecer llave primaria solo si se especifica y es diferente de 'id'
                if ($llavePrimaria && $llavePrimaria !== 'id') {
                    $table->primary($llavePrimaria);
                }
                
                $table->timestamps();
            });
        }
    }

    public function existeTabla($nombreTabla) {
        if (Schema::hasTable($nombreTabla)) {
            return true;
        } else {
            return false;
        }
    }

    public function leerColumnas($archivoPath)
    {
        // Cargar el archivo
        $spreadsheet = IOFactory::load(storage_path("app/archivos/".Auth::user()->name."_".Auth::user()->lastname."/"."{$archivoPath}"));
        $hoja = $spreadsheet->getActiveSheet(); 

        // Obtener la primera fila (nombres de columnas)
        $columnas = [];
        foreach ($hoja->getRowIterator(1, 1) as $fila) {
            foreach ($fila->getCellIterator() as $celda) {
                $valor = trim((string) $celda->getFormattedValue());
                if (strlen($valor) > 0) {
                    $columnas[] = Str::lower($valor);
                }
            }
        }

        return $columnas; // Retornamos el arreglo con los nombres de las columnas
    }



    public function importarDatosDesdeExcel($nombreTabla, $fileName) {
        // Obtén la ruta completa del archivo desde storage
        $filePath = storage_path("app/archivos/{$fileName}");

        // Verifica si el archivo existe
        if (!file_exists($filePath)) {
            return false;
        }

        // Carga el archivo Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(); // Convierte la hoja en un array

        if (empty($data) || count($data) < 2) {
            return false;
        }

        // Obtener nombres de las columnas desde la primera fila del Excel
        $columnas = array_map('trim', $data[0]); // La primera fila son los nombres de las columnas

        // Elimina la primera fila (encabezados)
        array_shift($data);

        // Inserción de datos en la tabla
        foreach ($data as $i=>$fila) {
         
            $registro = [];
            foreach ($columnas as $index => $columna) {
                   Log::info("Procesando fila #{$index}: ", $fila);
                if (isset($fila[$index])) {
                    $registro[Str::lower($columna)] = $fila[$index]; // Asigna el valor correspondiente
                }
            }
            // Insertar en la tabla creada dinámicamente
            DB::table($nombreTabla)->insert($registro);
        }

        return true;
    }

    public function pruebaExistenciaArchivo($nombreTabla, $fileName){
          $filePath = storage_path("app/archivos/".Auth::user()->name."_".Auth::user()->lastname."/"."{$fileName}");

        // Verifica si el archivo existe
        if (!file_exists($filePath)) {
            return false;
        }else{
            return true;
        }

    }

    public function obtenerArreglo($nombreTabla, $fileName){
         // Obtén la ruta completa del archivo desde storage
        $filePath = storage_path("app/archivos/".Auth::user()->name."_".Auth::user()->lastname."/"."{$fileName}");

        // Verifica si el archivo existe
        if (!file_exists($filePath)) {
            return false;
        }

        // Carga el archivo Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(); // Convierte la hoja en un array
        
        $columnas = array_map('trim', $data[0]); // La primera fila son los nombres de las columnas
        array_shift($data);

        $prueba = array();
        foreach ($data as $fila) {
            $registro = [];
            foreach ($columnas as $index => $columna) {
                if (isset($fila[$index])) {
                    $registro[$columna] = $fila[$index]; // Asigna el valor correspondiente
                }
            }
            // Insertar en la tabla creada dinámicamente
           $prueba[] = $registro;
        }

        
        return $prueba;
    }

 

    public function obtenerArregloV2($nombreTabla, $fileName, $user = "")
    {
        $userFolder = $user ?: Auth::user()->name . "_" . Auth::user()->lastname;
        $filePath = storage_path("app/archivos/{$userFolder}/{$fileName}");

        if (!file_exists($filePath)) {
            Log::error("🚨 Archivo no encontrado: {$filePath}");
            return false;
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true); // Mantiene las celdas vacías

        if (empty($data)) {
            Log::warning("⚠️ El archivo {$fileName} está vacío.");
            return [];
        }

        $rawHeader = array_shift($data);
        $columnas = [];

        // Solo incluimos columnas con encabezado válido
        foreach ($rawHeader as $key => $value) {
            $limpio = trim($value);
            if ($limpio !== "") {
                $columnas[$key] = Str::lower($limpio);
            }
        }

        $resultado = [];

        foreach ($data as $filaIndex => $fila) {
            // Filtramos para solo los campos definidos en encabezados
            $registro = [];

            foreach ($columnas as $colKey => $nombreCol) {
                $valorCelda = $fila[$colKey] ?? null;
                $registro[$nombreCol] = is_string($valorCelda) ? trim($valorCelda) : $valorCelda;
            }

            // Si todos los campos de este registro están vacíos, saltarlo
            if (empty(array_filter($registro, fn($v) => $v !== null && $v !== ""))) {
                Log::warning("⚠️ Fila {$filaIndex} vacía en {$fileName}, saltándola.");
                continue;
            }

            $resultado[] = $registro;
        }

        return $resultado;
    }


    public function obtenerArregloV3($nombreTabla, $fileName, $request, $nombresColumnasEsperadas = [], $user = "")
{
    // Validar usuario y ruta del archivo
   // Ruta actualizada para archivos temporales
    $filePath = storage_path("app/archivos/temporal/{$fileName}");

    if (!file_exists($filePath)) {
        throw new \Exception("El archivo {$fileName} no existe en la ruta temporal.");
    }
    

    // Cargar datos del Excel
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    if (empty($data)) {
        Log::warning("⚠️ El archivo {$fileName} está vacío.");
        return [];
    }

    // Procesar encabezados
    $columnas = array_map('trim', $data[0]);
    
    // Validar columnas contra las esperadas (case sensitive)
    if (!empty($nombresColumnasEsperadas)) {
        if ($columnas !== $nombresColumnasEsperadas) {
            throw new \Exception("Las columnas del archivo no coinciden exactamente con las columnas esperadas de la tabla.");
        }
    }

    array_shift($data); // Eliminar fila de encabezados

    // Obtener metadatos de la tabla
    $columnasTabla = DB::table('columnas_tablas')
        ->where('id_tabla', function($query) use ($nombreTabla) {
            $query->select('id')
                ->from('tablas_modulos')
                ->where('nombre_tabla', $nombreTabla);
        })
        ->where('activo', true)
        ->get()
        ->keyBy('nombre_columna');

    // Identificar llave primaria
    $llavePrimaria = $columnasTabla->where('es_llave_primaria', true)->first();
    $nombreLlavePrimaria = $llavePrimaria ? Str::lower($llavePrimaria->nombre_columna) : null;

    // Obtener llaves primarias existentes (solo si es necesario)
    $llavesExistentes = collect();
    if ($nombreLlavePrimaria && $request->input("ignorar_llaves_primarias") === "on") {
        $llavesExistentes = DB::table($nombreTabla)
            ->select($nombreLlavePrimaria)
            ->pluck($nombreLlavePrimaria)
            ->flip(); // Usamos flip para búsquedas O(1)
        
        Log::debug("Total de llaves primarias existentes: " . $llavesExistentes->count());
    }

    $resultado = [];
    $ignorarCamposVacios = $request->input("ignorar_campos_vacios") === "on";

    foreach ($data as $index => $fila) {
        $fila = array_map('trim', $fila);

        // Saltar filas completamente vacías
        if (empty(array_filter($fila))) {
            Log::warning("⚠️ Fila {$index} vacía en {$fileName}, saltándola.");
            continue;
        }

        // Construir registro con validaciones
        $registro = [];
        $registroValido = true;
        
        foreach ($columnas as $colIndex => $columna) {
            $columnaLower = Str::lower($columna);
            
            if (!isset($fila[$colIndex])) {
                if ($ignorarCamposVacios && isset($columnasTabla[$columnaLower]) && !$columnasTabla[$columnaLower]->nullable) {
                    Log::warning("⚠️ Fila {$index} tiene campo obligatorio vacío: {$columna}");
                    $registroValido = false;
                    break;
                }
                continue;
            }
            
            $registro[$columnaLower] = $fila[$colIndex];
        }
        
        if (!$registroValido) {
            continue;
        }
        
        // Validar llave primaria existente SOLO si está configurado
        if ($nombreLlavePrimaria && isset($registro[$nombreLlavePrimaria])) {
            $valorLlave = $registro[$nombreLlavePrimaria];
            
            if ($request->input("ignorar_llaves_primarias") === "on" && $llavesExistentes->has($valorLlave)) {
                Log::warning("⚠️ Fila {$index} con llave primaria existente: {$valorLlave}");
                continue;
            }
        }
        
        // Si llegó hasta aquí, agregar al resultado
        $resultado[] = $registro;
        Log::debug("Registro agregado: ", $registro);
    }
    
    Log::info("Total de registros válidos para importar: " . count($resultado));
    return $resultado;
}

    function obtenerColumnasTablaDB(string $tabla, array $excluir = []): array
    {
        // Obtiene todas las columnas de la tabla
        $columnas = Schema::getColumnListing($tabla);

        // Filtra las columnas excluidas
        return array_values(array_diff($columnas, $excluir));
    }


    
}
