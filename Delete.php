<?php
require './Connection.php'; // Verbindung zur Datenbank herstellen

// Definition der deleteSong-Funktion
function deleteSong($data, $isId = false) {
    global $db;

    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data); 
        $db->song->deleteOne(["_id" => $id]);
    } else {
        $db->song->deleteOne(["name" => $data]);
    }
}

// Definition der deleteUser-Funktion
function deleteUser($data, $isId = false) {
    global $db;

    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data); 
        $db->user->deleteOne(["_id" => $id]);
    } else {
        $db->user->deleteOne(["name" => $data]);
    }
}

// Definition der deletePlaylist-Funktion
function deletePlaylist($data, $isId = false) {
    global $db;
    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data); 
        $db->playlist->deleteOne(["_id" => $id]);
    } else {
        $db->playlist->deleteOne(["name" => $data]);
    }
}

// Definition der deleteBand-Funktion
function deleteBand($data, $isId = false) {
    global $db;
    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data); 
        $db->band->deleteOne(["_id" => $id]);
    } else {
        $db->band->deleteOne(["name" => $data]);
    }
}

// Überprüfen, ob ein POST-Request zum Löschen eines Songs, Benutzers, Playlist oder Band gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["song_id"])) {
        // Aufruf der deleteSong-Funktion mit der übergebenen Song-ID
        deleteSong($_POST["song_id"], true);
    }
    if (isset($_POST["user_id"])) {
        // Aufruf der deleteUser-Funktion mit der übergebenen Benutzer-ID
        deleteUser($_POST["user_id"], true);
    }
    if (isset($_POST["playlist_id"])) {
        // Aufruf der deletePlaylist-Funktion mit der übergebenen Playlist-ID
        deletePlaylist($_POST["playlist_id"], true);
    }
    if (isset($_POST["band_id"])) {
        // Aufruf der deleteBand-Funktion mit der übergebenen Band-ID
        deleteBand($_POST["band_id"], true);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/nav.css">
</head>
<?php require 'Header.php'; ?>
<body id='home'>
<h1 id='title'>MusicJustForYou</h1>
<h2 id='secTitle'>Songs</h2>
<div id="songDiv">
    <?php
    foreach($db->song->find() as $song){
        showSongMinimal($song);
        
        ?> 
        <form method="post">
            <input type="hidden" name="song_id" value="<?php echo $song['_id']; ?>">
            <button type="submit">Delete</button>
        </form>
        <?php
    }
    ?>
</div>

<h2 id='secTitle'>Users</h2>
<div id="userDiv">
    <?php
    foreach($db->user->find() as $user){
        showUser($user);
        ?> 
        <form method="post">
            <input type="hidden" name="user_id" value="<?php echo $user['_id']; ?>">
            <button type="submit">Delete</button>
        </form>
        <?php
    }
    ?>
</div>

<h2 id='secTitle'>Playlists</h2>
<div id="playlistDiv">
    <?php
    foreach($db->playlist->find() as $playlist){
        showPlaylist($playlist);
        ?> 
        <form method="post">
            <input type="hidden" name="playlist_id" value="<?php echo $playlist['_id']; ?>">
            <button type="submit">Delete</button>
        </form>
        <?php
    }
    ?>
</div>

<h2 id='secTitle'>Bands</h2>
<div id="bandDiv">
    <?php
    foreach($db->band->find() as $band){
        showBand($band);
        ?> 
        <form method="post">
            <input type="hidden" name="band_id" value="<?php echo $band['_id']; ?>">
            <button type="submit">Delete</button>
        </form>
        <?php
    }
    ?>
</div>

</body>
</html>
