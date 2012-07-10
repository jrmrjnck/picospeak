$(document).ready( function(){
   getMessage();
});

function getMessage()
{
   $.get( 'GetMessage.php', processMessage, "json" );
}

function processMessage( data )
{
   vals = eval(data);
   $("#message").html(vals.message);
   setTimeout( getMessage, data.interval*1000 );
}
