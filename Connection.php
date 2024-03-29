<?php
require 'vendor/autoload.php'; // include Composer's autoloader
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->music;
# REGISTER / LOGIN ---------------------------
function registerUser($username,$email,$password)
{
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $db->user->insertOne(["username" => $username,"email" => $email,"password" => $hash]);
}

if(isset($_POST['type'])){
    if($_POST['type'] == "Register"){
        registerUser($_POST['username'],$_POST['email'],$_POST['password']);
    }elseif ($_POST['type'] == "Login"){
        if(validateUserInput()){
            $_SESSION['user'];
        }
    }
    unset($_POST['type']);
    header("Location: /Account.php");
    exit();
}

# SHOW ---------------------------
function showPlaylist($playlist){
    echo "<div id='playlist'>";
    echo "<h1>" . $playlist['name'] . "</h1>";
    foreach($playlist['songs'] as $song){
        showSongMinimal(getSong($song,true));
    }
    echo "<p>" . "This Playlist is made by: " . getUser($playlist['user'],true)['username'] . "</p>";
    echo "<p>" . "ID: " . $playlist['user'] . "</p>";
    echo "</div>";
}
function showSongMinimal($song){
    echo "<div id='songMinimal'>";
    echo "<h1>" . $song['name'] . "</h1>";
    echo "<p>" . getBand($song['band'],true)['name'] . "</p>";
    echo "<p>" . $song['genre'] . "</p>";
    echo "<p>" . $song['length'] . "s" . "</p>";
    echo "</div>";
}
function showSong($song){
    echo "<a href=". "Song.php?id=" . $song['_id'] . ">";
    echo "<div id='song'>";
    echo "<h1>" . $song['name'] . "</h1>";
    showBand(getBand($song['band'],true));
    echo "<p>" . "Genre: " . $song['genre'] . "</p>";
    echo "<p>" . "Dauer: " . $song['length'] . "</p>";
    echo "</div>";
    echo "</a>";
}
function showSongMaximum($song){
    echo "<div id='song'>";
    echo "<h1>" . $song['name'] . "</h1>";
    showBand(getBand($song['band'],true));
    echo "<p>" . "Genre: " . $song['genre'] . "</p>";
    echo "<p>" . "Dauer: " . $song['length'] . "</p>";
    showUser(getUser($song['user'],true));
    echo "</div>";
    echo "</a>";
}
function showBand($band){
    echo "<div id='band'>";
    echo "<h2>" . $band['name'] . "</h2>";
    echo "<h3>" . "Members: " . "</h3>";
    foreach ($band['members'] as $member){
        echo "<p>" . $member .  "</p>";
    }
    echo "</div>";
}
function showUser($user){
    echo "<p>" . $user['username'] .  "</p>";
    echo "<p>" . $user['email'] .  "</p>";
    echo "<p>" . $user['password'] .  "</p>";
}
# GET -------------------------
function getSong($data, $id){
    global $db;
    if($id){
        return $db->song->findOne(["_id" => new MongoDB\BSON\ObjectId($data)]);
    }else{
        return $db->song->findOne(["name" => $data]);
    }
}
function getUser($data, $id){
    global $db;
    if($id){
        return $db->user->findOne(["_id" => new MongoDB\BSON\ObjectId($data)]);
    }
    else{
        return $db->user->findOne(["username" => $data]);
    }
}
function getPlaylist($data, $id){
    global $db;
    if($id){
        return $db->playlist->findOne(["_id" => new MongoDB\BSON\ObjectId($data)]);
    }else{
        return $db->playlist->findOne(["name" => $data]);
    }
}
function getBand($data, $id){
    global $db;
    if($id){
        return $db->band->findOne(["_id" => new MongoDB\BSON\ObjectId($data)]);
    }else{
        return $db->band->findOne(["name" => $data]);
    }
}
# POST ---------------------------
//addUser("Der Wilde Kater", "kater@gmail.com", "Kater");
//addBand("Der Wilden Kater", ["Kater1","Kater2","Kater3"]);
//addSong("Darude Sandstorm", getBand("Der Wilden Kater",false)['_id'],"Rock",248,getUser('Der Wilde Kater',false)['_id']);
//addPlaylist("BestPlaylist", [getSong("Blau",false)['_id'],getSong("Darude Sandstorm",false)['_id']],getUser("Der Wilde Kater",false)['_id']);
function addSong($name,$band,$genre,$length,$user){
    global $db;
    $db->song->insertOne(["name" => $name, "band" => $band, "genre" => $genre, "length" => $length, "user" => $user]);
}
function addUser($name, $email, $password){
    global $db;
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $db->user->insertOne(["username" => $name, "email" => $email, "password" => $hash]);
}
function addPlaylist($name,$songs,$user){
    global $db;
    $db->playlist->insertOne(["name" => $name, "songs" => $songs, "user" => $user]);
}
function addBand($name, $members){
    global $db;
    $db->band->insertOne(["name" => $name, "members" => $members]);
}
?>