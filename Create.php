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
            <label for="song1">Songs</label>
            <input type="text" name="song1" id="song1" placeholder="song1">
            <div id="hereSong">
                <input type="submit" value="Create Playlist">
                <button onclick="addSong()">Add Song</button>
            </div>
        </form>

        <?php
        echo "<h1 style='color: white; margin: 10px'>Create Song: </h1>";
        ?>
        <form action="/Connection.php" method="POST">
            <input hidden="hidden" value="song" name="create">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Best Song" required>
            <label for="band">Band</label>
            <input type="text" name="band" placeholder="Die Beetles" required>
            <label for="genre">Genre</label>
            <input type="text" name="genre" placeholder="Pop" required>
            <label for="length">Name</label>
            <input type="text" name="length" placeholder="376" required>
            <input type="submit" value="Create Song">
        </form>
        <?php
        echo "<h1 style='color: white; margin: 10px'>Create Band: </h1>";
        ?>
        <form id="formBand" action="/Connection.php" method="POST">
            <input hidden="hidden" value="band" name="create">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="The Wild Band" required>
            <label for="treeMember1">Members</label>
            <input type="text" name="treeMember1" id="treeMember1" placeholder="member1">
            <div id="hereBand">
                <input type="submit" value="Create Band">
                <button onclick="addMember()">Add Member</button>
            </div>
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
    let number = 1;
    function addMember(){
        let elementBefore = document.getElementById('hereBand');
        console.log(elementBefore)
        let label = document.createElement("label");
        label.setAttribute("for", "treeMember" + (number + 1).toString());

        let input = document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("name", "treeMember" + (number + 1).toString());
        input.setAttribute("id", "treeMember" + (number + 1).toString());
        input.setAttribute("placeholder", "member" + (number + 1).toString());

        elementBefore.insertBefore(label,elementBefore.firstChild);
        elementBefore.insertBefore(input,elementBefore.firstChild);
        number++;
    }
    function addSong(){
        let elementBefore = document.getElementById('hereSong');
        console.log(elementBefore)
        let label = document.createElement("label");
        label.setAttribute("for", "song" + (number + 1).toString());

        let input = document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("name", "song" + (number + 1).toString());
        input.setAttribute("id", "song" + (number + 1).toString());
        input.setAttribute("placeholder", "song" + (number + 1).toString());

        elementBefore.insertBefore(label,elementBefore.firstChild);
        elementBefore.insertBefore(input,elementBefore.firstChild);
        number++;
    }
</script>
</html>