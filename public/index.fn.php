<?php

  // Build query
  ob_start(); ?>

    SELECT * FROM <?php echo DB; ?>text_snippets

  <?php

  // Run it
  require("index.tpl.php");
  tpl(slurq($conn));

