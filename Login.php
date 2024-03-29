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
session_start();
// Dokumente anzeigen
if(isset($_SESSION['user'])){
    header("Location: /Account.php");
    exit();
}
else {
    ?>
    <form action="/Connection.php" method="POST">
        <input hidden="hidden" value="Login" name="type">
        <label for="username"></label>
        <input type="text" name="username" placeholder="MonsterLuni" required>
        <label for="password"></label>
        <input type="password" name="password" placeholder="monstErluni£9365" required>
        <input type="submit" value="Einloggen">
    </form>
 <?php
}
?>
</body>
</html>

