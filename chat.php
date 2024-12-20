<?php
session_start();
if(!isset($_SESSION['id'])){
  header("location: login.php");
}
//print_r($_SESSION);
$id= $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="chat.css">
</head>
<body>

  <p class= "title">A simple Chatroom Service</p>
  <div class="wrapper">

    <section class="chat-area">
      <header>
        <button class = "logoutBttn" ><i >Logout</i></button>
        <!--<a href="login.php?action=Logout" class=button>logout</a>-->
      </header>
      <div class="chat-box">
        <div class ="chat outgoing">
          <div class="details">
            <p> message loading </p>
          </div>
        </div>
        <div class ="chat incoming">
          <div class="details">
            <p> plesase wait</p>
          </div>
        </div>
      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $_SESSION['id']; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i>SEND</i></button>
      </form>
    </section>
  </div>
  <script src="chat.js"></script>


</body>


</html>