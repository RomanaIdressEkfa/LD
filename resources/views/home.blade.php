<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $debate ? $debate->title : 'Logically Debate' }}</title>
    <link rel="icon" href="https://i.ibb.co.com/s916M5xG/Logo-01.png" type="image/png">

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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
        }

        :root {
            --brand-primary: #D32F2F;
            --brand-light: #FFEBEE;
            --brand-hover: #B71C1C;
            --side-agreed: #1976D2;
            --side-agreed-light: #E3F2FD;
            --side-disagreed: var(--brand-primary);
            --bg-body: #F4F6F8;
            --bg-card: #FFFFFF;
            --text-main: #212121;
            --text-muted: #757575;
            --border-light: #EEEEEE;
            --shadow-soft: 0 4px 20px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.08);
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-full: 50px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            padding-top: 70px;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: 0.3s;
        }

        ul {
            list-style: none;
        }

        button {
            font-family: inherit;
            cursor: pointer;
        }

        /* ------------------------------------------------------------------
           NAVBAR
           ------------------------------------------------------------------ */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: var(--bg-card);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4%;
            z-index: 1000;
        }

        .logo-wrapper img {
            height: 40px;
            width: auto;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            border-radius: var(--radius-full);
            transition: background 0.2s;
            cursor: pointer;
        }

        .navbar-user:hover {
            background-color: var(--bg-body);
        }

        .user-name-nav {
            font-weight: 500;
            font-size: 15px;
            color: var(--text-main);
        }

        .user-avatar-nav {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-light);
        }

        /* Dropdown */
        .navbar-user-wrapper {
            position: relative;
        }

        .user-dropdown {
            position: absolute;
            top: 130%;
            right: 0;
            width: 200px;
            background: var(--bg-card);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-hover);
            padding: 8px;
            display: none;
            border: 1px solid var(--border-light);
            z-index: 1001;
        }

        .user-dropdown.active {
            display: block;
            animation: slideDown 0.2s ease;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            border: none;
            background: transparent;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            color: var(--text-main);
        }

        .dropdown-item:hover {
            background: var(--bg-body);
        }

        .logout-item {
            color: var(--brand-primary);
        }

        .logout-item:hover {
            background: var(--brand-light);
        }

        /* ------------------------------------------------------------------
           MAIN LAYOUT (Increased Spacing)
           ------------------------------------------------------------------ */
        .main-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 40px 6%;
            display: grid;
            grid-template-columns: 280px 1fr 300px;
            gap: 40px;
            align-items: start;
        }

        .sidebar-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-soft);
            margin-bottom: 24px;
            border: 1px solid var(--border-light);
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-left: 3px solid var(--brand-primary);
            padding-left: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .stat-box {
            padding: 20px 10px;
            border-radius: var(--radius-md);
            text-align: center;
            transition: transform 0.2s;
        }

        .stat-box:hover {
            transform: translateY(-3px);
        }

        .stat-box.blue {
            background: linear-gradient(135deg, #42A5F5, #1976D2);
            color: white;
        }

        .stat-box.red {
            background: linear-gradient(135deg, #EF5350, #C62828);
            color: white;
        }

        /* Neutral Stats */
        .stat-box.neutral-1 {
            background: var(--bg-body);
            border: 1px solid var(--border-light);
        }

        .stat-box.neutral-2 {
            background: var(--bg-body);
            border: 1px solid var(--border-light);
        }

        .stat-number {
            font-size: 24px;
            font-weight: 900;
            display: block;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 500;
            margin-top: 5px;
            opacity: 0.9;
        }

        /* Participant List */
        .participant-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: background 0.2s;
            border-bottom: 1px solid transparent;
        }

        .participant-item:hover {
            background: var(--bg-body);
        }

        .participant-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        .participant-name {
            font-weight: 500;
            font-size: 14px;
            color: var(--text-main);
        }

        .participant-side {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* ------------------------------------------------------------------
           CENTER FEED & POST CARD
           ------------------------------------------------------------------ */
        .post-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            margin-bottom: 30px;
            overflow: hidden;
            border: 1px solid var(--border-light);
        }

        .post-header {
            padding: 24px 30px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .post-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--brand-light);
        }

        .author-name {
            font-weight: 700;
            font-size: 16px;
            color: var(--text-main);
        }

        .post-time {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .post-content {
            padding: 0 30px 20px 30px;
        }

        .post-title {
            font-size: 28px;
            font-weight: 900;
            /* Bolder font */
            color: var(--text-main);
            margin-bottom: 16px;
            line-height: 1.3;
        }

        .post-description {
            font-size: 16px;
            color: #424242;
            line-height: 1.8;
            font-weight: 300;
        }

        /* Reactions Area */
        .post-stats {
            padding: 16px 30px;
            background: #FAFAFA;
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reaction-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            transition: all 0.2s;
        }

        .reaction-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .bubble-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: white;
        }

        .bg-agreed {
            background: var(--side-agreed);
        }

        .bg-disagreed {
            background: var(--brand-primary);
        }

        .reaction-text {
            font-weight: 600;
            font-size: 14px;
        }

        .text-agreed {
            color: var(--side-agreed);
        }

        .text-disagreed {
            color: var(--brand-primary);
        }

        /* Action Buttons Row */
        .action-row {
            display: flex;
            padding: 10px 20px;
            gap: 10px;
        }

        .action-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            font-weight: 500;
            color: var(--text-muted);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 15px;
            transition: 0.2s;
        }

        .action-btn:hover {
            background: var(--bg-body);
            color: var(--text-main);
        }

        .action-btn.active-blue {
            background: var(--side-agreed-light);
            color: var(--side-agreed);
            font-weight: 700;
        }

        .action-btn.active-red {
            background: var(--brand-light);
            color: var(--brand-primary);
            font-weight: 700;
        }

        /* ------------------------------------------------------------------
           INPUT SECTION
           ------------------------------------------------------------------ */
        .comment-input-section {
            padding: 24px 30px;
        }

        .comment-textarea {
            width: 100%;
            background: var(--bg-body);
            border: 1px solid transparent;
            border-radius: 20px;
            padding: 14px 20px;
            font-size: 15px;
            resize: none;
            min-height: 50px;
            transition: all 0.3s;
            font-family: 'Roboto', sans-serif;
        }

        .comment-textarea:focus {
            background: var(--bg-card);
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px var(--brand-light);
        }

        .position-buttons-wrapper {
            margin-top: 16px;
            display: none;
            gap: 16px;
            animation: fadeIn 0.3s;
        }

        .position-buttons-wrapper.active {
            display: flex;
        }

        .position-btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            color: white;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-agreed {
            background: var(--side-agreed);
        }

        .btn-agreed:hover {
            background: #1565C0;
        }

        .btn-disagreed {
            background: var(--brand-primary);
        }

        .btn-disagreed:hover {
            background: var(--brand-hover);
        }

        /* Join Prompt */
        .join-prompt {
            text-align: center;
            padding: 30px;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            border-radius: 12px;
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .join-btn {
            background: white;
            color: var(--brand-primary);
            padding: 10px 28px;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            margin-top: 12px;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
        }

        /* ------------------------------------------------------------------
           COMMENTS
           ------------------------------------------------------------------ */
        .comments-section {
            padding: 0 30px 30px 30px;
        }

        .comments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-light);
        }

        .comments-count {
            font-weight: 700;
            font-size: 18px;
            color: var(--text-main);
        }

        .filter-tab {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 6px;
        }

        .filter-tab.active {
            background: var(--bg-body);
            color: var(--text-main);
        }

        /* Comment Item */
        .comment-wrapper {
            display: flex;
            gap: 14px;
            margin-bottom: 12px;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .comment-bubble {
            background: var(--bg-body);
            border-radius: 0 16px 16px 16px;
            /* Unique shape */
            padding: 12px 18px;
            display: inline-block;
            max-width: 100%;
        }

        .badge-agreed {
            font-size: 10px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            background: var(--side-agreed-light);
            color: var(--side-agreed);
            margin-left: 8px;
        }

        .badge-disagreed {
            font-size: 10px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            background: var(--brand-light);
            color: var(--brand-primary);
            margin-left: 8px;
        }

        .comment-author {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .comment-text {
            font-size: 15px;
            color: #333;
        }

        .comment-meta {
            margin-left: 54px;
            display: flex;
            gap: 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
        }

        /* Nested Replies */
        .replies-container {
            margin-left: 54px;
            margin-top: 10px;
            padding-left: 16px;
            border-left: 2px solid var(--border-light);
        }

        /* Utilities */
        .hidden {
            display: none !important;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ------------------------------------------------------------------
       FIXED COMMENT & REPLY STYLES
       ------------------------------------------------------------------ */

        /* Hide Reply Input by default */
        .reply-input-container {
            display: none;
            margin-top: 15px;
            margin-left: 54px;
            /* Align with text */
            animation: fadeIn 0.3s ease;
        }

        /* Class to show it via JS */
        .reply-input-container.active {
            display: block !important;
        }

        /* Reply Input Styling */
        .input-wrapper {
            background: #f0f2f5;
            border-radius: 12px;
            padding: 10px;
            border: 1px solid var(--border-light);
        }

        .reply-textarea {
            width: 100%;
            background: transparent;
            border: none;
            resize: none;
            font-size: 14px;
            height: 40px;
            font-family: inherit;
        }

        .reply-action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 8px;
            justify-content: flex-end;
        }

        .reply-btn {
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Collapse/Expand System */
        .replies-container {
            display: none;
            /* Hidden by default */
            margin-left: 54px;
            margin-top: 10px;
            padding-left: 16px;
            border-left: 2px solid var(--border-light);
        }

        /* Class to show replies via JS */
        .replies-container.open {
            display: block !important;
        }

        .toggle-replies-btn {
            margin-left: 54px;
            margin-top: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            user-select: none;
            transition: color 0.2s;
        }

        .toggle-replies-btn:hover {
            color: var(--brand-primary);
        }

        /* ------------------------------------------------------------------
       FACEBOOK STYLE TREE & THREAD DESIGN (FIXED)
       ------------------------------------------------------------------ */
        .comment-thread {
            margin-bottom: 10px;
            position: relative;
        }

        .replies-container {
            display: none;
            position: relative;
            margin-left: 26px;
            padding-left: 20px;
            border-left: 2px solid #E4E6EB;
            padding-top: 5px;
        }

        .replies-container.open {
            display: block !important;
            animation: fadeIn 0.3s ease;
        }

        .reply-item {
            position: relative;
            margin-bottom: 15px;
        }

        .reply-item::before {
            content: '';
            position: absolute;
            top: 22px;
            left: -22px;
            width: 20px;
            height: 20px;
            border-bottom: 2px solid #E4E6EB;
            border-left: 2px solid #E4E6EB;
            border-bottom-left-radius: 12px;
            margin-top: -10px;
            z-index: 1;
        }

        .comment-wrapper {
            display: flex;
            gap: 10px;
            position: relative;
            z-index: 2;
        }

        .comment-bubble {
            background: #F0F2F5;
            border-radius: 18px;
            padding: 10px 15px;
            display: inline-block;
            max-width: 100%;
            color: #050505;
        }

        .comment-author {
            font-weight: 700;
            font-size: 13px;
            color: #050505;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reply-input-container {
            display: none;
            margin-top: 10px;
            margin-left: 54px;
        }

        .reply-input-container.active {
            display: block;
        }

        .custom-input-box {
            background: #F0F2F5;
            border-radius: 18px;
            padding: 8px 12px;
            min-height: 36px;
            font-size: 14px;
            border: 1px solid transparent;
            cursor: text;
            outline: none;
            color: #050505;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .custom-input-box:focus {
            background: #FFFFFF;
            border-color: #E4E6EB;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        .input-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 8px;
        }

        .mini-btn {
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            color: white;
            cursor: pointer;
        }

        .view-replies-link {
            margin-left: 54px;
            margin-top: 5px;
            font-size: 13px;
            font-weight: 600;
            color: #65676B;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            background: none;
            border: none;
            padding: 5px 8px;
            border-radius: 5px;
            transition: background 0.2s;
            text-decoration: none !important;
        }

        .view-replies-link:hover {
            text-decoration: none !important;
            background-color: rgba(0, 0, 0, 0.05);
        }

        .view-replies-link i {
            font-size: 12px;
        }


        .badge-agreed {
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            background: #E7F3FF;
            color: #1877F2;
            margin-left: 8px;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        .badge-disagreed {
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            background: #FFEBEE;
            color: #D32F2F;
            margin-left: 8px;
            display: inline-block;
            letter-spacing: 0.5px;
        }


        .vote-btn {
            background: none;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            color: #65676B;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none !important;
        }

        .vote-btn:hover {
            text-decoration: none !important;
            background-color: rgba(0, 0, 0, 0.05);
        }

        .active-like {
            color: #1877F2 !important;
            font-weight: 700 !important;
        }

        .active-dislike {
            color: #D32F2F !important;
            font-weight: 700 !important;
        }

        .mention-tag {
            background-color: #E7F3FF;
            color: #1877F2;
            font-weight: 700;
            font-size: 13px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-right: 4px;
            display: inline-block;
        }


        .alert-success {
            background: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #C8E6C9;
        }

        .alert-error {
            background: #FFEBEE;
            color: #C62828;
            border: 1px solid #FFCDD2;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ------------------------------------------------------------------
           RESPONSIVE DESIGN
           ------------------------------------------------------------------ */
        @media (max-width: 1280px) {
            .main-container {
                padding: 30px 3%;
                grid-template-columns: 260px 1fr;
            }

            .right-sidebar {
                display: none;
            }
        }

        @media (max-width: 992px) {
            .main-container {
                grid-template-columns: 1fr;
                max-width: 800px;
            }

            .left-sidebar {
                display: none;
            }

            .post-title {
                font-size: 24px;
            }
        }

        @media (max-width: 600px) {
            .main-container {
                padding: 20px 16px;
            }

            .post-header,
            .post-content,
            .post-stats,
            .comments-section {
                padding-left: 20px;
                padding-right: 20px;
            }

            .position-buttons-wrapper {
                flex-direction: column;
                gap: 10px;
            }

            .comment-meta {
                margin-left: 0;
                margin-top: 8px;
            }

            .replies-container {
                margin-left: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-wrapper">
            <a href="{{ route('home') }}">
                <img src="https://i.ibb.co.com/gbLB6Dqj/Logo-02.png" alt="Logically Debate">
            </a>
        </div>

        @auth
            <div class="navbar-user-wrapper" onclick="toggleUserDropdown()">
                <div class="navbar-user">
                    <span class="user-name-nav">{{ Auth::user()->name }}</span>
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                        alt="{{ Auth::user()->name }}" class="user-avatar-nav">
                    <i class="fas fa-chevron-down" style="font-size: 10px; color: var(--text-muted); margin-left: 8px;"></i>
                </div>

                <div class="user-dropdown" id="userDropdown">

                    @if (Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                            <i class="fas fa-cog"></i> Admin Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item logout-item">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>

                </div>
            </div>
        @else
            <div class="navbar-user">
                <span class="user-name-nav"
                    onclick="window.location='{{ isset($debate) ? route('debate.join_form', $debate->id) : '#' }}'">
                    Guest
                </span>
            </div>
        @endauth
    </nav>

    <!-- Main Container -->
    <div class="main-container">

        <!-- LEFT SIDEBAR -->
        <aside class="left-sidebar">
            @if($debate)
                <div class="sidebar-card">
                    <div class="sidebar-title">Statistics</div>
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
                    <div class="sidebar-title">Engagement</div>
                    <div class="stats-grid">
                        <div class="stat-box neutral-1">
                            <span class="stat-number"
                                style="color: var(--brand-primary)">{{ $debate->participants->count() }}</span>
                            <span class="stat-label">People</span>
                        </div>
                        <div class="stat-box neutral-2">
                            <span class="stat-number"
                                style="color: var(--text-main)">{{ $debate->arguments->count() }}</span>
                            <span class="stat-label">Arguments</span>
                        </div>
                    </div>
                </div>
            @endif
        </aside>

        <!-- CENTER FEED -->
        <main class="center-feed">

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if($debate)
                <article class="post-card">
                    <!-- Post Header -->
                    <div class="post-header">
                        <img src="https://ui-avatars.com/api/?name=Debate+Host&background=D32F2F&color=fff"
                            alt="Debate Host" class="post-avatar">
                        <div class="post-author-info">
                            <div class="author-name">Debate Host</div>
                            <div class="post-time">
                                <span>{{ $debate->created_at->diffForHumans() }}</span>
                                <span style="margin: 0 4px;">·</span>
                                <i class="fas fa-globe-americas"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="post-content">
                        <h1 class="post-title">{{ $debate->title }}</h1>
                        <p class="post-description">{{ $debate->description }}</p>
                    </div>

                    <!-- Stats Bar -->
                    <div class="post-stats">
                        <div style="display: flex; gap: 15px;">
                            <form action="{{ route('debate.join', $debate->id) }}" method="POST">
                                @csrf <input type="hidden" name="side" value="pro">
                                <button type="submit" class="reaction-btn">
                                    <div class="bubble-icon bg-agreed"><i class="fas fa-thumbs-up"></i></div>
                                    <span class="reaction-text text-agreed">
                                        {{ $debate->participants->where('side', 'pro')->count() }}
                                    </span>
                                </button>
                            </form>

                            <form action="{{ route('debate.join', $debate->id) }}" method="POST">
                                @csrf <input type="hidden" name="side" value="con">
                                <button type="submit" class="reaction-btn">
                                    <div class="bubble-icon bg-disagreed"><i class="fas fa-thumbs-down"></i></div>
                                    <span class="reaction-text text-disagreed">
                                        {{ $debate->participants->where('side', 'con')->count() }}
                                    </span>
                                </button>
                            </form>
                        </div>
                        <div style="color: var(--text-muted); font-size: 14px; font-weight: 500;">
                            {{ $debate->arguments->count() }} Comments
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-row">
                        <form action="{{ route('debate.join', $debate->id) }}" method="POST" style="flex: 1;">
                            @csrf <input type="hidden" name="side" value="pro">
                            <button class="action-btn {{ $userSide == 'pro' ? 'active-blue' : '' }}">
                                <i class="{{ $userSide == 'pro' ? 'fas' : 'far' }} fa-thumbs-up"></i> Agreed
                            </button>
                        </form>

                        <form action="{{ route('debate.join', $debate->id) }}" method="POST" style="flex: 1;">
                            @csrf <input type="hidden" name="side" value="con">
                            <button class="action-btn {{ $userSide == 'con' ? 'active-red' : '' }}">
                                <i class="{{ $userSide == 'con' ? 'fas' : 'far' }} fa-thumbs-down"></i> Disagreed
                            </button>
                        </form>

                        <button class="action-btn" onclick="document.getElementById('mainCommentInput').focus()">
                            <i class="far fa-comment-alt"></i> Debate
                        </button>
                    </div>

                    <!-- Input Section -->
                    <div class="comment-input-section" id="disqus-card">
                        @if(Auth::check() && $userSide)
                            <form action="{{ route('argument.store', $debate->id) }}" method="POST">
                                @csrf
                                <div style="display: flex; gap: 12px;">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                        class="post-avatar" style="width: 40px; height: 40px; border: none;">

                                    <div style="flex: 1;">
                                        <textarea class="comment-textarea" name="body" id="mainCommentInput"
                                            placeholder="Write your argument..." required></textarea>

                                        <div class="position-buttons-wrapper" id="mainPositionButtons">
                                            <button type="submit" name="side" value="pro" class="position-btn btn-agreed">
                                                <i class="fas fa-check"></i> Post as AGREED
                                            </button>
                                            <button type="submit" name="side" value="con" class="position-btn btn-disagreed">
                                                <i class="fas fa-times"></i> Post as DISAGREED
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="join-prompt" onclick="window.location='{{ route('debate.join_form', $debate->id) }}'">
                                <div style="font-size: 18px; font-weight: 700; margin-bottom: 6px;">
                                    <i class="fas fa-lock"></i> Join the Debate
                                </div>
                                <p style="font-size: 14px; opacity: 0.9;">Choose a side to participate</p>
                                <button class="join-btn">Pick a Side</button>
                            </div>
                        @endif
                    </div>

                    <!-- Comments List -->
                    <div class="comments-section">
                        <div class="comments-header">
                            <div class="comments-count">Arguments</div>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('home', ['sort' => 'relevant']) }}"
                                    class="filter-tab {{ request('sort', 'relevant') == 'relevant' ? 'active' : '' }}">
                                    Relevant
                                </a>

                                <a href="{{ route('home', ['sort' => 'latest']) }}"
                                    class="filter-tab {{ request('sort') == 'latest' ? 'active' : '' }}">
                                    Latest
                                </a>
                            </div>
                        </div>

                        @if($roots->count() > 0)
                            @foreach($roots as $argument)
                                @include('frontend.partials.comment_tree', ['argument' => $argument, 'debate' => $debate, 'userSide' => $userSide])
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-comments" style="font-size: 48px; opacity: 0.2; margin-bottom: 15px;"></i>
                                <p>No arguments yet. Start the debate!</p>
                            </div>
                        @endif
                    </div>
                </article>
            @else
                <div class="post-card">
                    <div style="text-align: center; padding: 60px;">
                        <h3>No Active Debate</h3>
                    </div>
                </div>
            @endif
        </main>

        <!-- RIGHT SIDEBAR -->
        <aside class="right-sidebar">
            @if($debate)
                <div class="sidebar-card">
                    <div class="sidebar-title">
                        <i class="fas fa-users" style="margin-right: 8px;"></i> Participants
                    </div>
                    <div>
                        @foreach($debate->participants->take(8) as $participant)
                            <div class="participant-item">
                                <img src="{{ $participant->user->avatar ? asset('storage/' . $participant->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($participant->user->name) }}"
                                    class="participant-avatar">
                                <div style="flex: 1;">
                                    <div class="participant-name">{{ $participant->user->name }}</div>
                                    <div class="participant-side"
                                        style="color: {{ $participant->side == 'pro' ? 'var(--side-agreed)' : 'var(--brand-primary)' }}">
                                        {{ $participant->side == 'pro' ? 'AGREED' : 'DISAGREED' }}
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
        // JS Logic for Interactivity
        const mainInput = document.getElementById('mainCommentInput');
        const mainButtons = document.getElementById('mainPositionButtons');

        if (mainInput) {
            mainInput.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
                if (this.value.trim().length > 0) {
                    mainButtons.classList.add('active');
                } else {
                    mainButtons.classList.remove('active');
                }
            });
        }

        function toggleUserDropdown() {
            document.getElementById('userDropdown').classList.toggle('active');
        }

        window.onclick = function (event) {
            if (!event.target.closest('.navbar-user-wrapper')) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && dropdown.classList.contains('active')) {
                    dropdown.classList.remove('active');
                }
            }
        }

        function toggleReplyInput(id, userName) {
            document.querySelectorAll('.reply-input-container').forEach(el => el.classList.remove('active'));

            const target = document.getElementById('replyInput-' + id);
            const textarea = document.getElementById('replyTextarea-' + id);

            if (target) {
                target.classList.add('active');

                if (textarea) {
                    textarea.value = userName + " ";
                    textarea.focus();
                }
            }
        }

        function openReplyBox(id, userName) {
            document.querySelectorAll('.reply-input-container').forEach(el => el.classList.remove('active'));

            const container = document.getElementById('replyInput-' + id);
            const fakeInput = document.getElementById('fakeInput-' + id);

            if (container && fakeInput) {
                container.classList.add('active');
                fakeInput.innerHTML = `<span class="mention-tag" contenteditable="false">${userName}</span>&nbsp;`;
                placeCaretAtEnd(fakeInput);
            }
        }

        function placeCaretAtEnd(el) {
            el.focus();
            if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
                var range = document.createRange();
                range.selectNodeContents(el);
                range.collapse(false);
                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }

        function setEndOfContenteditable(contentEditableElement) {
            let range, selection;
            if (document.createRange) {
                range = document.createRange();
                range.selectNodeContents(contentEditableElement);
                range.collapse(false);
                selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
            }
        }

        function submitReply(id, side) {
            const fakeInput = document.getElementById('fakeInput-' + id);
            const hiddenInput = document.getElementById('hiddenBody-' + id);
            const sideInput = document.getElementById('hiddenSide-' + id);
            const form = document.getElementById('replyForm-' + id);

            if (fakeInput && hiddenInput && form) {
                hiddenInput.value = fakeInput.innerHTML;
                sideInput.value = side;
                if (fakeInput.innerText.trim() === "") {
                    alert("Please write a reply.");
                    return;
                }
                form.submit();
            }
        }

        function toggleReplies(id, count) {
            const container = document.getElementById('replies-' + id);
            const icon = document.getElementById('arrow-icon-' + id);

            if (container.classList.contains('open')) {
                container.classList.remove('open');
                if (icon) icon.className = 'fas fa-reply';
                if (icon) icon.style.transform = 'rotate(180deg)';
            } else {
                container.classList.add('open');
                if (icon) icon.className = 'fas fa-caret-up';
                if (icon) icon.style.transform = 'rotate(0deg)';
            }
        }

        function toggleUserDropdown() {
            document.getElementById('userDropdown').classList.toggle('active');
        }

        window.onclick = function (event) {
            if (!event.target.closest('.navbar-user-wrapper')) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && dropdown.classList.contains('active')) {
                    dropdown.classList.remove('active');
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            @if(session('expanded_id'))
                let expandId = "{{ session('expanded_id') }}";
                let container = document.getElementById('replies-' + expandId);
                if (container) {
                    let current = container;
                    while (current) {
                        if (current.classList.contains('replies-container')) {
                            current.classList.add('open');
                        }
                        current = current.parentElement.closest('.replies-container');
                    }
                    setTimeout(() => {
                        container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 300);
                }
            @endif
    });


        function ajaxVote(argumentId, type) {
            const token = document.querySelector('input[name="_token"]').value;

            fetch(`/argument/${argumentId}/vote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ type: type })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'login_required') {
                        window.location.href = `/debate/${data.debate_id}/join-guest`;
                    } else if (data.status === 'success') {
                        const agreeCountSpan = document.getElementById(`agree-count-${argumentId}`);
                        const disagreeCountSpan = document.getElementById(`disagree-count-${argumentId}`);

                        agreeCountSpan.innerText = data.agree_count > 0 ? data.agree_count : '';
                        disagreeCountSpan.innerText = data.disagree_count > 0 ? data.disagree_count : '';

                        const agreeBtn = document.getElementById(`btn-agree-${argumentId}`);
                        const disagreeBtn = document.getElementById(`btn-disagree-${argumentId}`);

                        agreeBtn.classList.remove('active-like');
                        disagreeBtn.classList.remove('active-dislike');

                        if (data.user_vote === 'agree') {
                            agreeBtn.classList.add('active-like');
                        } else if (data.user_vote === 'disagree') {
                            disagreeBtn.classList.add('active-dislike');
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

</body>

</html>