<?php
require('./model/company_object.php');

$check = company::check_userPartOfCompany($user->getId(), $companyId);

if(!$check && !(user::isAdmin())) {
	header("Location: index.php?action=logIn");
}

$company = company::get_companyById($companyId);
$companyName = $company->getName();

?>

<ul>
	<li><a href="./index.php?action=publishJob&companyId=<?php echo $companyId; ?>"><button class="side-button waves-effect <?php if ($action == "publishJob" || $action == "publishJob2" || $action == "publishJob3" || $action == "publishJob4") {echo "active";} ?>">Publish a job</button></a></li>
	<li><a href="./index.php?action=vacantJobs&companyId=<?php echo $companyId; ?>"><button class="side-button waves-effect <?php if ($action == "vacantJobs") {echo "active";} ?>">Vacant jobs</button></a></li>
	<li><a href="./index.php?action=passedJobs&companyId=<?php echo $companyId; ?>"><button class="side-button waves-effect <?php if ($action == "passedEvents" || $senderPage == "passedJobs") {echo "active";} ?>">Passed job posts</button></a></li>
	<li><a href="./index.php?action=company&companyId=<?php echo $companyId; ?>&userId=<?php echo $user->getId(); ?>"><button class="side-button waves-effect <?php if ($action == "company") {echo "active";} ?>">Company details</button></a></li>
</ul>