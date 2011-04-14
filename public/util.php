<?php

  // Slurp query
  function slurq() {
    if (!$results = mysql_query(ob_get_clean())) {
      die("Trouble: ".mysql_error());
      return false;
    }

    // Load results
    while ($snippets[] = mysql_fetch_assoc($results));

    if ($snippets == Array(false)) {
      // Empty condition
      $snippets = Array();
    }

    // Return
    return $snippets;
  }

  function tables() {
    ?>

      CREATE TABLE IF NOT EXISTS <?php echo DB; ?>`text_snippets` (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        `title` text NOT NULL,
        `contents` text NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `id` (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1

    <?php
    if (!mysql_query(ob_get_clean())) {
      die("Could not create tables: ".mysql_error());
    }
  }

  // Load connection
  // Run correct file
  if (!isset($_REQUEST['conn'])) {
    require("config.php");
  } elseif ($_REQUEST['conn'] == "local") {
    // Choose a separate config
    require($_REQUEST['conn']."/config.php");
  }

  // Initialize tables
  tables();

