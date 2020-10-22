<?php
error_reporting(0);
include_once 'dbh.php';
session_start();
?>

<style>
<?php include '../CSS/main.css' ?>
</style>

<!DOCTYPE html>
<html>
<head>
  <title>FiLo</title>
  <link rel = "stylesheet" href= "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-color: rgba(0, 139, 139, 0.5)">

  <!-- Navigation bar with the about tab highlighted -->
  <nav class="navbar navbar-inverse" id="navig">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="../index.php">FiLo</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
        <li class="active"><a href="about.php">About</a></li>


        <!-- if the user is logged in the upload and request tabs are available -->
        <?php
        if (isset($_SESSION['UserID'])){
          echo "<li><a href='addItem.php'>Upload</a></li>
          <li><a href='requestItem.php'>Request</a></li>";
        } else if (isset($_SESSION['Admin'])){
          echo "<li><a href='requests.php'>Requests</a></li>";
        }
        ?>
      </ul>


      <!-- If the user is signed in the username and logout button is displayed
      otherwise the login form is displayed -->
      <ul class="nav navbar-nav navbar-right" >
        <?php
        if (isset($_SESSION['Username'])){
          $user = $_SESSION['Username'];

          echo "<div class='Logout' align='right'>
          <form class='userlog' action='loggedOut.php' method='POST'>";
          echo "<label id='name'><i class='glyphicon glyphicon-user'></i> Welcome $user!</label>
          <button class='btn btn-primary' type='submit' name='logout'>Logout</button>
          </form>
          </div>";
        } else {
          echo "<div class='Login'>
          <form action='LoggedIn.php' method='POST'>";
          echo "<a href='register.php'> Don't have an account? Sign Up</a>
          <input type='text' name='Username' placeholder='Username'>
          <input type='password' name='Password' placeholder='Password'>
          <button class='btn btn-primary' type='submit' name='login'>Login</button>
          </form>
          </div>";
        }
        ?>
      </ul>
    </div>
  </nav>

  <div class="headings4" style="float:left"><h1><strong>ABOUT</strong><h1></div>            <!-- the heading on the left side of the page -->

<div style="margin-top: 8%; margin-left: 17%">
  <h1 style="margin-left: 18%; text-decoration:underline"><strong> Welcome to the Filo Community </strong></h1><br><br>
  <div style ="background-color: rgba(60, 60, 60, 0.3); width: 78%; border-radius: 25px;">
    <p  style="padding:2%; color:white; text-align:center"><strong style="color:black; text-decoration:underline">Public:</strong><br><br> All users can view minimal content of lost items.</p>
  </div>


  <div style ="margin-top:2%; background-color: rgba(60, 60, 60, 0.3); width: 78%; border-radius: 25px;">
    <p  style="color: white; padding:2%; text-align:center; color: white;"><strong style="color:black; text-decoration:underline">Registered Users:</strong><br><br> Sign up now if you haven't already, as this will give you access to viewing more information
    about the items which have been lost such as their images, descriptions etc.
    <br><br>
    <strong style="color:black;">And there's more..</strong>
    <br><br>
    Not only will you have access to the extra information, you will also have access to upload lost items you may have found, as well as request items back that may be on
    our website.
    </p>
  </div>


  <div style ="margin-top:2%; background-color: rgba(60, 60, 60, 0.3); width: 78%; border-radius: 25px;">
    <p  style="color: white; padding:2%; text-align:center"><strong style="color:black; text-decoration:underline">Contact Us:</strong><br><br><strong  style="color:white;"> FiLoTeamCEO@gmail.com </strong></p>
  </div>



</body>
</html>
