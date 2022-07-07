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
                $input_oldpassword = $_POST["oldpassword"];
                $input_newpassword = $_POST["newpassword"];

                // select users information using SQL query
                $sql = "SELECT username, password FROM users;";
                $results = mysqli_query($connection, $sql);
                // fetch SQL query results per row using while loop
                while ($row = mysqli_fetch_assoc($results)) {
                    $validLogin = array(array('username'=>$row['username'], 'password'=>$row['password']));
                }

                // for each login (or $validLogin) in the database
                foreach ($validLogin as $row) {
                    // check if the login username is equal to the input username
                    if ($row['username'] == $input_username) {
                        echo "User is checked, and it is matched <br>";
                        // check if the login old password is equal to the input password
                        if ($row['password'] == $input_oldpassword) {
                            echo "Password is checked, and it is matched <br>";
                            // if old password is verified,
                            // change (or update) password to new password in SQL query
                            $sql = "UPDATE users SET password='$input_newpassword' WHERE username='$input_username'";
                            $results = mysqli_query($connection, $sql);
                            echo "user's password has been updated <br>";
                        } else {
                            echo "Password is invalid <br>";
                        }
                    } else {
                        echo "Username and/or password are invalid <br>";
                    }     
                }
                // free sql results to free up memory space
                mysqli_free_result($results);
                // close connection
                mysqli_close($connection);
            } else {
                echo "This is a GET method <br>";
                throw new Exception("This is a GET method");
            }
        }
?>