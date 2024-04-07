<?php
require 'vendor/autoload.php'; // include Composer's autoloader
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->music;

# REGISTER / LOGIN ---------------------------
function getSongsFromPOST(): array
{
    $songs = [];
    for ($i = 0; $i < sizeof($_POST); $i++){
        if(isset($_POST['song' . $i]) && $_POST['song' . $i] != ""){
            $text = $_POST["song" . $i];
            $song = getSong($text,true)['_id'];
            if($song != null){
                $songs[$i] = $song;
            }
        }
    }
    return $songs;
}
if(isset($_POST['type'])){
    session_start();
    if($_POST['type'] == "Register"){
        addUser($_POST['username'],$_POST['email'],$_POST['password']);
        $_SESSION['user'] = getUser($_POST['username'],false);
    }elseif ($_POST['type'] == "Login"){
        if(validateUserInput($_POST['username'],$_POST['password'])){
            $_SESSION['user'] = getUser($_POST['username'],false);
        }
    }
    unset($_POST['type']);
    header("Location: /Account.php");
    exit();
}
if(isset($_POST['create'])){
    session_start();
    switch ($_POST['create']){
        case "band":
            $members = [];
            for ($i = 0; $i < sizeof($_POST); $i++){
                if(isset($_POST['treeMember' . $i]) && $_POST['treeMember' . $i] != ""){
                    $members[$i] = $_POST['treeMember' . $i];
                }
            }
            addBand($_POST['name'],$members,$_POST['otherName'],$_POST['otherValue']);
            header("Location: /Create.php");
            break;
        case "song":
            $band_id = getband($_POST['bandw'],true)['_id'];
            if($band_id != null){
                addSong($_POST['name'],$band_id,$_POST['genre'],$_POST['length'],$_SESSION['user']['_id'],$_POST['otherName'],$_POST['otherValue']);
            }
            header("Location: /Create.php");
            break;
        case "playlist":
            $songs = getSongsFromPOST();
            addPlaylist($_POST['name'],$songs,$_SESSION['user']['_id'],$_POST['otherName'],$_POST['otherValue']);
            header("Location: /Create.php");
            break;
    }
}
if(isset($_POST['update'])){
    session_start();
    switch ($_POST['update']){
        case "band":
            $bandJson = [];
            $members = [];
            for ($i = 0; $i < sizeof($_POST); $i++){
                if(isset($_POST['treeMember' . $i]) && $_POST['treeMember' . $i] != ""){
                    $members[$i] = $_POST['treeMember' . $i];
                }
            }
            if($_POST['name'] == ""){
                $bandJson = array("members" => $members);
            } else if (sizeof($members) < 1){
                $bandJson = array("name" => $_POST['name']);
            } else{
                $bandJson = array("name" => $_POST['name'], "members" => $members);
            }
            update($_POST["bandSelect"],$bandJson,$_POST['update']);
            header("Location: /Update.php");
            break;
        case "song":
            $bandJson = [];
            if($_POST['name'] != ""){
                $bandJson = array("name" => $_POST['name']);
            }
            if ($_POST['bandw'] != ""){
                $bandJson = array_merge($bandJson, array("band" => getBand($_POST['bandw'],true)['_id']));
            }
            if ($_POST['genre'] != ""){
                $bandJson = array_merge($bandJson, array("genre" => $_POST['genre']));
            }
            if ($_POST['length'] != ""){
                $bandJson = array_merge($bandJson, array("length" => $_POST['length']));
            }
            update($_POST["songSelect"],$bandJson,$_POST['update']);
            header("Location: /Update.php");
            break;
        case "playlist":
            $bandJson = [];
            $songs = [];
            for ($i = 0; $i < sizeof($_POST); $i++){
                if(isset($_POST['song' . $i]) && $_POST['song' . $i] != ""){
                    $text = $_POST["song" . $i];
                    if($text != null){
                        $text = getSong($text,true)['_id'];
                        $songs[$i] = $text;
                    }
                }
            }
            var_dump($_POST['song1']);
            if($_POST['name'] == ""){
                $bandJson = array("songs" => $songs);
            } else if (sizeof($songs) < 1){
                $bandJson = array("name" => $_POST['name']);
            } else{
                $bandJson = array("name" => $_POST['name'], "songs" => $songs);
            }
            update($_POST["playlistSelect"],$bandJson,$_POST['update']);
            header("Location: /Update.php");
            break;
        case "user":
            $bandJson = [];
            if($_POST['username'] != ""){
                $bandJson = array("username" => $_POST['username']);
            }
            if ($_POST['email'] != ""){
                $bandJson = array_merge($bandJson, array("email" => $_POST['email']));
            }
            update($_SESSION['user']['_id'],$bandJson,$_POST['update']);
            $_SESSION['user'] = getUser($_SESSION['user']['_id'],true);
            header("Location: /Update.php");
            break;
    }
}
if(isset($_POST['delete'])){
    switch ($_POST['delete']){
        case "band":
            deleteBand($_POST["band"], true);
            header("Location: /Delete.php");
            break;
        case "song":
            deleteSong($_POST["song"], true);
            header("Location: /Delete.php");
            break;
        case "playlist":
            deletePlaylist($_POST["playlist"], true);
            header("Location: /Delete.php");
            break;
        case "user":
            deleteUser($_POST["user_id"], true);
            header("Location: /Delete.php");
            break;
    }
}
function validateUserInput($username, $password): bool
{
    $user = getUser($username,false);
    if($user != null){
        if(password_verify($password, $user['password'])){
            return true;
        }
    }
    return false;
}

