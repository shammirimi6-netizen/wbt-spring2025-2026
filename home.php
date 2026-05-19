<?php 

$user = $_SESSION['user'] ?? null;
$medicines = $medicines ?? []; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioMed Elite &mdash; Premium Biotech Hub</title>
    <link rel="stylesheet" href="style.css">
    <style>
    
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 32px;
            align-items: stretch !important;
        }
        
        .medicine-card {
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            padding: 20px !important; 
        }
        
        .medicine-card-content {
            flex-grow: 1 !important;
            display: flex;
            flex-direction: column;
        }
        
        .medicine-image-placeholder {
            height: 240px; 
            background: linear-gradient(135deg, var(--bg), #eaf1ff);
            border-radius: var(--radius) var(--radius) 0 0;
            margin: -20px -20px 16px -20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 48px;
            border-bottom: 1px solid var(--border);
            overflow: hidden; 
            padding: 0;
        }

        .tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px; 
            font-weight: 600;
            background: var(--surface-container-high);
            color: var(--primary-dark);
            margin-bottom: 8px; 
        }

        .medicine-title {
            font-size: 17px; 
            font-weight: 700;
            margin-bottom: 4px; 
            line-height: 1.3;
            min-height: 44px; 
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .medicine-footer {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-top: 1px solid var(--border); 
            padding-top: 12px; 
            margin-top: auto !important;
        }
        
        .filters {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            background: var(--card-bg);
            border: 1px solid var(--border);
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .hero {
            text-align: center;
            padding: 64px 24px;
            background: linear-gradient(180deg, #eaf1ff 0%, var(--bg) 100%);
            border-radius: var(--radius-lg);
            margin-bottom: 48px;
        }
        
        .hero-title {
            font-size: 48px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }
    </style>
</head>
<body class="app-body">

    <header class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="index.php?page=home">
                <span class="brand-icon">&#9877;</span>
                <span>BioMed Elite</span>
            </a>

           <?php if ($user): ?>
                    <?php if ($user['role'] === 'customer'): ?>
                        <a href="index.php?page=cart" style="text-decoration: none; position: relative; margin-right: 16px; display: flex; align-items: center;">
                            <img src="images/cart icon.png" alt="Cart" style="height: 40px; width: auto; display: block;">
                        </a>
                    <?php endif; ?>

                    <a href="index.php?page=profile" style="text-decoration: none; color: inherit;">
                        <span class="user-pill">
                            <span class="user-avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                            <span class="user-meta">
                                <span class="user-name"><?= htmlspecialchars($user['name']) ?></span>
                                <span class="user-role"><?= ucfirst($user['role']) ?></span>
                            </span>
                        </span>
                    </a>
                    <a href="index.php?page=logout" class="btn-logout">Logout</a>
                <?php else: ?>
                    <a href="index.php?page=login" class="btn btn-ghost" style="padding: 8px 16px;">Sign In</a>
                    <a href="index.php?page=register" class="btn btn-primary" style="padding: 8px 16px;">Request Access</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="main-content">
        
        <div class="hero">
            <div class="tag" style="background: rgba(0, 101, 145, 0.1); color: var(--primary);">HEALTH AS THE ULTIMATE LUXURY</div>
            <h1 class="hero-title">Precision Healthcare,<br>Delivered with Elegance.</h1>
            <p style="color: var(--text-muted); font-size: 18px; max-width: 600px; margin: 0 auto 32px auto;">
                Access premium pharmaceuticals, advanced lab testing, and elite medical consultations through a seamless, secure platform.
            </p>
            
            <div class="search-wrap" style="max-width: 600px; margin: 0 auto; position: relative;">
                <img src="images/search icon.png" alt="Search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); height: 20px; width: auto; opacity: 0.5;">
                <input type="text" id="globalSearch" class="search-input" placeholder="Search for medications, vendors, or symptoms..." style="padding: 16px 16px 16px 48px; border-radius: 999px; width: 100%; box-sizing: border-box;">
            </div>
        </div>

        <div>
            <h2 style="font-size: 24px; font-weight: 600;">Curated Therapeutics</h2>
            <p class="muted">Highly vetted formulations for optimal health.</p>
        </div>

        <div class="filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="solid">Solid Forms (Pills/Capsules)</button>
            <button class="filter-btn" data-filter="liquid">Liquid Forms (Syrups/Tinctures)</button>
            <button class="filter-btn" data-filter="Supplement">Supplements</button>
            <button class="filter-btn" data-filter="Rx Required">Prescriptions</button>
        </div>

        <div class="catalog-grid" id="catalogGrid">
            <?php foreach ($medicines as $med): ?>
                <div class="card medicine-card" data-type="<?= htmlspecialchars($med['type'] ?? '') ?>" data-category="<?= htmlspecialchars($med['category'] ?? '') ?>">
                    
                    <div class="medicine-card-content">
                        <div class="medicine-image-placeholder">
                            <?php if (!empty($med['image_path'])): ?>
                                <img src="<?= htmlspecialchars($med['image_path']) ?>" alt="Medicine Image" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                💊
                            <?php endif; ?>
                        </div>
                        
                        <div><span class="tag"><?= htmlspecialchars($med['category'] ?? 'Medicine') ?></span></div>
                        <h3 class="medicine-title"><?= htmlspecialchars($med['name']) ?></h3>
                        <p class="muted" style="font-size: 12px; margin-bottom: 12px;"><?= htmlspecialchars($med['vendor']) ?></p>
                    </div>
                    
                    <div class="medicine-footer">
                        <span style="font-size: 18px; font-weight: 700; color: var(--primary);"><?= number_format($med['price'], 2) ?><b>৳</b></span>
                        
                        <?php if ($user && $user['role'] === 'customer'): ?>
                            <button class="btn btn-primary" onclick="addToCart(<?= $med['id'] ?>)" style="padding: 8px 16px; border-radius: 999px;">
                                Add to Cart
                            </button>
                        <?php elseif (!$user): ?>
                            <a href="index.php?page=login" class="btn btn-ghost" style="padding: 8px 16px; border-radius: 999px;">Login to Buy</a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
            
            <?php if (empty($medicines)): ?>
                <div style="grid-column: 1 / -1; padding: 48px; text-align: center; color: var(--text-muted);">
                    No medicines currently available in the catalog.
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">&copy; <?= date('Y') ?> BioMed Elite. Health as the Ultimate Luxury.</footer>

    <script>
        const isCustomer = <?php echo ($user && $user['role'] === 'customer') ? 'true' : 'false'; ?>;
        const isLoggedIn = <?php echo ($user) ? 'true' : 'false'; ?>;

        const filterBtns = document.querySelectorAll('.filter-btn');
        let currentCards = document.querySelectorAll('.medicine-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');
                currentCards = document.querySelectorAll('.medicine-card');

                currentCards.forEach(card => {
                    if (filter === 'all' || 
                        card.getAttribute('data-type') === filter || 
                        card.getAttribute('data-category') === filter) {
                        card.style.setProperty('display', 'flex', 'important');
                    } else {
                        card.style.setProperty('display', 'none', 'important');
                    }
                });
            });
        });

        // --- Live Search AJAX ---
        const searchInput = document.getElementById('globalSearch');
        const catalogGrid = document.getElementById('catalogGrid');
        let searchTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            const query = this.value.trim();

            searchTimer = setTimeout(() => {
                fetch('index.php?page=ajax&type=medicine_search&q=' + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    catalogGrid.innerHTML = ''; 
                    
                    if (data.error) {
                         catalogGrid.innerHTML = `<div style="grid-column: 1 / -1; padding: 48px; text-align: center; color: var(--error);">${data.error}</div>`;
                         return;
                    }

                    if (data.length === 0) {
                        catalogGrid.innerHTML = '<div style="grid-column: 1 / -1; padding: 48px; text-align: center; color: var(--text-muted);">No medicines found matching your search.</div>';
                        return;
                    }

                    data.forEach(med => {
                        let buttonHtml = '';
                        if (isCustomer) {
                            buttonHtml = `<button class="btn btn-primary" onclick="addToCart(${med.id})" style="padding: 8px 16px; border-radius: 999px;">Add to Cart</button>`;
                        } else if (!isLoggedIn) {
                            buttonHtml = `<a href="index.php?page=login" class="btn btn-ghost" style="padding: 8px 16px; border-radius: 999px;">Login to Buy</a>`;
                        }

                        // THE JAVASCRIPT IMAGE LOGIC IS HERE
                        const imgSource = med.image_path 
                            ? `<img src="${med.image_path}" alt="Medicine Image" style="width: 100%; height: 100%; object-fit: cover;">` 
                            : `💊`;

                        const card = `
                            <div class="card medicine-card" data-type="${med.type || ''}" data-category="${med.category || ''}">
                                <div class="medicine-card-content">
                                    <div class="medicine-image-placeholder">
                                        ${imgSource}
                                    </div>
                                    <div><span class="tag">${med.category || 'Medicine'}</span></div>
                                    <h3 class="medicine-title">${med.name}</h3>
                                    <p class="muted" style="font-size: 12px; margin-bottom: 12px;">${med.vendor}</p>
                                </div>
                                <div class="medicine-footer">
                                    <span style="font-size: 18px; font-weight: 700; color: var(--primary);">${parseFloat(med.price).toFixed(2)}<b>৳</b></span>
                                    ${buttonHtml}
                                </div>
                            </div>
                        `;
                        catalogGrid.innerHTML += card;
                    });
                    
                    filterBtns.forEach(b => b.classList.remove('active'));
                    document.querySelector('[data-filter="all"]').classList.add('active');
                })
                .catch(err => console.error("Search AJAX Error: ", err));
            }, 300); 
        });

        // --- Add to Cart AJAX ---
        function addToCart(medicineId) {
            let formData = new FormData();
            formData.append('medicine_id', medicineId);
            formData.append('quantity', 1); 

            fetch('index.php?page=ajax&type=cart_add', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Item added to your cart!');
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                alert('Could not add item to cart.');
            });
        }
    </script>
</body>
</html>