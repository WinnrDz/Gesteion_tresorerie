  @extends('layout')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">
              <div class="row">
                  <div class="col-12">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                  <h6 class="text-white text-capitalize ps-3">créer un nom de dépense</h6>
                              </div>
                          </div>
                          <div class="card-body px-0 pb-2">
                              <div class="table-responsive p-0">
                                  <form action="{{ route('depensesNoms.store') }}" method="POST">
                                      @csrf
                                      <table class="table align-items-center mb-0">
                                          <thead>
                                              <tr>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Nom
                                                  </th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Type</th>
                                                  <th class="text-secondary opacity-7"></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td class="align-middle">
                                                      <input type="text" name="nom" class="form-control text-center"
                                                          placeholder="....">
                                                  </td>

                                                  <td class="input-group input-group-outline">
                                                      <select name="type" class="form-control">
                                                              <option value="fix">Fix</option>
                                                              <option value="variable">Variable</option>
                                                        </select>
                                                  </td>
                                                  
                                                  @if(url()->previous() == route('depenses.create'))
                                                    <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
                                                @endif


                                                  <td class="align-middle text-center">
                                                      <button type="submit" class="text-secondary font-weight-bold text-xs"
                                                          style="border: none; background: none">
                                                          Créer
                                                      </button>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </main>
  @endsection
