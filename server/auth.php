<?php
$fnameErr =  $lnameErr = $emailErr = $passErr  = $rpassErr = $birthErr = "";
$fname = $lname = $email = $pass = $rpass = $birth = "";
$passPreg = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
$namePreg = "/^[a-zA-Z0-9]*$/";

echo "<h2>Your Input:</h2>";

if (isset($_POST['forgot-submit'])) {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } 
    else {
        $email = str_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
}

if (isset($_POST['login-submit'])) {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } 
    else {
        $email = str_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["pass"])) {
        $passErr = "Password is required";
    } 
    else {
        $pass = str_input($_POST["pass"]);
        if (!preg_match($passPreg, $pass)) {
            $passErr = "Invalid email format";
        }
    }
}

if (isset($_POST['signup-submit'])) {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } 
    else {
        $email = str_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["pass"])) {
        $passErr = "Password is required";
    } 
    else {
        $pass = str_input($_POST["pass"]);
        if (!preg_match($passPreg, $pass)) {
            $passErr = "Invalid password format";
        }
    }

    if (empty($_POST["rpass"])) {
        $rpassErr = "Password is required";
    } 
    else {
        $rpass = str_input($_POST["rpass"]);
        if (!preg_match($passPreg, $rpass)) {
            $rpassErr = "Invalid password format";
        }
        else if(strcmp($rpass,$pass) !== 0){
            $rpassErr = "Confirmed password does not match password";
        }
    }

    if (empty($_POST["fname"])) {
        $fnameErr = "First name is required";
    } 
    else {
        $fname = str_input($_POST["fname"]);
        if (!preg_match($namePreg, $fname)) {
            $fnameErr = "Invalid name format";
        }
    }

    if (empty($_POST["lname"])) {
        $lnameErr = "Last name is required";
    } 
    else {
        $lname = str_input($_POST["lname"]);
        if (!preg_match($namePreg, $lname)) {
            $lnameErr = "Invalid name format";
        }
    }

    if (empty($_POST["birth"])) {
        $brithErr = "Birthday is required";
    } 
    else {
        $birth = str_input($_POST["birth"]);
    }
}

function str_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

echo "<p>Name: $fname $lname</p>";
echo"<br>";
echo "<p>Password: $pass</p>";
echo"<br>";
echo "<p>Re-enter Password: $rpass</p>";
echo"<br>";
echo "<p>Birthday: $birth</p>";
echo"<br>";

?>