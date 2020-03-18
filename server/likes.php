<?php

if (isset($_GET['userID']) && isset($_GET['postID'])) {
    $userID = $_GET['userID'];
    $postID = $_GET['postID'];

    // validate that userID and postID are integers
    if (!filter_var($userID, FILTER_VALIDATE_INT)) {
        echo "<p>userID must be an integer. </p>";
    }
    else if (!filter_var($postID, FILTER_VALIDATE_INT)) {
        echo "<p>PostID must be an integer. </p>";
    }

    // TODO: validate that userID and postID exist in database

    // TODO: add like to database

    echo "liked";
}