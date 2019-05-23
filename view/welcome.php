<?php
session_start();
include_once('header.html');

$user = user::isLoggedIn();
if(!$user) {
    session_unset();
    session_destroy();
    header("Location: index.php?action=logIn");
}

?>

<body>
    <?php
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
	
	// Encrypt the link to the activation file.
	$encryptString = $_SESSION['userId'] . $firstname . $lastname;
	$encryptLink = hash('sha256', $encryptString);
	
	$encryptLink = substr($encryptLink, strlen($_SESSION['userId']));
	
    echo "<div class='col-20'><div class='col-15 lone-message'><h1><h1>Welcome " . $firstname . " " . $lastname . ",</h1><p>Your account was succesfully activated! To start working with SkillsBridger, go to our home page and log in with your e-mail address and your password.</p><br><a href=index.php><button>Home</button></a></div></div>";
    
    //Delete the created activation file
    unlink("./temp/$encryptLink$_SESSION[userId].php");
    
    //Remove all session variables
    session_unset();
    //Destroy the session
    session_destroy();
    
    ?>
    
</body>

<?php
include_once('footer.html');
?>