<?php
// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$description = cleanInput($_POST['description']);
	$capacity = (int) cleanInput($_POST['capacity']);
	if (isset($_POST['language'])) {
		$language = cleanInput($_POST['language']);
	}
	if (isset($_POST['freeForAll'])) {
		$freeForAll = 1;
	} else if (isset($_POST['notFreeForAll'])) {
		$freeForAll = 0;
	}
	$price = cleanInput($_POST['price']);
	// Make sure the comma denoted floats are transformed to dot denoted ones.
	$price = (float) str_replace(',', '.', $price);
	if (isset($_POST['paidOnline'])) {
		$paidOnline = 1;
	} else if (isset($_POST['entrancePaid'])) {
		$paidOnline = 0;
	}
	if (isset($_POST['alternateSubscription'])) {
		$alternateSubscription = 1;
	} else {
		$alternateSubscription = 0;
	}
	$subscriptionUrl = cleanInput($_POST['subscriptionUrl']);
	if (isset($_POST['notOpenForAll'])) {
		$openForAll = 0;
	} else {
		$openForAll = 1;
	}
	$openFor = cleanInput($_POST['openFor']);
	if (isset($_POST['motivationLetterEncouraged'])) {
		$motivationLetterEncouraged = 1;
	} else {
		$motivationLetterEncouraged = 0;
	}
	if (isset($_POST['motivationLetter'])) {
		$motivationLetter = 1;
	} else {
		$motivationLetter = 0;
	}
	// Makes sure motivation letter is not both encouraged and required.
	if (isset($_POST['motivationLetterEncouraged']) && isset($_POST['motivationLetter'])) {
		$motivationLetterEncouraged = 0;
		$motivationLetter = 1;
	}
	if (isset($_POST['cvEncouraged'])) {
		$cvEncouraged = 1;
	} else {
		$cvEncouraged = 0;
	}
	if (isset($_POST['cv'])) {
		$cv = 1;
	} else {
		$cv = 0;
	}
	// Makes sure cv is not both encouraged and required.
	if (isset($_POST['cvEncouraged']) && isset($_POST['cv'])) {
		$cvEncouraged = 0;
		$cv = 1;
	}
	$webpage = cleanInput($_POST['webpage']);
	
	
	if (empty($description)) {
		$description = NULL;
		$descriptionErr = "Please, describe what your event is about and who it is for.";
		$err = true;
	}
	// Check if the description is not longer than 270 characters.
	if (strlen($description) > 270) {
		$descriptionErr = "This event description exceeds the maximum of 270 characters! Kindly shorten it.";
		$err = true;
	}
	if (empty($capacity)) {
		$capacity = NULL;
		$capacityErr = "Please, fill in the event's capacity.";
		$err = true;
	}
	if (empty($language)) {
		$languageErr = "Please, select a language for your event.";
		$err = true;
	}
	if (!isset($freeForAll)) {
		unset($price);
		$paidOnline = ""; // Avoid unknown variable error for later logic
		$freeForAllErr = "Please choose if your event will be free or payable.";
		$err = true;
	} else {
		if ($freeForAll) {
			$price = NULL;
			$paidOnline = 0; /* Avoid unknown variable error for later logic */
		} else {
			if (empty($price)) {
				$price = NULL;
				$priceErr = "Please, write down the price for your event.";
				$err = true;
			}
			if (!isset($paidOnline)) {
				$paidOnline = NULL; /* Avoid unknown variable error for later logic */
				$paidOnlineErr = "Please choose if your event will be paid for at the entrance or online.";
				$err = true;
			}
		}
	}
	if ($alternateSubscription || $paidOnline) {
		if (empty($subscriptionUrl)) {
			$subscriptionUrlErr = "Please, write the url of the webpage handling the subscription and/or payment process.";
			$err = true;
		}
	} else {
		$subscriptionUrl = NULL;
	}
	if (isset($openForAll)) {
		if (!$openForAll) {
			if (empty($openFor)) {
				$openFor = NULL;
				$openForErr = "Please, briefly state the target audience of your event.";
				$err = true;
			}
			// Check if the openFor description is not longer than 180 characters.
			if (strlen($openFor) > 180) {
				$openForErr = "This event description exceeds the maximum of 180 characters! Kindly shorten it.";
				$err = true;
			}
		} else {
			$openFor = NULL;
		}
	}
	if (empty($webpage)) {
		$webpage = NULL;
	}
}

