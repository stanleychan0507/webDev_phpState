<?php
    session_start();
    if (isset($_SESSION['loggedin'])){
        echo "Welcome to secure.php!<br><br>";
        echo "<a href='http://localhost/lab10/home.php'>Home Page</a><br>";
        echo "<a href='http://localhost/lab10/logout.php'>Logout</a>";
    } else {
        echo "User is not logged in";
        echo "<a href='http://localhost/lab10/login.php'>Login</a>";
    } 
?>