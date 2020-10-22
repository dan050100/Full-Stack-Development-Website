<?php
error_reporting(0);
include_once 'dbh.php';
session_start();
if(!isset($_SESSION['UserID'])){                  // Prevents users accessing content they shouldnt be able to
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


  <!-- Navigation bar with the upload tab highlighted -->
  <nav class="navbar navbar-inverse" id="navig">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="../index.php">FiLo</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li class="active"><a href='addItem.php'>Upload</a></li>
        <li><a href="requestItem.php">Request</a></li>
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

  <div class="headings2" style="float:left"><h1><strong>UPLOAD</strong><h1></div>                         <!-- the heading on the left side of the page -->


    <!-- If a user is logged in, a form is displayed for them to fill in
    to add an item to the database -->
    <?php

      echo '<div class="item">
      <form class = "col-lg-3" method="POST" action="" enctype="multipart/form-data">';
      echo '<div class="initem">
      <select name="category" style="text-align:center">
      <option value="Phone">Phone</option>
      <option value="Pet">Pet</option>
      <option value="Jewellery">Jewellery</option>
      </select><br>';

      // All fields are required
      echo'<div class="itemFields">
      <input class="inp" type="text" name="colour" placeholder="Colour" align="center" style="text-align:center" required><br><br>
      <input class="date" type="Date" name="date" id="dating" align="center" style="text-align:center" required>
      <input class="tim" type="Time" name="time" id="timing" align="center" style="text-align:center" required><br><br>
      <input type="file" name="pic[]" accept="image/*" multiple="multiple" class="file" required/><br><br>';                                  // Only images can be uploaded
      echo'<input class="inp" type="text" name="place" placeholder="The Place where the Item was Found" align="center" style="text-align:center" required><br><br>
      <textarea  type="text" name="description" placeholder="Description of the Item (250 Words)" align="center" style="text-align:center" rows="5" cols="35" wrap="soft" maxlength="250" required></textarea>
      </div>

      <div>
      <button class="buts" type="submit" name="upload" style="text-align:center">Upload</button>
      </div>
      </div>
      </form>
      </div>';

    ?>


    <!-- If upload button is clicked, the data is inputted into the database
    if validation requirements are met -->
    <?php
    if (isset($_POST['upload'])) {
      $category = ucfirst(strtolower(mysqli_real_escape_string($connect, $_POST['category'])));           // Prevents special characters being entered and capitalises
      $colour = ucfirst(strtolower(mysqli_real_escape_string($connect,$_POST['colour'])));                // only the first character for clearer presentation in tables
      $date = $_POST['date'];
      $time = $_POST['time'];
      $place = ucwords(strtolower(mysqli_real_escape_string($connect,$_POST['place'])));                  // All new Words have capital letters
      $description = ucfirst(mysqli_real_escape_string($connect,$_POST['description']));

      $imagename = $_FILES["pic"]["name"];
      $tempimgname = $_FILES["pic"]["tmp_name"];


      if (empty($category) || empty($colour) || empty($date) || empty($time) || empty($place) || empty($description)){      //Ensures fields are not left blank
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if (!preg_match("/^[a-zA-Z ]*$/", $colour)){              // Ensures the user cannot enter anything other than lettes for a colour
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $place)){           // Ensures the user cannot enter anything other than lettes for a place
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $description)){      // Ensures the user cannot enter anything other than lettes for a description
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if (!filter_var($colour, FILTER_SANITIZE_STRING)){           //Ensures html code is removed from the colour
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if (!filter_var($place, FILTER_SANITIZE_STRING)){           //Ensures html code is removed from the place
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else if (!filter_var($description, FILTER_SANITIZE_STRING)){           //Ensures html code is removed from the Description
        echo' <script> alert("Request Error! Try Again") </script>';
      }
      else {
        $uID = $_SESSION['UserID'];
        $imgcounter = count($imagename);    // counter for the amount of images selected
        $picture = "";

        // Loop through each image of the item to be uploaded.
        // Remove all the whitespaces from the image string and add a
        // comma to the end of the image name so that multiple images can be retrieved
        for($i=0 ; $i < $imgcounter; $i++) {
          $picture = "$picture" ."$imagename[$i]¬?";
          $picture1 = trim($picture, " ");

          // the temporary image file location
          $tmploc = $tempimgname[$i];

          // The new location where the file is being copied to
          if ($tmploc != ""){
            $newloc = "../image/" .$imagename[$i];

            // Copy the file into the selected temporary directory and
            // if it cannot, output an error to the user
            if(!move_uploaded_file($tmploc, $newloc)) {
              echo' <script> alert("Error! The items Images were not successfully uploaded!") </script>';
            }
          }
        }

        $sql = "INSERT INTO items (`Category`, `Colour`, `Date`, `Time`, `Photo`, `Place`, `Description`, `ID`, `UserID`, `Status`) VALUES ('$category', '$colour', '$date', '$time', '$picture1', '$place', '$description', NULL, '$uID', 0)";


        // Alert to inform the user whether the item was
        // added successfully to the database or not
        if (mysqli_query($connect, $sql) && isset($_SESSION['UserID'])){
          echo' <script> alert("Success! The item has been added to the website!") </script>';
        } else {
          echo' <script> alert("Error! The item was not added to the website!") </script>';
        }
      }
    }}
    ?>

</body>
</html>
