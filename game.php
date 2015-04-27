<?php
//create_game.php
include 'connect.php';
include 'header.php';
include 'functions.php'; 

//first select the game based on $_GET['game_id']
$sql = "SELECT
            game_id,
            game_name,
            game_description
        FROM
            games
        WHERE
            game_id = " . mysql_real_escape_string($_GET['id']);
 
$result = mysql_query($sql);
 
if(!$result)
{
    echo 'The game could not be displayed, please try again later.<br/>';
    printSqlError(mysql_error(),$sql);
}
else
{
    if(mysql_num_rows($result) == 0)
    {
        echo 'This game does not exist.';
    }
    else
    {
        //display game data
        while($row = mysql_fetch_assoc($result))
        {
            echo '<h2>' . $row['game_name'] . '</h2>';
        }
     
        //do a query for the stories
        $sql = "SELECT  
                    story_id,
                    story_subject,
                    story_description,
                    story_date,
                    story_game
                FROM
                    stories
                WHERE
                    story_game = " . mysql_real_escape_string($_GET['id']);
         
        $result = mysql_query($sql);
         
        if(!$result)
        {
            echo 'The stories could not be displayed, please try again later.';
            echo '<table border="1">
              <tr>
                <th>Error in DB access</th>
                <th>' . mysql_error() . '</th>
              </tr>
              <tr>
                <th>Sql Query:</th>
                <th>' . $sql . '</th>
              </tr>'; 
        }
        else
        {
            if(mysql_num_rows($result) == 0)
            {
                echo 'There are no stories in this game yet.';
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                      <tr>
                        <th>story</th>
                        <th>Created at</th>
                      </tr>'; 
                     
                while($row = mysql_fetch_assoc($result))
                {               
                    echo '<tr>';
                        echo '<td class="leftpart">';
                            echo '<h3><a href="story.php?id=' . $row['story_id'] . '">' . $row['story_subject'] . '</a></h3>' . $row['story_description'];
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo date('d-m-Y', strtotime($row['story_date']));
                        echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';

            }
        }
    }
}
 
include 'footer.php';
?>