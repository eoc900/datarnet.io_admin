@extends('administrador.maestros.layouts.seccion_maestro')
@section("content")

  <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Maestro</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
              <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Información | Registrado: {{ \Carbon\Carbon::parse($maestro->inicio_contrato)->format('d-M-Y')  }}</li>
            </ol>
          </nav>
        </div>
        <div class="ms-auto">
          <div class="btn-group">
            <button type="button" class="btn btn-primary">Settings</button>
            <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
              data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                href="javascript:;">Action</a>
              <a class="dropdown-item" href="javascript:;">Another action</a>
              <a class="dropdown-item" href="javascript:;">Something else here</a>
              <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
            </div>
          </div>
        </div>
      </div>
      <!--end breadcrumb-->


      <div class="row">
        <div class="col-12 col-lg-4 d-flex">
          <div class="card w-100">
            <div class="card-body">
              <div class="position-relative">
                <img src="{{  asset("dashboard_resources/assets/images/gallery/18.png"); }}" class="img-fluid rounded" alt="">
                <div class="position-absolute top-100 start-50 translate-middle">
                  <img src="{{ Storage::url("avatar_maestros/".$maestro->avatar) }}" width="100" height="100"
                    class="rounded-circle raised p-1 bg-white" alt="">
                </div>
              </div>
              <div class="text-center mt-5 pt-4">
                <h4 class="mb-1">{{ $maestro->nombre." ".$maestro->apellido_paterno." ".$maestro->apellido_materno }}</h4>
                <p class="mb-0">Titulo académico</p>
              </div>
             
              <div class="d-flex align-items-center justify-content-around mt-5">
                <div class="d-flex flex-column gap-2">
                  <h4 class="mb-0 text-center">9</h4>
                  <p class="mb-0">Materias impartidas</p>
                </div>
                <div class="d-flex flex-column gap-2">
                  <h4 class="mb-0 text-center">4</h4>
                  <p class="mb-0">Reportes</p>
                </div>
                <div class="d-flex flex-column gap-2">
                  <h4 class="mb-0">8.5/10</h4>
                  <p class="mb-0">Calificación</p>
                </div>
              </div>

            
            <ul class="list-group list-group-flush">
              <li class="list-group-item border-top">
                <b>Dirección</b>
                <br>
                {{ $maestro->calle.", ".$maestro->codigo_postal.", ".$maestro->ciudad."," }}
                <br>
                {{ $maestro->estado }}
              </li>
              <li class="list-group-item">
                <b>Correos electrónicos</b>
                <br>
                {{ $maestro->correo_personal }}
                <br>
                {{ $maestro->correo_institucional }}
              </li>
              <li class="list-group-item">
                <b>Phone</b>
                <br>
                {{ $maestro->telefono }}
             
              </li>
              <li class="list-group-item text-center mt-4">
                <button type="button" class="btn btn-outline-{{ ($maestro->estado_sistema=="Activo")?"success":"warning"; }} px-5">{{ $maestro->estado_sistema}}</button>
              </li>
            </ul>
            </div>

          </div>
        </div>
        

        


        <div class="col-12 col-lg-8 d-flex">
