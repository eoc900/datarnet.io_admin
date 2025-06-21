<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\TablasController;
use App\Http\Controllers\EscuelasController;
use App\Http\Controllers\SistemasAcademicosController;
use App\Http\Controllers\ConceptosCobrosController;
use App\Http\Controllers\CostoConceptoController;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\AjaxHtmlController;
use App\Http\Controllers\AjaxAddMultipleInputsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermisosController;

use App\Http\Controllers\CuentasController;
use App\Http\Controllers\CobrosController;
use App\Http\Controllers\CargosController;
use App\Http\Controllers\CategoriaCobroController;

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\MaestrosController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\TituloAcademMaestroController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\DescuentosController;
use App\Http\Controllers\PromocionesController;
use App\Http\Controllers\PromocionesAplicadasController;
use App\Http\Controllers\TiposCorreosAlumnosController;
use App\Http\Controllers\TiposContactosController;
use App\Http\Controllers\ContactosAlumnosController;
use App\Http\Controllers\TiposCorreosContactosAlumnosController;
use App\Http\Controllers\CorreosAsociadosController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\InvitacionesUsuariosController;
use App\Http\Controllers\CargaMateriasController;
use App\Http\Controllers\FileExcelCsvReadController;
use App\Http\Controllers\TiposCorreosMaestrosController;
use App\Http\Controllers\HorariosMaestrosController;
use App\Http\Controllers\CargasArchivosController;
use App\Http\Controllers\DirectoriosRootController;
use App\Http\Controllers\CarpetasUsuariosController;
use App\Http\Controllers\SalonesController;
use App\Http\Controllers\CurriculasController;
use App\Http\Controllers\MateriasRegistradasAlumnosController;
use App\Http\Controllers\TablasModulosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\SQLCreatorController;
use App\Http\Controllers\CertificadosController;
use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\FormCreatorController;
use App\Http\Controllers\TitulosGeneradosController;
use App\Http\Controllers\LigasFormulariosController;
use App\Http\Controllers\InformesController;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\MailGunController;

use App\Http\Controllers\ProyectosController;

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PdfController;

use App\Http\Controllers\TiposDocumentosController;
use App\Http\Controllers\Select2Controller;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\HTMLTablesController;
use Illuminate\Support\Facades\Route;

//Route::post('/register', [RegisterController::class, 'register']);
Route::post('/webhooks/mailgun',[MailGunController::class,'storage']);



Route::get('/RegisterMasterUser',[UsuariosController::class,'registerMasterView']); 
Route::post('/usuarios/registerMain',[UsuariosController::class,'receiveMaster']);

Route::get('/',[LandingPageController::class,'index']);
Route::resource('/blog', BlogController::class);

