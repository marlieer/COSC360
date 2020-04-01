<?php include '../top.php'; ?>
<?php include 'admin_check.php'; ?>
<?php include '../../server/admin.php'; ?>
<style>
h3{
    text-align:center;
    margin-top:2em;
    margin-bottom:2em;
}
table {
	margin-left: auto;
	margin-right: auto;
	width: 90%;
}
th,td{
    padding: 1em 1em 1em 1em;
    border: 1px solid #8fbfc4;
}
</style>
<main class="container">
    <h3>Mate and Posts Website Analytics</h3>
    <table id="stat">
        <tr>
            <th class="th-1">Number of Registered Users</th>
            <td><?php echo get_reg_users(); ?></td>
            <th>Number of New Users per Month</th>
        </tr>
        <tr>
            <th class="th-1">Number of Active Users</th>
            <td><?php echo get_active_users(); ?></td> 
            <td rowspan="3"><div id="bar_chart"></div></td>
        </tr>
        <tr>
            <th class="th-1">Top 5 Categories</th>
            <td>
                <ol>
                <?php $data = get_top_5();
                foreach($data as $key=>$val){
                    echo "<li>$val[0] - $val[1] views</li>";
                }
                ?>
                </ol>
            </td>
        </tr>
        <tr>
            <th class="th-1">Number of Enabled/Disabled Users</th>
            <td><div id="pie_chart"></div></td>
    </table>
</main>
<?php include '../bottom.php' ?>