<?php
// feedback.php
// Static admin feedback display (no database)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --sidebar-width: 250px;
            --primary: #2563eb;
            --bg-light: #f5f7fb;
            --card-bg: #ffffff;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
        }

        * {
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, sans-serif;
        }

        body {
            margin: 0;
            background: var(--bg-light);
        }

        /* ===== MAIN CONTENT (fits with sidebar) ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 26px;
            color: var(--text-dark);
            margin: 0;
        }

        .page-header span {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* ===== FEEDBACK GRID ===== */
        .feedback-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .feedback-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border-left: 5px solid var(--primary);
            transition: transform 0.2s ease;
        }

        .feedback-card:hover {
            transform: translateY(-4px);
        }

        .feedback-user {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
        }

        .user-info h4 {
            margin: 0;
            font-size: 16px;
            color: var(--text-dark);
        }

        .user-info small {
            color: var(--text-muted);
            font-size: 13px;
        }

        .feedback-message {
            font-size: 15px;
            color: var(--text-dark);
            line-height: 1.6;
            margin-top: 10px;
        }

        .feedback-footer {
            margin-top: 15px;
            font-size: 13px;
            color: var(--text-muted);
            text-align: right;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- MAIN CONTENT -->
<div class="main-content">

    <div class="page-header">
        <div>
            <h1>User Feedback</h1>
            <span>Overview of recent feedback</span>
        </div>
    </div>

    <div class="feedback-grid">

        <!-- Feedback Card 1 -->
        <div class="feedback-card">
            <div class="feedback-user">
                <div class="avatar">A</div>
                <div class="user-info">
                    <h4>Ankit Sharma</h4>
                    <small>ankit@example.com</small>
                </div>
            </div>
            <div class="feedback-message">
                The admin panel is very smooth and easy to use.  
                Navigation feels clean and professional.
            </div>
            <div class="feedback-footer">
                12 Jan 2026
            </div>
        </div>

        <!-- Feedback Card 2 -->
        <div class="feedback-card">
            <div class="feedback-user">
                <div class="avatar">R</div>
                <div class="user-info">
                    <h4>Riya Patel</h4>
                    <small>riya@gmail.com</small>
                </div>
            </div>
            <div class="feedback-message">
                Design looks modern and fits perfectly on desktop and mobile.  
                Would love dark mode in future.
            </div>
            <div class="feedback-footer">
                10 Jan 2026
            </div>
        </div>

        <!-- Feedback Card 3 -->
        <div class="feedback-card">
            <div class="feedback-user">
                <div class="avatar">M</div>
                <div class="user-info">
                    <h4>Mohit Verma</h4>
                    <small>mohit@yahoo.com</small>
                </div>
            </div>
            <div class="feedback-message">
                Overall experience is great.  
                Sidebar and layout feel well structured and clear.
            </div>
            <div class="feedback-footer">
                08 Jan 2026
            </div>
        </div>

    </div>

</div>

</body>
</html>
