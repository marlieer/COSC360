<?php
include '../top.php';
// TODO: Get all posts from the database. Order by date. Limit 15
// TODO: Get recently viewed posts from database based on SESSION array of recently viewed
if (isset($_SESSION['recentlyViewed']))
// TODO: Get top 5 viewed posts from database
?>
<main class="container">
    <div class="row">
        <section class="col-8">
            <section id="main-feed">

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
    var main = '';
    for (var i=0; i<20; i++)
    {
        // TODO: add post ID to href for show
        main += "<article class='entry'><a href='posts/show.php'>";
        main += "<p class='main-title'><strong>Title " + i + "</strong></p>";
        main += "<p class='post-category'>#category</p>";
        main += "<p class='post-date'><time datetime='2020-02-14'>February 14, 2020</time></p>";
        main += "<br/><p class='main-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>"
        main += "</a></article>";
    }
    document.getElementById("main-feed").innerHTML = main;


    var trending = '<h2>Trending Posts</h2>';
    for(var j=0; j< 5; j++)
    {
        trending += "<article class='entry'><a href='posts/show.php'>";
        trending += "<p class='main-title'><strong>Title " + j + "</strong></p>"
        trending += "<p class='main-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>"
        trending += "</a></article>";
    }
    document.getElementById("trending").innerHTML = trending;

    var recent = '<h2>Recently viewed</h2>';
    for(var j=0; j< 3; j++)
    {
        recent += "<article class='entry'><a href='posts/show.php'>";
        recent += "<p class='main-title'><strong>Title " + j + "</strong></p>"
        recent += "<p class='main-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>"
        recent += "</a></article>";
    }
    document.getElementById("recent").innerHTML = recent;
</script>
<?php include '../bottom.php'; ?>