<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Song</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/nav.css">
    <?php require 'Connection.php'; ?>
</head>
<?php require 'Header.php'; ?>
<body id='home'>
<h1 id='secTitle'>Chosen Song</h1>
<div id=songDiv>
    <?php
    // Dokumente anzeigen
    var_dump($_REQUEST['id']);
    var_dump(getSong($_REQUEST['id'],true));
    showSongMaximum(getSong($_REQUEST['id'],true));
    ?>
</div>
</body>
</html>
