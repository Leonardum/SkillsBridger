<?php

require('../database.php');
require('../notification_object.php');

$userId = filter_input (INPUT_POST, 'userId');
if ($userId == NULL) {
    $userId = filter_input (INPUT_GET, 'userId');
}

$notificationId = filter_input (INPUT_POST, 'notificationId');
if ($notificationId == NULL) {
    $notificationId = filter_input (INPUT_GET, 'notificationId');
}

if (isset($notificationId) && isset($userId)) {
	notification::set_seen($userId, $notificationId);
} else if (isset($userId)) {
    $notifications = notification::get_newNotificationByUser($userId);
	echo json_encode($notifications);
	
}

?>