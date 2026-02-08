<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Debate - {{ $debate->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container { max-width: 500px; width: 100%; }
        .join-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 32px 24px;
            text-align: center;
        }
        .header-title { font-size: 28px; font-weight: 800; margin-bottom: 8px; }
        .header-subtitle { font-size: 15px; opacity: 0.95; }
        .card-body { padding: 32px 24px; }
        
        /* Alert Box for Logged In User */
        .user-status-alert {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.5;
        }
        .logout-link {
            color: #dc2626;
            font-weight: 700;
            text-decoration: underline;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            font-size: inherit;
        }

        .debate-info {
            background: #f0f2f5;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 28px;
        }
        .debate-title { font-size: 18px; font-weight: 700; color: #050505; margin-bottom: 8px; }
        .debate-description { font-size: 14px; color: #65676b; line-height: 1.6; }
        
        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-weight: 600; font-size: 14px; color: #050505; margin-bottom: 8px; }
        .form-input {
            width: 100%; padding: 12px 16px; border: 2px solid #e4e6eb;
            border-radius: 10px; font-size: 15px; font-family: inherit; transition: all 0.2s; outline: none;
        }
        .form-input:focus { border-color: #667eea; box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1); }
        
        .avatar-upload { display: flex; align-items: center; gap: 16px; }
        .avatar-preview {
            width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 3px solid #e4e6eb;
        }
        .file-input-wrapper { flex: 1; }
        .file-input { display: none; }
        .file-button {
            display: inline-block; padding: 10px 20px; background: #f0f2f5;
            border: 2px dashed #c5c7cc; border-radius: 8px; cursor: pointer;
            font-weight: 600; font-size: 14px; color: #65676b; transition: all 0.2s;
        }
        .file-button:hover { background: #e4e6eb; border-color: #667eea; color: #667eea; }
        
        .side-selection { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .side-option { position: relative; }
        .side-input { display: none; }
        .side-label {
            display: block; padding: 20px; border: 3px solid #e4e6eb; border-radius: 12px;
            text-align: center; cursor: pointer; transition: all 0.3s; font-weight: 700;
        }
        .side-label:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
        .side-input:checked + .side-label { border-width: 3px; }
        .side-option.pro .side-label { color: #2563eb; }
        .side-option.pro .side-input:checked + .side-label { background: #dbeafe; border-color: #2563eb; }
        .side-option.con .side-label { color: #dc2626; }
        .side-option.con .side-input:checked + .side-label { background: #fee2e2; border-color: #dc2626; }
        .side-icon { font-size: 32px; margin-bottom: 8px; }
        .side-name { display: block; font-size: 16px; margin-bottom: 4px; }
        .side-desc { font-size: 13px; opacity: 0.7; font-weight: 500; }
        
        .submit-btn {
            width: 100%; padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700;
            cursor: pointer; transition: all 0.3s; margin-top: 24px;
        }
        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4); }
        .back-link {
            display: block; text-align: center; margin-top: 16px; color: #65676b;
            font-size: 14px; text-decoration: none; font-weight: 600;
        }
        .back-link:hover { color: #667eea; }
        
        /* Hidden class */
        .d-none { display: none !important; }
    </style>
</head>
<body>

<div class="container">
    <div class="join-card">
        <div class="card-header">
            <h1 class="header-title">Join the Debate</h1>
            <p class="header-subtitle">Choose your side and start sharing your thoughts</p>
        </div>

        <div class="card-body">
            <!-- ERROR MESSAGE -->
              @if ($errors->any())
                    <div class="alert" style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
                        <ul style="margin-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @if(session('error'))
                <div class="alert" style="background: #fee2e2; color: #991b1b;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- LOGGED IN ALERT (Solution for your problem) -->
            @auth
                <div class="user-status-alert">
                    <i class="fas fa-info-circle"></i>
                    You are currently logged in as <strong>{{ Auth::user()->name }}</strong>.
                    <br><br>
                    If you want to join as a <strong>New User</strong>, please 
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-link">Logout First</button>
                    </form>.
                </div>
            @endauth

            <div class="debate-info">
                <div class="debate-title">{{ $debate->title }}</div>
                <div class="debate-description">{{ Str::limit($debate->description, 100) }}</div>
            </div>

          <form action="{{ route('debate.process_join', $debate->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if(!Auth::check())
        <!-- Name Input -->
        <div class="form-group">
            <label class="form-label"><i class="fas fa-user"></i> Your Name</label>
            <input type="text" name="name" class="form-input" placeholder="Enter your full name" required>
        </div>

        <!-- Email Input (NEW) -->
        <div class="form-group">
            <label class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" name="email" class="form-input" placeholder="Enter your email (for login)" required>
            <small style="color: #666; font-size: 12px;">You will use this email to login later.</small>
        </div>

        <!-- Password Input (NEW) -->
        <div class="form-group">
            <label class="form-label"><i class="fas fa-lock"></i> Set Password</label>
            <input type="password" name="password" class="form-input" placeholder="Choose a secure password" required>
        </div>

        <!-- Avatar Upload -->
        <div class="form-group">
            <label class="form-label"><i class="fas fa-camera"></i> Profile Picture (Optional)</label>
            <div class="avatar-upload">
                <img id="avatarPreview" src="https://ui-avatars.com/api/?name=User&background=667eea&color=fff" class="avatar-preview">
                <div class="file-input-wrapper">
                    <input type="file" name="avatar" id="avatarInput" class="file-input" accept="image/*">
                    <label for="avatarInput" class="file-button"><i class="fas fa-upload"></i> Choose Photo</label>
                </div>
            </div>
        </div>
    @else
        <!-- Logged In User View -->
        <div class="form-group">
            <label class="form-label">Joining as:</label>
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid #e4e6eb; border-radius: 8px;">
                <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" style="width: 30px; height: 30px; border-radius: 50%;">
                <span style="font-weight: 600;">{{ Auth::user()->name }}</span>
            </div>
        </div>
    @endif

    <!-- Side Selection -->
    <div class="form-group">
        <label class="form-label"><i class="fas fa-balance-scale"></i> Choose Your Position</label>
        <div class="side-selection">
            <div class="side-option pro">
                <input type="radio" name="side" value="pro" id="sidePro" class="side-input" required>
                <label for="sidePro" class="side-label">
                    <div class="side-icon"><i class="fas fa-thumbs-up"></i></div>
                    <span class="side-name">AGREED</span>
                    <span class="side-desc">Support this position</span>
                </label>
            </div>

            <div class="side-option con">
                <input type="radio" name="side" value="con" id="sideCon" class="side-input" required>
                <label for="sideCon" class="side-label">
                    <div class="side-icon"><i class="fas fa-thumbs-down"></i></div>
                    <span class="side-name">DISAGREED</span>
                    <span class="side-desc">Oppose this position</span>
                </label>
            </div>
        </div>
    </div>

    <button type="submit" class="submit-btn">
        <i class="fas fa-sign-in-alt"></i> 
        {{ Auth::check() ? 'Join Discussion' : 'Register & Join' }}
    </button>
    
    @if(!Auth::check())
    <div style="text-align: center; margin-top: 15px;">
        <span style="font-size: 14px;">Already have an account? <a href="{{ route('login') }}" style="color: #667eea; font-weight: bold;">Login here</a></span>
    </div>
    @endif
</form>

            <a href="{{ route('home') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Debate</a>
        </div>
    </div>
</div>

<script>
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