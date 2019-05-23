<?php

require('../database.php');
require('../eventOrganisation_object.php');

$organisationId = filter_input (INPUT_POST, 'organisationId');
if ($organisationId == NULL) {
    $organisationId = filter_input (INPUT_GET, 'organisationId');
}

$events = eventOrganisation::get_passedEvents($organisationId);

echo json_encode($events);

?>