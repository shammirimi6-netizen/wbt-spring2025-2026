<?php 
$user = $_SESSION['user'] ?? null; 
$cartItems = $cartItems ?? [];
$subtotal = $subtotal ?? 0;
$shipping = $shipping ?? 15.00;
$total = $total ?? 0;
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout &mdash; BioMed Elite</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .payment-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 12px; }
        @media (max-width: 500px) { .payment-grid { grid-template-columns: 1fr; } }
        .payment-option {
            border: 2px solid var(--border); border-radius: var(--radius);
            padding: 16px; text-align: center; cursor: pointer; font-weight: 600;
            transition: var(--transition); background: var(--bg);
        }
        .payment-option input[type="radio"] { display: none; }
        .payment-option:has(input:checked) { border-color: var(--primary); background: #eff4ff; color: var(--primary-dark); }
    </style>
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
                    <span class="user-avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                    <span class="user-meta">
                        <span class="user-name"><?= htmlspecialchars($user['name']) ?></span>
                        <span class="user-role">Customer</span>
                    </span>
                </span>
                <a href="index.php?page=logout" class="btn-logout">Logout</a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Secure Checkout</h1>
            <p class="page-sub">Finalize your premium biotech order.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=checkout&action=confirm" class="layout-grid" id="checkoutForm">
            
            <div>
                <div class="card form-card">
                    <h3 class="card-title">Shipping Details</h3>
                    <div class="field">
                        <label for="shipping_address">Delivery Address</label>
                        <textarea id="shipping_address" name="shipping_address" class="search-input" rows="4" required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="card form-card">
                    <h3 class="card-title">Payment Method</h3>
                    <div class="payment-grid">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="Credit Card" required>
                            💳 Credit Card
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="bKash">
                            📱 bKash
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="Nagad">
                            📱 Nagad
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="Cash on Delivery">
                            💵 Cash on Delivery
                        </label>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-title">Invoice Summary</h3>
                <div class="table-wrap" style="margin-bottom: 24px;">
                    <table class="data-table" style="border: none;">
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td style="padding: 12px 0;">
                                        <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                                        <span class="muted" style="font-size: 12px;">Qty: <?= $item['quantity'] ?> &times; $<?= number_format($item['price'], 2) ?></span>
                                    </td>
                                    <td class="text-right" style="padding: 12px 0; vertical-align: bottom;">
                                        $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <tr style="border-top: 2px dashed var(--border);">
                                <td style="padding-top: 16px;">Subtotal</td>
                                <td class="text-right" style="padding-top: 16px;">$<?= number_format($subtotal, 2) ?></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 16px;">Cold-Chain Shipping</td>
                                <td class="text-right" style="padding-bottom: 16px;">$<?= number_format($shipping, 2) ?></td>
                            </tr>
                            <tr style="border-top: 1px solid var(--border);">
                                <td style="padding-top: 16px; font-weight: 700; font-size: 18px;">Total</td>
                                <td class="text-right" style="padding-top: 16px; font-weight: 700; font-size: 18px; color: var(--primary);">
                                    $<?= number_format($total, 2) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block" style="padding: 14px; font-size: 16px;">Confirm Purchase</button>
                <a href="index.php?page=cart" class="btn btn-ghost btn-block" style="text-align: center; margin-top: 12px;">Cancel (Back to Cart)</a>
            </div>

        </form>
    </main>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const address = document.getElementById('shipping_address').value.trim();
            const payment = document.querySelector('input[name="payment_method"]:checked');
            
            if (!address) {
                e.preventDefault();
                alert('Please provide a valid shipping address.');
            } else if (!payment) {
                e.preventDefault();
                alert('Please select a payment method.');
            }
        });
    </script>
</body>
</html>