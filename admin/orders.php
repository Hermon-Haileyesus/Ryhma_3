<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../log_in.php");
    exit;
}

$stmt = $pdo->query("
    SELECT orders.*, users.name
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.created_at DESC
");

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Tilaukset – Admin</title>

<link rel="stylesheet" href="../css/styles.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

.orders-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.orders-table th {
    background: #ff6b35;
    color: white;
    padding: 14px;
    text-align: left;
    font-size: 15px;
}

.orders-table td {
    padding: 14px;
    border-bottom: 1px solid #eee;
    vertical-align: top;
}

.orders-table tr:hover {
    background: #f9f9f9;
}

.order-products {
    margin: 0;
    padding-left: 18px;
}

.order-products li {
    margin-bottom: 6px;
}

.empty-message {
    text-align: center;
    font-size: 18px;
    margin-top: 30px;
}

.orders-wrapper {
    width: 95%;
    max-width: 1200px;
    margin: 40px auto;
}

</style>

</head>
<body>

<header>
    <div class="logo">Ruoka<span>Talo</span></div>

    <nav>
        <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Menu</a>

        <a href="orders.php" class="<?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : '' ?>">Tilaukset</a>

        <a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : '' ?>">Profiili</a>

        <a href="../logout.php">Kirjaudu ulos</a>
    </nav>
</header>

<div class="orders-wrapper">

<?php if (empty($orders)): ?>

    <p class="empty-message">
        Tilaukset on tyhjä.
    </p>

<?php else: ?>

<table class="orders-table">

    <thead>
        <tr>
           
            <th>Asiakas</th>
          
            <th>Hinta</th>
            <th>Tuote</th>
            <th>Päivämäärä</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach ($orders as $o): ?>

        

        <tr>

            

            <td>
                <?= htmlspecialchars($o['name']) ?>
            </td>

          

            <td>
                <?= number_format($o['total'], 2) ?> €
            </td>
           
    <td>
        <ul class="order-products">
            <?php
                $stmt = $pdo->prepare("
                    SELECT order_items.*, products.name 
                    FROM order_items
                    JOIN products ON order_items.product_id = products.id
                    WHERE order_items.order_id = ?
                ");
                $stmt->execute([$o['id']]);
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($items as $item):
            ?>
                <li>
                    <?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </td>
            <td>
                <?= $o['created_at'] ?>
            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>

</table>

<?php endif; ?>

</div>

</body>
</html>

