<?php
include '../top.php';

$valid = true;
$admin = false;

// validate that logged in userID is an integer
$session_userID = (isset($_SESSION['id'])) ? $_SESSION['id'] : -1;
if (!filter_var($session_userID, FILTER_VALIDATE_INT)) {
    echo "<p>You are not properly logged in. Please try again </p>";
} else {

    $pdo = openConnection();

    // check if logged in user is an admin
    if($session_userID !== -1) {
        $sql = "SELECT * from users where id=?";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $session_userID);
        $statement->execute();
        $result = $statement->fetch();

        if ($result) {
            $admin = $result['admin'];
        }
    }

// validate that postID is an integer
    parse_str($_SERVER['QUERY_STRING'], $params);
    $postID = $params['id'];
    if (!filter_var($postID, FILTER_VALIDATE_INT)) {
        echo "<p>PostID must be an integer. </p>";
        $valid = false;
    }

    if ($valid) {

        // Add this post to session array of recently viewed posts.
        // Remove first post if array size is 5 or more
        // only add if postID is not already in array
        $recentlyViewed = (isset($_SESSION['recentlyViewed'])) ? $_SESSION['recentlyViewed'] : array();

        if (!in_array($postID, $recentlyViewed)) {
            if (sizeof($recentlyViewed) >= 5) {
                array_shift($recentlyViewed);
            }
            array_push($recentlyViewed, $postID);
            $_SESSION['recentlyViewed'] = $recentlyViewed;
        }

        // Get post from database along with associated comments
        $sql = "SELECT * FROM posts where id=?";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $postID);
        $statement->execute();
        $result = $statement->fetch();

        // assign post attributes
        $edit_href = "posts/edit.php?id=$postID";
        $post_userID = null;
        $title = null;
        $category = null;
        $body = null;
        $date = null;
        $author = null;
        $author_href = null;


        if ($result) {

            // get name of post author
            $sql = "SELECT * FROM users where id=?";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $result['user_id']);
            $statement->execute();
            $user = $statement->fetch();
            if ($user) {
                $author = $user['name'];
            } else $author = "Author Not Found";

            $post_userID = $result['user_id'];
            $title = $result['title'];
            $category = $result['category'];
            $date = date("F j, Y", strtotime($result['created_at']));
            $author_href = "users/show.php?id=" . $result['user_id'];
            $body = $result['body'];
        }

        $sql = "SELECT * FROM comments where post_id=?";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(1, $postID);
        $statement->execute();
        $comments = $statement->fetchAll();
    }
    closeConnection($pdo);
}
?>
<main>
    <section class="post">
        <div class="post-meta-info">

            <a id="edit" href="<?php echo $edit_href ?>" class="btn my-btn edit">Edit</a>
            <h1 class="post-title"><?php echo $title ?></h1>
            <p><a class="post-category" href="#"><?php echo $category ?></a></p>
            <p class="post-date">
                <time><?php echo $date ?></time>
            </p>
        </div>
        <div class="post-body">
            <p><a class="post-author" href="<?php echo $author_href ?>"><?php echo $author ?></a></p>
            <p>
                <?php echo $body ?>
            </p>
        </div>
    </section>
    <section class="comments">
        <div class="make-comment">
            <form method="post" action="http://randyconnolly.com/tests/process.php">
                <label for="new_comment">Make a Comment</label>
                <textarea id="new_comment" class="comment-text" name="comment"></textarea>
                <button class="comment-post btn" type="submit">post</button>
            </form>
        </div>
        <div id="comments">
            <?php if ($comments) {
                foreach ($comments as $comment) {
                    $sql = "SELECT name FROM users where id=?";
                    $statement = $pdo->prepare($sql);
                    $statement->bindValue(1, $comment['user_id']);
                    $statement->execute();
                    $user = $statement->fetch();
                    ?>
                    <article class='comment'>
                        <p class='comment-author'><a
                                    href="users/show.php?id=<?php echo $comment['user_id']; ?>"><?php if ($user) {
                                    echo $user[0];
                                } ?></a></p>
                        <p class='comment-date'>
                            <time><?php echo date("F j, Y", strtotime($comment['created_at'])); ?></time>
                        </p>
                        <p class='comment-body'><?php echo $comment['comment']; ?></p>
                    </article>
                <?php }
            } ?>
        </div>
    </section>
</main>
<script>

    var userID = '<?php echo $session_userID;?>';
    var post_userID = '<?php echo $post_userID?>';
    var postID = '<?php echo $postID ?>';

    // if user is not logged in, remove edit/like button
    if (userID === "-1") {
        $('#edit').remove();
        $('.make-comment').remove();
    }
    // if the logged in user is not the author of the post, change the edit button to "like"
    else if (userID !== post_userID) {
        $('#edit').removeAttr("href").html("Like").click(function () {

            $.ajax({
                type: "GET",
                data: {
                    userID: userID,
                    postID: postID,
                },
                url: "../server/likes.php",
                success: function (response) {
                    alert(response);
                }
            });
        });
    }
</script>
<?php include '../bottom.php'; ?>
