<?php
// this line loads the library 
// require_once(APPPATH.'libraries/Services/Twilio.php');

require('vendor/autoload.php');

/*
 * SETUP environment vars for application in Heroku
 *
 * Twilio SID and TOKEN can be found here: https://www.twilio.com/user/account/
 * heroku config:set TWILIO_SID=Azzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz
 * heroku config:set TWILIO_TOKEN=Azzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz
 * heroku config:set TWILIO_APPSID=Azzzzzzzzzzzzzzzzzzzzzzzzzzzzzz
 *
 */

// Your Account Sid and Auth Token from twilio.com/user/account
$accountSid	= getenv('TWILIO_SID');
$authToken	= getenv('TWILIO_TOKEN');

$client = new Services_Twilio($accountSid, $authToken); 
 
$queues = $client->account->queues->getIterator(0, 50); 
echo "<h1>List of Twilio queues with current sizes in ()</h1>";

foreach ($queues as $queue) { 
	echo "<p>".$queue->friendly_name." (".$queue->current_size.")"." <a class='del_queue' href='#' sid='".$queue->sid."'>Delete</a></p>";
}

?>
<script type="text/javascript" src="https://code.jquery.com/jquery-git1.min.js"></script>
<script type="text/javascript">
	$(".del_queue").click(function(){
		var that = $( this );
		var sid = $( this ).attr('sid');
		console.log(sid);
		$.ajax({
			type: 'POST',
			url: "https://"+window.location.hostname+"/delete_queue.php",
			data: {
				queueid: sid
			},
			dataType: 'text'
		}).done(function( data ) {
			  that.parent().text("Deleted");
		});

	});
</script>