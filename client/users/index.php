<?php include '../top.php'; ?>
<main class="container">
	<div class="content">
		<section id="users">

		</section>
	</div>
</main>
<script>
    var main = "<h2>Registered Users<h2>";
    for (var i=0; i<20; i++)
    {
        main += "<article class='entry'><a href='show.php'>";
        main += "<p class='main-title'><strong>User " + i + "</strong></p>"
        main += "<p class='main-body'>user" + i + "@gmail.om</p>";
        main += "</a></article>";
    }
    document.getElementById("users").innerHTML = main;
</script>
<?php include '../bottom.php'; ?>