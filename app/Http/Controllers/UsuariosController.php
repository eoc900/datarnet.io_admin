<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuariosRequest;
use App\Http\Requests\UpdateUsuariosRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Helpers\Filter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Helpers\Mensajes;
use Illuminate\Support\Facades\Crypt;
use App\Models\Code;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class UsuariosController extends Controller
{

    public function index(Request $request){
        $filter = [         // $filter -> recuerda crear el query en la clase correspondiente ["filtro"=>"nombreMetodo"]
            "Email"=>"getUserByEmail"
        ];
        $user = new User();
        $usuarios =Filter::runQuerySingleParam($request,$user,$filter,"getUserByEmail");
        $count = $usuarios->count();
        $usuarios = $usuarios->paginate(10);
        $usuarios->appends(["page"=>$request->page,"search"=>$request->search,"filter"=>$request->filter]);
         return view('administrador.usuarios.index',[
            "title"=>"Usuario",
            "breadcrumb_title" => "Usuarios",
            "breadcrumb_second" => "Lista Usuarios",
            "hasDynamicTable"=>true,
            "rowCheckbox"=>true,
            "idKeyName"=>"id",
            "keys"=>array('id',"name",'email',"telephone","estado"),
            "columns"=>array("#Ref","Nombre","Email","Telefono","Estado"),
            "indicadores"=>true, // esta funcion esta enlzada a la propiedad de abajo (botones) pero también debes tener una columna llamada estado
            "botones"=>array('Inactivo'=>'btn-outline-danger',
                                'Activo'=>'btn-outline-success',
                                'Bloqueado'=>'btn-outline-warning'),
            "rowActions"=>array("show","edit","destroy"),
            "data" => $usuarios,
            "routeDestroy" => 'usuarios.destroy',
            "routeCreate" => 'usuarios.create',
            "routeEdit" => 'usuarios.edit',
            "routeShow" => 'usuarios.show',
            "routeIndex" => 'usuarios.index',
            "ajaxRenderRoute" => '/html/tableTareas',
            "reRenderSection" => ".dynamic_table",
            "searchFor"=>$request->search,
            "count" => $count,
            "filtros_busqueda"=>User::$estados,
            "txtBtnCrear"=>"Agregar un usuario"
        ]);
    }

    public function show($id){
        $object = User::where('id', '=', $id)->firstOrFail(); 
        $roles = DB::table("model_has_roles")
        ->select("roles.name","model_has_roles.model_id")
        ->join("roles","model_has_roles.role_id","=","roles.id")
        ->where("model_has_roles.model_id","=",$id)->get();
        return view('administrador.usuarios.show',[
                    "title"=>"Usuario",
                    "breadcrumb_title" => "Usuario",
                    "breadcrumb_second" => "Visualizar Usuario",
                    "data"=>$object,
                    "roles"=>$roles
        ]);

    }

    public function create(){
        $user = new User();
        $estados = $user::$estados;
        $categorias = $user->tipo;
        
         return view('administrador.usuarios.create',[
            "title"=>"Usuarios",
            "breadcrumb_title" => "Usuarios",
            "breadcrumb_second" => "Visualizar usuarios",
            "estados" => $estados,
            "categorias" => $categorias,
            "routeDestroy" => 'usuarios.destroy',
            "routeCreate" => 'usuarios.create',
            "routeStore" => 'usuarios.store',
            "routeEdit" => 'usuarios.edit',
            "routeShow" => 'usuarios.show',
            "routeIndex" => 'usuarios.index'
        ]);

    }

    public function store(StoreUsuariosRequest $request){
        $mensajes = new Mensajes();
        
        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->telephone = $request->telephone;

        $user->estado = $request->estado;
        $user->creado_por = Auth::user()->id; // Asumiendo que tienes autenticación y quieres guardar el nombre del usuario
        $user->created_at = now();
        $user->password = Hash::make(strtolower($request->name."_".$request->email));
        $user->codigo_activacion = Str::random(15);

        
        // Guardar el registro en la base de datos
        $user->save();
        $user->assignRole($request->user_type);
        $mensajes->add(array("response"=>true,"message"=>"Se agregó un usuario."));
        return back()->with('mensajes',$mensajes->log);

    }

    public function edit($id){

        $user = new User();
        $estados = $user::$estados;
        $categorias = $user->tipo;
        $user = User::where('id','=',$id)->firstOrFail();
        return view('administrador.usuarios.edit',[
            "title"=>"Usuario",
            "breadcrumb_title" => "Usuario",
            "breadcrumb_second" => "Editar Usuario",
            "estados" => $estados,
            "categorias"=>$categorias,
            "user" => $user,
            "routeUpdate" => 'usuarios.update',
        ]);

    }

    public function update(UpdateUsuariosRequest $request, $id){

        if(Auth::user()->hasRole("Admin")){
            $users = User::findOrFail($id);
            $users->update([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'telephone' => $request->input('telephone'),
                'estado' => $request->input('estado'),
                'updated_at' => now(),
                'actualizado_por' => Auth::user()->id
            ]); 
            return back()->with('success', 'Usuario actualizado exitosamente.');
        }
        return back()->with('error', 'No se pudo actualizar información de usuario.');    
    }

    public function destroy($id){

        if(Auth::user()->hasRole(["Admin","Developer"])){

            $record = User::find($id);
            if($record && $record->id!=Auth::user()->id){
                $record->delete();
                return back()->with('success', 'Registro de usuario eliminado exitosamente.');
            }
        }
        
        return back()->with('error', 'No tienes autorización para borrar registro');
    }
    

    public function perfil(){
        $code = encrypt("xbjigEEPM24@");
        $email = encrypt("eoc900@gmail.com");
        $id = (string) Str::uuid();
        $roles = DB::table("model_has_roles")
        ->select("roles.name","model_has_roles.model_id")
        ->join("roles","model_has_roles.role_id","=","roles.id")
        ->where("model_has_roles.model_id","=",Auth::user()->id)->get();
        return view('administrador.usuarios.profile',[
            "title"=>Auth::user()->name,
            "breadcrumb_title" => "Usuario",
            "breadcrumb_second" => "Visualizar mis datos",
            "avatar"=>Auth::user(),
            "email"=>$email,
            "code"=>$code,
            "id"=>$id,
            "roles"=>$roles

        ]);
    }


    public function registerMasterView(){
        return view('administrador.usuarios.master',[
            "title"=>"Registrar Usuario Master",
            "breadcrumb_title" => "Usuarios",
            "breadcrumb_second" => "Visualizar usuarios",
        ]);
    }

    public function receiveMaster(Request $request){

        $request->validate([
            'name' => 'required|string|max:62',
            'lastname' => 'string|max:84',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|max:32',
            'master_code' => 'required|string|max:12',
        ]);

        if(env('APP_MASTER_REGISTER')==$request->master_code){
            $user = new User();
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user = User::create([
                'name' =>  $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'codigo_maestro' => Hash::make($request->master_code),
                'user_type'=>"Admin",
                'estado'=>"Activo"
           
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        }
        $configVariable = config('app.APP_MASTER_REGISTER');

        return back()->with('error', 'Lo sentimos algo salió mal. '.$configVariable);
    }

    public function updateAvatar(Request $request){
        $rules = [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Maximum file size of 2MB
        ];

        // Custom error messages (optional)
        $messages = [
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'avatar.max' => 'The image may not be greater than 2MB.',
        ];
        $request->validate($rules, $messages);
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/avatares', $imageName); // Store the image in the storage folder
        }else{
            return back()->with('error', 'No se encontró archivo');
        }

        $user = User::findOrFail(Auth::user()->id);
        if(Auth::user()->avatar!=null){
            Storage::delete('public/avatares/'.Auth::user()->avatar);
        }

         $user->update(["avatar"=>$imageName]);
         return back()->with('success', 'Archivo modificado');

    }

    public function vistaModificarRoles(){
        $roles = DB::table("roles")->get();
        return view('administrador.usuarios.programar_roles',[
            "title"=>"Modificar Roles",
            "titulo_breadcrumb"=>'Usuarios',
            "subtitulo_breadcrumb"=>'Roles de usuario',
            "select2"=>'/select2/usuarios',
            "idSelect2"=>'seleccionUsuarios',
            "roles"=>$roles,
            "titulo_formulario"=>"",
            "routeStore"=>"insert.rol_usuario",
            "accion"=>"alta",
            "formulario"=>"user_roles"]);
    }

    public function removeRol(Request $request){
        $request->validate([
                'rol'=>'required|string|max:42',
                'user_id'=>'required|string|max:36'
        ]);
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])

        if(auth::user()->email=="eoc900@gmail.com"){
               $user = User::find($request->user_id);
            if ($user->hasRole($request->rol)) {
                // Elimina el rol del usuario
                $user->removeRole($request->rol);
            }
            $mensajes->add(array("response"=>true,"message"=>"Se eliminó el rol: ".$request->rol));

        }else{
            $mensajes->add(array("response"=>true,"message"=>"Lo sentimos algo salió mal, no se pudo eliminar el rol"));
        }
     
        return back()->with("mensajes",$mensajes->log);
    }
}
