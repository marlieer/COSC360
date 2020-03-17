<?php
$fnameErr =  $lnameErr = $emailErr = $opassErr = $npassErr  = $rpassErr = $birthErr = "";
$fname = $lname = $email = $opass = $npass = $rpass = $birth = "";

$userid = 2;

$passPreg = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
$namePreg = "/^[a-zA-Z0-9]*$/";


echo "<h2>Your Input:</h2>";

if (isset($_POST['edit-submit'])) {
    if (!empty($_POST["email"]))  {
        $email = str_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (!empty($_POST["newpass"])) {
        if (empty($_POST["oldpass"])) {
            $opassErr = "Password is required";
        } 
        else {
            $opass = str_input($_POST["oldpass"]);
            if (!preg_match($passPreg, $opass)) {
                $opassErr = "Invalid password format";
                echo 'here';
            }
            else{
                
                $npass = str_input($_POST["newpass"]);
                if (!preg_match($passPreg, $npass)) {
                    $npassErr = "Invalid password format";
                }
                if (empty($_POST["rpass"])) {
                    $rpassErr = "Password is required";
                } 
                else {
                    $rpass = str_input($_POST["rpass"]);
                    if (!preg_match($passPreg, $rpass)) {
                        $rpassErr = "Invalid password format";
                    }
                    if(strcmp($rpass,$npass) !== 0){
                        $rpassErr = "Confirmed password does not match password";
                    }
                }
            }
        }
    }

    if (!empty($_POST["fname"])){
        $fname = str_input($_POST["fname"]);
        if (!preg_match($namePreg, $fname)) {
            $fnameErr = "Invalid name format";
        }
    }

    if (!empty($_POST["lname"])){
        $lname = str_input($_POST["lname"]);
        if (!preg_match($namePreg, $lname)) {
            $lnameErr = "Invalid name format";
        }
    }

    if (!empty($_POST["birth"])){
        $birth = str_input($_POST["birth"]);
    }

    if(!empty($_FILE["file"])){
        $validExt = array("jpg", "png");

        $fileName = $_FILES['file']['name'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        if(in_array($fileActualExt, $validExt)){
            echo "<p>valid file</p>";

            
            $fileToMove = $_FILES["file"]["tmp_name"];
            $destination = "./client/profilePics/".$userid.".".$fileActualExt;
            move_uploaded_file($fileToMove, $destination);

        }
        else{
                echo "<p>".$fileName." invalid file type</p>";
        }
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
echo "<p>Email: $email</p>";
echo"<br>";
echo "<p>old Password: $opass</p>";
echo"<br>";
echo "<p>New Password: $npass</p>";
echo"<br>";
echo "<p>Re-enter Password: $rpass</p>";
echo"<br>";
echo "<p>Birthday: $birth</p>";
echo"<br>";

?>