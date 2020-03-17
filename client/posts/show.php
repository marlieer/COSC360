<?php
include '../top.php';

$valid = true;

// validate that logged in userID is an integer
$session_userID=(isset($_SESSION['userID'])) ? $_SESSION['userID'] : null;
if (!filter_var($session_userID, FILTER_VALIDATE_INT)) {
    echo "<p>UserID must be an integer. </p>";
}

// validate that postID is an integer
$postID = (isset($_GET['postID'])) ? $_GET['postID'] : null;
if (!filter_var($postID, FILTER_VALIDATE_INT)) {
    echo "<p>PostID must be an integer. </p>";
    $valid = false;
}

if ($valid) {
    
    // Add this post to session array of recently viewed posts.
    // Remove first post if array size is 5 or more
    // only add if postID is not already in array
    $recentlyViewed = (isset($_SESSION['recentlyViewed'])) ? $_SESSION['recentlyViewed'] : array();
    if (sizeof($recentlyViewed) >= 5) {
        array_shift($recentlyViewed);
    }
    if (!in_array($postID, $recentlyViewed)) {
        array_push($recentlyViewed, $postID);
    }

    // TODO: Get post by ID from database along with associated comments

    // assign post attributes
    $edit_href = "posts/edit.php?id=$postID";
    $post_userID = 1;
    $title = "Ipsem Title";
    $category = "#Rubish";
    $date = "February 14, 2020";
    $author = "Dr. Shehata";
    $author_href = "users/show.php?id=$post_userID";
    $body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tincidunt,
                    mi in malesuada venenatis, mi tortor aliquam justo, et consectetur libero
                    felis eget elit. Sed id elit a est congue mattis";
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

        </div>
    </section>
</main>
<script>
    var comment = '';
    for (var j = 0; j < 4; j++) {
        comment += "<article class='comment'>";
        comment += "<p class='comment-author'><a href='users/show.php'>Dr. Abdallah</a></p>";
        comment += "<p class='comment-date'><time>February 15, 2020</time></p>";
        comment += "<p class='comment-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>";
        comment += "</article>";
    }
    document.getElementById("comments").innerHTML = comment;

    var userID = '<?php echo $session_userID;?>';
    var post_userID = '<?php echo $post_userID?>';
    var postID = '<?php echo $postID ?>';

    // if the logged in user is not the author of the post, change the edit button to "like"
    if (userID !== post_userID && userID != null) {
        $('#edit').removeAttr("href").html("Like").click(function() {

            $.ajax({
                type: "GET",
                data: {
                    userID: userID,
                    postID: postID,
                },
                url: "../server/likes.php",
                success: function(response) {
                    alert(response);
                }
            });
        });
    }
</script>
<?php include '../bottom.php'; ?>
