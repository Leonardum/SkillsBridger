<?php
session_start();
include_once('header.html');

$user = user::isLoggedIn();
if(!$user) {
    session_unset();
    session_destroy();
    header("Location: index.php?action=logIn");
}

if(!(user::isAdmin())){
    header("location: ./index.php?action=userPage");
}

?>

<body>
	
	<a href="./index.php?action=skillsAdmin"><button>Manage the skills</button></a>
    <a href="./index.php?action=careerGoalsAdmin"><button>Manage the career goals</button></a>
    <a href="./index.php?action=universityAdmin"><button>Manage the universities</button></a>
    <a href="./index.php?action=organisationAdmin"><button>Manage the event organisers</button></a>
	<a href="./index.php?action=companyAdmin"><button>Manage the companies</button></a>
	<a href="./index.php?action=userPage"><button>Back</button></a>
	
</body>

<?php
include_once('footer.html');
?>