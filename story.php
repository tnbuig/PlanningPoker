<div>
    <?php
    //create_story.php
    include 'connect.php';
    include 'header.php';
    include 'functions.php'; 

        if(isUserSignedIn())
        {
            //first select the story based on $_GET['story_id']
            $resultForStoryquery =  GetStoryFromById(mysql_real_escape_string($_GET['id']));
            if($resultForStoryquery)
            {
                if($_SERVER['REQUEST_METHOD'] == 'POST')//if the  user request to vote 
                {
                    /* so, the form has been posted, we'll process the data in three steps:
                        1.  Check the data
                        2.  Let the user refill the wrong fields (if necessary)
                        3.  Varify if the data is correct and return the correct response
                    */
                    $errors = array(); /* declare the array for later use */
                     
                    if(!isset($_POST['vote']))
                    {
                        $errors[] = 'The Vote field must not be empty.';
                    }
                    $vote = mysql_real_escape_string($_POST['vote']) ;
                    if(!isset($_GET['id']))
                    {
                        $errors[] = 'There is some unexpected error in the website - Please try to sign out and Sign in again.';
                    }
                    $user_id =  mysql_real_escape_string($_GET['id']);
                    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
                    {
                        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
                        echo '<ul>';
                        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
                        {
                            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
                        }
                        echo '</ul>';
                    }
                    else
                    {
                        //the form has been posted without errors, so save it
                        //notice the use of mysql_real_escape_string, keep everything safe!
                        transationForVote($vote,$user_id);
                    }
                }
                else
                { // the story exist and the user did not request to vote
                    //display story data
                    $storyId = mysql_real_escape_string($_GET['id']);
                    while($row = mysql_fetch_assoc($resultForStoryquery))
                    {
                        if(isset($_SESSION['isFinal'])){
                            $final =  $_SESSION['isFinal'];
                        }
                        else{
                             $final = false;
                        }

                        if($final){
                            echo 'This story does not open for voting.';
                            echo '<h2>Votes for ′' . $row['story_subject'] . '′ story</h2>';
                            printVotesForCloseStory($storyId);
                        }else
                        {
                            printVotesForOpenStory($storyId);   
                        }
                    }
                }  
            }
        }
    ?>
    <div>
        <?php
        include 'riddle.php';
        include 'footer.php';
        ?>
    </div>
</div>