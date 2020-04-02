<?php

include '../top.php';
include '../../server/db_connect.php';

$valid = true;
$_SESSION['userID'] = -1;

// validate that postID is an integer
parse_str($_SERVER['QUERY_STRING'], $params);
$postID = $params['id'];
if (!filter_var($postID, FILTER_VALIDATE_INT)) {
    echo "<p class='warning'>PostID must be an integer. </p>";
    $valid = false;
}

// validate that logged in userID is an integer
$session_userID=(isset($_SESSION['userID'])) ? $_SESSION['userID'] : 1;
if (!filter_var($session_userID, FILTER_VALIDATE_INT)) {
    echo "<p class='warning'>UserID must be an integer. </p>";
    $valid = false;
}

// validate that logged in user owns this post
$pdo = openConnection();

$sql = "SELECT * FROM posts where id=?";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $postID);
$statement->execute();
$result = $statement->fetch();

?>
    <main>
        <?php if ($result){ ?>
            <form method="post" action="../server/posts.php?id=<?php echo $postID; ?>" onsubmit="return validateCreatePost()">
                <fieldset>
                    <legend>Edit Post</legend>
                    <p>
                        <label for="title">Title:</label>
                        <input class="input form-control" type="text" name="title" id="title" value="<?php echo $result['title']; ?>"/>
                    </p>
                    <p>
                        <label for="category">Category:</label>
                        <input class="input form-control" type="text" name="category" id="category" max="50" value="<?php echo $result['category']; ?>"/>
                        <small>Separate multiple categories with a semi-colon</small>
                    </p>
                    <p>
                        <label for="body">Body:</label>
                        <textarea class="input form-control" name="body" col="5" rows="5" id="body"><?php echo $result['body']; ?></textarea>
                        <small>Max characters: 250</small>
                    </p>
                    <div class="container">
                        <button class="btn my-btn" name="edit" type="submit">publish</button>
                        <a href="posts/show.php?id=<?php echo $postID;?>" class="btn my-btn cancel-btn">cancel</a>
                        <button class="btn my-btn delete-btn" name="delete" type="submit" onsubmit="confirm('Are you sure?')">delete</button>
                    </div>
                </fieldset>
            </form>

    <?php } ?>
</main>
<?php include '../bottom.php'; ?>