# SHOW ---------------------------
function showPlaylist($playlist): void
{
    echo "<div id='playlist'>";
    echo "<h1>" . $playlist['name'] . "</h1>";
    foreach($playlist['songs'] as $song){
        showSongMinimal(getSong($song, true));
    }
    echo "<p>" . "This Playlist is made by: " . getUser($playlist['user'],true)['username'] . "</p>";
    echo "<p>" . "ID: " . $playlist['user'] . "</p>";
    echo "</div>";
}
function showSongMinimal($song): void
{
    echo "<a href=". "Song.php?id=" . $song['_id'] . ">";
    echo "<div id='songMinimal'>";
    echo "<h1>" . $song['name'] . "</h1>";
    echo "<p>" . getBand($song['band'],true)['name'] . "</p>";
    echo "<p>" . $song['genre'] . "</p>";
    echo "<p>" . $song['length'] . "s" . "</p>";
    echo "</div>";
    echo "</a>";
}
function showSong($song): void
{
    echo "<a href=". "Song.php?id=" . $song['_id'] . ">";
    echo "<div id='song'>";
    echo "<h1>" . $song['name'] . "</h1>";
    showBand(getBand($song['band'],true));
    echo "<p>" . "Genre: " . $song['genre'] . "</p>";
    echo "<p>" . "Dauer: " . $song['length'] . "</p>";
    echo "</div>";
    echo "</a>";
}
function showSongMaximum($song): void
{
    echo "<div id='song'>";
    echo "<h1>" . $song['name'] . "</h1>";
    showBand(getBand($song['band'],true));
    echo "<p>" . "Genre: " . $song['genre'] . "</p>";
    echo "<p>" . "Dauer: " . $song['length'] . "</p>";
    showUser(getUser($song['user'],true));
    echo "</div>";
    echo "</a>";
}
function showBand($band): void
{
    echo "<div id='band'>";
    echo "<h2>" . $band['name'] . "</h2>";
    echo "<h3>" . "Members: " . "</h3>";
    foreach ($band['members'] as $member){
        echo "<p>" . $member .  "</p>";
    }
    echo "</div>";
}
function showUser($user): void
{
    echo "<p>" . $user['username'] .  "</p>";
    echo "<p>" . $user['email'] .  "</p>";
    echo "<p>" . $user['password'] .  "</p>";
}

