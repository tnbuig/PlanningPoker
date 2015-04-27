<?php
//signout.php
include 'connect.php';
include 'header.php';
 
if(isset($_SESSION['isFinal'])) {
    $isFinal = $_SESSION['isFinal'];
    $_SESSION['isFinal'] = !$isFinal;
}
echo '<h1>Danger Zone!!!</h1>';
echo '<h2>This is a WORK ARROUND in this website logic - Result of layziness. <br/>Only the admin should use it.<h1>';
echo '<h2>Take the EMERGENCY EXIT immediately!!! <br/> Its important to notify the group.</h1>';

echo '<a href="index.php">EMERGENCY EXIT</a>';
  
include 'footer.php';
?>