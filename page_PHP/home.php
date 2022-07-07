<?php
    session_start();
    if (isset($_SESSION['loggedin'])){
        echo "User is logged in<br>";
        echo "Welcome to home.php!<br><br>";
        echo "<a href='http://localhost/lab10/secure.php'>Secure Data Page</a><br>";
        echo "<a href='http://localhost/lab10/logout.php'>Logout</a>";
    } else {
        echo "User is not logged in";
        //header("Location: http://localhost/lab10/login.html");
        echo "<a href='http://localhost/lab10/login.php'>Login</a>";
    } 
?>