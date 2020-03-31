<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mates & Posts</title>
    <base href="http://localhost/COSC360/client/" />
    <link rel="stylesheet" type="text/css" href="stylesheets/reset.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stylesheets/main.css"/>

    <script type="text/javascript" src="js/form_validation.js"></script>
    <script type="text/javascript" src="js/signin_validation.js"></script>
    <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="posts/index.php">Mates & Posts</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="posts/index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php
                    if(isset($_SESSION['id'])){
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="posts/create.php">Create Post</a>';
                        echo '</li>';
                    } 
                    
                    if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        echo 'Administration';
                        echo '</a>';
                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                        echo '<a class="dropdown-item" href="admin/stats.php">Analytics</a>';
                        echo '<a class="dropdown-item" href="admin/index.php">Users</a>';
                        echo '</div>';
                        echo '</li>';
                    }
             
                    if(isset($_SESSION['id'])){
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        echo  $_SESSION['user'];
                        echo '</a>';
                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                        echo '<a class="dropdown-item" href="users/myprofile.php">Profile</a>';
                        echo '<a class="dropdown-item" href="#">Settings</a>';
                        echo '</div>';
                        echo '</li>';
                        echo '<li>';
                        echo '<a class="dropdown-item" href="../server/logout.php"><img src="icons/log-out.svg"/></a>';
                        echo '</li>';
                    }
                    else{
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="auth/login.php"><img src="icons/log-in.svg"/></a>';
                        echo '</li>';
                    }
                ?>
            </ul>
        </div>
    </nav>
    <?php
    if(isset($_SESSION['message'])){
        echo '<p class="message entry">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }

    if(isset($_SESSION['warning'])){
        echo '<p class="warning entry">' . $_SESSION['warning'] . '</p>';
        unset($_SESSION['warning']);
    }
    ?>
</header>