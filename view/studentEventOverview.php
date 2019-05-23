<?php
$eventId = filter_input (INPUT_POST, 'eventId');
if ($eventId == NULL) {
    $eventId = filter_input (INPUT_GET, 'eventId');
}

$organisationId = filter_input (INPUT_POST, 'organisationId');
if ($organisationId == NULL) {
    $organisationId = filter_input (INPUT_GET, 'organisationId');
}

$event = event::get_eventById($eventId);
$address = address::get_addressById($event->getAddressId());
$organisationId = $event->getOrganisationId();
$organisation = eventOrganisation::get_eventOrganisationById($organisationId);

$paidOnline = $event->getPaidOnline();
$alternateSubscription = $event->getAlternateSubscription();
$cv = $event->getCv();
$motivationLetter = $event->getMotivationLetter();

if ($paidOnline === 1 || $alternateSubscription === 1) {
	$externalLink = 1;
} else {
	$externalLink = 0;
}


/* check whether the form has been submitted using the POST method. */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subscribeSubmit'])) {
	
	$studentId = cleanInput($_POST['studentId']);
	$eventId = cleanInput($_POST['eventId']);
	$skillId = cleanInput($_POST['skillId']);
	$senderPage = cleanInput($_POST['senderPage']);
	
	event::add_studentToEvent($eventId, $studentId);
	header("Location: index.php?action=studentEventOverview&studentId=$studentId&eventId=$eventId&skillId=$skillId&senderPage=$senderPage");
}

/* check whether the form has been submitted using the POST method. */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['unsubscribeSubmit'])) {
	
	$studentId = cleanInput($_POST['studentId']);
	$eventId = cleanInput($_POST['eventId']);
	$skillId = cleanInput($_POST['skillId']);
	$senderPage = cleanInput($_POST['senderPage']);
	
	event::delete_studentFromEvent($eventId, $studentId);
	header("Location: index.php?action=studentEventOverview&studentId=$studentId&eventId=$eventId&skillId=$skillId&senderPage=$senderPage");
}

?>


<div class="col-20 studentEventOverview">
	<div class="col-20 eventOverviewRow">
		<p class="title"><?php echo $event->getName(); ?></p>
		<p class="title">By <?php echo $organisation->getName(); ?></p>
	</div>
	<div class="col-20 eventOverviewRow">
		<p><?php echo ucfirst($event->getPurpose()); ?> event - <?php echo $event->getType(); ?></p>
	</div>
	<div class="col-20 eventOverviewRow">
		<p>Deadline to subscribe :
			<?php
			$subDeadline = $event->getSubscriptionDeadline();
			echo date("D d F Y", strtotime($subDeadline)) . " at " . date("H:i", strtotime($subDeadline));
			?>
		</p>
		<p>Event start :
			<?php
			$start = $event->getStart();
			echo date("D d F Y", strtotime($start)) . " at " . date("H:i", strtotime($start));
			?>
		</p>
		<p>Event end :
			<?php
			$end = $event->getEndOfEvent();
			echo date("D d F Y", strtotime($end)) . " at " . date("H:i", strtotime($end));
			?>
		</p>
	</div>
	<?php $addressDescription = $event->getAddressDescription(); ?>
	<div class="col-20 eventOverviewRow">
		<div class="<?php if(isset($addressDescription) && $addressDescription != ""){echo 'col-10';} else {echo 'col-20';} ?>">
			<p>Address :</p>
			<p><?php if (isset($address)) {echo $address->getName();} else {echo "There is no address set for this event.";} ?></p>
			<p><?php if (isset($address)) {echo $address->getStreet() . ' ' . $address->getNumber();} ?></p>
			<p><?php if (isset($address)) {echo $address->getZip() . ' ' . $address->getCity();} ?></p>
			<p><?php if (isset($address)) {echo $address->getCountry();} ?></p>
		</div>
		<?php
		if (isset($addressDescription) && $addressDescription != "") {
			echo "<div class=col-10>";
			echo "<p>Additional directions:</p>";
			echo "<p>$addressDescription</p>";
			echo "</div>";
		}
		?>
	</div>
	<div class="col-20 eventOverviewRow">
		<p>Event description:</p>
		<p><?php echo $event->getDescription(); ?></p>
	</div>
	<div class="col-20 eventOverviewRow">
		<p>
			<?php
				$eventLanguage = $event->getLanguage();
				if ($eventLanguage == "Francais") {
					$eventLanguage = "Français";
				}
				
				$openForAll = $event->getOpenForAll();
				if($openForAll === 1) {
					echo 'This event will be held in ' . $eventLanguage . ', can accomodate ' . $event->getCapacity() . ' participants and is open to all students.';
				} else {
					echo 'This event will be held in ' . $eventLanguage . ', can accomodate ' . $event->getCapacity() . ' participants and is open to : ' . $event->getOpenFor();
				}
			?>
		</p>
	</div>
	<!--
	<div class="col-20 eventOverviewRow">
		<?php /*
		$motivationLetterEncouraged = $event->getMotivationLetterEncouraged();
		$cvEncouraged = $event->getCvEncouraged();
		if ($motivationLetterEncouraged === 1 || $motivationLetter === 1 || $cvEncouraged === 1 || $cv === 1) {
			echo "<p>Students are asked to send in the following documents:</p>";
			if ($motivationLetterEncouraged === 1 || $motivationLetter === 1) {
				echo "<p>A motivation letter</p>";
			} else {
				echo "<p>Their Curriculum Vitae</p>";
			}
		} else {
			echo "<p>Students are not requested, nor required to send in a motivation letter or their Curriculum Vitae.</p>";
		}
		 */?>
	</div>
	-->
	<div class="col-20 eventOverviewRow">
		<p>
			<?php
			$ticketPrice = $event->getTicketPrice();
			if(isset($ticketPrice)) {
				if($paidOnline === 1) {
					echo 'This event has a ticket price of ' . $ticketPrice . ' EUR, to be paid online!';
				} else {
					echo 'This event has a ticket price of ' . $ticketPrice . ' EUR, to be paid at the entrance!';
				}

			} else {
				echo 'This event is free!';
			}
			?>
		</p>
	</div>
	<?php
	$subscriptionUrl = $event->getSubscriptionUrl();
	if(isset($subscriptionUrl)) {
		echo "<div class='col-20 eventOverviewRow'>";
		echo "<p>Students are required to follow the additional subscription procedures on the following webpage:</p>";
		echo "<p class=url>";
		echo $subscriptionUrl;
		echo "</p>";
		echo "</div>";
	}
	$eventSkills = event::get_skillsOfferedOnEvent($eventId);
	if($eventSkills[0] != null) {
		echo "<div class='col-20 eventOverviewRow'>";
		echo "<p>Skills offered on the event:</p>";
		for ($x = 0; $x < count($eventSkills); $x++) {
			echo "<p>";
			echo $eventSkills[$x][1];
			echo "</p>";
		}
		echo "</div>";
	}
	$webpageUrl = $event->getWebpageUrl();
	if(isset($webpageUrl)) {
		echo "<div class='col-20 eventOverviewRow'>";
		echo "<p>Event webpage:</p>";
		echo "<p class=url>";
		echo $webpageUrl;
		echo "</p>";
		echo "</div>";
	}
	?>
