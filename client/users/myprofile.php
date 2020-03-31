<?php include '../top.php'; ?>
<?php include 'user_check.php'; ?>
<?php include '../../server/users.php'; ?>
<?php $data = show_users($_SESSION["id"]); ?>
    <main class="container">
        <section>
            <h2><?php echo $data[1]; ?></h2>
            <a href="users/edit.php" style="display: block; text-align: center;"><img src="icons/edit.svg"/></a>
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