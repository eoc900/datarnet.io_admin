<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Mensajes;
use Illuminate\Http\Request;
use App\Models\InvitacionUsuario;
use App\Helpers\Email;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class InvitacionesUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchFor = "";
        $filter = "";
        $page = 1;
        if($request->search != "" && isset($request->search)){
            $searchFor = $request->search;
        }
        if($request->filter != "" && isset($request->filter)){
            $filter = $request->filter;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }

      $registros = DB::table('invitaciones_usuarios')
        ->select(
            'invitaciones_usuarios.id',
            'invitaciones_usuarios.correo',
            'invitaciones_usuarios.activo',
            'invitaciones_usuarios.abierto',
            DB::raw("CONCAT(users.name, ' ', users.lastname) as enviado_por")
        )
        ->join('users', 'invitaciones_usuarios.createdBy', '=', 'users.id')
        ->where('invitaciones_usuarios.correo','like', "%{$searchFor}%")
        ->orWhere('invitaciones_usuarios.activo', 'like', "%{$searchFor}%")
        ->orWhere('invitaciones_usuarios.abierto', 'like', "%{$searchFor}%") // Cambié `=` a `like` para el patrón de búsqueda
        ->orWhere(DB::raw("CONCAT(users.name, ' ', users.lastname)"), 'like', "%{$searchFor}%");
        
        $tipos_contactos = [
            "title"=>"Invitaciones",
            "titulo_breadcrumb" => "Invitaciones",
            "subtitulo_breadcrumb" => "Invitaciones",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"invitaciones_usuarios",
            "confTabla"=>array(
                "tituloTabla"=>"Invitaciones",
                "placeholder"=>"Buscar invitaciones",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"correo","option"=>"Por correo"],["key"=>"activo","option"=>"Activo [0,1]"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('correo','enviado_por','activo','abierto'),
                "columns"=>array('Correo',"Remitente","Activo",'Abierto'),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'invitaciones_usuarios.destroy',
                "routeCreate" => ['invitaciones_usuarios','create'],
                "routeEdit" => 'invitaciones_usuarios.edit', // referente a un método ListadoFormularios
                "routeShow" => 'invitaciones_usuarios.show',
                "routeIndex" => 'invitaciones_usuarios.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Invitaciones"
            )];

            return view('sistema_cobros.invitaciones_usuarios.index', $tipos_contactos);
            
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles =  Role::all()->pluck('name')->toArray();
        return view('sistema_cobros.invitaciones_usuarios.create',[
            "title"=>"Invitaciones",
            "titulo_breadcrumb" => "Invitaciones",
            "subtitulo_breadcrumb" => "Invitaciones",
            "roles"=>$roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                'correo' => 'required|string|max:32',
                'roles'=>'required|string|max:64'
        ]);
        $codigo = (string) Str::uuid();
        InvitacionUsuario::create([
            'id' => (string) Str::uuid(),
            'createdBy' => Auth::user()->id,
            'correo'=>$request->correo,
            'codigo' => $codigo,
            'activo' => 1,
            'abierto' => 0,
            'roles'=>$request->roles
        ]);

          // 2. Enviar la url al correo del alumno correspondiente a ccuenta
        $email = new Email();
        $titulo = "Haz recibido una invitación.";
        $html_mensaje = '<h1>Por favor da click en el siguiente enlace.</h1>';
        $html_mensaje .= '<h3>Crea tu cuenta con el liga que aparece abajo. Gracias, formar parte de Centro de Estudios</h3><br>';
        $html_mensaje .= '<a href="https://admin.cegto.com.mx/vincular_usuario/'.$codigo.'" style="border: 1px solid red; border-radius:10px; color:white; background-color: #c8553c;"> Registrarme </a>';
        $enviado = $email->sendEmail($titulo,$html_mensaje,"",$request->correo,"Usuario Panel");

        
        // 3. Cambiar el estatus de enviado/entregado
        if($enviado){
            return back()->with('success','La invitación fue enviada exitosamente');
        }
        return back()->with('error','Hubo un error al enviar el correo.');

    }

    public function vincularUsuario(Request $request){
        $codigo = $request->codigo;

        // Checar si el código existe y está activo
        $resultado = DB::table('invitaciones_usuarios')
        ->where('codigo','=',$codigo)
        ->where('activo','=',1)
        ->first();

        if($resultado){
            // la vista tiene que ser de la landing page y no del panel de control
            return view('sistema_cobros.invitaciones_usuarios.validar',[
            "titulo"=>"Regístrate aquí",
            "descripcion" => "Registro de usuarios",
            "subtitulo_breadcrumb" => "Bienvenido",
            "codigo"=>$codigo
            ]);
        }else{
            return view('sistema_cobros.invitaciones_usuarios.error_validacion',[
            "titulo"=>"Error",
            "descripcion" => "Alta de cuenta",
            "subtitulo_breadcrumb" => "error"
            ]);
        }

    }

    public function registrarUsuario(Request $request){
        $request->validate([
                'nombre' => 'required|string|max:32',
                'apellido_paterno'=>'required|string|max:32',
                'apellido_materno'=> 'required|string|max:32',
                'codigo'=>'required|uuid',
                'password'=>'required|confirmed|string|min:8'

        ]);

        $resultado = DB::table('invitaciones_usuarios')
        ->where('codigo','=',$request->codigo)
        ->where('activo','=',1)
        ->first();

        $user = User::create([
            'id'=>(string) Str::uuid(),
            'name' => $request->nombre,
            'lastname' => $request->apellido_paterno." ".$request->apellido_materno,
            'email' => $resultado->correo,
            'telephone'=>$request->telefono_personal,
            'password' => Hash::make($request->password),
        ]);

        $user->markEmailAsVerified();

        $info = User::find($user->id);
        $roles = explode(',', $resultado->roles);
        $info->assignRole($roles);

        return redirect()->route('dashboard');
     
    }

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