Route::get('/dashboard_inicio', [DashboardsController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');


// ----> activación de usuarios
Route::get('/vincular_usuario/{codigo}',[InvitacionesUsuariosController::class,'vincularUsuario']);
Route::post('/vincular_usuario/registrar',[InvitacionesUsuariosController::class,'registrarUsuario'])->name('invitaciones_usuarios.registrar_usuario');

// ---> prueba de descarga de archivo zip
Route::get('/descargar_zip', [TitulosGeneradosController::class, 'descargarZipDesdeBase64']);
Route::get('/descargar-zip-temporal/{filename}', [TitulosGeneradosController::class, 'descargarZipTemporal'])->name('descargar.zip.temporal');

//---> Visualización y procesamiento de formularios publicos
Route::get("/formulario_publico/{slug}",[LigasFormulariosController::class,"formularioPublico"])->name("formulario.publico");
Route::post('/ruta_publica',[FormCreatorController::class,"rutaPublica"])->name("ruta_publica");

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/admin',[DashboardsController::class,'index']);

    Route::get('/test_mailgun', [TestsController::class, 'mailGun']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//-------> Para manejo de usuario
    Route::get('/usuarios/programar_roles',[UsuariosController::class,'vistaModificarRoles']);
    Route::post('/usuarios/agregar_rol',[UsuariosController::class,'agregarRoleUsuario'])->name('agregar.rol.usuario');

    Route::get('/perfil',[UsuariosController::class,'perfil']);
    Route::post('/usuarios/cambio_avatar',[UsuariosController::class,'updateAvatar']);
    Route::resource('/usuarios',UsuariosController::class);
//-------> Para manejo de usuario

     Route::get('/test_email',[EmailController::class,"testView"]);
     Route::post('/emails/sendEmail',[EmailController::class,"testSend"]);

    Route::get("/calendario",[CalendarioController::class,'index']);
    Route::resource('/tareas',TareasController::class);
    Route::resource('/maestros', MaestrosController::class);
    
    Route::resource('/documentos',DocumentoController::class);
    Route::resource('/tipos_documentos',TiposDocumentosController::class);

    //-------> Para sistema de cobros
    Route::post('/alta/rol_permisos',[FormsController::class,'store'])->name('insert.rol_permisos');
    Route::post('/alta/rol_usuario',[FormsController::class,'store'])->name('insert.rol_usuario');
    Route::post('/alta/categoria_cobros',[FormsController::class,'store'])->name('insert.categoria_cobros');

    Route::get('/tabla/{nombre?}',[TablasController::class,'index'])->name('tabla');
    Route::post("/select2/conceptos",[Select2Controller::class,'conceptos_cobros']);
    Route::post("/select2/alumnos",[Select2Controller::class,'alumnos_con_sistema']);
    Route::post("/select2/costos_conceptos",[Select2Controller::class,'costos_conceptos']);
    Route::post("/select2/cuentas_alumno",[Select2Controller::class,'cuentas_alumno']);
    Route::post("/select2/usuarios_roles",[Select2Controller::class,'usuariosYRoles']);
    Route::post("/select2/usuarios",[Select2Controller::class,'usuarios']);
    Route::post('/select2/descuentos',[Select2Controller::class,'dropdownDescuentos']);
    Route::post('/select2/maestros',[Select2Controller::class,'maestros']);
    Route::post('/select2/sistemas',[Select2Controller::class,'sistemas']);
    Route::post('/select2/queries',[Select2Controller::class,'queries']);
    Route::post('/select2/tablas_modulos',[Select2Controller::class,'tablasModulos']);
    Route::post('/select2/formularios',[Select2Controller::class,'formularios']);
    

    
   
    Route::resource('/sistemas_academicos',SistemasAcademicosController::class);
    Route::resource('/alumnos',AlumnosController::class);
    Route::resource('/carga_materias',CargaMateriasController::class);
    Route::resource('/concepto_cobro',ConceptosCobrosController::class);
    Route::resource('/costo_concepto',CostoConceptoController::class);
    Route::resource('/correos_asociados',CorreosAsociadosController::class);
    Route::resource('/cuentas',CuentasController::class);
    Route::resource('/cobros',CobrosController::class);
    Route::resource('/roles',RolesController::class);
    Route::resource('/permisos',PermisosController::class);
    Route::resource('/users',UsuariosController::class);
    Route::resource('/categoria_cobros',CategoriaCobroController::class);
    Route::resource('/pagos_realizados',PagosController::class);
    Route::resource('/pagos_pendientes',CargosController::class);
    Route::resource('/tipos_correos',TiposCorreosAlumnosController::class);
    Route::resource('/tipos_contactos',TiposContactosController::class);
    Route::resource('/descuentos',DescuentosController::class);
    Route::resource('/promociones',PromocionesController::class);
    Route::resource('/promociones_aplicadas',PromocionesAplicadasController::class);
    Route::resource('/contactos_alumnos',ContactosAlumnosController::class);
    Route::resource('/tipos_correos_contactos',TiposCorreosContactosAlumnosController::class);
    Route::resource('/inscripciones',InscripcionesController::class);
    Route::resource('/materias',MateriasController::class);
    Route::resource('/invitaciones_usuarios',InvitacionesUsuariosController::class);
    Route::resource('/tipos_correos_maestros',TiposCorreosMaestrosController::class);
    Route::resource('/horarios_maestros',HorariosMaestrosController::class);
    Route::resource('/archivos',CargasArchivosController::class);
    Route::resource('/directorios_root',DirectoriosRootController::class);
    Route::resource('/carpetas_usuarios',CarpetasUsuariosController::class);
    Route::resource('/salones',SalonesController::class);
    Route::resource('/curriculas',CurriculasController::class);
    Route::resource('/materias_registradas_alumnos',MateriasRegistradasAlumnosController::class);
    Route::resource('/tablas_modulos',TablasModulosController::class);
    Route::resource('/reportes',ReportesController::class);
    Route::resource('/sql_creator',SQLCreatorController::class);
    Route::resource('/dashboard',DashboardsController::class);
    Route::resource('/archivos',ArchivosController::class);
    Route::resource('/form_creator',FormCreatorController::class);
    Route::resource('/titulos_generados',TitulosGeneradosController::class);
    Route::resource('/ligas_formulario',LigasFormulariosController::class);
    Route::resource('/informes',InformesController::class);


    // ----> Relación materias y maestros, y horario
    Route::get('/maestros_materias/definir_materias/{maestro?}',[MaestrosController::class,"materiasQuePuedeDar"])->name("maestros_materias.definir_materias");
    Route::post('/maestros_materias/guardar_materias_definidas',[MaestrosController::class,"guardarMateriasDefinidas"])->name("maestros_materias.guardar_materias_definidas");

    // ----> Asociar materias a sistemas academicos
    Route::get('/curricula_sistema/definir_materias/{id_sistema?}',[CurriculasController::class,"asociarMaterias"])->name("curricula_sistema.definir_materias");

    // ----> Asociar o registrar materias al alumno; aunque se haya inscrito a un sistema las materias pueden revalidarse
    Route::get('/curricula_alumnos/definir_materias/{id_alumno?}',[MateriasRegistradasAlumnosController::class,'definirRegistroMaterias'])->name('definir_materias_alumno');


    // ---->Sistema cobros: Ajax html
    Route::post('/ajax/tabla_cobros',[AjaxHtmlController::class,'tablaCobros']);
    Route::post('/ajax/rolesUsuario',[AjaxHtmlController::class,'listaRolesUsuario']);
    Route::post("/ajax/sistemas_ac_escuela",[AjaxHtmlController::class,'sistemasAcademicosEscuela']);
    Route::post('/ajax/preview_cuenta',[AjaxHtmlController::class,'previewCuenta']);
    Route::post('/ajax/columnas_tabla',[AjaxHtmlController::class,'columnasTablaModulo']);
    Route::post('/ajax/dropdownJoins',[AjaxHtmlController::class,'dropdownJoins']);
    Route::post('/ajax/dropdownWhereOperators',[AjaxHtmlController::class,'dropdownWhereOperators']);
    Route::post('/ajax/whereValueInput',[AjaxHtmlController::class,'whereValueInput']); // Para la elaboración de reportes
    Route::post('/ajax/selectFuncionFechas',[AjaxHtmlController::class,'selectFuncionFechas']);
    Route::post('/ajax/dropdownFuncionesAgregadas',[AjaxHtmlController::class,'dropdownFuncionesAgregadas']);
    Route::post('/ajax/dropdownWhereLogicOperators',[AjaxHtmlController::class,'dropdownWhereLogicOperators']);
    Route::post('/ajax/formCreatorInputSelection',[AjaxHtmlController::class,'formCreatorInputSelection']);
    Route::post('/ajax/formCreatorDropdownInputConfig',[AjaxHtmlController::class,'formCreatorDropdownInputConfig']);
    Route::post('/ajax/formCreatorSelect2InputConfig',[AjaxHtmlController::class,'formCreatorSelect2InputConfig']);
    Route::post('/ajax/formCreatorRadioConfig',[AjaxHtmlController::class,'formCreatorRadioConfig']);
    Route::post('/ajax/formCreatorDateConfig',[AjaxHtmlController::class,'formCreatorDateConfig']);
    Route::post('/ajax/formCreatorDatetimeConfig',[AjaxHtmlController::class,'formCreatorDatetimeConfig']);
    Route::post('/ajax/formCreatorTextConfig',[AjaxHtmlController::class,'formCreatorTextConfig']);
    Route::post('/ajax/formCreatorEmailConfig',[AjaxHtmlController::class,'formCreatorEmailConfig']);
    Route::post('/ajax/formCreatorFileConfig',[AjaxHtmlController::class,'formCreatorFileConfig']);
    Route::post('/ajax/formCreatorHiddenInputConfig',[AjaxHtmlController::class,'formCreatorHiddenInputConfig']);
    Route::post('/ajax/formCreatorCheckboxConfig',[AjaxHtmlController::class,'formCreatorCheckboxConfig']);
    Route::post('/ajax/formCreatorMultiItemConfig',[AjaxHtmlController::class,'formCreatorMultiItemConfig']);
    Route::post('/ajax/dropdown_graficas',[AjaxHtmlController::class,'dropdownGraficas']);
    Route::post('/ajax/ejemplo_graficas',[AjaxHtmlController::class,'ejemploGraficas']);
    Route::post('/ajax/data_graficas',[AjaxHtmlController::class,'dataGraficas']);
    Route::post('/ajax/query_graph',[AjaxHtmlController::class,'queryConfigurationGraph']);
    Route::post('/ajax/campo_select2',[AjaxHtmlController::class,'campoSelect2']);
    Route::post('/ajax/render_inputs_edit',[AjaxHtmlController::class,'renderEditInputsFormCreator'])->name("ajax.render_inputs_edit");
    Route::post('/ajax/renderInputs',[AjaxHtmlController::class,'renderInputsTabla']);
    Route::post('/ajax/form_creator_buscar_sola_columna',[AjaxHtmlController::class,'tablasModulosBuscarEnColumna']);
    Route::post('/ajax/form_creator_tipos_datos',[AjaxHtmlController::class,'tiposDatosDropdown'])->name("ajax.tipos_datos");
    Route::post('/ajax/render_elemento_config',[AjaxHtmlController::class,'informesRenderElementoConfig'])->name("ajax.render_elementos");
    Route::post('/ajax/configElementData',[AjaxHtmlController::class,'configElementDataInformes'])->name("ajax.config_element_data");
    Route::post('/ajax/zonaJoinInformes',[AjaxHtmlController::class,'zonaJoinInformes'])->name("ajax.zona_join");
    Route::post('/ajax/whereSimple',[AjaxHtmlController::class,'condicionWhereSimple'])->name("ajax.where_simple");
    Route::post('/ajax/whereGrupal',[AjaxHtmlController::class,'condicionWhereGrupal'])->name("ajax.where_grupal");
    Route::post('/ajax/funcion_agregada',[AjaxHtmlController::class,'camposFuncionAgregada'])->name("ajax.funcion_agregada");
    Route::post('/ajax/caja_validacion',[AjaxHtmlController::class,'cajaValidacion'])->name("ajax.caja_validacion");
    Route::post('/ajax/tipo_dato_regla_validacion',[AjaxHtmlController::class,'tipoDatoReglaValidacion'])->name("ajax.tipo_dato_regla_validacion");
 
    
 
    

    //-------> Para sistema de cobros

    // -----> Agregar Múltiples Inputs de manera dinámica
    Route::post('/add_multiple/{inputs}',[AjaxAddMultipleInputsController::class,'validate']);
    Route::get('/snippet_test',[AjaxAddMultipleInputsController::class,'test']); //---> Hay que cambiar el controlador


    Route::post('/eliminar/rol',[UsuariosController::class,'removeRol']);

    // Cuentas del alumno
    Route::get('/download/info',[PdfController::class,'downloadInfo']);
    Route::get('/ver',[PdfController::class,'verPDF']);   
    Route::get('/ver_cuenta/{id_cuenta?}',[PdfController::class,'vistaGenerarCuenta']);   
    Route::post('/download/cuenta',[PdfController::class,'downloadCuenta']);   
    Route::post('/aplicar_descuento/store',[DescuentosController::class,'storeAplicarDescuento'])->name('aplicar_descuento.store');
    Route::get('/aplicar_descuento/create',[DescuentosController::class,'aplicarDescuentoVista'])->name('aplicar_descuento.create');
    Route::post('/download/envio_cuenta',[PdfController::class,'enviarCuentaCorreo']);
    Route::get('/post_create/alumnos/{id?}',[AlumnosController::class,'postCreate'])->name('post_create.alumnos');
    
    // Correos personalizados
    Route::post('/enviar_bienvenida',[EmailController::class,'bienvenida']);

    // Excel
    Route::post('/excel/read', [FileExcelCsvReadController::class,'read'])->name('excel.read');
    Route::get('/cargar_calificaciones',[FileExcelCsvReadController::class,'cargarCalificaciones'])->name('excel.cargar_calificaciones');
    Route::get('/crear_archivo', [TablasModulosController::class, 'crearArchivo'])->name('crear.archivo');
    Route::post('/subir_archivo', [TablasModulosController::class, 'insertarArchivo'])->name('insertar.archivo');
    Route::post('/cargar_tabla', [TablasModulosController::class, 'cargarDatosTabla'])->name('cargar.datos');
    Route::get('/ver_cargar_tabla/{id_tabla?}', [TablasModulosController::class, 'verCargarDatosTabla'])->name('ver_cargar.datos');
    Route::get('/definir_columnas',[TablasModulosController::class,'definirColumnas'])->name('tablas_modulos.definir_columnas');
    Route::post('/subir_columnas', [TablasModulosController::class, 'insertarColumnas'])->name('insertar.columnas');
    Route::get('/contenido/{archivo}', [TablasModulosController::class, 'testDocument']);
    Route::get('/descargar_tabla/{id_tabla}', [TablasModulosController::class, 'descargarCSV'])->name('descargar_tabla');

    // Gantt
    Route::get('/gantt',[ProyectosController::class,'gantt']);

    // Disponibilidad horarios
    Route::get('/buscar_disponibilidad',[HorariosMaestrosController::class,'buscarMaestro'])->name("disponibilidad.maestro");
    Route::get('/disponibilidad/{maestro?}',[HorariosMaestrosController::class,'disponibilidad']);
    Route::post('/asignar_horario_disponible',[HorariosMaestrosController::class,'storeDisponibilidad'])->name("asignar_disponibilidad");
    Route::post('/eliminar_horario_disponible',[HorariosMaestrosController::class,'eliminarHoraDisponible'])->name("eliminar_hora_disponible");


    // Carga de archivos
    Route::post('/listar_directorios',[DirectoriosRootController::class,'getDirectorios']);
    Route::get('/cargar_archivo',[CargasArchivosController::class,'cargarDocumentos']);
    Route::post('/cargar',[CargasArchivosController::class,'cargar'])->name("cargar");
    Route::get('/directorios',[DirectoriosRootController::class,'verTodos']);
    Route::get('/ver_contenido/{id_directorio?}/{ruta?}',[CarpetasUsuariosController::class,'verContenido'])->name('ver_contenido')->where('ruta', '.*');
    Route::get('/descargar_archivo/{id}',[ArchivosController::class,"descargar"])->name("descargar_archivo");
    Route::get('/descargar_configuracion/{tipo}/{nombreArchivo}',[ArchivosController::class,"descargarConfiguracion"])->name("descargar.configuracion");
    // Edición de archivos
    Route::get('/editar_archivo/{tipo}/{nombreArchivo}', [ArchivosController::class, 'vistaModificarArchivo'])
    ->where('tipo', 'formulario|query|dashboard') // validación por tipo
    ->name('vista.editar.archivo');
    Route::post('/actualizar_archivo',[ArchivosController::class,'modificarArchivo'])->name("actualizar.archivo");
    Route::post('/carga_configuracion', [ArchivosController::class, 'cargaConfiguracion'])->name('carga.configuracion');
    Route::get('/ver_cargar_configuracion',[ArchivosController::class,'verCargarConfiguracion'])->name("ver.cargar.configuracion");

    //Ligas de formulario
    Route::post('/modal_crear_tabla',[FormCreatorController::class,'procesarTablaModal'])->name("modal_crear_tabla");

   
    //Informes
    Route::post('/actualizar_seccion_informe',[InformesController::class,'actualizarSeccionInforme'])->name("actualizar.seccion");
    Route::post('/autoguardado/creador_informes',[InformesController::class,'autoguardadoParcial'])->name("autoguardado_seccion.creador_informe");


    // Generación y pruebas de certificados
    Route::get("/reformular_xmls",[TitulosGeneradosController::class,"reformularTitulosParaXML"]);
    Route::get("/ejemplo_certificados",[CertificadosController::class,"ejemploCertificados"]);
    Route::get("/prueba_soap_xml/{id}",[TitulosGeneradosController::class,"pruebaSOAPXml"])->name("prueba_soap");
    Route::get("/consultar_lote/{id_titulo}",[TitulosGeneradosController::class,"consultarLote"])->name("consultar_lote");
    Route::get("/descargar_lote/{id_titulo}",[TitulosGeneradosController::class,"descargarLote"])->name("descargar_lote");
    Route::get("/ver_xml/{id_titulo}",[TitulosGeneradosController::class,"verXml"])->name("ver_xml");
    Route::post("/generar_titulo",[TitulosGeneradosController::class,"actionGenerarTitulo"])->name("generar_titulo");
    Route::post("/generar_zip",[TitulosGeneradosController::class,"generarZipDocumentos"])->name("generar_zip");


    // Probar conexión wsdl
    Route::get("/probar_conexion",[TitulosGeneradosController::class,"probarConexion"]);

    // Creador de formularios FormCreator
    Route::get('/generar_qr/{id_liga?}',[FormCreatorController::class,"generarQR"])->name("generar.qr");
    Route::post('/previsualizar_input',[FormCreatorController::class,"cargarEjemplo"])->name("previsualizacion");
    Route::post('/select2/ejemplo_select2',[FormCreatorController::class,"respuestaSelect2V2"])->name("ejemplo_select2");
    Route::post('/action_form_creator',[FormCreatorController::class,"actionFormCreator"])->name("action_form_creator");
    Route::post('/ruta_automatica',[FormCreatorController::class,"rutaAutomatica"])->name("ruta_automatica");
    Route::get('/editar_registro/{tabla}/{id}',[FormCreatorController::class,"editarRegistro"])->name("editar.registro");
    Route::post('/modificar_registro/{tabla}/{id}',[FormCreatorController::class,"modificarRegistro"])->name("modificar.registro");

    // Loader
    Route::post('/loader', [FormCreatorController::class,"loader"]);
    
});

Route::get('/not-found',[App\Http\Controllers\CommonsController::class, 'notFound'])->name("not_found");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('verified');



// Authentication routes with email verification enabled
Auth::routes(['verify' => true]);
require __DIR__.'/auth.php';


