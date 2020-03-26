<?php
include 'validation.php';
include '../client/top.php';

// create a comment
if (isset($_POST['create'])){
    createComment();
}

// create a new comment for a post
function createComment(){
    $postID = -1;
    $userID = -1;
    $comment = null;

    if(isset($_POST['postID'])){
        $postID = $_POST['postID'];
        echo $postID;
    }

    if(isset($_POST['comment'])){
        $comment = sanitizeText($_POST['comment']);
    }

    if(isset($_SESSION['id'])){
        $userID = $_SESSION['id'];
        echo $userID;
    }

    // insert comment into database
    if(validatePost($postID) && validateUser($userID)){
        $pdo = openConnection();
        $sql = "INSERT INTO comments (post_id, user_id, created_at, comment) VALUES (?, ?, ?, ?)";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $postID);
        $statement->bindValue(2, $userID);
        $statement->bindValue(3, date("Y-m-d"));
        $statement->bindValue(4, $comment);

        $statement->execute();

        closeConnection($pdo);

        // redirect to post
        header("Location: ../client/posts/show.php?id=$postID");
        exit();
    }
    else echo "Post ID or User ID are wrong";

}
