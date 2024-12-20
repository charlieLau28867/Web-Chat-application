<?php
  $conn = mysqli_connect("mydb", "dummy", "c3322b", "db3322");

 
  if(isset($_POST['email'])) { //if is a POST request
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $password = mysqli_real_escape_string($conn, $_POST['password']);
  
  
    if(!empty($email) ){
      $sql = mysqli_query($conn, "SELECT * FROM account WHERE useremail = '{$email}'");
      if(mysqli_num_rows($sql) > 0)  {
        
      }else{
        echo"Cannot find your email Record";
      }
  
    }
  }else{
    $regEmail = mysqli_real_escape_string($conn, $_POST['Regemail']);

    $sql = mysqli_query($conn, "SELECT * FROM account WHERE useremail = '{$regEmail}'");
    if(mysqli_num_rows($sql) > 0)  {
      echo "You have register before";
    }
  }
?>