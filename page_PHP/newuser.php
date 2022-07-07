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
                echo "This is a POST method <br>";
                // get elements from the form, according to their name
                $input_firstname = $_POST["firstname"];
                $input_lastname = $_POST["lastname"];
                $input_username = $_POST["username"];
                $input_email = $_POST["email"];
                $input_password = $_POST["password"];

                // check if all the input fields are set
                if (!empty($input_firstname) && !empty($input_lastname) && !empty($input_username) && !empty($input_email) && !empty($input_password)) {
                    echo "all parameters are set <br>";
                    // select all the users information using SQL query
                    $sql = "SELECT * FROM users";
                    // execute SQL query
                    $results = mysqli_query($connection, $sql);
                    // fetch the SQL query results per row using while loop
                    while ($row = mysqli_fetch_assoc($results)) {
                        // if in this row, the SQL username is equal to the input username
                        if ($row['username'] == $input_username) {
                            echo "User already exists with this name <br><br>";
                            echo "<a href='http://localhost/lab9/lab9-1.html'>Return to user entry</a>";
                        // else, the input user does not exist
                        } else {
                            echo "user does not exists with this username <br>";
                            // create (or insert) this user that does not exist, into the SQL database
                            $sql = "INSERT INTO users (firstname, lastname, username, email, password) VALUES ('$input_firstname', '$input_lastname', '$input_username', '$input_email', '$input_password')";
                            // error handling for failing to create new user
                            if ($connection->query($sql) === TRUE) {
                                echo "An account for the user " .$input_firstname. " has been created";
                            } else {
                                echo "Error: " .$sql. "<br>" .$conn->error;
                            }
                        }
                        // breaking from the while loop, prevent the loop to continue look for username after the if-else checks has been done from above
                        break;
                    }
                    // free sql results to free up memory space
                    mysqli_free_result($results);
                    // close connection
                    mysqli_close($connection);
                } else {
                    echo "one of the parameters are not set <br>";
                }
                // set up variables for upload files
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                echo "Filename: " . $_FILES['fileToUpload']['tmp_name']."<br>";
                // check if upload files is an image
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . "<br>";
                    if ($_FILES["fileToUpload"]["size"] < 100000) {
                        echo "This file is under 100k size<br>";
                        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "gif" ) {
                            echo "This file is either a jpg, png, and gif<br>";
                            file_put_contents($target_file, $_FILES["fileToUpload"]["tmp_name"]);
                            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                        } else {
                            echo "This file is none of the jpg, png, and gif<br>";
                        }
                      } else {
                        echo "This file is not under 100k size";
                      }
                  } else {
                    echo "File is not an image.";
                  }
            } else {
                echo "This is a GET method <br>";
                throw new Exception("This is a GET method");
            }
        }
?>