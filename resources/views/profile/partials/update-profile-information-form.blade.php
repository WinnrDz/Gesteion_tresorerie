<section>
    <!-- Header -->
    <div class="mb-4">
        <h5 class="fw-bold text-dark mb-1">
            Profile Information
        </h5>
        <p class="text-sm text-muted">
            Update your account profile information and email address.
        </p>
    </div>

    <!-- Email verification form (hidden trigger) -->
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Main form -->
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">
                Name
            </label>
            <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                placeholder="................................................................"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
            >
            @error('name')
                <div class="text-danger text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">
                Email
            </label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
            >
            @error('email')
                <div class="text-danger text-sm mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning py-2 mt-3">
                    <small>
                        Your email address is unverified.
                        <button
                            type="submit"
                            form="send-verification"
                            class="btn btn-link p-0 ms-1 align-baseline"
                        >
                            Re-send verification email
                        </button>
                    </small>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success py-2 mt-2">
                        <small>
                            A new verification link has been sent to your email.
                        </small>
                    </div>
                @endif
            @endif
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center gap-3 mt-4">
            <button type="submit" class="btn btn-primary">
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success text-sm">
                    ✔ Saved successfully
                </span>
            @endif
        </div>
    </form>
</section>
