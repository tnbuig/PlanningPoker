<?php 
//create_index.php
include 'connect.php';
include 'header.php';
 
$sql = "SELECT
            game_id,
            game_name,
            game_description
        FROM
            games";
 
$result = mysql_query($sql);
 
if(!$result)
{
    echo "sql query: " . $sql . '</br>' . "result: " . $result . '<br/>';
    echo 'The games could not be displayed, please try again later.';
}
else
{
    if(mysql_num_rows($result) == 0)
    {
        echo 'No games defined yet.';
    }
    else
    {
        //prepare the table
        echo '<table border="1">
              <tr>
                <th>Game</th>
              </tr>'; 
             
        while($row = mysql_fetch_assoc($result))
        {               
            echo '<tr>';
                echo '<td class="leftpart">';
                    echo '<h3><a href="game.php?id=' . $row['game_id'] . '">' . $row['game_name'] . '</a></h3>' . $row['game_description'];
                echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}
 
include 'footer.php';
?>