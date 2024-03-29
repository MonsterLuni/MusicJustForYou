<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/nav.css">
    <?php require './Connection.php'; ?>
</head>
<?php require 'Header.php'; ?>
<body id='home'>
<h1 id='title'>MusicJustForYou</h1>
<h2 id='secTitle'>Songs</h2>
<div id=songDiv>
    <?php
    // Dokumente anzeigen
    foreach($db->song->find() as $song){
        showSong($song);
    }
    ?>
</div>
</body>
</html>