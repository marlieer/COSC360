<?php
// for database connection later
include "db_connect.php";

// -------------------------------------------------------------------------------
// for SHOWING ALL REGISTERED USERS page
// -------------------------------------------------------------------------------
function show_all_users(){
    $data = [];
    try{
        $conn = openConnection();
        $sql = "SELECT id, name, email FROM users";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data[$row['id']] = array($row['name'], $row['email']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }

    foreach($data as $key=>$val){
        echo "<article class='entry'><a href='users/show.php?id=$key'>";
        echo "<p class='main-title'><strong>$val[0]</strong></p>";
        echo "<p class='main-body'>$val[1]</p>";
        echo "</a></article>";
    }
}

// -------------------------------------------------------------------------------
// for DISABLING/ENABLING and DELETING USERS as admin
// -------------------------------------------------------------------------------
if(isset($_GET['id']) && isset($_GET['enabled'])){
    $en = $_GET['enabled'];
    $id = $_GET['id'];

    if($en == 0 || $en == 1){
        try{
            $conn = openConnection();
            $sql = "UPDATE users SET enabled=? WHERE id=?";
            $statement = $conn->prepare($sql);
            $statement->bindValue(1, $en);
            $statement->bindValue(2, $id);
            $statement->execute();
            closeConnection($conn);
        }
        catch(PDOException $err){
            die($err->getMessage());
        }
    }
    if($en == 0){
        echo "<script>alert('User $id has be deactivated.')</script>";
    }
    elseif($en == 1){
        echo "<script>alert('User $id has be activated.')</script>";
    }
    // redirect to profile page after
    echo "<script>window.location='../client/users/show.php?id=$id'</script>";
}

if(isset($_GET['id']) && isset($_GET['delete'])){
    $del = $_GET['delete'];
    $id = $_GET['id'];

    if($del == 1){
        try{
            $conn = openConnection();
            $sql = "DELETE FROM users WHERE id=?";
            $statement = $conn->prepare($sql);
            $statement->bindValue(1, $id);
            $statement->execute();
            closeConnection($conn);
        }
        catch(PDOException $err){
            die($err->getMessage());
        }

        echo "<script>alert('User $id' has be deleted.)</script>";
        // redirect to profile page after
        echo "<script>window.location='../client/admin/index.php'</script>";
    }
}

// -------------------------------------------------------------------------------
// for ADMIN ANALYTICS
// -------------------------------------------------------------------------------
function get_top_5(){
    $data = [];
    try{
        $conn = openConnection();
        $sql = "SELECT category, SUM(views) AS total_views FROM posts GROUP BY category ORDER BY SUM(views) DESC LIMIT 5";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data[] = array($row['category'], $row['total_views']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }

    return $data;
}

function get_reg_users(){
    $data = '';
    try{
        $conn = openConnection();
        $sql = "SELECT COUNT(*) AS total_users FROM users";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data = $row['total_users'];
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }
    
    return $data;
}

function get_active_users(){
    $data = '';
    $time = strtotime("-3 year", time());
    $date = date("Y-m-d", $time);
    try{
        $conn = openConnection();
        $sql = "SELECT COUNT(*) AS total_users FROM users WHERE last_login>$date";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data = $row['total_users'];
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }
    
    return $data;
}

function get_monthly_new_users(){
    $data = [];
    try{
        $conn = openConnection();
        $sql = "SELECT COUNT(*) AS total_users, YEAR(created_at) as yearly,  MONTH(created_at) AS monthly FROM users GROUP BY yearly, monthly ORDER BY yearly ASC, monthly ASC";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data = array($row['total_users'], $row['yearly'], $row['monthly']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }
    
    return $data;
}

function get_en_users(){
    $data = [];
    try{
        $conn = openConnection();
        $sql = "SELECT COUNT(*) AS total_users, enabled FROM users GROUP BY enabled";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data = array($row['total_users'], $row['enabled']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }

    return $data;
    }

?>