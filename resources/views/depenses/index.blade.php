  @extends('layout')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">
              <div class="row">
                  <div class="col-12">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                  <h6 class="text-white text-capitalize ps-3">Depenses table</h6>
                              </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                              <div class="table-responsive p-0">
                                  <table class="table align-items-center mb-0">
                                      <thead>
                                          <tr>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  nom
                                              </th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Décaissements</th>
                                              <th
                                                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  date
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($depenses as $depense)
                                              <tr>
                                                  <td>
                                                      <h6 class="mb-0 text-sm">{{ $depense->depensenom->nom ?? 'null' }}
                                                      </h6>
                                                  </td>
                                                  <td class="align-middle text-center text-sm">
                                                      <span class="badge badge-sm bg-gradient-secondary">{{ $depense->valeur }} DA</span>
                                                  </td>
                                                  
                                                  <td class="align-middle text-center">
                                                      <span
                                                          class="text-secondary text-xs font-weight-bold">{{ $depense->date }}
                                                      </span>
                                                  </td>
                                                  
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                        </div>
                        <a class="btn bg-gradient-dark mb-0" href="{{ route("depenses.create")}}"><i class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Crée une depense</a>
                  </div>
              </div>
          </div>
      </main>
  @endsection
