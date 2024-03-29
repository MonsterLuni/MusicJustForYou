<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Account</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/nav.css">
    <?php require './Connection.php'; ?>
</head>
<?php require 'Header.php'; ?>
<body id='home'>
<?php
// Dokumente anzeigen
if(isset($_SESSION['user'])){
    header("Location: /Account.php");
    exit();
}
else {
    ?>
    <form action="/Connection.php" method="POST">
        <input hidden="hidden" value="Register" name="type">
        <label for="username"></label>
        <input type="text" name="username" placeholder="MonsterLuni" required>
        <label for="email"></label>
        <input type="email" name="email" placeholder="monsterluni@gmail.com" required>
        <label for="password"></label>
        <input type="password" name="password" placeholder="monstErluni£9365" required>
        <input type="submit" value="Benutzer Erstellen">
    </form>

    <?php
}
?>
</body>
</html>

