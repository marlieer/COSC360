<?php
include "db_connect.php";
if (isset($_GET['userID']) && isset($_GET['postID'])) {

    $isValid = true;

    $userID = $_GET['userID'];
    $postID = $_GET['postID'];
    $command = $_GET['command'];

    // validate that userID and postID are integers
    if (!filter_var($userID, FILTER_VALIDATE_INT)) {
        echo "<p>userID must be an integer. </p>";
    } else if (!filter_var($postID, FILTER_VALIDATE_INT)) {
        echo "<p>PostID must be an integer. </p>";
    }

    // validate that userID and postID exist in database
    $pdo = openConnection();

    $sql = "SELECT * FROM users where id=?";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $userID);
    $statement->execute();
    $result = $statement->fetch();

    if (!$result) {
        $isValid = false;
        echo("Not a valid user_id");
    }


    $sql = "SELECT * FROM posts where id=?";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $postID);
    $statement->execute();
    $result = $statement->fetch();

    if (!$result) {
        $isValid = false;
        echo "Not a valid post_id";
    }

    // add like to database
    if ($isValid) {

        if ($command == "add") {
            $sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $postID);
            $statement->bindValue(2, $userID);
            $result = $statement->execute();
            echo "add";

        } else if ($command == "remove") {
            $sql = "DELETE FROM likes WHERE post_id=? and user_id=?";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $postID);
            $statement->bindValue(2, $userID);
            $result = $statement->execute();
            echo "remove";
        }

    }

    closeConnection($pdo);
}