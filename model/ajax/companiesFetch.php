<?php

require('../database.php');

$userId = filter_input (INPUT_POST, 'userId');
if ($userId == NULL) {
    $userId = filter_input (INPUT_GET, 'userId');
}

$companyIds = filter_input (INPUT_POST, 'companyIds');
if ($companyIds == NULL) {
    $companyIds = filter_input (INPUT_GET, 'companyIds');
}

if (isset($userId)) {
	require('../company_object.php');
	
    $companies = company::get_companiesByUser($userId);
	echo json_encode($companies);
	
} else if (isset($companyIds)) {
	require('../file_object.php');
	
	$companyIds = json_decode($companyIds);
	
	$logoUrls = array();
	$arrLength = count($companyIds);
	for($x = 0; $x < $arrLength; $x++) {
		$file = userFile::get_imageOfUploader('company', $companyIds[$x]);
		$logoUrl = $file->getUrl();
		if (!$logoUrl) {
			$logoUrl = 0;
		}
		array_push($logoUrls, $logoUrl);
	}
	echo json_encode($logoUrls);
}

?>