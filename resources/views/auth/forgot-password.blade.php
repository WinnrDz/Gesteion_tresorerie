<x-guest-layout>



    <div class="page-header align-items-start min-vh-100"
        style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                    Reset password
                                </h4>

                                @if (!session('status'))
                                    <p class="text-light p-2">
                                        You will receive an e-mail in maximum 60 seconds
                                    </p>
                                @endif

                                <!-- Session Status -->
                                <x-auth-session-status class="text-light p-2" :status="session('status')" />
                            </div>

                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <input placeholder="Email" type="email" id="email" class="form-control"
                                        type="email" name="email" :value="old('email')" required autofocus>

                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Send</button>
                                </div>
                                <p class="mt-4 text-sm text-center">
                                    Don't have an account?
                                    <a href="{{ route('register') }}"
                                        class="text-primary text-gradient font-weight-bold">Sign up</a>
                                </p>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-guest-layout>
