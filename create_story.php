<?php
include 'connect.php';
include 'header.php';
include 'functions.php'; 
 
echo '<h2>Create a story</h2>';
if(isUserSignedIn())
{
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {   
        //the form hasn't been posted yet, display it
        //retrieve the games from the database for use in the dropdown
        $sql = "SELECT
                    game_id,
                    game_name,
                    game_description
                FROM
                    games";
         
        $result = mysql_query($sql);
         
        if(!$result)
        {
            //the query failed, uh-oh :-(
            echo 'Error while selecting from database. Please try again later.';
            printSqlError(mysql_error(),$sql);
        }
        else
        {
            $canCreateStory = canCreateStory($_SESSION['user_level'],mysql_num_rows($result));
            
            if($canCreateStory)
            {
                echo '<form method="post" action="">
                    Title :<br/> <br/> <input type="text" name="story_subject" />
                      Game : '; 
                 
                echo '<select name="story_game">';
                    while($row = mysql_fetch_assoc($result))
                    {
                        echo '<option value="' . $row['game_id'] . '">' . $row['game_name'] . '</option>';
                    }
                echo '</select><br/><br/>'; 
                     
                echo 'Description: <br/><br/><textarea name="story_description" /></textarea>
                      <br/><br/><input type="submit" value="Create story" />
                 </form>';
            }
        }
    }
    else
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysql_query($query);
         
        if(!$result)
        {
            //Damn! the query failed, quit
            echo 'An error occured while creating your story. Please try again later.';
        }
        else
        {
     
            //the form has been posted, so save it
            //insert the story into the stories table first, then we'll save the post into the posts table
            $sql = "INSERT INTO 
                        stories(story_subject,
                                story_description,
                               story_date,
                               story_game,
                               story_by)
                   VALUES('" . mysql_real_escape_string($_POST['story_subject']) . "',
                            '" . mysql_real_escape_string($_POST['story_description']) . "',
                            NOW(),
                            " . mysql_real_escape_string($_POST['story_game']) . ",
                            " . $_SESSION['user_id'] . "
                            )";
                      
            $result = mysql_query($sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'An error occured while inserting your data. Please try again later.' . mysql_error();
                echo '</br>' . $sql; 
                $sql = "ROLLBACK;";
                $result = mysql_query($sql);
            }
            else
            {
                //the first query worked, now start the second, votes query
                //retrieve the id of the freshly created story for usage in the votes query
                $storyid = mysql_insert_id();
                 
                
                $sql = "COMMIT;";
                $result = mysql_query($sql);
                 
                //after a lot of work, the query succeeded!
                echo 'You have successfully created <a href="story.php?id='. $storyid . '">your new story</a>.';
               
            }
        }
    }
}
 
include 'footer.php';
?>