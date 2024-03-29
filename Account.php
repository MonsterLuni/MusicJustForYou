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
    foreach($db->song->find() as $song){
        showSong($song);
    }
}
else {
    header("Location: /Register.php");
    exit();
}
?>
</body>
</html>
