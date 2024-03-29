<?php
require './Connection.php'; // Verbindung zur Datenbank herstellen

// Definition der deleteSong-Funktion
function deleteSong($data, $isId = false) {
    global $db;

    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data); 
        $db->song->deleteOne(["_id" => $id]);
        echo "hallo";
    } else {
        $db->song->deleteOne(["name" => $data]);
    }
}

// Überprüfen, ob ein POST-Request zum Löschen eines Songs gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["song_id"])) {
        // Aufruf der deleteSong-Funktion mit der übergebenen Song-ID
        deleteSong($_POST["song_id"], true);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Delete</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/nav.css">
</head>
<?php require 'Header.php'; ?>
<body id='home'>
<h1 id='title'>MusicJustForYou</h1>
<h2 id='secTitle'>Songs</h2>
<div id=songDiv>
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
</body>
</html>
