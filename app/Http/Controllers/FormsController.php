<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\PagosDiferidos;
use App\Helpers\Mensajes;
use App\Models\ListadoFormularios;
use App\Models\Escuela;
use App\Models\ConceptoCobro;
use App\Models\CostoConceptoCobro;
use App\Models\Alumno;
use App\Models\SistemaAcademico;
use App\Models\Cuenta;
use App\Models\Cobro;
use App\Models\User;
use App\Models\Code;
use App\Models\DesgloseCuenta;
use App\Models\CategoriaCobro;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Add this import statement
use DateTime;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class FormsController extends Controller
{

    public function index(Request $request){
        //pages/formulario es un redireccionador de vistas hacia formularios
        return view('sistema_cobros.pages.formulario', ListadoFormularios::lista($request));
    }

     public function actualizar(Request $request){
        //pages/formulario es un redireccionador de vistas hacia formularios
        return view('sistema_cobros.pages.formulario', ListadoFormularios::listaEdicion($request));
    }

    public function store(Request $request){
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
        
        if($request->formulario=="escuela"){
                // Validar los datos de entrada
            $request->validate([
                'codigo_escuela' => 'required|string|max:32',
                'nombre' => 'required|string|max:64',
                'calle' => 'required|string',
                'colonia' => 'required|string',
                'codigo_postal' => 'required|string|max:9',
                'num_exterior' => 'required|string|max:5',
                'ciudad' => 'required|string|max:32',
                'estado' => 'required|string|max:32',
                'activo' => 'required|boolean',
                'imagen_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

             if ($request->hasFile('imagen_logo')) {
                $image = $request->file('imagen_logo');
                $imageName = time() . '.' . $image->getClientOriginalExtension(); // Nombre único para la imagen
                $request->file('imagen_logo')->storeAs('logos/',$imageName, 'public');
            }

            // Crear una nueva instancia de Escuela
            $escuela = new Escuela([
                'id' => (string) Str::uuid(), // Generar un UUID
                'codigo_escuela' => $request->codigo_escuela,
                'nombre' => $request->nombre,
                'calle' => $request->calle,
                'colonia' => $request->colonia,
                'codigo_postal' => $request->codigo_postal,
                'num_exterior' => $request->num_exterior,
                'ciudad' => $request->ciudad,
                'estado' => $request->estado,
                'creada_por' => Auth::user()->id,
                'activo' => $request->activo,
                'imagen_logo'=> $imageName
            ]);

            // Guardar la instancia en la base de datos
            $escuela->save();
            $mensajes->add(array("response"=>true,"message"=>"Se agregó la escuela exitosamente"));
        }


        if($request->formulario=="sistema_academico"){
                // Validar los datos de entrada
            $request->validate([
                'codigo_sistema' => 'required|string|max:32',
                'id_escuela' => 'required|string',
                'nombre' => 'required|string|max:64',
                'activo' => 'required|boolean',
            ]);

            $escuela = DB::table('escuelas')->where("id","=",$request->id_escuela)->first();
            // Crear una nueva instancia de Escuela
            $sistema = new SistemaAcademico([
                'id' => (string) Str::uuid(), // Generar un UUID
                'id_escuela'=>$request->id_escuela,
                'codigo_sistema' => $escuela->codigo_escuela."-".$request->codigo_sistema,
                'nivel_academico' => $request->nivel_academico,
                'nombre' => $request->nombre,
                'creada_por' => Auth::user()->id,
                'activo' => $request->activo,
            ]);

            // Guardar la instancia en la base de datos
            $sistema->save();
            $mensajes->add(array("response"=>true,"message"=>"Se agregó el sistema academico exitosamente"));
        }

         if($request->formulario=="alumnos"){
                // Validar los datos de entrada
            $request->validate([
                'nombre' => 'required|string|max:32',
                'apellido_paterno' => 'required|string|max:32',
                'apellido_materno' => 'required|string|max:32',
                'id_sistema' => 'required|string',
                'telefono' => 'required|string|max:15',
                'matricula' => 'required|string|max:10',
                'email' => 'required|email|max:32',
                'activo' => 'required|boolean',
            ]);

            // Crear una nueva instancia de Escuela
            $alumno = new Alumno([
                'id' => (string) Str::uuid(), // Generar un UUID
                'id_sistema_academico'=>$request->id_sistema,
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'creado_por' => Auth::user()->id,
                'activo' => $request->activo,
                'matricula'=> $request->matricula
            ]);

            // Guardar la instancia en la base de datos
            $alumno->save();
            $mensajes->add(array("response"=>true,"message"=>"Se agregó al alumno exitosamente"));
        }

        if($request->formulario=="conceptos_cobros"){
                // Validar los datos de entrada
            $request->validate([
                    'id_escuela'=>'required|string',
                    'codigo_concepto' => 'required|string|max:32',
                    'nombre' => 'required|string|max:42',
                    'activo' => 'required|boolean',
                    'sistema_academico' => 'nullable|exists:sistemas_academicos,id',
                    'categoria_cobro' => 'exists:categoria_cobros,id'  
            ]);

            // Crear una nueva instancia de Escuela
            $concepto = new ConceptoCobro([
                'id' => (string) Str::uuid(), // Generar un UUID
                'id_escuela'=>$request->id_escuela,
                'id_categoria'=>$request->categoria_cobro,
                'sistema_academico'=>$request->sistema_academico,
                'codigo_concepto'=>$request->codigo_concepto,
                'nombre' => $request->nombre,
                'creado_por' => Auth::user()->id,
                'activo' => $request->activo
            ]);
            // Guardar la instancia en la base de datos
            $concepto->save();
            $mensajes->add(array("response"=>true,"message"=>"Se agregó el concepto de cobro exitosamente"));
        }

         if($request->formulario=="costo_concepto"){
                // Validar los datos de entrada
            $request->validate([
                'id_concepto'=>'required|string',
                'anio' => 'required|numeric|max:2050',
                'cuatri' => 'required|numeric|max:4',
                'costo' => 'required|numeric'
            ]);

            $resultados = CostoConceptoCobro::where("periodo","=",$request->anio."".$request->cuatri)->where("id_concepto","=",$request->id_concepto);
            
            if($resultados->count()==0){
                $costoC= new CostoConceptoCobro([
                'id' => (string) Str::uuid(), // Generar un UUID
                'id_concepto'=>$request->id_concepto,
                'periodo'=>$request->anio."".$request->cuatri,
                'costo' => $request->costo,
                'creado_por' => Auth::user()->id,
                'activo' => $request->activo
                ]);
                $costoC->save();
                $mensajes->add(array("response"=>true,"message"=>"Se agregó el costo de concepto de cobro exitosamente"));
            }
            if($resultados->count()>0){
                $mensajes->add(array("response"=>false,"message"=>"Lo sentimos ese costo ya está registrado para ese concepto y periodo."));
            }
          
            
        }
        if($request->formulario=="cuentas"){
                // Validar los datos de entrada
            $request->validate([
                'id_alumno'=>'required|string',
                'anio' => 'required|numeric|max:2050',
                'cuatri' => 'required|numeric|max:4',
                'pagos' => 'required|string',
                'activa'=> 'required|boolean'
            ]);

            //1. obtener el id de sistema al que está enrolado el alumno
            $alumno = DB::table('alumnos')->select('id_sistema_academico')->find($request->id_alumno);
            //2. buscar el id de concepto pago relacionado al id_sistema
            $concepto_cobro = DB::table('conceptos_cobros')->select('conceptos_cobros.id','conceptos_cobros.codigo_concepto')
            ->join('categoria_cobros','conceptos_cobros.id_categoria','=','categoria_cobros.id')
            ->where('conceptos_cobros.sistema_academico','=',$alumno->id_sistema_academico)
            ->where('categoria_cobros.categoria','like',"%colegiatura%")
            ->first();

            if(!$concepto_cobro){
                $mensajes->add(array("response"=>false,"message"=>"No hay un concepto de cobro de colegiatura para el sistema academico de este alumno. "));
            }

            //3. Con el periodo seleccionado consultamos aquel registro que esté activo, con el periodo especifico, id_concepto, 
            // para obtener ese costo de concepto de cobro que es mensual ()
            if($concepto_cobro){
                $costo = DB::table('costo_concepto_cobros')
                ->where('id_concepto','=',$concepto_cobro->id)
                ->where('periodo','=',$request->anio."".$request->cuatri)
                ->where('activo','=',1)
                ->first();
            }

            if(!$costo){
                $mensajes->add(array("response"=>false,"message"=>"Aún no asignas un costo para este concepto de colegiatura {$concepto_cobro->codigo_concepto} del periodo: ".$request->anio."".$request->cuatri));
                return back()->with("mensajes",$mensajes->log);
            }

            if($request->pagos=="semanal"){
                $pagos = 16;
            }
            if($request->pagos=="quincenal"){
                $pagos = 8;
            }
            if($request->pagos=="mensual"){
                $pagos = 4;
            }

            $costo_mensual = $costo->costo;
            $costo_cuatrimestre = $costo_mensual*4;
            $cantidadPago = $costo_cuatrimestre/$pagos;

            


            $fechas = PagosDiferidos::getCuatrimestreFechas($request->anio, $request->cuatri);


            
            // Crear una nueva instancia de cuenta
            $id_cuenta = (string) Str::uuid();

            $cuenta= new Cuenta([
                'id' => $id_cuenta, // Generar un UUID
                'id_alumno'=>$request->id_alumno,
                'cuatrimestre'=>$request->anio."".$request->cuatri,
                'dist_pagos_cuatri' => $pagos,
                'creada_por' => Auth::user()->id,
                'activa' => $request->activa,
                'fecha_inicio'=>$fechas["fecha_inicio"],
                'vencimiento'=>$fechas["fecha_fin"]
            ]);
            // Guardar la instancia en la base de datos
            $cuenta->save();


            $insert = DesgloseCuenta::generarCargosColegiatura($id_cuenta, $costo->id, $pagos, ($costo->costo/($pagos/4)),$request->anio."".$request->cuatri, Auth::user()->id);

            





            $mensajes->add(array("response"=>true,"message"=>"Se agregó una cuenta exitosamente exitosamente"));

            $mensajes->add(array("response"=>true,"message"=>"id_sistema: ".$alumno->id_sistema_academico." id concepto cobro ".$concepto_cobro->id));
            $mensajes->add(array("response"=>true,"message"=>"Cantidad de pagos programados: ".$pagos."; Monto por pago: ".$cantidadPago."; Total: ".$costo_cuatrimestre));
        }
        if($request->formulario=="cobros"){
                // Validar los datos de entrada
            $request->validate([
                'id_cuenta'=>'required|string',
                'id_costo_concepto'=>'required|string',
                'periodo' => 'required|numeric|max:30000',
                'estado'=> [Rule::in(Cobro::mostrarEstados())],
                'fecha_inicio'=>'required|date_format:Y-m-d\TH:i',
                'fecha_fin'=>'required|date_format:Y-m-d\TH:i'

            ]);
            $datetime = DateTime::createFromFormat('Y-m-d\TH:i', $request->fecha_inicio);
            $fecha_inicio = $datetime->format('Y-m-d H:i:s');
            $datetime = DateTime::createFromFormat('Y-m-d\TH:i', $request->fecha_fin);
            $fecha_fin = $datetime->format('Y-m-d H:i:s');

            
           
            $cuenta= new Cobro([
                'id' => (string) Str::uuid(), // Generar un UUID
                'id_cuenta'=>$request->id_cuenta,
                'id_costo_concepto'=>$request->id_costo_concepto,
                'periodo'=>$request->periodo,
                'estado' => $request->estado,
                'creado_por' => Auth::user()->id,
                'fecha_inicio'=>$fecha_inicio,
                'fecha_fin'=>$fecha_fin
            ]);
            // Guardar la instancia en la base de datos
            $cuenta->save();
            $mensajes->add(array("response"=>"success","message"=>"Se agregó una ficha de cobro exitosamente."));
        }
        if($request->formulario=="roles"){
             $request->validate([
                'rol'=>'required|string|max:32'
            ]);
            $role = Role::create(['name' => $request->rol]);
            $mensajes->add(array("response"=>"success","message"=>"Se agregó un rol de usuario exitosamente."));
        }
        if($request->formulario=="permisos"){
             $request->validate([
                'permiso'=>'required|string|max:42'
            ]);
            $permission = Permission::create(['name' => $request->permiso]);
            $mensajes->add(array("response"=>"success","message"=>"Se agregó un nuevo permiso."));
        }
        if($request->formulario=="rol_permisos"){
            $request->validate([
                'rol'=>'required|string|max:42',
                'permiso' => 'required|array',

            ],['permiso.required' => 'Debes seleccionar al menos un permiso.']);
            
            $role = Role::findByName($request->rol);
            $role->givePermissionTo($request->permiso);

         
            $mensajes->add(array("response"=>"success","message"=>"Se agregaron los permisos al rol."));
        }
        if($request->formulario=="user_roles"){
           
            $request->validate([
                'rol'=>'required|string|max:42',
                'user_id'=>'required|string|max:36',
                'hidden_input'=>'required|string',
                'code'=>'required|string',
            ]);

            

            if(Auth::user()->email=="eoc900@gmail.com" && $request->code==330320){
               $mensajes->add(array("response"=>"success","message"=>"Cambio fue aprovado."));
            }

            $user = User::find($request->user_id);
            $user->assignRole($request->rol);
            $mensajes->add(array("response"=>"success","message"=>"Se agregó un nuevo rol al usuario."));
        }

        if($request->formulario=="categoria_cobros"){
                // Validar los datos de entrada
            $request->validate([
                    'categoria' => 'required|string|max:32|unique:categoria_cobros,categoria',
                    'activo' => 'required|boolean'
            ]);

            // Crear una nueva instancia de Escuela
            $concepto = new CategoriaCobro([
                'categoria'=>$request->categoria,
                'activo' => $request->activo
            ]);
            // Guardar la instancia en la base de datos
            $concepto->save();
            $mensajes->add(array("response"=>true,"message"=>"Se agregó la categoría de cobro exitosamente"));
        }


        

 
            return back()->with("mensajes",$mensajes->log);


    }
}
