<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DirectorioRoot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DirectoriosRootController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function verTodos(Request $request){
        // La vista de este método es para directivos o administrativos

        $id_user = Auth::user()->id;
        $directorios_user = DB::table('directorios_root')->where('propietario','=',$id_user)->get();

        $todos = DB::table('directorios_root')
        ->select("directorios_root.id","directorios_root.nombre_directorio",DB::raw('CONCAT(users.name," ",users.lastname) as usuario'))
        ->join('users','directorios_root.propietario','=','users.id')
        ->get();

        // Creamos un nuevo directorio root con el nombre del usuario y fecha
        if(!$directorios_user->count()>0){
            $username = Str::replace(' ','',Auth::user()->name);
            $date = "_".Carbon::now()->format('Y_m_d');
            Storage::makeDirectory($username.$date);
        }

        return view('sistema_cobros.directorios_root.ver_todos',[
            'title'=>'Directorios',
            'todos'=>$todos
        ]);
    }


    public function create()
    {
        return view('sistema_cobros.directorios_root.create',["title"=>"Crear un nuevo directorio"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'nombre_directorio' => 'required|string|max:40'
        ]);

        $nombre_directorio = $request->nombre_directorio."_".Carbon::now()->format('Y_m_d');

        if (Storage::exists($nombre_directorio)) {
            return back()->with("error","El nombre de directorio ya existe");
        }

        if (!Storage::makeDirectory($nombre_directorio)) {
            return back()->with("error","No se pudo crear el directorio");
        }

        $directorio = new DirectorioRoot();
        $directorio->id = (string) Str::uuid();
        $directorio->nombre_directorio = $nombre_directorio;
        $directorio->propietario = $request->id_usuario;
        $directorio->creadoPor = Auth::user()->id;
        $directorio->activo = true;

        $directorio->save();

        return back()->with("success","Carpeta root creada exitosamente");
    }

    public function getDirectorios(Request $request){

        $request->validate([
            "ruta"=>"required|string|max:255|exists:capetas_usuarios,nombre_ruta"
        ]);

        $user = DB::table('carpetas_usuarios')
        ->select(DB::raw("CONCAT(users.name,' ', users.lastname) as propietario"),'carpetas_usuarios.propietario',
        'carpetas_usuarios.nombre_ruta','directorios_root.nombre_directorio','directorios_root.id')
        ->join('users', 'users.id', '=', 'carpetas_usuarios.propietario')
        ->join('directorios_root','carpetas_usuarios.propietario','=','directorios_root.nombre_directorio')
        ->where('carpetas_usuarios.nombre_ruta','=',$request->ruta)
        ->first();

        $directory = $request->ruta;
        $subdirectories = Storage::directories($user->$nombre_directorio."/".$directory);

        return $subdirectories;

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
