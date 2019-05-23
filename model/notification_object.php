<?php
/* This file contains the code for the address object and queries. */

class notification {
    
    private $id;
    private $message;
    private $objectReference;
    private $objectId;
    private $timeStamp;
    
    function __construct($id, $message, $objectReference, $objectId, $timeStamp) {
        $this->id = $id;
        $this->message = $message;
        $this->objectReference = $objectReference;
        $this->objectId = $objectId;
        $this->timeStamp = $timeStamp;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getMessage() {
        return $this->message;
    }
    public function getObjectReference() {
        return $this->objectReference;
    }
    public function getObjectId() {
        return $this->objectId;
    }
    public function getTimeStamp() {
        return $this->timeStamp;
    }
    
    public function setId($id) {
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setMessage($message) {
        if (is_string($message)) {
            $this->message = $message;
        }
    }
    public function setObjectReference($objectReference) {
        if (is_string($objectReference)) {
            $this->objectReference = $objectReference;
        }
    }
    public function setObjectId($objectId) {
        if (is_int($objectId)) {
            $this->objectId = $objectId;
        }
    }
    public function setTimeStamp($timeStamp) {
        if (is_string($timeStamp)) {
            $this->timeStamp = $timeStamp;
        }
    }
	
    
    // Save all changes made to the notification info to the database.
    public function save() {
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `notification` (Message, ObjectReference, ObjectId, TimeStamp) VALUES (?, ?, ?, ?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("ssis", $this->message, $this->objectReference, $this->objectId, $this->timeStamp);
            
            $success = $statement->execute();
            
            if ($success) {
                $notificationId = $db->insert_id;
                $statement->close();
                return $notificationId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `notification` SET Message = ?, ObjectReference = ?, ObjectId = ?, TimeStamp = ? WHERE Notification_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("ssisi", $this->message, $this->objectReference, $this->objectId, $this->timeStamp, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete notification record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `notification` WHERE Notification_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $this->id);
        
        $success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
    
    
    /* Create a notification object and store all information of the record with the given Notification_id in it. */
    static function get_notificationById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `notification` WHERE Notification_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $message, $objectReference, $objectId, $seen, $timeStamp);
        
        $statement->fetch();
        
        $notification = new notification($id, $message, $objectReference, $objectId, $seen, $timeStamp);
        
        $statement->close();
        
        return $notification;
    }
	
	
	// Get all the notifications for a particular user which are not seen.
	static function get_newNotificationByUser($userId) {
		global $db;
        
        $userId = $db->escape_string($userId);
        
        $query = "SELECT * FROM `notification`, `user_has_notification` WHERE user_has_notification.User_id = ? AND user_has_notification.Notification_id = notification.Notification_id AND user_has_notification.Seen = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $userId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $notifications = array();
        
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
        
        $statement->close();
        
        return $notifications;
	}
	
	
	// Sets a notification to seen for a user.
	static function set_seen($userId, $notificationId) {
		global $db;
        
        $userId = $db->escape_string($userId);
		$notificationId = $db->escape_string($notificationId);
        
        $query = "UPDATE `user_has_notification` SET seen=1 WHERE User_id = ? AND Notification_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("ii", $userId, $notificationId);
        
		$success = $statement->execute();
		
		if ($success) {
			$statement->close();
		} else {
			display_db_error($db->error);
		}
	}
	
	
	// Adds a notification for a user in the database.
	static function add_notificationForUser($userId, $notificationId) {
		global $db;
        
        $userId = $db->escape_string($userId);
		$notificationId = $db->escape_string($notificationId);
        
        $query = "INSERT INTO `user_has_notification` (User_id, Notification_id) VALUES (?, ?)";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("ii", $userId, $notificationId);
        
		$success = $statement->execute();
		
		if ($success) {
			$statement->close();
		} else {
			display_db_error($db->error);
		}
	}
}

?>