<?php 
    // Inicia sessão
    require_once('./common/estructure/startsession.php');

    // Insere cabeçalho na página
    $page_title = 'Questionnaire';
    require_once('./common/estructure/header.php');

    // Variáveis
    require_once('./common/variables/appvars.php');
    require_once('./common/variables/connectvars.php');

    // Assegura que o usuário está logado antes de seguir adiante
    require_once('./common/estructure/userverify.php');

    // Mostra o menu de navegação
    require_once('./common/estructure/navmenu.php');

    // Conecta no banco de dados
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Se este usuário jamais respondeu ao questinário, inserir respostas vazias no banco
    $query = "SELECT * FROM mismatch_response WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);

    if (mysqli_num_rows($data) == 0) {
        // Primeiramente, obtém a lista de IDs dos tópicos a partir da respectiva tabela
        $query = "SELECT topic_id FROM mismatch_topic ORDER BY category_id, topic_id";
        $data = mysqli_query($dbc, $query);

        $topicsIDs = array();
        while ($row = mysqli_fetch_array($data)) {
            array_push($topicsIDs, $row['topic_id']);
        }
        
        // Insere linhas de respostas na tabela respectiva, uma para cada tópico
        foreach ($topicsIDs as $topic_id) {
            $query = "INSERT INTO mismatch_response (user_id, topic_id) VALUES ('" . $_SESSION['user_id']. "', '$topic_id')";
            mysqli_query($dbc, $query);
        }
    }

    // Se o questionário tiver sido submetido, escreve as respostas do formulário no banco
    if (isset($_POST['submit'])) {
        // Escreve as linhas de respostas do questionário na tabela de respostas
        foreach ($_POST as $response_id => $response) {
            $query = "UPDATE mismatch_response SET response = '$response' WHERE response_id = '$response_id'";
            mysqli_query($dbc, $query);
        }
        echo '<p>Your responses have been saved.</p>';
    }

    // Obtém os dados de resposta do banco, para gerar o formulário
    $query = "SELECT mr.response_id, mr.topic_id, mr.response, 
        mt.name AS topic_name, mc.name AS category_name
        FROM mismatch_response AS mr 
        INNER JOIN mismatch_topic AS mt USING (topic_id)
        INNER JOIN mismatch_category AS mc USING (category_id)
        WHERE mr.user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $responses = array();
    while ($row = mysqli_fetch_array($data)) {
        array_push($responses, $row);
    }

    // Gera o formulário do questionário, fazendo looop através do array de respostas
    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<p>How do you feel about each topic?</p>';
    $category = $responses[0]['category_name'];
    echo '<fieldset><legend>' . $responses[0]['category_name'] . '</legend>';
    foreach ($responses as $response) {
        // Só inicia um novo conjunto de campos se a categoria tiver se modificado
        if ($category != $response['category_name']) {
            $category = $response['category_name'];
            echo '</fieldset><fieldset><legend>' . $response['category_name'] . '</legend>';
        }

        // Exibe o corpo do tópico do formulário
        echo '<label ' . ($response['response'] == NULL ? 'class="error"' : '') . ' for="' . $response['response_id'] . '">' . $response['topic_name'] . ':</label>';
        echo '<input type="radio" id="' . $response['response_id'] . '" name="' . $response['response_id'] . '" value="1" ' . ($response['response'] == 1 ? 'checked="checked"' : '') . ' />Love ';
        echo '<input type="radio" id="' . $response['response_id'] . '" name="' . $response['response_id'] . '" value="2" ' . ($response['response'] == 2 ? 'checked="checked"' : '') . ' />Hate<br />';
      }
      echo '</fieldset>';
      echo '<input type="submit" value="Save Questionnaire" name="submit" />';
      echo '</form>';

    // Insere a página
    require_once('./common/estructure/footer.php');
?>