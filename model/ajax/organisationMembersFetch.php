<?php
require('../database.php');
require('../user_object.php');
require('../eventOrganisation_object.php');
require('../file_object.php');

$organisationId = filter_input (INPUT_POST, 'organisationId');
if ($organisationId == NULL) {
    $organisationId = filter_input (INPUT_GET, 'organisationId');
}

if (isset($organisationId)) {
	$organisation = eventOrganisation::get_eventOrganisationById($organisationId);
	$adminId = $organisation->getAdminUserId();
	
	$organisationMemberIds = eventOrganisation::get_members($organisationId);
	
	$members = array();
	array_push($members, $adminId);
	
	foreach($organisationMemberIds as $organisationMemberId) {
		if ($organisationMemberId === $adminId) {
			$admin = true;
		} else {
			$admin = false;
		}
		$member = user::get_userById($organisationMemberId);
		$memberName = $member->getFirstName() . " " . $member->getLastName();
		$memberPicture = userFile::get_imageOfUploader('user', $organisationMemberId);
		if (isset($memberPicture)) {
			$memberPictureUrl = $memberPicture->getUrl();
		} else {
			$memberPictureUrl = NULL;
		}
		array_push($members, array("memberId"=>$organisationMemberId, "memberName"=>$memberName, "picUrl"=>$memberPictureUrl));
	}
	echo json_encode($members);
	
}

?>