if (isset($_POST["submit"]) && !$err) {
	
	$event = unserialize($_SESSION['event']);
	
	$event->setDescription($description);
	$event->setCapacity($capacity);
	$event->setLanguage($language);
	$event->setTicketPrice($price);
	$event->setPaidOnline($paidOnline);
	$event->setOpenForAll($openForAll);
	$event->setOpenFor($openFor);
	$event->setCvEncouraged($cvEncouraged);
	$event->setCv($cv);
	$event->setMotivationLetterEncouraged($motivationLetterEncouraged);
	$event->setMotivationLetter($motivationLetter);
	$event->setAlternateSubscription($alternateSubscription);
	$event->setSubscriptionUrl($subscriptionUrl);
	$event->setWebpageUrl($webpage);
	
	$_SESSION['event'] = serialize($event);
	
	header("Location: index.php?action=eventCreation3&organisationId=$organisationId");
}

?>


<h1>Please provide all required information for your new event.</h1><br>

<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<textarea id="description" name="description" rows="10" cols="50" maxlength="270" class="<?php if (isset($descriptionErr)) {echo "invalid";} else if (isset($description)) {echo "valid";} ?>" onkeyup="countdown('description', 270, 'charsLeft')"><?php if (isset($description)) {echo $description;} ?></textarea>
		<label>Give a brief description of your event (max 270 chars):</label>
		<span class="error"> * <?php if (isset($descriptionErr)) {echo $descriptionErr;}?></span>
		<br>
		<span id="charsLeft" class="charCountDown">Characters left: 270</span>
	</div>
	
	
	<div class="userInput">
		<input type="text" name="capacity" placeholder="e.g.: 65" value="<?php if (isset($capacity)) {echo $capacity;} ?>" class="<?php if (isset($capacityErr)) {echo "invalid";} else if (isset($capacity)) {echo "valid";} ?>">
		<label>What is the capacity of your event (how many people can maximum take part)?</label>
		<span class="error"> * <?php if (isset($capacityErr)) {echo $capacityErr;} ?></span>
	</div>
	
	
	<div class="userInput">
		<select name="language" class="<?php if (isset($languageErr)) {echo "invalid";} ?>">
			<option selected disabled hidden value=""></option>
			<option value="english">English</option>
			<option value="francais">Français</option>
			<option value="nederlands">Nederlands</option>
		</select>
		<label> In which language will your event be presented?</label>
		<span class="error"> * <?php if (isset($languageErr)) {echo $languageErr;} ?></span>
	</div>
	
	<br>
	<div class="userInput">
		<input id="freeEntrance" type="checkbox" name="freeForAll" value="true" onchange="uncheckYes(this.checked)" <?php if(isset($freeForAll) && $freeForAll == 1) {echo "checked";} ?>><span class="checkboxtext">No</span>
		<input id="paidEntrance" type="checkbox" name="notFreeForAll" value="true" onchange="uncheckNo(this.checked)" style="margin-left:20px;" <?php if(isset($freeForAll) && $freeForAll == 0) {echo "checked";} ?>><span class="checkboxtext">Yes</span>
		<label>Does your event have an entrance fee?</label>
		<span class="error"> * <?php if (isset($freeForAllErr)) {echo $freeForAllErr;} ?></span>
	</div>
	
	
	<div id="price" class="userInput" style="<?php if(isset($freeForAll) && $freeForAll == 0) {echo "display:block;";} else {echo "display:none;";} ?>">
		<input type="text" name="price" value="<?php if (isset($price)) {echo $price;} ?>" style="width:60px;"  class="<?php if (isset($priceErr)) {echo "invalid";} else if (isset($price)) {echo "valid";} ?>"><span class="checkboxtext">EUR</span>
		<label>What does it cost to participate in your event?</label>
		<span class="error"> * <?php if (isset($priceErr)) {echo $priceErr;} ?></span>
	</div>
	
	
	<div id="paymentMethod" class="userInput" style="<?php if(isset($freeForAll) && $freeForAll == 0) {echo "display:block;";} else {echo "display:none;";} ?>">
		<input id="entrancePaid" type="checkbox" name="entrancePaid" value="true" onchange="uncheckOnline(this.checked)" <?php if(isset($paidOnline) && $paidOnline === 0) {echo "checked";} ?>><span class="checkboxtext">At the entrance</span>
		<input id="onlinePaid" type="checkbox" name="paidOnline" value="true" onchange="uncheckEntrance(this.checked)" <?php if(isset($paidOnline) && $paidOnline == 1) {echo "checked";} ?>><span class="checkboxtext">Online through your own or a third party webpage</span>
		<label>How shall your event attendees pay?</label>
		<span class="error"> * <?php if (isset($paidOnlineErr)) {echo $paidOnlineErr;} ?></span>
	</div>
	
	
	<div class="userInput">
		<input id="alternateSubscription" type="checkbox" name="alternateSubscription" value="true" onchange="setSubscriptionPage(this.checked)" <?php if(isset($alternateSubscription)) { if($alternateSubscription) {echo "checked";}} ?>><span class="checkboxtext">Subscribers have to finalize their subscription through another link, such as "EventBrite" or your own webpage.</span><br>
	</div>
	
		
	<div id="subscriptionPage" class="userInput" style="<?php if ((isset($alternateSubscription) && ($alternateSubscription == 1)) || (isset($paidOnline) && ($paidOnline == 1))) {echo "display:block;";} else {echo "display:none;";} ?>">
		<input type="url" name="subscriptionUrl" placeholder="http://www.example.com/event" value="<?php if (isset($subscriptionUrl)) {echo $subscriptionUrl;} ?>" class="<?php if (isset($subscriptionUrlErr)) {echo "invalid";} else if (isset($subscriptionUrl)) {echo "valid";} ?>">
		<label>Alternate subscription page:</label>
		<span class="error"> * <?php if (isset($subscriptionUrlErr)) {echo $subscriptionUrlErr;} ?></span>
	</div>
	
	
	<div class="userInput">
		<input type="checkbox" name="notOpenForAll" value="true" onchange="setOpenFor(this.checked)" <?php if(isset($openForAll)) { if(!$openForAll) {echo "checked";}} ?>><span class="checkboxtext">Describe who is welcome to your event and/or the level of proficiency needed for this event.</span>
	</div>
	
	
	<div id="openFor" class="userInput" style="<?php if(isset($openForAll)) { if(!$openForAll) {echo "display:block;";} else {echo "display:none;";}} else {echo "display:none;";} ?>">
		<textarea name="openFor" rows="5" cols="50" maxlength="180" class="<?php if (isset($openForErr)) {echo "invalid";} else if (isset($openFor)) {echo "valid";} ?>"><?php if (isset($openFor)) {echo $openFor;} ?></textarea>
		<label>Who is welcome at your event (max 180 chars)?</label>
		<span class="error"> * <?php if (isset($openForErr)) {echo $openForErr;} ?></span>
	</div>
	
	<!--
	<div class="userInput">
		<input id="motivationLetterEncouraged" type="checkbox" name="motivationLetterEncouraged" value="true" onchange="setMotivationLetterEncouraged(this.checked)" <?php if(isset($motivationLetterEncouraged) && $motivationLetterEncouraged == 1) {echo "checked";} ?>><span class="checkboxtext">Subscribers ARE ENCOURAGED TO send in a motivation letter through SkillsBridger.</span><br>
		<input id="motivationLetter" type="checkbox" name="motivationLetter" value="true" onchange="setMotivationLetter(this.checked)" <?php if(isset($motivationLetter) && $motivationLetter == 1) {echo "checked";} ?>><span class="checkboxtext">Subscribers HAVE TO send in a motivation letter through SkillsBridger to be eligible for this event.</span>
	</div>
	
	
	<div class="userInput">
		<input id="cvEncouraged" type="checkbox" name="cvEncouraged" value="true" onchange="setCvEncouraged(this.checked)" <?php if(isset($cvEncouraged) && $cvEncouraged == 1) {echo "checked";} ?>><span class="checkboxtext">Subscribers ARE ENCOURAGED TO send in their CV through SkillsBridger.</span><br>
		<input id="cv" type="checkbox" name="cv" value="true" onchange="setCv(this.checked)" <?php if(isset($cv) && $cv == 1) {echo "checked";} ?>><span class="checkboxtext">Subscribers HAVE TO send in their CV through SkillsBridger to be eligible for this event.</span>
	</div>
	-->
	
	<div class="userInput">
		<input type="url" name="webpage" placeholder="http://www.example.com/event" value="<?php if (isset($webpage)) {echo $webpage;} ?>">
		<label>Do you have (another) informative webpage for this event? In that case, feel free to give us the url:</label>
	</div>
	
	<input type="hidden" name="organisationId" value="<?php echo $organisationId ?>">
	
	<input type="hidden" name="action" value="eventCreation2">
	
	<input type="submit" name="submit" value="Next">
</form>