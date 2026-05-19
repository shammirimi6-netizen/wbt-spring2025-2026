<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In &mdash; BioMed Elite</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background: var(--surface-container-high); 
        }
        .auth-wrapper { 
            display: flex; 
            min-height: 100vh; 
            align-items: center; 
            justify-content: center; 
            padding: 24px; 
        }
        .auth-container { 
            display: flex; 
            max-width: 1000px; 
            width: 100%; 
            background: var(--bg); 
            border-radius: var(--radius-lg); 
            box-shadow: var(--shadow-xl); 
            overflow: hidden; 
            border: 1px solid var(--border); 
        }
        .auth-brand { 
            flex: 1; 
            padding: 64px; 
            background: linear-gradient(135deg, #f4f7ff, #eaf1ff); 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            border-right: 1px solid var(--border); 
        }
        .auth-form-area { 
            flex: 1.2; 
            padding: 64px; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .auth-container { flex-direction: column; }
            .auth-brand { padding: 48px 24px; border-right: none; border-bottom: 1px solid var(--border); }
            .auth-form-area { padding: 48px 24px; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-brand">
            <div style="font-size: 40px; color: var(--primary); margin-bottom: 16px; line-height: 1;">&#9877;</div>
            <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 16px; color: var(--text);">BioMed Elite</h2>
            <p style="font-size: 16px; color: var(--text-muted); line-height: 1.6; margin-bottom: 32px;">
                Health as the Ultimate Luxury. Enter the premium biotech hub for personalized wellness and clinical precision.
            </p>
            <div style="font-size: 14px; font-weight: 600; color: var(--primary-dark); display: flex; gap: 16px; flex-wrap: wrap;">
                <span>✓ FDA Compliant</span>
                <span>✓ Enterprise Security</span>
            </div>
        </div>

        <div class="auth-form-area">
            <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 8px;">Welcome Back</h1>
            <p class="muted" style="margin-bottom: 32px;">Sign in to access your clinical dashboard.</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=login" class="form" id="loginForm" novalidate>
                <div class="field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="search-input" style="padding-left: 16px;" 
                           value="<?= htmlspecialchars($prefill ?? '') ?>" 
                           placeholder="Enter your email" required autofocus>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="search-input" style="padding-left: 16px;" 
                           placeholder="Enter your password" required>
                </div>
                
                <label class="checkbox" style="margin-top: 8px;">
                    <input type="checkbox" name="remember" <?= !empty($prefill) ? 'checked' : '' ?>>
                    <span>Remember my email</span>
                </label>
                
                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 16px;">Sign In</button>
            </form>

            <p style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-muted);">
                New to BioMed Elite? <a href="index.php?page=register" style="font-weight: 600;">Create account</a>
            </p>
        </div>
    </div>
</div>

<script>
    // JS Validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        if (!document.getElementById('email').value || !document.getElementById('password').value) {
            e.preventDefault();
            alert('Please fill in both email and password.');
        }
    });
</script>
</body>
</html>