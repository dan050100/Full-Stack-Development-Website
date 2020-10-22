<?php
error_reporting(0);
include_once 'dbh.php';
session_start();
?>

<?php
if (isset($_POST['login'])){
  require 'dbh.php';

  $Username = mysqli_real_escape_string($connect, $_POST['Username']);
  $Password = mysqli_real_escape_string($connect, $_POST['Password']);

  if (empty($Username) || empty($Password)){
    echo' <script> alert("Login Error! Try Again") </script>';      //Ensures Fields are not left blank
    header("Location: ../index.php");
  }
  else if (!filter_var($Username, FILTER_SANITIZE_STRING)){           //Ensures html code is removed from the username
    echo' <script> alert("Signup Error! Try Again") </script>';
    header("Location: register.php?invalidUsername");
  }
  else if (!filter_var($Password, FILTER_SANITIZE_STRING)){            //Ensures html code is removed from the password
    echo' <script> alert("Signup Error! Try Again") </script>';
    header("Location: register.php?invalidPassword");
  }
  else {
    $sql = "SELECT * FROM users WHERE Username = ? or email = ?";
    $stmt = mysqli_stmt_init($connect);

    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../index.php");
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $Username, $Username);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($res)){                           // Gets the row of data associated with that user
        $passCheck = password_verify($Password, $row['Password']);
        if ($passCheck == false){
          header("Location: ../index.php?error=WrongPassword");
        }
        else if ($passCheck == true){
          session_start();
          if ($row['UserID'] == 4){                                   // The admins userID to start and admin session
            $_SESSION['Admin'] = $row['UserID'];
            $_SESSION['Username'] = $row['Username'];
          } else {
            $_SESSION['UserID'] = $row['UserID'];                   // The users userID if they are not an admin, a user session is set
            $_SESSION['Username'] = $row['Username'];
          }
          header("Location: ../index.php?login=success");
        } else {
          header("Location: ../index.php?error=WrongPassword");
        }
      } else {
        header("Location: ../index.php?error=UserDoesNotExist");
      }
    }
  }
}
