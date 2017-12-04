<?php

// This is the event class
class event {

	// These are the variables each member of the event class has
	var $house;
	var $title;
	var $startsAt;
	var $endsAt;
	var $event_date;
	var $location;
	var $favorite = false; 

	// event constuctor
	// Takes in a house, event name, start time, end time, date, and location
	function __construct($h, $en, $st, $et, $ed, $l)
	{ 
    	$this->house = $h;
    	$this->title = $en;
    	$this->startsAt = $st;
    	$this->endsAt = $et;
    	$this->event_date = $ed;
    	$this->location = $l;
    } 
}
// test date
$todaysDate = '09/10/2017';

// test time 
$currentTime = '05:31';

// connect to the SQL server
$db = mysqli_connect('34.225.179.240','guest','guestaccess','fratinfo', '3306')
 or die('Error connecting to MySQL server.');

// Query the database for all events
$query = "SELECT * FROM events";

// Make sure we get results
mysqli_query($db, $query) or die('Error querying database.');

// Make sure there are no special characters
mysqli_set_charset( $db, "utf8" );

// fetch results
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);


// create a new array for events
$events = array();

// if the event is after the test date and time
if (strcmp($row['event_date'],$todaysDate) > 0 or $row['event_date']==$todaysDate) {
	if (strcmp($row['start_time'],$currentTime) > 0){
		// get the first event by constucting a event object with query row results. 
		$event = new event($row['house'], $row['event_name'], $row['start_time'], $row['end_time'], $row['event_date'], $row['location']);

		// add event to event array
		$events[] = $event;
	}	
}

// loop through the rest of the rows and do the same
while ($row = mysqli_fetch_array($result)) {
	if (strcmp($row['event_date'],$todaysDate) > 0 or $row['event_date']==$todaysDate){
		if (strcmp($row['start_time'],$currentTime) > 0){
			$event = new event($row['house'], $row['event_name'], $row['start_time'], $row['end_time'], $row['event_date'], $row['location']);
			$events[] = $event;
		}
	}
}

// encode the event array into json so angular can read it
echo json_encode($events, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

// close database
mysqli_close($db);
?>