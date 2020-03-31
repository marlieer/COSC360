<?php
// for database connection later
include "db_connect.php";

// initalize all variables for data
$fnameErr =  $lnameErr = $emailErr = $passErr  = $rpassErr = $birthErr = "";
$fname = $lname = $email = $pass = $rpass = $birth = "";

// -------------------------------------------------------------------------------
// for FORGOT PASSWORD page
// -------------------------------------------------------------------------------
if (isset($_POST['forgot-submit'])) {
    // check email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } 
    else {
        $email = str_input($_POST["email"]);
        // check email in correct function
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
        else{
            // get data from database
            db_forget($email);
        }
    }
}

// -------------------------------------------------------------------------------
// for LOGIN page
// -------------------------------------------------------------------------------
if (isset($_POST['login-submit'])) {

    // check email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } 
    else {
        $email = str_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }

        //check password
        if (empty($_POST["pass"])) {
            $passErr = "Password is required";
        } 
        else {
            $pass = str_input($_POST["pass"]);

            $upper = preg_match('@[A-Z]@', $pass);
            $lower = preg_match('@[a-z]@', $pass);
            $number = preg_match('@[0-9]@', $pass);
            if (!$upper || !$lower || !$number || strlen($pass) < 8 ) {
                $passErr = "Invalid email format";
            }
            else{
                db_login($email, $pass);
            } 
        }
    }
}

// -------------------------------------------------------------------------------
// for SIGN UP page
// -------------------------------------------------------------------------------
if (isset($_POST['signup-submit'])) {
    $data = [];

    //check email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } 
    else {
        $email = str_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
        else{
            $data["email"] = $email;
        }
    }

    //check password
    if (empty($_POST["pass"])) {
        $passErr = "Password is required";
    } 
    else {
        $pass = str_input($_POST["pass"]);

        $upper = preg_match('@[A-Z]@', $pass);
        $lower = preg_match('@[a-z]@', $pass);
        $number = preg_match('@[0-9]@', $pass);

        if (!$upper || !$lower || !$number || strlen($pass) < 8 ) {
            $passErr = "Invalid password format";
        }
        else{
            $data["password"] = $pass;
        }
    }

    //check re-enter password
    if (empty($_POST["rpass"])) {
        $rpassErr = "Password is required";
    } 
    else {
        $rpass = str_input($_POST["rpass"]);

        $upper = preg_match('@[A-Z]@', $rpass);
        $lower = preg_match('@[a-z]@', $rpass);
        $number = preg_match('@[0-9]@', $rpass);

        if (!$upper || !$lower || !$number || strlen($rpass) < 8 ) {
            $rpassErr = "Invalid password format";
        }
        else if(strcmp($rpass,$pass) !== 0){
            $rpassErr = "Confirmed password does not match password";
        }
        else{
            $data["rpassword"] = $rpass;
        }
    }

    //check first and last name
    if (empty($_POST["fname"])) {
        $fnameErr = "First name is required";
    } 
    else {
        $fname = str_input($_POST["fname"]);

        $number = preg_match("@[0-9]@", $fname);

        if ($number) {
            $fnameErr = "Invalid name format";
        }
        else{
            if (empty($_POST["lname"])) {
                $lnameErr = "Last name is required";
            } 
            else {
                $lname = str_input($_POST["lname"]);

                $number = preg_match("@[0-9]@", $lname);

                if ($number) {
                    $lnameErr = "Invalid name format";
                }
                else{
                    $data["name"] = $fname . " " . $lname;
                }
            }
        }
    }   

    //check birthdate
    if (empty($_POST["birth"])) {
        $brithErr = "Birthday is required";
    } 
    else {
        $birth = str_input($_POST["birth"]);
        $data["birthdate"] = $birth;
    }

    //send to database information
    db_signup($data);
}

