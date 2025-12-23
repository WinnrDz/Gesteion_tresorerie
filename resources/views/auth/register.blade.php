 <x-guest-layout>
         <section>
             <div class="page-header min-vh-100">
                 <div class="container">
                     <div class="row">
                         <div
                             class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                             <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                                 style="background-image: url('../assets/img/illustrations/illustration-signup.jpg'); background-size: cover;">
                             </div>
                         </div>
                         <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                             <div class="card card-plain">
                                 <div class="card-header">
                                     <h4 class="font-weight-bolder">Sign Up</h4>
                                     <p class="mb-0">Enter your email and password to register</p>
                                 </div>
                                 <div class="card-body">
                                     <form role="form" method="POST" action="{{ route('register') }}">
                                         @csrf
                                         <div class="input-group input-group-outline mb-3">
                                             <input placeholder="Name" type="text" class="form-control" id="name" type="text"
                                                 name="name" :value="old('name')" required autofocus
                                                 autocomplete="name">
                                             <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                         </div>
                                         <div class="input-group input-group-outline mb-3">
                                             <input placeholder="Email" type="email" class="form-control" id="email" type="email"
                                                 name="email" :value="old('email')" required autocomplete="username">
                                             <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                         </div>
                                         <div class="input-group input-group-outline mb-3">
                                             <input placeholder="Password" type="password" class="form-control" id="password" type="password"
                                                 name="password" required autocomplete="new-password">
                                         </div>

                                         <div class="input-group input-group-outline mb-3">
                                             <input placeholder="Confirm Password" type="password" class="form-control" id="password_confirmation"
                                                 type="password" name="password_confirmation"
                                                 required autocomplete="new-password">
                                             <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                         </div>
                                         <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                         

                                         <div class="text-center">
                                             <button type="submit"
                                                 class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Sign
                                                 Up</button>
                                         </div>
                                     </form>
                                 </div>
                                 <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                     <p class="mb-2 text-sm mx-auto">
                                         Already have an account?
                                         <a href="{{ route('login') }}"
                                             class="text-primary text-gradient font-weight-bold">Sign in</a>
                                     </p>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
 </x-guest-layout>
