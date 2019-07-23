<?php

  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'test_user');
  define('DB_PASSWORD', 'test_pass');
  define('DB_DATABASE', 'test_database');
  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

  // Initialize the session
  session_start();

     if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from

        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']);

        $sql = "SELECT id, username FROM Test_Table WHERE username = '$myusername' and password = '$mypassword'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

        $count = mysqli_num_rows($result);

        if($count == 1) {
          header("location: capture.html");
          exit();
          //echo "ID: ", $row["id"], "<br>";
          //echo "Username: ", $row["username"], "<br>";
        }else {
           header("location: error.html");
           exit();
        }
     }

    // Close connection
    mysqli_close($db);
?>
