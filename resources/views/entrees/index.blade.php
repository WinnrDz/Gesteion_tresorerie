  @extends('layouts.app')

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
                                  <table class="table align-items-center mb-0" id="goofy-table">
                                      <thead>
                                          <tr class="bg-primary" style="display: none;" id="selectedRow">
                                              <th colspan="8">
                                                  <div class="d-flex justify-content-between align-items-center px-3 pe-5">
                                                      <label class="text-uppercase text-light font-weight-bolder fs-5">5
                                                          Selected</label>
                                                      <form action="{{ route('entrees.deleteMulti') }}" method="POST"
                                                          onsubmit="return confirm('Are you sure?')">@csrf <input
                                                              type="text" value="5" id="deleteMultiInput"
                                                              style="display: none;" name="deleteMultiInput"> <button
                                                              type="submit" id="deleteBtn"
                                                              style="background: none; border: none; padding: 0; margin: 0; cursor: pointer; outline: none;"><i
                                                                  class="fa-solid fa-trash fs-5 text-light"
                                                                  style="cursor: pointer;"></i></button>
                                                      </form>
                                                  </div>
                                              </th>
                                          </tr>
                                          <tr>
                                              <th style="padding-left:0.5%; width:5%">
                                                  <div class="form-check">
                                                      <input type="checkbox" class="form-check-input" id="selectAll">

                                                  </div>
                                              </th>
                                              <th style="width:5%"
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Edit</th>
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
                                                      {{ request('sortEnca') == 'desc' ? '▼' : '' }}</a>
                                              </th>
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
                                                      <div class="form-check">
                                                          <input type="checkbox" class="form-check-input"
                                                              id="customCheckDisabled" value="{{ $entree->id }}">

                                                          <label class="custom-control-label"
                                                              for="customCheckDisabled"></label>
                                                      </div>
                                                  </td>
                                                  <td style="text-align:center;">
                                                      <form action="{{ route('entrees.edit', $entree) }}" method="GET">
                                                          <button type="submit" id="deleteBtn"
                                                              style="background: none; border: none; padding: 0; margin: 0; cursor: pointer; outline: none;"><i
                                                                  class="material-symbols-rounded opacity-5">edit</i></button>
                                                      </form>
                                                  </td>
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
                                                      <span
                                                          class="badge badge-sm bg-gradient-success">{{ $entree->valeur }}
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
                                                          <a href="{{ route('entrees.download', $entree->id) }}"
                                                              class="text-secondary font-weight-bold text-xs">
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
