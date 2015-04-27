<?php
//create_game.php
include 'connect.php';
include 'header.php';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    echo 'This file cannot be called directly.';
}
else
{
    //check for sign in status
    if(!$_SESSION['signed_in'])
    {
        echo 'You must be signed in to post a reply.';
    }
    else
    {
        //a real user posted a real reply
        $sql = "INSERT INTO 
                    posts(post_content,
                          post_date,
                          post_story,
                          post_by) 
                VALUES ('" . $_POST['reply-content'] . "',
                        NOW(),
                        " . mysql_real_escape_string($_GET['id']) . ",
                        " . $_SESSION['user_id'] . ")";
                         
        $result = mysql_query($sql);
                         
        if(!$result)
        {
            echo 'Your reply has not been saved, please try again later.';
        }
        else
        {
            echo 'Your reply has been saved, check out <a href="story.php?id=' . htmlentities($_GET['id']) . '">the story</a>.';
        }
    }
}
 
include 'footer.php';
?>