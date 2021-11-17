<?php
require_once('authorize.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Guitar Wars - Remove a High Score</title>
</head>

<body>
    <h2>Guitar Wars - Remove a High Score</h2>
    <?php
    require_once('appvars.php');
    require_once('connectvars.php');

    if (
        isset($_GET['id']) &&
        isset($_GET['date']) &&
        isset($_GET['name']) &&
        isset($_GET['score']) &&
        isset($_GET['screenshot'])
    ) {
        // Pega dados em GET
        $id = $_GET['id'];
        $date = $_GET['date'];
        $name = $_GET['name'];
        $score = $_GET['score'];
        $screenshot = $_GET['screenshot'];
    } else if (
        isset($_POST['id']) &&
        isset($_POST['name']) &&
        isset($_POST['score'])
    ) {
        // Pega dados em POST
        $id = $_POST['id'];
        $name = $_POST['name'];
        $score = $_POST['score'];
        $screenshot = $_POST['screenshot'];
    } else {
        echo '<p class="error">Sorry, no high score was specified for removal.</p>';
    }

    if (isset($_POST['submit'])) {
        if ($_POST['confirm'] == 'Yes') {
            // Exclui o arquivo gráfico do servidor
            @unlink(GW_UPLOADPATH . $screenshot);

            // Conecte ao banco de dados
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            // Exclui dados da pontuação do banco
            $query = "DELETE FROM guitarwars WHERE id = $id LIMIT 1";
            mysqli_query($dbc, $query);
            mysqli_close($dbc);

            // Confirmar êxito com o usuário
            echo '<p>The high score of ' . $score . ' for ' . $name . ' was successfully removed. </p>';
        } else {
            echo '<p class="error">The high score was not removed.</p>';
        }
    } else if (isset($id) && isset($name) && isset($date) && isset($score) && isset($screenshot)) {
        echo '<p>Are you sure you want to delete the following high score?</p>';
        echo
        '<p><strong>Name: </strong>' . $name . '<br>' .
            '<strong>Date: </strong>' . $date . '<br>' .
            '<strong>Score: </strong>' . $score . '</p>';
        echo '<form method="post" action="removescore.php">';
        echo '<input type="radio" name="confirm" value="Yes">Yes';
        echo '<input type="radio" name="confirm" value="No" checked="checked">No<br>';
        echo '<input type="submit" value="Submit" name="submit">';
        echo '<input type="hidden" name="id" value="' . $id . '">';
        echo '<input type="hidden" name="name" value="' . $name . '">';
        echo '<input type="hidden" name="score" value="' . $score . '">';
        echo '<input type="hidden" name="screenshot" value="' . $screenshot . '">';
        echo '</form>';
    }

    echo '<p><a href="admin.php">&lt;&lt; Back to admin page</a></p>';

    ?>
</body>

</html>