# GET ---------------------------
function getSong($data, $id): object|array|null
{
    global $db;
    if($id){
        return $db->song->findOne(["_id" => new MongoDB\BSON\ObjectId($data)]);
    }else{
        return $db->song->findOne(["name" => $data]);
    }
}
function getUser($data, $id): object|array|null
{
    global $db;
    if($id){
        return $db->user->findOne(["_id" => new MongoDB\BSON\ObjectId($data)]);
    }
    else{
        return $db->user->findOne(["username" => $data]);
    }
}
function getPlaylist($data, $id): object|array|null
{
    global $db;
    if($id){
        return $db->playlist->findOne(["_id" => new MongoDB\BSON\ObjectId($data)]);
    }else{
        return $db->playlist->findOne(["name" => $data]);
    }
}
function getBand($data, $id): object|array|null
{
    global $db;
    if($id){
        return $db->band->findOne(["_id" => new MongoDB\BSON\ObjectId($data)]);
    }else{
        return $db->band->findOne(["name" => $data]);
    }
}

# POST ---------------------------
function addSong($name,$band,$genre,$length,$user, $otherName, $otherValue): void
{
    global $db;
    if($otherName == ""){
        $db->song->insertOne(["name" => $name, "band" => $band, "genre" => $genre, "length" => $length, "user" => $user]);
    }
    else{
        $db->song->insertOne(["name" => $name, "band" => $band, "genre" => $genre, "length" => $length, "user" => $user, $otherName => $otherValue]);
    }

}
function addUser($name, $email, $password): void
{
    global $db;
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $db->user->insertOne(["username" => $name, "email" => $email, "password" => $hash]);
}
function addPlaylist($name,$songs,$user, $otherName, $otherValue): void
{
    global $db;
    var_dump($otherName);
    if($otherName == ""){
        $db->playlist->insertOne(["name" => $name, "songs" => $songs, "user" => $user]);
    }
    else{
        $db->playlist->insertOne(["name" => $name, "songs" => $songs, "user" => $user, $otherName => $otherValue]);
    }
}
function addBand($name, $members, $otherName, $otherValue): void
{
    global $db;
    if($otherName == ""){
        $db->band->insertOne(["name" => $name, "members" => (array)$members]);
    }
    else{
        $db->band->insertOne(["name" => $name, "members" => (array)$members, $otherName => $otherValue]);
    }
}

# DELETE ---------------------------
function deleteSong($data, $isId = false): void{
    global $db;

    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data);
        $db->song->deleteOne(["_id" => $id]);
    } else {
        $db->song->deleteOne(["name" => $data]);
    }
}
function deleteUser($data, $isId = false): void{
    global $db;

    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data);
        $db->user->deleteOne(["_id" => $id]);
    } else {
        $db->user->deleteOne(["name" => $data]);
    }
}
function deletePlaylist($data, $isId = false): void{
    global $db;
    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data);
        $db->playlist->deleteOne(["_id" => $id]);
    } else {
        $db->playlist->deleteOne(["name" => $data]);
    }
}
function deleteBand($data, $isId = false): void{
    global $db;
    if ($isId) {
        $id = new MongoDB\BSON\ObjectId($data);
        $db->band->deleteOne(["_id" => $id]);
    } else {
        $db->band->deleteOne(["name" => $data]);
    }
}

# UPDATE ---------------------------
function update($id, $updateData, $type): void
{
    global $db;

    $filter = ["_id" => new MongoDB\BSON\ObjectId($id)];
    $update = ['$set' => $updateData];

    switch ($type){
        case "band":
            $db->band->updateOne($filter, $update);
            break;
        case "song":
            $db->song->updateOne($filter, $update);
            break;
        case "playlist":
            $db->playlist->updateOne($filter, $update);
            break;
        case "user":
            $db->user->updateOne($filter, $update);
            break;
    }
}
?>