<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Update</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/form.css">
    <?php require './Connection.php'; ?>
</head>
<?php require 'Header.php'; ?>
<body id='home'>
<?php
session_start();

if(isset($_SESSION['user'])){
    echo "<h1 style='color: white; margin: 10px'>Update Playlist: </h1>";
    ?>
    <form id="formSong" action="/Connection.php" method="POST">
        <label id="playlisttoUpdate">Playlist To Update</label>
        <input hidden="hidden" value="playlist" name="update">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Die Beste Playlist">
        <label>Songs</label>
        <div id="hereSong">
        </div>
        <input type="submit" value="Update Playlist">
    </form>
    <?php
    echo "<h1 style='color: white; margin: 10px'>Update Song: </h1>";
    ?>
    <form action="/Connection.php" method="POST">
        <label id="songtoUpdate">Song To Update</label>
        <input hidden="hidden" value="song" name="update">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Best Song">
        <label for="genre">Genre</label>
        <input type="text" name="genre" placeholder="Pop">
        <label for="length">Length</label>
        <input type="text" name="length" placeholder="376">
        <label>Band</label>
        <div id="hereSongInput">

        </div>
        <input type="submit" value="Update Song">
    </form>
    <?php
    echo "<h1 style='color: white; margin: 10px'>Update Band: </h1>";
    ?>
    <form id="formBand" action="/Connection.php" method="POST">
        <label id="bandtoUpdate">Band To Update</label>
        <input hidden="hidden" value="band" name="update">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="The Wild Band">
        <label>Members</label>
        <div id="hereBand">

        </div>
        <input type="submit" value="Update Band">
    </form>
    <?php
    echo "<h1 style='color: white; margin: 10px'>Update User: </h1>";
    ?>
    <form id="formUser" action="/Connection.php" method="POST">
        <input hidden="hidden" value="user" name="update">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="MonsterLuni">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="monsterluni@gmail.com">
        <input type="submit" value="Update User">
    </form>
    <?php
}
else {
    echo "<h1 id='title'>You have to be logged in to create anything</h1>";
    echo "<a href='Login.php'>Login</a>";
    echo "<a href='Account.php'>Register</a>";
}
?>
</body>
<script>
    let numberSong = 0;
    let numberMember = 1;
    let songIDs = 0;
    let songNames = 0;
    let songIDsTwo = 0;
    let songNamesTwo = 0;
    function updateElements(){
        let element = document.getElementById('hereSong');
        let elements = element.querySelectorAll('select');
        let lastElement = elements[elements.length - 1];
        lastElement.addEventListener('change',makeThing);

        function makeThing(){
            addSong(songIDs,songNames);
            lastElement.removeEventListener('change',makeThing);
            updateElements();
        }
    }
    function updateElementsTwo(){
        let elementTwo = document.getElementById('hereBand');
        let elementsTwo = elementTwo.querySelectorAll('input');
        let lastElementTwo = elementsTwo[elementsTwo.length - 1];
        lastElementTwo.addEventListener('keydown',makeThingTwo);
        function makeThingTwo(){
            addMember();
            lastElementTwo.removeEventListener('keydown',makeThingTwo);
            updateElementsTwo();
        }
    }
    function addMember(){
        let elementBefore = document.getElementById('hereBand');
        let selectArray = elementBefore.querySelectorAll('input');
        let lastSelect = selectArray[selectArray.length - 1]
        let label = document.createElement("label");
        label.setAttribute("for", "treeMember" + (numberMember + 1).toString());

        let input = document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("name", "treeMember" + (numberMember + 1).toString());
        input.setAttribute("id", "treeMember" + (numberMember + 1).toString());

        if(lastSelect === undefined){
            elementBefore.insertBefore(label,elementBefore.firstChild);
            elementBefore.insertBefore(input,elementBefore.firstChild);
        }
        else{
            insertAfter(label,lastSelect);
            insertAfter(input,lastSelect);
        }
        numberMember++;
    }
    function addSong(listOfID, listOfNames){
        songIDs = listOfID;
        songNames = listOfNames;
        let elementBefore = document.getElementById('hereSong');
        let selectArrayTwo = elementBefore.querySelectorAll('select');
        let lastSelect = selectArrayTwo[selectArrayTwo.length - 1];
        let label = document.createElement("label");
        label.setAttribute("for", "song" + (numberSong + 1).toString());

        let input = document.createElement("select");
        input.setAttribute("name", "song" + (numberSong + 1).toString());
        input.setAttribute("id", "song" + (numberSong + 1).toString());
        input.setAttribute("class", "songArray");
        input.value = '0';
        let option = document.createElement("option");
        input.appendChild(option);
        for (let i = 0; i < listOfID.length; i++){
            option = document.createElement("option");
            option.setAttribute("value",listOfID[i]['$oid']);
            option.textContent = listOfNames[i];
            input.appendChild(option);
        }
        if(lastSelect === undefined){
            elementBefore.insertBefore(label,elementBefore.firstChild);
            elementBefore.insertBefore(input,elementBefore.firstChild);
        }
        else{
            insertAfter(label,lastSelect);
            insertAfter(input,lastSelect);
        }
        numberSong++;
    }
    function insertAfter(newNode, referenceNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }
    function addBand(listOfID, listOfNames){
        songIDsTwo = listOfID;
        songNamesTwo = listOfNames;
        let elementBefore = document.getElementById('hereSongInput');
        let label = document.createElement("label");
        label.setAttribute("for", "bandw");

        let input = document.createElement("select");
        input.setAttribute("name", "bandw");
        input.setAttribute("id", "bandw");
        input.value = '0';
        let option = document.createElement("option");
        input.appendChild(option);
        for (let i = 0; i < listOfID.length; i++){
            option = document.createElement("option");
            option.setAttribute("value",listOfID[i]['$oid']);
            option.textContent = listOfNames[i];
            input.appendChild(option);
        }
        elementBefore.insertBefore(label,elementBefore.firstChild);
        elementBefore.insertBefore(input,elementBefore.firstChild);
    }
    function addBandIDSelector(){
        let elementBefore = document.getElementById('bandtoUpdate');

        let label = document.createElement("label");
        label.setAttribute("for", "bandSelect");

        let input = document.createElement("select");
        input.setAttribute("name", "bandSelect");
        input.setAttribute("id", "bandSelect");
        input.setAttribute("class", "bandSelect");
        input.value = '0';

        let option = document.createElement("option");
        input.appendChild(option);
        console.log(songIDsTwo.length);
        for (let i = 0; i < songIDsTwo.length; i++){
            option = document.createElement("option");
            option.setAttribute("value",songIDsTwo[i]['$oid']);
            option.textContent = songNamesTwo[i];
            input.appendChild(option);
        }
        insertAfter(label,elementBefore);
        insertAfter(input,elementBefore);
    }

    let listOfIDPlaylist = 0;
    let listOfNamesPlaylist = 0;
    function addPlaylistIDSelector(){
        let elementBefore = document.getElementById('playlisttoUpdate');

        let label = document.createElement("label");
        label.setAttribute("for", "playlistSelect");

        let input = document.createElement("select");
        input.setAttribute("name", "playlistSelect");
        input.setAttribute("id", "playlistSelect");
        input.setAttribute("class", "playlistSelect");
        input.value = '0';

        let option = document.createElement("option");
        input.appendChild(option);

        for (let i = 0; i < listOfIDPlaylist.length; i++){
            option = document.createElement("option");
            option.setAttribute("value",listOfIDPlaylist[i]['$oid']);
            option.textContent = listOfNamesPlaylist[i];
            input.appendChild(option);
        }
        insertAfter(label,elementBefore);
        insertAfter(input,elementBefore);
    }
    function setPlaylistIDSelector(listOfID, listOfNames){
        listOfIDPlaylist = listOfID;
        listOfNamesPlaylist = listOfNames;
    }

    let listOfIDSong = 0;
    let listOfNamesSong = 0;
    function addSongIDSelector(){
        let elementBefore = document.getElementById('songtoUpdate');

        let label = document.createElement("label");
        label.setAttribute("for", "songSelect");

        let input = document.createElement("select");
        input.setAttribute("name", "songSelect");
        input.setAttribute("id", "songSelect");
        input.setAttribute("class", "songSelect");
        input.value = '0';

        let option = document.createElement("option");
        input.appendChild(option);

        for (let i = 0; i < listOfIDSong.length; i++){
            option = document.createElement("option");
            option.setAttribute("value",listOfIDSong[i]['$oid']);
            option.textContent = listOfNamesSong[i];
            input.appendChild(option);
        }
        insertAfter(label,elementBefore);
        insertAfter(input,elementBefore);
    }
    function setSongIDSelector(listOfID, listOfNames){
        listOfIDSong = listOfID;
        listOfNamesSong = listOfNames;
    }

    <?php
    $names = []; $ids = []; $i = 0;
    foreach ($db->song->find() as $song){
        $names[$i] = $song['name'];
        $ids[$i] = $song['_id'];
        $i++;
    }
    $ids = json_encode($ids);
    $names = json_encode($names);
    echo "addSong($ids,$names);";
    echo "addMember();";
    echo "updateElements();";
    echo "updateElementsTwo();";
    $i = 0; $names = []; $ids = [];
    foreach ($db->band->find() as $band){
        $names[$i] = $band['name'];
        $ids[$i] = $band['_id'];
        $i++;
    }
    $ids = json_encode($ids);
    $names = json_encode($names);
    echo "addBand($ids,$names);";
    echo "addBandIDSelector();";

    $i = 0; $names = []; $ids = [];
    foreach ($db->playlist->find() as $playlist){
        if($_SESSION['user']['_id'] == $playlist['user']){
            $names[$i] = $playlist['name'];
            $ids[$i] = $playlist['_id'];
            $i++;
        }
    }
    $ids = json_encode($ids);
    $names = json_encode($names);
    echo "setPlaylistIDSelector($ids,$names);";
    echo "addPlaylistIDSelector();";

    $i = 0; $names = []; $ids = [];
    foreach ($db->song->find() as $song){
        if($_SESSION['user']['_id'] == $song['user']){
            $names[$i] = $song['name'];
            $ids[$i] = $song['_id'];
            $i++;
        }
    }
    $ids = json_encode($ids);
    $names = json_encode($names);
    echo "setSongIDSelector($ids,$names);";
    echo "addSongIDSelector();";
    ?>
</script>
</html>