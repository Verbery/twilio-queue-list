<?php
// Get the PHP helper library from twilio.com/docs/php/install
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

$queue = $client->account->queues->get($_POST['queueid']);
if($queue->current_size == 0) {
	$client->account->queues->delete($_POST['queueid']);
	print "successfully removed queue";
} else {
	print "queue is not empty";
}