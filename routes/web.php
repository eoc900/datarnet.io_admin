<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AjaxHtmlController;
use App\Http\Controllers\AjaxAddMultipleInputsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermisosController;

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\TablasModulosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\SQLCreatorController;
use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\FormCreatorController;
use App\Http\Controllers\LigasFormulariosController;
use App\Http\Controllers\InformesController;
use App\Http\Controllers\RespaldosController;
use App\Http\Controllers\InstaladorController;
use App\Http\Controllers\InstaladorJsonController;
use App\Http\Controllers\ArtificialIntelligenceController;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\Select2Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard_inicio', [DashboardsController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');



//---> Visualización y procesamiento de formularios publicos
Route::get("/formulario_publico/{slug}", [LigasFormulariosController::class, "formularioPublico"])->name("formulario.publico");
Route::post('/ruta_publica', [FormCreatorController::class, "rutaPublica"])->name("ruta_publica");

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', [DashboardsController::class, 'index']);



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //-------> Para manejo de usuario
    Route::get('/usuarios/programar_roles', [UsuariosController::class, 'vistaModificarRoles']);
    Route::post('/usuarios/agregar_rol', [UsuariosController::class, 'agregarRoleUsuario'])->name('agregar.rol.usuario');

    Route::get('/perfil', [UsuariosController::class, 'perfil']);
    Route::post('/usuarios/cambio_avatar', [UsuariosController::class, 'updateAvatar']);
    Route::resource('/usuarios', UsuariosController::class);
    //-------> Para manejo de usuario

    Route::get('/test_email', [EmailController::class, "testView"]);
    Route::post('/emails/sendEmail', [EmailController::class, "testSend"]);


    Route::post("/select2/usuarios_roles", [Select2Controller::class, 'usuariosYRoles']);
    Route::post("/select2/usuarios", [Select2Controller::class, 'usuarios']);
    Route::post('/select2/descuentos', [Select2Controller::class, 'dropdownDescuentos']);
    Route::post('/select2/maestros', [Select2Controller::class, 'maestros']);
    Route::post('/select2/sistemas', [Select2Controller::class, 'sistemas']);
    Route::post('/select2/queries', [Select2Controller::class, 'queries']);
    Route::post('/select2/tablas_modulos', [Select2Controller::class, 'tablasModulos']);
    Route::post('/select2/formularios', [Select2Controller::class, 'formularios']);



    Route::resource('/roles', RolesController::class);
    Route::resource('/permisos', PermisosController::class);
    Route::resource('/users', UsuariosController::class);
    Route::resource('/tablas_modulos', TablasModulosController::class);
    Route::resource('/reportes', ReportesController::class);
    Route::resource('/sql_creator', SQLCreatorController::class);
    Route::resource('/dashboard', DashboardsController::class);
    Route::resource('/archivos', ArchivosController::class);
    Route::resource('/form_creator', FormCreatorController::class);
    Route::resource('/ligas_formulario', LigasFormulariosController::class);
    Route::resource('/informes', InformesController::class);
    Route::resource('/respaldos', RespaldosController::class);

    //-----> Respaldos
    Route::post('/respaldo-generar', [RespaldosController::class, 'generar'])->name('respaldo.generar');
    //-----> Instalador
    Route::get('/instalador/cargar-sql', [InstaladorController::class, 'formularioSQL'])->name('instalador.sql.form');


    Route::get('/instalador/cargar-sql', [InstaladorController::class, 'formularioSQL'])->name('instalador.sql.form');
    Route::post('/instalador/cargar-sql', [InstaladorController::class, 'importarSQL'])->name('instalador.sql.importar');
    Route::get('/instalador/json', [InstaladorJsonController::class, 'formulario'])->name('instalador.json.formulario');
    Route::post('/instalador/json', [InstaladorJsonController::class, 'guardar'])->name('instalador.json.importar');





    // ---->Sistema cobros: Ajax html
    Route::post('/ajax/tabla_cobros', [AjaxHtmlController::class, 'tablaCobros']);
    Route::post('/ajax/rolesUsuario', [AjaxHtmlController::class, 'listaRolesUsuario']);
    Route::post("/ajax/sistemas_ac_escuela", [AjaxHtmlController::class, 'sistemasAcademicosEscuela']);
    Route::post('/ajax/preview_cuenta', [AjaxHtmlController::class, 'previewCuenta']);
    Route::post('/ajax/columnas_tabla', [AjaxHtmlController::class, 'columnasTablaModulo']);
    Route::post('/ajax/dropdownJoins', [AjaxHtmlController::class, 'dropdownJoins']);
    Route::post('/ajax/dropdownWhereOperators', [AjaxHtmlController::class, 'dropdownWhereOperators']);
    Route::post('/ajax/whereValueInput', [AjaxHtmlController::class, 'whereValueInput']); // Para la elaboración de reportes
    Route::post('/ajax/selectFuncionFechas', [AjaxHtmlController::class, 'selectFuncionFechas']);
    Route::post('/ajax/dropdownFuncionesAgregadas', [AjaxHtmlController::class, 'dropdownFuncionesAgregadas']);
    Route::post('/ajax/dropdownWhereLogicOperators', [AjaxHtmlController::class, 'dropdownWhereLogicOperators']);
    Route::post('/ajax/formCreatorInputSelection', [AjaxHtmlController::class, 'formCreatorInputSelection']);
    Route::post('/ajax/formCreatorDropdownInputConfig', [AjaxHtmlController::class, 'formCreatorDropdownInputConfig']);
    Route::post('/ajax/formCreatorSelect2InputConfig', [AjaxHtmlController::class, 'formCreatorSelect2InputConfig']);
    Route::post('/ajax/formCreatorRadioConfig', [AjaxHtmlController::class, 'formCreatorRadioConfig']);
    Route::post('/ajax/formCreatorDateConfig', [AjaxHtmlController::class, 'formCreatorDateConfig']);
    Route::post('/ajax/formCreatorTimeConfig', [AjaxHtmlController::class, 'formCreatorTimeConfig']);
    Route::post('/ajax/formCreatorDatetimeConfig', [AjaxHtmlController::class, 'formCreatorDatetimeConfig']);
    Route::post('/ajax/formCreatorTextConfig', [AjaxHtmlController::class, 'formCreatorTextConfig']);
    Route::post('/ajax/formCreatorEmailConfig', [AjaxHtmlController::class, 'formCreatorEmailConfig']);
    Route::post('/ajax/formCreatorFileConfig', [AjaxHtmlController::class, 'formCreatorFileConfig']);
    Route::post('/ajax/formCreatorHiddenInputConfig', [AjaxHtmlController::class, 'formCreatorHiddenInputConfig']);
    Route::post('/ajax/formCreatorCheckboxConfig', [AjaxHtmlController::class, 'formCreatorCheckboxConfig']);
    Route::post('/ajax/formCreatorMultiItemConfig', [AjaxHtmlController::class, 'formCreatorMultiItemConfig']);
    Route::post('/ajax/dropdown_graficas', [AjaxHtmlController::class, 'dropdownGraficas']);
    Route::post('/ajax/ejemplo_graficas', [AjaxHtmlController::class, 'ejemploGraficas']);
    Route::post('/ajax/data_graficas', [AjaxHtmlController::class, 'dataGraficas']);
    Route::post('/ajax/query_graph', [AjaxHtmlController::class, 'queryConfigurationGraph']);
    Route::post('/ajax/campo_select2', [AjaxHtmlController::class, 'campoSelect2']);
    Route::post('/ajax/render_inputs_edit', [AjaxHtmlController::class, 'renderEditInputsFormCreator'])->name("ajax.render_inputs_edit");
    Route::post('/ajax/renderInputs', [AjaxHtmlController::class, 'renderInputsTabla']);
    Route::post('/ajax/form_creator_buscar_sola_columna', [AjaxHtmlController::class, 'tablasModulosBuscarEnColumna']);
    Route::post('/ajax/form_creator_tipos_datos', [AjaxHtmlController::class, 'tiposDatosDropdown'])->name("ajax.tipos_datos");
    Route::post('/ajax/render_elemento_config', [AjaxHtmlController::class, 'informesRenderElementoConfig'])->name("ajax.render_elementos");
    Route::post('/ajax/configElementData', [AjaxHtmlController::class, 'configElementDataInformes'])->name("ajax.config_element_data");
    Route::post('/ajax/zonaJoinInformes', [AjaxHtmlController::class, 'zonaJoinInformes'])->name("ajax.zona_join");
    Route::post('/ajax/whereSimple', [AjaxHtmlController::class, 'condicionWhereSimple'])->name("ajax.where_simple");
    Route::post('/ajax/whereGrupal', [AjaxHtmlController::class, 'condicionWhereGrupal'])->name("ajax.where_grupal");
    Route::post('/ajax/funcion_agregada', [AjaxHtmlController::class, 'camposFuncionAgregada'])->name("ajax.funcion_agregada");
    Route::post('/ajax/eliminar_seccion_informes', [AjaxHtmlController::class, 'eliminarSeccionInformes'])->name("ajax.eliminar_seccion_informe");
    Route::post('/ajax/caja_validacion', [AjaxHtmlController::class, 'cajaValidacion'])->name("ajax.caja_validacion");
    Route::post('/ajax/tipo_dato_regla_validacion', [AjaxHtmlController::class, 'tipoDatoReglaValidacion'])->name("ajax.tipo_dato_regla_validacion");





    //-------> Para sistema de cobros

    // -----> Agregar Múltiples Inputs de manera dinámica
    Route::post('/add_multiple/{inputs}', [AjaxAddMultipleInputsController::class, 'validate']);
    Route::get('/snippet_test', [AjaxAddMultipleInputsController::class, 'test']); //---> Hay que cambiar el controlador


    Route::post('/eliminar/rol', [UsuariosController::class, 'removeRol']);



    // Correos personalizados
    Route::post('/enviar_bienvenida', [EmailController::class, 'bienvenida']);

    Route::get('/crear_archivo', [TablasModulosController::class, 'crearArchivo'])->name('crear.archivo'); // PASO A
    Route::post('/subir_archivo', [TablasModulosController::class, 'insertarArchivo'])->name('insertar.archivo'); // PASO A -> PASO B
    Route::post('/cargar_tabla', [TablasModulosController::class, 'cargarDatosTabla'])->name('cargar.datos'); // Para cargas con excel cuando existe la tabla en db
    Route::get('/ver_cargar_tabla/{id_tabla?}', [TablasModulosController::class, 'verCargarDatosTabla'])->name('ver_cargar.datos'); // PASO A -> B -> C
    Route::get('/definir_columnas', [TablasModulosController::class, 'definirColumnas'])->name('tablas_modulos.definir_columnas'); // PASO A -> B -> D
    Route::post('/subir_columnas', [TablasModulosController::class, 'insertarColumnas'])->name('insertar.columnas'); // PASO A -> B -> D -> E


    Route::get('/contenido/{archivo}', [TablasModulosController::class, 'testDocument']);
    Route::get('/descargar_tabla/{id_tabla}', [TablasModulosController::class, 'descargarCSV'])->name('descargar_tabla');


    //Artificial intelligence module
    Route::get('/ai/conf/iniciar', [ArtificialIntelligenceController::class, 'iniciarTablasJson'])->name('ai.configuracion.iniciar');
    Route::post('/ai/conf/guardar', [ArtificialIntelligenceController::class, 'guardarTablasJson'])->name('ai.configuracion.guardar');


    // Carga de archivos
    Route::get('/descargar_archivo/{id}', [ArchivosController::class, "descargar"])->name("descargar_archivo");
    Route::get('/descargar_configuracion/{tipo}/{nombreArchivo}', [ArchivosController::class, "descargarConfiguracion"])->name("descargar.configuracion");
    // Edición de archivos
    Route::get('/editar_archivo/{tipo}/{nombreArchivo}', [ArchivosController::class, 'vistaModificarArchivo'])
        ->where('tipo', 'formulario|query|dashboard|informe') // validación por tipo
        ->name('vista.editar.archivo');
    Route::post('/actualizar_archivo', [ArchivosController::class, 'modificarArchivo'])->name("actualizar.archivo");
    Route::post('/carga_configuracion', [ArchivosController::class, 'cargaConfiguracion'])->name('carga.configuracion');
    Route::get('/ver_cargar_configuracion', [ArchivosController::class, 'verCargarConfiguracion'])->name("ver.cargar.configuracion");

    //Ligas de formulario
    Route::post('/modal_crear_tabla', [FormCreatorController::class, 'procesarTablaModal'])->name("modal_crear_tabla");


    //Informes
    Route::post('/actualizar_seccion_informe', [InformesController::class, 'actualizarSeccionInforme'])->name("actualizar.seccion");
    Route::post('/autoguardado/creador_informes', [InformesController::class, 'autoguardadoParcial'])->name("autoguardado_seccion.creador_informe");



    // Creador de formularios FormCreator
    Route::get('/generar_qr/{id_liga?}', [FormCreatorController::class, "generarQR"])->name("generar.qr");
    Route::post('/previsualizar_input', [FormCreatorController::class, "cargarEjemplo"])->name("previsualizacion");
    Route::post('/select2/ejemplo_select2', [FormCreatorController::class, "respuestaSelect2V2"])->name("ejemplo_select2");
    Route::post('/action_form_creator', [FormCreatorController::class, "actionFormCreator"])->name("action_form_creator");
    Route::post('/ruta_automatica', [FormCreatorController::class, "rutaAutomatica"])->name("ruta_automatica");
    Route::get('/editar_registro/{tabla}/{id}', [FormCreatorController::class, "editarRegistro"])->name("editar.registro");
    Route::post('/modificar_registro/{tabla}/{id}', [FormCreatorController::class, "modificarRegistro"])->name("modificar.registro");

    // Loader
    Route::post('/loader', [FormCreatorController::class, "loader"]);
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified');



// Authentication routes with email verification enabled
Auth::routes(['verify' => true]);
require __DIR__ . '/auth.php';