// -------------------------------------------------------------------------------
// FUNCTIONS
// -------------------------------------------------------------------------------
function str_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// email password 
// NOTE - on google for mates and posts account must have turn on less authorized apps access
// also to turn off fire wall
function db_forget($email){
    $check = 0;

    try{
        $conn = openConnection();

        $sqlemail = $conn->quote($email);
        $sql = "SELECT name, password FROM users WHERE email=$sqlemail";
        $result = $conn->query($sql);

        while($row = $result->fetch()){
            $name = $row["name"];
            $password = $row["password"];
            $check = 1;
        }

        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  
    if($check == 1)   {
        // the message
        $msg = "Hi $name,\nHere is your password: $password\nRegards,\nAdmin";
    
        // use wordwrap() if lines are longer than 70 characters
        // send email
        if(mail($email, "Mates & Posts - Password Recovery",$msg)){
            echo $msg;
            echo "Recovery password email sent.";
            echo "<script>alert('Recovery password email sent. Please check email.')</script>";
            echo "<script>window.location='../client/auth/login.php'</script>";
        }
        else{
            echo "Message could not be sent.";
            echo "<script>alert('Recovery password email was not sent. Please try again later.')</script>";
            echo "<script>window.location='../client/auth/forgotpassword.php'</script>";
        }
    }
    else{
        echo "<script>alert('The email was not found.')</script>";
        echo "<script>window.location='../client/auth/forgotpassword.php'</script>";
    }
}

function db_login($email, $pass){
    $check = 0;
    $d = date("Y-m-d");
    
    try{
        $conn = openConnection();

        $email = $conn->quote($email);
        $pass = $conn->quote($pass);
        $sql = "SELECT id, name, admin, enabled FROM users WHERE email=$email AND password=$pass";
        $result = $conn->query($sql);
                
        while($row = $result->fetch()){
            $id = $row["id"];
            $user = $row["name"];
            $admin = $row["admin"];
            $enabled = $row["enabled"];
            $check = 1;
        }

        closeConnection($conn);       

        // if user matches, go to home index
        if($check == 1){

            // user has been disabled by admin, redirect to home page
            if($enabled == 0){
                echo "<script>alert('User has been disabled. Please contact admin for further assistance.')</script>";
                echo "<script>window.location='../client/posts/index.php'</script>";
            }                                                            
            // update last login of user
            $conn = openConnection();
            $sql = "UPDATE users SET last_login='$d' WHERE id=$id";
            if($conn->query($sql)){
                echo "\n$sql\n";
            }
            closeConnection($conn); 

            // set session for user login
            session_start();
            $_SESSION["id"] = $id;
            $_SESSION["user"] = $user;
            $_SESSION["admin"] = $admin;
            $_SESSION["enabled"] = $enabled;
            
            // redirect to home page
            echo "<script>window.location='../client/posts/index.php'</script>";
        }
        // if not, redirect to login page
        else{
            echo "<script>alert('The email and/or password does not match.')</script>";
            echo "<script>window.location='../client/auth/login.php'</script>";
        }        
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  
}

function db_signup($arr){
    if(count($arr) != 5){
        echo "<script>alert('Signup form was not completed properly.')</script>";
        echo "<script>window.location='../client/auth/signup.php'</script>";
    }
    else{
        $check = 0;
        $date = date('Y-m-d');
        try{
            $conn = openConnection();

            $sql = "INSERT INTO users (name, email, password, birthdate, admin, enabled, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $statement = $conn->prepare($sql);
            
            $statement->bindValue(1, $arr["name"]);
            $statement->bindValue(2, $arr["email"]);
            $statement->bindValue(3, $arr["password"]);
            $statement->bindValue(4, $arr["birthdate"]);
            $statement->bindValue(5, 0);
            $statement->bindValue(6, 1);
            $statement->bindValue(7, $date);
            $statement->bindValue(8, $date);

            $statement->execute();
            $check = 1;

            closeConnection($conn);

            // if user matches, go to home index
            if($check == 1){
                echo "<script>alert('User created. Please login.')</script>";
                echo "<script>window.location='../client/posts/index.php'</script>";
            }
            // if not, redirect to login page
            else{
                echo "<script>alert('Something went wrong creating user. Please retry signing up.')</script>";
                echo "<script>window.location='../client/auth/signup.php'</script>";
            }        
        }   
        catch(PDOException $err){
            die($err->getMessage());
        }  
    }
}

?>