<?php
require_once('authorize.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Guitar Wars - High Scores Administration</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <h2>Guitar Wars - High Scores Administration</h2>
    <p>Below is a list of all Guitar Wars high scores. Use this page to remove scores as needed.</p>
    <hr />
    <?php
    require_once('appvars.php');
    require_once('connectvars.php');

    // Conecta-se com o banco de dados
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Obtém os dados das pontuações a partir do MySQL
    $query = "SELECT * FROM guitarwars ORDER BY score DESC, date ASC";

    $data = mysqli_query($dbc, $query);

    // Faz um loop através do array contendo os dados das pontuações, formatando-os como HTML 
    echo '<table>';
    while ($row = mysqli_fetch_array($data)) {
        // Exibe dados das pontuações
        echo '<tr class="scorerow">';
        echo '<td><strong>' . $row['name'] . '</strong></td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['score'] . '</td>';
        echo '<td><a href="removescore.php?id=' . $row['id'] .
            '&amp;date=' . $row['date'] .
            '&amp;name=' . $row['name'] .
            '&amp;score=' . $row['score'] .
            '&amp;screenshot=' .
            $row['screenshot'] .
            '">Remove</a>';
        if($row['approved']==0){
            echo ' / <a href="approvescore.php?id=' . $row['id'] .
            '&amp;date=' . $row['date'] .
            '&amp;name=' . $row['name'] .
            '&amp;score=' . $row['score'] .
            '&amp;screenshot=' . $row['screenshot'] .
            '">Approve</a>';
        }
        echo '</td></tr>';
    }
    echo '</table>';

    mysqli_close($dbc);

    ?>

</body>

</html>