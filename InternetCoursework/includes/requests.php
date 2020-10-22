<?php
include_once 'dbh.php';
session_start();

if(!isset($_SESSION['Admin'])){                 // Prevents users accessing content they shouldnt be able to
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-color: rgba(0, 139, 139, 0.5);">


  <!-- Navigation bar with the requests tab highlighted -->
  <nav class="navbar navbar-inverse" id="navig">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="../index.php">FiLo</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li class="active"><a href='requests.php'>Requests</a></li>
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

  <?php
  if (isset($_SESSION['Admin'])){
    $sql = "SELECT * FROM items where status = 1";                              // Requested items selected if the admin is logged in
    $result = mysqli_query($connect, $sql);
    $resultCheck = mysqli_num_rows($result);                                    // stores the number of rows in a variable
  }

  ?>


  <!-- The table being written out -->
  <div class="container tbl" style="margin-top: 9%;">
    <table class="table table-hover">
      <tr>
        <th style="text-align:center">ID</th>                                 <!-- the headings for each of the fields in the table -->
        <th style="text-align:center">Category</th>
        <th style="text-align:center">Colour</th>
        <th style="text-align:center">Date Found</th>
        <th></th>
        <th style="text-align:center">Accept/Decline</th>
      </tr>
      <tbody>

        <?php
        if ($resultCheck > 0){
          while ($row = mysqli_fetch_assoc($result)){                              // Loops through the table entries and outputs the data to the sites table
            echo "<tr>
            <td style='text-align:center'>" .$row['ID']. "</td>
            <td style='text-align:center'>" .$row['Category']. "</td>
            <td style='text-align:center'>" .$row['Colour']. "</td>
            <td style='text-align:center'>" .$row['Date']. "</td>";


            // If the user is an admin, all of the requests are displayed
            // to the user along with the option to accept or decline them.
            // The admin can also click on the item to see the reason for request
            if (isset($_SESSION['Admin'])){
              $sqli = "SELECT * FROM requests";
              $resultreq = mysqli_query($connect, $sqli);
              $resultCheckreq = mysqli_num_rows($resultreq);

              if($resultCheckreq > 0){                                        // Selects all of the requests so that they can be written into the table
                $sqlsel = "SELECT * FROM requests";                           // where the Item ID's are the same
                $resultsel = mysqli_query($connect, $sqlsel);
                $resultChecksel = mysqli_num_rows($resultsel);

                while ($rows = mysqli_fetch_assoc($resultsel)) {
                  $ReqID = $rows['RequestID'];
                  $res = $rows['Reason'];
                  $item = $rows['ItemID'];

                  if ($rows['ItemID'] == $row['ID']){                   // If the item ids are the same, the item data is outputted to the table
                    echo"<td style='text-align:center'>
                    <button type='button' class='but' id='addbtn' data-toggle='modal' data-target='#" .$ReqID." ' data-backdrop='true'>
                    <span class='glyphicon glyphicon-plus-sign'></span>
                    </button>
                    </td>

                    <td style='text-align:center'>
                    <div class='button-container'>
                    <form action='accept.php' method='POST'>";
                    echo "<button type='submit' name='accept' class='btn btn-primary' id='approve' value='" .$item."'>Approve</button>
                    </form>

                    <form action='decline.php' method='POST'>";
                    echo "<button type='submit' name='decline' class='btn btn-danger' id='decline' value='" .$item."'>Decline</button>
                    </form>
                    </div>
                    </td>";


                    // A modal is used to display the request information upon
                    // the plus symbol button being clicked. Imcludes the
                    // item id, the reason for the request as well as the request id
                    echo "<div class='modal fade' id='$ReqID' role='dialog'>
                    <div class='modal-dialog'>
                    <div class='modal-content' style='text-align:center'>
                    <div class='modal-header' style='text-align:center'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h4 class='modal-title'><Label>Request ID: " .$ReqID. "<Label></h4>
                    </div>
                    <div class='modal-body'>
                    <Label>Item ID:</Label>
                    <p>".$rows['ItemID']."</p><br>
                    <Label>Reason for Request: </Label>
                    <p>".$rows['Reason']."</p>
                    </div>
                    <div class='modal-footer' style='text-align:right'>
                    <button type='button' class='btn btn-primary' data-dismiss='modal'>Close</button>
                    </div>";
                    break;
                  }
                }
              }
            }
          }
        }
      }
      echo"</tr>
    </tbody>
  </table>";
?>
</body>
</html>
