<?php
session_start();

#Set the access counter
if (isset($_SESSION['counter'])) {
 $_SESSION['counter'] += 1;
} else {
 $_SESSION['counter'] = 1;
}

#Our main() function

start();
//print_r($_SESSION);
$msg='';
function start() {
  //if(isset($_POST['login'])) { //if is a POST request
  if(isset($_GET['login'])) {

    if (authenticate()) {
  // display secured content if user logged in successfully
      //display_secured_content();
    } else {
  // display login form again with message
      display_login_form($msg='get1');
    }
  } else if(isset($_GET['action']) && $_GET['action'] == 'Logout') {
  // obtain a GET request with query string action=logout
    logout();
  } else {
  // is a GET request
    if (authenticate()) {
      //display_secured_content();
    } else {
  // default: display the login form
      global $msg;
      display_login_form($msg);
    }
  }
  
}

function display_login_form($msg='') {
  ?>
  <link rel="stylesheet" type="text/css" href="login.css">
  
  <p class="topic">A simple Chatroom Service </p>

  <div class="FormDisplay" id="loginForm">
    <p class="title"> Login to Chatroom</p><br>
    <form action="login.php" method="POST" enctype="multipart/form-data" autocomplete="off">
      <fieldset name="logininfo" >
        <legend>Login</legend>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" pattern = ".+@connect.hku.hk" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <input class="button" type="submit" name="login" value="Login">
      </fieldset>
      <p class="link" id="toReg">click <a href>here</a> to register an account</p>
      <p class="errorText"><?php echo $msg; ?></p>
    </form>
  </div>  

  <div  id="RegForm" class="switch">
    <p class="title">Register an Account</p><br>
    <form action="login.php" method="POST" enctype="multipart/form-data" autocomplete="off"  >
      <fieldset name="Reginfo" >
        <legend>Register</legend>
        <label for="Regemail">Email:</label>
        <input type="text" name="Regemail" id="Regemail" pattern = ".+@connect.hku.hk" required><br>
        <label for="Regpassword">Password:</label>
        <input type="password" name="Regpassword" id="Regpassword" required><br>
        <label for="confirm">Confirm:</label>
        <input type="password" name="confirm" id="confirm" required><br>
        <input class="button" type="submit" name="register" value="Register">
      </fieldset>
      <p class="link" id="toLog">click <a href>here</a> for login</p>
      <p class="errorText"></p>

    </form>
  </div>

   <script src="login.js"></script>
  <?php
  }
  
  function display_secured_content() {
    ?>
    <h1>Welcome <?php echo $_SESSION['id'];?></h1>
    <p>Welcome to the member area!</p>
    <p>
    <a href="login.php?action=Logout">logout</a>
    </p>
    
    
    <?php
  }

    function authenticate() {
      if (isset($_SESSION['email'])) { //if already authenticated
        return true;
      }
      //login
      global $msg;
      if (isset($_POST['email']) && isset($_POST['password'])) {
        $conn = mysqli_connect("mydb", "dummy", "c3322b", "db3322");
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        #Check username & password for login
        if(!empty($email) && !empty($password)){
          $sql = mysqli_query($conn, "SELECT * FROM account WHERE useremail = '{$email}'");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);

            $enc_pass = $row['password'];
            $unique_id = $row['id'];
            if($password == $enc_pass){
              $_SESSION['id'] = $unique_id; //Store authenticated variable
              header("Location: chat.php");
              session_write_close(); //free session lock
              return true;
            }else{
              //global $msg;
              $msg = 'Failed to login. Incorrect password';
            }
          }else{
            //global $msg;
            $msg = 'Failed to login. Unknown user!!';
          }

        }else { //Wrong credential
        return false;
        }
    
      }
      
      //post for register
      if (isset($_POST['Regemail']) && isset($_POST['Regpassword'])) {
        $msg = 'Here comes from reg form';
        $conn = mysqli_connect("mydb", "dummy", "c3322b", "db3322");
        $email = $_POST['Regemail'];
        $password = $_POST['Regpassword'];
        $check_query = mysqli_query($conn, "SELECT * FROM account WHERE useremail = '{$email}'");
        if(mysqli_num_rows($check_query) > 0){
          $msg = 'Failed to register. Already registered before!!';
        }else{
          $insert_query = mysqli_query($conn, "INSERT INTO account (useremail,password) VALUES('{$email}','{$password}')");
          $get_query = mysqli_query($conn, "SELECT * FROM account WHERE useremail = '{$email}'");
          $row2 = mysqli_fetch_assoc($get_query);
          $_SESSION['id'] = $row2['id']; //Store authenticated variable
          header("Location: chat.php");
          session_write_close(); //free session lock
          return true;
        }
      }
    }

  function logout() {
      #set SESSION cookie to expire ==> delete cookie
      if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(),'',time()-3600, '/');
      }
      session_unset();
      session_destroy();
      #Set redirection
      header('location: login.php');
  }
?>    