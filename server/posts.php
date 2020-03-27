<?php
include 'db_connect.php';
include '../client/top.php';

$pdo = openConnection();
$isValidForm = true;
$errors = array();

// validate that user is logged in
if (!isset($_SESSION["id"])) {
    $_SESSION['warning'] = "You must be logged in to perform this action";

    // redirect to login
    header("Location: ../client/auth/login.php");
    exit();

} // validate that user is in database
else {
    $userID = $_SESSION['id'];

    if (!filter_var($userID, FILTER_VALIDATE_INT)) {
        $_SESSION['warning'] = "You must be logged in to perform this action";

        // redirect to login
        header("Location: ../client/auth/login.php");
        exit();

    } else {

        $sql = "SELECT * FROM users WHERE id=?;";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $userID);
        $statement->execute();
        $user = $statement->fetch();

        if (!$user) {
            $_SESSION['warning'] = "You must be logged in to perform this action";

            // redirect to login
            header("Location: ../client/auth/login.php");
            exit();
        } else if (isset($_POST['delete'])) {
            deletePost($user, $pdo);
        } // for creating or editing a post
        else if (isset($_POST['create']) || isset($_POST['edit'])) {
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
                    $_SESSION['warning'] = "Post not found";

                    // redirect to index posts
                    header("Location: ../client/posts/index.php");
                    exit();

                } else {
                    $postID = $_GET['id'];

                    // validate that post is in the database
                    $sql = "SELECT * FROM posts WHERE id=?;";
                    $statement = $pdo->prepare($sql);
                    $statement->bindValue(1, $postID);
                    $statement->execute();
                    $result = $statement->fetch();

                    if (!$result) {
                        $_SESSION['warning'] = "Post not found";

                        // redirect to index posts
                        header("Location: ../client/posts/index.php");
                        exit();
                    }

                    // update post in database if form is valid. Else echo errors
                    if ($isValidForm) {
                        if ($userID === $result['user_id']) {
                            $sql = "UPDATE posts SET body=?, title=?, category=?, updated_at=? WHERE id=?;";
                            $statement = $pdo->prepare($sql);
                            $statement->bindValue(1, $body);
                            $statement->bindValue(2, $title);
                            $statement->bindValue(3, $category);
                            $statement->bindValue(4, date("Y-m-d"));
                            $statement->bindValue(5, $postID);
                            $result = $statement->execute();


                            // redirect to show post
                            header("Location: ../client/posts/show.php?id=$postID");
                            exit();

                        } else {
                            $_SESSION['warning'] = "You are not authorized to perform this action";

                            // redirect to show post
                            header("Location: ../client/posts/show.php?id=$postID");
                            exit();
                        }
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

closeConnection($pdo);

function deletePost($user, PDO $pdo)
{

    // validate that post ID is an integer
    if (!filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
        $_SESSION['warning'] = "PostID must be an integer. ";

        // redirect to show post
        header("Location: ../client/posts/index.php");
        exit();

    } else {
        $postID = $_GET['id'];
        $postAuthor = -1;

        $sql = "SELECT * FROM posts WHERE id=?";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $postID);
        $statement->execute();
        $result = $statement->fetch();
        if ($result) {
            $postAuthor = $result['user_id'];
        }

        // delete post if user is post author or admin
        if ($user['admin'] || $user['id'] === $postAuthor) {
            $sql = "DELETE FROM posts WHERE id=?;";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $postID);
            $statement->execute();

            $_SESSION['message'] = "Post successfully deleted";

            // redirect to index posts
            header("Location: ../client/posts/index.php");
            exit();
        } else {
            $_SESSION['warning'] = "You are not authorized to delete this post";

            // redirect to show post
            header("Location: ../client/posts/show.php?id=$postID");
            exit();
        }

    }
}