</div>

<div>
	<a href="./index.php?action=<?php if (isset($senderPage)) {echo $senderPage;} else {echo "eventPerPreference";} if (isset($studentId)) {echo "&studentId=$studentId";}  if (isset($skillId)) {echo "&skillId=$skillId";} ?>"><button>Back</button></a>
	
	<?php
	$studentUpcomingEvents = student::get_allUpcomingStudentEvents($studentId);
	$cancelled = $event->getCancelled();
	if ($cancelled === 0 && $senderPage != 'beenToEvents') {
		if (!in_array($eventId, $studentUpcomingEvents)) {
			?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:inline; float:right;">
				<input type="hidden" name="studentId" value="<?php echo $studentId; ?>">
				<input type="hidden" name="eventId" value="<?php echo $eventId; ?>">
				<input type="hidden" name="skillId" value="<?php echo $skillId; ?>">
				<input type="hidden" name="senderPage" value="<?php echo $senderPage; ?>">
				<input type="hidden" name="action" value="<?php echo $action; ?>">
				<input id="subscribeButton" class="subscribe-button" <?php if ($externalLink === 1) {echo "style=display:none;";} ?> type="submit" name="subscribeSubmit" value="Subscribe for this event!">
				<?php if ($externalLink === 1) { ?>
					<a href="<?php echo $event->getSubscriptionUrl(); ?>" target="_blank" id="subscribeLink"></a>
					<button type="button" class="subscribe-button" onclick="alertExternal();">Subscribe for this event!</button>
				<?php } ?>
			</form>
			<?php
		} else {
			?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:inline; float:right;">
				<input type="hidden" name="studentId" value="<?php echo $studentId; ?>">
				<input type="hidden" name="eventId" value="<?php echo $eventId; ?>">
				<input type="hidden" name="skillId" value="<?php echo $skillId; ?>">
				<input type="hidden" name="senderPage" value="<?php echo $senderPage; ?>">
				<input type="hidden" name="action" value="<?php echo $action; ?>">
				<input id="unsubscribeButton" style="display:none;" type="submit" name="unsubscribeSubmit">
				<button type="button" class="unsubscribe-button" onclick="unsubscribeConfirm();">Unsubscribe for this event!</button>
			</form>
			<?php
		}
	}
	?>
</div>