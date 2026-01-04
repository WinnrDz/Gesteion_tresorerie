  @extends('layouts.app')

  @section('content')
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
          <div class="container-fluid py-2">
              <div class="row">
                  <div class="col-12">
                      <form action="{{ route('clients.store') }}" method="POST">
                      <div class="card my-4">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                  <h6 class="text-white text-capitalize ps-3">Crée un client</h6>
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
                                                      Nom
                                                  </th> 
                                                  <th class="text-secondary opacity-7"></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                 <td class="align-middle">
                                                      <input type="text" name="nom" class="input-group input-group-outline"
                                                          placeholder="nom" style="outline: none;">
                                                  </td>
                                              </tr>
                                              @if(url()->previous() == route('projects.create'))
                                                <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
                                            @endif


                                          </tbody>
                                      </table>

                                      
                                    </div>
                                </div>
                            </div>
                            <button class="btn bg-gradient-dark mb-0" type="submit"><i class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Crée</button>
                      </form>
                  </div>
              </div>
          </div>
      </main>
  @endsection
