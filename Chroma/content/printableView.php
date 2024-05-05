<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printable View</title>
    <style>
        .company_header {
            text-align: center;
            margin: 0px;
        }

        .company_header_element {
            display: inline-block;
            padding: 1rem 1rem;
            vertical-align: middle;
        }

        .company_header_element p {
            font-style: italic;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 25px;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .company_header_element img {
            width: 25px;
            height: 25px;
            border-radius: 6px;
            filter: grayscale(100%);
        }

        .table_1, .table_2 {
            width: 95%;
        }

        .table_1 td, .table_2 td {
            text-align: center;
        }

        .table_1 input[type="radio"] {
            display: none;
        }
    </style>
</head>
<body>
    <div class="company_header">
        <div class="company_header_element"><p>CHROMA </p></div>
        <div class="company_header_element"><img src="../images/DALLE_companylogo.png" alt="A company logo designed by DALL-E."></div>
    </div>
    <?php
        $rc = isset($_GET['rc']) ? $_GET['rc'] : null;
        $colors = isset($_GET['colors']) ? $_GET['colors'] : null;
        $selectedColors = isset($_GET['selectedColors']) ? json_decode($_GET['selectedColors'], true) : [];

        echo "<table class='table_1' border='1'>";
        $i = 0;
        foreach ($selectedColors as $option) {
            echo "<tr>";
            $i_1 = $i + 1;
            echo "<td width='20%'>Color $i_1</td>";
            echo "<td width='40%'>{$option}</td>";
            echo "<td width='40%'>Hex Code Here</td>"; 
            echo "</tr>";
            $i++;
        }
        echo "</table>";
        echo "<table class='table_2' border='1'>";
        echo "<tr><td></td>";
        for ($i = 0; $i < $rc; $i++) {
            echo "<td>" . chr(65 + $i) . "</td>";
        }
        echo "</tr>";
        for ($i = 0; $i < $rc; $i++) {
            echo "<tr>";
            echo "<td>" . ($i + 1) . "</td>";
            for ($j = 0; $j < $rc; $j++) {
                echo "<td></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    ?>
</body>
</html>