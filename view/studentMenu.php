<?php
require('./model/student_object.php');

$student = student::get_studentByUser($_SESSION['userId']);
$studentId = $student->getId();
$studentApplications = student::get_upcomingAppliedEvents($studentId);
$studentApplications = count($studentApplications);
$studentSubscriptions = student::get_upcomingSubscribedEvents($studentId);
$studentSubscriptions = count($studentSubscriptions);

?>

<ul>
	<li><a href="./index.php?action=learningEvents"><button class="side-button waves-effect <?php if ($action == "learningEvents") {echo "active";} ?>">Learning Events</button></a></li>
	<li><a href="./index.php?action=careerEvents"><button class="side-button waves-effect <?php if ($action == "careerEvents") {echo "active";} ?>">Career Events</button></a></li>
	<li><a href="./index.php?action=experienceOpportunities"><button class="side-button waves-effect <?php if ($action == "experienceOpportunities") {echo "active";} ?>">Experience Opportunities</button></a></li>
	<li><a href="./index.php?action=profile"><button class="side-button waves-effect <?php if ($action == "profile" || $action == "eventPerSkill") {echo "active";} ?>">Track my learning</button></a></li>
	<li class="menuDivider"></li>
	<li><a href="./index.php?action=pendingEvents&studentId=<?php echo $studentId ?>"><button class="side-button waves-effect <?php if ($action == "pendingEvents") {echo "active";} ?>">Pending subscriptions (<?php echo $studentApplications; ?>)</button></a></li>
	<li><a href="./index.php?action=subscribedEvents&studentId=<?php echo $studentId ?>"><button class="side-button waves-effect <?php if ($action == "subscribedEvents") {echo "active";} ?>">Subscriptions (<?php echo $studentSubscriptions; ?>)</button></a></li>
	<li><a href="./index.php?action=beenToEvents&studentId=<?php echo $studentId ?>"><button class="side-button waves-effect <?php if ($action == "beenToEvents") {echo "active";} ?>">Passed events</button></a></li>
</ul>