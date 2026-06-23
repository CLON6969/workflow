<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Deletion Instructions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --bg: #f3f4f6;
            --card: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --warning-bg: #fff7ed;
            --warning-border: #fed7aa;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: linear-gradient(180deg, #eef2ff, var(--bg));
            color: var(--text);
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 780px;
            background: var(--card);
            border-radius: 14px;
            padding: 36px;
            box-shadow: 0 20px 40px rgba(0,0,0,.08);
            border: 1px solid var(--border);
        }

        .header {
            margin-bottom: 30px;
        }

        .badge {
            display: inline-block;
            background: #eef2ff;
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .subtitle {
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.6;
        }

        h2 {
            font-size: 1.25rem;
            margin-top: 36px;
            margin-bottom: 12px;
        }

        p {
            line-height: 1.7;
            color: #374151;
        }

        ul {
            margin-top: 12px;
            padding-left: 0;
            list-style: none;
        }

        ul li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px dashed var(--border);
        }

        ul li:last-child {
            border-bottom: none;
        }

        ul li::before {
            content: "✓";
            color: var(--primary);
            font-weight: bold;
            margin-top: 2px;
        }

        .warning {
            margin-top: 32px;
            padding: 16px 18px;
            background: var(--warning-bg);
            border: 1px solid var(--warning-border);
            border-radius: 10px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            font-size: 0.95rem;
        }

        .warning span {
            font-size: 1.2rem;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 0.95rem;
            color: var(--muted);
        }

        a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .card {
                padding: 24px;
            }

            h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="card">

        <div class="header">
            <span class="badge">Privacy & Data Control</span>
            <h1>Data Deletion Instructions</h1>
            <p class="subtitle">
                <strong>{{ config('app.name') }}</strong> is committed to protecting your privacy.
                This page explains how you can request permanent deletion of your personal data.
            </p>
        </div>

        <h2>How to delete your data</h2>
        <p>
            To request deletion of your account and associated personal data, follow these steps:
        </p>

        <ul>
            <li>Log in to your account on our website or mobile app</li>
            <li>Navigate to your <strong>Dashboard</strong></li>
            <li>Open <strong>Profile</strong> (bottom of the sidebar)</li>
            <li>Click <strong>Delete My Account</strong></li>
            <li>Confirm your deletion request</li>
        </ul>

        <p>
            Once confirmed, your account and all associated personal data will be permanently removed.
        </p>

        <h2>Data that will be deleted</h2>
        <ul>
            <li>Personal profile information (name, email, phone number)</li>
            <li>Login and authentication credentials</li>
            <li>Saved content and user activity records</li>
            <li>Any other data directly linked to your account</li>
        </ul>

        <h2>Data retention</h2>
        <p>
            Certain information may be retained if required by applicable laws or for security,
            fraud prevention, or compliance purposes. Such data is never used for marketing.
        </p>

        <div class="warning">
            <span>⚠️</span>
            <div>
                <strong>Important:</strong> Account deletion is permanent and cannot be undone.
            </div>
        </div>

        <div class="footer">
            <div>
                Need help accessing your account?
            </div>
            <div>
                Contact us at
                <a href="mailto:support@{{ request()->getHost() }}">
                    support@{{ request()->getHost() }}
                </a>
            </div>
        </div>

    </div>
</div>

</body>
</html>
