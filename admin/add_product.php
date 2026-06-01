<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../log_in.php");
    exit;
}





if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
  

    // Handle image upload
    $imageName = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $target = "../images/menu/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $stmt = $pdo->prepare("
        INSERT INTO products (name, description, price, image)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([$name, $desc, $price, $imageName]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Lisää tuote – Admin</title>
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

<div class="form-container">
    <h2>Lisää uusi ruoka</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Nimi</label>
        <input type="text" name="name" required>

        <label>Kuvaus</label>
        <textarea name="description" rows="4"></textarea>

        <label>Hinta (€)</label>
        <input type="number" step="0.01" name="price" required>

        <label>Kuva</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Lisää tuote</button>
    </form>
</div>

</body>
</html>
