<!--start sidebar-->
   <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div class="logo-icon">
        <img src="{{ asset('dashboard_resources/assets/branding/logo-icono-datarnet.png'); }}" class="logo-img" alt="">
      </div>
      <div class="logo-name flex-grow-1">
       <p class="fs-15 text-center pt-3 orbitron">Datarnet.io</p>
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

            <li>
            <a class="has-arrow" href="javascript:;" aria-expanded="true">
                <div class="font-20">	<i class="fadeIn animated bx bx-group"></i>
                </div>
                <div class="menu-title">Base datos</div>
            </a>
            <ul class="mm-collapse mm-show" style="">
              @if(auth()->user()->can('Generar tablas'))
              <li><a href="/crear_archivo" class="fs-6"><i class="lni lni-circle-plus"></i> Generar tabla</a></li> 
              @endif
              @if(auth()->user()->can('Cargar tablas'))
              <li><a href="/ver_cargar_tabla" class="fs-6"><i class="lni lni-circle-plus"></i> Cargar datos</a></li> 
              @endif
              {{-- @if(auth()->user()->can('Crear queries'))
              <li><a href="/sql_creator/create" class="fs-6"> <i class="lni lni-circle-plus"></i> Crear query</a></li> 
              @endif --}}
              @if(auth()->user()->can('Crear formularios'))
              <li class="fs-12"><a href="{{ route('form_creator.create'); }}"><i class="lni lni-circle-plus"></i> Crear formulario</a></li>
              @endif
              @if(auth()->user()->can('Crear liga'))
              <li class="fs-12"><a href="{{ route('ligas_formulario.create'); }}"><i class="lni lni-circle-plus"></i> Crear liga</a></li>
              @endif
               @if(auth()->user()->can('Crear informe'))
                <li class="fs-12"><a href="/informes/create"><i class="lni lni-layout"></i> Crear informe</a></li>
              @endif
              {{-- @if(auth()->user()->can('Ver queries'))
              <li class="fs-12"><a href="/sql_creator"><i class="lni lni-code-alt"></i> Queries creados</a></li>
              @endif --}}
              @if(auth()->user()->can('Ver archivos'))
              <li class="fs-12"><a href="/archivos"><i class="lni lni-empty-file"></i> Documentos excel</a></li>
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
              @if(auth()->user()->can('Ver ligas'))
                <li class="fs-12"><a href="/ligas_formulario"><i class="lni lni-certificate"></i> Ver ligas</a></li>
              @endif                  
            </ul>
        </li>
           

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

          @if(auth()->user()->hasAnyRole(['Administrador tecnológico','Owner'])) 
            <li>
                <a class="has-arrow" href="javascript:;" aria-expanded="true">
                    <div class="font-20">	<i class="lni lni-consulting"></i>
                    </div>
                    <div class="menu-title">Usuarios</div>
                </a>
                <ul class="mm-collapse" style="">
                  <li><a href="{{ route('users.index'); }}" class="fs-20"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-primary"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span class="ps-3">Usuarios</span></a>
                  </li>
                  <li><a href="{{ route('roles.index') }}" class="fs-20">
                    <i class="fadeIn animated bx bx-id-card"></i>
                    <span class="ps-3"> Roles</span></a>
                  </li>
                  <li><a href="{{ route('permisos.index') }}" class="fs-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle text-primary"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    <span class="ps-3">Permisos</span></a>
                  </li>  
                </ul>
            </li>
          @endif
        
          
          
         </ul>
        <!--end navigation-->
    </div>
  </aside>
<!--end sidebar-->
