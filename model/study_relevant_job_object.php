<?php
/* This file contains the code for the study relevant job object and queries. */
class studyRelevantJob {
	
	private $id; 
	private $companyId;
    private $hiringCompany;
	private $department;
    private $studentReportsTo;
	private $requestDate;
    private $start;
    private $endOfJob;
	private $applicationDeadline;
	private $daysPerWeek;
	private $hoursPerWeek;
    private $description;
    private $goal;
	private $desiredStudy;
    private $bachelor;
	private $firstMaster;
	private $secondMaster;
	private $maNaMa;
	private $desiredSkills;
	private $softwareMastery;
    private $grossWage;
    private $remarks;
	private $addressId;
	private $addressDescription;
	private $termsOfUseAcceptIp;
	
	
    function __construct($id, $companyId, $hiringCompany, $department, $studentReportsTo, $requestDate, $start, $endOfJob, $applicationDeadline, $daysPerWeek, $hoursPerWeek, $description, $goal, $desiredStudy, $bachelor, $firstMaster, $secondMaster, $maNaMa, $desiredSkills, $softwareMastery, $grossWage, $remarks, $addressId, $addressDescription, $termsOfUseAcceptIp) {
        $this->id = $id;
		$this->companyId = $companyId;
		$this->hiringCompany = $hiringCompany;
		$this->department = $department;
		$this->studentReportsTo = $studentReportsTo;
		$this->requestDate = $requestDate;
		$this->start = $start;
		$this->endOfJob = $endOfJob;
		$this->applicationDeadline = $applicationDeadline;
		$this->daysPerWeek = $daysPerWeek;
		$this->hoursPerWeek = $hoursPerWeek;
		$this->description = $description;
		$this->goal = $goal;
		$this->desiredStudy = $desiredStudy;
		$this->bachelor = $bachelor;
		$this->firstMaster = $firstMaster;
		$this->secondMaster = $secondMaster;
		$this->maNaMa = $maNaMa;
		$this->desiredSkills = $desiredSkills;
		$this->softwareMastery = $softwareMastery;
		$this->grossWage = $grossWage;
		$this->remarks = $remarks;
		$this->addressId = $addressId;
		$this->addressDescription = $addressDescription;
		$this->termsOfUseAcceptIp = $termsOfUseAcceptIp;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getCompanyId() {
        return $this->companyId;
    }
    public function getHiringCompany() {
        return $this->hiringCompany;
    }
    public function getDepartment() {
        return $this->department;
    }
    public function getStudentReportsTo() {
        return $this->studentReportsTo;
    }
    public function getRequestDate() {
        return $this->requestDate;
    }
    public function getStart() {
        return $this->start;
    }
    public function getEndOfJob() {
        return $this->endOfJob;
    }
    public function getApplicationDeadline() {
        return $this->applicationDeadline;
    }
    public function getDaysPerWeek() {
        return $this->daysPerWeek;
    }
    public function getHoursPerWeek() {
        return $this->hoursPerWeek;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getGoal() {
        return $this->goal;
    }
    public function getDesiredStudy() {
        return $this->desiredStudy;
    }
    public function getBachelor() {
        return $this->bachelor;
    }
    public function getFirstMaster() {
        return $this->firstMaster;
    }
    public function getSecondMaster() {
        return $this->secondMaster;
    }
    public function getMaNaMa() {
        return $this->maNaMa;
    }
    public function getDesiredSkills() {
        return $this->desiredSkills;
    }
    public function getSoftwareMastery() {
        return $this->softwareMastery;
    }
    public function getGrossWage() {
        return $this->grossWage;
    }
	public function getRemarks() {
        return $this->remarks;
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
	
	
    public function setId($id){
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setCompanyId($companyId) {
        if (is_int($companyId)) {
            $this->companyId = $companyId;
        }
    }
    public function setHiringCompany($hiringCompany) {
        if (is_string($hiringCompany)) {
            $this->hiringCompany = $hiringCompany;
        }
    }
    public function setDepartment($department) {
        if (is_string($department)) {
            $this->department = $department;
        }
    }
    public function setStudentReportsTo($studentReportsTo) {
        if (is_string($studentReportsTo)) {
            $this->studentReportsTo = $studentReportsTo;
        }
    }
    public function setRequestDate($requestDate) {
        if (is_string($requestDate)) {
            $this->requestDate = $requestDate;
        }
    }
    public function setStart($start) {
        if (is_string($start)) {
            $this->start = $start;
        }
    }
    public function setEndOfJob($endOfJob) {
        if (is_string($endOfJob)) {
            $this->endOfJob = $endOfJob;
        }
    }
    public function setApplicationDeadline($applicationDeadline) {
        if (is_string($applicationDeadline)) {
            $this->applicationDeadline = $applicationDeadline;
        }
    }
    public function setDaysPerWeek($daysPerWeek) {
        if (is_int($daysPerWeek) || ($daysPerWeek == NULL)) {
            $this->daysPerWeek = $daysPerWeek;
        }
    }
    public function setHoursPerWeek($hoursPerWeek) {
        if (is_int($hoursPerWeek) || ($hoursPerWeek == NULL)) {
            $this->hoursPerWeek = $hoursPerWeek;
        }
    }
    public function setDescription($description) {
        if (is_string($description)) {
            $this->description = $description;
        }
    }
    public function setGoal($goal) {
        if (is_string($goal) || ($goal == NULL)) {
            $this->goal = $goal;
        }
    }
    public function setDesiredStudy($desiredStudy) {
        if (is_int($desiredStudy) || ($desiredStudy == NULL)) {
            $this->desiredStudy = $desiredStudy;
        }
    }
    public function setBachelor($bachelor) {
        if (is_int($bachelor)) {
            $this->bachelor = $bachelor;
        }
    }
    public function setFirstMaster($firstMaster) {
        if (is_int($firstMaster)) {
            $this->firstMaster = $firstMaster;
        }
    }
    public function setSecondMaster($secondMaster) {
        if (is_int($secondMaster)) {
            $this->secondMaster = $secondMaster;
        }
    }
    public function setMaNaMa($maNaMa) {
        if (is_int($maNaMa)) {
            $this->maNaMa = $maNaMa;
        }
    }
    public function setDesiredSkills($desiredSkills) {
        if (is_string($desiredSkills) || ($desiredSkills == NULL)) {
            $this->desiredSkills = $desiredSkills;
        }
    }
	public function setSoftwareMastery($softwareMastery) {
        if (is_string($softwareMastery) || ($softwareMastery == NULL)) {
            $this->softwareMastery = $softwareMastery;
        }
	}
    public function setGrossWage($grossWage) {
        if (is_float($grossWage)) {
            $this->grossWage = $grossWage;
        }
    }
    public function setRemarks($remarks) {
        if (is_string($remarks) || ($remarks == NULL)) {
            $this->remarks = $remarks;
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
	
    
    // Save all changes made to the study relevant job info to the database.
    public function save() {
        /* Check if the study relevant job already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `study_relevant_job` (Company_id, HiringCompany, Department, StudentReportsTo, RequestDate, Start, End, ApplicationDeadline, DaysPerWeek, HoursPerWeek, Description, Goal, DesiredStudy, Bachelor, FirstMaster, SecondMaster, MaNaMa, DesiredSkills, SoftwareMastery, GrossWage, Remarks, Address_id, AddressDescription, TermsOfUseAcceptIp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            			
			$statement->bind_param("isssssssiissiiiiissdsiss", $this->companyId, $this->hiringCompany, $this->department, $this->studentReportsTo, $this->requestDate, $this->start, $this->endOfJob, $this->applicationDeadline, $this->daysPerWeek, $this->hoursPerWeek, $this->description, $this->goal, $this->desiredStudy, $this->bachelor, $this->firstMaster, $this->secondMaster, $this->maNaMa, $this->desiredSkills, $this->softwareMastery, $this->grossWage, $this->remarks, $this->addressId, $this->addressDescription, $this->termsOfUseAcceptIp);
			
            $success = $statement->execute();
            
            if ($success) {
                $studyRelevantJobId = $db->insert_id;
                $statement->close();
                return $studyRelevantJobId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `study_relevant_job` SET Company_id = ?, HiringCompany = ?, Department = ?, StudentReportsTo = ?, RequestDate = ?, Start = ?, End = ?, ApplicationDeadline = ?, DaysPerWeek = ?, HoursPerWeek = ?, Description = ?, Goal = ?, DesiredStudy = ?, Bachelor = ?, FirstMaster = ?, SecondMaster = ?, MaNaMa = ?, DesiredSkills = ?, SoftwareMastery = ?, GrossWage = ?, Remarks = ?, Address_id = ?, AddressDescription = ?, TermsOfUseAcceptIp = ? WHERE StudyRelevantJob_id = ?";
			
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("isssssssiissiiiiissdsissi", $this->companyId, $this->hiringCompany, $this->department, $this->studentReportsTo, $this->requestDate, $this->start, $this->endOfJob, $this->applicationDeadline, $this->daysPerWeek, $this->hoursPerWeek, $this->description, $this->goal, $this->desiredStudy, $this->bachelor, $this->firstMaster, $this->secondMaster, $this->maNaMa, $this->desiredSkills, $this->softwareMastery, $this->grossWage, $this->remarks, $this->addressId, $this->addressDescription, $this->termsOfUseAcceptIp, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete study relevan job record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `event` WHERE StudyRelevantJob_id = ?";
        
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
    
    
    /* Create a study relevant job object and store all information of the record with the given StudyRelevantJob_id in it. */
    static function get_studyRelevantJobById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `study_relevant_job` WHERE StudyRelevantJob_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $companyId, $hiringCompany, $department, $studentReportsTo, $requestDate, $start, $endOfJob, $applicationDeadline, $daysPerWeek, $hoursPerWeek, $description, $goal, $desiredStudy, $bachelor, $firstMaster, $secondMaster, $maNaMa, $desiredSkills, $softwareMastery, $grossWage, $remarks, $addressId, $addressDescription, $termsOfUseAcceptIp);
        
        $statement->fetch();
        
        $studyRelevantJob = new studyRelevantJob($id, $companyId, $hiringCompany, $department, $studentReportsTo, $requestDate, $start, $endOfJob, $applicationDeadline, $daysPerWeek, $hoursPerWeek, $description, $goal, $desiredStudy, $bachelor, $firstMaster, $secondMaster, $maNaMa, $desiredSkills, $softwareMastery, $grossWage, $remarks, $addressId, $addressDescription, $termsOfUseAcceptIp);
        
        $statement->close();
        
        return $studyRelevantJob;
    }
	
	
	/* Create a study relevant job array and store all information of the record with the given StudyRelevantJob_id in it. */
    static function get_studyRelevantJobArrayById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `study_relevant_job` WHERE StudyRelevantJob_id = ?";
		
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
            $studyRelevantJob = $row;
        }
        
        $statement->close();
        
        return $studyRelevantJob;
    }
	
	
	// Get all the skills offered on a study relevant job.
    static function get_skillsOfferedOnStudyRelevantJob($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT skill_offered_on_study_relevant_job.StudyRelevantJob_id, skill.* FROM `skill_offered_on_event`, `skill` WHERE skill_offered_on_study_relevant_job.StudyRelevantJob_id = ? AND skill_offered_on_study_relevant_job.Skill_id = skill.Skill_id";
		
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
    
	
    // Returns a list of all study relevant jobs for a certain skill.
    static function get_upcomingStudyRelevantJobsBySkill($skillId) {
		global $db;
        
        $skillId = $db->escape_string($skillId);
        
        $query = "SELECT * FROM `study_relevant_job`,`skill_offered_on_study_relevant_job` WHERE skill_offered_on_study_relevant_job.StudyRelevantJob_id = study_relevant_job.StudyRelevantJob_id AND skill_offered_on_study_relevant_job.Skill_id = ?";
        
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
        
        $studyRelevantJobs = array();
        
        while ($row = $result->fetch_assoc()) {
			// Set the timezone & get the current time.
			date_default_timezone_set("Europe/Brussels");
			$now = time();
			// Store the job application deadline in a timestamp.
			$applicationDeadline = strtotime(date("Y-m-d H:i:s", strtotime($row['ApplicationDeadline'])));
			/* If the job application deadline hasn't passed yet, add the event to the array. */
			if ($now < $applicationDeadline) {
				$studyRelevantJobs[] = $row;
			}
        }
        
        $statement->close();
        
        return $studyRelevantJobs;
    }
	
	
	// Returns a list of all study relevant jobs for a certain which are still vacant.
    static function get_vacantStudyRelevantJobs() {
        global $db;
        
        $query = "SELECT * FROM `study_relevant_job`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $studyRelevantJobs = array();
        
        while ($row = $result->fetch_assoc()) {
			// Set the timezone & get the current time.
			date_default_timezone_set("Europe/Brussels");
			$now = time();
			// Store the job application deadline in a timestamp.
			$applicationDeadline = strtotime(date("Y-m-d H:i:s", strtotime($row['ApplicationDeadline'])));
			/* If the job application deadline hasn't passed yet, add the event to the array. */
			if ($now < $subDeadline) {
				$studyRelevantJobs[] = $row;
			}
        }
        
        $statement->close();
        
        return $studyRelevantJobs;
    }
	
	
	/* Returns an array of all students' names who applied to the study relevant job with id $id. */
    static function get_applicants($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT student_applied_for_study_relevant_job.StudyRelevantJob_id, student_applied_for_study_relevant_job.Student_id, student_applied_for_study_relevant_job.Approved, student.User_id, user.FirstName, user.LastName, user.Email FROM `student_applied_for_study_relevant_job`, `student`, `user` WHERE StudyRelevantJob_id = ? AND student_applied_for_study_relevant_job.Student_id = student.Student_id AND student.User_id = user.User_id ORDER BY user.FirstName;";
        
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
        
        $applicants = array();
        
        while ($row = $result->fetch_assoc()) {
            $applicants[] = array ($row['User_id'], $row['FirstName'], $row['LastName'], $row['Email'], $row['Approved'], $row['Student_id']);
        }
        
        $statement->close();
        
        return $applicants;
    }
	
    
    // Adds a student as applying to a study relevant job in the database.
    static function add_studentToStudyRelevantJob($studyRelevantJobId, $studentId) {
        global $db;
        
        $studyRelevantJobId = $db->escape_string($studyRelevantJobId);
        $studentId = $db->escape_string($studentId);
		
		$query = "INSERT INTO `student_applied_for_study_relevant_job` (StudyRelevantJob_id, Student_id) VALUES (?, ?)";
		
        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("ii", $studyRelevantJobId, $studentId);

        $success = $statement->execute();

        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Removes a student as an applicant of a study relevant job in the database.
    static function delete_studentFromStudyRelevantJob($studyRelevantJobId, $studentId) {
        global $db;
        
        $studyRelevantJobId = $db->escape_string($studyRelevantJobId);
        $studentId = $db->escape_string($studentId);

        $query = "DELETE FROM `student_applied_for_study_relevant_job` WHERE StudyRelevantJob_id = ? AND Student_id = ?";

        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("ii", $studyRelevantJobId, $studentId);

        $success = $statement->execute();

        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Gets the current amount of applicants approved for a study relevant job.
    static function get_applicantAmount($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `student_applied_for_study_relevant_job` WHERE StudyRelevantJob_id = ? AND Approved = 1;";
        
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
        
		$applicantAmount = $result->num_rows;
        
        $statement->close();
        
        return $applicantAmount;
    }
	
	
	/* Approves a student for a study relevant job, updating the Approved field to true in student_applied_for_study_relevant_job. */
    static function approve($studyRelevantJobId, $studentId) {
        global $db;
        
        $studyRelevantJobId = $db->escape_string($studyRelevantJobId);
        $studentId = $db->escape_string($studentId);
        
        $query = "UPDATE `student_applied_for_study_relevant_job` SET Approved = 1 WHERE StudyRelevantJob_id = ? AND Student_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("ii", $studyRelevantJobId, $studentId);
        
        $success = $statement->execute();
        
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
    
    /* Marks a student for a study relevant job as having finished the job he or she was hired for. */
    static function finishedJob($studyRelevantJobId, $studentId) {
        global $db;
        
        $studyRelevantJobId = $db->escape_string($studyRelevantJobId);
        $studentId = $db->escape_string($studentId);
        
        $query = "UPDATE `student_applied_for_study_relevant_job` SET JobFinished = 1 WHERE StudyRelevantJob_id = ? AND Student_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("ii", $studyRelevantJobId, $studentId);
        
        $success = $statement->execute();
        
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
    
    // Adds a skill as offered on a study relevant job in the database.
    static function add_skillToStudyRelevantJob($studyRelevantJobId, $skillId) {
        global $db;
		
		$studyRelevantJobId = $db->escape_string($studyRelevantJobId);
        $skillId = $db->escape_string($skillId);
		
        $query = "INSERT INTO `skill_offered_on_study_relevant_job` (StudyRelevantJob_id, Skill_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE Skill_id = Skill_id;";
		
        $statement = $db->prepare($query);
		
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("ii", $studyRelevantJobId, $skillId);
		
        $success = $statement->execute();
		
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
    
	
	// Removes all skills offered on a study relevant job from the database.
    static function delete_skillsFromStudyRelevantJob($studyRelevantJobId) {
        global $db;
        
        $studyRelevantJobId = $db->escape_string($studyRelevantJobId);
		
		$query = "DELETE FROM `skill_offered_on_study_relevant_job` WHERE StudyRelevantJob_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $studyRelevantJobId);
        
        $success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Adds a language requirement to a study relevant job in the database.
    static function add_desiredLanguageToStudyRelevantJob($studyRelevantJobId, $languageId, $desiredLevel) {
        global $db;
		
		$studyRelevantJobId = $db->escape_string($studyRelevantJobId);
        $languageId = $db->escape_string($languageId);
        $desiredLevel = $db->escape_string($desiredLevel);
		
        $query = "INSERT INTO `study_relevant_job_desires_language` (StudyRelevantJob_id, Language_id, DesiredLevel) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE Language_id = Language_id;";
		
        $statement = $db->prepare($query);
		
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("iii", $studyRelevantJobId, $languageId, $desiredLevel);
		
        $success = $statement->execute();
		
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Adjust a language requirement to a study relevant job in the database.
    static function adjust_desiredLanguageToStudyRelevantJob($studyRelevantJobId, $languageId, $desiredLevel) {
        global $db;
        
		$studyRelevantJobId = $db->escape_string($studyRelevantJobId);
        $languageId = $db->escape_string($languageId);
        $desiredLevel = $db->escape_string($desiredLevel);
        
        $query = "UPDATE `study_relevant_job_desires_language` SET DesiredLevel = ? WHERE StudyRelevantJob_id = ? AND Language_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("iii", $desiredLevel, $studyRelevantJobId, $languageId);
        
        $success = $statement->execute();
        
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Removes a language requirement to a study relevant job in the database.
    static function delete_desiredLanguageFromStudyRelevantJob($studyRelevantJobId, $languageId) {
        global $db;
        
        $studyRelevantJobId = $db->escape_string($studyRelevantJobId);
        $languageId = $db->escape_string($languageId);
		
		$query = "DELETE FROM `study_relevant_job_desires_language` WHERE StudyRelevantJob_id = ? AND Language_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("ii", $studyRelevantJobId, $languageId);
        
        $success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
}

?>