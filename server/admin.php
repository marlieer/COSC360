<?php
// for database connection later
include "db_connect.php";

// -------------------------------------------------------------------------------
// for SHOWING ALL REGISTERED USERS page
// -------------------------------------------------------------------------------

if(isset($_POST['search_button'])){
    if(empty($_POST['search_type']) || empty($_POST['search_text']) || $_POST['search_type'] == ''){
        echo "<script>window.location='../client/admin/index.php'</script>";
    }
    else{
        echo "<script>window.location='../client/admin/index.php?type=".$_POST['search_type']."&search=".$_POST['search_text']."'</script>";
    }
}

function show_all_users(){
    $data = [];
    try{
        $conn = openConnection();
        $sql = "SELECT id, name, email, enabled FROM users";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data[$row['id']] = array($row['name'], $row['email'], $row['enabled']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }

    foreach($data as $key=>$val){
        echo "<tr>";
        echo "<td>";
        if($val[2]==0){
            echo "<a href='../server/admin.php?enabled=1&id=$key'><img src='icons/user-plus.svg'/></a>";
        }
        else{
            echo "<a href='../server/admin.php?enabled=0&id=$key'><img src='icons/user-minus.svg'/></a>";
        }
        echo "</td>";
        echo "<td>";
        echo "<a href='../server/admin.php?delete=1&id=$key'><img src='icons/user-x.svg'/></a>";
        echo "</td>";
        echo "<td>";
        echo "<article class='entry'><a href='users/show.php?id=$key'>";
        echo "<p class='main-title'><strong>$val[0]</strong></p>";
        echo "<p class='main-body'>$val[1]</p>";
        echo "</a></article>";
        echo "</td>";
        echo "</tr>";
    }
}

function show_users_by($type, $search){
    $data = [];
    try{
        $conn = openConnection();
        $sql='';
        if(strcmp($type, 'email') == 0 || strcmp($type, 'name') == 0){
            $sql = "SELECT users.id, name, email, enabled FROM users WHERE ".$type." LIKE '%".$search."%'";
        }
        elseif(strcmp($type, 'post') == 0){
            $sql = "SELECT users.id, name, email, enabled FROM users JOIN posts on users.id=posts.user_id WHERE title LIKE '%".$search."%'";
        }
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data[$row['id']] = array($row['name'], $row['email'], $row['enabled']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }
    foreach($data as $key=>$val){
        echo "<tr>";
        echo "<td>";
        if($val[2]==0){
            echo "<a href='../server/admin.php?enabled=1&id=$key'><img src='icons/user-plus.svg'/></a>";
        }
        else{
            echo "<a href='../server/admin.php?enabled=0&id=$key'><img src='icons/user-minus.svg'/></a>";
        }
        echo "</td>";
        echo "<td>";
        echo "<a href='../server/admin.php?delete=1&id=$key'><img src='icons/user-x.svg'/></a>";
        echo "</td>";
        echo "<td>";
        echo "<article class='entry'><a href='users/show.php?id=$key'>";
        echo "<p class='main-title'><strong>$val[0]</strong></p>";
        echo "<p class='main-body'>$val[1]</p>";
        echo "</a></article>";
        echo "</td>";
        echo "</tr>";
    }
}

// -------------------------------------------------------------------------------
// for DISABLING/ENABLING and DELETING USERS as admin
// -------------------------------------------------------------------------------
if(isset($_GET['id']) && isset($_GET['enabled'])){
    $en = $_GET['enabled'];
    $id = $_GET['id'];

    if($en == 0 || $en == 1){
        try{
            $conn = openConnection();
            $sql = "UPDATE users SET enabled=? WHERE id=?";
            $statement = $conn->prepare($sql);
            $statement->bindValue(1, $en);
            $statement->bindValue(2, $id);
            $statement->execute();
            closeConnection($conn);
        }
        catch(PDOException $err){
            die($err->getMessage());
        }
    }
    if($en == 0){
        echo "<script>alert('User $id has be deactivated.')</script>";
    }
    elseif($en == 1){
        echo "<script>alert('User $id has be activated.')</script>";
    }
    // redirect to profile page after
    echo "<script>window.location='../client/admin/index.php'</script>";
}

if(isset($_GET['id']) && isset($_GET['delete'])){
    $del = $_GET['delete'];
    $id = $_GET['id'];

    if($del == 1){
        try{
            $conn = openConnection();
            $sql = "DELETE FROM users WHERE id=?";
            $statement = $conn->prepare($sql);
            $statement->bindValue(1, $id);
            $statement->execute();
            closeConnection($conn);
        }
        catch(PDOException $err){
            die($err->getMessage());
        }

        echo "<script>alert('User $id has be deleted.')</script>";
        // redirect to profile page after
        echo "<script>window.location='../client/admin/index.php'</script>";
    }
}

// -------------------------------------------------------------------------------
// for ADMIN ANALYTICS
// -------------------------------------------------------------------------------
function get_top_5(){
    $data = [];
    try{
        $conn = openConnection();
        $sql = "SELECT category, SUM(views) AS total_views FROM posts GROUP BY category ORDER BY SUM(views) DESC LIMIT 5";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data[] = array($row['category'], $row['total_views']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }

    return $data;
}

function get_reg_users(){
    $data = '';
    try{
        $conn = openConnection();
        $sql = "SELECT COUNT(*) AS total_users FROM users";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data = $row['total_users'];
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }
    
    return $data;
}

function get_active_users(){
    $data = '';
    $time = strtotime("-3 year", time());
    $date = date("Y-m-d", $time);
    try{
        $conn = openConnection();
        $sql = "SELECT COUNT(*) AS total_users FROM users WHERE last_login>$date";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data = $row['total_users'];
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }
    
    return $data;
}

function get_en_users(){
    $data = [];
    try{
        $conn = openConnection();
        $sql = "SELECT COUNT(*) AS total_users, enabled FROM users GROUP BY enabled ORDER BY enabled DESC";
        $result = $conn->query($sql);
        while($row = $result->fetch()){
            $data[] = array($row['total_users'], $row['enabled']);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }

    return $data;
    }

?>

 <!--
 -------------------------------------------------------------------------------
 for ADMIN ANALYTICS
 -------------------------------------------------------------------------------
 -->
<head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        //--------------------------------------------------------------------------------------
        // FOR PIE CHART OF ENABLED/DISABLED USERS
        //--------------------------------------------------------------------------------------
        // Create the data table
        var data1 = new google.visualization.DataTable();
        data1.addColumn('string', 'Status');
        data1.addColumn('number', 'Users');
        <?php $data1 = get_en_users(); ?>
        data1.addRows([
          ['Enabled', <?php echo $data1[0][0] ?>],
          ['Disabled', <?php echo $data1[1][0] ?>]
        ]);
        // Set chart options
        var options1 = {'width':400, 'height':300};
        // Instantiate and draw our chart, passing in some options.
        var chart1 = new google.visualization.PieChart(document.getElementById('pie_chart'));
        chart1.draw(data1, options1);
        
        //--------------------------------------------------------------------------------------
        // FOR PIE CHART OF ENABLED/DISABLED USERS
        //--------------------------------------------------------------------------------------
        // Create the data table
        var jsonData = $.ajax({
        url: "../server/admin_data.php",
        dataType:"json",
        async: false
        }).responseText;
        var data2 = new google.visualization.DataTable(jsonData);
        // Set chart options
        var options2 = {'width':500, 'height':500};
        // Draw chart
        var chart2 = new google.visualization.ColumnChart(document.getElementById('bar_chart'));
        chart2.draw(data2, options2);
      }
    </script>


  </head>
