<!--start sidebar-->
   <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div class="logo-icon">
        <img src="{{ asset('dashboard_resources/assets/images/3-logos.png'); }}" class="logo-img" alt="">
      </div>
      <div class="logo-name flex-grow-1">
       <p class="fs-15 text-center pt-3">Centro de Estudios</p>
      </div>
      <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
          <li class="sidebar-item sidebar-principal">
            <a href="/perfil" aria-expanded="true"><i class="material-icons-outlined">person</i><span class="sidebar-text">Perfil</span></a>
          </li>
          <li class="sidebar-item sidebar-principal">
          <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="/dashboard"><i class="material-icons-outlined">dashboard</i>
            <span class="sidebar-text">Inicio</span>
          </a>
          </li>

          @if (!Auth::user()->hasRole('Guest') )
          
          @if(auth()->user()->hasAnyRole(['Admin'])) 
          <li>
              <a class="has-arrow" href="javascript:;" aria-expanded="true">
                  <div class="font-20">	<i class="lni lni-consulting"></i>
							    </div>
                  <div class="menu-title">General</div>
              </a>
              <ul class="mm-collapse" style="">
                @if(auth()->user()->can('Agregar escuelas'))
                  <li>
                    <a href="/formulario/alta_escuelas" class="fs-6"> <i class="fadeIn animated bx bx-building-house"></i>Agregar Escuela</a>
                  </li> 
                @endif
                @if(auth()->user()->can('Agregar sistema académico'))
                  <li>
                    <a href="/sistemas_academicos/create" class="fs-6"> <i class="fadeIn animated bx bx-book-alt"></i>Agregar Sistemas</a>
                  </li>
                @endif
                @if(auth()->user()->can('Agregar materias'))
                <li>
                  <a href="/materias/create" class="fs-6"> <i class="fadeIn animated bx bx-book-alt"></i>Agregar Materias</a>
                </li>  
                @endif
                @if(auth()->user()->can('Generar currícula'))
                <li>
                  <a href="/curricula_sistema/definir_materias" class="fs-6"> <i class="fadeIn animated bx bx-book-alt"></i>Currícula</a>
                </li>  
                @endif
                @if(auth()->user()->can('Agregar contactos de alumnos'))
                <li>
                  <a href="/contactos_alumnos/create" class="fs-6"> <i class="fadeIn animated bx bx-user-plus"></i>Contactos</a>
                </li>
                @endif
                @if(auth()->user()->can('Agregar promociones'))
                <li><a href="/promociones/create" class="fs-20"><i class="fadeIn animated bx bx-id-card"></i>Agregar promoción</a>
                </li>
                @endif
                @if(auth()->user()->can('Ver escuelas')) 
                <li><a href="/tabla/escuelas" class="fs-20"><i class="fadeIn animated bx bx-id-card"></i>Ver Escuelas</a>
                </li>
                @endif
                @if(auth()->user()->can('Ver sistema académico')) 
                <li><a href="/sistemas_academicos" class="fs-20"><i class="fadeIn animated bx bx-id-card"></i>Ver Sistemas</a>
                @endif
                @if(auth()->user()->can('Ver materias')) 
                <li><a href="/materias" class="fs-20"><i class="fadeIn animated bx bx-id-card"></i>Ver Materias</a>
                </li>
                @endif
                @if(auth()->user()->can('Ver promociones')) 
                <li><a href="/tabla/promociones" class="fs-20"><i class="fadeIn animated bx bx-id-card"></i>Ver promociones</a>
                </li>
                @endif
               
              </ul>
          </li>
          @endif


        
          @if(auth()->user()->hasAnyRole(['Admin'])) 
          <li>
          <a class="has-arrow" href="javascript:;" aria-expanded="true">
              <div class="font-20">	<i class="lni lni-revenue"></i>
							</div>
            <div class="menu-title">Tesorería</div>
          </a>
          <ul class="mm-collapse">
            <li class=""><a class="has-arrow" href="javascript:;" aria-expanded="false">
              <i class="material-icons-outlined">arrow_right</i>
              Descuentos
              </a>
              <ul class="mm-collapse" >
                <li><a class="has-arrow fs-12" href="/descuentos/create">
                  <i class="lni lni-plus"></i>
                  Crear un descuento</a>
                </li>
                <li><a class="has-arrow fs-12" href="/aplicar_descuento/create"><i class="lni lni-pointer-up"></i>
                  Aplicar un descuento</a>
                </li>
                <li><a class="has-arrow fs-12" href="/tabla/descuentos"><i class="lni lni-folder"></i>
                  Ver descuentos</a>
                </li>
              </ul>
            </li>
            <li class=""><a class="has-arrow" href="javascript:;" aria-expanded="false">
              <i class="material-icons-outlined">arrow_right</i>
              Conceptos Cobro
              </a>
              <ul class="mm-collapse" >
                <li><a href="/formulario/alta_categoria_cobros" class="fs-12"><i class="lni lni-plus"></i>
                  Crear Categoría</a>
                </li> 
                <li>
                  <a href="/formulario/alta_conceptos_cobros" class="fs-12"><i class="lni lni-plus"></i>
                  Crear Concepto</a>
                </li> 
                <li>
                  <a href="/formulario/alta_costos_conceptos" class="fs-12"><i class="lni lni-pointer-up"></i>
                  Asignar Costo</a>
                </li> 
                <li><a href="/tabla/categoria_cobros" class="fs-12"><i class="lni lni-folder"></i> Ver Categorías</a>
                </li> 
                <li><a href="/tabla/conceptos_cobros" class="fs-12"><i class="lni lni-folder"></i> Ver Conceptos</a>
                </li>   
                <li><a href="/tabla/costos_conceptos" class="fs-12"><i class="lni lni-folder"></i> Ver Costos</a>
                </li>
              </ul>
            </li>
            <li class=""><a class="has-arrow" href="javascript:;" aria-expanded="false">
              <i class="material-icons-outlined">arrow_right</i>
              Cuentas
              </a>
              <ul class="mm-collapse">
                <li><a href="/tabla/cuentas" class="fs-12"><i class="fadeIn animated bx bx-id-card"></i>Ver Cuentas</a>
                </li>
                <li>
                  <a href="/formulario/alta_cuentas" class="fs-12"><i class="fadeIn animated bx bx-dollar"></i> Generar Cuenta</a>
                </li>
                <li>
                  <a href="/pagos_pendientes/create" class="fs-12"><i class="fadeIn animated bx bx-dollar"></i> Pago Pendiente</a>
                </li>
                <li>
                  <a href="/pagos_realizados/create" class="fs-12"><i class="fadeIn animated bx bx-dollar"></i> Registrar Pago</a>
                </li>
                <li>
                  <a href="/ver_cuenta" class="fs-12"><i class="fadeIn animated bx bx-dollar"></i> Documento Cuenta</a>
                </li>    
              </ul>
            </li>
            <li class=""><a class="has-arrow" href="javascript:;" aria-expanded="false">
              <i class="material-icons-outlined">arrow_right</i>
              Pagos
              </a>
              <ul class="mm-collapse">
                <li><a href="/tabla/pagos_pendientes" class="fs-12"><i class="fadeIn animated bx bx-id-card"></i>Ver Pagos Pendientes</a>
                </li>
                <li><a href="/tabla/pagos" class="fs-12"><i class="fadeIn animated bx bx-id-card"></i>Ver Pagos Realizados</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        @endif

        @if(auth()->user()->hasAnyRole(['Admin','Control de títulos']))
        <li>
            <a class="has-arrow" href="javascript:;" aria-expanded="true">
                <div class="font-20">	<i class="fadeIn animated bx bx-group"></i>
                </div>
                <div class="menu-title">Base datos</div>
            </a>
            <ul class="mm-collapse" style="">
              @if(auth()->user()->can('Generar tablas'))
              <li><a href="/crear_archivo" class="fs-6"><i class="lni lni-circle-plus"></i> Generar tabla</a></li> 
              @endif
              @if(auth()->user()->can('Cargar tablas'))
              <li><a href="/cargar_datos" class="fs-6"><i class="lni lni-circle-plus"></i> Cargar datos</a></li> 
              @endif
              @if(auth()->user()->can('Crear queries'))
              <li><a href="/sql_creator/create" class="fs-6"> <i class="lni lni-circle-plus"></i> Crear query</a></li> 
              @endif
              @if(auth()->user()->can('Crear formularios'))
              <li class="fs-12"><a href="{{ route('form_creator.create'); }}"><i class="lni lni-circle-plus"></i> Crear formulario</a></li>
              @endif
              @if(auth()->user()->can('Crear liga'))
              <li class="fs-12"><a href="{{ route('ligas_formulario.create'); }}"><i class="lni lni-circle-plus"></i> Crear liga</a></li>
              @endif
              @if(auth()->user()->can('Crear dashboards'))
                <li class="fs-12"><a href="/dashboard/create"><i class="lni lni-layout"></i> Crear dashboard</a></li>
              @endif
               @if(auth()->user()->can('Crear informe'))
                <li class="fs-12"><a href="/informes/create"><i class="lni lni-layout"></i> Crear informe</a></li>
              @endif
              @if(auth()->user()->can('Ver queries'))
              <li class="fs-12"><a href="/sql_creator"><i class="lni lni-code-alt"></i> Queries creados</a></li>
              @endif
              @if(auth()->user()->can('Ver archivos'))
              <li class="fs-12"><a href="/archivos"><i class="lni lni-empty-file"></i> Documento excel</a></li>
              @endif
              @if(auth()->user()->can('Ver tablas'))
              <li class="fs-12"><a href="/tablas_modulos"><i class="lni lni-archive"></i> Tablas BD</a></li>
              @endif
              @if(auth()->user()->can('Ver informes'))
              <li class="fs-12"><a href="/informes"><i class="lni lni-clipboard"></i> Ver informes</a></li>
              @endif
              @if(auth()->user()->can('Ver formularios'))
              <li class="fs-12"><a href="/form_creator"><i class="lni lni-clipboard"></i> Ver formularios</a></li>
              @endif
              @if(auth()->user()->can('Ver titulos'))
                <li class="fs-12"><a href="/titulos_generados"><i class="lni lni-certificate"></i> Ver titulos</a></li>
              @endif 
              @if(auth()->user()->can('Ver ligas'))
                <li class="fs-12"><a href="/ligas_formulario"><i class="lni lni-certificate"></i> Ver ligas</a></li>
              @endif                  
            </ul>
        </li>
        @endif
        
        @if(auth()->user()->hasAnyRole(['Admin']))
        <li>
            <a class="has-arrow" href="javascript:;" aria-expanded="true">
                <div class="font-20">	<i class="fadeIn animated bx bx-group"></i>
                </div>
                <div class="menu-title">Alumnos</div>
            </a>
            <ul class="mm-collapse" style="">
              <li><a href="/alumnos/create" class="fs-6"> <i class="fadeIn animated bx bx-user-plus"></i>Agregar Alumnos</a></li> 
              <li class="fs-12"><a href="{{ route("definir_materias_alumno"); }}"><i class="lni lni-circle-plus"></i> Definir currícula</a></li>
              <li class="fs-12"><a href="/inscripciones/create"><i class="lni lni-circle-plus"></i> Generar inscripción </a></li>
               
              <li><a href="/carga_materias/create" class="fs-6"> <i class="lni lni-postcard"></i>Cargar materias</a></li>       
              <li class="fs-12"><a href="/inscripciones"><i class="lni lni-network"></i> Ver Inscripciones </a></li> 
              <li><a href="/alumnos" class="fs-20"><i class="fadeIn animated bx bx-id-card"></i>Ver Alumnos</a></li>
              <li><a href="/carga_materias" class="fs-6"><i class="lni lni-school-bench-alt"></i> Ver Materias Cargadas</a></li>
               
            </ul>
        </li>
        @endif
        @if(auth()->user()->hasAnyRole(['Admin']))
         <li>
            <a class="has-arrow" href="javascript:;" aria-expanded="true">
                <div class="font-20">	<i class="fadeIn animated bx bx-group"></i>
                </div>
                <div class="menu-title">Maestros</div>
            </a>
            <ul class="mm-collapse" style="">
              @if(auth()->user()->can('Agregar maestro'))
                <li class="fs-12"><a href="/maestros/create"><i class="lni lni-circle-plus"></i> Agregar maestro </a></li>
              @endif
              @if(auth()->user()->can('Ver maestros'))
                <li><a href="/maestros" class="fs-6"> <i class="fadeIn animated bx bx-user-plus"></i>Ver maestros</a></li> 
              @endif
              @if(auth()->user()->can('Currícula maestro'))
                <li class="fs-12"><a href="/maestros_materias/definir_materias"><i class="lni lni-network"></i> Currícula Maestro </a></li>
              @endif
              @if(auth()->user()->can('Buscar disponibilidad maestro'))
                <li class="fs-12"><a href="/buscar_disponibilidad"><i class="lni lni-network"></i> Horario Disponible </a></li>
              @endif
              @if(auth()->user()->can('Manejar tipos de correos de maestros'))
                <li class="fs-12"><a href="/tipos_correos_maestros/create"><i class="lni lni-circle-plus"></i> Agregar Tipo/Correo </a></li>   
                <li><a href="/tipos_correos_maestros" class="fs-6"> <i class="fadeIn animated bx bx-user-plus"></i>Lista Tipos/Co.</a></li> 
              @endif         
            </ul>
        </li>
        @endif
          
      
        @if(auth()->user()->hasAnyRole(['Admin'])) 
        <li>
            <a class="has-arrow" href="javascript:;" aria-expanded="true">
                <div class="font-20">	<i class="lni lni-checkbox"></i>
                </div>
                <div class="menu-title">Utilidades</div>
            </a>
            <ul class="mm-collapse" style="">
                <li class="fs-12"><a href="/directorios"><i class="lni lni-network"></i> Directorios </a></li>
                <li class="fs-12"><a href="/contactos_alumnos"><i class="lni lni-network"></i> Contactos Alumnos </a></li>
                <li class="fs-12"><a href="/gantt"><i class="lni lni-network"></i>Maneja Proyectos </a></li>
                <li class="fs-12"><a href="/tipos_contactos"><i class="lni lni-postcard"></i> Cat. Contactos </a></li>
                <li class="fs-12"><a href="/tipos_correos"><i class="lni lni-school-bench"></i> Categorías Correos </a></li>
                <li class="fs-12"><a href="/tipos_correos_contactos"><i class="lni lni-envelope"></i> Cat. Correos Cont.</a></li>
                <li class="fs-12"><a href="/tipos_correos/create"><i class="lni lni-circle-plus"></i> Generar Cat. Correo </a></li>
                <li class="fs-12"><a href="/tipos_contactos/create"><i class="lni lni-circle-plus"></i> Cat. Contacto </a></li>
                <li class="fs-12"><a href="/tipos_correos_contactos/create"><i class="lni lni-circle-plus"></i> Cat. Correo Cont. </a></li>
            </ul>
        </li>
        @endif
        
         @if(auth()->user()->hasAnyRole(['Admin'])) 
        <li>
              <a class="has-arrow" href="javascript:;" aria-expanded="true">
                  <div class="font-20">	<i class="lni lni-checkbox"></i>
							    </div>
                  <div class="menu-title">Pendientes</div>
              </a>
              <ul class="mm-collapse" style="">
                  <li><a href="/calendario"><i class="fadeIn animated bx bx-calendar-event"></i> Calendario   </a></li>
                  <li><a href="/tareas"> <i class="fadeIn animated bx bx-layer"></i> Tareas   </a></li>
              </ul>
          </li>
          @endif


          @if(auth()->user()->hasAnyRole(['Admin'])) 
          <li>
              <a class="has-arrow" href="javascript:;" aria-expanded="true">
                  <div class="font-20">	<i class="lni lni-consulting"></i>
							    </div>
                  <div class="menu-title">Roles y Permisos</div>
              </a>
              <ul class="mm-collapse" style="">

                <li><a href="/tabla/usuarios" class="fs-20"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-primary"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                  <span class="ps-3">Usuarios</span></a>
                </li>
                <li><a href="/usuarios/programar_roles" class="fs-20">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check text-primary"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                  <span class="ps-3"> Asignar Roles</span></a>
                </li> 
                <li><a href="/tabla/roles" class="fs-20">
                  <i class="fadeIn animated bx bx-id-card"></i>
                   <span class="ps-3"> Roles</span></a>
                </li>
                <li><a href="/tabla/permisos" class="fs-20">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle text-primary"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                   <span class="ps-3">Permisos</span></a>
                </li>  
                <li><a href="/invitaciones_usuarios" class="fs-20">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail text-primary"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                  <span class="ps-3">Invitaciones</span></a>
                </li>
                <li><a href="/invitaciones_usuarios/create" class="fs-20">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus text-primary"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                  <span class="ps-3">Invitar Usuario</span></a>
                </li>
              </ul>
          </li>
          @endif
          
          @endif
      
          <!-- Maestros -->
          
         </ul>
        <!--end navigation-->
    </div>
  </aside>
<!--end sidebar-->
