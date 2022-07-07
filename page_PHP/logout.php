<?php
    session_start();
    if (isset($_SESSION['loggedin'])){
        unset($_SESSION['loggedin']);
        session_destroy();
        echo "Logout successful!<br>";
        echo "Unset superglobal and session destroyed";
    } else {
        echo "User is not logged in";
        echo "<a href='http://localhost/lab10/login.php'>Login</a>";
    } 
?>