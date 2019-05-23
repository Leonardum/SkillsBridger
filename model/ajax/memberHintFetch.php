<?php

require('../database.php');
require('../user_object.php');
require('../file_object.php');

$str = filter_input (INPUT_POST, 'str');
if ($str == NULL) {
    $str = filter_input (INPUT_GET, 'str');
}

$users = user::get_allUsers();

if (isset($hint)) {
	unset($hint);
}

$hint = array();

// lookup all hints from array if $str is different from ""
if ($str !== "") {
    $str = ucfirst($str); //Returns $str with the first character capitalized.
	$len = strlen($str);
    foreach($users as $user) {
		$userNameLength = strlen($user[1]);
        if (stristr($str, substr($user[1], 0, $len))) {
			if ($len < ($userNameLength+1)) {
				$profilePicture = userFile::get_imageOfUploader('user', $user[0]);
				$profilePictureUrl = $profilePicture->getUrl();
				if (!in_array(array($user[0], $user[1], $profilePictureUrl), $hint)) {
					array_push($hint, array($user[0], $user[1], $profilePictureUrl));
				}
			}
		}
    }
	echo json_encode($hint);
}

?>