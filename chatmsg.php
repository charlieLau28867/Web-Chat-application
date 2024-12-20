<?php 
    session_start();

    if(isset($_SESSION['id'])){

      if (isset($_SESSION['counter2'])) {
       } else {
        $_SESSION['counter2'] = 0;
       }

      $conn = mysqli_connect("mydb", "dummy", "c3322b", "db3322");
      if($conn){

        $user_id = $_SESSION['id'];
        $sql = mysqli_query($conn, "SELECT * FROM account WHERE id = '{$user_id}'");
        if(mysqli_num_rows($sql) > 0)  {
          $row = mysqli_fetch_assoc($sql);
          $email = $row['useremail'];
          $username = strstr($email, '@', true);
        }


        if ($_SESSION['counter2']<24){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $message = mysqli_real_escape_string($conn, $_POST['message']);
              date_default_timezone_set("Asia/Hong_Kong");
              $time = date("H:i:s");
              if(!empty($message)){ 
                $sql2 = mysqli_query($conn, "INSERT INTO message (time, message, person) VALUES ('{$time}', '{$message}', '{$username}')") or die();
              }
              $_SESSION['counter2'] = 0;
            }else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
              $output = "";
              date_default_timezone_set("Asia/Hong_Kong");
              $timenow = strtotime(date("H:i:s"));
              $oneHourAgo= date('H:i:s', strtotime('-1 hour'));
              $_SESSION['counter2'] += 1;


              $sql3 = mysqli_query($conn, "SELECT * FROM message ");
              if(mysqli_num_rows($sql3) > 0){
                while($row2 = mysqli_fetch_assoc($sql3)){
                  $timeCompare = strtotime($row2['time']);
                  $hours = ($timenow - $timeCompare)/3600;
                  if ($hours < 1){
                    if($row2['person'] === $username  ){

                      $output .= '<div class="chat outgoing">
                                    <div class="details">
                                      <p>'.$row2['person'].'&nbsp;&nbsp;&nbsp;'.$row2['time'] .'<br>'.$row2['message'] .'</p>
                                    </div>
                                  </div>';
                    }else{
                      $output .= '<div class="chat incoming">
                                  <div class="details">
                                  <p>'.$row2['person'] .'&nbsp;&nbsp;&nbsp;'.$row2['time'] .'<br>'.$row2['message'] .'</p>
                                  </div>
                                  </div>';
                    }
                  }
                }
              }
              echo $output;
            }
        }else{
          http_response_code(401);
        }


    }
    }else if (!isset($_SESSION['id'])){
      header("location: login.php");
    }



    
?>

