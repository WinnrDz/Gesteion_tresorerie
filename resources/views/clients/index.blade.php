  @extends('layouts.app')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">
              <div class="row">
                  <div class="col-12">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                  <h6 class="text-white text-capitalize ps-3">Clients table</h6>
                              </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                              <div class="table-responsive p-0">
                                  <table class="table align-items-center mb-0">
                                      <thead>
                                          <tr>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  <a
                                                      href="{{ request('sortNom') == 'desc' ? '?sortNom=asc' : '?sortNom=desc' }}">nom
                                                      {{ request('sortNom') == 'asc' ? '▼' : '' }}
                                                      {{ request('sortNom') == 'desc' ? '▲' : '' }}</a>
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Projects
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($clients as $client)
                                              <tr>
                                                  <td>
                                                      <h6 class="mb-0 text-sm">{{ $client->nom }}
                                                      </h6>
                                                  </td>
                                                  <td>
                                                      @foreach ($client->projects as $project)
                                                      <h6 class="mb-0 text-sm">{{ $project->nom }}
                                                      </h6>
                                                    @endforeach
                                                </td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                          @if ($clients->hasPages())
                              <nav aria-label="Page navigation example">
                                  <ul class="pagination pagination-secondary justify-content-center">
                                      @foreach ($clients->links()->elements[0] as $page => $url)
                                          <li class="page-item {{ $clients->currentPage() == $page ? 'active ' : '' }}">
                                              <a href="{{ $url }}"
                                                  class="page-link {{ $clients->currentPage() == $page ? 'text-white bg-indigo-600' : '' }}">{{ $page }}</a>
                                          </li>
                                      @endforeach
                                  </ul>
                              </nav>
                          @endif
                      </div>
                      <a class="btn bg-gradient-dark mb-0" href="{{ route('clients.create') }}"><i
                              class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Crée un Client</a>
                  </div>
              </div>
          </div>
      </main>
  @endsection
