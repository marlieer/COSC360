<?php include '../top.php'; ?>
<main>
    <form method="post" action="http://randyconnolly.com/tests/process.php" name="create-post" onsubmit="return validateCreatePost()">
        <fieldset>
            <legend>Edit Post</legend>
            <p>
                <label for="title">Title:</label>
                <input class="input form-control" type="text" name="title" id="title" value="My family has so many Cows!"/>
            </p>
            <p>
                <label for="category">Category:</label>
                <input class="input form-control" type="text" name="category" id="category" max="50" value="#cows #family"/>
            </p>
            <p>
                <label for="body">Body:</label>
                <textarea class="input form-control" name="body" col="5" rows="5" id="body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tincidunt, mi in malesuada venenatis, mi tortor aliquam justo, et consectetur libero felis eget elit. Sed id elit a est congue mattis
                </textarea>
                <small>Max characters: 250</small>
            </p>
            <div class="container">
                <button class="btn my-btn" type="submit">publish</button>
                <a href="index.php" class="btn my-btn cancel-btn">cancel</a>
                <a href="#" class="btn my-btn delete-btn" onclick="alert('Are you sure?')">delete</a>
            </div>
        </fieldset>
    </form>
</main>
<?php include '../bottom.php'; ?>