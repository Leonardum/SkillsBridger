<?php

require('../database.php');
require('../event_object.php');

$skillsMapLoad = filter_input (INPUT_POST, 'skillsMapLoad');
if ($skillsMapLoad == NULL) {
    $skillsMapLoad = filter_input (INPUT_GET, 'skillsMapLoad');
}

$regionsLoad = filter_input (INPUT_POST, 'regionsLoad');
if ($regionsLoad == NULL) {
    $regionsLoad = filter_input (INPUT_GET, 'regionsLoad');
}


if (isset($skillsMapLoad)) {
	require('../careerGoal_object.php');
	
	$careerGoalArray = careerGoal::get_careerGoalArray();
	
	/* The $careerGoalArray will be a 3-dimensional array (all three indexed) of the following shape:
	[
		["Entrepreneurship",1,
			["Finance and Accounting",6],
			["Formalities and Legal",2],
			["Marketing",5],
			["Product and Development",4],
			["Strategy, Modeling and Planning",3],
			["Tech Skills",7]
		],
		["Finance and Accounting",14,
			["Financial Modeling, Analysis and Management",17],
			["Industry Knowledge",15],
			["Key Calculations, Concepts and Principles",18],
			["Products, Services and Activities",16],
			["Tech Skills",19]
		],
		["Marketing",8,
			["Digital and Tech Skills",10],
			["Product, Brand and Development",13],
			["Promotion and Marketing Communication",11],
			["Research and Demand",12],
			["Strategy",9]
		]
	] */
	
	$skillsMap = array();
	
	/* For every (parent) career goal ID, look up the skills required for all their child career goals and put them in the $skills array. */
	for($x = 0; $x<count($careerGoalArray); $x++) {
		/* For every array within the $careerGoalArray, extract the parent-career-goal name and -id. */
		$parentName = $careerGoalArray[$x][0];
		$parentId = $careerGoalArray[$x][1];
		$careerGoalSkill = array("parentId"=>$parentId, "skills"=>array());
		
		for($y = 2; $y < count($careerGoalArray[$x]); $y++) {
			$childCareerGoalId = $careerGoalArray[$x][$y][1];
			$careerGoalSkills = careerGoal::get_skillOfCareerGoal($childCareerGoalId);
			
			for($z = 0; $z < count($careerGoalSkills); $z++) {
				if (!in_array($careerGoalSkills[$z][0], $careerGoalSkill['skills'])) {
					array_push($careerGoalSkill['skills'],$careerGoalSkills[$z][0]);
				}
			}
			
			sort($careerGoalSkill['skills']);
		}
		
		array_push($skillsMap, $careerGoalSkill);
	}
	
	echo json_encode($skillsMap);
	
	
	/* The $skillsMap array will be a 3-dimensional array (indexed, associative, indexed) of the following shape:
	[
		{
			"parentId":1,
			"skills": [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,63,64,65,113,115,119,121,126,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,156]
		},
		{
			"parentId":14,
			"skills":[28,44,45,51,56,57,58,59,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,130,131,132,133,134,135,136,137,138,140,146,147,148,154,155,156]
		},
		{
			"parentId":8,
			"skills":[8,9,11,19,21,22,23,24,25,26,27,28,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,54,55,57,58,60,61,62,63,64,65,113,114,115,116,117,118,119,120,121,122,125,126,127,128,129,130,131,132,133,134,135,136,137,138,140,144,145,146,147,148,151,152,153,156]
		}
	] */
	
} else if (isset($regionsLoad)) {
	require('../address_object.php');
	
	$upcomingEvents = event::get_upcomingNonFullEvents();
	
	$regions = array();
	for($x = 0; $x < count($upcomingEvents); $x++) {
		$skillsOffered = event::get_skillsOfferedOnEvent($upcomingEvents[$x]['Event_id']);
		if ($skillsOffered) {
			$eventAddress = address::get_addressById($upcomingEvents[$x]['Address_id']);
			$region = $eventAddress->getProvince();
			if (!in_array($region, $regions)) {
				array_push($regions, $region);
			}
		}
	}
	
	sort($regions);
	
    echo json_encode($regions);
	
} else {
	$upcomingEvents = event::get_upcomingNonFullEvents();
	$events = array();
	for($x = 0; $x < count($upcomingEvents); $x++) {
		/* MAKE SURE ONLY EVENTS ARE SHOWN WHICH OFFER SKILLS (AND THUS MICRODEGREES)! */
		$skillsOffered = event::get_skillsOfferedOnEvent($upcomingEvents[$x]['Event_id']);
		if ($skillsOffered) {
			if (!in_array($upcomingEvents[$x], $events)) {
				array_push($events, $upcomingEvents[$x]);
			}
		}
	}
	sort($events);
	
    echo json_encode($events);
	
}

?>