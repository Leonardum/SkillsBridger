<?php
/* This file contains the code for the event object and queries. */
class event {
	
	private $id; 
	private $organisationId;
    private $name;
	private $purpose;
    private $type;
    private $start;
    private $endOfEvent;
	private $subscriptionDeadline;
    private $description;
    private $capacity;
	private $language;
    private $ticketPrice;
	private $paidOnline;
	private $alternateSubscription;
	private $subscriptionUrl;
	private $openForAll;
	private $openFor;
	private $motivationLetterEncouraged;
	private $motivationLetter;
	private $cvEncouraged;
	private $cv;
    private $webpageUrl;
    private $addressId;
    private $addressDescription;
	private $termsOfUseAcceptIp;
	private $cancelled;
	
    function __construct($id, $organisationId, $name, $purpose, $type, $start, $endOfEvent, $subscriptionDeadline, $description, $capacity, $language, $ticketPrice, $paidOnline, $alternateSubscription, $subscriptionUrl, $openForAll, $openFor, $motivationLetterEncouraged, $motivationLetter, $cvEncouraged, $cv, $webpageUrl, $addressId, $addressDescription, $termsOfUseAcceptIp, $cancelled) {
        $this->id = $id;
        $this->organisationId = $organisationId;
        $this->name = $name;
        $this->purpose = $purpose;
        $this->type = $type;
        $this->start = $start;
        $this->endOfEvent = $endOfEvent;
		$this->subscriptionDeadline = $subscriptionDeadline;
        $this->description = $description;
        $this->capacity = $capacity;
		$this->language = $language;
        $this->ticketPrice = $ticketPrice;
        $this->paidOnline = $paidOnline;
		$this->alternateSubscription = $alternateSubscription;
		$this->subscriptionUrl = $subscriptionUrl;
		$this->openForAll = $openForAll;
		$this->openFor = $openFor;
		$this->motivationLetterEncouraged = $motivationLetterEncouraged;
		$this->motivationLetter = $motivationLetter;
		$this->cvEncouraged = $cvEncouraged;
		$this->cv = $cv;
        $this->webpageUrl = $webpageUrl;
        $this->addressId = $addressId;
        $this->addressDescription = $addressDescription;
		$this->termsOfUseAcceptIp = $termsOfUseAcceptIp;
		$this->cancelled = $cancelled;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getOrganisationId() {
        return $this->organisationId;
    }
    public function getName() {
        return $this->name;
    }
    public function getPurpose() {
        return $this->purpose;
    }
    public function getType() {
        return $this->type;
    }
    public function getStart() {
        return $this->start;
    }
    public function getEndOfEvent() {
        return $this->endOfEvent;
    }
    public function getSubscriptionDeadline() {
        return $this->subscriptionDeadline;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getCapacity() {
        return $this->capacity;
    }
    public function getLanguage() {
        return $this->language;
    }
    public function getTicketPrice() {
        return $this->ticketPrice;
    }
    public function getPaidOnline() {
        return $this->paidOnline;
    }
    public function getAlternateSubscription() {
        return $this->alternateSubscription;
    }
    public function getSubscriptionUrl() {
        return $this->subscriptionUrl;
    }
    public function getOpenForAll() {
        return $this->openForAll;
    }
    public function getOpenFor() {
        return $this->openFor;
    }
    public function getMotivationLetterEncouraged() {
        return $this->motivationLetterEncouraged;
    }
    public function getMotivationLetter() {
        return $this->motivationLetter;
    }
    public function getCvEncouraged() {
        return $this->cvEncouraged;
    }
    public function getCv() {
        return $this->cv;
    }
    public function getWebpageUrl() {
        return $this->webpageUrl;
    }
	public function getAddressId() {
        return $this->addressId;
    }
	public function getAddressDescription() {
        return $this->addressDescription;
    }
	public function getTermsOfUseAcceptIp() {
        return $this->termsOfUseAcceptIp;
    }
    public function getCancelled() {
        return $this->cancelled;
    }
	
	
    public function setId($id){
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setOrganisationId($organisationId) {
        if (is_int($organisationId)) {
            $this->organisationId = $organisationId;
        }
    }
    public function setName($name) {
        if (is_string($name)) {
            $this->name = $name;
        }
    }
    public function setPurpose($purpose) {
        if (is_string($purpose)) {
            $this->purpose = $purpose;
        }
    }
    public function setType($type) {
        if (is_string($type)) {
            $this->type = $type;
        }
    }
    public function setStart($start) {
        if (is_string($start)) {
            $this->start = $start;
        }
    }
    public function setEndOfEvent($endOfEvent) {
        if (is_string($endOfEvent)) {
            $this->endOfEvent = $endOfEvent;
        }
    }
    public function setSubscriptionDeadline($subscriptionDeadline) {
        if (is_string($subscriptionDeadline)) {
            $this->subscriptionDeadline = $subscriptionDeadline;
        }
    }
    public function setDescription($description) {
        if (is_string($description)) {
            $this->description = $description;
        }
    }
    public function setCapacity($capacity) {
        if (is_int($capacity)) {
            $this->capacity = $capacity;
        }
    }
    public function setLanguage($language) {
        if (is_string($language)) {
            $this->language = $language;
        }
    }
	public function setTicketPrice($ticketPrice) {
        if (is_float($ticketPrice) || ($ticketPrice == NULL)) {
            $this->ticketPrice = $ticketPrice;
        }
    }
    public function setPaidOnline($paidOnline) {
        if (is_int($paidOnline)) {
            $this->paidOnline = $paidOnline;
        }
    }
    public function setAlternateSubscription($alternateSubscription) {
        if (is_int($alternateSubscription)) {
            $this->alternateSubscription = $alternateSubscription;
        }
    }
	public function setSubscriptionUrl($subscriptionUrl) {
        if (is_string($subscriptionUrl) || ($subscriptionUrl == NULL)) {
            $this->subscriptionUrl = $subscriptionUrl;
        }
	}
    public function setOpenForAll($openForAll) {
        if (is_int($openForAll)) {
            $this->openForAll = $openForAll;
        }
    }
    public function setOpenFor($openFor) {
        if (is_string($openFor) || ($openFor == NULL)) {
            $this->openFor = $openFor;
        }
    }
    public function setMotivationLetterEncouraged($motivationLetterEncouraged) {
        if (is_int($motivationLetterEncouraged)) {
            $this->motivationLetterEncouraged = $motivationLetterEncouraged;
        }
    }
    public function setMotivationLetter($motivationLetter) {
        if (is_int($motivationLetter)) {
            $this->motivationLetter = $motivationLetter;
        }
    }
    public function setCvEncouraged($cvEncouraged) {
        if (is_int($cvEncouraged)) {
            $this->cvEncouraged = $cvEncouraged;
        }
    }
    public function setCv($cv) {
        if (is_int($cv)) {
            $this->cv = $cv;
        }
    }
    public function setWebpageUrl($webpageUrl) {
        if (is_string($webpageUrl) || ($webpageUrl == NULL)) {
            $this->webpageUrl = $webpageUrl;
        }
    }
    public function setAddressId($addressId) {
        if (is_int($addressId)) {
            $this->addressId = $addressId;
        }
    }
    public function setAddressDescription($addressDescription) {
        if (is_string($addressDescription) || ($addressDescription == NULL)) {
            $this->addressDescription = $addressDescription;
        }
    }
	public function setTermsOfUseAcceptIp($termsOfUseAcceptIp) {
        if (is_string($termsOfUseAcceptIp) || ($termsOfUseAcceptIp == NULL)) {
            $this->termsOfUseAcceptIp = $termsOfUseAcceptIp;
        }
	}
    public function setCancelled($cancelled) {
        if (is_int($cancelled)) {
            $this->cancelled = $cancelled;
        }
    }
	
    
    // Save all changes made to the event info to the database.
    public function save() {
        /* Check if the event already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `event` (Organisation_id, Name, Purpose, Type, Start, End, SubscriptionDeadline, Description, Capacity, Language, TicketPrice, PaidOnline, AlternateSubscription, SubscriptionUrl, OpenForAll, OpenFor, MotivationLetterEncouraged, MotivationLetter, CvEncouraged, Cv, WebpageUrl, Address_id, AddressDescription, TermsOfUseAcceptIp, Cancelled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            			
			$statement->bind_param("isssssssisdiisisiiiisissi", $this->organisationId, $this->name, $this->purpose, $this->type, $this->start, $this->endOfEvent, $this->subscriptionDeadline, $this->description, $this->capacity, $this->language, $this->ticketPrice, $this->paidOnline, $this->alternateSubscription, $this->subscriptionUrl, $this->openForAll, $this->openFor, $this->motivationLetterEncouraged, $this->motivationLetter, $this->cvEncouraged, $this->cv, $this->webpageUrl, $this->addressId, $this->addressDescription, $this->termsOfUseAcceptIp, $this->cancelled);
			
            $success = $statement->execute();
            
            if ($success) {
                $eventId = $db->insert_id;
                $statement->close();
                return $eventId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `event` SET Organisation_id = ?, Name = ?, Purpose = ?, Type = ?, Start = ?, End = ?, SubscriptionDeadline = ?, Description = ?, Capacity = ?, Language = ?, TicketPrice = ?, PaidOnline = ?, AlternateSubscription = ?, SubscriptionUrl = ?, OpenForAll = ?, OpenFor = ?, MotivationLetterEncouraged = ?, MotivationLetter = ?, CvEncouraged = ?, Cv = ?, WebpageUrl = ?, Address_id = ?, AddressDescription = ?, TermsOfUseAcceptIp = ?, Cancelled = ? WHERE Event_id = ?";
			
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("isssssssisdiisisiiiisissii", $this->organisationId, $this->name, $this->purpose, $this->type, $this->start, $this->endOfEvent, $this->subscriptionDeadline, $this->description, $this->capacity, $this->language, $this->ticketPrice, $this->paidOnline, $this->alternateSubscription, $this->subscriptionUrl, $this->openForAll, $this->openFor, $this->motivationLetterEncouraged, $this->motivationLetter, $this->cvEncouraged, $this->cv, $this->webpageUrl, $this->addressId, $this->addressDescription, $this->termsOfUseAcceptIp, $this->cancelled, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete event record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `event` WHERE Event_id = ?";
        
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
    
    
    /* Create an event object and store all information of the record with the given Event_id in it. */
    static function get_eventById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `event` WHERE Event_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $organisationId, $name, $purpose, $type, $start, $endOfEvent, $subscriptionDeadline, $description, $capacity, $language, $ticketPrice, $paidOnline, $alternateSubscription, $subscriptionUrl, $openForAll, $openFor, $motivationLetterEncouraged, $motivationLetter, $cvEncouraged, $cv, $webpageUrl, $addressId, $addressDescription, $termsOfUseAcceptIp, $cancelled);
        
        $statement->fetch();
        
        $event = new event($id, $organisationId, $name, $purpose, $type, $start, $endOfEvent, $subscriptionDeadline, $description, $capacity, $language, $ticketPrice, $paidOnline, $alternateSubscription, $subscriptionUrl, $openForAll, $openFor, $motivationLetterEncouraged, $motivationLetter, $cvEncouraged, $cv, $webpageUrl, $addressId, $addressDescription, $termsOfUseAcceptIp, $cancelled);
        
        $statement->close();
        
        return $event;
    }
	
	
	/* Create an event array and store all information of the record with the given Event_id in it. */
    static function get_eventArrayById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `event` WHERE Event_id = ?";
		
		$statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        while ($row = $result->fetch_assoc()) {
            $event = $row;
        }
        
        $statement->close();
        
        return $event;
    }
	
	
	/* Adds the event ID, user ID and current time to the database in a separate table in order to keep track of event edits. */
	static function add_editHistory($eventId, $userId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
        $userId = $db->escape_string($userId);
		
		// Set the timezone.
		date_default_timezone_set("Europe/Brussels");
		// Get the current time.
		$now = date("Y-m-d H:i:s", time());
		
		$query = "INSERT INTO `event_edited_by_user` (Event_id, User_id, Time) VALUES (?, ?, ?)";
		
        $statement = $db->prepare($query);
		
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("iis", $eventId, $userId, $now);
		
        $success = $statement->execute();
		
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
	}
	
	
	// Get all the skills offered on an event.
    static function get_skillsOfferedOnEvent($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT skill_offered_on_event.Event_id, skill.* FROM `skill_offered_on_event`, `skill` WHERE skill_offered_on_event.Event_id = ? AND skill_offered_on_event.Skill_id = skill.Skill_id";
		
		$statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
		
		$skills = array();
        
        while ($row = $result->fetch_assoc()) {
            array_push($skills, array($row['Skill_id'], $row['Name'], $row['Type'], $row['Description']));
        }
        
        $statement->close();
        
		if (empty($skills)) {
			$skills = false;
		}
		
        return $skills;
    }
    
	
    // Returns a list of all events for a certain skill.
    static function get_upcomingEventsBySkill($skillId) {
		global $db;
        
        $skillId = $db->escape_string($skillId);
        
        $query = "SELECT * FROM `event`,`skill_offered_on_event` WHERE skill_offered_on_event.Event_id = event.Event_id AND skill_offered_on_event.Skill_id = ? AND event.Cancelled = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $skillId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
			// Set the timezone & get the current time.
			date_default_timezone_set("Europe/Brussels");
			$now = time();
			// Store the event end in a timestamp.
			$subDeadline = strtotime(date("Y-m-d H:i:s", strtotime($row['SubscriptionDeadline'])));
			/* If the event subscription deadline hasn't passed yet, add the event to the array. */
			if ($now < $subDeadline) {
				$currentAttendeeAmount = event::get_attendeeAmount($row['Event_id']);
				
				if ($currentAttendeeAmount < ($row['Capacity'])) {
					$events[] = $row;
				}
			}
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	// Returns a list of all events for a certain event Type.
    static function get_upcomingNonFullEvents() {
        global $db;
        
        $query = "SELECT * FROM `event` WHERE event.Cancelled = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
			// Set the timezone & get the current time.
			date_default_timezone_set("Europe/Brussels");
			$now = time();
			// Store the event end in a timestamp.
			$subDeadline = strtotime(date("Y-m-d H:i:s", strtotime($row['SubscriptionDeadline'])));
			/* If the event subscription deadline hasn't passed yet, add the event to the array. */
			if ($now < $subDeadline) {
				$currentAttendeeAmount = event::get_attendeeAmount($row['Event_id']);
				
				if ($currentAttendeeAmount < ($row['Capacity'])) {
					$events[] = $row;
				}
			}
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	// Returns a list of all events for a certain event Type.
    static function get_upcomingEventsByType($type) {
        global $db;
        
        $type = $db->escape_string($type);
        
        $query = "SELECT * FROM `event` WHERE Type = ? AND event.Cancelled = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("s", $type);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
			// Set the timezone & get the current time.
			date_default_timezone_set("Europe/Brussels");
			$now = time();
			// Store the event end in a timestamp.
			$subDeadline = strtotime(date("Y-m-d H:i:s", strtotime($row['SubscriptionDeadline'])));
			/* If the event subscription deadline hasn't passed yet, add the event to the array. */
			if ($now < $subDeadline) {
				$currentAttendeeAmount = event::get_attendeeAmount($row['Event_id']);
				
				if ($currentAttendeeAmount < ($row['Capacity'])) {
					$events[] = $row;
				}
			}
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	// Returns a list of all events that take place in a certain province.
	static function get_eventsByProvince($province) {
		global $db;
        
        $province = $db->escape_string($province);
        
        $query = "SELECT event.*, address.Address_id, address.Province FROM `event`, `address` WHERE Province = ? AND address.Address_id = event.Address_id AND event.Cancelled = 0;";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("s", $province);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
			/* , $row['Name'], $row['Type'], $row['Start'], $row['End'], $row['Address_id'], $row['Description'], $row['Capacity'], $row['TicketPrice'], $row['WebPageUrl'], $row['Cancelled'] */
        }
        
        $statement->close();
        
        return $events;
	}
    
	
	/* Returns an array of all students' names who applied to the event with id $id. */
    static function get_candidates($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT student_going_to_event.Event_id, student_going_to_event.Student_id, student_going_to_event.Approved, student.User_id, user.FirstName, user.LastName, user.Email FROM `student_going_to_event`, `student`, `user` WHERE Event_id = ? AND student_going_to_event.Student_id = student.Student_id AND student.User_id = user.User_id ORDER BY user.FirstName;";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $attendees = array();
        
        while ($row = $result->fetch_assoc()) {
            $attendees[] = array ($row['User_id'], $row['FirstName'], $row['LastName'], $row['Email'], $row['Approved'], $row['Student_id']);
        }
        
        $statement->close();
        
        return $attendees;
    }
	
    
    /* Returns an array of all students' names who subscribed to the event with id $id. */
    static function get_attendees($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT student_going_to_event.Event_id, student_going_to_event.Student_id, student_going_to_event.Approved, student_going_to_event.CheckedIn, student.User_id, user.FirstName, user.LastName, user.Email FROM `student_going_to_event`, `student`, `user` WHERE Event_id = ? AND student_going_to_event.Student_id = student.Student_id AND student.User_id = user.User_id AND student_going_to_event.Approved = 1 ORDER BY user.FirstName;";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $attendees = array();
        
        while ($row = $result->fetch_assoc()) {
            $attendees[] = array ($row['User_id'], $row['FirstName'], $row['LastName'], $row['Email'], $row['CheckedIn'], $row['Student_id']);
        }
        
        $statement->close();
        
        return $attendees;
    }
    
    
    // Adds a student as an attendee to an event in the database.
    static function add_studentToEvent($eventId, $studentId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
        $studentId = $db->escape_string($studentId);
		
		$event = event::get_eventById($eventId);
		
		$paidOnline = $event->getPaidOnline();
		$alternateSubscription = $event->getAlternateSubscription();
		$cv = $event->getCv();
		$motivationLetter = $event->getMotivationLetter();
		
		if ($paidOnline === 1 || $alternateSubscription === 1 || $cv === 1 || $motivationLetter === 1) {
			$query = "INSERT INTO `student_going_to_event` (Event_id, Student_id) VALUES (?, ?)";
		} else {
			$query = "INSERT INTO `student_going_to_event` (Event_id, Student_id, Approved) VALUES (?, ?, 1)";
		}
		
        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("ii", $eventId, $studentId);

        $success = $statement->execute();

        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Removes a student as an attendee to an event in the database.
    static function delete_studentFromEvent($eventId, $studentId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
        $studentId = $db->escape_string($studentId);

        $query = "DELETE FROM `student_going_to_event` WHERE Event_id = ? AND Student_id = ?";

        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("ii", $eventId, $studentId);

        $success = $statement->execute();

        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Gets the current amount of attendees approved for an event.
    static function get_attendeeAmount($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `student_going_to_event` WHERE Event_id = ? AND Approved = 1;";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
		$attendeeAmount = $result->num_rows;
        
        $statement->close();
        
        return $attendeeAmount;
    }
	
    
    // Adds a skill as offered at an event in the database.
    static function add_skillToEvent($eventId, $skillId) {
        global $db;
		
		$eventId = $db->escape_string($eventId);
        $skillId = $db->escape_string($skillId);
		
        $query = "INSERT INTO `skill_offered_on_event` (Event_id, Skill_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE Skill_id=Skill_id;";
		
        $statement = $db->prepare($query);
		
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("ii", $eventId, $skillId);
		
        $success = $statement->execute();
		
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
    
	
	// Removes all skills offered at an event from the database.
    static function delete_skillsFromEvent($eventId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
		
		$query = "DELETE FROM `skill_offered_on_event` WHERE Event_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $eventId);
        
        $success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	/* Checks in a student for an event, updating the CheckedIn field to true in student_going_to_event. */
    static function approve($eventId, $studentId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
        $studentId = $db->escape_string($studentId);
        
        $query = "UPDATE `student_going_to_event` SET Approved = 1 WHERE Event_id = ? AND Student_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("ii", $eventId, $studentId);
        
        $success = $statement->execute();
        
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
    
    /* Checks in a student for an event, updating the CheckedIn field to true in student_going_to_event. */
    static function checkIn($eventId, $studentId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
        $studentId = $db->escape_string($studentId);
        
        $query = "UPDATE `student_going_to_event` SET CheckedIn = 1 WHERE Event_id = ? AND Student_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("ii", $eventId, $studentId);
        
        $success = $statement->execute();
        
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Adds a sponsor to an event in the database.
	static function add_sponsorToEvent($eventId, $sponsorId) {
		global $db;
        
        $eventId = $db->escape_string($eventId);
        $sponsorId = $db->escape_string($sponsorId);
		
		$query = "INSERT INTO `event_has_sponsor` (Event_id, Sponsor_id) VALUES (?, ?)";
		
        $statement = $db->prepare($query);
		
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("ii", $eventId, $sponsorId);
		
        $success = $statement->execute();
		
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
	}
	
	
	// Removes a sponsor from an event in the database.
    static function delete_sponsorFromEvent($eventId, $sponsorId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
        $sponsorId = $db->escape_string($sponsorId);

        $query = "DELETE FROM `event_has_sponsor` WHERE Event_id = ? AND Sponsor_id = ?";

        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("ii", $eventId, $sponsorId);

        $success = $statement->execute();

        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Adds the rating of a student to an event in the database.
    static function add_rating($rating, $eventId, $studentId) {
        global $db;
        
        $rating = $db->escape_string($rating);
        $eventId = $db->escape_string($eventId);
        $studentId = $db->escape_string($studentId);
		
		$query = "UPDATE `student_going_to_event` SET Rating = ? WHERE Event_id = ? AND Student_id = ?";
		
        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("iii", $rating, $eventId, $studentId);

        $success = $statement->execute();

        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Gets the rating of a student to an event in the database.
	static function get_studentRating($eventId, $studentId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
        $studentId = $db->escape_string($studentId);
		
		$query = "SELECT Rating FROM `student_going_to_event` WHERE Event_id = ? AND Student_id = ?";
		
		$statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("ii", $eventId, $studentId);

        $success = $statement->execute();
		
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
		
		while ($row = $result->fetch_assoc()) {
            $rating = $row['Rating'];
        }
        
        $statement->close();
        
        return $rating;
    }
	
	
	// Gets the total rating of an event out of the database.
	static function get_rating($eventId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
		
		$query = "SELECT Rating FROM `student_going_to_event` WHERE Event_id = ? AND Rating IS NOT NULL";
		
		$statement = $db->prepare($query);
		
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("i", $eventId);
		
        $success = $statement->execute();
		
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
		
		$raterAmount = 0;
		$totalRating = 0;
		
		while ($row = $result->fetch_assoc()) {
			$raterAmount += 1;
            $totalRating += $row['Rating'];
        }
        
		if ($raterAmount != 0) {
			$rating = $totalRating/$raterAmount;
		} else {
			$rating = false;
		}
		
        $statement->close();
        
        return $rating;
    }
}

?>