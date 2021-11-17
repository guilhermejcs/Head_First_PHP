<?php 
    // Define constantes de coneção do banco de dados
    define('DB_HOST', 'localhost');
    define('DB_USER', ${{ secrets.USUARIO }});
    define('DB_PASSWORD', ${{ secrets.SENHA }});
    define('DB_NAME', ${{ secrets.BANCO }});
?>
