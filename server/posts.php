<?php

// create or edit a post
if (isset($_POST['create']) || isset($_POST['edit'])) {
    $isValidForm = true;
    $errors = array();
    $title = $body = $category = $userID = "";

    // make sure title and body are filled in and user is logged in
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

    if (!isset($_SESSION["userID"])) {
        array_push($errors, "User must be logged in");
        $isValidForm = false;
    }

    // TODO: validate that user is in database
    else {
        $userID = $_SESSION["userID"];
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
        }

        // TODO: validate that post is in the database

        // TODO: update post in database if form is valid. Else echo errors
        if ($isValidForm) {
            echo "updating post";
        } else {
            foreach ($errors as $e) {
                echo $e . "\n";
            }
        }

    } else if ($isValidForm) {
        // TODO: create new post from form data if form is valid
        echo "creating new post";

    } // otherwise print errors
    else foreach ($errors as $e) {
        echo "<p>$e</p>";
    };
    echo "<h1>Your Input: </h1>";
    echo "<p>Title: $title</p>";
    echo "<p>Category: $category</p>";
    echo "<p>Body: $body</p>";

}




