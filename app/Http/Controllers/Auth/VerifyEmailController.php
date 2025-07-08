<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\ModuloUser;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user(); // ✅ Definir el usuario una sola vez

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // ✅ Crear el registro en `modulo_users`
            ModuloUser::create([
                'uuid_repetido' => $user->id,
                'nombre_completo' => $user->name,
                'correo' => $user->email,
                'telefono' => $user->telefono ?? null,
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
    }
}
