/* Namespacing: technique used to create global-like variable without 'polluting' the global object of your code in order to avoid ambiguity and minimize the risk of naming collisions. Often the namespace (as is the case for AUXLIB) is wrapped in a self-invoking function. */
var AUXLIB = AUXLIB || (function() {
	/* The || logic is there to make sure that other instances of AUXLIB remain valid. */
	var auxvars = [];
	
	return { /* Returning an object has the advantage that several possible outputs can be called with once function. */
		init : function(input) {
			var a;
			var arrayLength = input.length;
			for (a = 0; a < arrayLength; a++) {
				// Make sure to only include the variable needed for the script.
				if (input[a] != null) {
					// Clean variables to avoid cross-scripting attacks.
					input[a] = unescape(input[a].toString());
					input[a] = input[a].replace(/</g, '&lt;');
					input[a] = input[a].replace(/>/g, '&gt;');
					auxvars.push(input[a]);
				} else {
					auxvars.push(undefined);
				}
			}
		},
		all : function() {
			return auxvars;
		},
		currentPage : function() {
			return auxvars[0];
		},
		thisPage : function() {
			return auxvars[1];
		},
		// The original value of checkList (php value) was not a string, but an array. However, the php function json_encode() transforms the value to a javascript string. Therefore, to get an array again, the "json_encoded" value has to be split to an array once more.
		checkList : function() {
			if (typeof auxvars[2] !== 'undefined') {
				var checkList = auxvars[2].split(",");
				return checkList;
			}
		},
		passedCareerGoals : function() {
			return auxvars[3];
		},
		studentId : function() {
			return auxvars[4];
		},
		studentGoingToEvents : function() {
			return JSON.parse(auxvars[5]);
		},
		studentAppliedForEvents : function() {
			return JSON.parse(auxvars[6]);
		},
		noSelection : function() {
			return auxvars[7];
		},
		passedRegions : function() {
			if (typeof auxvars[8] !== 'undefined') {
				var passedRegions = auxvars[8].split(",");
				return passedRegions;
			}
		},
		passedCareerEventTypes : function() {
			return auxvars[9];
		},
		organisationName : function() {
			return auxvars[10];
		},
		organisationId : function() {
			return auxvars[11];
		},
		senderPage : function() {
			return auxvars[12];
		},
		recordedSkills : function() {
			if (typeof auxvars[13] !== 'undefined') {
				// split the skills string into an array based upon the commas which are not followed by a white space.
				var skills = auxvars[13].split(/,(?!\s)/);
				var i;
				var recordedSkills = [];
				for (i = 0; i < skills.length; i = i+4) {
					var skill = skills.slice(i, i+4);
					recordedSkills.push(skill);
				}
				return recordedSkills;
			}
		},
		selectedEventType : function() {
			return auxvars[14];
		},
		eventType : function() {
			return auxvars[15];
		},
		eventPurpose : function() {
			return auxvars[16];
		},
		skillId : function() {
			return auxvars[17];
		},
		passedJobTypes : function() {
			return auxvars[18];
		}
	};
})();

AUXLIB.init([
	<?php
	if (isset ($action) && $action != null) {
		echo  "'" . $action . "'";
	} else {
		echo ", null"; //to make sure the indexes of auxlib are always correct
	}
	
	echo ", '" . htmlspecialchars($_SERVER['PHP_SELF']) . "'";
	
	
	/* For learningEvents.php, careerEvents.php and eventPerSkill.php */
	
	if (isset ($checkList) && $checkList != null) {
		echo ", " . json_encode($checkList);
	} else {
		echo ", null";
	}
	
	if (isset ($passedCareerGoals) && $passedCareerGoals != null) {
		echo ", " . json_encode($passedCareerGoals);
	} else {
		echo ", null";
	}
	
	if (isset ($studentId) && $studentId != null) {
		echo ", " . json_encode($studentId);
	} else {
		echo ", null";
	}
	
	if (isset ($studentGoingToEvents) && $studentGoingToEvents != null) {
		echo ", " . json_encode($studentGoingToEvents);
	} else {
		echo ", null";
	}
	
	if (isset ($studentAppliedForEvents) && $studentAppliedForEvents != null) {
		echo ", " . json_encode($studentAppliedForEvents);
	} else {
		echo ", null";
	}
	
	if (isset ($noSelection) && $noSelection != null) {
		echo ", " . json_encode($noSelection);
	} else {
		echo ", null";
	}
	
	if (isset($passedRegions) && $passedRegions != null) {
		echo ", " . json_encode($passedRegions);
	} else {
		echo ", null";
	}
	
	
	/* For careerEvents.php */
	
	if (isset($passedCareerEventTypes) && $passedCareerEventTypes != null) {
		echo ", " . json_encode($passedCareerEventTypes);
	} else {
		echo ", null";
	}
	
	
	/* For eventOrganisationOverview.php */
	
	if (isset($organisationName) && $organisationName != null) {
		echo ", " . json_encode($organisationName);
	} else {
		echo ", null";
	}
	
	
	/* For attendeeList.php and candidateList.php and eventOrganisation.php */
	
	if (isset($organisationId) && $organisationId != null) {
		echo ", " . json_encode($organisationId);
	} else {
		echo ", null";
	}
	
	if (isset($senderPage) && $senderPage != null) {
		echo ", " . json_encode($senderPage);
	} else {
		echo ", null";
	}
	
	
	/* For eventEditor.php */
	
	if (isset($skillsInfo) && $skillsInfo != null) {
		echo ", " . json_encode($skillsInfo);
	} else {
		echo ", null";
	}
	
	if (isset($isType) && $isType != null) {
		echo ", " . json_encode($isType);
	} else {
		echo ", null";
	}
	
	
	/* For eventCreation4.php and eventEditor.php */
	
	if (isset($eventType) && $eventType != null) {
		echo ", " . json_encode($eventType);
	} else {
		echo ", null";
	}
	
	if (isset($eventPurpose) && $eventPurpose != null) {
		echo ", " . json_encode($eventPurpose);
	} else {
		echo ", null";
	}
	
	
	/* For eventPerSkill.php */
	
	if (isset ($skillId) && $skillId != null) {
		echo ", " . json_encode($skillId);
	} else {
		echo ", null";
	}
	
	
	/* For experienceOpportunities.php */
	
	if (isset ($passedJobTypes) && $passedJobTypes != null) {
		echo ", " . json_encode($passedJobTypes);
	} else {
		echo ", null";
	}
	
	
	?>
]);