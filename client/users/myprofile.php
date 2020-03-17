<?php include '../top.php'; ?>
    <main class="container">
        <section>
            <h2>Khoi Ngo</h2>
            <a href="users/edit.php" class="center">Edit Profile</a>
            <img src="./profilePics/user1.png" alt="user1" class="profile-pic"/>
            <table class="table">
                <tr>
                    <th>Email:</th>
                    <td>test123@gmail.com</td>
                </tr>
                <tr>
                    <th>User since:</th>
                    <td>Feb 9, 2020</td>
                </tr>
                <tr>
                    <th>Birthday:</th>
                    <td>Jan 1, 1997</td>
                </tr>
            </table>
        </section>
        <section id="user-posts">

        </section>
    </main>
    <script>
        var main = "<h2>User's Posts<h2>";
        for (var i = 0; i < 10; i++) {
            main += "<article class='entry'><a href='posts/show.php'>";
            main += "<p class='main-title'><strong>Title " + i + "</strong></p>";
            main += "<p class='main-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut sollicitudin justo. Morbi semper ipsum semper nunc rutrum sodales. </p>";
            main += "</a></article>";
        }
        document.getElementById("user-posts").innerHTML = main;
    </script>
<?php include '../bottom.php'; ?>