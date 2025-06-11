<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PromocionesController extends Controller
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
    public function create()
    {
          return view('sistema_cobros.promociones.create',[
                        "title"=>"Registrar una nueva promoción",
                        "titulo_breadcrumb" => "Promociones",
                        "subtitulo_breadcrumb" => "Crear una nueva promoción.",
                        "go_back_link"=>"#"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'breve_descripcion' => 'required|string|max:255',
            'inicia_en' => 'required|date',
            'caducidad' => 'required|date|after:inicia_en',
            'banner1200x700' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner300x250' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activo' => 'required|boolean',
            'tasa' => 'required|numeric|max:1',
            'monto' => 'required|numeric'
        ]);

        // Crear una nueva instancia de Promocion
        $promocion = new Promocion();
        $promocion->id = (string) Str::uuid(); // Generar un UUID para el id
        $promocion->nombre = $request->nombre;
        $promocion->breve_descripcion = $request->breve_descripcion;

        // Manejar la subida de los banners_promociones
        $random_code = Str::random(8);
        if ($request->hasFile('banner1200x700')) {
            $banner1200x700 = $request->file('banner1200x700')->store('banners_promociones', 'public');
            
            $promocion->banner_1200x700 = $banner1200x700;
        } else {
            $promocion->banner_1200x700 = $random_code."_".'default_1200x700.png'; // Establecer un valor por defecto si no se sube
        }
        if ($request->hasFile('banner300x250')) {
            $banner300x250 = $request->file('banner300x250')->store('banners_promociones', 'public');
            $promocion->banner_300x250 = $banner300x250;
        } else {
            $promocion->banner_300x250 = $random_code."_".'default_300x250.png'; // Establecer un valor por defecto si no se sube
        }

        $promocion->inicia_en = $request->inicia_en;
        $promocion->caducidad = $request->caducidad;
        $promocion->activo = $request->activo;
        $promocion->monto = $request->monto;
        $promocion->tasa = $request->tasa;
        $promocion->tipo = $request->tipo; //guia: elegir si es tasa o monto lo que se quiere descontar o incluso
        $promocion->createdBy = auth()->user()->id; // Asignar el usuario que creó la promoción

        // Guardar la nueva promoción
        $promocion->save();

        // Redirigir o devolver una respuesta
        return back()->with('success', 'Promoción creada exitosamente');


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
        $promocion = Promocion::findOrFail($id);
         return view('sistema_cobros.promociones.edit',[
                        "title"=>"Editar promoción",
                        "titulo_breadcrumb" => "Promociones",
                        "subtitulo_breadcrumb" => "Editar promoción.",
                        "go_back_link"=>"#",
                        "promocion"=>$promocion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'breve_descripcion' => 'required|string|max:255',
            'banner_1200x700' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_300x250' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'inicia_en' => 'required|date',
            'caducidad' => 'required|date|after:inicia_en',
            'activo' => 'required|boolean',
        ]);

        // Buscar la promoción por id
        $promocion = Promocion::findOrFail($id);

        // Actualizar los datos
        $promocion->nombre = $request->nombre;
        $promocion->breve_descripcion = $request->breve_descripcion;

        // Manejar la actualización de los banners si se suben nuevos archivos
        if ($request->hasFile('banner_1200x700')) {
            $banner1200x700 = $request->file('banner_1200x700')->store('banners_promociones', 'public');
             Storage::disk('public')->delete($promocion->banner_1200x700);
             $promocion->banner_1200x700 = $banner1200x700;
        }

        if ($request->hasFile('banner_300x250')) {
            $banner300x250 = $request->file('banner_300x250')->store('banners_promociones', 'public');
            Storage::disk('public')->delete($promocion->banner_300x250);
            $promocion->banner_300x250 = $banner300x250;
        }

        $promocion->inicia_en = $request->inicia_en;
        $promocion->caducidad = $request->caducidad;
        $promocion->activo = $request->activo;
        $promocion->tipo = $request->tipo;

        // Guardar los cambios
        $promocion->save();

        // Redirigir o devolver una respuesta
        return back()->with('success', 'Promoción actualizada exitosamente');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            //
        }
}
