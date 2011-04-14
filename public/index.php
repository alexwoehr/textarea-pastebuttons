<?php

  require_once("util.php");

  // Check inputs
  if (!isset($_REQUEST['fn'])) {
    // Load default page
    require("index.fn.php");
  } elseif ($_REQUEST['fn'] == "save") {
    require("save.fn.php");
  }

?>
