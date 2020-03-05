<?php include '../top.php'; ?>
<main class="container">
	<div class="content">
		<section>
			<h1 id="username">Khoi Ngo</h1>
				<h3>Email</h3>
					<p>test123@gmail.com</p>
				<h3>User since:</h3>
					<p>Feb 9, 2020</p>
				<h3>Birthday:</h3>
					<p>Jan 1, 1997</p>
		</section>
		<section id="user-posts">
			
		</section>
	</div>
</main>
<script>
    var main = "<h2>User's Posts<h2>";
    for (var i=0; i<20; i++)
    {
        main += "<article class='entry'><a href='../posts/show.php'>";
        main += "<p class='main-title'><strong>Title " + i + "</strong></p>"
        main += "<p class='main-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>"
        main += "</a></article>";
    }
    document.getElementById("user-posts").innerHTML = main;
</script>
<?php include '../bottom.php'; ?>