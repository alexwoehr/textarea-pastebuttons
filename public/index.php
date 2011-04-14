<?php

  require_once("util.php");

  // Check inputs
  if (!isset($_GET['fn'])) {
    // Load default page
    require("index.fn.php");
  } elseif ($_GET['fn'] == "save") {
    require("save.fn.php");
  }

?>
