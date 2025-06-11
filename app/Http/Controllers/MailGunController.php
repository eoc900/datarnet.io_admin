<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class MailGunController extends Controller
{
    public function storage(Request $request){
         // Extraer la información relevante del correo
        $sender = $request->input('sender');
        $subject = $request->input('subject');
        $timestamp = $request->input('timestamp');
        $bodyPlain = $request->input('body-plain');
        $bodyHtml = $request->input('body-html');

        // Formatear el contenido para guardar en el archivo
        $logEntry = "Timestamp: $timestamp\nFrom: $sender\nSubject: $subject\nBody Plain: $bodyPlain\nBody HTML: $bodyHtml\n\n";

        // Guardar la información en un archivo de registro
        $logFile = storage_path('logs/emails_log.txt');
        File::append($logFile, $logEntry);

        // Opcional: Guardar también en el log de Laravel
        Log::info('Correo recibido:', [
            'sender' => $sender,
            'subject' => $subject,
            'timestamp' => $timestamp,
            'body_plain' => $bodyPlain,
            'body_html' => $bodyHtml
        ]);

        return response()->json(['status' => 'success','mensaje'=>'webhook recibido'], 200);
    }
}
