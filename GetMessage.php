<?php
 
   $db = new SQLite3( "PicoSpeak.db", SQLITE3_OPEN_READWRITE );
   $db->busyTimeout( 60000 );

   // Look for currently displayed message
   $result = $db->query( "SELECT * FROM `messages` WHERE (`displayed`=1) LIMIT 1" );
   $row    = $result->fetchArray( SQLITE3_ASSOC );
   
   $curTime  = time();
   $interval = 60;
   $stopTime = 0;

   // If we need to get a new one
   if( $row === false || $curTime > $row['stopTime'] )
   {
      // If the current one is expired, mark it so
      if( $row !== false )
      {
         $id = $row['id'];
         $db->exec( "UPDATE `messages` SET `displayed`=2 WHERE `id`=$id" );
      }

      $result = $db->query( "SELECT * FROM `messages` WHERE (`displayed`=0) ORDER BY `time` ASC LIMIT 1" );
      $row    = $result->fetchArray( SQLITE3_ASSOC );
      $stopTime = $curTime + $interval;

      if( $row !== false )
      {
         $id = $row['id'];
         $db->exec( "UPDATE `messages` SET `stopTime`=$stopTime, `displayed`=1 WHERE `id`=$id" );
      }
   }
   else
   {
      $stopTime = $row['stopTime'];
   }

   // If there is no message to show now, set some defaults
   if( $row === false )
   {
      $message = '';
      $interval = 2;
   }
   else
   {
      $message = $row['text'];
      $interval = $stopTime - $curTime;
   }

   echo json_encode( array(
      'message'=>$message,
      'interval'=>$interval
   ));

   $db->close();
?>
