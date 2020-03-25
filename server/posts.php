<?php
include '../db_connection.php';
include '../client/top.php';

$connection = openConnection();
$isValidForm = true;
$errors = array();

// validate that user is logged in
if (!isset($_SESSION["userID"])) {
    echo "User must be logged in";
} // validate that user is in database
else {
    $userID = $_SESSION['id'];

    if (!filter_var($userID, FILTER_VALIDATE_INT)) {
        echo "<p>You are not properly logged in. Please try again </p>";
    } else {

        $pdo = openConnection();
        $sql = "SELECT * FROM users WHERE id=?;";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $userID);
        $statement->execute();
        $result = $statement->fetch();

        if (!$result) {
            array_push($errors, "User not found in database");
            $isValidForm = false;
        }


        // for creating or editing a post
        if (isset($_POST['create']) || isset($_POST['edit'])) {
            $title = $body = $category = "";

            // validate title and body are filled in
            if (!isset($_POST["title"])) {
                array_push($errors, "Title must be filled in");
                $isValidForm = false;
            } else {
                $title = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
            }

            if (!isset($_POST["body"])) {
                array_push($errors, "Body must be filled in");
                $isValidForm = false;
            } else {
                $body = filter_var($_POST["body"], FILTER_SANITIZE_STRING);
            }

            if (isset($_POST["category"])) {
                $category = filter_var($_POST["category"], FILTER_SANITIZE_STRING);
            }

            // if id passed through get -> edit post with that id. Else, create a new post
            if (isset($_GET["id"])) {
                // validate that post ID is an integer
                if (!filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
                    $isValidForm = false;
                    array_push($errors, "PostID must be an integer. ");
                } else {
                    $postID = $_GET['id'];

                    // validate that post is in the database
                    $sql = "SELECT * FROM posts WHERE id=?;";
                    $statement = $pdo->prepare($sql);
                    $statement->bindValue(1, $postID);
                    $statement->execute();
                    $result = $statement->fetch();

                    if (!$result) {
                        array_push($errors, "Post not found in database");
                        $isValidForm = false;
                    }

                    // update post in database if form is valid. Else echo errors
                    if ($isValidForm) {
                        $sql = "UPDATE posts SET body=?, title=?, category=?, updated_at=? WHERE id=?;";
                        $statement = $pdo->prepare($sql);
                        $statement->bindValue(1, $body);
                        $statement->bindValue(2, $title);
                        $statement->bindValue(3, $category);
                        $statement->bindValue(4, date("Y-m-d"));
                        $statement->bindValue(5, $postID);
                        $result = $statement->execute();


                        //TODO: redirect to show post
                        header("Location: ../client/posts/show.php?id=$postID");
                        exit();

                    } else {
                        foreach ($errors as $e) {
                            echo $e . "\n";
                        }
                    }
                }


            } else if ($isValidForm) {
                // create new post from form data if form is valid
                echo $title . $category . $body . $userID;
                $sql = "INSERT INTO posts (title, category, body, user_id, created_at) VALUES (?, ?, ?, ?, ?)";
                $statement = $pdo->prepare($sql);
                $statement->bindValue(1, $title);
                $statement->bindValue(2, $category);
                $statement->bindValue(3, $body);
                $statement->bindValue(4, $userID);
                $statement->bindValue(5, date("Y-m-d"));
                $result = $statement->execute();
                $postID = $pdo->lastInsertId();;

                // redirect to show post
                header("Location: ../client/posts/show.php?id=$postID");
                exit();

            } // otherwise print errors
            else foreach ($errors as $e) {
                echo "<p>$e</p>";
            };

        }
    }
}




