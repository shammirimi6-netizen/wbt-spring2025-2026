<?php 
$user = $_SESSION['user'] ?? null; 
$cartItems = $cartItems ?? []; 
$subtotal = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart &mdash; BioMed Elite</title>
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
            <div>
                <h1 class="page-title">Your Cart</h1>
                <p class="page-sub">Review your premium biotech selections.</p>
            </div>
        </div>

        <div class="layout-grid">
            <div id="cartItemsContainer">
                <?php if (empty($cartItems)): ?>
                    <div class="card empty" style="text-align: center; padding: 48px;">
                        <p>Your cart is empty.</p>
                        <a href="index.php?page=home" class="btn btn-primary" style="margin-top: 16px;">Browse Medicines</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($cartItems as $item): ?>
                        <?php $subtotal += ($item['price'] * $item['quantity']); ?>
                        <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; margin-bottom: 16px;">
                            <div>
                                <h3 style="margin-bottom: 4px;"><?= htmlspecialchars($item['name']) ?></h3>
                                <p class="muted" style="font-size: 13px;"><?= htmlspecialchars($item['vendor']) ?> &mdash; <span style="color: var(--success);"><?= $item['availability'] ?> in stock</span></p>
                                
                                <div style="margin-top: 12px; display: flex; align-items: center; gap: 12px;">
                                    <button class="btn-sm btn-edit" 
                                            onclick="updateCart(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)">-</button>
                                    
                                    <span style="font-weight: 600; font-size: 16px; min-width: 20px; text-align: center;">
                                        <?= intval($item['quantity']) ?>
                                    </span>
                                    
                                    <button class="btn-sm btn-edit" 
                                            onclick="updateCart(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>, <?= $item['availability'] ?>)">+</button>
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn-sm btn-delete" onclick="removeFromCart(<?= $item['id'] ?>)">✕ Remove</button>
                                <h3 style="margin-top: 16px; color: var(--primary);">
                                    <?= number_format($item['price'] * $item['quantity'], 2) ?><b>৳</b>
                                </h3>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="card">
                <h3 class="card-title">Order Summary</h3>
                <table class="data-table" style="width: 100%; border: none;">
                    <tbody>
                        <tr>
                            <td style="padding: 12px 0;">Subtotal</td>
                            <td class="text-right" style="padding: 12px 0;"><?= number_format($subtotal, 2) ?><b>৳</b></td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0;">Cold-Chain Shipping</td>
                            <td class="text-right" style="padding: 12px 0;">15.00<b>৳</b></td>
                        </tr>
                        <tr style="font-weight: 700; font-size: 18px; border-top: 1px solid var(--border);">
                            <td style="padding: 16px 0 0 0;">Total</td>
                            <td class="text-right" style="padding: 16px 0 0 0; color: var(--primary);">
                                <?= number_format($subtotal + ($subtotal > 0 ? 15 : 0), 2) ?><b>৳</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <?php if (!empty($cartItems)): ?>
                    <a href="index.php?page=checkout" class="btn btn-primary btn-block" style="margin-top: 24px; text-align: center; display: block;">Proceed to Secure Checkout</a>
                <?php else: ?>
                    <button class="btn btn-primary btn-block" style="margin-top: 24px; opacity: 0.5; cursor: not-allowed;" disabled>Proceed to Secure Checkout</button>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">&copy; <?= date('Y') ?> BioMed Elite. Health as the Ultimate Luxury.</footer>

    <script>
    function sendCartAjax(type, formData) {
        fetch('index.php?page=ajax&type=' + type, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('AJAX Error:', error);
            alert('An error occurred while updating the cart.');
        });
    }

    function updateCart(cartId, newQuantity, maxStock = null) {
        if (newQuantity <= 0) {
            removeFromCart(cartId);
            return;
        }
        if (maxStock !== null && newQuantity > maxStock) {
            alert('Requested quantity exceeds available stock (' + maxStock + ').');
            return;
        }

        let formData = new FormData();
        formData.append('cart_id', cartId);
        formData.append('quantity', newQuantity);
        
        sendCartAjax('cart_update', formData);
    }

    function removeFromCart(cartId) {
        if (confirm('Are you sure you want to remove this item from your cart?')) {
            let formData = new FormData();
            formData.append('cart_id', cartId);
            
            sendCartAjax('cart_remove', formData);
        }
    }
    </script>

</body>
</html>