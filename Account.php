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
    echo "<a href='Logout.php' style='color: white; margin: 10px'>Logout</a>";
    echo "<h1 style='color: white; margin: 10px'>" . $_SESSION['user']['username'] . "</h1>";
    echo "<h2 style='color: white; margin: 10px'>" . $_SESSION['user']['email'] . "</h2>";
    echo "<h3 style='color: white; margin: 10px'>Your Playlists: </h3>";
    foreach($db->playlist->find() as $playlist){
        if($playlist['user'] == $_SESSION['user']['_id']){
            showPlaylist($playlist);
        }
    }
    echo "<h3 style='color: white; margin: 10px'>Your Songs: </h3>";
    foreach($db->song->find() as $song){
        if($song['user'] == $_SESSION['user']['_id']){
            showSong($song);
        }
    }
}
else {
    header("Location: /Register.php");
    exit();
}
?>
</body>
</html>
