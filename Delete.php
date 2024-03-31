<?php require './Connection.php'; ?>

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
        <div id="songDiv">
            <?php
            foreach($db->song->find() as $song){
                showSongMinimal($song);

                ?>
                <form action="/Connection.php" method="post">
                    <input type="hidden" name="delete" value="song">
                    <input type="hidden" name="song" value="<?php echo $song['_id']; ?>">
                    <button class="delete-button" type="submit">Delete</button>
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
                
                    <form action="/Connection.php" method="post">
                        <input type="hidden" name="delete" value="user">
                        <input type="hidden" name="user" value="<?php echo $user['_id']; ?>">
                        <button class="delete-button" type="submit">Delete</button>
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
                <form action="/Connection.php" method="post">
                    <input type="hidden" name="delete" value="playlist">
                    <input type="hidden" name="playlist" value="<?php echo $playlist['_id']; ?>">
                    <button class="delete-button" type="submit">Delete</button>
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
                <form action="/Connection.php" method="post">
                    <input type="hidden" name="delete" value="band">
                    <input type="hidden" name="band" value="<?php echo $band['_id']; ?>">
                    <button class="delete-button" type="submit">Delete</button>
                </form>
                <?php
            }
            ?>
        </div>
    </body>
</html>