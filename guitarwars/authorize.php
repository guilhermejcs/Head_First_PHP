<?php
// nome do usuário e senha para autenticação
$username = 'rock';
$password = 'roll1';

if (
    !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)
) {
    // Nome do usuário/senha incorretos, então enviar os cabeçalhos de autenticação
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Guitar Wars"');
    exit('<h2>Guitar Wars</h2>Sorry, you must enter a valid username and password to access this page.');
}
