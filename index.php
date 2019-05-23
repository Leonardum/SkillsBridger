<?php

ob_start(); // Prevent HTTP header from sending too soon.

/* the define function allows to declare constants, which are are automatically global and can be used across the entire script. */
define('project', '/SkillsBridger/');
define('documentRoot', $_SERVER['DOCUMENT_ROOT'].project);
define('home', documentRoot.'view/home.php');

/* The control file loads some methods from these pages in order to pass the necessary parameters to the views, therefor they must be included. */
require('./model/database.php');
require('./model/functions.php');
require('./model/user_object.php');
require('./model/file_object.php');

/* The controller file uses the action parameter to see what page should be displayed next. Depending on the value of the action parameter, different things can happen. Therefore this parameter is first filtered, in case it was sent in by another script. If it wasn't sent in (and the value of $action = NULL), then a default value is given. In this case, the default value is 'home'. */
$action = filter_input (INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input (INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'home';
    }
}

$userId = filter_input (INPUT_POST, 'userId');
if ($userId == NULL) {
	$userId = filter_input (INPUT_GET, 'userId');
}
$studentId = filter_input (INPUT_POST, 'studentId');
if ($studentId == NULL) {
	$studentId = filter_input (INPUT_GET, 'studentId');
}
$organisationId = filter_input (INPUT_POST, 'organisationId');
if ($organisationId == NULL) {
	$organisationId = filter_input (INPUT_GET, 'organisationId');
}
$companyId = filter_input (INPUT_POST, 'companyId');
if ($companyId == NULL) {
	$companyId = filter_input (INPUT_GET, 'companyId');
}
$skillId = filter_input (INPUT_POST, 'skillId');
if ($skillId == NULL) {
	$skillId = filter_input (INPUT_GET, 'skillId');
}
$eventId = filter_input (INPUT_POST, 'eventId');
if ($eventId == NULL) {
    $eventId = filter_input (INPUT_GET, 'eventId');
}
$senderPage = filter_input (INPUT_POST, 'senderPage');
if ($senderPage == NULL) {
    $senderPage = filter_input (INPUT_GET, 'senderPage');
}


