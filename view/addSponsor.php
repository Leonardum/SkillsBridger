<?php
$success = filter_input (INPUT_POST, 'success');
if ($success == NULL) {
    $success = filter_input (INPUT_GET, 'success');
}

$successNew = filter_input (INPUT_POST, 'successNew');
if ($successNew == NULL) {
    $successNew = filter_input (INPUT_GET, 'successNew');
}

$event = event::get_eventById($eventId);


// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
	
	(int) $newSponsorId = cleanInput($_POST['newSponsorId']);
	
	if (empty($newSponsorId)) {
		$newSponsorIdErr = "Please, select a sponsor from the search results.";
		$err = true;
	}
	
	/* Check if the submitted sponsor name is not already a sponsor for the event. */
	$eventSponsors = sponsor::get_sponsorOfEvent($eventId);
	for($x = 0; $x < count($eventSponsors); $x++) {
		if (!empty($newSponsorId) && $eventSponsors[$x] == $newSponsorId) {
			$sponsorAvailableErr = "Looks like this sponsor is already added to your event!";
			$err = true;
		}
	}
	
	if (isset($_POST["submit"]) && !$err) {
		event::add_sponsorToEvent($eventId, $newSponsorId);
		header("Location: index.php?action=addSponsor&eventId=$eventId&organisationId=$organisationId&senderPage=$senderPage&success=true");
	}
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submitNewSponsor"])) {
	
	$name = cleanInput($_POST['name']);
	$name = ucfirst ($name);
	
	if (empty($name)) {
		$nameErr = "Please, enter a name for the new sponsor.";
		$err = true;
	}
	
	/* Check if the submitted sponsor name is unique in the database. */
	$sponsorNames = sponsor::get_names();
	$arrLength = count($sponsorNames);
	for($x = 0; $x < $arrLength; $x++) {
		if (!empty($name) && $sponsorNames[$x] === $name) {
			$nameAvailableErr = "Whoops! Looks like this sponsor already exists!";
			$err = true;
		}
	}
	
	if (!isset($_FILES['sponsorLogo'])) {
		$fileErr = "Please, select a logo for the new sponsor.";
		$err = true;
	}
	
	if (!$err && isset($_POST["submitNewSponsor"])) {
		$sponsor = new sponsor (NULL, $name);
		$sponsorId = $sponsor->save();
		
		$uploadDir = './uploads/files/sponsorLogos/';
		$name = $sponsorId . " - " . basename($_FILES['sponsorLogo']['name']);
		$uploadPath = $uploadDir . $name;

		if ($_FILES['sponsorLogo']['size'] > 524288) {
			$sizeErr = "file is larger than 512kB";
			$err = true;
		}

		$allowed = array("image/jpg","image/jpeg","image/png");
		$fileType = $_FILES['sponsorLogo']['type'];
		if (!in_array($fileType, $allowed)) {
			$typeErr = "unsupported file type";
			$err = true;
		}

		$allowedExtension = array("jpg", "jpeg", "png");
		$fileExtension = pathinfo($uploadPath, PATHINFO_EXTENSION);
		if (!in_array($fileExtension, $allowedExtension)) {
			$typeErr = "unsupported file type";
			$err = true;
		}

		$check = getimagesize($_FILES["sponsorLogo"]["tmp_name"]);
		if($check !== false) {
			if (!in_array( $check["mime"], $allowed)) {
				$typeErr = "unsupported file type";
				$err = true;
			}
		} else {
			$typeErr = "unsupported file type";
			$err = true;
		}

		/* Conceal the filename in the upload url by hashing. */
		$uploadFile = hash('md5', $name);
		$uploadPath = $uploadDir . $uploadFile . "." . $fileExtension;

		if (!$err && move_uploaded_file($_FILES['sponsorLogo']['tmp_name'], $uploadPath)) {
			$sponsorLogo = userFile::get_imageOfUploader('sponsor', $sponsorId);
			$test = $sponsorLogo->getId();
			if (!empty($test)) {
				unlink($oldFile);
				$sponsorLogo->setName(basename($_FILES['sponsorLogo']['name']));
				$sponsorLogo->setUrl("./uploads/files/sponsorLogos/" . $uploadFile . "." . $fileExtension);
				$sponsorLogo->save();
			} else {
				$sponsorLogo = new userFile(NULL, basename($_FILES['sponsorLogo']['name']), 'image', "sponsor", $sponsorId, NULL, NULL, "./uploads/files/sponsorLogos/" . $uploadFile . "." . $fileExtension);
				$sponsorLogo->save();
			}

			event::add_sponsorToEvent($eventId, $sponsorId);

			header("Location: index.php?action=addSponsor&eventId=$eventId&organisationId=$organisationId&senderPage=$senderPage&successNew=true");
		} else {
			unlink($_FILES['sponsorLogo']['tmp_name']);
			echo "<p>Your file could not be moved to the server. Please try to upload your picture again.</p>";
			echo "<p>The following error occured: $sizeErr, $typeErr!<p>";
		}
	}
}



