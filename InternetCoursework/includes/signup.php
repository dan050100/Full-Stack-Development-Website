<?php
error_reporting(0);
include_once 'dbh.php';
session_start();
?>

<?php
  if (isset($_POST['signup'])){
    require 'dbh.php';

    $Username = mysqli_real_escape_string($connect, $_POST['Username']);                                // Prevents special characters being entered
    $Firstname = ucfirst(strtolower(mysqli_real_escape_string($connect, $_POST['Firstname'])));         // Capitalises the first Letter of the name and surname
    $Lastname = ucfirst(strtolower(mysqli_real_escape_string($connect, $_POST['Lastname'])));
    $Email = ucfirst(strtolower(mysqli_real_escape_string($connect, $_POST['Email'])));
    $Password = mysqli_real_escape_string($connect, $_POST['Password']);
    $Password2 = mysqli_real_escape_string($connect, $_POST['Password2']);


    if (empty($Username) || empty($Firstname) || empty($Lastname) || empty($Email) || empty($Password) || empty($Password2)){       //Ensures fields are not left blank
      echo' <script> alert("Signup Error! Try Again") </script>';
      header("Location: register.php?error=emptyFields");
    }
    else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)){                 //Ensures the email entered is a valid email
      header("Location: register.php?invalidEmail&Username");
    }
    else if (!filter_var($Firstname, FILTER_SANITIZE_STRING)){           //Ensures html code is removed from the firstname
      header("Location: register.php?invalidFirstname");
    }
    else if (!filter_var($Lastname, FILTER_SANITIZE_STRING)){            //Ensures html code is removed from the lastname
      header("Location: register.php?invalidLastname");
    }
    else if (!filter_var($Password, FILTER_SANITIZE_STRING)){            //Ensures html code is removed from the password
      header("Location: register.php?invalidPassword");
    }
    else if (!filter_var($Password2, FILTER_SANITIZE_STRING)){           //Ensures html code is removed from the password2
      header("Location: register.php?invalidPassword");
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $Username)){                   // Ensures the user cannot enter anything other than lettes or numbers for a username
      header("Location: register.php?invalidUsername&Email");
    }
    else if (!preg_match("/^[a-zA-Z \-]*$/", $firstname)){                   // Ensures the user cannot enter anything other than lettes for a firstname
      header("Location: register.php?invalidFirstname");
    }
    else if (!preg_match("/^[a-zA-Z \-]*$/", $Lastname)){                   // Ensures the user cannot enter anything other than lettes for a lastname
      header("Location: register.php?invalidLastname");
    }
    else if ($Password !== $Password2) {                                // Ensure both passwords match to reduce human error, verification
      header("Location: register.php?error=passwordCheck&Email");
    }
    else {
      //prevents sql injection attack
      $sql = "SELECT Username FROM users WHERE Username=?";
      $initalise = mysqli_stmt_init($connect);                      // A prepared statement is made
      if (!mysqli_stmt_prepare($initalise, $sql)){
        header("Location: ../index.php");
      }
      else {
        mysqli_stmt_bind_param($initalise, "sss", $Username, $Firstname, $Lastname);            // the paramters are binded to their relevent variable names
        mysqli_stmt_execute($initalise);
        mysqli_stmt_store_result($initalise);
        $resultNumber = mysqli_stmt_num_rows($initalise);

        if ($resultNumber > 0) {
          header("Location: ../index.php");
        }
        else {
          // New user is added into the database
          // with the relevent fields which were inputted
          $sql = "INSERT INTO users (UserID, Username, Password, Firstname, Lastname, Email) VALUES (null,?, ?, ?, ?, ?)";
          $initalise = mysqli_stmt_init($connect);
          if (!mysqli_stmt_prepare($initalise, $sql)) {
            header("Location: ../index.php");
          }
          else {
            // Password is hashed to improve security
            $hashPass = password_hash($Password, PASSWORD_DEFAULT);

            // the paramters are binded to their relevent variable names
            mysqli_stmt_bind_param($initalise, "sssss", $Username, $hashPass, $Firstname, $Lastname, $Email);
            mysqli_stmt_execute($initalise);
            header("Location: ../index.php");
          }
        }
      }
    }
    mysqli_stmt_close($initalise);
    mqsqli_close($connect);
  }
