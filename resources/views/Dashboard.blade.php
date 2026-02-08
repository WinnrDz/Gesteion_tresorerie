  @extends('layouts.app')

  @section('content')


      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">

              <div class="row">
                  <div class="ms-3">
                      <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
                      <p class="mb-4">
                          Statistics
                      </p>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                          <div class="card-header p-2 ps-3">
                              <div class="d-flex justify-content-between">
                                  @if ($initial == null)
                                      <div>
                                          <p class="text-sm mb-0 text-capitalize"> Trésorerie initiale</p>
                                          <form id="tresorerieForm" action="{{ route('entrees.store') }}" method="POST">
                                              @csrf
                                              <input type="text" name="valeur" class="form-control mb-0"
                                                  placeholder="................................"> Enter montant initial
                                              <input type="hidden" name="initial" value="0">
                                      </div>
                                      <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg"
                                          style="cursor:pointer;"
                                          onclick="document.getElementById('tresorerieForm').submit();">
                                          <i class="material-symbols-rounded opacity-10">add</i>
                                      </div>
                                      </form>
                                  @else
                                      <div>
                                          <p class="text-sm mb-0 text-capitalize"> Trésorerie initiale d’aujourd’hui</p>
                                          <h4 class="mb-0">{{ $initial }} DA</h4>
                                      </div>
                                      <div
                                          class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                          <i class="material-symbols-rounded opacity-10">fertile</i>
                                      </div>
                                  @endif
                              </div>
                          </div>
                          <hr class="dark horizontal my-0">
                      </div>
                  </div>
              </div>
              <div class="row" style="padding-top: 20px">
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                          <div class="card-header p-2 ps-3">
                              <div class="d-flex justify-content-between">
                                  <div>
                                      <p class="text-sm mb-0 text-capitalize">Total Entrées d'aujourd'hui</p>
                                      <h4 class="mb-0">{{ $totalentreeToday }} DA</h4>
                                  </div>
                                  <div
                                      class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                      <i class="material-symbols-rounded opacity-10">weekend</i>
                                  </div>
                              </div>
                          </div>
                          <hr class="dark horizontal my-0">
                          <div class="card-footer p-2 ps-3">
                              <p class="mb-0 text-sm">
                                  @if ($percentageentree)
                                      @if ($percentageentree > 0)
                                          <span class="text-success font-weight-bolder">{{ $percentageentree }}% </span>
                                      @else
                                          <span class="text font-weight-bolder">{{ $percentageentree }}% </span>
                                      @endif
                                      than yesterday
                                  @else
                                      no records from yesterday
                                  @endif
                              </p>
                          </div>
                      </div>
                  </div>



                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                          <div class="card-header p-2 ps-3">
                              <div class="d-flex justify-content-between">
                                  <div>
                                      <p class="text-sm mb-0 text-capitalize">Total Dépenses d'aujourd'hui</p>
                                      <h4 class="mb-0">{{ $totaldepenseToday }} DA</h4>
                                  </div>
                                  <div
                                      class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                      <i class="material-symbols-rounded opacity-10">weekend</i>
                                  </div>
                              </div>
                          </div>
                          <hr class="dark horizontal my-0">
                          <div class="card-footer p-2 ps-3">
                              <p class="mb-0 text-sm">
                                  @if ($percentagedepense)
                                      <span class="text font-weight-bolder">{{ $percentagedepense }}% </span>
                                      than yesterday
                                  @else
                                      no records from yesterday
                                  @endif
                              </p>
                          </div>
                      </div>
                  </div>

                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                          <div class="card-header p-2 ps-3">
                              <div class="d-flex justify-content-between">
                                  <div>
                                      <p class="text-sm mb-0 text-capitalize">Solde d'aujourd'hui</p>
                                      <h4 class="mb-0">{{ $solde }} DA</h4>
                                  </div>
                                  <div
                                      class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                      <i class="material-symbols-rounded opacity-10">weekend</i>
                                  </div>
                              </div>
                          </div>
                          <hr class="dark horizontal my-0">
                          <div class="card-footer p-2 ps-3">
                              <p class="mb-0 text-sm">
                                  Solde des Entrées et Dépenses
                              </p>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                          <div class="card-header p-2 ps-3">
                              <div class="d-flex justify-content-between">
                                  <div>
                                      <p class="text-sm mb-0 text-capitalize">Trésorerie finale</p>
                                      <h4 class="mb-0">{{ $finale }} DA</h4>
                                  </div>
                                  <div
                                      class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                      <i class="material-symbols-rounded opacity-10">weekend</i>
                                  </div>
                              </div>
                          </div>
                          <hr class="dark horizontal my-0">
                          <div class="card-footer p-2 ps-3">
                              <p class="mb-0 text-sm">
                                  @if ($percentageFinale)
                                      @if ($percentageFinale > 0)
                                          <span class="text-success font-weight-bolder">{{ $percentageFinale }}% </span>
                                      @else
                                          <span class="text font-weight-bolder">{{ $percentageFinale }}% </span>
                                      @endif
                                      than yesterday
                                  @else
                                      no records from yesterday
                                  @endif
                              </p>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row mb-4">
                  <div class="col-lg-4 col-md-6 mt-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h6 class="mb-0 ">Entrées de cette semaine</h6>
                              <p class="text-sm ">Graphique qui affiche les Entrées par temps</p>
                              <div class="pe-2">
                                  <div class="chart">
                                      <canvas id="chart-bars" class="chart-canvas" height="212" width="454"
                                          style="display: block; box-sizing: border-box; height: 170px; width: 363px;"></canvas>
                                      <script>
                                          window.dashboardData = {
                                              entrees: @json($entreeValeurWeek),
                                              depenses: @json($depenseValeurWeek),
                                              tresoreries: @json($tresorerieValuerWeek),
                                              entreeValeurLast4Weeks: @json($entreeValeurLast4Weeks),
                                              depenseValeurLast4Weeks: @json($depenseValeurLast4Weeks),
                                              tresorerieValeurLast4Weeks: @json($tresorerieValeurLast4Weeks),
                                              last7Days: @json($last7Days),
                                              weekLabels: @json($weekLabels),
                                              lastMonthLabels: @json($lastMonthLabels),
                                              entreeValeurLastMonths: @json($entreeValeurLastMonths),
                                              depenseValeurLastMonths: @json($depenseValeurLastMonths),
                                              tresorerieValeurLastMonths: @json($tresorerieValeurLastMonths)
                                          };
                                      </script>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-4 col-md-6 mt-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h6 class="mb-0 ">Entrées de ce mois</h6>
                              <p class="text-sm ">Graphique qui affiche les Entrées par temps</p>
                              <div class="pe-2">
                                  <div class="chart">
                                      <canvas id="chart-bars-m" class="chart-canvas" height="212" width="454"
                                          style="display: block; box-sizing: border-box; height: 170px; width: 363px;"></canvas>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-4 col-md-6 mt-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h6 class="mb-0 ">Entrées des mois précédents</h6>
                              <p class="text-sm ">Graphique qui affiche les Entrées par temps</p>
                              <div class="pe-2">
                                  <div class="chart">
                                      <canvas id="chart-bars-y" class="chart-canvas" height="212" width="454"
                                          style="display: block; box-sizing: border-box; height: 170px; width: 363px;"></canvas>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-4 col-md-6 mt-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h6 class="mb-0 ">Depenses de cette semaine</h6>
                              <p class="text-sm ">Graphique qui affiche les Dépenses par temps</p>
                              <div class="pe-2">
                                  <div class="chart">
                                      <canvas id="chart-bars-2" class="chart-canvas" height="212" width="454"
                                          style="display: block; box-sizing: border-box; height: 170px; width: 363px;"></canvas>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  
                  <div class="col-lg-4 col-md-6 mt-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h6 class="mb-0 ">Depenses de ce mois</h6>
                              <p class="text-sm ">Graphique qui affiche les Dépenses par temps</p>
                              <div class="pe-2">
                                  <div class="chart">
                                      <canvas id="chart-bars-2-m" class="chart-canvas" height="212" width="454"
                                          style="display: block; box-sizing: border-box; height: 170px; width: 363px;"></canvas>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-4 col-md-6 mt-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h6 class="mb-0 ">Depenses des mois précédents</h6>
                              <p class="text-sm ">Graphique qui affiche les Dépenses par temps</p>
                              <div class="pe-2">
                                  <div class="chart">
                                      <canvas id="chart-bars-2-y" class="chart-canvas" height="212" width="454"
                                          style="display: block; box-sizing: border-box; height: 170px; width: 363px;"></canvas>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>


                  <div class="col-lg-4 mt-4 mb-3">
                      <div class="card">
                          <div class="card-body">
                              <h6 class="mb-0 ">Tresorerie</h6>
                              <p class="text-sm ">Graphique qui affiche la trésorerie par temps</p>
                              <div class="pe-2">
                                  <div class="chart">
                                      <canvas id="chart-line-tasks" class="chart-canvas" height="212" width="454"
                                          style="display: block; box-sizing: border-box; height: 170px; width: 363px;"></canvas>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row mb-4">
                  <div class="col-lg-10 col-md-6 mb-md-0 mb-4">
                      <div class="card">
                          <div class="card-header pb-0">
                              <div class="row">
                                  <div class="col-lg-6 col-7">
                                      <h6>Projects</h6>
                                      <p class="text-sm mb-0">
                                          <i class="fa fa-check text-info" aria-hidden="true"></i>
                                          <span class="font-weight-bold ms-1">30 done</span> this month
                                      </p>
                                  </div>
                                  <div class="col-lg-6 col-5 my-auto text-end">
                                      <div class="dropdown float-lg-end pe-4">
                                          <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                              aria-expanded="false">
                                              <i class="fa fa-ellipsis-v text-secondary"></i>
                                          </a>
                                          <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5"
                                              aria-labelledby="dropdownTable">
                                              <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a>
                                              </li>
                                              <li><a class="dropdown-item border-radius-md" href="javascript:;">Another
                                                      action</a></li>
                                              <li><a class="dropdown-item border-radius-md" href="javascript:;">Something
                                                      else here</a></li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                              <div class="table-responsive">
                                  <table class="table align-items-center mb-0">
                                      <thead>
                                          <tr>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Projects</th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                  Clients</th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Montant</th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  achèvement</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($projects as $project)
                                              <tr>
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div>
                                                              <img src="../assets/img/small-logos/logo-xd.svg"
                                                                  class="avatar avatar-sm me-3" alt="xd">
                                                          </div>
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">{{ $project->nom }}</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                      <div class="avatar-group mt-2">
                                                          <h6 class="mb-0 text-sm">{{ $project->client->nom }}</h6>
                                                      </div>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span class="text-xs font-weight-bold"> {{ $project->montant }}
                                                          DA</span>
                                                  </td>
                                                  <td class="align-middle">
                                                      <div class="progress-wrapper w-75 mx-auto">
                                                          <div class="progress-info">
                                                              <div class="progress-percentage">
                                                                  <span
                                                                      class="text-xs font-weight-bold">{{ round($project->percentage) }}%</span>
                                                              </div>
                                                          </div>
                                                          <div class="progress">
                                                              <div class="progress-bar bg-gradient-info"
                                                                  role="progressbar"
                                                                  aria-valuenow="{{ $project->percentage }}"
                                                                  aria-valuemin="0" aria-valuemax="100"
                                                                  style="width: {{ $project->percentage }}%;">
                                                              </div>

                                                          </div>
                                                      </div>
                                                  </td>
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>


                              </div>
                          </div>
                          @if ($projects->hasPages())
                              <nav aria-label="Page navigation example">
                                  <ul class="pagination pagination-secondary justify-content-center">
                                      @foreach ($projects->links()->elements[0] as $page => $url)
                                          <li class="page-item {{ $projects->currentPage() == $page ? 'active ' : '' }}">
                                              <a href="{{ $url }}"
                                                  class="page-link {{ $projects->currentPage() == $page ? 'text-white bg-indigo-600' : '' }}">{{ $page }}</a>
                                          </li>
                                      @endforeach
                                  </ul>
                              </nav>
                          @endif
                      </div>

                  </div>

              </div>
          </div>
      </main>
  @endsection






