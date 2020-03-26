<?php include '../top.php'; ?>
<?php include 'user_check.php'; ?>
<?php include '../../server/users.php'; ?>
<?php $data = show_users($_GET["id"]); ?>
    <main class="container">
        <section>
            <h2><?php echo $data[1]; ?></h2>
            <?php
                if($data[6] == 1){
                    echo "<a href='/COSC360/server/admin.php?enabled=0&id=$data[0]'>Disable User</a>";
                }
                else{
                    echo "<a href='/COSC360/server/admin.php?enabled=1&id=$data[0]'>Enable User</a>";
                }
            ?>
            <a href="/COSC360/server/admin.php?delete=1&id=<?php echo $data[0]; ?>">Delete Profile</a>
            <img src="<?php echo $data[4]; ?>" alt="<?php echo $data[1]; ?>" class="profile-pic"/>
            <table class="table">
                <tr>
                    <th>Email:</th>
                    <td><?php echo $data[3]; ?></td>
                </tr>
                <tr>
                    <th>User since:</th>
                    <td><?php echo $data[5]; ?></td>
                </tr>
                <tr>
                    <th>Birthday:</th>
                    <td><?php echo $data[2]; ?></td>
                </tr>
            </table>
        </section>
        <section id="user-posts">
            <?php show_posts($data[0]); ?>
        </section>
    </main>
<?php include '../bottom.php'; ?>