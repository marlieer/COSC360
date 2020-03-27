<?php include '../top.php'; ?>
<?php include 'admin_check.php'; ?>
<?php include '../../server/admin.php'; ?>
<main class="container">
    <div class="row">
        <div class="stat">
            <h3>Top 5 Searched Topics</h3>
            <ol>
            <?php $data = get_top_5();
            foreach($data as $key=>$val){
                echo "<li>$val[0] - $val[1] views</li>";
            }
            ?>
            </ol>
        </div>
        <div class="stat">
            <h3>Number of Registered Users</h3>
            <p><?php echo get_reg_users(); ?></p>
        </div>
        <div class="stat">
            <h3>Number of Enabled/Disabled Users</h3>
            <div id="pie_chart"></div>
        </div>
        <div class="stat">
            <h3>Number of Active Users</h3>
            <p><?php echo get_active_users(); ?></p>
        </div>
    </div>
    <div class="stat-graph">
        <h3>Number of New Users per Month</h3>
        <div id="bar_chart"></div>
    </div>
</main>
<?php include '../bottom.php' ?>