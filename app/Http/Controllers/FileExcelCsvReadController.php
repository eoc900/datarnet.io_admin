<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;

class FileExcelCsvReadController extends Controller
{

    public function cargarCalificaciones(){
        return view('sistema_cobros.lectura_archivos.create',[
            'title'=>'Cargar Calificaciones',
            'breadcrumb_title'=>'Carga']);
    }
    public function read(Request $request)
    {
        // Valida el archivo
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');

        // Carga el archivo Excel
        $spreadsheet = IOFactory::load($file->getPathname());

        // Obtén la hoja activa
        $sheet = $spreadsheet->getActiveSheet();

        // Lee los datos (ejemplo: toda la hoja)
        $data = $sheet->toArray();

        // Retorna los datos o haz algo con ellos
        return back()->with("resultados",$data);
    }


    public function alimentarBase(){

        $prefijo = "modulo001";
        $lista_usuarios = User::all();
        $lista_tablas_modulo = DB::table("tablas_modulos as tb")
        ->select("tb.nombre_documento","tb.qty_columnas","tb.activo","columnas_tablas.id_columna","columnas_tablas.tipo_dato")
        ->join("columnas_tablas","tb.id","=","columnas_tablas.id_tabla")
        ->get();

        return view();

    }


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
