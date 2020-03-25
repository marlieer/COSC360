<?php
    session_start();

    unset($_SESSION["id"]);
    unset($_SESSION["user"]);
    unset($_SESSION["admin"]);
    unset($_SESSION["enabled"]);          
    
    session_destroy();

    echo "<script>window.location='../client/posts/index.php'</script>";
?>