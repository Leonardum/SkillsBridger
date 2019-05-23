<?php
require('./model/eventOrganisation_object.php');

$check = eventOrganisation::check_userPartOfOrganisation($user->getId(), $organisationId);

if(!$check && !(user::isAdmin())) {
	header("Location: index.php?action=logIn");
}

$organisation = eventOrganisation::get_eventOrganisationById($organisationId);
$organisationName = $organisation->getName();

?>

<ul>
	<li><a href="./index.php?action=eventCreation1&organisationId=<?php echo $organisationId; ?>"><button class="side-button waves-effect <?php if ($action == "eventCreation1" || $action == "eventCreation2" || $action == "eventCreation3" || $action == "eventCreation4") {echo "active";} ?>">Create a new event</button></a></li>
	<li><a href="./index.php?action=upcomingEvents&organisationId=<?php echo $organisationId; ?>"><button class="side-button waves-effect <?php if ($action == "upcomingEvents" || $senderPage == "upcomingEvents") {echo "active";} ?>">Upcoming events</button></a></li>
	<li><a href="./index.php?action=passedEvents&organisationId=<?php echo $organisationId; ?>"><button class="side-button waves-effect <?php if ($action == "passedEvents" || $senderPage == "passedEvents") {echo "active";} ?>">Passed events</button></a></li>
	<li><a href="./index.php?action=eventOrganisation&organisationId=<?php echo $organisationId; ?>&userId=<?php echo $user->getId(); ?>"><button class="side-button waves-effect <?php if ($action == "eventOrganisation") {echo "active";} ?>">Manage your organization</button></a></li>
</ul>