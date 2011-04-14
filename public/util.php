<?php

  // Slurp query
  function slurq($conn) {
    $results = mysql_query(ob_get_clean());

    // Load results
    $snippets[] = mysql_fetch_assoc($results);

    // Return
    return $snippets;
  }

  $conn = mysql_connect("10.194.111.8", "user_e39e7998", ".3g3vCFVgf7Tmm", "db_e39e7998");

