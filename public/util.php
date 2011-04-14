<?php

  // Slurp query
  function slurq($conn) {
    if (!$results = mysql_query(ob_get_clean())) {
      die("Trouble: ".mysql_error());
      return false;
    }

    // Load results
    $snippets[] = mysql_fetch_assoc($results);

    // Return
    return $snippets;
  }

  // Initalize the connection
  mysql_connect("10.194.111.8", "user_e39e7998", ".3g3vCFVgf7Tmm", "db_e39e7998");

