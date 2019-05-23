<?php
require('../database.php');
require('../user_object.php');
require('../company_object.php');
require('../file_object.php');

$companyId = filter_input (INPUT_POST, 'companyId');
if ($companyId == NULL) {
    $companyId = filter_input (INPUT_GET, 'companyId');
}

if (isset($companyId)) {
	$company = company::get_companyById($companyId);
	$adminId = $company->getAdminUserId();
	
	$companyMemberIds = company::get_members($companyId);
	
	$members = array();
	array_push($members, $adminId);
	
	foreach($companyMemberIds as $companyMemberId) {
		if ($companyMemberId === $adminId) {
			$admin = true;
		} else {
			$admin = false;
		}
		$member = user::get_userById($companyMemberId);
		$memberName = $member->getFirstName() . " " . $member->getLastName();
		$memberPicture = userFile::get_imageOfUploader('user', $companyMemberId);
		if (isset($memberPicture)) {
			$memberPictureUrl = $memberPicture->getUrl();
		} else {
			$memberPictureUrl = NULL;
		}
		array_push($members, array("memberId"=>$companyMemberId, "memberName"=>$memberName, "picUrl"=>$memberPictureUrl));
	}
	echo json_encode($members);
	
}

?>