<?php 
$user = $_SESSION['user'] ?? null; 
$orderId = $_GET['order_id'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful &mdash; BioMed Elite</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="app-body">
    <header class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="index.php?page=home">
                <span class="brand-icon">&#9877;</span>
                <span>BioMed Elite</span>
            </a>
            <div class="nav-user">
                <span class="user-pill">
                    <span class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?></span>
                    <span class="user-meta">
                        <span class="user-name"><?= htmlspecialchars($user['name'] ?? 'Guest') ?></span>
                        <span class="user-role">Customer</span>
                    </span>
                </span>
                <a href="index.php?page=logout" class="btn-logout">Logout</a>
            </div>
        </div>
    </header>

    <main class="main-content" style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
        <div class="card" style="max-width: 500px; text-align: center; padding: 48px;">
            <div style="font-size: 64px; color: var(--success); margin-bottom: 16px; line-height: 1;">✓</div>
            <h1 class="page-title" style="margin-bottom: 16px;">Order Confirmed!</h1>
            
            <div class="alert alert-success" style="margin: 24px 0; display: inline-block;">
                Order Number: <strong>#BME-<?= htmlspecialchars($orderId) ?></strong>
            </div>
            
            <p style="color: var(--text-muted); margin-bottom: 32px; line-height: 1.6;">
                Thank you for your purchase. Your order is currently <strong style="color: #856404;">Pending Admin Approval</strong>. You can track the status of your medications in your profile.
            </p>
            
            <a href="index.php?page=home" class="btn btn-primary btn-block">Continue Shopping</a>
        </div>
    </main>
</body>
</html>