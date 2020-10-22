<?php
include_once 'includes/dbh.php';
session_start();
?>

<style>
<?php include 'CSS/main.css' ?>
</style>


<!DOCTYPE html>
<html>
<head>
  <title>FiLo</title>
  <link rel = "stylesheet" href= "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-color: rgba(0, 139, 139, 0.5);">


  <!-- Navigation bar with the home tab highlighted -->
  <nav class="navbar navbar-inverse" id="navig">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">FiLo</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="includes/about.php">About</a></li>


        <!-- if a registered user is logged in the upload and request tabs are available,
        if the admin is logged in the requests tab is available -->
        <?php
        if (isset($_SESSION['UserID'])){
          echo "<li><a href='includes/addItem.php'>Upload</a></li>
          <li><a href='includes/requestItem.php'>Request</a></li>";
        } else if (isset($_SESSION['Admin'])){
          echo "<li><a href='includes/requests.php'>Requests</a></li>";
        }
        ?>
      </ul>


      <!-- If a user is signed in, the username and logout button is displayed
      otherwise the login form is displayed -->
      <ul class="nav navbar-nav navbar-right" >
        <?php
        if (isset($_SESSION['Username'])){
          $user = $_SESSION['Username'];

          echo "<div class='Logout' align='right'>
          <form class='userlog' action='includes/loggedOut.php' method='POST'>";
          echo "<label id='name'><i class='glyphicon glyphicon-user'></i> Welcome $user!</label>
          <button class='btn btn-primary' type='submit' name='logout'>Logout</button>
          </form>
          </div>";
        } else {
          echo "<div class='Login'>
          <form action='includes/LoggedIn.php' method='POST'>";
          echo "<a href='includes/register.php'> Don't have an account? Sign Up</a>
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


  <!-- the user can order the table by date
  or by category in both ascending and descending order or default
  sets it back to it's original state -->
  <?php
  echo"<form action='index.php' method='post'>";
  echo "<div class ='Req'>
  <select name='sort'>
  <option value ='srt'>Sort By:</option>
  <option value='Date'>Date</option>
  <option value='Category'>Alphabetically</option>
  </select>

  <input class='btn' type='submit' name='up' value='Ascending'></input>
  <input class='btn' type='submit' name='down' value='Descending'></input>
  <input class='btn' type='submit' name='def' value='Default'></input>
  </div>
  <br><br>";


  // Checks which button is clicked to order the data as to which query is executed
  if (isset($_POST['up'])) {
    $type = $_POST['sort'];
    if ($type == 'srt'){
      $sql = "SELECT * FROM items where status = 0";
    } else {
      $sql = "SELECT * FROM items where status = 0 ORDER BY $type ASC";         // Orders the items table in ascending order of the selected type
    }                                                                             // when the ascending utton is clicked
  } else if (isset($_POST['down'])) {
    $type = $_POST['sort'];
    if ($type == 'srt'){
      $sql = "SELECT * FROM items where status = 0";
    } else {
      $sql = "SELECT * FROM items where status = 0 ORDER BY $type DESC";       // Orders the items table in descending order of the selected type
    }                                                                            // when the descending utton is clicked
  } else if (isset($_POST['def'])) {
    $sql = "SELECT * FROM items where status = 0";
  } else {
    $sql = "SELECT * FROM items where status = 0";                              // Default order of the items table
  }


  $result = mysqli_query($connect, $sql);
  $resultCheck = mysqli_num_rows($result);                                        // stores the number of rows in a variable to ensure no data is lost
  ?>


  <!-- The table being written out -->
  <div class="container tbl">
    <table class="table table-hover">
      <tr>
        <th style="text-align:center">ID</th>                                 <!-- the headings for each of the fields in the table -->
        <th style="text-align:center">Category</th>
        <th style="text-align:center">Colour</th>
        <th style="text-align:center">Date Found</th>

        <?php if (isset($_SESSION['Username'])){                             // used to make the table look cleaner
          echo'<th></th>';
        }
        ?>

      </tr>
      <tbody>

        <?php
        if ($resultCheck > 0){
          while ($row = mysqli_fetch_assoc($result)){
            echo "<tr>
            <td style='text-align:center'>" .$row['ID']. "</td>
            <td style='text-align:center'>" .$row['Category']. "</td>
            <td style='text-align:center'>" .$row['Colour']. "</td>
            <td style='text-align:center'>" .$row['Date']. "</td>";


            // If the user is logged in, they have access to viewing more information about the items
            // such as images, descriptions, time found and place found.
            if(isset($_SESSION['Username'])){
              $id=$row['ID'];
              echo"<form class='id' method='post' action=''>";
              echo "<td style='text-align:center'>
              <button type='button' class='but' id='addbtn' data-toggle='modal' data-target='#" .$id." ' data-backdrop='true'>
              <span class='glyphicon glyphicon-plus-sign'></span>
              </button>
              </td>
              </form>";


              // A modal is used to display the extra infrormation about the item
              // when the plus symbol button is clicked for a specific item
              echo"<div class='modal fade' id='$id' role='dialog'>
              <div class='modal-dialog'>
              <div class='modal-content' style='text-align:center'>
              <div class='modal-header' style='text-align:center'>
              <button type='button' class='close' data-dismiss='modal'>&times;</button>
              <h4 class='modal-title'><Label>Item ID: " .$id. "<Label></h4>
              </div>
              <div class='modal-body'>
              <Label>Time Item was Found:</Label><p>".$row['Time']."</p><br><br>
              <Label>Images:</Label><p>";


              $pics = $row['Photo'];
              $imagesplit = explode("¬?", $pics);                                                                          // Splits the image string whenever the ¬? symbols are found, so that it can distinguish the start
              for ($x=0; $x < sizeof($imagesplit)-1; $x++){                                                                // and end of the individual images and puts them into an array which can then be looped trhough
                echo '<img src = image/'.$imagesplit[$x].' alt="image name" width="110px" height="110px"/>';             // to display the images in the modal.
              }

              echo "</p><br><br>
              <Label>Item Description:</Label><p>".$row['Description']."</p><br><br>";                                // Displays the desciption and place in the modal too
              echo "<Label>Place Item was Found: </Label><p>".$row['Place']."</p>
              </div>
              <div class='modal-footer' style='text-align:right'>
              <button type='button' class='btn btn-primary' data-dismiss='modal'>Close</button>
              </div>
              </div>
              </div>
              </div>
              </tr>";
            }
          }
        }
        ?>
      </tbody>
    </table>

  </body>
  </html>
