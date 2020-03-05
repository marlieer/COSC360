<?php include '../top.php'; ?>
<main>
    <section class="post">
        <div class="post-meta-info">
            <a href="edit.php" class="btn my-btn edit">Edit</a>
            <h1 class="post-title">Ipsem Title</h1>
            <p><a class="post-category" href="#">#Rubish</a></p>
            <p class="post-date">
                <time>February 14, 2020</time>
            </p>
        </div>
        <div class="post-body">
            <p><a class="post-author" href="../users/show.php">Dr. Shehata</a></p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tincidunt,
                mi in malesuada venenatis, mi tortor aliquam justo, et consectetur libero
                felis eget elit. Sed id elit a est congue mattis
            </p>
        </div>
    </section>
    <section class="comments">
        <div class="make-comment">
            <form method="post" action="#">
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
        comment += "<p class='comment-author'><a href='../users/show.php'>Dr. Abdallah</a></p>";
        comment += "<p class='comment-date'><time>February 15, 2020</time></p>";
        comment += "<p class='comment-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>";
        comment += "</article>";
    }
    document.getElementById("comments").innerHTML = comment;
</script>
<?php include '../bottom.php'; ?>