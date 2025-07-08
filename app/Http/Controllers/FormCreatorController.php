<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\FormCreator;
use App\Models\TablaModulo;
use App\Helpers\TablasModulos;
use App\Models\ColumnaTabla;
use Illuminate\Support\Facades\Schema;
use App\Models\LigaFormulario;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use App\Models\User;



class FormCreatorController extends Controller
{

    public function index(Request $request)
    {
        $searchFor = "";
        $filter = "";
        $page = 1;
        if ($request->search != "" && isset($request->search)) {
            $searchFor = $request->search;
        }
        if ($request->filter != "" && isset($request->filter)) {
            $filter = $request->filter;
        }
        if ($request->page != "" && isset($request->page)) {
            $page = $request->page;
        }
        $registros = DB::table('form_creator')
            ->select(
                'form_creator.id',
                'form_creator.titulo',
                'form_creator.activo',
                'form_creator.nombre_documento',
                'form_creator.action',
                DB::raw("CONCAT(users.name, ' ', users.lastname) as creadoPor")
            )
            ->join('users', 'form_creator.creadoPor', '=', 'users.id')
            ->where('form_creator.nombre_documento', 'like', "%{$searchFor}%")
            ->orWhere('form_creator.titulo', 'like', "%{$searchFor}%");


        $form_creator = [
            "title" => "Formularios",
            "titulo_breadcrumb" => "Formularios",
            "subtitulo_breadcrumb" => "Formularios",
            "go_back_link" => "#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view" => "sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute" => "/form_creator",
            "confTabla" => array(
                "tituloTabla" => "Formularios",
                "placeholder" => "Buscar form_creator",
                "idSearch" => "buscarInfoTabla",
                "valueSearch" => $searchFor,
                "idBotonBuscar" => "btnBuscarTabla",
                "botonBuscar" => "Buscar",
                "filtrosBusqueda" => array(["key" => "nombre", "option" => "Por nombre del query"], ["key" => "usuario", "option" => "Nombre usuario"]),
                "rowCheckbox" => true,
                "idKeyName" => "id",
                "keys" => array('titulo', 'nombre_documento', 'action', 'creadoPor', 'activo'),
                "columns" => array('Título', 'Archivo Conf.', 'Route', 'Usuario', "Activo"),
                "indicadores" => true,
                "botones" => array(
                    '0' => 'btn-outline-danger',
                    '1' => 'btn-outline-success'
                ),
                "rowActions" => array("show", "edit", "destroy"),
                "data" => $registros->paginate(10)->appends(["page" => $page, "search" => $searchFor, "filter" => $filter]),
                "routeDestroy" => 'form_creator.destroy',
                "routeCreate" => "form_creator.create",
                "routeEdit" => 'form_creator.edit', // referente a un método ListadoFormularios
                "routeShow" => 'form_creator.show',
                "routeIndex" => 'form_creator.index',
                "searchFor" => $searchFor,
                "count" => $registros->count(),
                "txtBtnCrear" => "Formularios"
            )
        ];

        return view('sistema_cobros.form_creator.index', $form_creator);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prueba = true;
        return view("sistema_cobros.form_creator.create", ["title" => "Creador de formularios", "prueba" => $prueba ?? false]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'banner_formulario' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2560', // 2560 KB = 2.5MB
            'nombre_documento' => 'required|string'
        ]);

        if ($request->hasFile('banner_formulario')) {
            $archivo = $request->file('banner_formulario');

            // Verifica que el archivo es válido
            if ($archivo->isValid()) {
                $nombreArchivo = Str::uuid() . '.' . $archivo->getClientOriginalExtension();
                $ruta = $archivo->storeAs('banners_formularios', $nombreArchivo, 'public'); // <-- este es el correcto
            } else {
                // Si llega aquí es porque hubo un error al subir
                throw new \Exception('El archivo no es válido');
            }
        }

        // Usuarios permitidos
        $usuarios = $request->input('usuarios_permitidos', []);
        // Crear permiso único
        $tipo = $request->input('crear'); // 'formulario' o 'informe'
        $nombre = $request->input('nombre_formulario');

        $permiso = '';
        if (!empty($usuarios)) {
            $permiso = 'ver ' . $tipo . ' ' . Str::slug($nombre, ' ');
            Permission::firstOrCreate(['name' => $permiso]);
            // Asignar el permiso a los usuarios seleccionados
            foreach ($usuarios as $idUsuario) {
                $usuario = User::find($idUsuario);
                if ($usuario) {
                    $usuario->givePermissionTo($permiso);
                }
            }
        }



        $nombre_documento_limpio = Str::slug($request->nombre_documento, '_');

        $id = (string) Str::uuid();
        $titulo_formulario = $request->nombre_formulario;
        $nombre_documento = $nombre_documento_limpio . ".json";
        $hidden_identifier = $request->identificador_action; //ejemplo: generar_archivo_xml, consultar_titulo,
        $descripcion = $request->descripcion;
        $action = $request->action; // el default para procesar los datos enviados
        $creadoPor = Auth::user()->id;
        $activo = true;


        // Si el valor de tabla es null

        $form = new FormCreator();
        $form->id = $id;
        $form->titulo = $titulo_formulario;
        $form->hidden_identifier = $hidden_identifier;
        $form->permiso_requerido = $permiso;
        $form->descripcion = $descripcion;
        $form->action = $action;
        $form->nombre_documento = $nombre_documento_limpio;
        $form->creadoPor = $creadoPor;
        $form->es_publico = $request->has('formulario_publico') ? 1 : 0;
        $form->activo = $activo;
        $form->ruta_banner = $ruta ?? null;
        $form->save();

        // PENDIENTE: Vamos a iterar el ->input("input"); es donde estará marcado el tipo de input
        $inputs = $this->regresarJSONArregloInputs($request);

        // Para crear y almacenar el documento json de formularios
        $resultados = [
            "titulo" => $form->titulo,
            "publico" => $request->has('formulario_publico') ? 1 : 0,
            "multiples_registros" => $request->has('multiples_registros') ? 1 : 0,
            "hidden_identifier" => $form->hidden_identifier, // Campo extra para rutas personalizadas
            "descripcion" => $form->descripcion,
            "action" => $form->action,
            "update" => 'modificar.registro', // fijo /modificar_registro/{tabla}/{id}
            "enlazar_tabla" => $request->enlazar_tabla ?? "false",
            "tabla" => $request->id_tabla_db ?? "modulo_" . $nombre_documento_limpio, //$nombre_documento_limpio = Str::slug($request->nombre_documento, '_').".json";
            "creadoPor" => $form->creadoPor,
            "inputs" => $inputs,
            "ruta_banner" => $ruta ?? null,
            "permiso" => $permiso
        ];


