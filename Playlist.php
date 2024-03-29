<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Playlist</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/nav.css">
    <?php require 'Connection.php'; ?>
</head>
<?php require 'Header.php'; ?>
<body id='playlistDiv'>
<?php
foreach($db->playlist->find() as $playlist){
    showPlaylist($playlist);
}
?>
</body>
</html>