if ($action == 'home') {
    include('./view/home.php');
} else if ($action == 'about') {
    include('./view/about.php');
} else if ($action == 'contact') {
    include('./view/contact.php');
} else if ($action == 'contactSuccessful') {
    include('./view/contactSuccessful.php');
} else if ($action == 'terms') {
    include('./view/terms.php');
} else if ($action == 'credits') {
    include('./view/credits.php');
} else if ($action == 'createAccount') {
    include('./view/accountCreation.php');
} else if ($action == 'accountCreated') {
    include('./view/accountCreated.php');
} else if ($action == 'resendActivation') {
    include('./view/resendActivation.php');
} else if ($action == 'activationMailLost') {
    include('./view/activationMailLost.php');
} else if ($action == 'welcome') {
    include('./view/welcome.php');
} else if ($action == 'logIn') {
    require('./model/student_object.php');
    include('./view/logIn.php');
} else if ($action == 'forgotPassword') {
    include('./view/forgotPassword.php');
} else if ($action == 'newPassActive') {
    include('./view/newPassActive.php');
} else if ($action == 'userPage') {
    include('./view/userPage.php');
} else if ($action == 'editAccount') {
	$load = "loadStudyAndUniversity();";
	$page = './view/editAccount.php';
	$auxlib = false;
	$script = true;
	require('./model/student_object.php');
    include('./view/userPage.php');
}  else if ($action == 'studentCreation') {
	$animation = true;
	$load = "loadStudyAndUniversity();";
	$page = './view/studentCreation.php';
	$auxlib = false;
	$script = true;
	require('./model/student_object.php');
    include('./view/userPage.php');
} else if ($action == 'student') {
	header("Location: index.php?action=learningEvents&senderPage=student");
} else if ($action == 'profile') {
	$menu = "studentMenu.php";
	$load = "loadMicrodegrees();";
	$page = './view/profile.php';
	$auxlib = true;
	$script = true;
	require('./model/university_object.php');
	require('./model/study_object.php');
    include('./view/userPage.php');
} else if ($action == 'eventPerSkill') {
	$menu = "studentMenu.php";
	$load = "loadEvents('" . $skillId . "', '" . $studentId . "');";
	$page = './view/eventPerSkill.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'learningEvents') {
	if ($senderPage == 'student') {
		$animation = true;
	}
	$menu = "studentMenu.php";
	$load = "loadCareerGoals();";
	$page = './view/learningEvents.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'careerEvents') {
	$menu = "studentMenu.php";
	$load = "loadEventTypes();";
	$page = './view/careerEvents.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'experienceOpportunities') {
	$menu = "studentMenu.php";
	$load = "loadJobTypes();";
	$page = './view/experienceOpportunities.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'eventPerLocation') { //PAGE NOT IN USE ATM
    require('./model/event_object.php');
    include('./view/eventPerLocation.php');
} else if ($action == 'pendingEvents') {
	$menu = "studentMenu.php";
	$load = "loadEvents('" . $studentId . "');";
	$page = './view/pendingEvents.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'subscribedEvents') {
	$menu = "studentMenu.php";
	$load = "loadEvents('" . $studentId . "');";
	$page = './view/subscribedEvents.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'beenToEvents') {
	$menu = "studentMenu.php";
	$load = "loadEvents('" . $studentId . "');";
	$page = './view/beenToEvents.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'studentEventOverview') {
	$menu = "studentMenu.php";
	$page = './view/studentEventOverview.php';
	$auxlib = true;
	$script = true;
	require('./model/eventOrganisation_object.php');
    require('./model/event_object.php');
	require('./model/address_object.php');
    include('./view/userPage.php');
} else if ($action == 'organisationCreation') {
	$menu = "emptyOrganiserMenu.php";
	$page = './view/organisationCreation.php';
	$auxlib = false;
	$script = false;
    include('./view/userPage.php');
} else if ($action == 'eventOrganisationOverview') {
	$animation = true;
	$menu = "emptyOrganiserMenu.php";
	$load = "loadEventOrganisations('" . $userId . "');";
	$page = './view/eventOrganisationOverview.php';
	$auxlib = false;
	$script = true;
	require('./model/eventOrganisation_object.php');
    include('./view/userPage.php');
} else if ($action == 'eventOrganisation') {
	$menu = "organisationMenu.php";
	$load = "loadMembers('" . $organisationId . "', '" . $userId . "');";
	$page = './view/eventOrganisation.php';
	$auxlib = true;
	$script = true;
    include('./view/userPage.php');
} else if ($action == 'upcomingEvents') {
	$menu = "organisationMenu.php";
	$load = "loadOrganisationEvents('" . $organisationId . "');";
	$page = './view/upcomingEvents.php';
	$auxlib = false;
	$script = true;
    include('./view/userPage.php');
} else if ($action == 'passedEvents') {
	$menu = "organisationMenu.php";
	$load = "loadOrganisationEvents('" . $organisationId . "');";
	$page = './view/passedEvents.php';
	$auxlib = false;
	$script = true;
    include('./view/userPage.php');
} else if ($action == 'eventCreation1') {
	$menu = "organisationMenu.php";
	$page = './view/eventCreation1.php';
	$auxlib = false;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'eventCreation2') {
	$menu = "organisationMenu.php";
	$page = './view/eventCreation2.php';
	$auxlib = false;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'eventCreation3') {
	$menu = "organisationMenu.php";
	$page = './view/eventCreation3.php';
	$auxlib = false;
	$script = false;
    require('./model/event_object.php');
    require('./model/address_object.php');
    include('./view/userPage.php');
} else if ($action == 'eventCreation4') {
	$menu = "organisationMenu.php";
	$load = "loadSkills();";
	$page = './view/eventCreation4.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'eventManager') {
	$menu = "organisationMenu.php";
	$page = './view/eventManager.php';
	$auxlib = false;
	$script = true;
    require('./model/event_object.php');
	require('./model/address_object.php');
    include('./view/userPage.php');
} else if ($action == 'eventEditor') {
	$menu = "organisationMenu.php";
	$load = "loadSkills();";
	$page = './view/eventEditor.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
	require('./model/address_object.php');
	require('./model/skill_object.php');
	require('./model/notification_object.php');
    include('./view/userPage.php');
} else if ($action == 'addSponsor') {
	$menu = "organisationMenu.php";
	$load = "loadSponsors('" . $eventId . "');";
	$page = './view/addSponsor.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
	require('./model/sponsor_object.php');
    include('./view/userPage.php');
} else if ($action == 'attendeeList') {
	$menu = "organisationMenu.php";
	$load = "loadAttendeeList('" . $eventId . "');";
	$page = './view/attendeeList.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    include('./view/userPage.php');
} else if ($action == 'candidateList') {
	$menu = "organisationMenu.php";
	$load = "loadCandidateList('" . $eventId . "');";
	$page = './view/candidateList.php';
	$auxlib = true;
	$script = true;
    require('./model/event_object.php');
    require('./model/notification_object.php');
    include('./view/userPage.php');
} else if ($action == 'companyCreation') {
	$menu = "emptyCompanyMenu.php";
	$page = './view/companyCreation.php';
	$auxlib = false;
	$script = false;
    include('./view/userPage.php');
} else if ($action == 'companyOverview') {
	$animation = true;
	$menu = "emptyCompanyMenu.php";
	$load = "loadCompanies('" . $userId . "');";
	$page = './view/companyOverview.php';
	$auxlib = false;
	$script = true;
	require('./model/company_object.php');
    include('./view/userPage.php');
} else if ($action == 'company') {
	$menu = "companyMenu.php";
	$load = "loadMembers('" . $companyId . "', '" . $userId . "');";
	$page = './view/company.php';
	$auxlib = true;
	$script = true;
    include('./view/userPage.php');
} else if ($action == 'vacantJobs') {
	$menu = "companyMenu.php";
	$page = './view/vacantJobs.php';
	$auxlib = false;
	$script = false;
    include('./view/userPage.php');
} else if ($action == 'passedJobs') {
	$menu = "companyMenu.php";
	$page = './view/passedJobs.php';
	$auxlib = false;
	$script = false;
    include('./view/userPage.php');
} else if ($action == 'publishJob') {
	$menu = "companyMenu.php";
	$page = './view/publishJob.php';
	$auxlib = false;
	$script = false;
    include('./view/userPage.php');
} else if ($action == 'studyRelevantJob1') {
	$menu = "companyMenu.php";
	$page = './view/studyRelevantJob1.php';
	$auxlib = false;
	$script = false;
	require('./model/study_relevant_job_object.php');
    include('./view/userPage.php');
} else if ($action == 'studyRelevantJob2') {
	$menu = "companyMenu.php";
	$load = "loadStudies();";
	$page = './view/studyRelevantJob2.php';
	$auxlib = false;
	$script = true;
	require('./model/study_relevant_job_object.php');
    include('./view/userPage.php');
} else if ($action == 'studyRelevantJob3') {
	$menu = "companyMenu.php";
	$page = './view/studyRelevantJob3.php';
	$auxlib = false;
	$script = true;
	require('./model/study_relevant_job_object.php');
    include('./view/userPage.php');
} else if ($action == 'adminPanel') {
    include('./view/adminPanel.php');
} else if ($action == 'skillsAdmin') {
    require('./model/skill_object.php');
    include('./view/skillsAdmin.php');
} else if ($action == 'skillAdded') {
    include('./view/skillAdded.php');
} else if ($action == 'careerGoalsAdmin') {
    require('./model/careerGoal_object.php');
    include('./view/careerGoalsAdmin.php');
} else if ($action == 'careerGoalAdded') {
	require('./model/careerGoal_object.php');
	require('./model/skill_object.php');
    include('./view/careerGoalAdded.php');
} else if ($action == 'universityAdmin') {
	require('./model/university_object.php');
    include('./view/universityAdmin.php');
} else if ($action == 'organisationAdmin') {
	require('./model/eventOrganisation_object.php');
    include('./view/organisationAdmin.php');
} else if ($action == 'companyAdmin') {
	require('./model/company_object.php');
    include('./view/companyAdmin.php');
} else if ($action == 'logOut') {
    include('./view/logOut.php');
}

ob_end_flush();

?>