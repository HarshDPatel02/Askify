<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


  $errors = array();
  $dataOK = TRUE;
  

  $username = test_input($_POST["username"]);
  $unameRegex = "/^[a-zA-Z0-9_]+$/";
  if (!preg_match($unameRegex, $username)) {
      $errors["username"] = "Invalid Username";
      $dataOK = FALSE;
  }

  $password = test_input($_POST["password"]);
  $passwordRegex = "/^.{8}$/";
  if (!preg_match($passwordRegex, $password)) {
      $errors["password"] = "Invalid Password";
      $dataOK = FALSE;
  }


  if ($dataOK) {
    try {
      $db = new PDO($attr, $db_user, $db_pwd, $options);
  } catch (PDOException $e) {
      throw new PDOException($e->getMessage(), (int)$e->getCode());
  }

  $query = "SELECT * FROM User WHERE username ='$username' AND password='$password'";
  $result = $db -> query($query);
  
  if (!$result) {
    $errors["Database Error"] = "Could not retrieve user information";
  } elseif ($row = $result->fetch()) {
    session_start();

            $_SESSION["user_ID"] = $row["user_ID"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["avatar_url"] = $row["avatar_url"];

            header("Location: after-login.php");
            exit();

        }else{
          $errors["Login Failed"] = "That email/password combination does not exist.";
             }
              $db = null;
           }
           else {

            $errors['Login Failed'] = "You entered invalid data while logging in.";
        }
            if(!empty($errors)){
              foreach($errors as $type => $message) {
                  echo "$type: $message <br />\n";
              }
  }

}
?>





















<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/Askify.css" />
    <script src="js/registerLogin.js"></script>
</head>

<body>
<form action="after-login.php" method="post" >
  <div class="signin-container">
  
                      <div class="margin">
                                <div class="logo">
                                  <img src="img/Askify-transformed-transformed-removebg-preview.png" alt="Company Logo" class="logo" ">
                                </div>
                      </div>

                      <div class="slogan" style="font-size: 15px;"> 
                                <p>ASK&nbsp;&nbsp;&nbsp;DISCUSS&nbsp;&nbsp;&nbsp;LEARN</p>
                      </div>
                   
                     <div class="guest-logo">               
                                <img src="img/guest-transformed-removebg-preview.png" alt="Guest Image" class="guest-image">
                     </div>
                        
                     <div class="username-input">
                                <input class="input-field" type="text" placeholder="Enter your email" id="email">
                                <p id="error-text-username" class="error-text hidden">Username is invalid</p>
                     </div>

                     <div class="password-input">          
                                <input class="input-field" type="password" placeholder="Password" id="password">
                                <p id="error-text-password" class="error-text hidden">Password is invalid</p>
                     </div>
                     <div class="reset-password">
                                <a href="#" class="forgot-password-link">Forgot Password?</a>
                     </div>

                     <div class="button-login">
                              
                                    <button class="login-button" id="login-button">Login</button>
                     
                                
                    </div>

                    <div class="new-user">
                      <a href="signup.php" class="new-user">New User?</a>
                    </div>
  
                  </div>
</form>
</body>

</html>