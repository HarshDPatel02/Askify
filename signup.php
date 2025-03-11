<?php
require_once "db.php";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$error = array();

$username = "";
$password = "";
$email = "";
$confirm_password = "";
$firstname = "";
$lastname ="";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST["username"]) ? test_input($_POST["username"]) : "";
    $password = isset($_POST["password"]) ? test_input($_POST["password"]) : "";
    $email = isset($_POST["email"]) ? test_input($_POST["email"]) : "";
    $confirm_password = isset($_POST["confirm_password"]) ? test_input($_POST["confirm_password"]) : "";
    $firstname = isset($_POST["firstname"]) ? test_input($_POST["firstname"]) : "";
    $lastname = isset($_POST["lastname"]) ? test_input($_POST["lastname"]) : "";



    $unameRegEx = "/^[a-zA-Z0-9_]+$/";
    $pwdRegEx = "/^[A-Za-z0-9(@#\$%\^&\*)+]{6}$/";

    if (empty($username)) {
        $error["username"] = "Username is required";
    } elseif (!preg_match($unameRegEx, $username)) {
        $error["username"] = "Invalid username format";
    }

    if (empty($password)) {
        $error["password"] = "Password is required";
    } elseif (strlen($password) < 6) {
        $error["password"] = "Password must be at least 6 characters long";
    } elseif (!preg_match($pwdRegEx, $password)) {
        $error["password"] = "password contain number and alphabat";
    }

    if (empty($confirm_password)) {
        $error["confirm_password"] = "Please confirm your password";
    } elseif ($password !== $confirm_password) {
        $error["confirm_password"] = "Passwords do not match";
    }

    if (empty($email)) {
        $error["email"] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Invalid email format";
    }
   
    
    if (empty($firstname)) {
        $error["firstname"] = "First name is required";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $firstname)) {
        $error["firstname"] = "Invalid first name format";
    }
    
    if (empty($lastname)) {
        $error["lastname"] = "Last name is required";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $lastname)) {
        $error["lastname"] = "Invalid last name format";
    }



    if(isset($_POST['accounttype'])){
        $accountype = $_POST['accounttype'];
    }
    
    try {
        $db = new PDO("mysql:host=localhost;dbname=hpa021", "hpa021", "H@rsh1313!");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }

    $query = "SELECT * FROM Users WHERE username='$username'";
    $result = $db->query($query);
    $match = 0;

    if ($result->fetch()) {
        $error["username"] = "This username is already taken";
    }
    else {
        
            $query = "INSERT INTO Users(username,email, password,confirm_password, avatar,firstname,lastname) VALUES ('$username','$email','$password','$confirm_password', 'avatar_stub','$firstname','$lastname')";
            $result = $db -> exec($query);
    }

    if (empty($error)) {
        $target_dir = "uploads/";
        $uploadOk = true;
        $target_file = "";

        $imageFileType = strtolower(
            pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION)
        );

        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                $error["avatar"] =
                    "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
                $uploadOk = false;
            }

            if($_FILES['avatar']['size'] > 1000000 ){
                $error['avatar'] = "filesize is greater that 1 mb.";
                $uploadOK = false;
            }

            if ($uploadOk) {
                $fileStatus = move_uploaded_file( $_FILES["avatar"]["tmp_name"],$target_file);
                if (!$fileStatus) {
                    $error["ServerError"] =
                        "Image file could not get intpo server";
                    $uploadOK = false;
                }
            }

            if (!$uploadOk) {
                $query = "DELETE FROM Users Where username = '$username'";
                $result = $db->exec($query);
                if (!$result) {
                    $error["DbError"] =
                        "User could not be deleted.";
                }
                $db = null;
            } else {
                $query = "UPDATE Users SET avatar_url = '$target_file' WHERE username='$username'";

                $result = $db->exec($query);
                if (!$result) {
                    $error["DbError"] = "avatar couldn't be updated";
                } else {
                    $db = null;

                    header("Location:login.php");

                    exit();
                }
            }
        }
    }
    print_r($error);
    foreach ($error as $type => $message) {
        print "$type : $message \n <br />";
    }
?>








































<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/Askify.css" />
    <script src="js/registerSignup.js"></script>
</head>

<body>
    <div class="signup-container">

        <div class="margin">
            <div class="logo">
                <img src="img/Askify-transformed-transformed-removebg-preview.png" alt="Company Logo" class="logo" ">
            </div>
        </div>

        <div class="slogan" style="font-size: 15px;">
            <p>ASK&nbsp;&nbsp;&nbsp;DISCUSS&nbsp;&nbsp;&nbsp;LEARN</p>
        </div>

        <form action="signup.php" method="post">
            <div class="information">

                <div class="inputs">
                    <input class="input-field" type="text" placeholder="First Name" id="fname">
                    <p id="error-text-fname" class="error-text hidden">First name is invalid</p>
                </div>

                <div class="inputs">
                    <input class="input-field" type="text" placeholder="Last Name" id="lname">
                    <p id="error-text-lname" class="error-text hidden">Last name is invalid</p>
                </div>
                <br>
                <div class="inputs">
                    <input class="input-field" type="password" placeholder="Password" id="password">
                    <p id="error-text-password" class="error-text hidden">Password is invalid</p>
                </div>
                <div class="inputs">
                    <input class="input-field" type="password" placeholder="Confirm Password" id="confirmPassword">
                    <p id="error-text-confirm-password" class="error-text hidden"> Does not match with your password </p>
                </div>
                <br>
                <div class="inputss">
                    <input class="input-field" type="email" placeholder="email" id="email">
                    <p id="error-text-email" class="error-text hidden">invalid email address</p>
                </div>
                <br>
                <div class="inputs">
                    <label for="dob">Date of Birth</label>
                </div>

                <div class="inputs">
                    <input class="input-field" type="date" name="dob" id="dob">
                    <p id="error-text-dob" class="error-text hidden">DOB is invalid</p>
                </div>
                <br>
                <div class="inputs">
                    <input class="input-field" type="text" placeholder="Username" id="username">
                    <p id="error-text-username" class="error-text hidden">Username is invalid</p>
                </div>

                <div class="inputs">
                    <label for="profilephoto">Profile Photo :- </label>
                    <input style="color: white;" type="file" id="profilephoto" name="profilephoto" accept="image/*" />
                    <p id="error-text-photo" class="error-text hidden">Upload Profile Photo </p>
                </div>

            </div>

            <div class="button-sign">
                <button type="submit" class="sign-button" id="sign-button">SignUp</button>
            </div>
        </form>

        <div class="already-user">
            <a href="login.php" class="already-user" style="color: white;">Already A User?</a>
        </div>
    </div>

</body>

</html>


