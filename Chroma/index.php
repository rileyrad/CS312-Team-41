<?php
    $page = $_GET['page'] ?? 'home.html';
    $pageTitle = ucwords(implode(' ', explode('.html', $page)));
    $pageTitle = ucwords(implode(' ', explode('.php', $pageTitle)));
    $style = "css/styles.css";


    include 'content/header.php';
    include 'content/navbar.php';
    include "content/{$page}";
    include 'content/footer.html';
?>