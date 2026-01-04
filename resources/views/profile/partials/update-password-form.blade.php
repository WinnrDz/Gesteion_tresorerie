<section>
    <!-- Header -->
    <div class="mb-4">
        <h5 class="fw-bold text-dark mb-1">
            Update Password
        </h5>
        <p class="text-sm text-muted">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </div>

    <!-- Password Update Form -->
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-semibold">
                Current Password
            </label>
            <input
                type="password"
                class="form-control"
                id="update_password_current_password"
                name="current_password"
                autocomplete="current-password"
                placeholder="................................................................"
            >
            @error('current_password')
                <div class="text-danger text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-semibold">
                New Password
            </label>
            <input
                type="password"
                class="form-control"
                id="update_password_password"
                name="password"
                autocomplete="new-password"
                placeholder="................................................................"
            >
            @error('password')
                <div class="text-danger text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label fw-semibold">
                Confirm Password
            </label>
            <input
                type="password"
                class="form-control"
                id="update_password_password_confirmation"
                name="password_confirmation"
                autocomplete="new-password"
                placeholder="................................................................"
            >
            @error('password_confirmation')
                <div class="text-danger text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center gap-3 mt-4">
            <button type="submit" class="btn btn-primary">
                Save Changes
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success text-sm">
                    ✔ Password updated successfully
                </span>
            @endif
        </div>
    </form>
</section>
