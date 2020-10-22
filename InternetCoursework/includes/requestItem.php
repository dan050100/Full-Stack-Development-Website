<?php
error_reporting(0);
include_once 'dbh.php';
session_start();
if(!isset($_SESSION['UserID'])){                      // Prevents users accessing content they shouldnt be able to
  header("Location: ../index.php");
}else{
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


  <!-- Navigation bar with the request tab highlighted-->
  <nav class="navbar navbar-inverse" id="navig">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="../index.php">FiLo</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href='addItem.php'>Upload</a></li>
        <li class="active"><a href="requestItem.php">Request</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right" >
        <?php
        $user = $_SESSION['Username'];
        echo "<div class='Logout' align='right'>
        <form class='userlog' action='loggedOut.php' method='POST'>";
        echo "<label id='name'><i class='glyphicon glyphicon-user'></i> Welcome $user!</label>
        <button class='btn btn-primary' type='submit' name='logout'>Logout</button>
        </form>
        </div>";
        ?>
      </ul>
    </div>
  </nav>

  <div class="headings" style="float:left"><h1><strong>REQUEST</strong><h1></div>                         <!-- the heading on the left side of the page -->


    <!-- A form for the user to fill in in order to request for an item back
    which takes all of the current items from the database and
    puts them in a selector to reduce human error-->
    <?php
    echo '<div class="reqitem">
    <form class = "col-lg-3" method="POST" action="" enctype="multipart/form-data">';
    echo '<select name="id" style="text-align:center" required>
    <option name="sid" value ="sid">Select ID:</option>';

    $sql = "SELECT * FROM items where status = 0";
    $result = mysqli_query($connect, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0){
      while ($row = mysqli_fetch_assoc($result)) {
        $id=$row['ID'];
        echo "<option value='$id'> $id </option>";
      }
    }
    echo '</select>
    <textarea type="text" name="reason" placeholder="Reason for Request (250 Words)" style="text-align:center" rows="13" cols="35" wrap="soft" maxlength="250" required></textarea><br>
    <button class="buts" type="submit" name="request" style="text-align:center">Request</button>
    </form>
    </div>';
    ?>


    <?php
    if (isset($_POST['request'])) {
      $id = mysqli_real_escape_string($connect, $_POST['id']);                          // Prevents special characters
      $reason = ucfirst(mysqli_real_escape_string($connect, $_POST['reason']));

      if (!preg_match("/^[a-zA-Z0-9 ]*$/", $reason)){                   // Ensures the user cannot enter anything other than lettes or numbers for a Reason
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if (!filter_var($reason, FILTER_SANITIZE_STRING)){            //Ensures html code is removed from the reason
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if (empty($reason)){                                         //Ensures the reason field is not left blank
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if ($id == "sid"){
        echo' <script> alert("Request Error! Try Again") </script>';  // Ensures that an ID must be selected
      }
      else {
        // Gets the row where the IDs are the same
        $sql = "SELECT * from items where ID = $id";


        // If the sql query can be executed the request is added to the database
        // and the item is temporarily removed from the website (changed status to 1)
        if (mysqli_query($connect, $sql) && isset($_SESSION['UserID'])){
          $user = $_SESSION['UserID'];
          $sqli = "INSERT INTO requests (`RequestID`,`ItemID`, `Reason`, `RequesterID`) VALUES (NULL, '$id', '$reason', '$user')";
          mysqli_query($connect, $sqli);
          echo' <script> alert("Request Sent!") </script>';
          $sent=true;
        } else {
          $sent=false;
          echo' <script> alert("Request Error! Try Again") </script>';
        }

        if ($sent){
          $sqlu = "Update items set Status='1' where ID = $id";
          mysqli_query($connect, $sqlu);
        }
      }
    }
}?>

</body>
</html>
