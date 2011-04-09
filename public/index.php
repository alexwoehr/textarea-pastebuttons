<?php

  $conn = mysql_connect("10.194.111.8", "user_e39e7998", ".3g3vCFVgf7Tmm", "db_e39e7998");
  ob_start(); ?>
    SELECT * FROM text_snippets;

  <?php
  $results = mysql_query(ob_get_clean(), $conn);

  while ($result = mysql_fetch($result)) var_dump($result);

?>
<html>
  <head>
  </head>
  <body>
    <big>WELCOME!</big>
  </body>
</html>
