<?php

  // Check whether button exists
  ob_start(); ?>

    SELECT id
    FROM <?php echo DB; ?>text_snippets
    WHERE id='<?php echo mysql_real_escape_string($_REQUEST['id']); ?>' 

  <?php

  // Check for rows
  if (!count(slurq())) {

    if (strlen(trim($_REQUEST['title']))) {

      //
      // ADD
      //
    
      ob_start(); ?>
    
        INSERT INTO <?php echo DB; ?>text_snippets
        (`id`, `title`, `contents`)
        VALUES (
          '<?php echo mysql_real_escape_string($_REQUEST['id']); ?>',
          '<?php echo mysql_real_escape_string($_REQUEST['title']); ?>',
          '<?php echo mysql_real_escape_string($_REQUEST['contents']); ?>'
        )
    
      <?php
      $success = mysql_query(ob_get_clean());

    } else {
      
      // Not good
      $success = false;

    }

  } else {

    // Remove / Update old button

    if (!strlen(trim($_REQUEST['title']))) {

      //
      // REMOVE
      //

      ob_start(); ?>

        DELETE FROM <?php echo DB; ?>text_snippets
        WHERE id='<?php echo mysql_real_escape_string($_REQUEST['id']); ?>'

      <?php
      $success = mysql_query(ob_get_clean());

    } else {

      //
      // UPDATE
      //

      ob_start(); ?>

        UPDATE <?php echo DB; ?>text_snippets
        SET `title` = '<?php echo mysql_real_escape_string($_REQUEST['title']); ?>', 
            `contents` = '<?php echo mysql_real_escape_string($_REQUEST['contents']); ?>' 
        WHERE id='<?php echo mysql_real_escape_string($_REQUEST['id']); ?>' 

      <?php
      $success = mysql_query(ob_get_clean());

    }
  }

  die(json_encode(Array(
    "success" => $success,
  )));

