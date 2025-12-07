  @extends('layout')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">
              <div class="row">
                  <div class="col-12">
                      <form action="{{ route('entrees.store') }}" method="POST" enctype="multipart/form-data">
                          <div class="card my-4">
                              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                  <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                      <h6 class="text-white text-capitalize ps-3">Crée une Entrée</h6>
                                  </div>
                              </div>
                              <div class="card-body px-0 pb-2">
                                  <div class="table-responsive p-0">
                                      @csrf
                                      <table class="table align-items-center mb-0">
                                          <thead>
                                              <tr>
                                                  <th
                                                      class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Type
                                                  </th>
                                                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                      id="clientth">
                                                      Project
                                                  </th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Entree</th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      note</th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      date
                                                  </th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      attachment</th>

                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td class="align-middle" id="typetd">
                                                      <div class="input-group input-group-outline">
                                                          <select name="type" class="form-control"
                                                              onchange="toggleClientDropdown(this.value)">
                                                              <option value="project">Project</option>
                                                              <option value="autre">Autre</option>
                                                          </select>
                                                      </div>
                                                  </td>

                                                  <td class="align-middle" id="clienttd">
                                                      <div class="input-group input-group-outline">
                                                          <select name="project_id" class="form-control">
                                                              @foreach ($projects as $project)
                                                                  <option value="{{ $project->id }}">
                                                                      {{ $project->nom }}</option>
                                                              @endforeach
                                                          </select>
                                                          <div class="align-middle"
                                                              style="align-self: center; padding-left: 10px"><a
                                                                  href="{{ route('projects.create') }}"
                                                                  class=" text-secondary font-weight-bold text-xs"> Ajouter
                                                                  un project</a></div>
                                                      </div>
                                                  </td>

                                                  <td class="align-middle text-center">
                                                      <input type="text" name="valeur" class="form-control text-center"
                                                          placeholder="Valeur">
                                                  </td>
                                                  <td class="align-middle text-center">
                                                      <input type="text" name="note" class="form-control text-center"
                                                          placeholder="...">
                                                  </td>

                                                  <td class="align-middle text-center">
                                                      <input type="date" name="date" class="form-control text-center">
                                                  </td>

                                                  <td class="align-middle text-center">
                                                      <input type="file" name="attachment"
                                                          placeholder="...">
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <button class="btn bg-gradient-dark mb-0" type="submit"><i
                                  class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Crée</button>
                      </form>
                  </div>
              </div>
          </div>
      </main>
  @endsection
