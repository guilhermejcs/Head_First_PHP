<?php
$dbc = mysqli_connect('localhost', ${{ secrets.USUARIO }}, ${{ secrets.SENHA }}, ${{ secrets.BANCO }}) or die('Erro ao se conectar com o servidor MySQL server.');

$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$email = $_POST['email'];

$query = "INSERT INTO email_list(first_name, last_name, email)
 VALUES ('$first_name', '$last_name', '$email')";

mysqli_query($dbc, $query)
 or die('Erro ao acessar o banco de dados');
 echo 'cliente adicionado.';
 mysqli_close($dbc);
?>
