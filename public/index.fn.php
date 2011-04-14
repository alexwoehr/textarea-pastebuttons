<?php

  // Build query
  ob_start(); ?>

    SELECT * FROM text_snippets;

  <?php

  // Run it
  die(var_export(slurq($conn), true));
  require("index.tpl.php");
  tpl(slurq($conn));

