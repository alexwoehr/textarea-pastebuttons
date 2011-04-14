<?php

function tpl($data) {

?><html>
  <head>
    <script src="jquery.js"></script>
    <script src="jquery.tmpl.js"></script>
    <style type="text/css">
      /* States */
      #buttons .saved .save { display: none; }
      #buttons .saved textarea { display: none; }
      #buttons .saved button + input { display: none; } /* Caption editor for button */
      #buttons .opened .open { display: none; }
      #buttons .opened .drop { display: none; }
      #buttons .opened button { display: none; }

      #buttons fieldset { width: auto; float: left; }
      #buttons button + input { width: 120px; }
    </style>
  </head>
  <body>
    <textarea class="main" rows="15" cols="50"></textarea>
    <fieldset id="buttons"></fieldset><a href="#" class="new">New snippet</a>
    <script type="text/javascript">
      jQuery(document).ready(function(){
        // Data
        var snippets = <?php echo json_encode($data); ?>;

        // Assemble the crucial values for a fieldset
        function generateVars(fieldset) {
          return {
            // The main text area
            content: $("textarea.main"),

            // The fieldset itself
            _: fieldset,

            // Text for this fieldset
            textarea: fieldset.find("textarea"),
            button: fieldset.find("button"),
            caption: fieldset.find("button + input"),
            open: fieldset.find(".open"),
            save: fieldset.find(".save"),
            down: fieldset.find(".down"),
            up: fieldset.find(".down"),
            _class: fieldset.attr("className"),
            prev: fieldset.prev(),
            next: fieldset.next()
          };
        }

        $.fn.clicker = function(s, f){
          // Search case: search on s, bind, then end
          if (s) return this.find(s).clicker(false, f).end();
          // Base case: Bind clicker on this
          else return this.click(function(events){
            // Call using default variables
            f(generateVars($(this).closest("fieldset")));
            events.preventDefault();
            return false;
          });
        };

        $.fn.postDB = function() {
          with(generateVars(this)) {
            $.post(
              location, 
              { fn: "save"
              , id: _.attr("id").match(/-(\d+)$/)[1]
              , title: button.text()
              , contents: textarea.val()
              }
            );
          }
          return this;
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

            // Added functionality for save: save to database
            clicker(".save", function(_){ with(_){
              _.postDB(); // Save it
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
              // Remove from database
              // Clear title
              button.text("");
              // Save and drop
              _.postDB().remove();
            }}).

            // Caption: keep text consistent with button
            find("button + input").
              keyup(function(){
                $(this).prev("button").text($(this).val());
              }).
            end();
        
        };


        // Setup buttons
        // Can take one or more snippets
        function addButton(snippets) {
          return $(".button").
            tmpl(snippets).
            clothe().
            appendTo("#buttons");
        }

        // Add initial snippets
        addButton(snippets);

        // Setup "add button" functionality
        $(".new").click(function(e){
          snippet = {
            id: snippets.length + 1, // DB id starts past 0
            title: "New Snippet",
            contents: "Edit Snippet"
          };
          snippets.push(snippet);
          addButton(snippet).toggleClass("saved opened");
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
            <input value="${title}" />
            <a href="#" class="up">&rsaquo;</a>
          </div>
          <textarea cols="20" rows="4">${contents}</textarea><br />
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
