<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Riley Radici">
    <meta name="keywords" content="accessibility, color, html, php, javascript">
    <meta name="description" content="A dynamic website for CS312's project.">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href=<?php echo $style; ?>>
</head>
<body>
    <header>
        <div class="company_header">
            <div class="company_header_element"><p>CHROMA </p></div>
            <div class="company_header_element"><img src="images/DALLE_companylogo.png" alt="A company logo designed by DALL-E."></div>
        </div>
        <hr>
        <div class="title_nav">
            <div class="title_nav_element"><h1><?php echo $pageTitle ?></h1></div>
