<!DOCTYPE html>
<html>
<head>
    <title>MJFU - Create</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/form.css">
    <?php require './Connection.php'; ?>
</head>
<?php require 'Header.php'; ?>
<body id='home'>
    <?php
    session_start();
    // Dokumente anzeigen
    if(isset($_SESSION['user'])){
        echo "<h1 style='color: white; margin: 10px'>Create Playlist: </h1>";
        ?>
        <form id="formSong" action="/Connection.php" method="POST">
            <input hidden="hidden" value="playlist" name="create">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Die Beste Playlist" required>
            <label for="otherName">Other Attribute (Name)</label>
            <input type="text" name="otherName" placeholder="-">
            <label for="otherValue">Other Attribute (Value)</label>
            <input type="text" name="otherValue" placeholder="-">
            <label>Songs</label>
            <div id="hereSong">

            </div>
            <input type="submit" value="Create Playlist">
        </form>
        <?php
        echo "<h1 style='color: white; margin: 10px'>Create Song: </h1>";
        ?>
        <form action="/Connection.php" method="POST">
            <input hidden="hidden" value="song" name="create">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Best Song" required>
            <label for="genre">Genre</label>
            <input type="text" name="genre" placeholder="Pop" required>
            <label for="length">Length</label>
            <input type="text" name="length" placeholder="376" required>
            <label for="otherName">Other Attribute (Name)</label>
            <input type="text" name="otherName" placeholder="-">
            <label for="otherValue">Other Attribute (Value)</label>
            <input type="text" name="otherValue" placeholder="-">
            <label>Band</label>
            <div id="hereSongInput">

            </div>
            <input type="submit" value="Create Song">
        </form>
        <?php
        echo "<h1 style='color: white; margin: 10px'>Create Band: </h1>";
        ?>
        <form id="formBand" action="/Connection.php" method="POST">
            <input hidden="hidden" value="band" name="create">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="The Wild Band" required>
            <label for="otherName">Other Attribute (Name)</label>
            <input type="text" name="otherName" placeholder="-">
            <label for="otherValue">Other Attribute (Value)</label>
            <input type="text" name="otherValue" placeholder="-">
            <label>Members</label>
            <div id="hereBand">

            </div>
            <input type="submit" value="Create Band">
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
    ?>
</script>

</html>