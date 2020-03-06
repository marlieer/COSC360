<?php include '../top.php'; ?>
<main>
    <div class="container">
        <form method="post" action="../server/posts.php" name="create-post" onsubmit="return validateCreatePost()">
            <fieldset>
                <legend>Create Post</legend>
                <p>
                    <label for="title">Title:</label>
                    <input class="input form-control" type="text" name="title" id="title" />
                </p>
                <p>
                    <label for="category">Category:</label>
                    <input class="input form-control" type="text" name="category" id="category" max="50"/>
                </p>
                <p>
                    <label for="body">Body:</label>
                    <textarea class="input form-control" name="body" col="5" rows="5" id="body" ></textarea>
                    <small>Max characters: 250</small>
                </p>
                <div class="container">
                    <button class="btn my-btn create-post-btn" type="submit">publish</button>
                    <a href="posts/index.php" class="btn my-btn cancel-btn">cancel</a>
                </div>
            </fieldset>
        </form>
    </div>
</main>
<?php include '../bottom.php'; ?>
