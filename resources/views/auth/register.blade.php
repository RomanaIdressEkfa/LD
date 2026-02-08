<x-guest-layout>
    <!-- Header Text -->
    <div class="welcome-text">
        <h2>Create Account</h2>
        <p>Join the discussion and start debating today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Full Name</label>
            <input id="name" class="form-input" type="text" name="name" 
                   value="{{ old('name') }}" 
                   placeholder="Enter your full name"
                   required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="error-msg" />
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" class="form-input" type="email" name="email" 
                   value="{{ old('email') }}" 
                   placeholder="Enter your email"
                   required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="error-msg" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" 
                   placeholder="Choose a strong password"
                   required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="error-msg" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" class="form-input" type="password" 
                   name="password_confirmation" 
                   placeholder="Re-type your password"
                   required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="error-msg" />
        </div>

        <!-- Register Button -->
        <button type="submit" class="submit-btn">
            Register
        </button>

        <!-- Login Link -->
        <div class="footer-text">
            Already have an account?
            <a href="{{ route('login') }}" class="register-link">
                Log in here
            </a>
        </div>
    </form>
</x-guest-layout>