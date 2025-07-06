<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstaladorJsonController extends Controller
{

    public function cargarDocumentoTablasGeneradasAI()
    {
        // función ai



    }





    public function formulario()
    {
        return view('sistema_cobros.instalador.subir_json', ['title' => 'Instalar informes y formularios']);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'formularios_json.*' => 'file|mimes:json',
            'informes_json.*' => 'file|mimes:json',
        ]);

        // Formularios
        if ($request->hasFile('formularios_json')) {
            foreach ($request->file('formularios_json') as $archivo) {
                $nombre = $archivo->getClientOriginalName();
                Storage::putFileAs('formularios', $archivo, $nombre);
            }
        }

        // Informes
        if ($request->hasFile('informes_json')) {
            foreach ($request->file('informes_json') as $archivo) {
                $nombre = $archivo->getClientOriginalName();
                Storage::putFileAs('informes', $archivo, $nombre);
            }
        }

        return back()->with('success', 'Archivos JSON instalados correctamente.');
    }
}
