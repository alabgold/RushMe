<?php

// This is the frat class
class frat {

    // These are the variables each member of the frat class has
	var $name;
	var $description;
	var $chapter;
	var $members;
	var $gpa;
	var $cover_image;
	var $profile_image;
	var $calendar_image;
	var $preview_image;
	var $address;
	var $ip = 'http://34.225.179.240/';
	var $default = 'data/defaultPic.png';
	var $iframe = "https://www.google.com/maps/embed/v1/place?key=AIzaSyCsxfxjgnxH1cSheVfUG75ljqu4ZtejUu8&q=";
	var $temp;
    var $favorite = false;

    // checks to see if image url is valid
	function UR_exists($url){
	   $headers=get_headers($url);
	   return stripos($headers[0],"200 OK")?true:false;
	}

    // frat constuctor
    // Taks in a name, description, chapter, members, gpa, cover photo, profile photo, 
    // calendar photo, preview photo, and address
	function __construct($n, $d, $c, $m, $g, $cover, $prof, $cal, $pre, $add)
	{ 
    	$this->name = $n;
    	$this->description = $d;
    	$this->chapter = $c;
    	$this->members = $m;
    	$this->gpa = $g;

        // if there is no image, use the default image
    	if($cover == null){
    		$this->cover_image = $this->default; }
    	else{
    		$this->cover_image = $this->ip . $cover;}

        // if there is no image, use the default image
    	if($prof == null){
    		$this->profile_image = $this->default;}
    	else{
    		$this->temp = $this->ip . $prof;

            // if there is an image url, only use it if it is found
    		if ($this->UR_exists($this->temp)) { 
    			$this->profile_image =  $this->ip . $prof;
    		} 
    		else{
    			$this->profile_image = $this->default;

    		}
    	}

        // if there is no image, use the default image
    	if($cal == null){
    		$this->calendar_image = $this->default;}
    	else{
    		$this->calendar_image = $this->ip . $cal;}

        // if there is no image, use the default image
    	if($pre == null){
    		$this->preview_image = $this->default;}
    	else{
    		$this->preview_image = $this->ip . $pre;}

        // make the url for google iframe
        if($add == null){
            $this->address = $add;
        }
        else{
    	   $add = str_replace(' ', '+', $add);
    	   $this->address =  $this->iframe . $add;
        }
    } 
}

// connect to the SQL server
$db = mysqli_connect('34.225.179.240','guest','guestaccess','fratinfo', '3306')
 or die('Error connecting to MySQL server.');

// Query the database for all frats
$query = "SELECT * FROM house_info";

// Make sure we get results
mysqli_query($db, $query) or die('Error querying database.');

// Make sure there are no special characters
mysqli_set_charset( $db, "utf8" );

// fetch results
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

// create an new array for frats
$frats = array();

// get the first frat by constucting a frat object with query row results. 
$frat = new frat($row['name'], $row['description'], $row['chapter'], $row['members'], $row['gpa'], $row['cover_image'], $row['profile_image'], $row['calendar_image'], $row['preview_image'], $row['address']);

// add frat to array
$frats[] = $frat;

// loop through the rest of the rows and do the same
while ($row = mysqli_fetch_array($result)) {
	$frat = new frat($row['name'], $row['description'], $row['chapter'], $row['members'], $row['gpa'], $row['cover_image'], $row['profile_image'], $row['calendar_image'], $row['preview_image'], $row['address']);
	$frats[] = $frat;

}

// encode the frat array into json so angular can read it
echo json_encode($frats, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

// close database
mysqli_close($db);
?>
