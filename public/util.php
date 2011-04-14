<?php

  // Slurp query
  function slurq($conn) {
    $results = mysql_query(ob_get_clean(), $conn);

    // Load results
    while ($snippets[] = mysql_fetch($result));

    // Return
    return $snippets;
  }

  $conn = mysql_connect("10.194.111.8", "user_e39e7998", ".3g3vCFVgf7Tmm", "db_e39e7998");

  ob_start(); ?>
    SELECT * FROM text_snippets;

  <?php

  $snippets = slurq($conn);
  die(var_export($snippets, true));

