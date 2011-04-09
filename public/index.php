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
    <textarea class="main"></textarea>
    <fieldset id="buttons"></fieldset><a href="#" class="new">New snippet</a>
    <script src="text/javascript">
      jQuery(document).ready(function($){
        // Data
        var snippets = <?php echo json_encode($snippets); ?>;

        // Setup buttons
        $(".button").tmpl(snippets).
          // Setup functionality
          find("button").
            click(function(){
              var add = $(this).next("textarea").text();
              $("textarea.main").text(function(t) {return t + add; });
            });
          find(".save").
            click(function(){ save.call(this); $(this).prev("textarea").andSelf().hide(); }).
            end().
          find(".edit").
            click(function(){ $(this).next("textarea").next(".hide").andSelf().show(); }).
            end().
          find(".drop").
            click(function(){ $(this).parent("fieldset").remove(); }).
            end().

          // Add it
          prependTo("#buttons");
      });

      // "Event" on the textarea
      function save() {
        $(this).click(function(){
        });
      }
    </script>
    <div id="templates">
      <script class="button" type="text/x-jquery-tmpl">
        <fieldset>
          <button>${title}</button>
          <textarea display="none">${contents}</textarea>
          <a href="#" class="save" display="none">Save</a>
          <a href="#" class="edit">Edit</a>
          <a href="#" class="drop">Remove</a>
        </fieldset>
      </script>
    </div>
  </body>
</html>
