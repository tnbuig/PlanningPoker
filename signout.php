<?php
//signout.php
include 'connect.php';
include 'header.php';
 
echo '<h3>Sign out</h3>';
unset($_SESSION['user_id'] );
unset($_SESSION['user_name'] );
unset($_SESSION['user_level'] );  
unset($_SESSION['signed_in']);


echo 'You talked enough, now you need to start <a href="http://www.miniclip.com/games/bubble-trouble/en/">Work!!!</a>';
  
include 'footer.php';
?>