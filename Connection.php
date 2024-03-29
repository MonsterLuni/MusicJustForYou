<?php
require 'vendor/autoload.php'; // include Composer's autoloader
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->music;
# REGISTER / LOGIN ---------------------------
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

# SHOW ---------------------------
function showPlaylist($playlist): void
{
    echo "<div id='playlist'>";
    echo "<h1>" . $playlist['name'] . "</h1>";
    foreach($playlist['songs'] as $song){
        showSongMinimal(getSong($song,true));
    }
    echo "<p>" . "This Playlist is made by: " . getUser($playlist['user'],true)['username'] . "</p>";
    echo "<p>" . "ID: " . $playlist['user'] . "</p>";
    echo "</div>";
}
function showSongMinimal($song): void
{
    echo "<div id='songMinimal'>";
    echo "<h1>" . $song['name'] . "</h1>";
    echo "<p>" . getBand($song['band'],true)['name'] . "</p>";
    echo "<p>" . $song['genre'] . "</p>";
    echo "<p>" . $song['length'] . "s" . "</p>";
    echo "</div>";
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
# GET -------------------------
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
function addSong($name,$band,$genre,$length,$user): void
{
    global $db;
    $db->song->insertOne(["name" => $name, "band" => $band, "genre" => $genre, "length" => $length, "user" => $user]);
}
function addUser($name, $email, $password): void
{
    global $db;
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $db->user->insertOne(["username" => $name, "email" => $email, "password" => $hash]);
}
function addPlaylist($name,$songs,$user): void
{
    global $db;
    $db->playlist->insertOne(["name" => $name, "songs" => $songs, "user" => $user]);
}
function addBand($name, $members): void
{
    global $db;
    $db->band->insertOne(["name" => $name, "members" => $members]);
}

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

function deleteUser($data, $isId = false){
     global $db;

     if($isId){
         $id = new MongoDB\BSON\ObjectId($data); 
         $db->user->deleteOne(["_id" => $id]);;
     }
      else{
         $db->user->deleteOne(["name" => $data]);
     }
}

function deletePlaylist($data, $isId = false){
     global $db;
     if($isId){
         $id = new MongoDB\BSON\ObjectId($data); 
         $db->playlist->deleteOne(["_id" => $id]);;
     }
     else{
         $db->playlist->deleteOne(["name" => $data]);
     }
}

function deleteBand($data, $isId = false){
     global $db;
     if($isId){
         $id = new MongoDB\BSON\ObjectId($data); 
         $db->band->deleteOne(["_id" => $id]);;
     }
     else{
         $db->band->deleteOne(["name" => $data]);
     }
 }

function updateSong($id, $updateData) {
    global $db;

    $filter = ["_id" => new MongoDB\BSON\ObjectId($id)];
    $update = ['$set' => $updateData];

    $result = $db->song->updateOne($filter, $update);

    if ($result->getModifiedCount() > 0) {
        echo "Song erfolgreich aktualisiert.";
    } else {
        echo "Es wurde kein Song aktualisiert.";
    }
}

function updateUser($id, $updateData) {
    global $db;

    $filter = ["_id" => new MongoDB\BSON\ObjectId($id)];
    $update = ['$set' => $updateData];

    $result = $db->user->updateOne($filter, $update);

    if ($result->getModifiedCount() > 0) {
        echo "User erfolgreich aktualisiert.";
    } else {
        echo "Es wurde kein User aktualisiert.";
    }
}

function updatePlaylist($id, $updateData) {
    global $db;

    $filter = ["_id" => new MongoDB\BSON\ObjectId($id)];
    $update = ['$set' => $updateData];

    $result = $db->playlist->updateOne($filter, $update);

    if ($result->getModifiedCount() > 0) {
        echo "Playlist erfolgreich aktualisiert.";
    } else {
        echo "Es wurde keine Playlist aktualisiert.";
    }
}

function updateBand($id, $updateData) {
    global $db;

    $filter = ["_id" => new MongoDB\BSON\ObjectId($id)];
    $update = ['$set' => $updateData];

    $result = $db->band->updateOne($filter, $update);

    if ($result->getModifiedCount() > 0) {
        echo "Band erfolgreich aktualisiert.";
    } else {
        echo "Es wurde keine Band aktualisiert.";
    }
}

?>