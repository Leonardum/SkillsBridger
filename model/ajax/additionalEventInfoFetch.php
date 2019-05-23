<?php

require('../database.php');
require('../event_object.php');
require('../address_object.php');
require('../eventOrganisation_object.php');
require('../sponsor_object.php');
require('../file_object.php');

$ids = filter_input (INPUT_POST, 'ids');
if ($ids == NULL) {
    $ids = filter_input (INPUT_GET, 'ids');
}

$ratingNeeded = filter_input (INPUT_POST, 'ratingNeeded');
if ($ratingNeeded == NULL) {
    $ratingNeeded = filter_input (INPUT_GET, 'ratingNeeded');
}
$getRating = filter_input (INPUT_POST, 'getRating');
if ($getRating == NULL) {
    $getRating = filter_input (INPUT_GET, 'getRating');
}


$ids = json_decode($ids);

$eventsInfo = array();

for($x = 0; $x < count($ids); $x++) {
	$boxId = $ids[$x][0]; // To put the info in the right box.
	$eventId = $ids[$x][1]; // To get the skills of the event.
	$organisationId = $ids[$x][2]; // To get the organisation name and logo.
	$addressId = $ids[$x][3]; // To get the address of the event.
	if (isset($ratingNeeded)) {
		$studentId = $ids[$x][4]; // To get the rating of the event.
	}
	
	// Get the skills of the event.
	$skillsInfo = event::get_skillsOfferedOnEvent($eventId);
	// If there are skills for the event, then put them in the $skills array.
	if ($skillsInfo) {
		$skills = array();
		for($y = 0; $y < count($skillsInfo); $y++) {
			array_push($skills, array($skillsInfo[$y][0], $skillsInfo[$y][1]));
		}
	} else {
	// If there are no skills for the event, make the $skills variable zero.
		$skills = 0;
	}
	
	// Get the organisation name and logo.
	$organisation = eventOrganisation::get_eventOrganisationById($organisationId);
	$organisationName = $organisation->getName();
	
	$file = userFile::get_imageOfUploader('eventOrg', $organisationId);
	$logoUrl = $file->getUrl();
	if (!$logoUrl) {
		$logoUrl = 0;
	}
	
	// Get the address of the event.
	$address = address::get_addressArrayById($addressId);
	
	if (isset($ratingNeeded)) {
		$rating = event::get_studentRating($eventId, $studentId);
		if ($rating == NULL) {
			$rating = 0;
		}
	}
	
	if (isset($getRating)) {
		$rating = event::get_rating($eventId);
		if (!$rating) {
			$rating = 0;
		}
	}
	
	// Get the sponsors of the event.
	$eventSponsorIds = sponsor::get_sponsorOfEvent($eventId);
	$sponsors = array();
	
	foreach($eventSponsorIds as $eventSponsorId) {
		$sponsor = sponsor::get_sponsorById($eventSponsorId);
		$sponsorName = $sponsor->getName();
		$sponsorLogo = userFile::get_imageOfUploader('sponsor', $eventSponsorId);
		$sponsorLogoUrl = $sponsorLogo->getUrl();
		array_push($sponsors, array($sponsorName, $sponsorLogoUrl));
	}
	
	
	if (isset($ratingNeeded) || isset($getRating)) {
		// Gather all information for 1 event in an array
		$eventInfo = array($boxId, $skills, $organisationName, $logoUrl, $address, $sponsors, $rating);
	} else {
		$eventInfo = array($boxId, $skills, $organisationName, $logoUrl, $address, $sponsors);
	}
	
	/* $eventInfo will looks something like this:
	[2,["Communication","Valuation"],"Capitant",".\/uploads\/files\/e21baa864abf4c4f0745d996fd6f0526",{"Address_id":2,"LocationName":"Sporthal","Street":"Lagerstraat","StreetNumber":"8","ZipCode":"2690","City":"Antwerpen","Province":"Brabant wallon","State":null,"Country":"Belgium"}, 0] */
	
	array_push($eventsInfo, $eventInfo);
}

echo json_encode($eventsInfo);

?>