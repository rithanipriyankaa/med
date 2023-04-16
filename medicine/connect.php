<?php

$Name = $_POST['Name'];
$PhoneNumber = $_POST['PhoneNumber'];
$Email = $_POST['Email'];
$SelectMedicine =$_POST['SelectMedicine'];
$Message = $_POST['Message'];



if (!empty($Name) || !empty($PhoneNumber)  || !empty($Email) || !empty($SelectMedicine) || !empty($Message) )
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "test";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT Email From contactus Where Email = ? Limit 1";
  $INSERT = "INSERT Into contactus (Name , PhoneNumber, Email , SelectMedicine, Message )values(?,?,?,?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $Email);
     $stmt->execute();
     $stmt->bind_result($Email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking username
      if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sisss", $Name,$PhoneNumber,$Email,$SelectMedicine,$Message);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already registered using this Email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>