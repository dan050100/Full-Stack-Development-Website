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


  <!-- Navigation bar with the no tabs highlighted -->
  <div class = "signer">
    <nav class="navbar navbar-inverse" id="navig">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="../index.php">FiLo</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="../index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php
          echo "<div class='regLogin'>
          <form class = log>";
          echo "<a href='../index.php'> Have an account already? Login</a>
          </form>
          </div>";
          ?>
        </div>
      </nav>


      <div class="headings3" style="float:left"><h1><strong>REGISTER</strong><h1></div>             <!-- the heading on the left side of the page -->


        <!-- If a user is not logged in they can access the sign up form here -->
        <?php
        if (!isset($_SESSION['Username'])){
          echo '<div class="signup">
          <form class ="col-lg-3" action="signup.php" method="post">';
          echo '<div class="formsign">
          <input type="text" name="Username" placeholder="Username:" required><br>
          <input type="text" name="Firstname" placeholder="Firstname:" required><br>
          <input type="text" name="Lastname" placeholder="Lastname:" required><br>
          <input type="text" name="Email" placeholder="Email:" required><br>
          <input type="password" name="Password" placeholder="Password:" required><br>
          <input type="password" name="Password2" placeholder="Confirm-Password:" required><br>
          </div>
          <button class="btn btn-primary" type="submit" name="signup">Signup</button>
          </form>
          </div>';
        }
        ?>
      </div>
</body>
</html>
