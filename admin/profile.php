<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit;
}

$stmt = $pdo->prepare("SELECT name, email, address, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <a href="index.php"  class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Menu</a>
        <a href="orders.php"  class="<?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : '' ?>">Tilaukset</a>
        <a href="profile.php"  class="<?= basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : '' ?>">Profiili</a>
        <a href="../logout.php"  class="<?= basename($_SERVER['PHP_SELF']) === '../logout.php' ? 'active' : '' ?>">Kirjaudu ulos</a>
    </nav>
</header>
<div class="register-container">
   <h2>Profiili</h2>

    <p><strong>Käyttäjänimi:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Sähköposti:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Osoite:</strong> <?= htmlspecialchars($user['address'] ?? 'Ei asetettu') ?></p>
    <p><strong>Liittynyt:</strong> <?= htmlspecialchars($user['created_at']) ?></p>

    <br>
    <a href="../logout.php" class="register-btn" style="text-align:center; display:block;  margin-top:20px">Kirjaudu ulos</a>
</div>

</body>
</html>
