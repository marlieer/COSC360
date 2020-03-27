<?php
include '../../server/db_connect.php';
include '../top.php';
include '../../db_connection.php';
// Get all posts from the database. Order by date. Limit 15
$pdo = openConnection();
$sql = "SELECT * FROM posts LIMIT 15;";
$results = $pdo->query($sql);

// Get recently viewed posts from database based on SESSION array of recently viewed
$recentlyViewed = false;
if (isset($_SESSION['recentlyViewed'])) {
    $sql = "SELECT * FROM posts WHERE id=:0";

    for($i=1; $i<sizeof($_SESSION['recentlyViewed']); $i++){
        $sql = $sql . " OR id=:" . $i;
    }

    $statement = $pdo->prepare($sql);

    for($i=0; $i<sizeof($_SESSION['recentlyViewed']); $i++){
        $statement->bindValue(':' . $i, $_SESSION['recentlyViewed'][$i]);
    }

    $statement->execute();
    $recentlyViewed = $statement->fetchAll();
}

// Get top 5 viewed posts from database
$sql = "SELECT * FROM posts ORDER BY views DESC LIMIT 5;";
$trending = $pdo->query($sql);

?>
    <main class="container">
        <form class="post" action="posts/search.php" method="GET">
            <label>Search:
                <input type="text" class="form-control" name="query"/>
            </label>
        </form>
        <div class="row">
            <section class="col-8" id="main-feed">
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
            <aside class="col-4">
                <section id="trending">
                    <h2>Trending Now</h2>
                    <?php
                    if ($trending) {
                        while ($post = $trending->fetch()) { ?>
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
                <section id="recent">
                    <h2>Recently Viewed</h2>
                    <?php
                    if ($recentlyViewed) {
                    foreach($recentlyViewed as $post) { ?>
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
            </aside>
        </div>
    </main>
<script>
    var recentlyViewed = <?php echo $recentlyViewed;?>;
    $('#recent').html("hola");
</script>
<?php include '../bottom.php'; ?>