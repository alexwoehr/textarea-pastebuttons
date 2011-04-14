jQuery(document).ready(function(){
  // Data
  var snippets = DATA.snippets;

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
      edit: fieldset.find(".open"),
      save: fieldset.find(".save"),
      down: fieldset.find(".down"),
      up: fieldset.find(".down"),
      _class: fieldset.attr("className"),
      prev: fieldset.prev(),
      next: fieldset.next()
    };
  }

  // Allow single and double click
  jQuery.fn.single_double_click = function(single_click_callback, double_click_callback, timeout) {
    return this.each(function(){
      var clicks = 0, self = this;
      jQuery(this).click(function(event){
        clicks++;
        if (clicks == 1) {
          setTimeout(function(){
            if(clicks == 1) {
              single_click_callback.call(self, event);
            } else {
              double_click_callback.call(self, event);
            }
            clicks = 0;
          }, timeout || 300);
        }
      });
    });
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
        change(function(){
          $(this).prev("button").text($(this).val());
        }).
      end().

      // Single click on button inserts text into the text area.
      // Double click on button, for convenience: alias doubleclick on button to a click on Open
      find("button").
        single_double_click(
          // Single
          function(){with(generateVars($(this).closest("fieldset"))){
            content.val(function(i, t) { return t + textarea.val(); });
          }},
          // Double
          function(){with(generateVars($(this).closest("fieldset"))){
            edit.click();
          }}
        ).
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
