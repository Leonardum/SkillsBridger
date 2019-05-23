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
        
    <?php
    echo "<h1>The following skill was successfully added to the database: $_SESSION[skillName]!</h1>";
    ?>
    
    <a href="./index.php?action=skillsAdmin"><button>Add another skill</button></a>

</body>

<?php

unset($_SESSION['skillName']);

include_once('footer.html');
?>