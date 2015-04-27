<?php
    //create_game.php
    include 'header.php';
    include 'connect.php';
    include 'functions.php'; 

    echo '<h2>Create a Game</h2>';
    if (!isUserSignedIn()) {
        showSignInMessage();
    }
    else
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $time = date('d.m.y');
            //the form hasn't been posted yet, display it
            echo "<form method='post' action=''>
                <br/>Game name :<br/> <br/> <input type='text' value='Pricing Gui Sprint Planing " . $time . " ' name='game_name' />
                <br/>
                <br/>Game description:<br/> <br/><textarea name='game_description' /></textarea>
                <br/><br/><input type='submit' value='Add game' />
             </form>";
        }
        else
        {
            //the form has been posted, so save it
            $sql = 'INSERT INTO games(game_name, game_description)
               VALUES(\'' . mysql_real_escape_string($_POST['game_name']) . '\',\'
                     ' . mysql_real_escape_string($_POST['game_description']) . '\')';
            $result = mysql_query($sql);
            if(!$result)
            {
                printSqlError(mysql_error(),$sql);
            }
            else
            {
                echo 'New game successfully added.';
            }
        }
    }
?>