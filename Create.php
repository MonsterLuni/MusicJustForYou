<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Create</title>
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
        foreach($db->song->find() as $song){
            showSong($song);
        }
    }
    else {
        echo "<h1 id='title'>You have to be logged in to create anything</h1>";
        echo "<a href='Login.php'>Login</a>";
        echo "<a href='Account.php'>Register</a>";
    }
    ?>
</body>
</html>