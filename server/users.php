<?php
// for database connection later
include "db_connect.php";

// innitalize all variables for data
$fnameErr =  $lnameErr = $emailErr = $opassErr = $npassErr  = $rpassErr = $birthErr = "";
$fname = $lname = $email = $opass = $npass = $rpass = $birth = "";

// get session id
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;

// -------------------------------------------------------------------------------
// for MYPROFILE and SHOWING USERS page
// -------------------------------------------------------------------------------
function show_users($user){
    $data = [];

    try{
        $conn = openConnection();
        $sql = "SELECT id, name, email, birthdate, profile_img, created_at FROM users WHERE id=$user";
        $result = $conn->query($sql);

        while($row = $result->fetch()){
            $data[] = $row['id'];
            $data[] = $row['name'];
            $data[] = $row['birthdate'];
            $data[] = $row['email'];
            $data[] = $row['profile_img'];
            $data[] = $row['created_at'];
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  

    return $data;
}

function show_posts($user){
    $data = [];
    try{
        $conn = openConnection();
        $sql = "SELECT id, title, body FROM posts WHERE id=$user";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data[$row['id']] = array($row['title'], $row['body']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }
    
    echo "<h2>User's Posts</h2>";
    foreach($data as $key=>$val){
        echo "<article class='entry'><a href='posts/show.php?id=$key'>";
        echo "<p class='main-title'><strong>$val[0]</strong></p>";
        echo "<p class='main-body'>$val[1]</p>";
        echo "</a></article>";
    }
}
// -------------------------------------------------------------------------------
// for EDITING USER page
// -------------------------------------------------------------------------------
if (isset($_POST['edit-submit'])) {
    $edit = 0;

    // if email changed
    if (!empty($_POST["email"]))  {
        $email = str_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
        else{
            db_email($email, $id);
            $edit++;
        }
    }

    //if new password
    if (!empty($_POST["newpass"])) {
        if (empty($_POST["oldpass"])) {
            $opassErr = "Password is required";
        } 
        else{
            $opass = str_input($_POST["oldpass"]);

            if(check_pass_format($opass)) {
                $opassErr = "Invalid password format";
            }
            // check if inputed old password matches DB password
            elseif(check_pass($opass, $id)){
                $npass = str_input($_POST["newpass"]);

                if (check_pass_format($npass)) {
                    $npassErr = "Invalid password format";
                }

                if (empty($_POST["rpass"])) {
                    $rpassErr = "Password is required";
                } 
                else {
                    $rpass = str_input($_POST["rpass"]);
                    if (check_pass_format($rpass)) {
                        $rpassErr = "Invalid password format";
                    }
                    // check if new password and reenter password match
                    elseif(strcmp($rpass,$npass) !== 0){
                        $rpassErr = "Confirmed password does not match password";
                    }
                    else{
                        db_password($npass, $id);
                        $edit++;
                    }
                }
            }
            else{
                $opassErr = "Incorrect password";
            }
        }
    }

    // if name change
    if (!empty($_POST["fname"])){
        $fname = str_input($_POST["fname"]);
        if (preg_match("@[0-9]@", $fname)) {
            $fnameErr = "Invalid name format";
        }
        else{
            if (!empty($_POST["lname"])){
                $lname = str_input($_POST["lname"]);
                if (preg_match("@[0-9]@", $lname)) {
                    $lnameErr = "Invalid name format";
                }
                else{
                    $name = $fname." ".$lname;
                    db_name($name, $id);
                    $edit++;
                }
            }
        }
    }      

    // if birthdate change
    if (!empty($_POST["birth"])){
        $birth = str_input($_POST["birth"]);
        db_birthdate($birth, $id);
        $edit++;
    }

    // TODO
    if(is_uploaded_file($_FILES["upload"]["tmp_name"])){
        $validExt = array("jpg", "png");

        $fileName = $_FILES['upload']['name'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        if(in_array($fileActualExt, $validExt)){
            echo "<p>valid file</p>";
            
            $fileToMove = $_FILES["upload"]["tmp_name"];
            $destination = "../client/profilePics/".$id.".".$fileActualExt;
            move_uploaded_file($fileToMove, $destination);

            db_profilePic($id, $destination);
            $edit++;

        }
        else{
                echo "<p>".$fileName." invalid file type</p>";
        }
    }

    if($edit > 0){
        db_update($id);
    }
    // redirect to profile page after
    echo "<script>window.location='../client/users/myprofile.php'</script>";
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

function db_email($email, $id){
    try{
        $conn = openConnection();

        $sql = "UPDATE users SET email=? WHERE id=?";
        $statement = $conn->prepare($sql);

        $statement->bindValue(1, $email);
        $statement->bindValue(2, $id);

        $statement->execute();

        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  
}

function db_name($name, $id){  
    try{
        $conn = openConnection();

        $sql = "UPDATE users SET name=? WHERE id=?";
        $statement = $conn->prepare($sql);

        $statement->bindValue(1, $name);
        $statement->bindValue(2, $id);

        $statement->execute();

        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  
}

function db_birthdate($birth, $id){  
    try{
        $conn = openConnection();

        $sql = "UPDATE users SET birthdate=? WHERE id=?";
        $statement = $conn->prepare($sql);
        
        $statement->bindValue(1, $birth);
        $statement->bindValue(2, $id);

        $statement->execute();

        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  
}

function check_pass($pass, $id){  
    $real = '';
    try{
        $conn = openConnection();

        $sql = "SELECT password FROM users WHERE id=$id";
        $result = $conn->query($sql);

        while($row = $result->fetch()){
            $real = $row["password"];
        }

        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    } 
    
    if(strcmp($real, $pass) != 0){
        return false;
    }
    else{
        return true;
    }
}

function check_pass_format($pass){
    $upper = preg_match('@[A-Z]@', $pass);
    $lower = preg_match('@[a-z]@', $pass);
    $number = preg_match('@[0-9]@', $pass);
    if (!$upper || !$lower || !$number || strlen($pass) < 8 ){
        return true;
    }
    else{
        return false;
    }
}

function db_password($pass, $id){
    try{
        $conn = openConnection();
        $sql = "UPDATE users SET password=? WHERE id=?";
        $statement = $conn->prepare($sql);
        
        $statement->bindValue(1, $pass);
        $statement->bindValue(2, $id);
        $statement->execute();
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  
}

function db_profilePic($id, $file){
    try{
        $conn = openConnection();
        $sql = "UPDATE users SET profile_img=? WHERE id=?";
        $statement = $conn->prepare($sql);
        
        $statement->bindValue(1, $file);
        $statement->bindValue(2, $id);
        $statement->execute();
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  
}

function db_update($id){
    $d = date('Y-m-d');
    try{
        $conn = openConnection();
        $sql = "UPDATE users SET last_login=? WHERE id=?";
        $statement = $conn->prepare($sql);
        
        $statement->bindValue(1, $d);
        $statement->bindValue(2, $id);
        $statement->execute();
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }  
}


?>