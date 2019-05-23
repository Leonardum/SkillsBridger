<?php
// define variables and set to empty values.
$err = "";

/* check whether the form has been submitted using the POST method. */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$location = cleanInput($_POST['location']);
	$street = cleanInput($_POST['street']);
	(int) $number = cleanInput($_POST['number']);
	(int) $zip = cleanInput($_POST['zip']);
	$city = cleanInput($_POST['city']);
	if (isset($_POST['province'])) {
		$province = cleanInput($_POST['province']);
	}
	if (isset($_POST['state'])) {
	$state = cleanInput($_POST['state']);
	}
	if (isset($_POST['country'])) {
	$country = cleanInput($_POST['country']);
	}
	$addressDescription = cleanInput($_POST['addressDescription']);
	
	if (empty($street)) {
		$streetErr = "Please, fill in the street name.";
		$err = true;
	}
	if (empty($number)) {
		$numberErr = "Please, fill in the street number.";
		$err = true;
	}
	if (empty($zip)) {
		$zipErr = "Please, fill in the zip code.";
		$err = true;
	}
	if (empty($city)) {
		$cityErr = "Please, fill in the city name.";
		$err = true;
	}
	if (empty($province)) {
		$provinceErr = "Please, select a province.";
		$err = true;
	}
	if (empty($state)) {
		$state = NULL;
	}
	if (empty($country)) {
		$country = 'Belgium';
	}
	if (empty($addressDescription)) {
		$_SESSION['description'] = NULL;
	}
}

if (isset($_POST["submit"]) && !$err) {
	
	$address = new address(NULL, $location, $street, $number, $zip, $city, $province, $state, $country);
	$existingAddresses = $address->compare_address();
	if ($existingAddresses[0] == 1) {
		$addressId = $existingAddresses[1];
	} else {
		$addressId = $address->save();
	}
	
	$event = unserialize($_SESSION['event']);
	$event->setAddressId($addressId);
	$event->setAddressDescription($addressDescription);
	$_SESSION['event'] = serialize($event);
	
	header("Location: index.php?action=eventCreation4&organisationId=$organisationId");
}

?>


<h1>Where will this event take place?</h1><br>

<p><span class="error">* = required fields</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
	<div class="userInput">
		<input type="text" name="location" value="<?php if (isset($location)) {echo $location;} ?>">
		<label>Location / building name:</label>
	</div>
	
	
	<div class="userInput">
		<input type="text" name="street" value="<?php if (isset($street)) {echo $street;} ?>" class="<?php if (isset($streetErr)) {echo "invalid";} else if (isset($street)) {echo "valid";} ?>">
		<label>Street:</label>
		<span class="error"> * <?php if (isset($streetErr)) {echo $streetErr;} ?></span>
	</div>
	
	
	<div class="userInput">
		<input type="text" name="number" value="<?php if (isset($number)) {echo $number;} ?>" class="<?php if (isset($numberErr)) {echo "invalid";} else if (isset($number)) {echo "valid";} ?>">
		<label>Number:</label>
		<span class="error"> * <?php if (isset($numberErr)) {echo $numberErr;} ?></span>
	</div>
	
	
	<div class="userInput">
		<input type="text" name="zip" value="<?php if (isset($zip)) {echo $zip;} ?>" class="<?php if (isset($zipErr)) {echo "invalid";} else if (isset($zip)) {echo "valid";} ?>">
		<label>Zip code:</label>
		<span class="error"> * <?php if (isset($zipErr)) {echo $zipErr;} ?></span>
	</div>
	
	
	<div class="userInput">
		<input type="text" name="city" value="<?php if (isset($city)) {echo $city;} ?>" class="<?php if (isset($cityErr)) {echo "invalid";} else if (isset($city)) {echo "valid";} ?>">
		<label>City:</label>
		<span class="error"> * <?php if (isset($cityErr)) {echo $cityErr;} ?></span>
	</div>
	
	
	<div class="userInput">
		<select name="province" class="<?php if (isset($provinceErr)) {echo "invalid";} ?>">
			<option selected disabled hidden value=""></option>
			<option value="Antwerpen">Antwerpen</option>
			<option value="Brabant wallon">Brabant wallon</option>
			<option value="Brussels">Brussels</option>
			<option value="Hainaut">Hainaut</option>
			<option value="Liège">Liège</option>
			<option value="Limburg">Limburg</option>
			<option value="Luxembourg">Luxembourg</option>
			<option value="Namur">Namur</option>
			<option value="Oost-Vlaanderen">Oost-Vlaanderen</option>
			<option value="Vlaams-Brabant">Vlaams-Brabant</option>
			<option value="West-Vlaanderen">West-Vlaanderen</option>
		</select>
		<label>Province or region:</label>
		<span class="error"> * <?php if (isset($provinceErr)) {echo $provinceErr;} ?></span>
	</div>
	
	
	<div class="userInput">
		<textarea name="addressDescription" rows="10" cols="50" maxlength="100"><?php if (isset($addressDescription)) {echo $addressDescription;} ?></textarea>
		<label>Give a brief description of how to get to or recognize this location (max 100 chars):</label>
	</div>
	
	
	<input type="hidden" name="organisationId" value="<?php echo $organisationId ?>">
	
	<input type="hidden" name="action" value="eventCreation3">
	
	<input type="submit" name="submit" value="Next">
</form>