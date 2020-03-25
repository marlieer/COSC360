<?php
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    echo "<script>alert('Unauthorzied access. Redirecting to home page.')</script>";
    echo "<script>window.location='../client/posts/index.php'</script>";
}
?>