<x-guest-layout>
    <div class="mb-4 text-gray-600 dark:text-gray-400 text">
       <p>¡Gracias por registrarte! Antes de comenzar, </p> <br>
       <ol>
        <li class="mb-5">1. ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar?</li>
          <li class="mb-5 mt-5">2. Si no has recibido el correo, con gusto te enviaremos otro</li>
       </ol>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Reenviar correo de verificación') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Cerrar sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>
