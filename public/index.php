<?php

  $conn = mysql_connect();
  ob_start(); ?>
    SELECT * FROM text_snippets;

  <?php
  $results = mysql_query(ob_get_contents(), $conn);

  while ($result = mysql_fetch($result)) var_dump($result);

?>
<html>
  <head>
  </head>
  <body>
    <big>WELCOME!</big>
  </body>
</html>
