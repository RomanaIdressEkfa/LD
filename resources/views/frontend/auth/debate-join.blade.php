<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Debate - {{ $debate->title }}</title>
    
    <!-- Google Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* ------------------------------------------------------------------
           RESET & VARIABLES
           ------------------------------------------------------------------ */
        * { margin: 0; padding: 0; box-sizing: border-box; outline: none; }
        
        :root {
            --brand-primary: #D32F2F;
            --brand-gradient: linear-gradient(135deg, #C62828 0%, #B71C1C 100%);
            --text-main: #263238;
            --text-muted: #78909C;
            --bg-body: #ECEFF1;
            
            --side-agreed: #1976D2;
            --side-agreed-bg: #E3F2FD;
            --side-disagreed: #D32F2F;
            --side-disagreed-bg: #FFEBEE;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ------------------------------------------------------------------
           SPLIT LAYOUT CONTAINER
           ------------------------------------------------------------------ */
        .split-container {
            width: 100%;
            max-width: 1200px;
            min-height: 80vh; /* Taller card */
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            display: flex;
            overflow: hidden;
            margin: 20px;
        }

        /* LEFT SIDE - INFO & CONTEXT */
        .left-panel {
            flex: 1;
            background: var(--brand-gradient);
            color: white;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        /* Decoration Circle */
        .left-panel::before {
            content: ''; position: absolute; top: -50px; left: -50px;
            width: 200px; height: 200px; background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .debate-meta-label {
            font-size: 14px; text-transform: uppercase; letter-spacing: 2px;
            font-weight: 700; opacity: 0.8; margin-bottom: 15px;
        }

        .debate-title-large {
            font-size: 36px; font-weight: 900; line-height: 1.3; margin-bottom: 20px;
        }

        .debate-desc-large {
            font-size: 16px; line-height: 1.7; opacity: 0.9; font-weight: 300;
        }

        .back-home-btn {
            margin-top: 40px;
            display: inline-flex; align-items: center; gap: 10px;
            color: white; text-decoration: none; font-weight: 700;
            transition: transform 0.2s; width: fit-content;
        }
        .back-home-btn:hover { transform: translateX(-5px); }

        /* RIGHT SIDE - FORM */
        .right-panel {
            flex: 1.2; /* Slightly wider */
            padding: 60px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .form-header { margin-bottom: 30px; }
        .form-header h2 { font-size: 24px; color: var(--text-main); font-weight: 800; margin-bottom: 5px; }
        .form-header p { color: var(--text-muted); font-size: 14px; }

        /* Alerts */
        .alert-box {
            padding: 15px; border-radius: 8px; margin-bottom: 25px; font-size: 14px;
            display: flex; gap: 10px; align-items: start;
        }
        .alert-error { background: #FFEBEE; color: #C62828; border: 1px solid #FFCDD2; }
        .alert-info { background: #E3F2FD; color: #1565C0; border: 1px solid #BBDEFB; }

        /* Inputs */
        .input-group { margin-bottom: 20px; }
        .input-label { display: block; font-size: 13px; font-weight: 700; color: #546E7A; margin-bottom: 8px; text-transform: uppercase; }
        .input-field {
            width: 100%; padding: 14px 16px; border: 2px solid #ECEFF1;
            border-radius: 8px; font-size: 15px; transition: 0.2s;
            font-family: inherit;
        }
        .input-field:focus { border-color: var(--brand-primary); }

        /* Avatar */
        .avatar-wrapper { display: flex; align-items: center; gap: 15px; }
        .avatar-preview { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
        .file-label {
            padding: 8px 16px; background: #F5F5F5; border-radius: 6px;
            font-size: 13px; font-weight: 600; cursor: pointer; color: var(--text-main);
            transition: 0.2s;
        }
        .file-label:hover { background: #E0E0E0; }

        /* Side Selection Cards (Left/Right Grid) */
        .side-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 10px; }
        
        .side-card {
            position: relative;
        }
        .side-radio { display: none; }
        
        .side-box {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 25px 15px; border: 2px solid #ECEFF1; border-radius: 12px;
            cursor: pointer; transition: all 0.2s; height: 100%;
        }

        .side-icon { font-size: 32px; margin-bottom: 10px; color: var(--text-muted); }
        .side-title { font-weight: 800; font-size: 14px; color: var(--text-main); }

        /* Interactive States for Sides */
        .side-card:hover .side-box { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

        /* Agreed Active */
        .side-card.pro .side-radio:checked + .side-box {
            border-color: var(--side-agreed); background: var(--side-agreed-bg);
        }
        .side-card.pro .side-radio:checked + .side-box .side-icon,
        .side-card.pro .side-radio:checked + .side-box .side-title { color: var(--side-agreed); }

        /* Disagreed Active */
        .side-card.con .side-radio:checked + .side-box {
            border-color: var(--side-disagreed); background: var(--side-disagreed-bg);
        }
        .side-card.con .side-radio:checked + .side-box .side-icon,
        .side-card.con .side-radio:checked + .side-box .side-title { color: var(--side-disagreed); }

        /* Submit Button */
        .submit-btn {
            width: 100%; padding: 16px; background: var(--brand-primary);
            color: white; font-weight: 700; border: none; border-radius: 8px;
            font-size: 16px; margin-top: 30px; cursor: pointer;
            transition: background 0.2s;
        }
        .submit-btn:hover { background: #B71C1C; }

        .login-link { text-align: center; margin-top: 20px; font-size: 14px; color: var(--text-muted); }
        .login-link a { color: var(--brand-primary); font-weight: 700; }

        /* ------------------------------------------------------------------
           RESPONSIVE (Mobile Stack)
           ------------------------------------------------------------------ */
        @media (max-width: 900px) {
            .split-container {
                flex-direction: column;
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
            }
            .left-panel { padding: 40px 20px; flex: none; }
            .debate-title-large { font-size: 24px; }
            .right-panel { padding: 40px 20px; border-radius: 20px 20px 0 0; margin-top: -20px; }
        }
    </style>
</head>
<body>

<div class="split-container">
    
    <!-- LEFT PANEL: Info & Context -->
    <div class="left-panel">
        <div class="debate-meta-label">Currently Debating</div>
        <h1 class="debate-title-large">{{ $debate->title }}</h1>
        <p class="debate-desc-large">{{ Str::limit($debate->description, 200) }}</p>
        
        <a href="{{ route('home') }}" class="back-home-btn">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </div>

    <!-- RIGHT PANEL: Form -->
    <div class="right-panel">
        <div class="form-header">
            <h2>Join the Discussion</h2>
            <p>Select your stance and fill in your details to participate.</p>
        </div>

        <!-- Errors -->
        @if ($errors->any())
            <div class="alert-box alert-error">
                <i class="fas fa-exclamation-circle" style="margin-top:3px"></i>
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-box alert-error">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Logged In Alert -->
        @auth
            <div class="alert-box alert-info">
                <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" style="width: 30px; height: 30px; border-radius: 50%;">
                <div>
                    <div>Continuing as <strong>{{ Auth::user()->name }}</strong></div>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:#1565C0; font-size:12px; font-weight:700; cursor:pointer; text-decoration:underline; padding:0;">Not you? Logout</button>
                    </form>
                </div>
            </div>
        @endauth

        <form action="{{ route('debate.process_join', $debate->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Side Selection (Big Buttons) -->
            <div class="input-group">
                <label class="input-label">Choose Your Position</label>
                <div class="side-grid">
                    <!-- Agreed -->
                    <div class="side-card pro">
                        <input type="radio" name="side" value="pro" id="sidePro" class="side-radio" required>
                        <label for="sidePro" class="side-box">
                            <i class="fas fa-thumbs-up side-icon"></i>
                            <span class="side-title">AGREED</span>
                        </label>
                    </div>
                    <!-- Disagreed -->
                    <div class="side-card con">
                        <input type="radio" name="side" value="con" id="sideCon" class="side-radio" required>
                        <label for="sideCon" class="side-box">
                            <i class="fas fa-thumbs-down side-icon"></i>
                            <span class="side-title">DISAGREED</span>
                        </label>
                    </div>
                </div>
            </div>

            @if(!Auth::check())
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="input-group">
                        <label class="input-label">Full Name</label>
                        <input type="text" name="name" class="input-field" placeholder="John Doe" required>
                    </div>
                    <div class="input-group">
                        <label class="input-label">Email</label>
                        <input type="email" name="email" class="input-field" placeholder="email@example.com" required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Password</label>
                    <input type="password" name="password" class="input-field" placeholder="Create password" required>
                </div>

                <div class="input-group">
                    <label class="input-label">Profile Photo</label>
                    <div class="avatar-wrapper">
                        <img id="avatarPreview" src="https://ui-avatars.com/api/?name=User&background=ECEFF1&color=78909C" class="avatar-preview">
                        <input type="file" name="avatar" id="avatarInput" hidden accept="image/*">
                        <label for="avatarInput" class="file-label">Upload Image</label>
                    </div>
                </div>
            @endif

            <button type="submit" class="submit-btn">
                {{ Auth::check() ? 'Enter Debate' : 'Register & Join' }}
            </button>

            @if(!Auth::check())
                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Log In</a>
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    // Avatar Preview
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    if(avatarInput){
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { avatarPreview.src = e.target.result; };
                reader.readAsDataURL(file);
            }
        });
    }
</script>

</body>
</html>