<?php
include '../top.php';
include '../../server/db_connect.php';

$query="";
parse_str($_SERVER['QUERY_STRING'], $params);
if ($params['query'] != null){
    $query = filter_var($params['query'], FILTER_SANITIZE_STRING);
}

if (isset($_GET['query'])) {
    $query = filter_var($_GET['query'], FILTER_SANITIZE_STRING);
}
$pdo = openConnection();

$searchFor = '%' . $query . '%';
$sql = "SELECT * FROM posts WHERE title LIKE ? OR category LIKE ?";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $searchFor);
$statement->bindValue(2, $searchFor);
$statement->execute();

$results = $statement->fetchAll();

closeConnection($pdo);

?>

<main>
    <form class="post" action="posts/search.php" method="GET">
        <label>Search:
            <input type="text" class="form-control" name="query" value="<?php echo $query; ?>"/>
        </label>
    </form>
    <section class="col-12" id="main-feed">
        <?php
        if ($results) {
            foreach ($results as $post) { ?>
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
</main>


