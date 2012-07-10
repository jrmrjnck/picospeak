<?php
   $db = new SQLite3( "PicoSpeak.db", SQLITE3_OPEN_READONLY );
   $result = $db->query( "SELECT * FROM `messages`" );

   while( $row = $result->fetchArray(SQLITE3_ASSOC) )
   {
      foreach( $row as $col=>$val )
      {
         echo "$val---";
      }
      echo "<br/>";
   }
?>
