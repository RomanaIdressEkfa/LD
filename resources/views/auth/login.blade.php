<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="welcome-text">
        <h2>Welcome Back!</h2>
        <p>Please enter your details to sign in.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" 
                   class="form-input" 
                   value="{{ old('email') }}" 
                   placeholder="Enter your email" 
                   required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="error-msg" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" 
                   class="form-input" 
                   placeholder="Enter your password" 
                   required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="error-msg" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="options-row">
            <label for="remember_me" class="remember-me">
                <input id="remember_me" type="checkbox" name="remember" 
                       style="width: 16px; height: 16px; accent-color: #dc2626;">
                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button type="submit" class="submit-btn">
            Log In
        </button>

        <!-- Register Link -->
        <div class="footer-text">
            Don't have an account? 
            <a href="{{ route('register') }}" class="register-link">Register Now</a>
        </div>
    </form>
</x-guest-layout>