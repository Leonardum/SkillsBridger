<?php

require('../database.php');

$level = filter_input (INPUT_POST, 'level');
if ($level == NULL) {
    $level = filter_input (INPUT_GET, 'level');
}

$level = 1;

$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
$root_element = "careergoals";
$xml .= "<$root_element>";

global $db;

$level = $db->escape_string($level);

$query = "SELECT CareerGoal FROM `careergoal` WHERE CareerGoalLevel = '$level'";

$result = $db->query($query);

if ($result == FALSE) {
    display_db_error($db->error);
}

$parents = array();

while ($row = $result->fetch_assoc()) {
    $xml .= "<careergoal>";

    //loop through each key,value pair in row
    foreach($row as $key => $value) {
        //$key holds the table column name
        $xml .= "<$key>";

        //embed the SQL data in a CDATA element to avoid XML entity issues
        $xml .= "<![CDATA[$value]]>"; //outputs the CDATA in the final document D=

        //and close the element
        $xml .= "</$key>";
    }

    $xml.="</careergoal>";
}

//close the root element
$xml .= "</$root_element>";

//send the xml header to the browser
header ("Content-Type:text/xml");

//output the XML data
echo $xml;

// below the JS code to access this file (not successfully tested).
/* var xmlhttp, xmlDoc, x, i;
xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        /* Create an option element per array element and put it in the select element.
        xmlDoc = xmlhttp.responseXML;
        x = xmlDoc.getElementsByTagName("CareerGoal");
        for (i = 0; i < x.length; i++) {
            var option = document.createElement('option');
            option.value = x[i].childNodes[0].nodeValue;
            option.text = x[i].childNodes[0].nodeValue;
            selectList.appendChild(option);
        }
    }
}
xmlhttp.open("GET", "./model/careerGoalXmlFetch.php?level=" + value, true);
xmlhttp.send(); */
?>