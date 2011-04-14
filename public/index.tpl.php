<?php

function tpl($data) {

?><html>
  <head>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/jquery.tmpl.js"></script>
    <script type="text/javascript" src="/js/scripts.js"></script>
    <script type="text/javascript">
      var DATA = <?php echo json_encode($data); ?>;
    </script>
    <link rel="stylesheet" type="text/css" href="/css/styles.css" media="screen"></link>
  </head>
  <body>
    <textarea class="main" rows="15" cols="50"></textarea>
    <fieldset id="buttons"></fieldset><a href="#" class="new">New snippet</a>
    <div id="templates">
      <script class="button" type="text/x-jquery-tmpl">
        <fieldset id="num-${id}" class="saved">
          <div>
            <a href="#" class="down">&laquo;</a>
            <button>${title}</button>
            <input value="${title}" tabindex="10" />
            <a href="#" class="up">&raquo;</a>
          </div>
          <textarea cols="20" rows="4">${contents}</textarea><br />
          <a href="#" class="open">Edit</a>
          <a href="#" class="save" tabindex="10">Save</a>
          <a href="#" class="drop">Remove</a>
        </fieldset>
      </script>
    </div>
  </body>
</html><?php

}

?>
