<?php $user = $_SESSION['user'] ?? null; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile &mdash; BioMed Elite</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="app-body">
    <header class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="index.php?page=home"><span class="brand-icon">&#9877;</span><span>BioMed Elite</span></a>
            <div class="nav-user">
                <a href="index.php?page=logout" class="btn-logout">Logout</a>
            </div>
        </div>
    </header>

    <main class="main-content layout-grid">
        <div>
            <h1 class="page-title">Profile Settings</h1>
            <p class="muted">Manage your clinical account details.</p>
            
            <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <?php if (!empty($success)): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

            <div class="card form-card">
                <h3 class="card-title">Personal Information</h3>
                <form method="POST" action="index.php?page=profile" class="form">
                    <input type="hidden" name="action" value="update_profile">
                    <div class="field">
                        <label>Full Name</label>
                        <input type="text" name="name" class="search-input" value="<?= htmlspecialchars($userProfile['name']) ?>" required>
                    </div>
                    <div class="field">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="search-input" value="<?= htmlspecialchars($userProfile['phone']) ?>" required>
                    </div>
                    <div class="field">
                        <label>Shipping Address</label>
                        <textarea name="address" class="search-input" required><?= htmlspecialchars($userProfile['address']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top:12px;">Save Changes</button>
                </form>
            </div>
        </div>

        <div>
            <div class="card form-card" style="margin-top: 64px;">
                <h3 class="card-title">Security</h3>
                <form method="POST" action="index.php?page=profile" class="form">
                    <input type="hidden" name="action" value="update_password">
                    <div class="field">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="search-input" required>
                    </div>
                    <div class="field">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="search-input" required>
                    </div>
                    <button type="submit" class="btn btn-ghost" style="margin-top:12px;">Update Password</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>