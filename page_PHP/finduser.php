<?php
    // connect to database
    $host = "localhost";
    $database = "lab9";
    $user = "root";
    $password = "";
    $connection = mysqli_connect($host, $user, $password, $database);

    // exception if database connection is not successful
    $error = mysqli_connect_error();
    if($error != null) {
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
      } else {
        // check if this is a POST form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // get elements from the form, according to their name
            $input_username = $_POST["username"];

            // select users information using SQL query
            $sql = "SELECT username, firstName, lastName, email, userID FROM users WHERE username='$input_username';";
            $results = mysqli_query($connection, $sql);
           
            // check if the username exist before fetching results,
            // otherwise query fetches nothing, 
            // and username never can be checked since the fetch results are empty
            if (mysqli_num_rows($results)) {
                echo "username does existed <br>";
                // fetch SQL query results per row using while loop
                while ($row = mysqli_fetch_assoc($results)) {
                    $sql = "SELECT contentType, image FROM userImages where userID=?";
                    $stmt = mysqli_stmt_init($connection);
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $userID);
                    $result = mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $type, $image);
                    mysqli_stmt_fetch($stmt);
                    // create table within fieldset
                    echo "
                    <fieldset style='padding:20 20 20 20'>
                        <legend>User: " .$row['username']. "</legend>
                        <table>
                            <tr><td>First Name:</td><td>".$row['firstName']."</tr>
                            <tr><td>Last Name:</td><td>".$row['lastName']."</tr>
                            <tr><td>Email:</td><td>".$row['email']."</tr>
                            <tr><td>userID:</td><td>".$row['userID']."</tr>
                        </table>
                    </fieldset>";} 
            } else {
                echo "username does not existed <br>";
            }  
            mysqli_stmt_close($stmt);
            // free sql results to free up memory space
            mysqli_free_result($results);
            // close connection
            mysqli_close($connection);
        } else {
            echo "This is a GET method <br>";
            throw new Exception("This is a GET method");
        }
      }
      // html-1, can't create new user
      // html-4, doesn't display anything when user not found
?>

