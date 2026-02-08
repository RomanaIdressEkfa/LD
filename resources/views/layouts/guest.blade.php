<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Logically Debate') }}</title>
    <link rel="icon" href="https://i.ibb.co.com/s916M5xG/Logo-01.png" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .logo-area {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-area img {
            height: 50px; /* লোগোর সাইজ */
            width: auto;
        }

        .auth-card {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-text h2 {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            margin: 0 0 8px 0;
        }

        .welcome-text p {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.2s;
            outline: none;
            color: #1f2937;
        }

        .form-input:focus {
            border-color: #dc2626; /* ব্র্যান্ড কালার (লাল) */
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4b5563;
            cursor: pointer;
        }

        .forgot-link {
            color: #dc2626; /* ব্র্যান্ড কালার */
            font-weight: 600;
            text-decoration: none;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            /* Join Page এর মত গ্রেডিয়েন্ট বাটন, অথবা লোগোর লাল কালার */
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); 
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.3);
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #6b7280;
        }

        .register-link {
            color: #dc2626;
            font-weight: 700;
            text-decoration: none;
        }
        
        .register-link:hover {
            text-decoration: underline;
        }

        /* Error Message Style */
        .error-msg {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo -->
        <div class="logo-area">
            <a href="/">
                <img src="https://i.ibb.co.com/gbLB6Dqj/Logo-02.png" alt="Logically Debate">
            </a>
        </div>

        <!-- Card Content -->
        <div class="auth-card">
            {{ $slot }}
        </div>

        <div style="text-align: center; margin-top: 30px; color: #9ca3af; font-size: 12px;">
            &copy; {{ date('Y') }} Logically Debate. All rights reserved.
        </div>
    </div>
</body>
</html>