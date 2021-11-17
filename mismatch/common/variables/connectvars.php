<?php
  // Define database connection constants
  define('DB_HOST', 'localhost');
  define('DB_USER', ${{ secrets.USUARIO }});
  define('DB_PASSWORD', ${{ secrets.SENHA }});
  define('DB_NAME', ${{ secrets.BANCO }});
?>
