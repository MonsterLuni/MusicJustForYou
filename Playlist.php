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
echo "<div id='songDiv'>";
foreach($db->playlist->find() as $playlist){
    showPlaylist($playlist);
}
echo "</div>";
?>
</body>
</html>