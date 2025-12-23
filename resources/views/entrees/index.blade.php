  @extends('layout')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">
              <div class="row">
                  <div class="col-12">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                  <h6 class="text-white text-capitalize ps-3">Entrées table</h6>
                              </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                              <div class="table-responsive p-0">
                                  <table class="table align-items-center mb-0">
                                      <thead>
                                          <tr>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  type
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  <a
                                                      href="{{ request('sortProject') == 'asc' ? '?sortProject=desc' : '?sortProject=asc' }}">Project
                                                      {{ request('sortProject') == 'asc' ? '▼' : '' }}
                                                      {{ request('sortProject') == 'desc' ? '▲' : '' }}</a>
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  <a
                                                      href="{{ request('sortEnca') == 'asc' ? '?sortEnca=desc' : '?sortEnca=asc' }}">Encaissements
                                                      {{ request('sortEnca') == 'asc' ? '▲' : '' }}
                                                      {{ request('sortEnca') == 'desc' ? '▼' : '' }}</a></th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  note</th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  <a href="{{ request('sort') == 'asc' ? '?sort=desc' : '?sort=asc' }}">date
                                                      {{ request('sort') == 'asc' ? '▲' : '' }}
                                                      {{ request('sort') == 'desc' ? '▼' : '' }}</a>
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  attachment</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($entrees as $entree)
                                              <tr>
                                                  <td>
                                                      <h6 class="mb-0 text-sm">{{ $entree->type }}
                                                      </h6>
                                                  </td>
                                                  <td>
                                                      <h6 class="align-middle text-center text-sm">
                                                          {{ $entree->project->nom ?? 'null' }}
                                                      </h6>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span class="badge badge-sm bg-gradient-success">{{ $entree->valeur }}
                                                          DA</span>
                                                  </td>

                                                  <td class="align-middle text-center">
                                                      <span
                                                          class="text-secondary text-xs font-weight-bold">{{ $entree->note ?? 'no note' }}
                                                      </span>
                                                  </td>

                                                  <td class="align-middle text-center">
                                                      <span
                                                          class="text-secondary text-xs font-weight-bold">{{ $entree->date }}
                                                      </span>
                                                  </td>
                                                  @if ($entree->attachment)
                                                  <td class="align-middle text-center">
                                                      <a href="{{ route("entrees.download" , $entree->id )}}" class="text-secondary font-weight-bold text-xs">
                                                          download
                                                      </a>
                                                  </td>
                                                      
                                                  @else
                                                    <td class="align-middle text-center">
                                                      <span class="text-secondary font-weight-bold text-xs">
                                                          no piece joint
                                                      </span>
                                                    </td>
                                                  @endif    
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                          @if ($entrees->hasPages())
                              <nav aria-label="Page navigation example">
                                  <ul class="pagination pagination-secondary justify-content-center">
                                      @foreach ($entrees->links()->elements[0] as $page => $url)
                                          <li class="page-item {{ $entrees->currentPage() == $page ? 'active ' : '' }}">
                                              <a href="{{ $url }}"
                                                  class="page-link {{ $entrees->currentPage() == $page ? 'text-white bg-indigo-600' : '' }}">{{ $page }}</a>
                                          </li>
                                      @endforeach
                                  </ul>
                              </nav>
                          @endif
                      </div>
                      <a class="btn bg-gradient-dark mb-0" href="{{ route('entrees.create') }}"><i
                              class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Crée une Entrées</a>
                  </div>
              </div>
          </div>
      </main>
  @endsection
