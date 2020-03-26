<?php
if(!isset($_SESSION['id']) ){
    echo "<script>alert('Unauthorized access. Redirecting to home page.')</script>";
    echo "<script>window.location='../client/auth/signup.php'</script>";
}
?>