<!-- Indicadores-->
                <div class="row">
        <div class="col-12 col-lg-12 ">
        <div class="card rounded-4 rounded-4">
        <div class="card-body">
          <div class="row row-cols-1 row-cols-lg-12 row-cols-xl-12 g-3">
            <div class="col">
              <div class="card rounded-4 mb-0 border">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-primary">
                      <span class="material-icons-outlined text-white">monetization_on</span>
                    </div>
                    <div class="dropdown">
                      <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="material-icons-outlined fs-5">more_vert</span>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="mt-4">
                    <h4 class="mb-0 fw-light">$2,500.00 MXN</h4>
                    <p class="mb-0">Pago pendiente</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-end gap-1 mt-3">
                    <p class="dash-lable d-flex align-items-center gap-1 rounded mb-0 bg-danger text-danger bg-opacity-10">
                      <span class="material-icons-outlined fs-6">arrow_downward</span>45.7%
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card rounded-4 mb-0 border">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-purple">
                      <span class="material-icons-outlined text-white">account_balance</span>
                    </div>
                    <div class="dropdown">
                      <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="material-icons-outlined fs-5">more_vert</span>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="mt-4">
                    <h4 class="mb-0 fw-light">30 horas</h4>
                    <p class="mb-0">Horas atendidas</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-end gap-1 mt-3">
                    <p class="dash-lable d-flex align-items-center gap-1 rounded mb-0 bg-success text-success bg-opacity-10">
                      <span class="material-icons-outlined fs-6">arrow_downward</span>25.6%
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card rounded-4 mb-0 border">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                   <div class="wh-48 d-flex bg-orange-light text-orange bg-opacity-10 align-items-center justify-content-center rounded-circle">
                    <span class="material-icons-outlined">bookmarks</span>
                    </div>
                    <div class="dropdown">
                      <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="material-icons-outlined fs-5">more_vert</span>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="mt-4">
                    <h4 class="mb-0 fw-light">10 faltas</h4>
                    <p class="mb-0">Faltas del periodo</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-end gap-1 mt-3">
                    <p class="dash-lable d-flex align-items-center gap-1 rounded mb-0 bg-danger text-danger bg-opacity-10">
                      <span class="material-icons-outlined fs-6">arrow_downward</span>25.6%
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card rounded-4 mb-0 border">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="wh-48 d-flex align-items-center justify-content-center rounded-circle bg-pink">
                      <span class="material-icons-outlined text-white">card_giftcard</span>
                    </div>
                    <div class="dropdown">
                      <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="material-icons-outlined fs-5">more_vert</span>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="mt-4">
                    <h4 class="mb-0 fw-light">10</h4>
                    <p class="mb-0">Tareas pendientes</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-end gap-1 mt-3">
                    <p class="dash-lable d-flex align-items-center gap-1 rounded mb-0 bg-success text-success bg-opacity-10">
                      <span class="material-icons-outlined fs-6">north</span>34.8%
                    </p>
                  </div>
                </div>
              </div>
            </div>

          </div><!--end row-->
        </div>
      </div>
        </div>
        </div>

            
