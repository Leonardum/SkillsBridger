<?php
session_start();
include_once('header.html');

$user = user::isLoggedIn();
if (!$user || $user->getId() === NULL) {
    session_unset();
    session_destroy();
    header("Location: index.php?action=logIn");
}

$userFile = userFile::get_imageOfUploader('user', $user->getId());
$profilePictureUrl = $userFile->getUrl();
if (!$profilePictureUrl) {
	$profilePictureUrl = './images/userAccount.png';
	$profilePictureSet = false;
} else {
	$profilePictureSet = true;
}

?>

<body onload="loadNotifications(<?php echo "'" . $user->getId() . "'"; ?>); <?php if (isset($load)) {echo $load;} ?>">
	
	<div class="cookieWarning" style="display:none;">
		<p>Our website uses cookies in order to help serve you better!</p>
		<button class="cookieAcceptButton">Got it!</button>
	</div>
	
	<div id="left-sidebar" class="col-4 left-sidebar <?php if (isset($menu) && $menu == "studentMenu.php") {echo "student";} else if (isset($menu) && ($menu == "organisationMenu.php" || $menu == "emptyOrganiserMenu.php")) {echo "organisation";} else {echo "Select your role";} ?> <?php if (isset($animation)) {echo "animation";} ?>">
		<div class="logoBackground <?php if (isset($menu) && ($menu == "organisationMenu.php" || $menu == "emptyOrganiserMenu.php")) {echo "organisationBackground";} else if (isset($menu) && ($menu == "companyMenu.php" || $menu == "emptyCompanyMenu.php")) {echo "businessBackground";} else {echo "studentBackground";} ?>">
			<div class="sbLogoContainer">
				<img src="./images/web Logo.png" alt="SkillsBridger Logo" id="sbLogo" class="sbLogo">
			</div>
			<img src="./images/whiteMenuBars.png" onclick="tabletMenuAppear();" class="sideBarHider">
		</div>
		<div>
			<p class="userName"><?php echo $user->getFirstName() . " " . $user->getLastName(); ?></p>
		</div>
		<div class="profilePicture">
			<img src="<?php echo $profilePictureUrl ?>" alt="Profile pic" id="profilePicture" class="profilePicture" onmouseover="hide('message')" onmouseout="hide('message')">
			<button id="message" onclick="document.getElementById('userFile').click();" onmouseover="hide('message')" onmouseout="hide('message')" class="profilePicture" style="display:none;">Set my<br>professional picture</button>

			<!-- The data encoding type, enctype, MUST be specified as below -->
			<form enctype="multipart/form-data" action="./uploads/fileUploadHandling.php" method="post" id="ProPicForm">
				<!-- Name of input element determines name in $_FILES array -->
				<input type="file" id="userFile" name="userFile" hidden="true" accept=".jpg,.jpeg,.png;" onchange="checkProfilePictureSize();"/>
				<!--In case multiple files should be allowed to be uploaded set the following property: multiple="multiple". Furthermore, make sure that the name is an array: name="userFile[]". -->
				
				<input type="hidden" name="action" value="<?php echo $action; ?>">
				
				<input type="hidden" name="userId" value="<?php echo $userId; ?>">
				
				<input type="hidden" name="studentId" value="<?php echo $studentId; ?>">
				
				<input type="hidden" name="organisationId" value="<?php echo $organisationId; ?>">
				
				<input type="hidden" name="skillId" value="<?php echo $skillId; ?>">
				
				<input type="hidden" name="eventId" value="<?php echo $eventId; ?>">
				
				<input type="hidden" name="senderPage" value="<?php echo $senderPage; ?>">
			</form>
		</div>
		
		<?php if (isset($menu)) {include_once($menu);} ?>
	</div>
	
	<div class="col-16 middle-column">
		<div id="navigation" class="navigation">
			<div class="col-14 roleSelect" style="padding:0 5px;">
				<img src="./images/grayMenuBars.png" onclick="tabletMenuAppear();" class="menuBars">
				<span class="dropdown">
					<button class="roleSelector-button"><?php if ((isset($menu) && $menu == "studentMenu.php") || $action == 'studentCreation') {echo "Student";} else if (isset($menu) && ($menu == "organisationMenu.php" || $menu == "emptyOrganiserMenu.php") && (isset($organisationName))) {echo $organisationName;} else if (isset($menu) && ($menu == "organisationMenu.php" || $menu == "emptyOrganiserMenu.php") && (!isset($organisationName))) {echo "Event organiser";} else if (isset($menu) && ($menu == "companyMenu.php" || $menu == "emptyCompanyMenu.php") && (isset($companyName))) {echo $companyName;} else if (isset($menu) && ($menu == "companyMenu.php" || $menu == "emptyCompanyMenu.php") && (!isset($companyName))) {echo "Company";} else {echo "Select your role";} ?></button>
					<img src="./images/userRole.png" id="roleListIcon" class="roleSelectorIcon" onclick="hide('roleList')">
					<ul id="roleList" class="dropdown-content">
						<li title="If you are a Business & Economics student, you can use SkillsBridger to find educative events and initiatives!";>
							<a href="./index.php?action=studentCreation">Student</a>
						</li>
						<li title="If you are an organiser of educative events and initiatives, then you can use SkillsBridger to publish them for students!";>
							<a href="./index.php?action=eventOrganisationOverview&userId=<?php echo $user->getId(); ?>">Event organiser</a>
						</li>
						<li title="If you are a recruiter in your firm, you will be able to use SkillsBridger to find interesting student profiles!";>
							<a href="./index.php?action=companyOverview&userId=<?php echo $user->getId(); ?>">Company</a>
						</li>
					</ul>
				</span>
			</div>
			<div class="col-6 management-box">
				<span class="management-dropdown">
					<img src="./images/noNotification.png" alt="Notifications" id="notification" class="notification" onclick="hide('notifications')" title="Notifications">
					<ul id="notifications" class="notification-dropdown-content" style="display:none;"></ul>
					
					
					<img src="<?php if ($profilePictureSet) {echo $profilePictureUrl;} else {echo './images/userAccount.png';} ?>" alt="User account" id="setting" class="userAccount" <?php if ($profilePictureSet) {echo 'style=border-radius:50%;';} ?> onclick="hide('settings')" title="User account">
					<ul id="settings" class="setting-dropdown-content" style="display:none;">
						<li><a href="index.php?action=editAccount">Account settings</a></li>
						<?php
						if(user::isAdmin()){
							echo "<li><a href=./index.php?action=adminPanel>Admin Panel</a></li>";
						}
						?>
						<li class="divider"></li>
						<li><a href="./index.php?action=logOut">Log out</a></li>
					</ul>
				</span>
			</div>
		</div>
		
		<div id="content" class="col-20 content">
			<?php 
			if (isset($page)) {
				include_once($page);
			} else { ?>
				<!--
				<video src="./videos/Event Creation.mp4" type="video/mp4" poster="./videos/Welcome poster.png" onclick="playVideo(this)" controls>Please update your browser to watch this video.</video>
				-->
			<?php }
			?>
		</div>
	</div>
	
	
	<!--
	<div class="right-sidebar">
		<div class="adbox"><img src="./images/SB Logo Students.png"></div>
		<div class="adbox">NEWS</div>
		<div class="adbox">AD</div>
		<div class="adbox">AD</div>
	</div>
	-->
	
	<?php
		if (isset($auxlib) && $auxlib == true) {
			echo "<script type=text/javascript>";
			require_once('./js/auxlib.js');
			echo "</script>";
		}
		if (isset($script) && $script == true) {
			echo "<script type=text/javascript src=./js/$action.js?v0></script>";
		}
	?>
	<script type="text/javascript" src="./js/userPage.js?v1"></script>
	<script type="text/javascript" src="./js/fileUpload.js?v1"></script>
    
</body>

<?php
include_once('footer.html');
?>