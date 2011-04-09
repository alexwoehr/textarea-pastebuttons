<?php

  // Slurp a query
  function slurq($conn) {
    $results = mysql_query(ob_get_clean(), $conn);
    while ($snippets[] = mysql_fetch($result));
  }

  $conn = mysql_connect("10.194.111.8", "user_e39e7998", ".3g3vCFVgf7Tmm", "db_e39e7998");
  ob_start(); ?>
    SELECT * FROM text_snippets;

  <?php

  $snippets = slurq($conn);
  die(var_export($snippets, true));

?>
<html>
  <head>
    <script src="jquery.js"></script>
    <script src="jquery.tmpl.js"></script>
  </head>
  <body>
    <textarea></textarea>
    <fieldset id="buttons"></fieldset>
    <script src="text/javascript">
      jQuery(document).ready(function($){
        // Data
        var snippets = <?php echo json_encode($snippets); ?>;

        // Setup buttons
        $(".button").tmpl(snippets).appendTo("#buttons");

        // Editing functionality
      });
    </script>
    <div id="templates">
      <script class="button" type="text/x-jquery-tmpl">
        <button>${title}</button><code display="none">${contents}</code>
      </script>
    </div>
  </body>
</html>
