<?php
    
    function isUserSignedIn(){
        if(!isset($_SESSION['signed_in']) || ($_SESSION['signed_in']== false))
        {
            //the user is not signed in
            return false;
        }
        return true;
    }

    function showSignInMessage(){
        echo 'Take it easy buddy!, <a href="/signin.php">signed in</a> first.';
    }

	function printSqlError($sql_error,$faulty_query) {
	    echo '<table border="1">
              <tr>
                <th>Error in DB access</th>
                <th>' . $sql_error . '</th>
              </tr>
              <tr>
                <th>Sql Query:</th>
                <th>' . $faulty_query . '</th>
              </tr>'; 
         echo "</table>";
	}

    function canCreateStory($user_level,$num_result_rows)
    {
        if($num_result_rows == 0)
        {
            //there are no games, so a story can't be posted
            if($user_level == 1)
            {
                echo 'You have not created game yet.';
            }
            else
            {
                echo 'Before you can post a story, you must wait for an admin to create some games.';
            }
            return false;
        }
        return true;
    }

    function GetStoryFromById($story_id)
    {
        $sql = "SELECT
                story_id,
                story_subject,
                story_description,
                story_date,
                isFinal
            FROM
                stories
            WHERE
                story_id = " . $story_id;
     
        $result = mysql_query($sql);
        if(!$result)
        {
            echo 'The story could not be displayed, please try again later.<br/>';
            printSqlError(mysql_error(),$sql);
        }
        elseif (mysql_num_rows($result) == 0) 
        {
            # code...
                echo 'This story does not exist.';
        }
        return $result;
    }


    function transationForVote($vote,$user_id)
    {
        $sql = "INSERT INTO 
                            votes(vote_vote,
                                   vote_level,
                                   vote_date,
                                   vote_story,
                                   vote_by)
                       VALUES('" . mysql_real_escape_string($_POST['vote']) . "',
                                   '1',
                                   NOW(),
                                   '" . mysql_real_escape_string($_GET['id']) . "','" .$_SESSION['user_name']. "')";

        $vote_id = sql_transactionReturnId($sql);
        if ($vote_id != '-1') {
             echo 'You inseted successfully  <a href="story.php?id='. mysql_real_escape_string($_GET['id']) . '">your vote for this story</a>.';
        }
    }


     function sql_transactionReturnId($sql)
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysql_query($query);
         
        if(!$result)
        {
            //Damn! the query failed, quit
            echo 'An error occured while inserting your vote. Please try again later.';
            return '-1';
        }
        $result = mysql_query($sql);
        if(!$result)
        {
            //something went wrong, display the error
            echo 'An error occured while inserting your data. Please try again later.' . mysql_error();
            echo ' the sql querry was .' . $sql;
            $sql = "ROLLBACK;";
            $result = mysql_query($sql);
        }
        else
        {
            //the first query worked, now start the second, votes query
            //retrieve the id of the freshly created story for usage in the votes query
            $id = mysql_insert_id();
            
            $sql = "COMMIT;";
            $result = mysql_query($sql);
             
            return $id;
        }
            
    }



    function getVotesForStory($story_id)
    {
        //do a query for the stories
        $sql = "SELECT  
                    vote_id,
                    vote_vote,
                    vote_level,
                    vote_date,
                    vote_story,
                    vote_by
                FROM
                    votes
                WHERE
                    vote_story = " . $story_id;
 
        $result = mysql_query($sql);
             
        if(!$result)
        {
            echo 'The votes for this story could not be displayed, please try again later.';
            printSqlError(mysql_error(),$sql);               
        }
        return $result;
    }

    function printVotesForCloseStory($story_id)
    {
        $result  = getVotesForStory($story_id);
        if($result)
        {
            //prepare the table
            echo '<table border="1">
                      <tr>
                        <th>vote</th>
                        <th>submitted at</th>
                        <th>user name</th>
                        <th>Level</th>
                        <th>vote final</th>
                      </tr>'; 
                     
            
            while($row = mysql_fetch_assoc($result))
            {               
                echo '<tr>';
                     echo '<td class="leftpart">';
                        echo  $row['vote_vote'] ;
                    echo '</td>';
                     echo '<td class="middlepart">';
                        echo date('d-m-Y', strtotime($row['vote_date']));
                    echo '</td>';
                    echo '<td class="rightpart">';
                        echo '<h3>' . $row['vote_by'] . '</h3>';
                    echo '</td>';
                    echo '<td>';
                        echo $row['vote_level'] ;
                    echo '</td>';
                    echo '<td>';
                        echo 'Yz1' ;
                    echo '</td>';
                echo '</tr>';
            }
            echo "</table>";
        }
    }

    function printVotesForOpenStory($story_id)
    {
        $result  = getVotesForStory($story_id);
        if($result)
        {
            $userVote = 0;
            while($row = mysql_fetch_assoc($result)){
                if ( $_SESSION['user_name'] == $row['vote_by']) {
                    $userVote = $row['vote_vote'];
                }
            }

            if($userVote == 0)
            {
                echo 'Dont be a Snob, let us know what you think.';
                echo '</br></br>';
                echo '<form method="post" action="">
                      Your vote for this story: <input type="text" name="vote" />'; 
                echo  '<input type="submit" value="Vote" />
                      </form>';                
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                      <tr>
                        <th>vote</th>
                        <th>submitted at</th>
                        <th>user name</th>
                        <th>Level</th>
                        <th>vote final</th>
                      </tr>'; 

                $result  = getVotesForStory($story_id);
                while($row = mysql_fetch_assoc($result))
                {               
                    echo '<tr>';
                         echo '<td class="leftpart">';
                            echo  '?' ;
                        echo '</td>';
                         echo '<td class="middlepart">';
                            echo date('d-m-Y', strtotime($row['vote_date']));
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo '<h3>' . $row['vote_by'] . '</h3>';
                        echo '</td>';
                        echo '<td>';
                            echo $row['vote_level'] ;
                        echo '</td>';
                        echo '<td>';
                            echo 'Nq1' ;
                        echo '</td>';
                    echo '</tr>';
                }
                echo "</table>";
            }
        }

    }

?>