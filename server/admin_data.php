<?php
    include 'db_connect.php';
    $table = array();
    $table['cols'] = array(
    //Labels for the chart, these represent the column titles
    array('id' => '', 'label' => 'Date', 'type' => 'string'),
    array('id' => '', 'label' => 'Users', 'type' => 'number')
    );
    try{
        $conn = openConnection();
        $sql = "SELECT COUNT(*) AS total_users, YEAR(created_at) as yearly,  MONTH(created_at) AS monthly FROM users GROUP BY yearly, monthly ORDER BY yearly ASC, monthly ASC";
        $result = $conn->query($sql);
        $rows = array();
        foreach($result as $row){
            $dateObj   = DateTime::createFromFormat('!m', $row['monthly']);
            $monthName = $dateObj->format('F');
            $temp = array();
            $temp[] = array('v' => (string) ($row['yearly'].'-'.$monthName));
            $temp[] = array('v' => (float) $row['total_users']);
            $rows[] = array('c' => $temp);
        }
        closeConnection($conn);
    }
    catch(PDOException $err){
        die($err->getMessage());
    }
    $table['rows'] = $rows;

    $jsonTable = json_encode($table, true);
    echo $jsonTable;    

?>