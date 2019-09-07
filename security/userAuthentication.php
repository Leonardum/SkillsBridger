<?php

session_start();

// If no session variable exists, or unauthorized user_level, redirect the user:
if (isset($_SESSION['userId'])) {
/* If a valid user session is found then the user level is checked, if the user has level 3 access they will be granted access if not a access denied message be displayed and the user will be redirected. */
    if ($_SESSION['user_level'] != 3) {
        header("Refresh: 3; url=index.php");
        echo '<h3>Access deined - you do not have access to this page</h3>';
        echo 'You will be redirected in 3 seconds';
        include ('footer.html');
        exit(); // Quit the script.
    }
}

/* If no valid session is found then the user is not logged in and will receive a access denied message and will be redirected to the login page. */
else if (!isset($_SESSION['userId']) || (trim($_SESSION['userId']) == '')) {
    header("Refresh: 3; url=login.php");
    echo '<h3>Access deined - you do not have access to this page</h3>';
    echo '<p>You will be redirected in 3 seconds</p>';
    include ('footer.html');
    exit(); // Quit the script.
}


/* Throwing and catching exceptions:
$file_info = new SplFileInfo($_FILES['userFile']['tmp_name']);

echo $file_info->getType() . "<br>";

try {
    if ($_FILES['userfile']['size'] > 100000) {
        // unlink($_FILES['userFile']['tmp_name']);
        throw new RuntimeException('Exceeded filesize limit.');
    }
} catch (RuntimeException $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
} */


/* A query can be executed to update timestamps, for example last login timestamp: "update `User_activity_data` set LastLogin=now() WHERE User_id = '2'" */

?>