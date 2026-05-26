  @extends('layouts.app')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">
              <div class="row">
                  <div class="col-12">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                  <h6 class="text-white text-capitalize ps-3">Candidates table</h6>
                              </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                              <div class="table-responsive p-0" id="goofy-table">
                                  <table class="table align-items-center mb-0">
                                      <thead>
                                          <tr class="bg-primary" style="display: none;" id="selectedRow">
                                              <th colspan="9">
                                                  <div class="d-flex justify-content-between align-items-center px-3 pe-5">
                                                      <label class="text-uppercase text-light font-weight-bolder fs-5">5
                                                          Selected</label>
                                                      <form action="{{ route('candidates.deleteMulti') }}" method="POST"
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
                                                  Prénom
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Nom
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Pipeline
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  <a href="{{ request('sort') == 'asc' ? '?sort=desc' : '?sort=asc' }}">Notation
                                                      {{ request('sort') == 'asc' ? '▲' : '' }}
                                                      {{ request('sort') == 'desc' ? '▼' : '' }}</a>
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Compétences
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Profils
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">

                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($candidates as $candidate)
                                              <tr>
                                                  <td>
                                                      <div class="form-check">
                                                          <input type="checkbox" class="form-check-input"
                                                              id="customCheckDisabled" value="{{ $candidate->id }}">

                                                          <label class="custom-control-label"
                                                              for="customCheckDisabled"></label>
                                                      </div>
                                                  </td>
                                                  <td style="text-align:center;">
                                                      <form action="{{ route('candidates.edit', $candidate) }}" method="GET">
                                                          <button type="submit" id="deleteBtn"
                                                              style="background: none; border: none; padding: 0; margin: 0; cursor: pointer; outline: none;"><i
                                                                  class="material-symbols-rounded opacity-5">edit</i></button>
                                                      </form>
                                                  </td>
                                                  <td>
                                                      <span class="text-xs font-weight-bold">{{ $candidate->first_name }}
                                                      </span>
                                                  </td>
                                                  <td>
                                                      <span class="text-xs font-weight-bold">{{ $candidate->last_name }}
                                                      </span>
                                                  </td>
                                                  <td>
                                                      <i class="bg-info"></i>
                                                      <span
                                                          class="text-xs font-weight-bold">{{ $candidate->recruitment_pipeline }}
                                                      </span>
                                                  </td>
                                                  <td>
                                                      <span class="text-xs font-weight-bold">{{ $candidate->notation }}
                                                      </span>
                                                  </td>
                                                  <td>
                                                      @foreach ($candidate->skills as $skill)
                                                          <li><a
                                                                  href="{{ route('candidates.index', ['skill' => $skill->id]) }}">{{ $skill->name }}</a>
                                                          </li>
                                                      @endforeach
                                                  </td>
                                                  <td>
                                                      @foreach ($candidate->profilecvs as $profile)
                                                          <li><a
                                                                  href="{{ route('candidates.index', ['profile' => $profile->id]) }}">{{ $profile->name }}</a>
                                                          </li>
                                                      @endforeach
                                                  </td>


                                                  <td>
                                                      <a href="{{ route('candidates.show', $candidate->id) }}"
                                                          class="text-xs font-weight-bold">Afficher plus
                                                      </a>
                                                  </td>

                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                      <a class="btn bg-gradient-dark mb-0" href="{{ route('candidates.create') }}"><i
                              class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Ajouter un candidate</a>
                  </div>
              </div>
          </div>
      </main>
  @endsection
