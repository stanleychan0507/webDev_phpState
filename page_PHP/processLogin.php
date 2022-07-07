<?php
    session_start();
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
                echo "This is a POST method <br>";
                // get elements from the form, according to their name
                $input_username = $_POST["username"];
                $input_password = $_POST["password"];

                // select users information using SQL query
                $sql = "SELECT username, password FROM users WHERE username='$input_username';";
                $results = mysqli_query($connection, $sql);

                // check if the username exist before fetching results,
                // otherwise query fetches nothing, 
                // and username never can be checked since the fetch results are empty
                if (mysqli_num_rows($results)) {
                    echo "username does existed <br>";
                    // fetch SQL query results per row using while loop
                    while ($row = mysqli_fetch_assoc($results)) {
                        // put the username and password into dynamic array so they become set
                        $validLogin = array(array('username'=>$row['username'], 'password'=>$row['password']));
                        // check if username equal input username
                        if ($row['username'] == $input_username) {
                            echo "User is checked, and it is matched <br>";
                            // check if password equal input password
                            if ($row['password'] == $input_password) {
                                echo "Password is checked, and it is matched <br>";
                                // create a new session superglobal for username
                                $_SESSION['loggedin'] = true;
                                // if login successful, redirect to home.php
                                header("Location: http://localhost/lab10/home.php");
                            } else {
                                echo "Password is invalid <br>";
                                // unset session variables if username/password is invalid
                                unset($_SESSION['loggedin']);
                                // if login not successful, redirect to login.php
                                echo "<a href='http://localhost/lab10/login.php'>Login</a>";
                            }
                        } else {
                            echo "Username and/or password are invalid <br>";
                            // unset session variables if username/password is invalid
                            unset($_SESSION['loggedin']);
                            // if login not successful, redirect to login.php
                            echo "<a href='http://localhost/lab10/login.php'>Login</a>";
                        }
                    }
                } else {
                    echo "Username and/or password are invalid <br>";
                    // if login not successful, redirect to login.php
                    echo "<a href='http://localhost/lab10/login.php'>Login</a>";
                }
                // free sql results to free up memory space
                mysqli_free_result($results);
                // close connection
                mysqli_close($connection);
            } else {
                echo "This is a GET method <br>";
                throw new Exception("This is a GET method");
                // if login not successful, redirect to login.php
                echo "<a href='http://localhost/lab10/login.php'>Login</a>";
            }
        }
        // if-else to check if SESSION['loggedin'] is set
        if (isset($_SESSION['loggedin'])){
            echo "User is logged in";
        } else {
            echo "User is not logged in";
        }
?>