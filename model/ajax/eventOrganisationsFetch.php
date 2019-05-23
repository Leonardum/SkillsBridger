<?php

require('../database.php');

$userId = filter_input (INPUT_POST, 'userId');
if ($userId == NULL) {
    $userId = filter_input (INPUT_GET, 'userId');
}

$organisationIds = filter_input (INPUT_POST, 'organisationIds');
if ($organisationIds == NULL) {
    $organisationIds = filter_input (INPUT_GET, 'organisationIds');
}

if (isset($userId)) {
	require('../eventOrganisation_object.php');
	
    $eventOrganisations = eventOrganisation::get_eventOrganisationsByUser($userId);
	echo json_encode($eventOrganisations);
	
} else if (isset($organisationIds)) {
	require('../file_object.php');
	
	$organisationIds = json_decode($organisationIds);
	
	$logoUrls = array();
	$arrLength = count($organisationIds);
	for($x = 0; $x < $arrLength; $x++) {
		$file = userFile::get_imageOfUploader('eventOrg', $organisationIds[$x]);
		$logoUrl = $file->getUrl();
		if (!$logoUrl) {
			$logoUrl = 0;
		}
		array_push($logoUrls, $logoUrl);
	}
	echo json_encode($logoUrls);
}

?>