<!-- Cierre indicadores-->
          <div class="card w-100">
            <div class="card-body">
              <h5 class="mb-3">Enviar un comentario</h5>
              <textarea class="form-control" placeholder="Escribe un comentario" rows="6" cols="6"></textarea>
              <button class="btn btn-filter w-100 mt-3">Agregar un comentario</button>
            </div>
            <div class="customer-notes mb-3">
              <div class="bg-light mx-3 my-0 rounded-3 p-3">
                <div class="notes-item">
                  <p class="mb-2">Por favor recuerda subir las calificaciones.</p>
                  <p class="mb-0 text-end fst-italic text-secondary">10 Apr, 2022</p>
                </div>
                <hr class="border-dotted">
                <div class="notes-item">
                  <p class="mb-2">Necesitamos un reporte del alumno Perengano.</p>
                  <p class="mb-0 text-end fst-italic text-secondary">15 Apr, 2022</p>
                </div>
                <hr>
                <div class="notes-item">
                  <p class="mb-2">Recuerda que hay junta de maestros mañana a las 2:00pm</p>
                  <p class="mb-0 text-end fst-italic text-secondary">15 Apr, 2022</p>
                </div>
                <hr>
                <div class="notes-item">
                  <p class="mb-2">In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate. quae ab illo inventore veritatis et quasi architecto</p>
                  <p class="mb-0 text-end fst-italic text-secondary">18 Apr, 2022</p>
                </div>
                <hr>
                <div class="notes-item">
                  <p class="mb-2">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                    piece of classical Latin literature</p>
                  <p class="mb-0 text-end fst-italic text-secondary">22 Apr, 2022</p>
                </div>
                <hr>
                <div class="notes-item">
                  <p class="mb-2">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                    laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto
                    beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit
                    aut fugit, sed quia consequuntur magni dolores</p>
                  <p class="mb-0 text-end fst-italic text-secondary">22 Apr, 2022</p>
                </div>
                <hr>
                <div class="notes-item">
                  <p class="mb-2">On the other hand, we denounce with righteous indignation and dislike pleasure of the
                    moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue;
                    and equal blame belongs to those</p>
                  <p class="mb-0 text-end fst-italic text-secondary">22 Apr, 2022</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!--end row-->

       <!-- calendario -->
      <div class="card">
        <div class="card-body">
              <!--breadcrumb-->
			

                    <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<div id='calendar'></div>
						</div>
					</div>
				 </div>
        </div>
      </div>
      <!-- calendario -->


      <div class="card">
        <div class="card-body">
          <h5 class="mb-3">Transacciones realizadas<span class="fw-light ms-2">(98)</span></h5>
          <div class="product-table">
            <div class="table-responsive white-space-nowrap">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Cuenta</th>
                    <th>Tipo de pago</th>
                    <th>Fecha</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>#2453</td>
                    <td>$865</td>
                    <td><span
                        class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Paid<i
                          class="bi bi-check2 ms-2"></i></span></td>
                    <td><span
                        class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Completed<i
                          class="bi bi-check2 ms-2"></i></span></td>
                    <td>Cash on delivery</td>
                    <td>Jun 12, 12:56 PM</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" type="button"
                          data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;"><i class="bi bi-eye-fill me-2"></i>View</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;"><i
                                class="bi bi-box-arrow-right me-2"></i>Export</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="javascript:;"><i
                                class="bi bi-trash-fill me-2"></i>Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#7845</td>
                    <td>$427</td>
                    <td><span
                        class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                          class="bi bi-x-lg ms-2"></i></span></td>
                    <td><span
                        class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">Completed<i
                          class="bi bi-check2 ms-2"></i></span></td>
                    <td>Cash on delivery</td>
                    <td>Jun 12, 12:56 PM</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" type="button"
                          data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;"><i class="bi bi-eye-fill me-2"></i>View</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;"><i
                                class="bi bi-box-arrow-right me-2"></i>Export</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="javascript:;"><i
                                class="bi bi-trash-fill me-2"></i>Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#9635</td>
                    <td>$123</td>
                    <td><span
                        class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">Pending<i
                          class="bi bi-info-circle ms-2"></i></span></td>
                    <td><span
                        class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                          class="bi bi-x-lg ms-2"></i></span></td>
                    <td>Cash on delivery</td>
                    <td>Jun 12, 12:56 PM</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" type="button"
                          data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;"><i class="bi bi-eye-fill me-2"></i>View</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;"><i
                                class="bi bi-box-arrow-right me-2"></i>Export</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="javascript:;"><i
                                class="bi bi-trash-fill me-2"></i>Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#2415</td>
                    <td>$986</td>
                    <td><span
                        class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">Completed<i
                          class="bi bi-check2-all ms-2"></i></span></td>
                    <td><span
                        class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">Pending<i
                          class="bi bi-info-circle ms-2"></i></span></td>
                    <td>Cash on delivery</td>
                    <td>Jun 12, 12:56 PM</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" type="button"
                          data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;"><i class="bi bi-eye-fill me-2"></i>View</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;"><i
                                class="bi bi-box-arrow-right me-2"></i>Export</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="javascript:;"><i
                                class="bi bi-trash-fill me-2"></i>Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#3526</td>
                    <td>$104</td>
                    <td><span
                        class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                          class="bi bi-x-lg ms-2"></i></span></td>
                    <td><span
                        class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Completed<i
                          class="bi bi-check2 ms-2"></i></span></td>
                    <td>Cash on delivery</td>
                    <td>Jun 12, 12:56 PM</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" type="button"
                          data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;"><i class="bi bi-eye-fill me-2"></i>View</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;"><i
                                class="bi bi-box-arrow-right me-2"></i>Export</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="javascript:;"><i
                                class="bi bi-trash-fill me-2"></i>Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#7845</td>
                    <td>$368</td>
                    <td><span
                        class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Paid<i
                          class="bi bi-check2 ms-2"></i></span></td>
                    <td><span
                        class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                          class="bi bi-x-lg ms-2"></i></span></td>
                    <td>Cash on delivery</td>
                    <td>Jun 12, 12:56 PM</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" type="button"
                          data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;"><i class="bi bi-eye-fill me-2"></i>View</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;"><i
                                class="bi bi-box-arrow-right me-2"></i>Export</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="javascript:;"><i
                                class="bi bi-trash-fill me-2"></i>Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#256</td>
                    <td>$865</td>
                    <td><span
                        class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">Pending<i
                          class="bi bi-info-circle ms-2"></i></span></td>
                    <td><span
                        class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">Completed<i
                          class="bi bi-check2-all ms-2"></i></span></td>
                    <td>Cash on delivery</td>
                    <td>Jun 12, 12:56 PM</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-nocaret" type="button"
                          data-bs-toggle="dropdown">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="javascript:;"><i class="bi bi-eye-fill me-2"></i>View</a>
                          </li>
                          <li><a class="dropdown-item" href="javascript:;"><i
                                class="bi bi-box-arrow-right me-2"></i>Export</a></li>
                          <li class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="javascript:;"><i
                                class="bi bi-trash-fill me-2"></i>Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-body">
          <h5 class="mb-3 fw-bold">Calificaciones<span class="fw-light ms-2">(46)</span></h5>
          <div class="product-table">
            <div class="table-responsive white-space-nowrap">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>

                    <th>Alumno</th>
                    <th>Materia</th>
                    <th>Categoría</th>
                    <th>Exámenes</th>
                    <th>Calificaciones</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <div class="product-box">
                          <img src="assets/images/top-products/06.png" width="55" class="rounded-3" alt="">
                        </div>
                        <div class="product-info">
                          <a href="javascript:;" class="product-title">Women Pink Floral Printed</a>
                          <p class="mb-0 product-category">Category : Fashion</p>
                        </div>
                      </div>
                    </td>
                    <td>Blue</td>
                    <td>Large</td>
                    <td>2</td>
                    <td>$59</td>
                    <td>189</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <div class="product-box">
                          <img src="assets/images/top-products/05.png" width="55" class="rounded-3" alt="">
                        </div>
                        <div class="product-info">
                          <a href="javascript:;" class="product-title">Women Pink Floral Printed</a>
                          <p class="mb-0 product-category">Category : Fashion</p>
                        </div>
                      </div>
                    </td>
                    <td>Blue</td>
                    <td>Large</td>
                    <td>2</td>
                    <td>$59</td>
                    <td>189</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <div class="product-box">
                          <img src="assets/images/top-products/04.png" width="55" class="rounded-3" alt="">
                        </div>
                        <div class="product-info">
                          <a href="javascript:;" class="product-title">Women Pink Floral Printed</a>
                          <p class="mb-0 product-category">Category : Fashion</p>
                        </div>
                      </div>
                    </td>
                    <td>Blue</td>
                    <td>Large</td>
                    <td>2</td>
                    <td>$59</td>
                    <td>189</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <div class="product-box">
                          <img src="assets/images/top-products/03.png" width="55" class="rounded-3" alt="">
                        </div>
                        <div class="product-info">
                          <a href="javascript:;" class="product-title">Women Pink Floral Printed</a>
                          <p class="mb-0 product-category">Category : Fashion</p>
                        </div>
                      </div>
                    </td>
                    <td>Blue</td>
                    <td>Large</td>
                    <td>2</td>
                    <td>$59</td>
                    <td>189</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <div class="product-box">
                          <img src="assets/images/top-products/02.png" width="55" class="rounded-3" alt="">
                        </div>
                        <div class="product-info">
                          <a href="javascript:;" class="product-title">Women Pink Floral Printed</a>
                          <p class="mb-0 product-category">Category : Fashion</p>
                        </div>
                      </div>
                    </td>
                    <td>Blue</td>
                    <td>Large</td>
                    <td>2</td>
                    <td>$59</td>
                    <td>189</td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <div class="product-box">
                          <img src="assets/images/top-products/01.png" width="55" class="rounded-3" alt="">
                        </div>
                        <div class="product-info">
                          <a href="javascript:;" class="product-title">Women Pink Floral Printed</a>
                          <p class="mb-0 product-category">Category : Fashion</p>
                        </div>
                      </div>
                    </td>
                    <td>Blue</td>
                    <td>Large</td>
                    <td>2</td>
                    <td>$59</td>
                    <td>189</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-body">
          <h5 class="mb-3 fw-bold">Retroalimentación de alumnos<span class="fw-light ms-2">(86)</span></h5>
          <div class="product-table">
            <div class="table-responsive white-space-nowrap">
              <table class="table align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Product Name</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <a href="javascript:;" class="product-title">Women Pink Floral Printed Panelled Pure Cotton</a>
                    </td>
                    <td>
                      <div class="product-rating text-warning">
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                    </td>
                    <td class="review-desc">This is very awesome product. It has good quality. I suggest everyone to use this
                      product. It is available at very low amount.</td>
                    <td><span
                        class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Completed<i
                          class="bi bi-check2 ms-2"></i></span></td>
                    <td>Jun 12, 12:56 PM</td>
                  </tr>
                  <tr>
                    <td>
                      <a href="javascript:;" class="product-title">Women Pink Floral Printed Panelled Pure Cotton</a>
                    </td>
                    <td>
                      <div class="product-rating text-warning">
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                    </td>
                    <td class="review-desc">This is very awesome product. It has good quality. I suggest everyone to use this
                      product. It is available at very low amount.</td>
                    <td><span
                        class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                          class="bi bi-x-lg ms-2"></i></span></td>
                    <td>Jun 12, 12:56 PM</td>
                  </tr>
                  <tr>
                    <td>
                      <a href="javascript:;" class="product-title">Women Pink Floral Printed Panelled Pure Cotton</a>
                    </td>
                    <td>
                      <div class="product-rating text-warning">
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                    </td>
                    <td class="review-desc">This is very awesome product. It has good quality. I suggest everyone to use this
                      product. It is available at very low amount.</td>
                    <td><span
                        class="lable-table bg-primary-subtle text-primary rounded border border-primary-subtle font-text2 fw-bold">Completed<i
                          class="bi bi-check2-all ms-2"></i></span></td>
                    <td>Jun 12, 12:56 PM</td>
                  </tr>
                  <tr>
                    <td>
                      <a href="javascript:;" class="product-title">Women Pink Floral Printed Panelled Pure Cotton</a>
                    </td>
                    <td>
                      <div class="product-rating text-warning">
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                    </td>
                    <td class="review-desc">This is very awesome product. It has good quality. I suggest everyone to use this
                      product. It is available at very low amount.</td>
                    <td><span
                        class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Completed<i
                          class="bi bi-check2 ms-2"></i></span></td>
                    <td>Jun 12, 12:56 PM</td>
                  </tr>
                  <tr>
                    <td>
                      <a href="javascript:;" class="product-title">Women Pink Floral Printed Panelled Pure Cotton</a>
                    </td>
                    <td>
                      <div class="product-rating text-warning">
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                    </td>
                    <td class="review-desc">This is very awesome product. It has good quality. I suggest everyone to use this
                      product. It is available at very low amount.</td>
                    <td><span
                        class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Failed<i
                          class="bi bi-x-lg ms-2"></i></span></td>
                    <td>Jun 12, 12:56 PM</td>
                  </tr>
                  <tr>
                    <td>
                      <a href="javascript:;" class="product-title">Women Pink Floral Printed Panelled Pure Cotton</a>
                    </td>
                    <td>
                      <div class="product-rating text-warning">
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                    </td>
                    <td class="review-desc">This is very awesome product. It has good quality. I suggest everyone to use this
                      product. It is available at very low amount.</td>
                    <td><span
                        class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">Pending<i
                          class="bi bi-info-circle ms-2"></i></span></td>
                    <td>Jun 12, 12:56 PM</td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


    </div>
  </main>
  <!--end main wrapper-->


 @endsection