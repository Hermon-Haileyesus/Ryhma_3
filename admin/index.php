<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../log_in.php");
    exit;}

$stmt = $pdo->query("
    SELECT * FROM products
    ORDER BY products.id DESC
");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Admin – Ruokalista</title>
<link rel="stylesheet" href="../css/styles.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="logo">Ruoka<span>Talo</span></div>

    <nav>
        <a href="index.php"  >Menu</a>
        <a href="add_product.php" >Lisää ruoka</a>
        <a href="orders.php"  >Tilaukset</a>
        <a href="profile.php" >Profiili</a>
        <a href="../logout.php"  >Kirjaudu ulos</a>
    </nav>
</header>

    


<div class="products-grid ">
    <?php foreach ($products as $p): ?>
        <div class="product-card">
            <img src="../images/menu/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">

            <div class="product-info">
                <h3><?= htmlspecialchars($p['name']) ?></h3>
                <p><?= htmlspecialchars($p['description']) ?></p>
                <p class="price"><?= number_format($p['price'], 2) ?> €</p>
                <a href="delete_product.php?id=<?= $p['id'] ?>" class="delete-link">Poista</a>
                
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
