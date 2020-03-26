<?php
include '../db_connection.php';


function validateUser($id){

    // check that id is a valid integer
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        echo "<p>You are not properly logged in. Please try again </p>";
    }

    // check that id belongs to a user
    else {
        $pdo = openConnection();

        $sql = "SELECT * FROM users WHERE id=?";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();
        $result = $statement->fetch();

        if($result){
            closeConnection($pdo);
            return true;
        }
    }
    return false;
}

function validatePost($id){

    // check that id is a valid integer
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        echo "<p>That is not a valid post. Please try again</p>";
    }

    // check that id belongs to a post
    else {
        $pdo = openConnection();

        $sql = "SELECT * FROM posts WHERE id=?";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();
        $result = $statement->fetch();

        if($result){
            closeConnection($pdo);
            return true;
        }
    }
    return false;
}


function sanitizeText($text){
    return filter_var($text, FILTER_SANITIZE_STRING);
}