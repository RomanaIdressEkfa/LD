<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $debate ? $debate->title : 'Logically Debate' }}</title>
    <link rel="icon" href="https://i.ibb.co.com/s916M5xG/Logo-01.png" type="image/png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #2563eb;
            --primary-red: #dc2626;
            --bg-primary: #f0f2f5;
            --bg-secondary: #ffffff;
            --text-primary: #050505;
            --text-secondary: #65676b;
            --border-color: #e4e6eb;
            --hover-bg: #f2f3f5;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.06);
            --shadow-md: 0 2px 8px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 16px rgba(0,0,0,0.12);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            padding-top: 60px;
        }

        /* Top Navigation Bar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 0 20px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-nav {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-name-nav {
            font-weight: 600;
            font-size: 15px;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px 16px;
            display: grid;
            grid-template-columns: 1fr 680px 1fr;
            gap: 24px;
        }

        /* Left Sidebar */
        .left-sidebar {
            position: sticky;
            top: 84px;
            height: fit-content;
        }

        .sidebar-card {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 16px;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--text-primary);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 16px;
            border-radius: 10px;
            color: white;
            text-align: center;
        }

        .stat-box.blue {
            background: linear-gradient(135deg, var(--primary-blue), #3b82f6);
        }

        .stat-box.red {
            background: linear-gradient(135deg, var(--primary-red), #ef4444);
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
            display: block;
        }

        .stat-label {
            font-size: 13px;
            opacity: 0.95;
            margin-top: 4px;
        }

        /* Center Feed */
        .center-feed {
            max-width: 680px;
        }

        /* Post Card */
        .post-card {
            background: var(--bg-secondary);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
            overflow: hidden;
            transition: box-shadow 0.3s;
        }

        .post-card:hover {
            box-shadow: var(--shadow-md);
        }

        .post-header {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .post-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--border-color);
        }

        .post-author-info {
            flex: 1;
        }

        .author-name {
            font-weight: 700;
            font-size: 16px;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .post-time {
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .post-content {
            padding: 0 20px 16px 20px;
        }

        .post-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .post-description {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .post-stats {
            padding: 14px 20px;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 15px;
            color: var(--text-secondary);
        }

        .reactions-summary {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reaction-icons {
            display: flex;
            align-items: center;
        }

        .reaction-bubble {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid var(--bg-secondary);
            margin-left: -6px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .reaction-bubble:first-child {
            margin-left: 0;
        }

        .bubble-agreed {
            background: var(--primary-blue);
            color: white;
        }

        .bubble-disagreed {
            background: var(--primary-red);
            color: white;
        }

        /* Comment Input */
        .comment-input-section {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .input-group {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .input-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .input-wrapper {
            flex: 1;
        }

        .comment-textarea {
            width: 100%;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 10px 16px;
            font-size: 15px;
            font-family: inherit;
            resize: none;
            outline: none;
            min-height: 40px;
            max-height: 120px;
            transition: all 0.2s;
        }

        .comment-textarea:focus {
            background: var(--bg-secondary);
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .position-buttons-wrapper {
            margin-top: 12px;
            display: none;
            gap: 10px;
        }

        .position-buttons-wrapper.active {
            display: flex;
        }

        .position-btn {
            flex: 1;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-agreed {
            background: var(--primary-blue);
            color: white;
        }

        .btn-agreed:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-disagreed {
            background: var(--primary-red);
            color: white;
        }

        .btn-disagreed:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .join-prompt {
            text-align: center;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .join-prompt:hover {
            transform: scale(1.02);
        }

        .join-prompt-text {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .join-btn {
            background: white;
            color: #667eea;
            padding: 10px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            font-size: 15px;
        }

        /* Comments Section */
        .comments-section {
            padding: 20px;
        }

        .comments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .comments-count {
            font-weight: 700;
            font-size: 18px;
            color: var(--text-primary);
        }

        .filter-tabs {
            display: flex;
            gap: 16px;
            font-size: 14px;
        }

        .filter-tab {
            color: var(--text-secondary);
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .filter-tab:hover {
            background: var(--hover-bg);
        }

        .filter-tab.active {
            color: var(--primary-blue);
            background: rgba(37, 99, 235, 0.1);
        }

        /* Comment Item */
        .comment-thread {
            margin-bottom: 16px;
        }

        .comment-wrapper {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }

        .comment-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .comment-content-wrapper {
            flex: 1;
            min-width: 0;
        }

        .comment-bubble {
            background: var(--bg-primary);
            border-radius: 18px;
            padding: 10px 14px;
            display: inline-block;
            max-width: 100%;
            word-wrap: break-word;
        }

        .comment-author {
            font-weight: 700;
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .side-badge {
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-agreed {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-disagreed {
            background: #fee2e2;
            color: #991b1b;
        }

        .comment-text {
            font-size: 15px;
            color: var(--text-primary);
            line-height: 1.5;
        }

        .comment-meta {
            display: flex;
            gap: 16px;
            margin-top: 4px;
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 600;
            padding-left: 14px;
        }

        .comment-action {
            cursor: pointer;
            transition: color 0.2s;
        }

        .comment-action:hover {
            color: var(--text-primary);
            text-decoration: underline;
        }

        .comment-time {
            color: var(--text-secondary);
        }

        /* Nested Replies */
        .replies-container {
            margin-left: 46px;
            margin-top: 8px;
            padding-left: 16px;
            border-left: 2px solid var(--border-color);
        }

        .reply-wrapper {
            margin-bottom: 8px;
        }

        .collapse-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: 46px;
            margin-top: 8px;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 6px;
            width: fit-content;
            transition: background 0.2s;
        }

        .collapse-toggle:hover {
            background: var(--hover-bg);
        }

        .collapse-toggle i {
            font-size: 11px;
            transition: transform 0.3s;
        }

        .collapse-toggle.collapsed i {
            transform: rotate(-90deg);
        }

        /* Reply Input */
        .reply-input-container {
            margin-left: 46px;
            margin-top: 8px;
            display: none;
        }

        .reply-input-container.active {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .reply-textarea {
            flex: 1;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 8px 14px;
            font-size: 14px;
            font-family: inherit;
            resize: none;
            outline: none;
            min-height: 36px;
            transition: all 0.2s;
        }

        .reply-textarea:focus {
            background: var(--bg-secondary);
            border-color: var(--primary-blue);
        }

        .reply-action-buttons {
            display: none;
            gap: 8px;
            margin-top: 8px;
        }

        .reply-action-buttons.active {
            display: flex;
        }

        .reply-btn {
            padding: 6px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Right Sidebar */
        .right-sidebar {
            position: sticky;
            top: 84px;
            height: fit-content;
        }

        .participants-list {
            margin-top: 16px;
        }

        .participant-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: background 0.2s;
        }

        .participant-item:hover {
            background: var(--hover-bg);
        }

        .participant-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .participant-info {
            flex: 1;
        }

        .participant-name {
            font-weight: 600;
            font-size: 14px;
        }

        .participant-side {
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        .empty-state-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .empty-state-text {
            font-size: 15px;
        }

        /* Utilities */
        .hidden {
            display: none !important;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .comment-thread {
            animation: fadeInUp 0.4s ease;
        }

        /* Alert Messages */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert i {
            font-size: 18px;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-container {
                grid-template-columns: 1fr;
                max-width: 680px;
            }

            .left-sidebar,
            .right-sidebar {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 12px 8px;
            }

            .post-card,
            .comments-section {
                border-radius: 0;
            }

            .post-title {
                font-size: 20px;
            }

            .navbar-brand {
                font-size: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .replies-container {
                margin-left: 20px;
                padding-left: 12px;
            }

            .collapse-toggle,
            .reply-input-container {
                margin-left: 20px;
            }
        }
    </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar">
    <div class="sidebar-brand">
        <!-- Logo -->
        <a href="{{ route('home') }}">
            <img src="https://i.ibb.co.com/gbLB6Dqj/Logo-02.png" alt="Logically Debate">
        </a>
    </div>
    <style>
        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 25px;
        }
        
        .sidebar-brand img {
            max-height: 28px;
            width: auto;
        }
         @media (max-width: 991.98px) {
            .sidebar-brand {
                justify-content: center;
            }
        }
    </style>
    @auth
        <div class="navbar-user">
            <span class="user-name-nav">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                 alt="{{ Auth::user()->name }}" 
                 class="user-avatar-nav">
        </div>
    @else
        <div class="navbar-user">
            <span class="user-name-nav">Guest</span>
        </div>
    @endauth
</nav>

<!-- Main Container -->
<div class="main-container">
    
    <!-- Left Sidebar -->
    <aside class="left-sidebar">
        @if($debate)
        <div class="sidebar-card">
            <div class="sidebar-title">Debate Statistics</div>
            <div class="stats-grid">
                <div class="stat-box blue">
                    <span class="stat-number">{{ $debate->participants->where('side', 'pro')->count() }}</span>
                    <span class="stat-label">AGREED</span>
                </div>
                <div class="stat-box red">
                    <span class="stat-number">{{ $debate->participants->where('side', 'con')->count() }}</span>
                    <span class="stat-label">DISAGREED</span>
                </div>
            </div>
        </div>

        <div class="sidebar-card">
            <div class="sidebar-title">Total Engagement</div>
            <div class="stats-grid">
                <div class="stat-box" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <span class="stat-number">{{ $debate->participants->count() }}</span>
                    <span class="stat-label">Participants</span>
                </div>
                <div class="stat-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <span class="stat-number">{{ $debate->arguments->count() }}</span>
                    <span class="stat-label">Comments</span>
                </div>
            </div>
        </div>
        @endif
    </aside>

    <!-- Center Feed -->
    <main class="center-feed">
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($debate)
            <!-- Main Post -->
            <article class="post-card">
                <div class="post-header">
                    <img src="https://ui-avatars.com/api/?name=Debate+Host&background=667eea&color=fff" 
                         alt="Debate Host" 
                         class="post-avatar">
                    <div class="post-author-info">
                        <div class="author-name">Debate Host</div>
                        <div class="post-time">
                            <span>{{ $debate->created_at->diffForHumans() }}</span>
                            <span>·</span>
                            <i class="fas fa-globe-americas"></i>
                        </div>
                    </div>
                    <button style="background: transparent; border: none; cursor: pointer; padding: 8px; color: var(--text-secondary); font-size: 18px;">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>

                <div class="post-content">
                    <h1 class="post-title">{{ $debate->title }}</h1>
                    <p class="post-description">{{ $debate->description }}</p>
                </div>

               {{-- এই অংশটি রিপ্লেস করুন (Replace this section) --}}
                <div class="post-stats">
                    <div class="reactions-summary">
                        {{-- AGREED BUTTON FORM --}}
                        <form action="{{ route('debate.join', $debate->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="side" value="pro">
                            <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 6px; padding: 0;">
                                <div class="reaction-bubble bubble-agreed" style="transition: transform 0.2s;">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                                <span style="font-weight: 600; color: {{ $userSide == 'pro' ? 'var(--primary-blue)' : 'var(--text-secondary)' }}">
                                    {{ $debate->participants->where('side', 'pro')->count() }} Agreed
                                </span>
                            </button>
                        </form>
                        
                        <span style="margin: 0 8px;">·</span>

                        {{-- DISAGREED BUTTON FORM --}}
                        <form action="{{ route('debate.join', $debate->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="side" value="con">
                            <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 6px; padding: 0;">
                                <div class="reaction-bubble bubble-disagreed" style="transition: transform 0.2s;">
                                    <i class="fas fa-thumbs-down"></i>
                                </div>
                                <span style="font-weight: 600; color: {{ $userSide == 'con' ? 'var(--primary-red)' : 'var(--text-secondary)' }}">
                                    {{ $debate->participants->where('side', 'con')->count() }} Disagreed
                                </span>
                            </button>
                        </form>
                    </div>

                    {{-- Comment Count Display --}}
                    <div>
                        <span>{{ $debate->arguments->count() }} Comments</span>
                    </div>
                </div>

                {{-- Optional: Add a Visual "Action Bar" below stats just like Facebook --}}
                <div style="display: flex; border-top: 1px solid var(--border-color); margin: 0 20px; padding: 4px 0;">
                    <form action="{{ route('debate.join', $debate->id) }}" method="POST" style="flex: 1;">
                        @csrf <input type="hidden" name="side" value="pro">
                        <button class="action-btn {{ $userSide == 'pro' ? 'active-blue' : '' }}">
                            <i class="far fa-thumbs-up"></i> Agreed
                        </button>
                    </form>
                    
                    <form action="{{ route('debate.join', $debate->id) }}" method="POST" style="flex: 1;">
                        @csrf <input type="hidden" name="side" value="con">
                        <button class="action-btn {{ $userSide == 'con' ? 'active-red' : '' }}">
                            <i class="far fa-thumbs-down"></i> Disagreed
                        </button>
                    </form>
                    
                    <button class="action-btn" onclick="document.getElementById('mainCommentInput').focus()">
                        <i class="far fa-comment-alt"></i> Comment
                    </button>
                </div>

                {{-- Add this CSS in your <style> section or here --}}
                <style>
                    .action-btn {
                        width: 100%;
                        background: transparent;
                        border: none;
                        padding: 12px;
                        font-weight: 600;
                        color: var(--text-secondary);
                        cursor: pointer;
                        border-radius: 6px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 8px;
                        font-size: 14px;
                        transition: background 0.2s;
                    }
                    .action-btn:hover { background: var(--hover-bg); }
                    .action-btn.active-blue { color: var(--primary-blue); }
                    .action-btn.active-red { color: var(--primary-red); }
                </style>

                <!-- Comment Input Section -->
<div class="comment-input-section" id="disqus-card">
    @if(Auth::check() && $userSide)
        <!-- User has joined - can comment -->
        <form action="{{ route('argument.store', $debate->id) }}" method="POST">
            @csrf
            
            {{-- 
                IMPORTANT: 
                I have removed the <input type="hidden" name="side"> line.
                The buttons below will now pass the 'side' value.
            --}}
            
            <div class="input-group">
                <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="input-avatar">
                
                <div class="input-wrapper">
                    <textarea class="comment-textarea" 
                              name="body" 
                              id="mainCommentInput"
                              placeholder="Share your thoughts on this debate..."
                              required></textarea>
                    
                    <div class="position-buttons-wrapper" id="mainPositionButtons">
                        {{-- Button 1: AGREED --}}
                        <button type="submit" name="side" value="pro" class="position-btn btn-agreed">
                            <i class="fas fa-thumbs-up"></i> Post as AGREED
                        </button>

                        {{-- Button 2: DISAGREED --}}
                        <button type="submit" name="side" value="con" class="position-btn btn-disagreed">
                            <i class="fas fa-thumbs-down"></i> Post as DISAGREED
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @else
        <!-- User needs to join (Existing code...) -->
        <div class="join-prompt" onclick="window.location='{{ route('debate.join_form', $debate->id) }}'">
            <div class="join-prompt-text">
                <i class="fas fa-user-plus"></i> Join the discussion
            </div>
            <p style="font-size: 13px; opacity: 0.9; margin-bottom: 8px;">
                Choose your side and start debating
            </p>
            <button class="join-btn">
                <i class="fas fa-sign-in-alt"></i> Join Now
            </button>
        </div>
    @endif
</div>

                <!-- Comments Section -->
                <div class="comments-section">
                    <div class="comments-header">
                        <div class="comments-count">
                            All Comments ({{ $roots->count() }})
                        </div>
                        <div class="filter-tabs">
                            <div class="filter-tab active">Most Relevant</div>
                            <div class="filter-tab">Newest</div>
                        </div>
                    </div>

                    @if($roots->count() > 0)
                        @foreach($roots as $argument)
                            @include('frontend.partials.comment_tree', ['argument' => $argument, 'debate' => $debate, 'userSide' => $userSide])
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <div class="empty-state-title">No comments yet</div>
                            <div class="empty-state-text">Be the first to share your thoughts!</div>
                        </div>
                    @endif
                </div>
            </article>
        @else
            <!-- No Active Debate -->
            <div class="post-card">
                <div class="empty-state" style="padding: 100px 20px;">
                    <i class="fas fa-inbox"></i>
                    <div class="empty-state-title">No Active Debate</div>
                    <div class="empty-state-text">Check back soon for new debates!</div>
                </div>
            </div>
        @endif
    </main>

    <!-- Right Sidebar -->
    <aside class="right-sidebar">
        @if($debate)
        <div class="sidebar-card">
            <div class="sidebar-title">
                <i class="fas fa-users"></i> Participants ({{ $debate->participants->count() }})
            </div>
            <div class="participants-list">
                @foreach($debate->participants->take(10) as $participant)
                    <div class="participant-item">
                        <img src="{{ $participant->user->avatar ? asset('storage/'.$participant->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($participant->user->name) }}" 
                             alt="{{ $participant->user->name }}" 
                             class="participant-avatar">
                        <div class="participant-info">
                            <div class="participant-name">{{ $participant->user->name }}</div>
                            <div class="participant-side">
                                @if($participant->side == 'pro')
                                    <i class="fas fa-thumbs-up" style="color: var(--primary-blue);"></i> Agreed
                                @else
                                    <i class="fas fa-thumbs-down" style="color: var(--primary-red);"></i> Disagreed
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </aside>

</div>

<script>
    // Main comment input auto-expand
    const mainInput = document.getElementById('mainCommentInput');
    const mainButtons = document.getElementById('mainPositionButtons');

    if (mainInput) {
        mainInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
            
            if (this.value.trim().length > 0) {
                mainButtons.classList.add('active');
            } else {
                mainButtons.classList.remove('active');
            }
        });
    }

    // Toggle reply input
    function toggleReplyInput(argumentId) {
        const replyContainer = document.getElementById(`replyInput-${argumentId}`);
        const allReplyContainers = document.querySelectorAll('.reply-input-container');
        
        // Close all other reply inputs
        allReplyContainers.forEach(container => {
            if (container.id !== `replyInput-${argumentId}`) {
                container.classList.remove('active');
            }
        });

        // Toggle current
        replyContainer.classList.toggle('active');
        
        if (replyContainer.classList.contains('active')) {
            const textarea = document.getElementById(`replyTextarea-${argumentId}`);
            if (textarea) textarea.focus();
        }
    }

    // Reply textarea auto-expand and show buttons
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('reply-textarea')) {
            e.target.style.height = 'auto';
            e.target.style.height = e.target.scrollHeight + 'px';
            
            const id = e.target.id.replace('replyTextarea-', '');
            const buttons = document.getElementById(`replyButtons-${id}`);
            
            if (buttons) {
                if (e.target.value.trim().length > 0) {
                    buttons.classList.add('active');
                } else {
                    buttons.classList.remove('active');
                }
            }
        }
    });

    // Toggle nested replies
    function toggleReplies(argumentId) {
        const repliesContainer = document.getElementById(`replies-${argumentId}`);
        const toggleBtn = event.currentTarget;
        const icon = toggleBtn.querySelector('i');
        const text = toggleBtn.querySelector('span');
        
        if (repliesContainer) {
            repliesContainer.classList.toggle('hidden');
            toggleBtn.classList.toggle('collapsed');
            
            if (repliesContainer.classList.contains('hidden')) {
                const replyCount = repliesContainer.querySelectorAll('.reply-wrapper').length;
                text.textContent = `Show ${replyCount} ${replyCount === 1 ? 'Reply' : 'Replies'}`;
            } else {
                text.textContent = 'Hide Replies';
            }
        }
    }

    // Auto-scroll to comment section if hash present
    window.addEventListener('load', function() {
        if (window.location.hash === '#disqus-card') {
            document.getElementById('disqus-card').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>

</body>
</html>