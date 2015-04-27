<?php 
  session_start();
  if (isset($_SESSION['user_name'])) {
      echo $_SESSION['user_name'];
        if($_SESSION['signed_in'])
            echo "<br/>singed in";
  }else{
    echo "I dont know you.<br/> please leave this site!";
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Planning Poker." />
    <meta name="keywords" content="Scrum, Agile, Planning Poker," />
    <title>Planning Poker</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<p id="demo">d</p>
 <button type="button"
onclick="document.getElementById('demo').innerHTML = sdf">
Date and Time.</button>
<h1>Planing Poker</h1>
    <div id="wrapper">
    <div id="menu">
        <a class="item" href="index.php">Home</a> 
        <a class="item" href="create_story.php">Create a story</a> -
        <a class="item" href="create_game.php">Create a game</a>
         
        <div id="userbar">
            <?php
                if(isset($_SESSION['signed_in']))
                {
                    echo 'Hello ' . $_SESSION['user_name'] . '. Not you? <a href="signout.php" title="This is a Tool Tip : The term tooltip originally came from older Microsoft applications, tooltips are used in various parts of an interface. (From Wikipedia)">Sign out</a>';
                }
                else
                {
                    echo '<a href="signin.php">Sign in</a> or <a href="signup.php">create an account</a>.';
                }
            ?>
        </div>
    </div>
        <div id="content">