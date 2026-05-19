<?php $user = $_SESSION['user'] ?? null; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard &mdash; BioMed Elite</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .tabs { display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 1px solid var(--border); padding-bottom: 12px; }
        .tab { padding: 8px 16px; border-radius: 999px; text-decoration: none; color: var(--text-muted); font-weight: 600; }
        .tab.active { background: var(--primary); color: white; }
        .status-badge { padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-accepted { background: var(--success-bg); color: var(--success); }
        .status-rejected { background: var(--error-bg); color: var(--error); }
    </style>
</head>
<body class="app-body">
    <header class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="index.php?page=admin"><span class="brand-icon">&#9877;</span><span>BioMed Elite Admin</span></a>
            <a href="index.php?page=logout" class="btn-logout">Logout</a>
        </div>
    </header>

    <main class="main-content">
        <h1 class="page-title">Clinical Dashboard</h1>
        
        <div class="tabs">
            <a href="index.php?page=admin&tab=orders" class="tab <?= $activeTab === 'orders' ? 'active' : '' ?>">Purchase Requests</a>
            <a href="index.php?page=admin&tab=medicines" class="tab <?= $activeTab === 'medicines' ? 'active' : '' ?>">Medicines</a>
            <a href="index.php?page=admin&tab=categories" class="tab <?= $activeTab === 'categories' ? 'active' : '' ?>">Categories</a>
            <a href="index.php?page=admin&tab=customers" class="tab <?= $activeTab === 'customers' ? 'active' : '' ?>">Customers</a>
        </div>

        <?php if ($activeTab === 'orders'): ?>
            <div class="card table-wrap">
                <table class="data-table">
                    <thead><tr><th>Order ID</th><th>Customer</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#BME-<?= $o['id'] ?></td>
                            <td><?= htmlspecialchars($o['customer_name']) ?></td>
                            <td>$<?= number_format($o['total_amount'], 2) ?></td>
                            <td><span class="status-badge status-<?= $o['status'] ?>" id="status-<?= $o['id'] ?>"><?= ucfirst($o['status']) ?></span></td>
                            <td>
                                <?php if ($o['status'] === 'pending'): ?>
                                    <button class="btn-sm btn-edit" onclick="changeOrderStatus(<?= $o['id'] ?>, 'accepted')">Accept</button>
                                    <button class="btn-sm btn-delete" onclick="changeOrderStatus(<?= $o['id'] ?>, 'rejected')">Reject</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($activeTab === 'medicines'): ?>
            <div class="card form-card">
                <h3 class="card-title">+ Add New Medicine</h3>
                <form method="POST" action="index.php?page=admin&action=add_medicine" class="layout-grid" enctype="multipart/form-data">
                    
                    <div class="field"><label>Medicine Name</label><input type="text" name="med_name" class="search-input" required></div>
                    <div class="field"><label>Vendor</label><input type="text" name="vendor" class="search-input" required></div>
                    <div class="field"><label>Price (৳)</label><input type="number" step="0.01" name="price" class="search-input" required></div>
                    <div class="field"><label>Stock</label><input type="number" name="availability" class="search-input" required></div>
                    
                    <div class="field">
                        <label>Category</label>
                        <select name="category_id" class="search-input" required>
                            <?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option><?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label>Medicine Image</label>
                        <input type="file" name="medicine_image" accept="image/*" class="search-input" style="padding: 10px;">
                    </div>

                    <div class="field" style="grid-column: 1/-1;">
                        <label>Description</label>
                        <textarea name="description" class="search-input" rows="2"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="grid-column: 1/-1;">Save Medicine</button>
                </form>
            </div>
            
            <div class="card table-wrap">
                <table class="data-table">
                    <thead><tr><th>Name</th><th>Vendor</th><th>Price</th><th>Stock</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php foreach ($medicines as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['name']) ?></td><td><?= htmlspecialchars($m['vendor']) ?></td>
                            <td>৳<?= number_format($m['price'], 2) ?></td><td><?= $m['availability'] ?></td>
                            <td><a href="index.php?page=admin&action=delete_medicine&id=<?= $m['id'] ?>" class="btn-sm btn-delete">Delete</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($activeTab === 'categories'): ?>
            <div class="card form-card">
                <form method="POST" action="index.php?page=admin&action=add_category" style="display:flex; gap:16px; align-items:flex-end;">
                    <div class="field"><label>Category Name</label><input type="text" name="category_name" class="search-input" required></div>
                    <div class="field"><label>Type</label><select name="category_type" class="search-input"><option value="solid">Solid</option><option value="liquid">Liquid</option></select></div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>

        <?php elseif ($activeTab === 'customers'): ?>
            <div class="card table-wrap">
                <table class="data-table">
                    <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php foreach ($customers as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['name']) ?></td><td><?= htmlspecialchars($c['email']) ?></td><td><?= htmlspecialchars($c['phone']) ?></td>
                            <td><a href="index.php?page=admin&action=delete_customer&id=<?= $c['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('Delete customer?')">Delete</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

    <script>
    function changeOrderStatus(orderId, newStatus) {
        if (!confirm('Mark order as ' + newStatus + '?')) return;
        let fd = new FormData(); fd.append('order_id', orderId); fd.append('status', newStatus);
        fetch('index.php?page=ajax&type=order_status', { method: 'POST', body: fd })
        .then(r => r.json()).then(d => { if(d.success) window.location.reload(); });
    }
    </script>
</body>
</html>