        $jsonData = json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // Guardar en storage/app
        Storage::disk('local')->put('formularios/' . $nombre_documento_limpio . ".json", $jsonData);

        return back()->with("success", "El formulario fue creado con éxito.");
    }




    public function actionFormCreator(Request $request)
    {

        $identificador = $request->identificador_action;
        if ($identificador == "crear_alumno") {
            // Falta validación
            $request->validate([
                "id_control" => "required|string|max:10",
                "nombre" => "required|string|max:32",
                "primer_apellido" => "required|string|max:32",
                "segundo_apellido" => "nullable|string|max:32",
                "curp" => "required|string|max:18",
                "correo_electronico" => "required|email",
                "fecha_inicio" => 'nullable|date|date_format:Y-m-d',
                "fecha_terminacion" => 'required|date|date_format:Y-m-d',
            ]);

            DB::table('modulo_alumnos_pruebas')->insert([
                'id_control' => $request->id_control,
                'nombre' => $request->nombre,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'curp' => $request->curp,
                'correo_electronico' => $request->correo_electronico,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_terminacion' => $request->fecha_terminacion
            ]);

            return back()->with("success", "Alumno agregado exitosamente");
        }
        if ($identificador == "consultar_titulo") {
        }
        if ($identificador == "estado_tramite") {
        }
        if ($identificador == "validar_archivo") {
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Form = FormCreator::find($id);
        //1. Obtener la estructura del formulario
        $nombre_documento = $Form->nombre_documento;
        // Asegurar que termina en ".json"
        if (!Str::endsWith($nombre_documento, '.json')) {
            $nombre_documento .= '.json';
        }

        $data = Storage::disk('local')->get('formularios/' . $nombre_documento);
        $jsonDecoded = json_decode($data, true);
        $jsonDecoded["title"] = "Lectura formulario";
        $jsonDecoded["nombre_documento"] = $Form->nombre_documento;



        foreach ($jsonDecoded["inputs"] as $index => $input) {
            // Queries para dropdowns y select2
            if ($input["type"] == "dropdown") {
                $resultados = DB::table($input["tabla"])->select($input["value"] . " as value", $input["option"] . " as option")->get();
                $jsonDecoded["inputs"][$index]["resultados"] = $resultados;
            }

            // Queries para campos de checkbox
            if ($input["type"] == "checkbox" && $input["enlazado"] == "true") {
                $valores = DB::table($input["tabla"])->pluck($input["valores_tabla"])->toArray();
                $textos = DB::table($input["tabla"])->pluck($input["textos_tabla"])->toArray();
                $jsonDecoded["inputs"][$index]["resultados_valores"] = $valores;
                $jsonDecoded["inputs"][$index]["resultados_textos"] = $textos;
            }

            if ($input['type'] === 'multi-item') {
                foreach ($input['campos'] as $k => $campo) {
                    if ($campo['type'] == 'dropdown') {
                        $resultados = DB::table($campo['tabla'])->select(
                            DB::raw("{$campo['value']} as value, {$campo['option']} as `option`")
                        )->get();
                        $jsonDecoded["inputs"][$index]["campos"][$k]["resultados"] = $resultados;
                    }
                }
            }
        }
        return view("sistema_cobros.form_creator.show", $jsonDecoded);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $form = FormCreator::findOrFail($id);
        $data = Storage::disk('local')->get('formularios/' . $form->nombre_documento);
        $jsonDecoded = json_decode($data, true);
        return view("sistema_cobros.form_creator.edit", [
            "title" => "Editar formulario",
            "form" => $form,
            "documento" => $jsonDecoded
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->can("Borrar formularios")) {
            $form = FormCreator::find($id);
            if (!$form) {
                return back()->with('error', 'Formulario no encontrado');
            }
            // Eliminar el contacto
            Storage::delete('formularios/' . $form->nombre_documento);
            $form->delete();
            return back()->with("success", "Registro eliminado con éxito.");
        }
        return back()->with("error", "Sin autorización para eliminar formularios");
    }


    public function regresarJSONArregloInputs(Request $request)
    {

        if (!empty($request->input("input"))) {
            $inputs = [];
            foreach ($request->input("input") as $index => $input) {
                switch ($input) {
                    case "select2":
                        $type = $input;

                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $tabla = $request->input("inputs")[$index]["tabla_fuente"];
                        $buscar_en = explode(",", $request->input("inputs")[$index]["campos_busqueda"]); // los campos where
                        $campos_concatenados = explode(",", $request->input("inputs")[$index]["campos_concatenados"]); // los campos where
                        $retornar = explode(",", $request->input("inputs")[$index]["campos_respuesta"]); // los campos seleccionados
                        $principal = $request->input("inputs")[$index]["principal"]; // el campo id
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $endpoint = "ejemplo_select2";
                        $documento_select2 = $name . ".json"; // donde se almacenará la información del select2
                        $id = "buscar_" . $tabla;
                        $columnas = [];
                        foreach ($retornar as $elemento) {
                            // Divide cada elemento por el punto y toma la segunda parte (nombre_columna)
                            $partes = explode(".", $elemento);
                            if (count($partes) == 2) { // Asegura que el elemento tenga el formato correcto
                                $columnas[] = $partes[1]; // Agrega el nombre de la columna al arreglo
                            }

                            $this->generarArchivoJSONSelect2($tabla, $retornar, $buscar_en, $principal, $documento_select2, $campos_concatenados);
                        }


                        $objeto = [
                            "type" => $type,
                            "tabla" => $tabla,
                            "buscar_en" => $buscar_en,
                            "campos_concatenados" => $campos_concatenados,
                            "retornar" => $columnas,
                            "principal" => $principal,
                            "name" => $name,
                            "placeholder" => $label,
                            "endpoint" => $endpoint,
                            "archivo" => $documento_select2,
                            "id" => $id,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "dropdown":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $tabla = $request->input("inputs")[$index]["tabla_dropdown"];
                        $option = $request->input("inputs")[$index]["opcion_columna_dropdown"];
                        $value = $request->input("inputs")[$index]["valor_columna_dropdown"];
                        $objeto = [
                            "type" => $type,
                            "tabla" => $tabla,
                            "option" => $option,
                            "value" => $value,
                            "name" => $name,
                            "label" => $label,
                            "validacion" => $validaciones

                        ];
                        $inputs[] = $objeto;
                        break;
                    case "radio":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $radio = $request->input("inputs")[$index]["opciones_radio"];
                        $opciones = explode(",", $radio);

                        $objeto = [
                            "type" => $type,
                            "opciones" => $opciones,
                            "name" => $name,
                            "placeholder" => $label,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "text":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $placeholder = $request->input("inputs")[$index]["placeholder"];
                        $objeto = [
                            "type" => $type,
                            "placeholder" => $placeholder,
                            "name" => $name,
                            "label" => $label,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "hidden":
                        $type = $input;
                        $name = $request->input("name")[$index];
                        $value = $request->input("valor_oculto")[$index];
                        $objeto = [
                            "type" => $type,
                            "name" => $name,
                            "value" => $value
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "email":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $placeholder = $request->input("inputs")[$index]["placeholder"];
                        $objeto = [
                            "type" => $type,
                            "placeholder" => $placeholder,
                            "name" => $name,
                            "label" => $label,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "date":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $formato = $request->input("inputs")[$index]["formato_fecha"];
                        $objeto = [
                            "type" => $type,
                            "formato" => $formato,
                            "name" => $name,
                            "label" => $label,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "time":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $formato = $request->input("inputs")[$index]["formato_fecha"];
                        $objeto = [
                            "type" => $type,
                            "formato" => $formato,
                            "name" => $name,
                            "label" => $label,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "datetime":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $formato = $request->input("inputs")[$index]["formato_fecha"];
                        $objeto = [
                            "type" => $type,
                            "formato" => $formato,
                            "name" => $name,
                            "label" => $label,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "file":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $directorio = $request->input("inputs")[$index]["storage_directory"] ?? "archivos_de_formulario";
                        $formatosArray = $request->input("inputs")[$index]["file_type"];
                        $formatos = is_array($formatosArray) ? implode(',', $formatosArray) : $formatosArray;
                        $file_size = $request->input("inputs")[$index]["file_size"];
                        $objeto = [
                            "type" => $type,
                            "name" => $name,
                            "label" => $label,
                            "formatos" => $formatos,
                            "file_size" => $file_size,
                            "directorio" => $directorio,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "checkbox":
                        $type = $input;
                        // Aquí validamos si se activó la validación para ese índice
                        $validaciones = $request->input("validacion_activada.$index")
                            ? $request->input("reglas.$index")
                            : false;
                        $name = $request->input("name")[$index];
                        $label = $request->input("label")[$index];
                        $enlazable = $request->input("inputs")[$index]["enlazado"] ?? false;
                        $tabla = $request->input("inputs")[$index]["tabla_checkbox"] ?? "";
                        $valores = $request->input("inputs")[$index]["valores_checkbox"] ?? "";
                        $textos = $request->input("inputs")[$index]["textos_checkbox"] ?? "";
                        $valores_tabla = $request->input("inputs")[$index]["valor_columna_dropdown"] ?? "";
                        $textos_tabla = $request->input("inputs")[$index]["opcion_columna_dropdown"] ?? "";
                        $objeto = [
                            "type" => $type,
                            "enlazado" => $enlazable,
                            "tabla" => $tabla,
                            "name" => $name,
                            "valores" => $valores,
                            "textos" => $textos,
                            "valores_tabla" => $valores_tabla,
                            "textos_tabla" => $textos_tabla,
                            "label" => $label,
                            "validacion" => $validaciones
                        ];
                        $inputs[] = $objeto;
                        break;
                    case "multi-item":
                        $type = $input;
                        $descripcion = $request->input("inputs")[$index]["descripcion_subformulario"];
                        $tabla_hija = $request->input("inputs")[$index]["tabla_hija"];
                        $llave_foranea = $request->input("inputs")[$index]["llave_foranea"];
                        $campos_sub = $request->input("inputs")[$index]["campos"];

                        // Insertar la función para procesar campos_sub
                        $campos_procesados = $this->subcamposJSONInputs($campos_sub);

                        $inputs[] = [
                            "type" => "multi-item",
                            "descripcion_subformulario" => $descripcion,
                            "tabla_hija" => "modulo_" . $tabla_hija,
                            "llave_foranea" => $llave_foranea,
                            "campos" => $campos_procesados
                        ];


                        break;
                    default:

                        return false;
                }
            }

            if (!empty($inputs)) {
                return $inputs;
            }


            return $inputs;
        }
        return false;
    }

    public function subcamposJSONInputs($subcampos = [])
    {
        if (empty($subcampos)) {
            return [];
        }
        $campos_procesados = [];
        foreach ($subcampos as $subcampo) {
            $tipo_subcampo = $subcampo["input"];

            switch ($tipo_subcampo) {
                case "dropdown":
                    $campos_procesados[] = [
                        "type" => "dropdown",
                        "label" => $subcampo["label"] ?? '',
                        "name" => $subcampo["name"] ?? '',
                        "tabla" => $subcampo["tabla_dropdown"] ?? '',
                        "option" => $subcampo["opcion_columna_dropdown"] ?? '',
                        "value" => $subcampo["valor_columna_dropdown"] ?? ''
                    ];
                    break;
                case "select2":
                    $tabla = $subcampo["tabla_fuente"] ?? '';
                    $buscar_en = explode(",", $subcampo["campos_busqueda"] ?? '');
                    $campos_concatenados = explode(",", $subcampo["campos_concatenados"] ?? '');
                    $retornar = explode(",", $subcampo["campos_respuesta"] ?? '');
                    $principal = $subcampo["principal"] ?? '';
                    $name = $subcampo["name"] ?? '';
                    $label = $subcampo["label"] ?? '';
                    $endpoint = "ejemplo_select2";
                    $documento_select2 = $name . ".json";
                    $id = "buscar_" . $tabla;

                    $columnas = [];
                    foreach ($retornar as $elemento) {
                        $partes = explode(".", $elemento);
                        if (count($partes) == 2) {
                            $columnas[] = $partes[1];
                        }
                    }

                    // Generar el archivo JSON de configuración del select2
                    $this->generarArchivoJSONSelect2(
                        $tabla,
                        $retornar,
                        $buscar_en,
                        $principal,
                        $documento_select2,
                        $campos_concatenados
                    );

                    $campos_procesados[] = [
                        "type" => "select2",
                        "label" => $label,
                        "name" => $name,
                        "tabla" => $tabla,
                        "buscar_en" => $buscar_en,
                        "campos_concatenados" => $campos_concatenados,
                        "retornar" => $columnas,
                        "principal" => $principal,
                        "endpoint" => $endpoint,
                        "archivo" => $documento_select2,
                        "id" => $id
                    ];
                    break;
                case "radio":
                    $type = "radio";
                    $name = $subcampo["name"] ?? '';
                    $label = $subcampo["label"] ?? '';
                    $radio = $subcampo["opciones_radio"] ?? '';
                    $opciones = explode(",", $radio);

                    $campos_procesados[] = [
                        "type" => $type,
                        "opciones" => $opciones,
                        "name" => $name,
                        "placeholder" => $label
                    ];

                    break;
                case "text":
                    $campos_procesados[] = [
                        "type" => "text",
                        "label" => $subcampo["label"] ?? '',
                        "name" => $subcampo["name"] ?? '',
                        "placeholder" => $subcampo["placeholder"] ?? ''
                    ];
                    break;
                case "hidden":
                    $campos_procesados[] = [
                        "type" => "hidden",
                        "name" => $subcampo["name"] ?? '',
                        "value" => $subcampo["valor_oculto"] ?? ''
                    ];
                    break;
                case "date":
                    $campos_procesados[] = [
                        "type" => "date",
                        "label" => $subcampo["label"] ?? '',
                        "name" => $subcampo["name"] ?? '',
                        "formato" => $subcampo["formato_fecha"] ?? 'Y-m-d'
                    ];
                    break;
                case "time":
                    $campos_procesados[] = [
                        "type" => "time",
                        "label" => $subcampo["label"] ?? '',
                        "name" => $subcampo["name"] ?? '',
                        "formato" => $subcampo["formato_fecha"] ?? 'Y-m-d H:i'
                    ];
                    break;
                case "datetime":
                    $campos_procesados[] = [
                        "type" => "datetime",
                        "label" => $subcampo["label"] ?? '',
                        "name" => $subcampo["name"] ?? '',
                        "formato" => $subcampo["formato_fecha"] ?? 'Y-m-d H:i'
                    ];
                    break;
                case "checkbox":
                    $campos_procesados[] = [
                        "type" => "checkbox",
                        "name" => $subcampo["name"] ?? '',
                        "label" => $subcampo["label"] ?? '',
                        "enlazado" => $subcampo["enlazado"] ?? false,
                        "tabla" => $subcampo["tabla_checkbox"] ?? '',
                        "valores" => $subcampo["valores_checkbox"] ?? '',
                        "textos" => $subcampo["textos_checkbox"] ?? '',
                        "valores_tabla" => $subcampo["valor_columna_dropdown"] ?? '',
                        "textos_tabla" => $subcampo["opcion_columna_dropdown"] ?? ''
                    ];
                    break;
                case "file":
                    $formatosArray = $subcampo["file_type"] ?? '';
                    $formatos = is_array($formatosArray) ? implode(',', $formatosArray) : $formatosArray;
                    $campos_procesados[] = [
                        "type" => "file_subcampo", // <----------------------------------------------- Visualizar de manera sencilla en la vista
                        "name" => $subcampo["name"] ?? '',
                        "label" => $subcampo["label"] ?? '',
                        "formatos" => $formatos,
                        "file_size" => $subcampo["file_size"] ?? '',
                        "directorio" => $subcampo["storage_directory"] ?? 'archivos_de_formulario'
                    ];
                    break;
                default:
                    $campos_procesados[] = [];
                    break;
            }
        }
        return $campos_procesados;
    }

    public function cargarEjemplo(Request $request)
    {
        // IMPORTANTE: FALTA VALIDACIÓN <--------

        $tipo_input = $request->tipo_input;

        if (!empty($tipo_input)) {

            switch ($tipo_input) {
                case "dropdown":

                    $name = $request->name;
                    $label = $request->label;
                    $tabla = $request->tabla;
                    $option = $request->option;
                    $value = $request->value;
                    $resultados = DB::table($tabla)->select($value . " as value", $option . " as option")->get();
                    $res = ["resultados" => $resultados, "name" => $name, "label" => $label, "option", "ejemplo" => true];
                    return view("components.form_creator.ejemplos_inputs.dropdown", $res);
                    break;
                case "select2":
                    $tabla = $request->tabla;
                    $buscar_en = explode(",", $request->buscar_en); //REAL formulario $request->campos_busqueda
                    $retornar = explode(",", $request->retornar); // REAL formulario a $request->campos_respuesta
                    $principal = $request->principal;
                    $name = $request->name;
                    $label = $request->label;
                    $campos_concatenados = $request->campos_concatenados;


                    $columnas = []; // Arreglo para almacenar solo los nombres de las columnas
                    foreach ($retornar as $elemento) {
                        // Divide cada elemento por el punto y toma la segunda parte (nombre_columna)
                        $partes = explode(".", $elemento);
                        if (count($partes) == 2) { // Asegura que el elemento tenga el formato correcto
                            $columnas[] = $partes[1]; // Agrega el nombre de la columna al arreglo
                        }
                    }

                    $res = ["endpoint" => "ejemplo_select2", "id" => "buscar_" . $tabla, "placeholder" => $label, "name" => $name, "retornar" => $columnas, "ejemplo" => true];
                    // generamos un archivo json
                    $respuesta_query = $this->generarJSONEjemplo($tabla, $retornar, $buscar_en, $principal, $campos_concatenados);
                    return view("components.form_creator.ejemplos_inputs.select2", $res);

                    break;
                case "radio":
                    $name = $request->name;
                    $label = $request->label;
                    $radio = $request->opciones;
                    $opciones = explode(",", $radio);

                    $res = ["placeholder" => $label, "name" => $name, "opciones" => $opciones, "ejemplo" => true];
                    return view("components.form_creator.ejemplos_inputs.radio", $res);
                    break;
                case "date":
                    $name = $request->name;
                    $label = $request->label;
                    $formato = $request->formato_fecha;
                    $res = ["label" => $label, "name" => $name, "formato" => $formato, "ejemplo" => true];
                    return view("components.form_creator.ejemplos_inputs.date", $res);
                    break;
                case "time":
                    $name = $request->name;
                    $label = $request->label;
                    $formato = $request->formato_fecha;
                    $res = ["label" => $label, "name" => $name, "formato" => $formato, "ejemplo" => true];
                    return view("components.form_creator.ejemplos_inputs.time", $res);
                    break;
                case "datetime":
                    $name = $request->name;
                    $label = $request->label;
                    $formato = $request->formato_fecha;
                    $res = ["label" => $label, "name" => $name, "formato" => $formato, "ejemplo" => true];
                    return view("components.form_creator.ejemplos_inputs.datetime", $res);
                    break;
                case "text":
                    $name = $request->name;
                    $label = $request->label;
                    $placeholder = $request->placeholder;
                    $res = ["label" => $label, "name" => $name, "placeholder" => $placeholder, "ejemplo" => true];
                    return view("components.form_creator.ejemplos_inputs.text", $res);
                    break;
                case "email":
                    $name = $request->name;
                    $label = $request->label;
                    $placeholder = $request->placeholder;
                    $res = ["label" => $label, "name" => $name, "placeholder" => $placeholder, "ejemplo" => true];
                    return view("components.form_creator.ejemplos_inputs.email", $res);
                    break;
                case "file":
                    $name = $request->name;
                    $label = $request->label;
                    $formatos = $request->formatos;
                    $file_size = $request->file_size;
                    $res = ["label" => $label, "name" => $name, "formatos" => implode(",", $formatos), "file_size" => $file_size];
                    return view("components.form_creator.ejemplos_inputs.file", $res);
                    break;
                case "checkbox":
                    $name = $request->name;
                    $valores = $request->valores;
                    $textos = $request->textos;
                    $res = ["name" => $name, "valores" => explode(",", $valores), "textos" => explode(",", $textos)];
                    return view("components.form_creator.ejemplos_inputs.checkbox", $res);
                    break;
                default:
                    return '<div class="alert alert-warning">Lo sentimmos,tipo de campo no encontrado</div>';
            }

            return '<div class="alert alert-danger">Tipo_input no fue detectado en la petición.</div>';
        }
    }


    // Para el select2, ejemplo
    public function generarJSONEjemplo($tabla, $seleccionar, $buscar_en, $principal, $campos_concatenados = "")
    {

        $resultados = [
            "tabla" => $tabla,
            "seleccionar" => $seleccionar,
            "buscar_en" => $buscar_en,
            "principal" => $principal,
            "campos_concatenados" => $campos_concatenados
        ];

        $jsonData = json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        Storage::disk('local')->put('ejemplo_visual_select2/ejemplo.json', $jsonData);
        return true;
    }


    // Para el select2, archivo
    public function generarArchivoJSONSelect2($tabla, $seleccionar, $buscar_en, $principal, $nombre_documento, $campos_concatenados = "")
    {

        $resultados = [
            "tabla" => $tabla,
            "seleccionar" => $seleccionar,
            "buscar_en" => $buscar_en,
            "principal" => $principal,
            "campos_concatenados" => $campos_concatenados
        ];

        $jsonData = json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        Storage::disk('local')->put('select2/' . $nombre_documento, $jsonData);
        return true;
    }


    // 1. Usado para responder a la petición de select2 
    // 2. Necesitamos generar un documento JSON para que al momento que se haga la consulta 
    //  la función generarArchivoJSONSelect2() es la encargada de hacer el archivo json
    //  a su vez generarArchivoJSONSelect2() es llamada en regresarJSONArregloInputs(Request $request)
    public function respuestaSelect2(Request $request)
    {
        $search = $request->input("search");
        if (empty($request->input("archivo"))) {
            $data = Storage::disk('local')->get('ejemplo_visual_select2/ejemplo.json');
        } else {
            $data = Storage::disk('local')->get('select2/' . $request->input("archivo"));
        }

        $json = json_decode($data, true);

        $query = DB::table($json["tabla"]);

        $select = [];
        $where = [];
        // Seleccionar columnas
        if (!empty($json["seleccionar"])) {
            foreach ($json["seleccionar"] as $columna) {
                if ($columna == $json["principal"]) {
                    $select[] = $json["principal"] . " as id";
                    continue;
                }
                $select[] = $columna;
            }
        }

        if (!empty($select)) {
            $query->select($select);
        }

        if (!empty($json["buscar_en"])) {
            $firstCondition = true;
            foreach ($json["buscar_en"] as $columna) {
                if ($firstCondition) {
                    $query->where($columna, "like", "%{$search}%");
                    $firstCondition = false;
                } else {
                    $query->orWhere($columna, "like", "%{$search}%");
                }
            }
        }

        return $query->get();
    }
    public function respuestaSelect2V2(Request $request)
    {
        $search = $request->input("search");

        if (empty($request->input("archivo"))) {
            $data = Storage::disk('local')->get('ejemplo_visual_select2/ejemplo.json');
        } else {
            $data = Storage::disk('local')->get('select2/' . $request->input("archivo"));
        }

        $json = json_decode($data, true);
        $tabla = $json["tabla"];

        $query = DB::table($tabla);
        // Aplicar joins si hay más de una tabla
        if (!empty($json["joins"])) {
            foreach ($json["joins"] as $join) {
                $tablaJoin = $join["tabla"];
                $onPrincipal = $join["on_principal"];
                $onSecundaria = $join["on_secundaria"];
                $query->join($tablaJoin, $onPrincipal, '=', $onSecundaria);
            }
        }


        $select = [];

        // Seleccionar columnas correctamente
        if (!empty($json["seleccionar"])) {
            foreach ($json["seleccionar"] as $columna) {
                if ($columna == $json["principal"]) {
                    $select[] = "$columna as id"; // No alias de tabla, usar nombre original
                    continue;
                }
                $select[] = $columna;
            }
        }

        if (!empty($select)) {
            $query->select($select);
        }

        $firstCondition = true;
        // Procesar concatenaciones
        if (!empty($json["campos_concatenados"])) {
            // $arr_concatenados = explode(",", $json["campos_concatenados"]);
            $arr_concatenados = is_array($json["campos_concatenados"]) ? $json["campos_concatenados"] : explode(",", $json["campos_concatenados"]);
            $concatenaciones = [];

            foreach ($arr_concatenados as $item) {
                $parts = explode(":", trim($item));
                if (count($parts) == 3 && is_numeric($parts[1])) {
                    $n = intval($parts[1]);
                    if ($n <= 3) { // Límite de 3 concatenaciones
                        $concatenaciones[$n][] = $parts[2]; // No alias, usar columna tal cual
                    }
                }
            }



            foreach ($concatenaciones as $columns) {
                $concatStr = "CONCAT(" . implode(", ' ', ", $columns) . ")";

                if ($firstCondition) {
                    $query->where(DB::raw($concatStr), "like", "%{$search}%");
                    $firstCondition = false;
                } else {
                    $query->orWhere(DB::raw($concatStr), "like", "%{$search}%");
                }
            }
        }

        if (!empty($json["buscar_en"])) {
            // Si no hay concatenaciones, hacer búsqueda normal
            foreach ($json["buscar_en"] as $columna) {
                if ($firstCondition) {
                    $query->where($columna, "like", "%{$search}%");
                    $firstCondition = false;
                } else {
                    $query->orWhere($columna, "like", "%{$search}%");
                }
            }
        }

        return $query->get();
    }


    public function rutaAutomatica(Request $request)
    {
        $request->validate([
            "nombre_documento" => "required|string|max:82"
        ]);

        // 1. Obtener la estructura del formulario
        $nombre_documento = $request->nombre_documento;
        if (!Str::endsWith($nombre_documento, '.json')) {
            $nombre_documento .= '.json';
        }

        $data = Storage::disk('local')->get('formularios/' . $nombre_documento);
        $jsonDecoded = json_decode($data, true);
        $estructura = $jsonDecoded["inputs"];

        $inputOriginal = $request->input("input");
        $tablaPadre = array_key_first($inputOriginal);

        $idsInsertados = []; // para relacionar con hijos si se necesita

        // 2. Recorrer cada registro padre
        foreach ($inputOriginal[$tablaPadre] as $index => $datosPadre) {
            // Agregar timestamps
            $datosPadre['created_at'] = Carbon::now();
            $datosPadre['updated_at'] = Carbon::now();

            // 3. Procesar campos tipo file si existen
            foreach ($estructura as $campo) {
                if ($campo['type'] === 'file') {
                    $nombreCampo = $campo['name'];
                    $pathCampo = "input.$tablaPadre.$index.$nombreCampo";

                    if ($request->hasFile($pathCampo)) {
                        $archivo = $request->file($pathCampo);

                        $directorio = isset($campo['directorio']) ? 'archivos_formularios/' . trim($campo['directorio'], "/") : "archivos_formularios";
                        $formatosPermitidos = isset($campo['formatos']) ? explode(',', str_replace(' ', '', $campo['formatos'])) : [];
                        $tamanoMaximoMB = isset($campo['file_size']) ? (int)$campo['file_size'] : 5;

                        if ($archivo->getSize() > $tamanoMaximoMB * 1024 * 1024) {
                            return back()->withErrors(["El archivo '$nombreCampo' excede el tamaño máximo permitido."]);
                        }

                        $extensionArchivo = "." . $archivo->getClientOriginalExtension();
                        if (!empty($formatosPermitidos) && !in_array(strtolower($extensionArchivo), array_map('strtolower', $formatosPermitidos))) {
                            return back()->withErrors(["El archivo '$nombreCampo' no tiene un formato permitido."]);
                        }

                        $nombreFinal = uniqid() . "_" . Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME)) . "." . $archivo->getClientOriginalExtension();
                        $rutaFinal = $archivo->storeAs($directorio, $nombreFinal);

                        foreach (['directorio', 'formatos', 'file_size', 'validacion'] as $aux) {
                            if (isset($datosPadre[$aux])) {
                                unset($datosPadre[$aux]);
                            }
                        }

                        $datosPadre[$nombreCampo] = $rutaFinal;
                    } else {
                        $datosPadre[$nombreCampo] = null;
                    }
                }
            }

            // 4. Insertar registro padre y guardar ID
            $insertedId = DB::table($tablaPadre)->insertGetId($datosPadre);
            $idsInsertados[$index] = $insertedId;
        }

        // 5. Buscar campo llave (por si hay hijos multi-item)
        $campoLlave = 'id';
        foreach ($estructura as $campo) {
            if (isset($campo['llave_foranea']) && $campo['type'] !== 'multi-item') {
                $campoLlave = $campo['name'];
            }
        }

        // 6. Insertar registros multi-item si existen
        foreach ($estructura as $campo) {
            if ($campo["type"] === "multi-item") {
                $tablaHija = $campo["tabla_hija"];

                foreach ($inputOriginal[$tablaHija] ?? [] as $registro) {
                    $registroProcesado = $registro;

                    foreach ($registroProcesado as $key => $val) {
                        // Reemplazar si el valor indica referencia
                        if ($val === "{$tablaPadre}_{$campoLlave}") {
                            // Suponemos que se usa 'indice_padre' para saber con cuál padre relacionarlo
                            $indicePadre = $registro['indice_padre'] ?? 0;
                            $registroProcesado[$key] = $idsInsertados[$indicePadre] ?? null;
                        }
                    }

                    $registroProcesado['created_at'] = Carbon::now();
                    $registroProcesado['updated_at'] = Carbon::now();

                    DB::table($tablaHija)->insert($registroProcesado);
                }
            }
        }

        return back()->with("success", "¡Se insertaron los registros correctamente!");
    }







    public function procesarTablaModal(Request $request)
    {
        Log::info('Datos del request:', $request->all());


        $nombreArchivo = $request->nombre_archivo;
        $campos = $request->input('campos', []);
        $prefijo = "modulo_";
        // 2. Agregar columnas y prepara columnas de nueva tabla en db
        foreach ($campos as $tabla_nombre => $columnas_info) {
            $nuevo_nombre = $prefijo . Str::slug($tabla_nombre, '_');
            // Omitir tablas vacías o mal formadas
            if (!is_array($columnas_info) || count(array_filter($columnas_info, fn($c) => !empty($c['columna'] ?? null))) === 0) {
                continue;
            }
            //1. Verificar si existe tabla
            if (TablaModulo::where('nombre_tabla', $tabla_nombre)->exists()) {
                return response()->json([
                    'error' => "Ya existe una tabla con el nombre: $tabla_nombre"
                ], 422);
            }
            // Buscar si alguna columna tiene 'llave_foranea_padre'
            $llave_foranea_detectada = null;
            foreach ($columnas_info as $columna_info) {
                if (isset($columna_info['llave_foranea_padre'])) {
                    $llave_foranea_detectada = $columna_info['llave_foranea_padre']; // ej. "registros_pagos.id"
                    break;
                }
            }

            // Si existe, agregar manualmente ese campo como columna a crear
            if ($llave_foranea_detectada) {
                $partes = explode('.', $llave_foranea_detectada); // [tabla_padre, columna]
                if (count($partes) == 2) {
                    $columna_llave = $partes[1]; // ej. "id"
                    $tabla_padre = "modulo_" . $partes[0];   // ej. "registros_pagos"

                    // Verificar si ya existe una columna con ese nombre
                    $yaExiste = collect($columnas_info)->pluck('columna')->contains($columna_llave);
                    // Agregar columna hija que se relacione con tabla padre
                    $columnas_info[] = [
                        'columna' => $tabla_padre . "_" . $columna_llave,
                        'tipo_dato' => 'bigint',
                        'es_null' => false,
                        'on_table' => $tabla_padre,
                        'on_row' => $llave_foranea_detectada
                    ];
                }
            }


            // 2. Registrar en tabla_modulos
            $tabla = new TablaModulo();
            $tabla->nombre_tabla = $nuevo_nombre;
            $tabla->qty_columnas = count($columnas_info);
            $tabla->creadoPor = Auth::user()->id;
            $tabla->activo = $request->activo ?? 1;
            $tabla->save();

            // Inicializar estructuras para esta tabla
            $assoc_nullables = [];
            $assoc_limite = [];
            $assoc_foraneas = [];
            $assoc_unicos = [];
            $columnas = [];
            $tipos = [];

            foreach ($columnas_info as $columna_data) {
                if (empty($columna_data['columna'])) continue;

                $nombre_columna = $columna_data['columna'];
                $columnas[] = $nombre_columna;
                $tipos[] = $columna_data['tipo_dato'] ?? 'varchar';

                // 3. Guardar metadatos en tu tabla ColumnaTabla si deseas, por ejemplo:
                ColumnaTabla::create([
                    'nombre_columna' => $nombre_columna,
                    'id_tabla' => $tabla->id, // solo si es la tabla padre; si no, deberías tener otra referencia
                    'tipo_dato' => $columna_data['tipo_dato'] ?? 'varchar',
                    'qty_caracteres' => $columna_data['limite_caracteres'] ?? 255,
                    'es_llave_primaria' => isset($columna_data['es_llave_primaria']),
                    'nullable' => isset($columna_data['es_null']) && $columna_data['es_null'] === 'true',
                    'es_foranea' => isset($columna_data['es_foranea']),
                    'on_table' => $columna_data['on_table'] ?? null,
                    'on_column' => isset($columna_data['on_row']) && $columna_data['on_row'] !== "false"
                        ? (str_contains($columna_data['on_row'], '.') ? explode('.', $columna_data['on_row'])[1] : $columna_data['on_row'])
                        : null,
                    'activo' => true,
                ]);

                // Acumuladores para crear tabla
                $assoc_nullables[$nombre_columna] = isset($columna_data['es_null']) && $columna_data['es_null'] === 'true';
                $assoc_limite[$nombre_columna] = $columna_data['limite_caracteres'] ?? 255;
                $assoc_unicos[$nombre_columna] = isset($columna_data['es_unico']);

                if (isset($columna_data['on_table'], $columna_data['on_row']) && $columna_data['on_row'] !== "false") {
                    $on_column_parsed = str_contains($columna_data['on_row'], '.')
                        ? explode('.', $columna_data['on_row'])[1]
                        : $columna_data['on_row'];

                    $assoc_foraneas[$nombre_columna] = [
                        'tabla' => $columna_data['on_table'],
                        'columna' => $on_column_parsed
                    ];
                }
            }

            // Crear la tabla si no existe
            $Tabla = new TablasModulos();
            if (!$Tabla->existeTabla($nuevo_nombre)) {
                $Tabla->crearTablaDinamica($nuevo_nombre, $columnas, $tipos, null, $assoc_nullables, $assoc_limite, $assoc_foraneas, $assoc_unicos);
            }
        }

        return response()->json(["data" => $request->all()]);
    }

    public function loader(Request $request)
    {

        if ($request->type == "loading") {
            return view('components.form_creator.loaders.loading', [
                'heading' => $request->input('heading'),
                'descripcion' => $request->input('descripcion')
            ]);
        }
        if ($request->type == "done") {
            return view('components.form_creator.loaders.complete', [
                'heading' => $request->input('heading'),
                'descripcion' => $request->input('descripcion')
            ]);
        }
    }

    // Se procesan automaticamente los formularios
    public function rutaPublica(Request $request)
    {
        // USO: para hacer los inserts a las tablas
        //dd($request->all());
        $request->validate([
            "nombre_documento" => "required|string|max:82"
        ]);


        // Obtenener información de la liga 
        $liga = LigaFormulario::where('id', $request->liga)->firstOrFail();

        //1. Obtener la estructura del formulario
        $nombre_documento = $request->nombre_documento;
        // Asegurar que termina en ".json"
        if (!Str::endsWith($nombre_documento, '.json')) {
            $nombre_documento .= '.json';
        }
        $data = Storage::disk('local')->get('formularios/' . $nombre_documento);
        $jsonDecoded = json_decode($data, true);

        //2. Saber a qué tabla se va a hacer el insert
        $tabla = $jsonDecoded["tabla"];

        //3. Generar un arreglo para los nombres de columnas
        $columnas = [];
        $valores = [];
        foreach ($jsonDecoded["inputs"] as $inputs) {
            $columnas[] = $inputs["name"];
            if ($inputs["type"] != "file") {
                $valor = $request->input($inputs["name"]);
                if ($valor == "si" || $valor == "no") {
                    $valor = ($valor == "si") ? 1 : 0;
                }
                $valores[] = $valor;
            }
            if ($inputs["type"] == "file") {
                // Procesar archivo
                if ($request->hasFile($inputs["name"])) {
                    $archivo = $request->file($inputs["name"]);

                    // Validar tamaño y tipo si deseas aquí

                    $directorio = $inputs["directorio"];
                    $extension = $archivo->getClientOriginalExtension();
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombreArchivo = Str::uuid() . '.' . $extension;

                    // Guardar el archivo
                    $rutaGuardado = $archivo->storeAs($directorio, $nombreArchivo, 'public');

                    // Guardamos el nombre del archivo o la ruta según lo que necesites
                    $valores[] = $rutaGuardado; // o $nombreArchivo
                } else {
                    $valores[] = null; // si no se sube archivo
                }
            }
        }

        //4. Generar mi arreglo asociativo
        $datos = array_combine($columnas, $valores);

        //5. Hacer el insert
        DB::table($tabla)->insert($datos);


        if ($liga) {
            return redirect($liga->redirect_url ?? '/');
        }

        return back()->with("success", "Se ha insertado el registro exitosamente!");
    }

    public function generarQR(Request $request, $id_liga = null)
    {
        $liga = null;

        if (!empty($id_liga)) {
            $liga = LigaFormulario::where('slug', $id_liga)
                ->orWhere('id', $id_liga)
                ->first();
        }

        return view('sistema_cobros.form_creator.qr_code', [
            'title' => "Generar código QR",
            'liga'  => $liga,
        ]);
    }

    public function editarRegistro(string $tabla = "", string $id = "")
    {

        // Para poder implementar un botón de ir a registros
        // Buscamos en tablas_modulos el id de dicha tabl
        $tabla_registros = DB::table("tablas_modulos")->where('nombre_tabla', $tabla)->value('id');

        //1. Ver si existe la tabla
        if (!Schema::hasTable($tabla)) {
            return response()->json(["response" => "Lo sentimos, tabla: " . $tabla . " no encontrada"]);
        }

        //2. Ver si dicho registro existe
        $valores = DB::table($tabla)->where('id', $id)->first();
        if (!$valores) {
            return response()->json(["response" => "Lo sentimos, no hay registro: " . $id . " en la tabla: " . $tabla]);
        }

        //3. Ver si existe el formulario de tabla
        $documento = str_replace('modulo_', '', $tabla);
        if (!Storage::exists('formularios/' . $documento . ".json") &&  !Storage::exists('formularios/' . $tabla . ".json")) {
            return response()->json(["response" => "Lo sentimos, no hay archivo de configuración de formulario:  " . $tabla]);
        }

        //4. Obtener el json del archivo
        $data = Storage::disk('local')->get('formularios/' . $documento . ".json");
        if (!$data) {
            $data = Storage::disk('local')->get('formularios/' . $tabla . ".json");
        }

        $jsonDecoded = json_decode($data, true);


        //5. Iterar los inputs
        foreach ($jsonDecoded["inputs"] as $index => $input) {

            if ($input["type"] === "text" || $input["type"] === "datetime" || $input["type"] === "date" || $input["type"] === "time" || $input["type"] === "email" || $input["type"] === "radio") {
                try {
                    $jsonDecoded["inputs"][$index]["value"] = $valores->{$input["name"]};
                } catch (\Throwable $th) {
                    dd($valores);
                    return "Error con el input " . $input["name"] . " " . $th;
                }
            }

            if ($input["type"] == "dropdown") {
                $resultados = DB::table($input["tabla"])->select($input["value"] . " as value", $input["option"] . " as option")->get();
                $jsonDecoded["inputs"][$index]["resultados"] = $resultados;
                $jsonDecoded["inputs"][$index]["value"] = $valores->{$input["name"]};
                $jsonDecoded["inputs"][$index]["ejemplo"] = false;
            }



            if ($input["type"] == "checkbox") {
                //Obtener la cadena guardada de opciones separadas por comas
                $str_vals = $valores->{$input["name"]};
                if ($input["enlazado"] == "true") {
                    $valores1 = DB::table($input["tabla"])->pluck($input["valores_tabla"])->toArray();
                    $textos1 = DB::table($input["tabla"])->pluck($input["textos_tabla"])->toArray();
                    $jsonDecoded["inputs"][$index]["resultados_valores"] = $valores1;
                    $jsonDecoded["inputs"][$index]["resultados_textos"] = $textos1;
                }
                $jsonDecoded["inputs"][$index]["value"] = explode(",", $str_vals);
            }

            // Obtener el valor original del select2
            if ($input["type"] === "select2") {
                $idSeleccionado = $valores->{$input["name"]}; // El ID guardado

                // Buscar en la tabla el registro por ID
                $registro = DB::table($input["tabla"])
                    ->where($input["principal"], $idSeleccionado)
                    ->first();

                $texto = '';
                if ($registro) {
                    // Concatenar campos de "retornar" para mostrar texto en el select2
                    $texto = collect($input["retornar"])
                        ->map(fn($campo) => $registro->{$campo} ?? '')
                        ->implode(' ');
                }

                // Precargar el texto y el id al JSON que usarás en la vista
                $jsonDecoded["inputs"][$index]["id_seleccionado"] = $idSeleccionado;
                $jsonDecoded["inputs"][$index]["texto_concatenado"] = trim($texto);
            }
        }

        $jsonDecoded["title"] = "Lectura formulario";
        $jsonDecoded["id"] = $id;
        $jsonDecoded["nombre_documento"] = $tabla . ".json";
        $jsonDecoded["tabla_registros"] = $tabla_registros;
        // $jsonDecoded["nombre_documento"] = $Form->nombre_documento;
        //dd($jsonDecoded);
        return view('sistema_cobros.form_creator.modificar_registro', $jsonDecoded);
    }

    public function modificarRegistro(Request $request, string $tabla = "", string $id = "")
    {

        $datos = $request->except(['_token', 'nombre_documento', 'identificador_action']);

        foreach ($datos as $key => $value) {
            if (is_array($value)) {
                $datos[$key] = implode(',', $value); // o json_encode($value) si prefieres JSON
            }
        }
        DB::table($tabla)->where('id', $id)->update($datos);

        return back()->with('success', 'Registro actualizado correctamente.');
    }
}
