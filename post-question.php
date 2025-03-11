<?php
session_start();
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}

// Check if session variables are set
if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['email'], $_SESSION['avatar'])) {
    // Initialize variables
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $avatar =$_SESSION['avatar_url'];
    $errors = array();
    $questionText = "";
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['writingArea']) && !empty($_POST['writingArea'])) {
        $questionText = test_input($_POST['writingArea']);
    } else {
        $errors[] = "Question text is required";
    }

    if (empty($errors)) {
        try {
            $db = new PDO("mysql:host=localhost;dbname=hpa021", "hpa021", "H@rsh1313!");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully"; 
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        $query = "INSERT INTO questions (question_text, user_id, post_date) VALUES (:question_text, :user_id, CURRENT_TIMESTAMP)";
        $result = $db->prepare($query);
        $result->bindParam(':question_text', $questionText);
        $result->bindParam(':user_id', $user_id);
        $executed = $result->execute();

        if (!$executed) {
          $errors['database'] = "Failed to insert the question.";
      } else {
          $db = null;
          $_SESSION['username'] = $username;
          $_SESSION['avatar_url'] = $avatar; // Corrected line
          header("Location: post-question.php");
          exit();
      }
    }
    else {
      foreach($errors as $type => $message) {
          echo "$type: $message <br />\n";
      }
  }
}

// Print errors if any
if (!empty($errors)) {
    foreach($errors as $type => $message) {
        echo "$type: $message <br />";
    }
}
?>







<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/Askify.css" />
</head>

<body style="background-color: #002138;">
  <div class="logo-margin">
    <div class="logo">
      <img src="img/Askify-transformed-transformed-removebg-preview.png" alt="Company Logo" class="logo" >
    </div>
  </div>
  <div class="body1">
    <div class="menu">
      <div class="bar1">
        <a href="after-login.php">
          <button style="font-size: 15px;">Home</button>
        </a>
      </div>
      <div class="bar1">
        <a href="question-management.php">
          <button style="font-size: 15px;">Question Management</button>
        </a>
      </div>
      <div class="bar1">
        <a href="post-question.php">
          <button class="active" style="font-size: 15px;">Create your question</button>
        </a>
      </div>
      <div class="bar1">
        <a href="question-detail-page.php">
          <button style="font-size: 15px;">Question detail page</button>
        </a>
      </div>
      <br>
      <p style="margin-top: 300px;">
        <a style="color: white;" href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fwww.webdev.cs.uregina.ca%2F~hpa021%2Fassignment3%2Fpost-question.html">XHTML 5 validation</a>
      </p>
      <p>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
          <img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!" />
        </a>
      </p>
    </div>
    <div class="post">
      <div class="question">
        <div class="text">
          <h1>Create your question below</h1>
        </div>
        <br>
      </div>
      <div class="post-question">
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <textarea id="writingArea" name="writingArea" rows="4" cols="50"></textarea>
          <div class="submit-delete">
            <button class="submit-deletes" style="font-size: 15px;" type="submit" id="upload">Upload</button>
            <button class="deletes-submit" style="font-size: 15px;" type="reset" id="Reset">Reset</button>
          </div>
        </form>
      </div>
      <p id="error-text-question" class="error-text hidden">you must write 20 or less then 1500 words</p>
    </div>
  </div>
  <footer id="footer-auth">
    <p class="footer-text">
      <div class="button-logout-1">
        <a href="login.php">
          <button class="logout-button" style="font-size: 15px;">Logout</button>
        </a>
      </div>
    </p>
  </footer>
  <script src="js/registerCreateQuestion.js"></script>
</body>

</html>
