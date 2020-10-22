<?php
error_reporting(0);
include 'dbh.php';
session_start();


  // when the accept button is clicked the emails and item data is retrieved from the database tables
  if (isset($_POST['accept'])){
    $appID = $_POST['accept'];


    // Deletes the selected request and Item from their tables in the database
    $sql = "DELETE FROM items where id = $appID";
    $sqli = "DELETE FROM requests where ItemID = $appID";


    // Gets the user ID which requested the item as well as the Id of the item requested
    $id = "SELECT * FROM requests where ItemID = $appID";
    $idi = mysqli_query($connect, $id);
    $rows = mysqli_fetch_assoc($idi);
    $reid = $rows['RequesterID'];
    $ui = $rows['ItemID'];


    //Gets the email of the user which has requested the item.
    $email = "SELECT * FROM users WHERE UserID = $reid";
    $mail = mysqli_query($connect, $email);
    $row = mysqli_fetch_assoc($mail);
    $em = $row['Email'];


    // Gets the UserID, Category and Colour of the item being accepted
    $emailkeep = "SELECT * FROM items WHERE ID = $ui";
    $mailkeep=mysqli_query($connect, $emailkeep);
    $rowk = mysqli_fetch_assoc($mailkeep);
    $ide=$rowk['UserID'];
    $item=$rowk['Category'];
    $colour=$rowk['Colour'];



    // Gets the email address of the user who uploaded the item on the website
    $user = "SELECT * FROM users WHERE UserID = $ide";
    $useri = mysqli_query($connect, $user);
    $rowu = mysqli_fetch_assoc($useri);
    $emu = $rowu['Email'];


  if (mysqli_query($connect, $sql) && mysqli_query($connect, $sqli)){
    $iinfo = mysqli_query($connect, $sql);
    $rowi = mysqli_fetch_assoc($iinfo);

    // Sends emails to both the user who found the item and the user requesting their item back
    mail($em,"FiLo","Your request for the " .$colour. " " .$item. " you lost has been accepted by the FiLo Team. \n The user who lost this item can be contacted by email at: \n" .$emu. "\n \n Kind Regards, \n The Filo Team");
    mail($emu,"Filo has found the owner!","The owner of the " .$colour. " " .$item. " has requested their item back which has been accepted by the FiLo Team. The user who lost this item can be contacted by email at: \n" .$em. "\n \n Kind Regards, \n The Filo Team");
    header("Location: ../index.php?Item=ApprovedSuccess");
  }
}
