<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\HuellaMaestro;
use App\Models\Maestro;

class LocalhostController extends Controller
{
    
    public function login(Request $request){
         $validator = Validator::make($request->all(), [
                'usuario' => 'required|string',
                'password' => 'required|string',
                'auth_token' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json(['validated' => false, 'message' => 'Datos incompletos'], 400);
            }

            // Verificar el token de autenticación
            if ($request->auth_token !== env('AUTH_SECRET_KEY')) {
                return response()->json(['validated' => false, 'message' => 'Acceso no autorizado'], 401);
            }

            // Buscar usuario en la base de datos
            $user = User::where('email', $request->usuario)->orWhere('name', $request->usuario)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['validated' => false, 'message' => 'Credenciales incorrectas'], 401);
            }

            // Generar un nuevo token (opcional)
            $token = Str::random(60);

            return response()->json([
                'validated' => true,
                'message' => 'Login exitoso',
                'user' => [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'email' => $user->email
                ] // Puedes guardarlo en la BD si usas autenticación basada en tokens
            ]);

    }

    public function consultarMaestros(Request $request){
            $validator = Validator::make($request->all(), [
                'auth_token' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json(['validated' => false, 'message' => 'Datos incompletos'], 400);
            }
            // Verificar el token de autenticación
            if ($request->auth_token !== env('AUTH_SECRET_KEY')) {
                return response()->json(['validated' => false, 'message' => 'Acceso no autorizado'], 401);
            }
            $maestros = DB::table('maestros')
            ->leftJoin('huellas_maestros', 'maestros.id', '=', 'huellas_maestros.id_maestro')
            ->select('maestros.id','maestros.nombre','maestros.apellido_paterno','maestros.apellido_materno', 'huellas_maestros.id_huella')
            ->get();

             return response()->json([
                'validated' => true,
                'message' => 'Maestros encontrados',
                'maestros' => $maestros// Puedes guardarlo en la BD si usas autenticación basada en tokens
            ]);
    }


    public function loginGet(Request $request){
        return response()->json(["mensaje"=>"recibido"]);
    }

    public function enlazarHuella(Request $request){
        $request->validate([
            "maestro"=>"required|exists:maestros,id",
            "id_dispositivo"=>"required|integer",
            "auth"=>"required|string"
        ]);

        // Verificar el token de autenticación
        if ($request->auth !== env('AUTH_SECRET_KEY')) {
            return response()->json(['validated' => false, 'message' => 'Acceso no autorizado'], 401);
        }
        $Huella = new HuellaMaestro();
        $Huella->id_maestro = $request->maestro;
        $Huella->id_huella = $request->id_dispositivo;
        $Huella->save();

        $maestro = Maestro::select("nombre", "apellido_paterno", "apellido_materno")
                  ->find($request->maestro);
                  
        return response()->json([
            'enlazada' => true,
            'message' => 'Maestro cuenta con huella digital guardada.',
            'maestro' => $maestro// Puedes guardarlo en la BD si usas autenticación basada en tokens
        ]);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}
