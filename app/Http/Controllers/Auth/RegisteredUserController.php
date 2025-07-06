<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('general.auth.register',["title"=>"Registra tu usuario"]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname'=> ['required','string', 'max:255'],
            'telephone'=> ['required','string', 'max:15'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Contamos los usuarios existentes
        $usuariosExistentes = User::count();

        // Creamos al nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'telephone' => $request->telephone,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Asignamos el rol basado en el número de usuarios
        if ($usuariosExistentes === 0) {
            $user->assignRole('Administrador tecnológico');
        } elseif ($usuariosExistentes === 1) {
            $user->assignRole('Owner');
        } else {
            $user->assignRole('Colaborador'); // o cualquier otro rol por defecto
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

}
