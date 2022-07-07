<?php
    if (!isset($_SESSION['loggedin'])){
        echo '<!DOCTYPE html>
        <html>      
        <body>
        
        <form method="post" action="processLogin.php" id="mainForm" >
        Username:<br>
        <input type="text" name="username" id="username" class="required">
        <br>
        Password:<br>
        <input type="password" name="password" id="password" class="required">
        <br>
        <br><br>
        <input type="submit" value="Login">
        </form>
        </body>';
    } else {
        header("Location: http://localhost/lab10/home.php");
    }
?>