/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["remove"])) {
	
	(int) $sponsorId = cleanInput($_POST['sponsorId']);
	
	event::delete_sponsorFromEvent($eventId, $sponsorId);
	
	header("Location: index.php?action=addSponsor&eventId=$eventId&organisationId=$organisationId&senderPage=$senderPage");
}

?>
<div class="col-20" style="margin-bottom:5rem;">
	<div class="col-9" style="margin-right:5%;">
		<h1>Add a sponsor to <?php echo $event->getName(); ?>:</h1>
		<p><span class="error">* = required fields</span></p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			
			<div class="userInput" style="padding-top:2.2rem;">
				<input type="text" id="name" name="name" autocomplete="off" onkeyup="sponsorHint(event, this.value)" class="<?php if (isset($newUserIdErr)) {echo "invalid";} else if (isset($success)) {echo "valid";} ?>">
				<label>Select a suggested sponsor to add to your event:</label>
				<span class="error"> * <?php if (isset($newUserIdErr)) {echo $newUserIdErr;} else if (isset($sponsorAvailableErr)) {echo $sponsorAvailableErr;} ?></span>
				<span class="success"><?php if (isset($success)) {echo "The sponsor was successfully added to your event!";} ?></span>
				
				<div id="hints" class="hintBox" style="display:none;"></div>
			</div>
			
			<input type="hidden" id="newSponsorId" name="newSponsorId" value="<?php if (isset($newSponsorId)) {echo $newSponsorId;} ?>">
			
			<input type="hidden" name="eventId" value="<?php echo $eventId ?>">
			
			<input type="hidden" name="organisationId" value="<?php echo $organisationId ?>">
			
			<input type="hidden" name="senderPage" value="<?php echo $senderPage ?>">
			
			<input type="hidden" name="action" value="addSponsor">
			
			<input type="submit" name="submit" style="margin-left:2rem;" value="Add event sponsor!">
		</form>
	</div>
	
	<div class="col-10">
		<h1>Didn't find your sponsor? Add a new one:</h1>
		<p><span class="error">* = required fields</span></p>
		
		<!-- The data encoding type, enctype, MUST be specified as below -->
		<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="newSponsorForm">
			
			<div class="userInput" style="padding-top:2.2rem;">
				<input type="text" name="name" autocomplete="off" class="<?php if (isset($nameErr)) {echo "invalid";} else if (isset($name) || isset($successNew)) {echo "valid";} ?>" value="<?php if (isset($name)) {echo $name;} ?>">
				<label>New sponsor name:</label>
				<span class="error"> * <?php if (isset($nameErr)) {echo $nameErr;} else if (isset($nameAvailableErr)) {echo $nameAvailableErr;} else if (isset($fileErr)) {echo $fileErr;} ?></span>
				<span class="success"><?php if (isset($successNew)) {echo "The sponsor was successfully added to your event!";} ?></span>
			</div>
			
			<input type="file" id="sponsorLogo" name="sponsorLogo" hidden="true" accept=".jpg,.jpeg,.png;" onchange="checkSponsorLogoSize();"/>
			
			<input type="hidden" name="eventId" value="<?php echo $eventId ?>">
			
			<input type="hidden" name="organisationId" value="<?php echo $organisationId ?>">
			
			<input type="hidden" name="senderPage" value="<?php echo $senderPage ?>">
			
			<input type="hidden" name="action" value="addSponsor">
			
			<input type="submit" id="submitNewSponsor" name="submitNewSponsor" style="display:none;" value="Add new sponsor!">
			
			<button type="button" style="margin-left:2rem;" onclick="document.getElementById('sponsorLogo').click();">Add new sponsor!</button>
		</form>
	</div>
</div>

<div id="sponsorList" class="col-20" style="margin-bottom:5rem;">
	<h1 id="currentSponsors"></h1>
</div>

<div class="col-20">
	<a href="./index.php?action=eventManager&eventId=<?php echo $eventId ?>&organisationId=<?php echo $organisationId ?>&senderPage=<?php echo $senderPage ?>"><button>Back</button></a>
</div>