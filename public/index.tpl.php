<?php

function tpl($data) {

?>
<html>
  <head>
    <script src="jquery.js"></script>
    <script src="jquery.tmpl.js"></script>
    <style type="text/css">
      /* States */
      #buttons .saved .save { display: none; }
      #buttons .saved textarea { display: none; }
      #buttons .opened .open { display: none; }

      #buttons fieldset { width: auto; float: left; }
    </style>
  </head>
  <body>
    <textarea class="main" rows="15" cols="50"></textarea>
    <fieldset id="buttons"></fieldset><a href="#" class="new">New snippet</a>
    <script type="text/javascript">
      jQuery(document).ready(function(){
        // Data
        var snippets = <?php echo json_encode($data); ?>;

        $.fn.clicker = function(s, f){
          // Search case: search on s, bind, then end
          if (s) return this.find(s).clicker(false, f).end();
          // Base case: Bind clicker on this
          else return this.click(function(events){
            // Define default arguments for the function
            f({
              // The main text area
              content: $("textarea.main"),
              // The fieldset in question, the most important variable

              _: $(this).closest("fieldset"),

              // Text for this fieldset
              textarea: $(this).closest("fieldset").find("textarea"),
              open: $(this).closest("fieldset").find(".open"),
              save: $(this).closest("fieldset").find(".save"),
              down: $(this).closest("fieldset").find(".down"),
              up: $(this).closest("fieldset").find(".down"),
              myClass: $(this).attr("className"),
              parentClass: $(this).closest("textarea").attr("className"),
              prev: $(this).closest("fieldset").prev(),
              next: $(this).closest("fieldset").next()
            });
            events.preventDefault();
            return false;
          });
        };

        // Add events to a snippet
        $.fn.clothe = function(){
          return this.
            // Do
            clicker("button", function(_){with(_){
              content.val(function(i, t) { return t + textarea.val(); });
            }}).
          
            // Open, save: toggle saved/opened state
            clicker(".open, .save", function(_){ with(_){
              _.toggleClass("saved opened");
            }}).
          
            // Down: move position back/down
            clicker(".down", function(_){with(_){
              _.remove().insertBefore(prev).clothe();
            }}).
          
            // Up: move position forward/up
            clicker(".up", function(_){with(_){
              _.remove().insertAfter(next).clothe();
            }}).
          
            // Drop: remove
            clicker(".drop", function(_){with(_){
              _.remove();
            }});
        
        };


        // Setup buttons
        // Can take one or more snippets
        function addButton(snippets) {
          $(".button").tmpl(snippets).clothe().appendTo("#buttons");
        }

        // Add initial snippets
        addButton(snippets);

        // Setup "add button" functionality
        $(".new").click(function(e){
          snippet = {
            id: snippets.length,
            title: "New Snippet",
            contents: "Edit Snippet"
          };
          snippets.push(snippet);
          addButton(snippet);
          e.preventDefault();
          return false;
        });
      });

      // "Event" on the textarea
      function save() {
        var txt = $(this);
        //$.post("/save");
      }
    </script>
    <div id="templates">
      <script class="button" type="text/x-jquery-tmpl">
        <fieldset id="num-${id}" class="saved">
          <div>
            <a href="#" class="down">&lsaquo;</a>
            <button>${title}</button>
            <a href="#" class="up">&rsaquo;</a>
          </div>
          <textarea>${contents}</textarea>
          <a href="#" class="open">Edit</a>
          <a href="#" class="save">Save</a>
          <a href="#" class="drop">Remove</a>
        </fieldset>
      </script>
    </div>
  </body>
</html><?php

}

?>
