<?php
error_reporting(0);
include 'dbh.php';
session_start();

// if the decline button is clicked the Email of the user requesting is retrieved
// and the status is set back to 0 so it can be seen on the website again
  if (isset($_POST['decline'])){
    $appID = $_POST['decline'];
    $sql = "UPDATE items set Status='0' where ID = '$appID'";
    $sqli = "DELETE FROM requests where ItemID = $appID";


    // Gets the Id of the user requesting the item
    $id = "SELECT * FROM requests where ItemID = $appID";
    $idi = mysqli_query($connect, $id);
    $rows = mysqli_fetch_assoc($idi);
    $ui=$rows['RequesterID'];


    // Gets the Email of the user which is requesting the item
    $email = "SELECT * FROM users WHERE UserID = $ui";
    $mail=mysqli_query($connect, $email);
    $row = mysqli_fetch_assoc($mail);
    $em=$row['Email'];


  // Sends emails to the user requesting their item back
  if (mysqli_query($connect, $sql) && mysqli_query($connect, $sqli)){
    mail($em,"FiLo","Declined Request");
    header("Location: ../index.php?Item=DeclineSuccess");
  }
}
