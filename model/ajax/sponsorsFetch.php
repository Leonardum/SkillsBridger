<?php

require('../database.php');
require('../sponsor_object.php');
require('../file_object.php');

$eventId = filter_input (INPUT_POST, 'eventId');
if ($eventId == NULL) {
    $eventId = filter_input (INPUT_GET, 'eventId');
}
$str = filter_input (INPUT_POST, 'str');
if ($str == NULL) {
    $str = filter_input (INPUT_GET, 'str');
}

if (isset($eventId)) {
	$eventSponsorIds = sponsor::get_sponsorOfEvent($eventId);
	$sponsors = array();
	
	foreach($eventSponsorIds as $eventSponsorId) {
		$sponsor = sponsor::get_sponsorById($eventSponsorId);
		$sponsorName = $sponsor->getName();
		$sponsorLogo = userFile::get_imageOfUploader('sponsor', $eventSponsorId);
		$sponsorLogoUrl = $sponsorLogo->getUrl();
		array_push($sponsors, array($eventSponsorId, $sponsorName, $sponsorLogoUrl));
	}
	echo json_encode($sponsors);

} else if (isset($str)) {
	$sponsors = sponsor::get_allSponsors();
	$hint = array();
	
	// lookup all hints from array if $str is different from ""
	if ($str !== "") {
		$str = ucfirst($str); //Returns $str with the first character capitalized.
		$len=strlen($str);
		foreach($sponsors as $sponsor) {
			if (stristr($str, substr($sponsor[1], 0, $len))) {
				$sponsorLogo = userFile::get_imageOfUploader('sponsor', $sponsor[0]);
				$sponsorLogoUrl = $sponsorLogo->getUrl();
				array_push($hint, array($sponsor[0], $sponsor[1], $sponsorLogoUrl));
			}
		}
	}
	echo json_encode($hint);
	
}

?>