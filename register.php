<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Access &mdash; BioMed Elite</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container { display: flex; min-height: 100vh; background: var(--bg); justify-content: center; align-items: center; padding: 48px; }
        .auth-card { width: 100%; max-width: 600px; }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-card card">
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="font-size: 32px; color: var(--primary); margin-bottom: 8px;">&#9877;</div>
            <h1 style="font-size: 32px; font-weight: 700;">Request Access</h1>
            <p class="muted">Register for the premium biotech hub.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=register" class="form" id="registerForm" novalidate>
            <div class="field-row">
                <div class="field">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="search-input" style="padding-left: 16px;" value="<?= htmlspecialchars($old['name']) ?>" required>
                </div>
                <div class="field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="search-input" style="padding-left: 16px;" value="<?= htmlspecialchars($old['email']) ?>" required>
                </div>
            </div>

            <div class="field-row">
                <div class="field">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="search-input" style="padding-left: 16px;" value="<?= htmlspecialchars($old['phone']) ?>" required>
                </div>
                <div class="field">
                    <label for="role">Account Type</label>
                    <select id="role" name="role" class="search-input" style="padding-left: 16px;" required>
                        <option value="customer" <?= $old['role'] === 'customer' ? 'selected' : '' ?>>Customer (Patient)</option>
                        <option value="admin" <?= $old['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                    </select>
                </div>
            </div>

            <div class="field">
                <label for="address">Shipping Address</label>
                <textarea id="address" name="address" class="search-input" style="padding-left: 16px; min-height: 60px;" required><?= htmlspecialchars($old['address']) ?></textarea>
            </div>

            <div class="field-row">
                <div class="field">
                    <label for="password">Password (Min 8 chars)</label>
                    <input type="password" id="password" name="password" class="search-input" style="padding-left: 16px;" required>
                </div>
                <div class="field">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="search-input" style="padding-left: 16px;" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 24px;">Submit Registration</button>
        </form>

        <p style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-muted);">
            Already have access? <a href="index.php?page=login" style="font-weight: 600;">Sign in securely</a>
        </p>
    </div>
</div>

<script>
    // JS Validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const pass = document.getElementById('password').value;
        const conf = document.getElementById('confirm_password').value;
        
        if (pass.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long.');
        } else if (pass !== conf) {
            e.preventDefault();
            alert('Passwords do not match.');
        }
    });
</script>
</body>
</html>