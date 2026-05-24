  @extends('layouts.app')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">
              <div class="row">
                  <div class="col-12">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                  <h6 class="text-white text-capitalize ps-3">Projects table</h6>
                              </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                              <div class="table-responsive p-0">
                                  <table class="table align-items-center mb-0" id="goofy-table">
                                      <thead>
                                          <tr class="bg-primary" style="display: none;" id="selectedRow">
                                              <th colspan="12">
                                                  <div class="d-flex justify-content-between align-items-center px-3 pe-5">
                                                      <label class="text-uppercase text-light font-weight-bolder fs-5">5
                                                          Selected</label>
                                                      <form action="{{ route('depenses.deleteMulti') }}" method="POST"
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
                                                  <a
                                                      href="{{ request('sortNom') == 'asc' ? '?sortNom=desc' : '?sortNom=asc' }}">Nom
                                                      {{ request('sortNom') == 'asc' ? '▼' : '' }}
                                                      {{ request('sortNom') == 'desc' ? '▲' : '' }}</a>
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  <a
                                                      href="{{ request('sortClientNom') == 'asc' ? '?sortClientNom=desc' : '?sortClientNom=asc' }}">Client
                                                      {{ request('sortClientNom') == 'asc' ? '▼' : '' }}
                                                      {{ request('sortClientNom') == 'desc' ? '▲' : '' }}</a>
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  <a
                                                      href="{{ request('sortMontant') == 'asc' ? '?sortMontant=desc' : '?sortMontant=asc' }}">Montant
                                                      {{ request('sortMontant') == 'asc' ? '▲' : '' }}
                                                      {{ request('sortMontant') == 'desc' ? '▼' : '' }}</a>
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Montant Tva</th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Montant TTC
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Liverables</th>
                                              <th class="text-secondary opacity-7">
                                              </th>

                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Rest à payer
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Rest à payer Tva
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Rest à payer TTC
                                              </th>
                                              
                                              <!-- <th
                                                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                      note</th>
                                                                                  <th
                                                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                      attachment</th> -->
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($projects as $project)
                                              <tr>
                                                  <td>
                                                      <div class="form-check">
                                                          <input type="checkbox" class="form-check-input"
                                                              id="customCheckDisabled" value="{{ $project->id }}">

                                                          <label class="custom-control-label"
                                                              for="customCheckDisabled"></label>
                                                      </div>
                                                  </td>
                                                  <td style="text-align:center;">
                                                      <form action="{{ route('projects.edit', $project) }}" method="GET">
                                                          <button type="submit" id="deleteBtn"
                                                              style="background: none; border: none; padding: 0; margin: 0; cursor: pointer; outline: none;"><i
                                                                  class="material-symbols-rounded opacity-5">edit</i></button>
                                                      </form>
                                                  </td>
                                                  <td>
                                                      <h6 class="mb-0 text-sm">{{ $project->nom }}
                                                      </h6>
                                                  </td>
                                                  <td>
                                                      <h6 class="align-middle text-center text-sm">
                                                          {{ $project->client->nom }}
                                                      </h6>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span
                                                          class="badge badge-sm bg-gradient-success">{{ $project->montant }}
                                                          DA</span>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span
                                                          class="badge badge-sm bg-gradient-secondary">{{ $project->montanttva }}
                                                          DA</span>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span
                                                          class="badge badge-sm bg-gradient-secondary">{{ $project->montantttc }}
                                                          DA</span>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      @php($i = 1)
                                                      @foreach ($project->entrees as $entree)
                                                          <h6 class="mb-0 text-sm">liverable {{ $i }}:
                                                              {{ $entree->valeur }} DA
                                                          </h6>
                                                          @php($i++)
                                                      @endforeach
                                                  </td>
                                                  <td class="align-middle">
                                                      <a href="{{ route('entrees.create') }}"
                                                          class="text-secondary font-weight-bold text-xs"
                                                          data-toggle="tooltip" data-original-title="Edit user">
                                                          Ajouter un liverable
                                                      </a>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span
                                                          class="badge badge-sm bg-gradient-secondary">{{ $project->rest }}
                                                          DA</span>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span
                                                          class="badge badge-sm bg-gradient-secondary">{{ $project->restTva }}
                                                          DA</span>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span
                                                          class="badge badge-sm bg-gradient-secondary">{{ $project->RestTTC }}
                                                          DA</span>
                                                  </td>

                                                  {{--
                                                                          <td class="align-middle text-center">
                                                                              <span
                                                                                  class="text-secondary text-xs font-weight-bold">{{ $project->note ?? 'no note' }}
                                                                              </span>
                                                                          </td>

                                                                          <td class="align-middle text-center">
                                                                              <span
                                                                                  class="text-secondary text-xs font-weight-bold">{{ $project->date }}
                                                                              </span>
                                                                          </td>
                                                                          @if ($project->attachment)
    <td class="align-middle text-center">
                                                                              <a href="{{ route('projects.download', $project->id) }}" class="text-secondary font-weight-bold text-xs">
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
    --}}
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
                      <a class="btn bg-gradient-dark mb-0" href="{{ route('projects.create') }}"><i
                              class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Crée un Project</a>
                  </div>
              </div>
          </div>
      </main>
  @endsection
