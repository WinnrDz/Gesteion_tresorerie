  @extends('layouts.app')

  @section('content')
      <div class="main-content position-relative max-height-vh-100 h-100">
          <div class="container-fluid px-2 px-md-4">
              <div class="page-header min-height-300 border-radius-xl mt-4"
                  style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                  <span class="mask  bg-gradient-dark  opacity-6"></span>
              </div>
              <div class="card card-body mx-2 mx-md-2 mt-n6">
                  <div class="row gx-4 mb-2">
                      <div class="col-auto">
                          <div class="avatar avatar-xl position-relative">
                              <img src="../assets/img/default.jpg" alt="profile_image"
                                  class="w-100 border-radius-lg shadow-sm">
                          </div>
                      </div>
                      <div class="col-auto my-auto">
                          <div class="h-100">
                              <h5 class="mb-1">
                                  {{ $user->name }}
                              </h5>
                              <p class="mb-0 font-weight-normal text-sm">
                                  User
                              </p>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="row">
                          <div class="col-12 mt-4">
                              <div class="card card-plain h-100">
                                  <div class="card-header pb-0 p-3">
                                      <div class="row">
                                          <div class="card-body p-3">
                                              <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                                  <div class="max-w-xl">
                                                      @include('profile.partials.update-profile-information-form')
                                                  </div>
                                              </div>

                                              <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                                  <div class="max-w-xl">
                                                      @include('profile.partials.update-password-form')
                                                  </div>
                                              </div>

                                              <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                                  <div class="max-w-xl">
                                                      @include('profile.partials.delete-user-form')
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                              </div>
                          </div>
                      </div>
                  </div>
                  
              </div>

















          @endsection
