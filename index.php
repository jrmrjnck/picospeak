<!DOCTYPE html>
<html lang="en">
<head>
   <title>PicoSpeak</title>
</head>
<body>

<?php
   if( isset($_POST['message']) )
   {
      $db = new SQLite3( "PicoSpeak.db", SQLITE3_OPEN_READWRITE );
      $db->busyTimeout( 60000 );

      $text = $db->escapeString( $_POST['message'] );
      $ip   = $_SERVER['REMOTE_ADDR'];
      $time = time();
      $displayed = false;
      $query = sprintf( "INSERT INTO `messages` 
                         (`text`,`ip`,`time`,`displayed`, `stopTime`)
                         VALUES
                         ('%s','%s',%d,%d,0)",
                        $text,
                        $ip,
                        $time,
                        $displayed );

      if( !$db->exec($query) )
      {
         echo "SQLite query failed.\n";
         exit;
      }

      $db->close();
   }
?>

   <h1>PicoSpeak</h1>
   <form action="" method="post">
      <input name="message" size="100" placeholder="Say Something..." />
   </form>
</body>
</html>
