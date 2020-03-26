<?php
include '../../server/db_connect.php';
include '../top.php';
// TODO: Get all posts from the database. Order by date. Limit 15
$pdo = openConnection();
$sql = "SELECT * FROM posts LIMIT 15;";
$results = $pdo->query($sql);

// TODO: Get recently viewed posts from database based on SESSION array of recently viewed
if (isset($_SESSION['recentlyViewed'])) {

}
// TODO: Get top 5 viewed posts from database
?>
    <main class="container">
        <div class="row">
            <section class="col-8">
                <section id="main-feed">
                    <?php
                    if ($results) {
                        while ($post = $results->fetch()) { ?>
                            <article class='entry'><a href='posts/show.php?id=<?php echo $post['id'] ?>'>
                                    <p class='main-title'><strong><?php echo $post['title']; ?></strong></p>
                                    <p class='post-category'><?php echo $post['category']; ?></p>
                                    <p class='post-date'>
                                        <time datetime=<?php echo $post['created_at']; ?>><?php echo $post['created_at']; ?></time>
                                    </p>
                                    <br/>
                                    <p class='main-body'><?php echo $post['body']; ?></p>
                                </a></article>
                        <?php }
                    } ?>

                </section>
            </section>
            <aside class="col-4">
                <section id="trending">

                </section>
                <section id="recent">

                </section>
            </aside>
        </div>
    </main>
    <script>

        var trending = '<h2>Trending Posts</h2>';
        for (var j = 0; j < 5; j++) {
            trending += "<article class='entry'><a href='posts/show.php'>";
            trending += "<p class='main-title'><strong>Title " + j + "</strong></p>"
            trending += "<p class='main-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>"
            trending += "</a></article>";
        }
        document.getElementById("trending").innerHTML = trending;

        var recent = '<h2>Recently viewed</h2>';
        for (var j = 0; j < 3; j++) {
            recent += "<article class='entry'><a href='posts/show.php'>";
            recent += "<p class='main-title'><strong>Title " + j + "</strong></p>"
            recent += "<p class='main-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>"
            recent += "</a></article>";
        }
        document.getElementById("recent").innerHTML = recent;
    </script>
<?php include '../bottom.php'; ?>